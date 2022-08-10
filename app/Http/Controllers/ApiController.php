<?php

namespace App\Http\Controllers;

use App\Models\AppInfo;
use App\Models\Company;
use App\Models\EducationField;
use App\Models\GCM;
use App\Models\JobField;
use App\Models\JobOffer;
use App\Models\JobOfferMeta;
use App\Models\JobOfferSubmitRequest;
use App\Models\Report;
use App\Models\State;
use App\Models\Ticket;
use App\Models\TicketAnswer;
use App\Models\TicketCategory;
use App\Models\User;
use App\Models\UserToken;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use function App\Helpers\uploadAttachment;

class ApiController extends Controller
{
    ############ Base ##########
    private function createResponseItems($success, $error): array
    {
        return ["data" => $success,
            "code" => $error == null ? 1 : -1,
            "error" => $error
        ];
    }

    private function response($data)
    {
        $responsecode = 200;
        $header = array(
            'Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'
        );
        return response()->json($data, $responsecode, $header, JSON_UNESCAPED_UNICODE)
            ->setStatusCode(Response::HTTP_OK, Response::$statusTexts[Response::HTTP_OK],);
    }

    private function validateHeader(Request $request)
    {
        if ($request->hasHeader('AccessToken')) {
            $token = UserToken::where('token', $request->header('AccessToken'))->first();
            if (!$token) {
                return $this->response($this->createResponseItems(null, 'احراز هویت ناموفق'));

            }
        } else {
            return $this->response($this->createResponseItems(null, 'احراز هویت ناموفق'));
        }
    }
    ############ Base ##########

    ############ Dashboard ##########
    public function getDashboardItem(Request $request)
    {
        if (!$request->hasHeader('DeviceId')) {
            return $this->response($this->createResponseItems(null, 'احراز هویت ناموفق'));
        }
        $unReadCount = Ticket::where('device_id', $request->header('DeviceId'))->where('is_read', 0)->count();
        $appInfo = AppInfo::first();
        $response = [
            "unread_messages" => $unReadCount,
            "setting" => $appInfo,
            "job_field" => JobField::all(),
            "education_field" => EducationField::all(),
            "grades" => $this->generateGrades()
        ];
        return $this->response($this->createResponseItems($response, null));

    }

    function generateGrades(): array
    {
        $res = [];
        array_push($res, ["زیر دیپلم" => 21891]);
        array_push($res, ["دیپلم" => 21892]);
        array_push($res, ["فوق دیپلم" => 21893]);
        array_push($res, ["لیسانس" => 21894]);
        array_push($res, ["فوق لیسانس" => 21895]);
        array_push($res, ["دکتری" => 21896]);
        return $res;
    }
    ############ Dashboard ##########


