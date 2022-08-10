<?php

namespace App\Http\Controllers;

use App\Http\Traits\AutoFetch;
use App\Jobs\GroupMessagingJob;
use App\Models\Admin;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\AppInfo;
use App\Models\BanksHiring;
use App\Models\EducationField;
use App\Models\GCM;
use App\Models\GovernmentAgency;
use App\Models\JobField;
use App\Models\JobOffer;
use App\Models\JobOfferSubmitRequest;
use App\Models\Option;
use App\Models\Report;
use App\Models\Ticket;
use App\Models\TicketAnswer;
use App\Models\TicketCategory;
use App\Models\User;
use App\Models\UserAutomaticSubscription;
use App\Services\FCMService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use function App\Helpers\getJTimeStamp;
use function App\Helpers\sendPhoto;
use function App\Helpers\SendTelegramMessageWithCustomUserId;
use function App\Helpers\setOption;

class AdminController extends Controller
{

    use AutoFetch;

    ######### Authenticate #########
    public function login(Request $request)
    {
        if ($request->session()->has('Admin')) {
            return redirect('/admin/dashboard');
        }
        if (Cookie::get('Admin') != null) {
            return redirect('/admin/dashboard');
        }
        return view('admin.login');
    }

    public function doLogin(Request $request)
    {
        if (!isset($request->user_name) || !isset($request->password)) {
            return back()->with('msg', trans('messages.no_user_found'));
        }

        $Check = Admin::where('user_name', $request->user_name)->first();
        if (!$Check)
            return back()->with('msg', trans('messages.no_user_found'));
        if (decrypt($Check->password) != $request->password)
            return back()->with('msg', trans('messages.no_user_found'));

        if (isset($request->remember)) {
            Cookie::queue('Admin', encrypt($request->user_name), 1000000);
        }

        global $Admin;
        $Admin = $Check;
        $request->session()->put('Admin', $Check);

        return redirect('/admin/dashboard')->with('msg', trans('messages.login_successfully'));


    }

    public function logout(Request $request)
    {
        $request->session()->forget('Admin');
        Cookie::queue('Admin', '', -1);
        return redirect()->route('login');

    }

    ######### Authenticate #########

    ######### Dashboard #########
    public function dashboard()
    {
        $allUsers = User::count();
        $todayUsers = User::whereDate('created_at', Carbon::today())->count();
        $oneWeekUsers = User::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $thirtyDaysUsers = User::whereDate('created_at', '>', Carbon::today()->addDays(-30))->count();

        $todayJobOffers = JobOffer::whereDate('created_at', Carbon::today())->count();
        $totalJobOffers = JobOffer::count();
        $bankJobOffers = BanksHiring::count();
        $governmentalJobOffers = GovernmentAgency::count();

        return view('admin.dashboard',
            compact('allUsers', 'todayJobOffers',
                'totalJobOffers', 'bankJobOffers', 'governmentalJobOffers', 'todayUsers', 'oneWeekUsers', 'thirtyDaysUsers'));
    }
    ######### Dashboard #########

    ######### Managers #########
    public function listManagers()
    {
        $list = Admin:: orderBy('id', 'Desc')->paginate(15);
        return view('admin.manager.list', ['list' => $list]);
    }

    public function addManager()
    {
        return view('admin.manager.new');
    }

    public function storeManager(Request $request)
    {
        $request->request->add(['password' => encrypt($request->password)]);

        Admin::create($request->all());
        return redirect('/admin/manager/list')->with('msg', trans('messages.added_successfully'));

    }

    public function edit($id)
    {
        $edit = Admin::find($id);
        if ($edit) {
            return view('admin.manager.new', ['edit' => $edit]);

        }
        return redirect('/admin/manager/list');
    }

    public function updateManager($id, Request $request)
    {
        $request->request->add(['password' => encrypt($request->password)]);

        Admin::find($id)->update($request->all());
        return redirect('/admin/manager/list')->with('msg', trans('messages.update_successfully'));
    }

    public function deleteManager($id)
    {
        if (Admin::count() == 1) {
            return back()->with('msg', trans('messages.managers.one_limit_delete'));
        }
        $admin = Admin::find($id);
        if ($admin) {
            $admin->delete();
            return back()->with('msg', trans('messages.delete_successfully'));
        }
        return back();
    }

    ######### Managers #########


    ######### Users #########

