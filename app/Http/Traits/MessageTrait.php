<?php


namespace App\Http\Traits;


use App\Http\Repository\User\UserRepository;
use App\Models\BanksHiring;
use App\Models\CtegoriesCombination;
use App\Models\EducationField;
use App\Models\GovernmentAgency;
use App\Models\JobField;
use App\Models\JobOffer;
use App\Models\State;
use App\Models\User;
use App\Models\UserAutomaticSubscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Morilog\Jalali\Jalalian;
use Telegram\Bot\Keyboard\Keyboard;
use function App\Helpers\appendTexts;
use function App\Helpers\getOptions;
use function App\Helpers\SendTelegramMessage;
use function App\Helpers\SendTelegramMessageAsHTML;
use function App\Helpers\SendIntroVideo;

trait MessageTrait
{
    //region Variables
    private $userRepo;
    use MenuKeyboardTrait;
    use MenuMessageTrait;

    //endregion

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepo = $userRepository;
    }

    private function getCurrentUser(): User
    {
        return User::where('chat_id', request('message.from.id'))->first();
    }

    public function sendStartMessage()
    {
        if ($this->userRepo->IsUserExists(request('message.from.id'))) {
            SendTelegramMessage($this->GetMainMenuMessageText(), $this->mainMenuKeyboard());
        } else {
            $this->userRepo->AddUser(request('message.from.first_name'), request('message.from.username'), request('message.from.id'));
            SendTelegramMessage($this->GetMainMenuMessageForNewlyRegisteredUsersText(), $this->mainMenuKeyboard());
        }
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'start_menu');

    }

    public function sendStartMenuMessageOnNavigateBack()
    {
        if ($this->userRepo->IsUserExists(request('message.from.id'))) {
            SendTelegramMessage($this->GetMainMenuMessageTextOnNavigateBack(), $this->mainMenuKeyboard());
        } else {
            $this->userRepo->AddUser(request('message.from.first_name'), request('message.from.username'), request('message.from.id'));
            SendTelegramMessage($this->GetMainMenuMessageForNewlyRegisteredUsersText(), $this->mainMenuKeyboard());
        }
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'start_menu');

    }

    //region Other Option
    public function sendOtherOptionsMessage()
    {
        SendTelegramMessage($this->SelectDesireService(), $this->otherOptionKeyboard());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'other_option_menu');
        //store user selection

    }

    public function sendMainWebSiteMessage()
    {
        SendTelegramMessageAsHTML($this->MainWebSiteItemMessage(), $this->otherOptionKeyboard());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'other_option_menu');
        //store user selection

    }

    public function SendApplicationUrl()
    {

        SendTelegramMessageAsHTML($this->DownloadUrlMessage(), $this->applicationDownloadUrlKeyboard());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'other_option_menu');
        //store user selection

    }

    public function SendMetaOption($key)
    {
        SendTelegramMessageAsHTML(getOptions($key), $this->otherOptionKeyboard());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'other_option_menu');
        //store user selection

    }

    //endregion

    public function ShowSubscriptionMainMenu()
    {
        SendTelegramMessage($this->GetSubscriptionMenuText(), $this->subscriptionMainMenuKeyboard());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu');
        //store user selection
    }


    public function ShowSubscriptionMainMenuDisable()
    {
        $use = $this->getCurrentUser()->AutomaticSelection;
        $use->active = 0;
        $use->save();
        SendTelegramMessage($this->GetSubscriptionMenuText(), $this->subscriptionMainMenuKeyboard());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu');
        //store user selection
    }

    public function SendBlockedUser()
    {
        SendTelegramMessage($this->blocked(), null);
        //store user selection
    }


    public function BanksAndGovernmentsHiringMessage()
    {
        SendTelegramMessage($this->GetBanksAndGovernmentHiring(), $this->banksAndGovernmentHiringKeyboard());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'govern_bank_hiring_menu');
        //store user selection
    }

    public function ShowStatesListMenu()
    {
        SendTelegramMessage($this->GetSubscriptionMenuSelectStateText(), $this->subscriptionStateKeyboard());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_state');
        //store user selection
    }

    public function ShowGenderSelectionMenu()
    {
        SendTelegramMessage($this->GetSubscriptionMenuSelectSexText(), $this->subscriptionMainMenuSetSexKeyboard());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_gender');
        //store user selection

    }

    public function ShowWorkTimeModeMenu()
    {
        SendTelegramMessage($this->GetSubscriptionMenuWorkTimeModeSelectionText(), $this->subscriptionMainMenuSetWorkTimeKeyboard());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_work_time');
        //store user selection

    }

    public function ShowJobModeMenu()
    {
        SendTelegramMessage($this->GetSubscriptionJobTypeText(), $this->subscriptionJobModeKeyboard());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_job_mode');
        //store user selection

    }

    public function ShowExperienceMenu()
    {
        SendTelegramMessage($this->GetSubscriptionExperienceText(), $this->subscriptionJobExperienceKeyboard());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_experience');
        //store user selection

    }

    public function SearchJobsListMenu()
    {
        $jobs = JobField::orWhere('title', 'like', '%' . request('message.text') . '%')->get();
        if (!$jobs || $jobs->isEmpty()) {
            SendTelegramMessage($this->NoResultFoundInSubscription(), $this->SearchSubscriptionAgain());
            $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_job_field_searching');

        } else {
            if (strlen(request('message.text')) < 3) {
                SendTelegramMessage("حداقل دو کلمه از شغل مورد نظر را وارد کنید");
            } else {
                SendTelegramMessage($this->SelectJobText(), $this->subscriptionJobListKeyboard(request('message.text')));
                $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_job_field');
            }

        }

        //store user selection

    }

    public function SearchJobsListMenuSecond()
    {
        $jobs = JobField::orWhere('title', 'like', '%' . request('message.text') . '%')->get();
        if (!$jobs || $jobs->isEmpty()) {
            SendTelegramMessage($this->NoResultFoundInSubscription(), $this->SearchSubscriptionAgain());
            $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_job_field_searching_second');

        } else {
            if (strlen(request('message.text'))<3)
            {
                SendTelegramMessage("حداقل دو کلمه از شغل مورد نظر را وارد کنید");
            }
            else{
                SendTelegramMessage($this->SelectJobText(), $this->subscriptionJobListKeyboard(request('message.text')));
                $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_job_field_second');
            }

        }

        //store user selection

    }

    public function SearchJobsListMenuThird()
    {
        $jobs = JobField::orWhere('title', 'like', '%' . request('message.text') . '%')->get();
        if (!$jobs || $jobs->isEmpty()) {
            SendTelegramMessage($this->NoResultFoundInSubscription(), $this->SearchSubscriptionAgain());
            $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_job_field_searching_third');

        } else {
            if (strlen(request('message.text'))<3)
            {
                SendTelegramMessage("حداقل دو کلمه از شغل مورد نظر را وارد کنید");
            }
            else{
                SendTelegramMessage($this->SelectJobText(), $this->subscriptionJobListKeyboard(request('message.text')));
                $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_job_field_third');
            }

        }

        //store user selection

    }



    public function SearchEducationsListMenuShowItem()
    {
        if (strlen(request('message.text')) < 3) {
            SendTelegramMessage("حداقل دو کلمه از رشته تحصیلی مورد نظر را وارد کنید");
        } else {
            SendTelegramMessage($this->SelectFromEducationBelow(), $this->subscriptionEducationListKeyboard(request('message.text')));
            $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_education_field_searching');
        }
        //store user selection

    }




    public function showSearchInJobstMessage()
    {
        SendTelegramMessage($this->searchInJobs(), $this->searchInJobsListKeyboard());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_job_field_search');
        //store user selection

    }

    public function showSearchInEducationsMessage()
    {
        SendTelegramMessage($this->searchInJobs(), $this->searchInJobsListKeyboard());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_education_field_search');
        //store user selection

    }


    public function showSearchInEducationMessage()
    {
        SendTelegramMessage($this->searchInEducations(), $this->searchInEducationListKeyboard());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_education_field_search');
        //store user selection

    }

    public function ContinueSelectingSecondJob()
    {
        SendTelegramMessage($this->SelectAnOtherJobText(), $this->continueSubmittingKeyboard());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_ask_second_job');
        //store user selection

    }

    public function ContinueSelectingSecondEducation()
    {
        SendTelegramMessage($this->SelectAnOtherEducationText(), $this->continueSubmittingKeyboard());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_ask_second_education');
        //store user selection

    }

    public function ContinueSelectingThirdJob()
    {
        SendTelegramMessage($this->SelectAnOtherJobText(), $this->continueSubmittingKeyboard());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_ask_third_job');
        //store user selection

    }

    public function ContinueSelectingThirdEducation()
    {
        SendTelegramMessage($this->SelectAnOtherEducationText(), $this->continueSubmittingKeyboard());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_ask_third_education');
        //store user selection

    }


    public function SearchInEducationsMenu()
    {
        if (strlen(request('message.text')) < 3) {
            SendTelegramMessage("حداقل دو کلمه از رشته تحصیلی مورد نظر را وارد کنید");
        } else {
            $jobs = EducationField::orWhere('title', 'like', '%' . request('message.text') . '%')->get();
            if (!$jobs || $jobs->isEmpty()) {
                SendTelegramMessage($this->NoResultFoundInSubscription(), $this->SearchSubscriptionAgain());
                $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_education_field_searching');

            } else {
                SendTelegramMessage($this->SelectEducationText(), $this->subscriptionEducationListKeyboard(request('message.text')));
                $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_education_field');
            }
        }


        //store user selection

    }

    public function SearchInEducationsMenuSecond()
    {
        if (strlen(request('message.text')) < 3) {
            SendTelegramMessage("حداقل دو کلمه از رشته تحصیلی مورد نظر را وارد کنید");
        } else {
            $jobs = EducationField::orWhere('title', 'like', '%' . request('message.text') . '%')->get();
            if (!$jobs || $jobs->isEmpty()) {
                SendTelegramMessage($this->NoResultFoundInSubscription(), $this->SearchSubscriptionAgain());
                $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_education_field_searching_second');

            } else {
                SendTelegramMessage($this->SelectEducationText(), $this->subscriptionEducationListKeyboard(request('message.text')));
                $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_education_field_second');
            }
        }


        //store user selection

    }

    public function SearchInEducationsMenuThird()
    {
        $jobs = EducationField::orWhere('title', 'like', '%' . request('message.text') . '%')->get();
        if (!$jobs || $jobs->isEmpty()) {
            SendTelegramMessage($this->NoResultFoundInSubscription(), $this->SearchSubscriptionAgain());
            $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_education_field_searching_third');

        } else {
            if (strlen(request('message.text')) < 3) {
                SendTelegramMessage("حداقل دو کلمه از رشته تحصیلی مورد نظر را وارد کنید");
            } else {
                SendTelegramMessage($this->SelectEducationText(), $this->subscriptionEducationListKeyboard(request('message.text')));
                $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_education_field_third');
            }
        }


        //store user selection

    }


    public function ShowMaghteTahsili()
    {
        SendTelegramMessage($this->GetMaghateTahsiliText(), $this->subscriptionMaghateTahsiliKeyboard());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_maghta');
        //store user selection

    }

    public function ShowSuccessfulAndChooseSecond()
    {
//        $user=$this->getCurrentUser();
//        $text=['استان : '.CtegoriesCombination::find($user->AutomaticSelection->state_id)];
        SendTelegramMessage($this->FirstSettingSubmittedMessage(), $this->firstStepSubmittedKeyboard());
        $use = $this->getCurrentUser()->AutomaticSelection;
        $use->active = 1;
        $use->save();


        $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_first_step_done');
        //store user selection

    }

    private function handleSubscriptionSelected($currentUser)
    {
        $subscription = DB::table('user_automatic_subscriptions')->where('user_id', $currentUser->id)->first();
        if ($subscription == null) {
            $this->ShowStatesListMenu();
        } else {
            SendTelegramMessage($this->getUserSelection($subscription), $this->subscriptionMainMenuKeyboardWithActiveSelection());
            $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu');
        }
    }

    private function getUserSelection($auto): ?string
    {

        $msg = "تنظیمات دریافت آگهی شما ذخیره شد، از این پس شما آگهی های استخدامی ایران استخدام را با این تنظیمات دریافت خواهید کرد" . "\n";
        $state = CtegoriesCombination::where("service_id", $auto->state_id)->first();
        $msg .= "استان : " . $state->title . "\n";

        if ($auto->job_id != 8595600) {
            $job = CtegoriesCombination::where('service_id', $auto->job_id)->first();
            if ($job) {
                $msg .= "شغل : " . $job->title;
            }
            if ($auto->second_job_id != 8595800 && $auto->second_job_id !=$auto->job_id) {
                $secondJob = CtegoriesCombination::where('service_id', $auto->second_job_id)->first();
                $msg .= " - " . $secondJob->title;

            }
            if ($auto->third_job_id != 85951000 && $auto->third_job_id !=$auto->job_id && $auto->third_job_id !=$auto->second_job_id) {
                $thirdJob = CtegoriesCombination::where('service_id', $auto->third_job_id)->first();
                $msg .= " - " . $thirdJob->title;
            }
        } else {
            $msg .= "شغل : هیچکدام";

        }
        $msg .= "\n" . $this->getGenderTypes($auto->gender_id);

        if ($auto->education_id != 8595700) {
            $job = CtegoriesCombination::where('service_id', $auto->education_id)->first();
            if ($job) {
                $msg .= "\n" . "رشته تحصیلی : " . $job->title;
            }
            if ($auto->second_education_id != 8595900 && $auto->second_education_id !=$auto->education_id) {
                $secondJob = CtegoriesCombination::where('service_id', $auto->second_education_id)->first();
                if ($secondJob) {
                    $msg .= " - " . $secondJob->title;
                }

            }
            if ($auto->third_education_id != 85951100 && $auto->third_education_id !=$auto->education_id && $auto->third_education_id !=$auto->second_education_id) {
                $thirdJob = CtegoriesCombination::where('service_id', $auto->third_education_id)->first();
                if ($thirdJob) {
                    $msg .= " - " . $thirdJob->title;
                }

            }
        } else {
            $msg .= "\n" . "رشته تحصیلی :هیچکدام";
        }
        $msg .= "\n" . $this->getGradeTypes($auto->grade_id);
        $msg .= "\n" . $this->getExperienceTypes($auto->experience_type_id);
        $msg .= "\n" . $this->getWorkModeTypes($auto->work_mode_id);
        $msg .= "\n" . $this->getWorkModeTimes($auto->work_time_id);
        return $msg;

    }


    private function getGenderTypes($gender): ?string
    {
        $msg = "جنسیت : ";
        if ($gender == 8595100) {
            return $msg . " مرد و زن ";
        } else if ($gender == 76399) {
            return $msg . " مرد  ";
        } else if ($gender == 76400) {
            return $msg . "زن ";
        }

        return null;
    }

    private function getWorkModeTypes($workMode): ?string
    {
        $gender = "نوع همکاری : ";
        if ($workMode == 8595300) {
            return $gender . "همه انواع همکاری";
        }
        if ($workMode == 1021032) {
            return $gender . "حضوری";
        }
        if ($workMode == 19087) {
            return $gender . "دورکاری";
        }

        if ($workMode == 78191) {
            return $gender . "کارآموز";

        }
        if ($workMode == 13558) {
            return $gender . "دانشجو";


        }
        if ($workMode == 16388) {
            return $gender . "بازنشسته";


        }
        return "نوع همکاری : همه انواع همکاری";
    }

    private function getWorkModeTimes($workTimeId): ?string
    {
        $gender = "نوع ساعت کاری : ";
        if ($workTimeId == 8595200) {
            return $gender . "همه ساعات کاری ";
        } else if ($workTimeId == 1021031) {
            return $gender . "تمام وقت ";
        } else if ($workTimeId == 85293) {
            return $gender . "نیمه وقت";
        }

        return "نوع ساعت کاری :";
    }

    private function getGradeTypes($grade): ?string
    {
        $gender = "مقطع  : ";
        if ($grade == 8595500) {
            $gender .= "همه مقاطع";
            return $gender;
        }
        if ($grade == 21891) {
            $gender .= "زیر دیپلم ";
            return $gender;
        }
        if ($grade == 21892) {
            $gender .= " دیپلم ";
            return $gender;

        }
        if ($grade == 21893) {
            $gender .= "فوق دیپلم ";
            return $gender;
        }
        if ($grade == 21894) {
            $gender .= "لیسانس ";
            return $gender;
        }
        if ($grade == 21895) {
            $gender .= "فوق لیسانس ";
            return $gender;

        }
        if ($grade == 21896) {
            $gender .= "دکتری ";
            return $gender;

        }

        return "مقطع: همه مقاطع تحصیلی";
    }

    private function getExperienceTypes($experience): ?string
    {
        $gender = "سابقه  : ";
        if ($experience == 8595400) {

            return $gender . "همه سوابق کاری";
        }
        if ($experience == 1021033) {

            return $gender . "ندارد";
        }
        if ($experience == 1022031) {
            return $gender . "1 سال ";
        }
        if ($experience == 1022032) {

            return $gender . "2 سال";
        }
        if ($experience == 1022033) {
            return $gender . "3 سال";
        }
        if ($experience == 1022034) {
            return $gender . "4 سال";
        }
        if ($experience == 1022035) {
            return $gender . "5 الی 9 سال";
        }
        if ($experience == 1022036) {
            return $gender . " 10 سال به بالا";
        }


        return null;
    }


    public function ShowSuccessfulAndChooseSecondThird()
    {
        SendTelegramMessage($this->FirstSettingSubmittedMessageSecond(), $this->firstStepSubmittedKeyboard());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_second_step_done');
        //store user selection

    }

    public function ShowSuccessfulThirdStepAndFinish()
    {
        SendTelegramMessage($this->StepDone(), $this->AutoSubscriptionDone());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu');
        //store user selection

    }


    public function ShowAmountOfExperience()
    {
        SendTelegramMessage($this->AmountOfExperience(), $this->amountOfExperienceOnPositiveSelectionKeyboard());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_experience_amount');
        //store user selection

    }

    //region Second Step

    public function showSearchInJobstMessageSecond()
    {
        SendTelegramMessage($this->searchInJobs(), $this->searchInJobsListKeyboard());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_job_field_search_second');
        //store user selection

    }

    public function showSearchInJobstMessageThird()
    {
        SendTelegramMessage($this->searchInJobs(), $this->searchInJobsListKeyboard());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_job_field_search_third');
        //store user selection

    }


    public function showSearchInEducationMessageSecond()
    {
        SendTelegramMessage($this->searchInEducations(), $this->searchInEducationListKeyboard());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_education_field_search_second');
        //store user selection

    }



    //endregion


    //region Third Step


    public function showSearchInEducationMessageThird()
    {
        SendTelegramMessage($this->searchInEducations(), $this->searchInEducationListKeyboard());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'subscription_menu_education_field_search_third');
        //store user selection

    }


    //endregion


    //region Search
    public function ShowSearchMessage()
    {
        SendTelegramMessage($this->EnterKeyWordToSearch(), $this->searchKeyboard());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'search_menu');
        //store user selection

    }

    public function PerformSearch()
    {

        SendTelegramMessage($this->EnterKeyWordToSearch(), $this->searchKeyboard());
        $this->userRepo->ChangeMenuState(request('message.from.id'), 'search_menu');
        //store user selection

    }

    //endregion
    public function HandleNotMatterSelection()
    {
        /*  $User=$this->getCurrentUser();
          switch ($User->step)
          {
              case ""
          }
          SendTelegramMessage($this->GetSubscriptionMenuWorkTimeModeSelectionText(), $this->subscriptionMainMenuSetWorkTimeKeyboard());
          $this->userRepo->ChangeMenuState(request('message.from.id'),'subscription_menu_work_time');
          //store user selection*/

    }

    public function getAllBanksHiring()
    {
        $banks = BanksHiring::all();

        $date = Jalalian::forge('today');
        $arr = array();
        array_push($arr, ' 💠 ' . 'فرصت های استخدامی بانک ها');
        array_push($arr, '  ');
        array_push($arr, ' ⏱ ' . 'زمان ارسال: ' . $date->getYear() . '/' . $date->getMonth() . '/' . $date->getDay());
        array_push($arr, '  ');
        for ($i = 0; $i < count($banks); $i++) {
            array_push($arr, ' 💢 ' . $banks[$i]->title);
            array_push($arr, ' 🔗 ' . $banks[$i]->guid);
            array_push($arr, '  ');
            if ($i != 0 && $i % 30 == 0) {
                SendTelegramMessageAsHTML(appendTexts($arr));
                $arr = array();
                array_push($arr, ' 💠 ' . 'فرصت های استخدامی بانک ها');
                array_push($arr, '  ');
                array_push($arr, ' ⏱ ' . 'زمان ارسال: ' . $date->getYear() . '/' . $date->getMonth() . '/' . $date->getDay());
                array_push($arr, '  ');
            } else if ($i == count($banks) - 1) {
                SendTelegramMessageAsHTML(appendTexts($arr));
            }
        }

    }

    public function getAllGovernmentalHiring()
    {
        $banks = GovernmentAgency::all();
        $arr = array();
        $date = Jalalian::forge('today');

        array_push($arr, ' 💠 ' . 'فرصت های استخدامی موسسات دولتی');
        array_push($arr, '  ');
        array_push($arr, ' ⏱ ' . 'زمان ارسال: ' . $date->getYear() . '/' . $date->getMonth() . '/' . $date->getDay());
        array_push($arr, '  ');

        for ($i = 0; $i < count($banks); $i++) {
            array_push($arr, ' 💢 ' . $banks[$i]->title);
            array_push($arr, ' 🔗 ' . $banks[$i]->guid);
            array_push($arr, '  ');
            if ($i != 0 && $i % 30 == 0) {
                SendTelegramMessageAsHTML(appendTexts($arr));
                $arr = array();
                array_push($arr, ' 💠 ' . 'فرصت های استخدامی موسسات دولتی');
                array_push($arr, '  ');
                array_push($arr, ' ⏱ ' . 'زمان ارسال: ' . $date->getYear() . '/' . $date->getMonth() . '/' . $date->getDay());
                array_push($arr, '  ');
            } else if ($i == count($banks) - 1) {
                SendTelegramMessageAsHTML(appendTexts($arr));
            }
        }

    }

}