    ############ User ##########
    public function register(Request $request)
    {
        //region Validations
        if ($request->deviceId == null) {
            return $this->response($this->createResponseItems(null, 'شناسه دستگاه وارد نشده است'));
        }
        if ($request->password == null) {
            return $this->response($this->createResponseItems(null, 'رمز عبور را انتخاب کنید'));
        }
        if ($request->prefixNumber != null) {
            if (strlen($request->prefixNumber) > 11) {
                return $this->response($this->createResponseItems(null, 'پیش شماره وارد شده صحیح نمی باشد'));

            }

        }

        //endregion
        $user = User::where('device_id', $request->deviceId)->first();
        if ($user) {
            return $this->response($this->createResponseItems(null, 'شناسه دستگاه تکراری است'));
        }
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->lastName,
            'email' => $request->email,
            'phone_number' => $request->phoneNumber,
            'prefix_number' => $request->prefixNumber,
            'device_id' => $request->deviceId,
            'gender' => $request->gender,
            'state_id' => $request->stateId,
            'password' => encrypt($request->password),
        ]);
        $token = UserToken::create([
            'user_id' => $user->id,
            'token' => Str::random(24)
        ]);
        return $this->response($this->createResponseItems($token, null));

    }

    public function loginByDevice(Request $request)
    {
        if ($request->password == null) {
            return $this->response($this->createResponseItems(null, 'همه مقایر را وارد کنیذ'));
        }
        $user = null;
        if ($request->deviceId) {
            $user = User::where('device_id', $request->deviceId)->first();
        } else if ($request->email) {
            $user = User::where('email', $request->email)->first();
        } else if ($request->phoneNumber) {
            $user = User::where('phone_number', $request->phoneNumber)->first();
        }
        if (!$user) {
            return $this->response($this->createResponseItems(null, 'نام کاربری یا کلمه عبور اشتباه است'));
        }
        if (decrypt($user->password) != $request->password) {
            return $this->response($this->createResponseItems(null, 'نام کاربری یا کلمه عبور اشتباه است'));

        }
        return $this->response($this->createResponseItems($user->Token, null));

    }

    ############ User ##########
    public function findInRelation($item, $value): bool
    {

        $res = false;
        foreach ($item->meta as $relation) {
            if ($relation->value == $value) {
                $res = true;
                return true;
            }
        }
        return $res;
    }

    public function GetAllJobOffers()
    {
        $list = JobOffer::with('contact')->where('cats', 'like', "%9999%");

        ### Filters ####
        if (!isset($_GET['order']) || $_GET['order'] == 'new') {
            $list->orderBy('id', 'DESC');
        } else {
            $list->orderBy('id');
        }
        if (isset($_GET['gender']) && $_GET['gender'] != '') {
            if ($_GET['gender'] == "76399" || $_GET['gender'] == "76400") {
                $list->where('cats', 'LIKE', '%' . $_GET['gender'] . '%');

            } else {
                return $this->createResponseItems(null, 'فیلتر جنسیت صحیح نمی باشد');

            }
        }
        if (isset($_GET['grade']) && $_GET['grade'] != '') {
            if ($_GET['grade'] == "21891" || $_GET['grade'] == "21892" || $_GET['grade'] == "21893"
                || $_GET['grade'] == "21894" || $_GET['grade'] == "21895" || $_GET['grade'] == "21896") {
                $list->where('cats', 'LIKE', '%' . $_GET['grade'] . '%');


            } else {
                return $this->createResponseItems(null, 'فیلتر مقطع تحصیلی صحیح نمی باشد');

            }
        }
        if (isset($_GET['experience']) && $_GET['experience'] != '') {
            if ($_GET['experience'] == "1021033" || $_GET['experience'] == "1022031" || $_GET['experience'] == "1022032"
                || $_GET['experience'] == "1022033" || $_GET['experience'] == "1022034" ||
                $_GET['experience'] == "1022035" || $_GET['experience'] == "1022036") {
                $list->where('cats', 'LIKE', '%' . $_GET['experience'] . '%');


            } else {
                return $this->createResponseItems(null, 'فیلتر سابقه کار صحیح نمی باشد');

            }
        }
        if (isset($_GET['workMode']) && $_GET['workMode'] != '') {
            if ($_GET['workMode'] == "1021032" || $_GET['workMode'] == "19087" || $_GET['workMode'] == "78191"
                || $_GET['workMode'] == "13558" || $_GET['workMode'] == "16388") {
                $list->where('cats', 'LIKE', '%' . $_GET['workMode'] . '%');

            } else {
                return $this->createResponseItems(null, 'فیلتر نوع کار صحیح نمی باشد');

            }
        }
        if (isset($_GET['workTime']) && $_GET['workTime'] != '') {
            if ($_GET['workTime'] == "1021031" || $_GET['workTime'] == "85293") {
                $list->where('cats', 'LIKE', '%' . $_GET['workTime'] . '%');

            } else {
                return $this->createResponseItems(null, 'فیلتر ساعت کاری صحیح نمی باشد');

            }

        }
        if (isset($_GET['education']) && $_GET['education'] != '') {
            foreach (json_decode($_GET['education']) as $filterEducation) {
                $edField = EducationField::where('cat_id', $filterEducation)->first();
                if (!$edField) {
                    return $this->createResponseItems(null, 'کد رشته وارد شده صحیح نمی باشد');
                }
                $list->whereJsonContains('cats', $filterEducation);
            }
        }
        if (isset($_GET['job']) && $_GET['job'] != '') {
            foreach (json_decode($_GET['job']) as $filterJobs) {
                $jField = JobField::where('cat_id', $filterJobs)->first();
                if (!$jField) {
                    return $this->createResponseItems(null, 'کد شغلی وارد شده صحیح نمی باشد');
                }
                $list->whereJsonContains('cats', $filterJobs);


            }
        }
        if (isset($_GET['name']) && $_GET['name'] != '') {
            $list->where('title', 'LIKE', '%' . $_GET['name'] . '%');
        }
        $response = array();

        $list = $list->paginate(15);
        $itemsTransformed = $list
            ->getCollection()
            ->map(function ($item) {
                return [
                    "id" => $item->id,
                    "title" => $item->title,
                    "content" => $item->content,
                    "gender" => $this->getGender($item->cats),
                    "special_job_offer" => $this->isSpecialJobOffer($item->cats),
                    "grade" => $this->getGrade($item->cats),
                    "work_time" => $this->getWorkTime($item->cats),
                    "work_mode" => $this->getWorkMode($item->cats),
                    "salary" => $this->getSalary($item->cats),
                    "experience" => $this->getExperience($item->cats),
                    "job_field" => $this->getJob($item->cats),
                    "education_field" => $this->getEducation($item->cats),
                    "apply_link" => $item->apply_link,
                    "company_description" => $item->company_description,
                    "cats" => explode(',', $item->cats),
                    "company_logo" => $item->company_logo,
                    "company_name" => $item->company_name,
                    "district" => $item->district,
                    "introduction" => $item->introduction,
                    "link" => $item->link,
                    "payamak" => $item->payamak,
                    "plan" => $item->plan,
                    "state" => $item->state,
                    "contact" => $item->contact,
                ];
            })->toArray();


        $itemsTransformedAndPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $itemsTransformed,
            $list->total(),
            $list->perPage(),
            $list->currentPage(), [
                'path' => \Request::url(),
                'query' => [
                    'page' => $list->currentPage()
                ]
            ]
        );


        return $this->createResponseItems($itemsTransformedAndPaginated, null);

    }

    public function getSingleJobOffer($id)
    {
        $item = JobOffer::with('contact')->find($id);
        if (!$item) {
            return $this->createResponseItems(null, 'موردی یافت نشد');
        }
        $res = [
            "id" => $item->id,
            "title" => $item->title,
            "content" => $item->content,
            "gender" => $this->getGender($item->cats),
            "special_job_offer" => $this->isSpecialJobOffer($item->cats),
            "grade" => $this->getGrade($item->cats),
            "work_time" => $this->getWorkTime($item->cats) . ' ' . $this->getTimeDetail($item->time_detail),
            "work_mode" => $this->getWorkMode($item->cats),
            "salary" => $this->getSalary($item->cats),
            "experience" => $this->getExperience($item->cats),
            "job_field" => $this->getJob($item->cats),
            "education_field" => $this->getEducation($item->cats),
            "apply_link" => $item->apply_link,
            "company_description" => $item->company_description,
            "cats" => explode(',', $item->cats),
            "company_logo" => $item->company_logo,
            "company_name" => $item->company_name,
            "district" => $item->district,
            "introduction" => $item->introduction,
            "link" => $item->link,
            "payamak" => $item->payamak,
            "plan" => $item->plan,
            "state" => $item->state,
            "contact" => ($item->contact),
        ];
        return $this->createResponseItems($res, null);

    }

    public function getTimeDetail($string)
    {
        if ($string != '') {
            return "($string)";
        }
    }

    public function getAllCompanies()
    {
        $list = Company::where('id', '<>', 0);
        ### Filters ####
        if (!isset($_GET['order']) || $_GET['order'] == 'new') {
            $list->orderBy('id', 'DESC');
        } else {
            $list->orderBy('id');
        }
        if (isset($_GET['name']) && $_GET['name'] != '') {
            $list->where('name', 'LIKE', '%' . $_GET['name'] . '%');
        }
        if (isset($_GET['category']) && $_GET['category'] != '') {
            $list->where('category', 'LIKE', '%' . $_GET['category'] . '%');

        }

        $response = array();

        $list = $list->paginate(50);
        $itemsTransformed = $list
            ->getCollection()
            ->map(function ($item) {
                return [
                    "id" => $item->company_id,
                    "name" => $item->name,
                    "logo" => $item->logo,
                    "content" => $item->content,
                    "category" => $item->category,
                    "user_count" => $item->user_count,
                    "area" => $item->area,
                    "website" => $item->website,
                ];
            })->toArray();


        $itemsTransformedAndPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $itemsTransformed,
            $list->total(),
            $list->perPage(),
            $list->currentPage(), [
                'path' => \Request::url(),
                'query' => [
                    'page' => $list->currentPage()
                ]
            ]
        );
        return $this->response($this->createResponseItems($itemsTransformedAndPaginated, null));

    }

    public function getSingleCompanyInfo($id)
    {
        $company = Company::where('company_id', $id)->first();
        if ($company) {
            return $this->response($this->createResponseItems($company, null));

        } else {
            return $this->response($this->createResponseItems(null, 'شرکتی یافت نشد'));

        }
    }

    public function getCompanyJobFields($id)
    {
        $client = new Client;
        $results = $client->request('GET', 'https://kar.iranestekhdam.ir/feed/companies/' . $id);
        $companies = json_decode($results->getBody());
        $response = [];
        foreach ($companies as $company) {
            $fetchSingle = $client->request('GET', $company->get_details);
            $singleRes = json_decode($fetchSingle->getBody());
            $item = $singleRes[0];
            $single = [
                "title" => $item->title ?? "",
                "content" => $item->content ?? "",
                "gender" => $this->getGender($item->cats),
                "special_job_offer" => $this->isSpecialJobOffer($item->cats),
                "grade" => $this->getGrade($item->cats),
                "work_time" => $this->getWorkTime($item->cats),
                "work_mode" => $this->getWorkMode($item->cats),
                "salary" => $this->getSalary($item->cats),
                "experience" => $this->getExperience($item->cats),
                "job_field" => $this->getJob($item->cats),
                "education_field" => $this->getEducation($item->cats) ?? "",
                "apply_link" => $item->apply_link ?? "",
                "company_description" => $item->company_description ?? "",
                "cats" => explode(',', $item->cats) ?? "",
                "company_logo" => $item->company_logo ?? "",
                "company_name" => $item->company_name ?? "",
                "district" => $item->district ?? "",
                "introduction" => $item->introduction ?? "",
                "link" => $item->link ?? "",
                "payamak" => $item->payamak ?? "",
                "plan" => $item->plan ?? "",
                "state" => $item->state ?? "",
                "contact" => ($item->contacts),
            ];
            array_push($response, $single);
        }
        return $this->createResponseItems($response, null);
    }

    function getCompanyCategories()
    {
        $cats = DB::table('companies')->distinct()->get(['category']);
        $res = [];
        foreach ($cats as $cat) {
            array_push($res, ["title" => $cat->category]);
        }
        return $res;
    }

    public function GetEducationFields()
    {
        return $this->createResponseItems(EducationField::all(), null);
    }

    public function GetWorkFields()
    {
        return $this->createResponseItems(JobField::all(), null);
    }

    public function GetStateJobOffers($id)
    {
        $list = JobOfferMeta::with('jobOffer')->where('value', $id)->orderBy('id');
        ### Filters ####
        if (!isset($_GET['order']) || $_GET['order'] == 'new') {
            $list->orderBy('id', 'DESC');
        } else {
            $list->orderBy('id');
        }
        if (isset($_GET['name']) && $_GET['name'] != '') {
            $list->where('title', 'LIKE', '%' . $_GET['name'] . '%');
        }
        if (isset($_GET['state']) && $_GET['state'] != '') {
            $list->where('state', 'LIKE', '%' . $_GET['state'] . '%');
        }
        $response = array();

        $list = $list->paginate(15);

        $itemsTransformed = $list
            ->getCollection()
            ->map(function ($item) {
                return [
                    "id" => $item->jobOffer->id,
                    "title" => $item->jobOffer->title,
                    "content" => $item->jobOffer->content,
                    "gender" => $this->getGender($item->jobOffer->cats),
                    "special_job_offer" => $this->isSpecialJobOffer($item->jobOffer->cats),
                    "grade" => $this->getGrade($item->jobOffer->cats),
                    "work_time" => $this->getWorkTime($item->jobOffer->cats),
                    "work_mode" => $this->getWorkMode($item->jobOffer->cats),
                    "salary" => $this->getSalary($item->jobOffer->cats),
                    "experience" => $this->getExperience($item->jobOffer->cats),
                    "job_field" => $this->getJob($item->jobOffer->cats),
                    "education_field" => $this->getEducation($item->jobOffer->cats),
                    "apply_link" => $item->jobOffer->apply_link,
                    "company_description" => $item->jobOffer->company_description,
                    "cats" => explode(',', $item->jobOffer->cats),
                    "company_logo" => $item->jobOffer->company_logo,
                    "company_name" => $item->jobOffer->company_name,
                    "district" => $item->jobOffer->district,
                    "introduction" => $item->jobOffer->introduction,
                    "link" => $item->jobOffer->link,
                    "payamak" => $item->jobOffer->payamak,
                    "plan" => $item->jobOffer->plan,
                    "state" => $item->jobOffer->state,
                    "contact" => $item->jobOffer->contact,
                ];
            })->toArray();


        $itemsTransformedAndPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $itemsTransformed,
            $list->total(),
            $list->perPage(),
            $list->currentPage(), [
                'path' => \Request::url(),
                'query' => [
                    'page' => $list->currentPage()
                ]
            ]
        );
        return $this->createResponseItems($itemsTransformedAndPaginated, null);
    }


    private function getGender($cats): string
    {
        if (in_array("76399", str_getcsv($cats))) {
            return "زن";
        } else if (in_array("76400", str_getcsv($cats))) {
            return "مرد";
        } else {
            return "مرد و زن";
        }
    }

    private function getExperience($cats): string
    {
        if (in_array("1021033", str_getcsv($cats))) {
            return "ندارد";
        } else if (in_array("1022031", str_getcsv($cats))) {
            return "حداقل 1 سال";
        } else if (in_array("1022032", str_getcsv($cats))) {
            return "حداقل 2 سال";
        } else if (in_array("1022033", str_getcsv($cats))) {
            return "حداقل 3 سال";
        } else if (in_array("1022034", str_getcsv($cats))) {
            return "حداقل 4 سال";
        } else if (in_array("1022035", str_getcsv($cats))) {
            return "حداقل 5 تا 9 سال";
        } else if (in_array("1022036", str_getcsv($cats))) {
            return "حداقل  10 سال به بالا";
        } else {
            return "-";
        }
    }

    private function getWorkTime($cats): string
    {
        if (in_array("1021031", str_getcsv($cats))) {
            return "تمام وقت";
        } else if (in_array("85293", str_getcsv($cats))) {
            return "نیمه وقت";
        } else {
            return "-";
        }
    }

    private function getSalary($cats): string
    {
        if (in_array("1023031", str_getcsv($cats))) {
            return "توافقی";
        } else if (in_array("1023032", str_getcsv($cats))) {
            return "حداقل حقوق پایه وزارت کار";
        } else if (in_array("1023033", str_getcsv($cats))) {
            return "از 3 میلیون تومان به بالا";
        } else if (in_array("1023034", str_getcsv($cats))) {
            return "از 4 میلیون تومان به بالا";
        } else if (in_array("1023035", str_getcsv($cats))) {
            return "از 5 میلیون تومان به بالا";
        } else if (in_array("1023036", str_getcsv($cats))) {
            return "از 6 میلیون تومان به بالا";
        } else if (in_array("1023037", str_getcsv($cats))) {
            return "از 7 میلیون تومان به بالا";
        } else if (in_array("1023038", str_getcsv($cats))) {
            return "از 8 میلیون تومان به بالا";
        } else if (in_array("1023039", str_getcsv($cats))) {
            return "از 9 میلیون تومان به بالا";
        } else if (in_array("1023040", str_getcsv($cats))) {
            return "از 10 میلیون تومان به بالا";
        } else if (in_array("1023041", str_getcsv($cats))) {
            return "از 11 میلیون تومان به بالا";
        } else if (in_array("1023042", str_getcsv($cats))) {
            return "از 12 میلیون تومان به بالا";
        } else if (in_array("1023043", str_getcsv($cats))) {
            return "از 13 میلیون تومان به بالا";
        } else if (in_array("1023044", str_getcsv($cats))) {
            return "از 14 میلیون تومان به بالا";
        } else if (in_array("1023045", str_getcsv($cats))) {
            return "از 15 میلیون تومان به بالا";
        } else {
            return "-";
        }
    }

    private function getWorkMode($cats): string
    {
        if (in_array("1021032", str_getcsv($cats))) {
            return "حضوری";
        } else if (in_array("19087", str_getcsv($cats))) {
            return "دورکاری";
        } else if (in_array("78191", str_getcsv($cats))) {
            return "کارآموز";
        } else if (in_array("13558", str_getcsv($cats))) {
            return "دانشجو";
        } else if (in_array("16388", str_getcsv($cats))) {
            return "بازنشسته";
        } else {
            return "-";
        }
    }

    private function isSpecialJobOffer($cats): bool
    {
        return in_array("71194", str_getcsv($cats));
    }

    private function getGrade($cats): string
    {
        $text = '';
        if (in_array("21891", str_getcsv($cats))) {
            $text .= "| زیردیپلم ";
        }
        if (in_array("21892", str_getcsv($cats))) {
            $text .= "| دیپلم ";
        }
        if (in_array("21893", str_getcsv($cats))) {
            $text .= "| فوق دیپلم ";
        }
        if (in_array("21894", str_getcsv($cats))) {
            $text .= "| لیسانس ";
        }
        if (in_array("21895", str_getcsv($cats))) {
            $text .= "| فوق لیسانس ";
        }
        if (in_array("21896", str_getcsv($cats))) {
            $text .= "| دکتری";
        }
        if (!in_array("21891", str_getcsv($cats)) && !in_array("21892", str_getcsv($cats)) && !in_array("21893", str_getcsv($cats))
            && !in_array("21894", str_getcsv($cats)) && !in_array("21895", str_getcsv($cats)) && !in_array("21896", str_getcsv($cats))
        ) {
            $text = "همه مقاطع تحصیلی";
        }

        try {
            if(strpos($text, '|') !== false){
               // $text = substr($text, 1, -1);
            }
        }catch (\Exception $exception){

        }
        return $text;
    }

    private function getJob($cats): array
    {
        $jobs = array();
        foreach (explode(',', $cats) as $item) {
            $job = JobField::where('cat_id', $item)->first();
            if ($job) {
                array_push($jobs, $job->title);
            }
        }
        return $jobs;
    }

    private function getEducation($cats): array
    {
        $educations = array();
        foreach (explode(',', $cats) as $item) {
            $job = EducationField::where('cat_id', $item)->first();
            if ($job) {
                array_push($educations, $job->title);
            }
        }
        return $educations;
    }

    function getStateList()
    {
        return $this->createResponseItems(State::all(), null);
    }


    ############ Ticket ##########

    function getTicketCategories()
    {
        return $this->response($this->createResponseItems(TicketCategory::all()->makeHidden(['created_at', 'updated_at', 'status']), null));


    }

    public function sendNewTicket(Request $request)
    {
        $userToken = null;
        if (!$request->hasHeader('DeviceId')) {
            return $this->response($this->createResponseItems(null, 'احراز هویت ناموفق'));

        }
        if ($request->categoryId == null || $request->title == null || $request->body == null) {
            return $this->response($this->createResponseItems(null, 'همه مقادیر را وارد کنید'));
        }
        $category = TicketCategory::find($request->categoryId);
        if (!$category) {
            return $this->response($this->createResponseItems(null, 'دسته مورد نظر یافت نشد'));
        }
        $ticket = Ticket::create([
            'ticket_category_id' => $category->id,
            "subject" => $request->title,
            "body" => $request->body,
            "device_id" => $request->header('DeviceId'),
        ]);
        return $this->response($this->createResponseItems($ticket->makeHidden(['created_at', 'updated_at']), null));


    }

    function getUserTickets(Request $request)
    {
        if (!$request->hasHeader('DeviceId')) {
            return $this->response($this->createResponseItems(null, 'احراز هویت ناموفق'));
        }
        return $this->response($this->createResponseItems(Ticket::with('category')->where('device_id', $request->header('DeviceId'))->orderBy('id', 'DESC')->get()->makeHidden(['ticket_category_id', 'user_id']), null));

    }

    function submitTicketRely(Request $request)
    {
        $userToken = null;
        if (!$request->hasHeader('DeviceId')) {
            return $this->response($this->createResponseItems(null, 'احراز هویت ناموفق'));

        }
        if ($request->ticketId == null || $request->text == null) {
            return $this->response($this->createResponseItems(null, 'همه مقادیر را وارد کنید'));
        }
        $ticket = Ticket::find($request->ticketId);
        if (!$ticket) {
            return $this->response($this->createResponseItems(null, 'شناسه تیکت اشتباه است'));

        }
        if ($ticket->device_id != $request->header('DeviceId')) {
            return $this->response($this->createResponseItems(null, 'امکان پاسخ به این تیکت را ندارید'));
        }
        TicketAnswer::create(
            [
                "ticket_id" => $request->ticketId,
                "text" => $request->text,
                "type" => "user"
            ]
        );
        $ticket->status = 'user_answer';
        $ticket->save();
        return $this->response($this->createResponseItems(true, null));

    }

    function loadTicketReplies(Request $request)
    {
        if (!$request->hasHeader('DeviceId')) {
            return $this->response($this->createResponseItems(null, 'احراز هویت ناموفق'));

        }
        if ($request->ticketId == null) {
            return $this->response($this->createResponseItems(null, 'شناسه تیکت را وارد کنید'));
        }
        $ticket = Ticket::find($request->ticketId);
        if (!$ticket) {
            return $this->response($this->createResponseItems(null, 'تیکتی یافت نشد'));

        }

        if ($ticket->device_id != $request->header('DeviceId')) {
            return $this->response($this->createResponseItems(null, 'تیکتی یافت نشد'));
        }
        $replies = TicketAnswer::where('ticket_id', $request->ticketId)->get();
        foreach ($replies as $reply) {
            $reply->is_read = 1;
            $reply->save();
        }
        $ticket->is_read = 1;
        $ticket->save();
        return $this->response($this->createResponseItems(Ticket::with('reply')->where('id', $request->ticketId)->orderBy('id', 'DESC')->get()->makeHidden(['ticket_category_id', 'user_id']), null));

    }
    ############ Ticket ##########

    ############ Submit JobOffer ##########
    public function submitJobOffer(Request $request)
    {
        if (!$request->hasHeader('DeviceId')) {
            return $this->response($this->createResponseItems(null, 'احراز هویت ناموفق'));

        }
        if ($request->title == null) {
            return $this->response($this->createResponseItems(null, 'عنوان را وارد کنید'));

        }

        if ($request->text == null) {
            return $this->response($this->createResponseItems(null, 'متن درخواست را وارد کنید'));

        }
        $fileName = null;
        if ($request->attachment != null) {
            $fileName = uploadAttachment($request);

        }
        JobOfferSubmitRequest::create([
            "device_id" => $request->header('DeviceId'),
            "title" => $request->title,
            "text" => $request->text,
            "file_name" => $fileName,
            "email" => $request->email,
            "mobile_number" => $request->mobileNumber,
            "phone_number" => $request->phoneNumber,
        ]);
        return $this->response($this->createResponseItems(true, null));

    }

    public function getUserRequests(Request $request)
    {
        if (!$request->hasHeader('DeviceId')) {
            return $this->response($this->createResponseItems(null, 'احراز هویت ناموفق'));

        }

        return $this->response($this->createResponseItems(JobOfferSubmitRequest::where('device_id', $request->header('DeviceId'))->orderBy('id', 'DESC')->get()->makeHidden(['ticket_category_id', 'user_id']), null));

    }
    ############ Submit JobOffer ##########

    ############ Application Setting ##########
    public function getApplicationSettings()
    {
        $appInfo = AppInfo::first();
        $response = [
            "appVersion" => $appInfo->app_version,
            "updateNote" => $appInfo->update_note,
            "downloadUrl" => $appInfo->download_url,
            "forceUpdate" => $appInfo->force_update,
            "cvUrl" => $appInfo->resume_url,
            "shareText" => $appInfo->share_text,
            "aboutText" => $appInfo->about_text,
            "address" => $appInfo->address,
            "email" => $appInfo->email,
            "phone" => $appInfo->tel,
            "website" => $appInfo->website,
            "telegram" => $appInfo->telegram_id,
            "whatsApp" => $appInfo->whats_app_number,
        ];
        return $this->response($this->createResponseItems($response, null));
    }
    ############ Application Setting ##########

    ############ Store FCM ID ##########
    function storeDeviceFcmId(Request $request)
    {
        if (!$request->hasHeader('DeviceId')) {
            return $this->response($this->createResponseItems(null, 'احراز هویت ناموفق'));

        }
        GCM::updateOrCreate(['device_id' => $request->header('DeviceId')], [
            "device_id" => $request->header('DeviceId'),
            "firebase_token" => $request->firebaseToken
        ]);
        return $this->response($this->createResponseItems(true, null));

    }
    ############ Store FCM ID ##########

    ############ Report ##########
    public function report(Request $request)
    {
        if (!$request->hasHeader('DeviceId')) {
            return $this->response($this->createResponseItems(null, 'احراز هویت ناموفق'));

        }

        if (!isset($request->jobPositionId)) {
            return $this->response($this->createResponseItems(null, 'شناسه موقعیت شغلی را وارد کنید'));

        }
        $job = JobOffer::find($request->jobPositionId);
        if (!$job) {
            return $this->response($this->createResponseItems(null, 'موقعیت شغلی ای با این شناسه یافت نشد'));
        }
        Report::create([
            "device_id" => $request->header('DeviceId'),
            "job_offer_id" => $request->jobPositionId,
            "description" => $request->description,
            "title" => $request->title,
        ]);
        return $this->response($this->createResponseItems(true, null));


    }
    ############ Report ##########


}