    public function listUsers()
    {
        $list = User::with('AutomaticSelection')->where('step', '<>', '');
        ### Filters ####
        if (!isset($_GET['order']) || $_GET['order'] == 'new') {
            $list->orderBy('id', 'DESC');
        } else {
            $list->orderBy('id');
        }
        if (isset($_GET['name']) && $_GET['name'] != '') {
            $list->where('name', 'LIKE', '%' . $_GET['name'] . '%');
        }
        if (isset($_GET['user_name']) && $_GET['user_name'] != '') {
            $list->where('user_name', 'LIKE', '%' . $_GET['user_name'] . '%');
        }
        if (isset($_GET['mode']) && $_GET['mode'] != '') {
            $list->where('status', $_GET['mode']);
        }

        return view('admin.user.list', ['list' => $list->paginate(15)]);

    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return back()->with('msg', trans('messages.delete_successfully'));
        }
        return back();
    }


    public function refreshUserStatus($id)
    {
        $user = User::find($id);
        if ($user) {
            if ($user->status == "active") {
                $user->status = "block";
            } else {
                $user->status = "active";
            }
            $user->save();
            return back()->with('msg', trans('messages.status_successfully'));
        }
        return back();
    }


    public function sendDirectMessage($id)
    {
        return view('admin.direct.new', ['id' => $id]);
    }


    public function doSendDirectMessage($id, Request $request)
    {
        if ($request->message == null) {
            return back()->with('msg', trans('messages.specify_message'));
        } else {
            $user = User::find($id);
            SendTelegramMessageWithCustomUserId($request->message, $user);
        }
        return back()->with('msg', trans('messages.message_sent'));
    }


    public function showUserSubscriptions($id)
    {
        $user = User::with('AutomaticSelection')->find($id);
        if ($user) {
            return view('admin.user.subscriptions', compact('user'));
        }
        return redirect()->route('user.index')->with('msg', trans('messages.no_user_found'));
    }


    ######### Users #########


    ######### Job Offers #########
    public function listJobOffers()
    {
        $list = JobOffer::where('id', '<>', 0);
        ### Filters ####
        if (!isset($_GET['order']) || $_GET['order'] == 'new') {
            $list->orderBy('id', 'DESC');
        } else {
            $list->orderBy('id');
        }
        if (isset($_GET['name']) && $_GET['name'] != '') {
            $list->where('title', 'LIKE', '%' . $_GET['name'] . '%');
        }
        if (isset($_GET['user_name']) && $_GET['user_name'] != '') {
            $list->where('state', 'LIKE', '%' . $_GET['user_name'] . '%');
        }

        return view('admin.joboffer.list', ['list' => $list->paginate(15)]);
    }

    public function updateJobOffers()
    {
        $updates = $this->fetchRecruitmentAnnouncement();
        return redirect()->route('job_offer.list')->with('msg', $updates . ' ' . trans('messages.number_item_inserted'));
    }

    public function removeJobOffer($id)
    {
        JobOffer::find($id)->delete();
        return redirect()->route('job_offer.list')->with('msg', trans('messages.delete_successfully'));
    }

    public function listBanksJobOffers()
    {
        $list = BanksHiring::where('id', '<>', 0);
        ### Filters ####
        if (!isset($_GET['order']) || $_GET['order'] == 'new') {
            $list->orderBy('id', 'DESC');
        } else {
            $list->orderBy('id');
        }
        if (isset($_GET['name']) && $_GET['name'] != '') {
            $list->where('title', 'LIKE', '%' . $_GET['name'] . '%');
        }

        return view('admin.joboffer.bank', ['list' => $list->paginate(15)]);
    }

    public function updateBanksJobOffers()
    {
        $updates = $this->getAllBanksHiring();
        return redirect()->route('bank_job_offer.list')->with('msg', $updates . ' ' . trans('messages.number_item_inserted'));
    }

    public function listGovernmentJobOffers()
    {
        $list = GovernmentAgency::where('id', '<>', 0);
        ### Filters ####
        if (!isset($_GET['order']) || $_GET['order'] == 'new') {
            $list->orderBy('id', 'DESC');
        } else {
            $list->orderBy('id');
        }
        if (isset($_GET['name']) && $_GET['name'] != '') {
            $list->where('title', 'LIKE', '%' . $_GET['name'] . '%');
        }

        return view('admin.joboffer.government', ['list' => $list->paginate(15)]);
    }

    public function updateGovernmental()
    {
        $updates = $this->governmentHiring();
        return redirect()->route('governmental_job_offer.list')->with('msg', $updates . ' ' . trans('messages.number_item_inserted'));
    }
    ######### Job Offers #########

    ######### Education Field #########
    public function listEducationFields()
    {
        $list = EducationField::where('id', '<>', 0);
        ### Filters ####
        if (!isset($_GET['order']) || $_GET['order'] == 'new') {
            $list->orderBy('id', 'DESC');
        } else {
            $list->orderBy('id');
        }
        if (isset($_GET['name']) && $_GET['name'] != '') {
            $list->where('title', 'LIKE', '%' . $_GET['name'] . '%');
        }

        if (isset($_GET['cat_id']) && $_GET['cat_id'] != '') {
            $list->where('cat_id', 'LIKE', '%' . $_GET['name'] . '%');
        }

        return view('admin.field.education', ['list' => $list->paginate(15)]);
    }

    public function updateEducation()
    {
        $updates = $this->FetchEducationField();
        return redirect()->route('education.list')->with('msg', $updates . ' ' . trans('messages.number_item_inserted'));
    }
    ######### Education Field #########

    ######### Job Title Field #########
    public function listJobTitleFields()
    {
        $list = JobField::where('id', '<>', 0);
        ### Filters ####
        if (!isset($_GET['order']) || $_GET['order'] == 'new') {
            $list->orderBy('id', 'DESC');
        } else {
            $list->orderBy('id');
        }
        if (isset($_GET['name']) && $_GET['name'] != '') {
            $list->where('title', 'LIKE', '%' . $_GET['name'] . '%');
        }

        if (isset($_GET['cat_id']) && $_GET['cat_id'] != '') {
            $list->where('cat_id', 'LIKE', '%' . $_GET['name'] . '%');
        }

        return view('admin.field.job_title', ['list' => $list->paginate(15)]);
    }

    public function updateJobTitle()
    {
        $updates = $this->FetchWorkField();
        return redirect()->route('job_title.list')->with('msg', $updates . ' ' . trans('messages.number_item_inserted'));
    }
    ######### Job Title Field #########

    ######### Setting #########
    public function storeBotSetting(Request $request)
    {
        foreach ($request->all() as $key => $val) {

            setOption($key, $val);
        }
        return redirect()->route('setting.bot');
    }

    public function loadBotSetting()
    {
        return view('admin.setting.bot');
    }

    ######### Setting #########

    ######### Messaging #########
    public function sendGroupMessage()
    {
        return view('admin.messaging.new');
    }

    public function doSendMessage(Request $request)
    {

        if ($request->picture != null) {
            $imageName = time() . '.' . $request->picture->extension();
            $request->picture->move(public_path('messaging'), $imageName);
            $users = User::all();
            $delay = 1;
            foreach ($users as $user) {
                GroupMessagingJob::dispatch($imageName, $user, $request->name, "image")->delay(Carbon::now()->addSeconds($delay += 2));
            }
            return redirect()->route('messaging.all')->with('msg', trans('messages.message_sent'));
        } else {
            $users = User::all();
            $delay = 1;
            foreach ($users as $user) {
                GroupMessagingJob::dispatch('', $user, $request->name, "text")->delay(Carbon::now()->addSeconds($delay += 2));
            }
            return redirect()->route('messaging.all')->with('msg', trans('messages.message_sent'));

        }
    }
    ######### Messaging #########

    ######### Employee Request #########
    public function listEmployeeRequest()
    {
        $list = JobOfferSubmitRequest::where('id', '<>', 0);
        ### Filters ####
        if (!isset($_GET['order']) || $_GET['order'] == 'new') {
            $list->orderBy('id', 'DESC');
        } else {
            $list->orderBy('id');
        }
        if (isset($_GET['title']) && $_GET['title'] != '') {
            $list->where('title', 'LIKE', '%' . $_GET['title'] . '%');
        }
        if (isset($_GET['status']) && $_GET['status'] != '') {
            $list->where('status', 'LIKE', '%' . $_GET['status'] . '%');
        }

        return view('admin.employee.list', ['list' => $list->paginate(15)]);
    }

    public function viewRequest($id)
    {
        $single = JobOfferSubmitRequest::find($id);
        if ($single) {
            return view('admin.employee.info', ['item' => $single]);

        }
    }

    public function downloadAttachment($id)
    {
        $single = JobOfferSubmitRequest::find($id);
        if ($single) {
            if ($single->file_name == null) {
                return redirect()->back();
            }
            $file_path = public_path('uploads/ask/' . $single->file_name);
            return response()->download($file_path);

        }
        return redirect()->back();

    }

    public function acceptRequest($id)
    {
        $request = JobOfferSubmitRequest::find($id);
        if ($request) {
            $request->status = 'accepted';
            $request->save();
        }
        return redirect()->back();
    }

    public function rejectRequest($id)
    {
        $request = JobOfferSubmitRequest::find($id);
        if ($request) {
            $request->status = 'rejected';
            $request->save();
        }
        return redirect()->back();
    }

    public function reviewRequest($id)
    {
        $request = JobOfferSubmitRequest::find($id);
        if ($request) {
            $request->status = 'reviewed';
            $request->save();
        }
        return redirect()->back();
    }
    ######### Employee Request #########

    ######### Support #########
    public function listAllTickets()
    {
        $list = Ticket::with('category')->where('id', '<>', 0);
        ### Filters ####
        if (!isset($_GET['order']) || $_GET['order'] == 'new') {
            $list->orderBy('id', 'DESC');
        } else {
            $list->orderBy('id');
        }
        if (isset($_GET['subject']) && $_GET['subject'] != '') {
            $list->where('subject', 'LIKE', '%' . $_GET['subject'] . '%');
        }


        return view('admin.ticket.list', ['list' => $list->paginate(15)]);
    }

    public function replyTicket($id)
    {
        $ticket = Ticket::find($id);
        $ticket->is_read = 0;
        $ticket->save();
        $replies = TicketAnswer::where('ticket_id', $id)->get();
        return view('admin.ticket.reply', ['ticket' => $ticket, 'replies' => $replies]);

    }

    public function storeTicketReply($id, Request $request)
    {
        $ticket = Ticket::find($id);
        if ($ticket) {
            TicketAnswer::create([
                    "ticket_id" => $id,
                    "text" => $request->text,
                    "type" => 'admin',
                ]
            );
            $ticket->is_read = 0;
            $ticket->status = "admin_answer";
            $ticket->save();
            $gcm = GCM::where('device_id', $ticket->device_id)->first();
            if ($gcm) {
                FCMService::send($gcm->firebase_token,
                    [
                        'title' => 'پاسخ تیکت',
                        'body' => 'تیکت شماره ' . $ticket->id . ' توسط پشتیبان پاسخ داده شد',
                    ],
                    [
                        'value' => $ticket->id,
                        'action' => 'answer'
                    ]);

            }
            return back()->with('msg', 'پیام ارسال شد');

        }

        return back()->with('msg', 'پیام ارسال نشذ');


    }

    public function closeTicket($id)
    {
        $ticket = Ticket::find($id);
        if ($ticket) {
            $ticket->status = 'closed';
            $ticket->save();
            return redirect()->back();

        }
        return redirect()->back();

    }

    public function openTicket($id)
    {
        $ticket = Ticket::find($id);
        if ($ticket) {
            $ticket->status = 'waiting';
            $ticket->save();
            return redirect()->back();

        }
        return redirect()->back();

    }

    public function listSupportCategory()
    {
        $list = TicketCategory::where('id', '<>', 0);
        return view('admin.ticket.category', ['list' => $list->paginate(15)]);

    }

    public function newSupportCategory()
    {
        return view('admin.ticket.new_category');
    }

    public function newSupportCategoryStore(Request $request)
    {
        TicketCategory::create(['title' => $request->title, 'status' => 1]);
        return redirect()->route('support.category.list')->with('msg', 'با موفقیت ذخیره شد');
    }

    public function editSupportCategory($id)
    {
        $edit = TicketCategory::find($id);
        return view('admin.ticket.new_category', ['edit' => $edit]);
    }

    public function editSupportCategoryStore(Request $request, $id)
    {
        $edit = TicketCategory::find($id);
        $edit->title = $request->title;
        $edit->save();
        return redirect()->route('support.category.list')->with('msg', 'با موفقیت ذخیره شد');
    }

    public function deleteCategorySupport($id)
    {
        $edit = TicketCategory::find($id);
        $edit->delete();
        return redirect()->route('support.category.list')->with('msg', 'با موفقیت حذف شد');

    }
    ######### Support #########

    ######### App Info #########
    public function loadAppInfo()
    {
        $appInfo = AppInfo::first();
        return view('admin.app_info.index', compact('appInfo'));
    }

    public function updateAppInfo(Request $request)
    {
        AppInfo::first()->update($request->except('_token'));
        return redirect()->route('appInfo.load');
    }

    ######### App Info #########

    ######### Report #########
    public function loadReports()
    {
        $list = Report::with('jobOffer')->where('id', '<>', 0)->orderBy('id', 'Desc')->paginate(20);
        return view('admin.report.list', compact('list'));
    }
    ######### Report #########


}
