<?php

namespace App\Http\Controllers;

use App\Http\Repository\User\UserRepository;
use App\Http\Traits\MessageKeywordIncomingHandlerTrait;
use App\Http\Traits\MessageTrait;
use App\Http\Traits\SearchJobOffersTrait;
use App\Models\EducationField;
use App\Models\JobField;
use App\Models\State;
use App\Models\User;
use App\Models\UserAutomaticSubscription;
use Database\Seeders\UserAutomaticSubscriptionSeeder;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Telegram\Bot\Laravel\Facades\Telegram;
use function App\Helpers\getOptions;
use function App\Helpers\SendIntroVideo;
use function App\Helpers\SendTelegramMessage;
use function Symfony\Component\Translation\t;

class TelegramController extends Controller
{

    use MessageTrait;
    use MessageKeywordIncomingHandlerTrait;
    use SearchJobOffersTrait;

    protected $showMessage = true;

    public function setWebHook()
    {
        return Telegram::setWebHook(['url' => env('Bot_Handle_Base_URL') . env('BOT_TOKEN') . env('BOT_Handle_Messages_Route')]);
        if (getOptions('bot_auth_key')) {

        } else {
            return "Failed to set web hook";
        }

    }

    public function removeWebhook()
    {
        if (getOptions('bot_auth_key')) {
            return Telegram::deleteWebhook();
        } else {
            return "Failed to remove web hook";
        }
    }

    public function handleIncomingBotMessages(Request $request)
    {
//        if (request('message.chat.id') != "234087022") {
//            SendTelegramMessage("Under Construction");
//            return;
//        }
        try {
            Log::debug(\request());
            if (Str::startsWith(request('message.text'), $this->GetStartKeyword())) {
                $this->sendStartMessage();
            } else {
                $currentUser = DB::table('users')->where('chat_id', request('message.from.id'))->first();
                if ($currentUser == null) {
                    if (request('message.chat.username') != null) {
                        $currentUser = DB::table('users')->where('user_name', request('message.chat.username'))->first();
                    }
                }
                if ($currentUser != null) {
                    if ($this->IsUserBlocked($currentUser)) {
                        $this->SendBlockedUser();
                    } ######### First Selection ##########

                    else if ($this->IsDisableSubscriptionSelected($currentUser)) {
                        $this->ShowSubscriptionMainMenuDisable();
                    } else if ($this->IsSubscriptionSelected($currentUser)) {
                        $this->handleSubscriptionSelected($currentUser);
                    } else if ($this->IsStatesListSelected($currentUser)) {
                        $this->ShowStatesListMenu();
                    } else if ($this->IsStateSelected($currentUser)) {
                        $this->ShowGenderSelectionMenu();
                    } else if ($this->IsGenderSelected($currentUser)) {
                        $this->ShowWorkTimeModeMenu();
                    } else if ($this->IsWorkTimeSelected($currentUser)) {
                        $this->ShowJobModeMenu();
                    } else if ($this->IsJobModeSelected($currentUser)) {
                        $this->ShowExperienceMenu();
                    } else if ($this->IsExperienceSelected($currentUser)) {
                        $this->showSearchInJobstMessage();
                    } else if ($this->IsExperienceAmountSelected($currentUser)) {
                        $this->showSearchInJobstMessage();


                    } ####### First Job Selection ########
                    else if ($this->IsRetrySearchingInFirstStepJobSelected($currentUser)) {
                        $this->showSearchInJobstMessage();
                    } else if ($this->IsSearchInJobsSelected($currentUser)) {
                        $this->SearchJobsListMenu();
                    }
                   /* else if ($this->IsUserSearchingJobField($currentUser)) {
                        $this->SearchJobsListMenuShowItem();
                    } */
                    else if ($this->IsJobFieldSelected($currentUser)) {
                        $this->ContinueSelectingSecondJob();
                    }
                    ####### First Job Selection ########

                    //showSearchInEducationMessage))))((((

                    ####### Second Job Selection ########
                    else if ($this->IsContinueSubmittingSecondJobSelected($currentUser)) {
                        $this->showSearchInJobstMessageSecond();
                    } else if ($this->IsRetrySearchingInSecondStepJobSelected($currentUser)) {
                        $this->showSearchInJobstMessageSecond();
                    } else if ($this->IsSearchInJobsSelectedSecond($currentUser)) {
                        $this->SearchJobsListMenuSecond();
                    }
                 /*   else if ($this->IsUserSearchingJobFieldSecond($currentUser)) {
                        $this->SearchJobsListMenuShowItemSecond();
                    }*/
                    else if ($this->IsJobFieldSelectedSecond($currentUser)) {
                        $this->ContinueSelectingThirdJob();
                    } ####### Second Job Selection ########

                    ####### Third Job Selection ########
                    else if ($this->IsContinueSubmittingThirdJobSelected($currentUser)) {
                        $this->showSearchInJobstMessageThird();
                    } else if ($this->IsRetrySearchingInThirdStepJobSelected($currentUser)) {
                        $this->showSearchInJobstMessageThird();
                    } else if ($this->IsSearchInJobsSelectedThird($currentUser)) {
                        $this->SearchJobsListMenuThird();
                    }
                 /*   else if ($this->IsUserSearchingJobFieldThird($currentUser)) {
                        $this->SearchJobsListMenuShowItemThird();
                    }*/
                    else if ($this->IsJobFieldSelectedThird($currentUser)) {
                        $this->showSearchInEducationMessage();
                    } else if ($this->DismissSecondAndThirdJobSelection($currentUser)) {
                        $this->showSearchInEducationMessage();
                    } ####### Third Job Selection ########


                    ######## First Step Education ##########
                    else if ($this->IsRetrySearchingInFirstStepEducationSelected($currentUser)) {
                        $this->showSearchInEducationMessage();
                    }
                    else if ($this->IsSearchInEducationSelected($currentUser)) {
                        $this->SearchInEducationsMenu();
                    }
                    else if ($this->IsUserSearchingEducation($currentUser)) {
                        $this->SearchEducationsListMenuShowItem();
                    }
                    else if ($this->IsEducationFieldSelected($currentUser)) {
                        $this->ContinueSelectingSecondEducation();
                    }

                    ######## First Step Education ##########



                    ######## Second Step Education ##########
                    else if ($this->IsContinueSubmittingSecondEducationSelected($currentUser)) {
                        $this->showSearchInEducationMessageSecond();
                    } else if ($this->IsRetrySearchingInSecondStepEducationSelected($currentUser)) {
                        $this->showSearchInEducationMessageSecond();
                    } else if ($this->IsSearchInEducationSelectedSecond($currentUser)) {
                        $this->SearchInEducationsMenuSecond();
                    }
                    else if ($this->IsEducationFieldSelectedSecond($currentUser)) {
                        $this->ContinueSelectingThirdEducation();
                    }
                    ######## Second Step Education ##########



                    ######## Third Step Education ##########
                    else if ($this->IsContinueSubmittingThirdEducationSelected($currentUser)) {
                        $this->showSearchInEducationMessageThird();
                    } else if ($this->IsRetrySearchingInThirdStepEducationSelected($currentUser)) {
                        $this->showSearchInEducationMessageThird();
                    } else if ($this->IsSearchInEducationSelectedThird($currentUser)) {
                        $this->SearchInEducationsMenuThird();
                    }
                    else if ($this->IsEducationFieldSelectedThird($currentUser)) {
                        $this->ShowMaghteTahsili();
                    }
                    else if ($this->DismissSecondAndThirdEducationSelection($currentUser)) {
                        $this->ShowMaghteTahsili();
                    }
                    ######## Third Step Education ##########

                     else if ($this->IsMaghtaSelected($currentUser)) {
                        $this->handleSubscriptionSelected($currentUser);
                    }
                    ######### First Selection ##########

                    ######### Second Selection  ##########

//                    else if ($this->IsSecondSelectionSelected($currentUser)) {
//                        $this->showSearchInJobstMessageSecond();
//                    } else if ($this->IsSearchInJobsSelectedSecond($currentUser)) {
//                        $this->SearchJobsListMenuSecond();
//                    } else if ($this->IsJobFieldSelectedSecond($currentUser)) {
//                        $this->showSearchInEducationMessageSecond();
//                    } else if ($this->IsSearchInEducationSelectedSecond($currentUser)) {
//                        $this->SearchInEducationsMenuSecond();
//                    } else if ($this->IsEducationFieldSelectedSecond($currentUser)) {
//                        $this->ShowSuccessfulAndChooseSecondThird();
//                    }
                    ######### Second Selection ##########

                    ####### Third Selection #########
//                    else if ($this->IsThirdSelectionSelected($currentUser)) {
//                        $this->showSearchInJobstMessageThird();
//                    } else if ($this->IsSearchInJobsSelectedThird($currentUser)) {
//                        $this->SearchJobsListMenuThird();
//                    } else if ($this->IsJobFieldSelectedThird($currentUser)) {
//                        $this->showSearchInEducationMessageThird();
//                    } else if ($this->IsSearchInEducationSelectedThird($currentUser)) {
//                        $this->SearchInEducationsMenuThird();
//                    } else if ($this->IsEducationFieldSelectedThird($currentUser)) {
//                        $this->ShowSuccessfulThirdStepAndFinish();
//                    }
                    ####### Third Selection #########


                    ####### Search Selection #########
                    else if ($this->trySearchingAgainSelected($currentUser)) {
                        $this->ShowSearchMessage();
                    } else if ($this->IsSearchButtonSelected($currentUser)) {
                        $this->ShowSearchMessage();
                    } else if ($this->IsUserSearching($currentUser)) {
                        $this->search(request('message.text'), $currentUser);
                    } else if ($this->IsNextPageInSearchSelected($currentUser)) {
                        $this->nextPage($currentUser);
                    } else if ($this->IsPreviousPageInSearchSelected($currentUser)) {
                        $this->previousPage($currentUser);
                    }
                    ####### Search Selection #########

                    ####### Back And Governmental Selection #########

                    else if ($this->IsBanksAndGovernmentHiringMenuSelected($currentUser)) {
                        $this->BanksAndGovernmentsHiringMessage();
                    } else if ($this->IsBanksHiringSelected($currentUser)) {
                        $this->getAllBanksHiring();
                    } else if ($this->IsGovernmentHiringSelected($currentUser)) {
                        $this->getAllGovernmentalHiring();
                    }
                    ####### Back And Governmental Selection #########

                    ####### Other Services #########

                    else if ($this->IsRegisterInVirtualJobFinderSelected($currentUser)) {
                        SendTelegramMessage(getOptions('virtual_finding_job'), $this->mainMenuKeyboard());
                    } else if ($this->IsSubmitJobForEmployersSelected($currentUser)) {
                        SendTelegramMessage(getOptions('employers_submit_job_offer'), $this->mainMenuKeyboard());
                    } else if ($this->IsOtherOptionsSelected($currentUser)) {
                        $this->sendOtherOptionsMessage();
                    } else if ($this->IsMainWebSiteSelected($currentUser)) {
                        $this->sendMainWebSiteMessage();
                    } else if ($this->IsDownloadSelected($currentUser)) {
                        $this->SendApplicationUrl();
                    } else if ($this->IsCreateCvSelected($currentUser)) {
                        $this->SendMetaOption('create_cv');
                    } else if ($this->IsQuestionsSampleSelected($currentUser)) {
                        $this->SendMetaOption('hiring_questions_example');
                    } else if ($this->IsBooksSelected($currentUser)) {
                        $this->SendMetaOption('hiring_sample_books');
                    } else if ($this->IsIntroduceVideoSelected($currentUser)) {
                        SendIntroVideo();
                    } else if ($this->IsContactUsSelected($currentUser)) {
                        $this->SendMetaOption('contact_us');
                    } ####### Other Services #########
                    else if ($this->ResetSubscriptionSelected($currentUser)) {
                        $this->ShowStatesListMenu();
                    }
                    else if ($this->FinishSelectionSelected($currentUser)) {
                        $this->sendStartMenuMessageOnNavigateBack();
                    }else if (request('message.text') == $this->ReturnKey()) {
                        $this->BackButtonPressed($currentUser);
                    }


                } else {
                    SendTelegramMessage("هیچ پاسخی برای درخواست شما یافت نشد.");
                }
            }

        } catch (Exception $e) {
            Log::debug("Exception  : " . $e);
        }

    }

    private function FinishSelectionSelected($currentUser): bool
    {
        if ($currentUser->step == "subscription_menu_first_step_done" || $currentUser->step == "subscription_menu"
            && request('message.text') == $this->FinishSelection()) {

            return true;
        }
        return false;
    }
    private function ResetSubscriptionSelected($currentUser): bool
    {
        if ($currentUser->step == "subscription_menu_first_step_done"
            && request('message.text') == $this->ResetAutomaticSubscription()) {

            return true;
        }
        return false;
    }

    private function IsUserBlocked($currentUser): bool
    {
        return $currentUser->status == "block";
    }

    private function IsSubscriptionSelected($user)
    {
        return request('message.text') == $this->GetSubscriptionKey() && $user->step == "start_menu";
    }

    private function IsDisableSubscriptionSelected($user)
    {
        return request('message.text') == $this->DisableSubscription() && $user->step == "subscription_menu";
    }

    private function DismissSecondAndThirdJobSelection($user): bool
    {
        if ($user->step == "subscription_menu_ask_second_job" && request('message.text') == $this->NoSelection()) {
            return true;
        } else if ($user->step == "subscription_menu_ask_third_job" && request('message.text') == $this->NoSelection()) {
            return true;
        } else {
            return false;
        }
    }

    private function DismissSecondAndThirdEducationSelection($user): bool
    {
        if ($user->step == "subscription_menu_ask_second_education" && request('message.text') == $this->NoSelection()) {
            return true;
        } else if ($user->step == "subscription_menu_ask_third_education" && request('message.text') == $this->NoSelection()) {
            return true;
        } else {
            return false;
        }
    }

    private function IsStatesListSelected($user): bool
    {
        if (request('message.text') == $this->SelectStateKey() ||request('message.text') == $this->RetrySet() && $user->step == "subscription_menu") {

            return true;
        } else {
            return false;
        }
    }

    private function IsStateSelected($currentUser): bool
    {
        if ($currentUser->step == "subscription_menu_state" && request('message.text') != $this->ReturnKey()) {
            $search = State::where('title', request('message.text'))->first();
            $this->storeStateSelection($currentUser, $search);
            return (bool)$search;
        }
        return false;

    }

    private function IsGenderSelected($currentUser): bool
    {
        if ($currentUser->step == "subscription_menu_gender") {
            if (request('message.text') == $this->MaleKey() || request('message.text') == $this->FemaleKey() || request('message.text') == $this->NotMatter()) {
                $this->storeGenderSelection($currentUser, request('message.text'));
                return true;
            } else {
                return false;
            }

        }
        return false;

    }

    private function IsWorkTimeSelected($currentUser): bool
    {
        if ($currentUser->step == "subscription_menu_work_time") {
            if (request('message.text') == $this->FullTime() || request('message.text') == $this->PartTime() || request('message.text') == $this->NotMatter()) {
                $this->storeWorkTime($currentUser, request('message.text'));
                return true;
            } else {
                return false;
            }

        }
        return false;

    }

    private function IsJobModeSelected($currentUser): bool
    {
        if ($currentUser->step == "subscription_menu_job_mode") {

            if (request('message.text') == $this->InPlaceButton() || request('message.text') == $this->RemoteWorkButton()
                || request('message.text') == $this->NewBieLearnerButton() || request('message.text') == $this->StudentButton()
                || request('message.text') == $this->RetiredButton() || request('message.text') == $this->NotMatter()) {
                $this->storeWorkMode($currentUser, request('message.text'));
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    private function IsExperienceSelected($currentUser): bool
    {
        if ($currentUser->step == "subscription_menu_experience") {
            if (request('message.text') == $this->NeedExperience()) {
                $this->storeExperience($currentUser, request('message.text'));
                $this->ShowAmountOfExperience();
                return false;
            } else {
                $this->storeExperience($currentUser, request('message.text'));
                return request('message.text') == $this->NoExperience() || request('message.text') == $this->NotMatter();
            }

        }
        return false;
    }

    private function IsExperienceAmountSelected($currentUser): bool
    {
        if ($currentUser->step == "subscription_menu_experience_amount") {
            if (request('message.text') == $this->OneYear() || request('message.text') == $this->TwoYears()
                || request('message.text') == $this->ThreeYears() || request('message.text') == $this->FourYears()
                || request('message.text') == $this->FiveToNineYears() || request('message.text') == $this->MoreThanTenYears()
                || request('message.text') == $this->NotHavingExperience()) {
                $this->storeExperienceValue($currentUser, request('message.text'));
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    private function IsSearchInJobsSelected($currentUser): bool
    {
        if ($currentUser->step == "subscription_menu_job_field_search" && request('message.text') != $this->ReturnKey()) {
            if (request('message.text') == $this->NotNeeded()) {
                $this->setJobValueToDefault($currentUser);
                $this->showSearchInEducationMessage();
                return false;
            } else {
                return true;
            }
        }
        return false;
    }

    private function IsRetrySearchingInFirstStepJobSelected($currentUser): bool
    {
        return $currentUser->step == "subscription_menu_job_field_searching" && request('message.text') == $this->RetrySelection();
    }
    private function IsRetrySearchingInFirstStepEducationSelected($currentUser): bool
    {
        return $currentUser->step == "subscription_menu_education_field_searching" && request('message.text') == $this->RetrySelection();
    }

    private function IsRetrySearchingInSecondStepJobSelected($currentUser): bool
    {
        return $currentUser->step == "subscription_menu_job_field_searching_second" && request('message.text') == $this->RetrySelection();
    }
    private function IsRetrySearchingInSecondStepEducationSelected($currentUser): bool
    {
        return $currentUser->step == "subscription_menu_education_field_searching_second" && request('message.text') == $this->RetrySelection();
    }
    private function IsRetrySearchingInThirdStepEducationSelected($currentUser): bool
    {
        return $currentUser->step == "subscription_menu_education_field_searching_third" && request('message.text') == $this->RetrySelection();
    }

    private function IsRetrySearchingInThirdStepJobSelected($currentUser): bool
    {
        return $currentUser->step == "subscription_menu_job_field_searching_third" && request('message.text') == $this->RetrySelection();
    }


    private function IsUserSearchingJobField($currentUser): bool
    {
        if ($currentUser->step == "subscription_menu_job_field_search" && request('message.text') != $this->ReturnKey()) {
            if (request('message.text') == $this->NotNeeded()) {
                $this->setJobValueToDefault($currentUser);
                $this->showSearchInEducationMessage();
                return false;
            } else {
                return true;
            }
        }
        return false;
    }

    private function IsUserSearchingEducation($currentUser): bool
    {
        if ($currentUser->step == "subscription_menu_education_field_searching" && request('message.text') != $this->ReturnKey()) {
            if (request('message.text') == $this->NotNeeded()) {
                $this->setEducationToDefault($currentUser);
                $this->ShowMaghteTahsili();

                return false;
            } else {
                return true;
            }
        }
        return false;
    }




    private function IsJobFieldSelected($currentUser): bool
    {
        if ($currentUser->step == "subscription_menu_job_field" && request('message.text') != $this->ReturnKey()) {
            $existsJobField = JobField::where('title', request('message.text'))->first();

            if ($existsJobField == null) {
                $this->showMessage = false;
                $this->SearchJobsListMenu();
                return false;
            } else {
                $this->storeJobValue($currentUser, $existsJobField);
                return true;
            }
        }
        return false;
    }

    private function IsJobFieldSelectedSecond($currentUser): bool
    {
        if ($currentUser->step == "subscription_menu_job_field_second" && request('message.text') != $this->ReturnKey()) {
            $existsJobField = JobField::where('title', request('message.text'))->first();

            if ($existsJobField == null) {
                $this->showMessage = false;
                $this->SearchJobsListMenuSecond();
                return false;
            } else {
                $this->storeJobValueSecond($currentUser, $existsJobField);
                return true;
            }
        }
        return false;
    }

    private function IsJobFieldSelectedThird($currentUser): bool
    {
        if ($currentUser->step == "subscription_menu_job_field_third" && request('message.text') != $this->ReturnKey()) {
            $existsJobField = JobField::where('title', request('message.text'))->first();
            Log::debug('Third Job Field Selected');
            if ($existsJobField == null) {
                $this->showMessage = false;
                $this->SearchJobsListMenuThird();
                return false;
            } else {
                Log::debug('Third Job Field Selected ---> '.$existsJobField);
                $this->storeJobValueThird($currentUser, $existsJobField);
                return true;
            }
        }
        return false;
    }

    private function IsContinueSubmittingSecondJobSelected($currentUser): bool
    {
        return $currentUser->step == "subscription_menu_ask_second_job" && request('message.text') != $this->ReturnKey()
            && request('message.text') == $this->YesSelection();
    }
    private function IsContinueSubmittingSecondEducationSelected($currentUser): bool
    {
        return $currentUser->step == "subscription_menu_ask_second_education" && request('message.text') != $this->ReturnKey()
            && request('message.text') == $this->YesSelection();
    }

    private function IsContinueSubmittingThirdEducationSelected($currentUser): bool
    {
        return $currentUser->step == "subscription_menu_ask_third_education" && request('message.text') != $this->ReturnKey()
            && request('message.text') == $this->YesSelection();
    }

    private function IsContinueSubmittingThirdJobSelected($currentUser): bool
    {
        return $currentUser->step == "subscription_menu_ask_third_job" && request('message.text') != $this->ReturnKey()
            && request('message.text') == $this->YesSelection();
    }


    private function IsEducationFieldSelected($currentUser): bool
    {
        if ($currentUser->step == "subscription_menu_education_field" && request('message.text') != $this->ReturnKey()) {
            $existsJobField = EducationField::where('title', request('message.text'))->first();

            if ($existsJobField == null) {
                $this->showMessage = false;
                $this->SearchInEducationsMenu();
                return false;
            } else {
                $this->storeEducationValue($currentUser, $existsJobField);
                return true;
            }
        }
        return false;
    }

    private function IsSearchInEducationSelected($currentUser): bool
    {
        if ($currentUser->step == "subscription_menu_education_field_search" && request('message.text') != $this->ReturnKey()) {
            if (request('message.text') == $this->NotNeeded()) {
                $this->setEducationToDefault($currentUser);
                $this->ShowMaghteTahsili();
                return false;
            } else {
                return true;
            }
        }
        return false;
    }


    private function IsMaghtaSelected($currentUser): bool
    {
        if ($currentUser->step == "subscription_menu_maghta" && request('message.text') != $this->ReturnKey()) {

            if (request('message.text') == $this->UnderDiploma() || request('message.text') == $this->Diploma()
                || request('message.text') == $this->AboveDiploma() || request('message.text') == $this->Bachelor()
                || request('message.text') == $this->MA() || request('message.text') == $this->PHD() || request('message.text') == $this->NotMatter()) {
                $this->storeGrade($currentUser, request('message.text'));
                return true;
            } else return false;
        }
        return false;
    }



    private function IsThirdSelectionSelected($currentUser): bool
    {
        return $currentUser->step == "subscription_menu_second_step_done" && request('message.text') == $this->Continue();

    }


    private function IsSearchButtonSelected($currentUser): bool
    {
        return $currentUser->step == "start_menu" && request('message.text') == $this->SearchAmongAll();
    }


    private function trySearchingAgainSelected($currentUser): bool
    {
        return $currentUser->step == "search_menu" && request('message.text') == $this->NewKeyWord();
    }


    private function IsUserSearching($currentUser): bool
    {
        if ($currentUser->step == "search_menu") {
            if (request('message.text') == $this->NextRecords() || request('message.text') == $this->PreviousRecords() || request('message.text') == $this->ReturnKey()) {
                return false;
            } else {
                return true;
            }
        }
        return false;
    }

    private function IsNextPageInSearchSelected($currentUser): bool
    {
        return $currentUser->step == "search_menu" && request('message.text') == $this->NextRecords();
    }

    private function IsPreviousPageInSearchSelected($currentUser): bool
    {
        return $currentUser->step == "search_menu" && request('message.text') == $this->PreviousRecords();

    }

    ########## Store User Selection ##########
    private function storeStateSelection($currentUser, $state)
    {
        UserAutomaticSubscription::updateOrCreate(
            ['user_id' => $currentUser->id],
            ["user_id" => $currentUser->id,
                "state_id" => $state->cat_id]
        );

    }

    private function storeGenderSelection($currentUser, $gender)
    {
        $id = 8595100;
        if ($gender == $this->MaleKey()) {
            $id = 76399;

        } else if ($gender == $this->FemaleKey()) {
            $id = 76400;

        }
        $subscription = User::find($currentUser->id);
        $subscription->AutomaticSelection->gender_id = $id;
        $subscription->AutomaticSelection->save();

    }

    private function storeWorkTime($currentUser, $workTime)
    {
        $id = 8595200;
        if ($workTime == $this->FullTime()) {
            $id = 1021031;

        } else if ($workTime == $this->PartTime()) {
            $id = 85293;

        } else if ($workTime == $this->NotMatter()) {
            $id = 8595200;

        }
        $subscription = User::find($currentUser->id);
        $subscription->AutomaticSelection->work_time_id = $id;
        $subscription->AutomaticSelection->save();

    }

    private function storeWorkMode($currentUser, $jobMode)
    {
        $id = 8595300;
        if ($jobMode == $this->InPlaceButton()) {
            $id = 1021032;

        } else if ($jobMode == $this->RemoteWorkButton()) {
            $id = 85293;
        } else if ($jobMode == $this->NewBieLearnerButton()) {
            $id = 78191;
        } else if ($jobMode == $this->StudentButton()) {
            $id = 13558;
        } else if ($jobMode == $this->RetiredButton()) {
            $id = 16388;
        } else if ($jobMode == $this->NotMatter()) {
            $id = 8595300;
        }
        $subscription = User::find($currentUser->id);
        $subscription->AutomaticSelection->work_mode_id = $id;
        $subscription->AutomaticSelection->save();

    }

    private function storeExperience($currentUser, $experience)
    {
        $id = 8595300;
        if ($experience == $this->NeedExperience()) {
            $id = 8595400;

        } else if ($experience == $this->NoExperience()) {
            $id = 1021033;
        } else if ($experience == $this->NotMatter()) {
            $id = 8595400;
        }
        $subscription = User::find($currentUser->id);
        $subscription->AutomaticSelection->experience_type_id = $id;
        $subscription->AutomaticSelection->save();

    }

    private function storeExperienceValue($currentUser, $experienceAmount)
    {
        $id = 8595300;
        if ($experienceAmount == $this->OneYear()) {
            $id = 1022031;
        } else if ($experienceAmount == $this->TwoYears()) {
            $id = 1022032;
        } else if ($experienceAmount == $this->ThreeYears()) {
            $id = 1022033;
        } else if ($experienceAmount == $this->FourYears()) {
            $id = 1022034;
        } else if ($experienceAmount == $this->FiveToNineYears()) {
            $id = 1022035;
        } else if ($experienceAmount == $this->MoreThanTenYears()) {
            $id = 1022036;
        } else if ($experienceAmount == $this->NotHavingExperience()) {
            $id = 1021033;
        }
        $subscription = User::find($currentUser->id);
        $subscription->AutomaticSelection->experience_type_id = $id;
        $subscription->AutomaticSelection->experience_time_id = $id;
        $subscription->AutomaticSelection->save();

    }

    private function setJobValueToDefault($currentUser)
    {
        $subscription = User::find($currentUser->id);
        $subscription->AutomaticSelection->job_id = 8595600;
        $subscription->AutomaticSelection->save();
    }

    private function setJobValueToDefaultSecond($currentUser)
    {
        $subscription = User::find($currentUser->id);
        $subscription->AutomaticSelection->second_job_id = 8595800;
        $subscription->AutomaticSelection->save();
    }

    private function setJobValueToDefaultThird($currentUser)
    {
        $subscription = User::find($currentUser->id);
        $subscription->AutomaticSelection->second_job_id = 8595100;
        $subscription->AutomaticSelection->save();
    }

    private function storeJobValue($currentUser, $job)
    {
        $subscription = User::find($currentUser->id);
        $subscription->AutomaticSelection->job_id = $job->cat_id;
        $subscription->AutomaticSelection->save();

    }

    private function storeJobValueSecond($currentUser, $job)
    {
        $subscription = User::find($currentUser->id);
        $subscription->AutomaticSelection->second_job_id = $job->cat_id;
        $subscription->AutomaticSelection->save();

    }

    private function storeJobValueThird($currentUser, $job)
    {
        $subscription = User::find($currentUser->id);
        $subscription->AutomaticSelection->third_job_id = $job->cat_id;
        $subscription->AutomaticSelection->save();

    }

    private function setEducationToDefault($currentUser)
    {
        $subscription = User::find($currentUser->id);
        $subscription->AutomaticSelection->education_id = 8595700;
        $subscription->AutomaticSelection->save();
    }

    private function setEducationToDefaultSecond($currentUser)
    {
        $subscription = User::find($currentUser->id);
        $subscription->AutomaticSelection->second_education_id = 8595900;
        $subscription->AutomaticSelection->save();
    }

    private function setEducationToDefaultThird($currentUser)
    {
        $subscription = User::find($currentUser->id);
        $subscription->AutomaticSelection->third_education_id = 859511000;
        $subscription->AutomaticSelection->save();
    }

    private function storeEducationValue($currentUser, $education)
    {
        $subscription = User::find($currentUser->id);
        $subscription->AutomaticSelection->education_id = $education->cat_id;
        $subscription->AutomaticSelection->save();

    }

    private function storeEducationValueSecond($currentUser, $education)
    {
        $subscription = User::find($currentUser->id);
        $subscription->AutomaticSelection->second_education_id = $education->cat_id;
        $subscription->AutomaticSelection->save();

    }

    private function storeEducationValueThird($currentUser, $education)
    {
        $subscription = User::find($currentUser->id);
        $subscription->AutomaticSelection->third_education_id = $education->cat_id;
        $subscription->AutomaticSelection->save();

    }


    private function storeGrade($currentUser, $gradeSelection)
    {
        $id = 8595500;
        if ($gradeSelection == $this->NotMatter()) {
            $id = 8595500;
        } else if ($gradeSelection == $this->UnderDiploma()) {
            $id = 21891;
        } else if ($gradeSelection == $this->Diploma()) {
            $id = 21892;
        } else if ($gradeSelection == $this->AboveDiploma()) {
            $id = 21893;
        } else if ($gradeSelection == $this->Bachelor()) {
            $id = 21894;
        } else if ($gradeSelection == $this->MA()) {
            $id = 21895;
        } else if ($gradeSelection == $this->PHD()) {
            $id = 21896;
        }
        $subscription = User::find($currentUser->id);
        $subscription->AutomaticSelection->grade_id = $id;
        $subscription->AutomaticSelection->save();
    }


    ########## Store User Selection ##########


    //region Second Step

    private function IsSearchInJobsSelectedSecond($currentUser): bool
    {

        if ($currentUser->step == "subscription_menu_job_field_search_second" && request('message.text') != $this->ReturnKey()) {
            if (request('message.text') == $this->NotNeeded()) {
                $this->setJobValueToDefaultSecond($currentUser);
                $this->showSearchInEducationMessage();
                return false;
            } else {
                return true;
            }
        }
        return false;
    }

    private function IsSearchInJobsSelectedThird($currentUser): bool
    {

        if ($currentUser->step == "subscription_menu_job_field_search_third" && request('message.text') != $this->ReturnKey()) {
            if (request('message.text') == $this->NotNeeded()) {
                $this->setJobValueToDefaultSecond($currentUser);
                $this->showSearchInEducationMessage();
                return false;
            } else {
                return true;
            }
        }
        return false;
    }

    private function IsSearchInEducationSelectedSecond($currentUser): bool
    {
        if ($currentUser->step == "subscription_menu_education_field_search_second" && request('message.text') != $this->ReturnKey()) {
            if (request('message.text') == $this->NotNeeded()) {
                $this->setEducationToDefaultSecond($currentUser);
                $this->ShowSuccessfulAndChooseSecondThird();
                return false;
            } else {
                return true;
            }
        }
        return false;
    }

//    private function IsJobFieldSelectedSecond($currentUser): bool
//    {
//        if ($currentUser->step == "subscription_menu_job_field_second" && request('message.text') != $this->ReturnKey()) {
//            $existsJobField = JobField::where('title', request('message.text'))->first();
//
//            if ($existsJobField == null) {
//                $this->showMessage = false;
//                $this->SearchJobsListMenuSecond();
//                return false;
//            } else {
//                $this->storeJobValueSecond($currentUser, $existsJobField);
//                return true;
//            }
//        }
//        return false;
//
//
//    }

    private function IsEducationFieldSelectedSecond($currentUser): bool
    {
        if ($currentUser->step == "subscription_menu_education_field_second" && request('message.text') != $this->ReturnKey()) {
            $existsJobField = EducationField::where('title', request('message.text'))->first();


            if ($existsJobField == null) {
                $this->showMessage = false;
                $this->SearchInEducationsMenuSecond();
                return false;
            } else {
                $this->storeEducationValueSecond($currentUser, $existsJobField);
                return true;
            }

        }
        return false;
    }

    //endregion

    //region Third Step


    private function IsSearchInEducationSelectedThird($currentUser): bool
    {
        if ($currentUser->step == "subscription_menu_education_field_search_third" && request('message.text') != $this->ReturnKey()) {
            if (request('message.text') == $this->NotNeeded()) {
                $this->setEducationToDefaultThird($currentUser);
                $this->ShowSuccessfulThirdStepAndFinish();
                return false;
            } else {
                return true;
            }
        }
        return false;
    }


    private function IsEducationFieldSelectedThird($currentUser): bool
    {
        if ($currentUser->step == "subscription_menu_education_field_third" && request('message.text') != $this->ReturnKey()) {
            $existsJobField = EducationField::where('title', request('message.text'))->first();


            if ($existsJobField == null) {
                $this->showMessage = false;
                $this->SearchInEducationsMenuThird();
                return false;
            } else {
                $this->storeEducationValueThird($currentUser, $existsJobField);
                return true;
            }

        }
        return false;
    }

    //endregion

    //region Govern and banks hiring


    public function IsBanksAndGovernmentHiringMenuSelected($currentUser): bool
    {
        return $currentUser->step == "start_menu" && request('message.text') == $this->GovernmentsAdBanksHiring();

    }

    public function IsBanksHiringSelected($currentUser): bool
    {
        return $currentUser->step == "govern_bank_hiring_menu" && request('message.text') == $this->BanksHiring() && request('message.text') != $this->ReturnKey();

    }

    public function IsGovernmentHiringSelected($currentUser): bool
    {
        return $currentUser->step == "govern_bank_hiring_menu" && request('message.text') == $this->GovernmentalHiring() && request('message.text') != $this->ReturnKey();

    }

    //endregion

    //region Main Options
    public function IsRegisterInVirtualJobFinderSelected($currentUser): bool
    {
        return $currentUser->step == "start_menu" && request('message.text') == $this->RegisterInVirtualJobFinding() && request('message.text') != $this->ReturnKey();


    }

    public function IsSubmitJobForEmployersSelected($currentUser): bool
    {
        return $currentUser->step == "start_menu" && request('message.text') == $this->SubmitJobOffersForEmployer() && request('message.text') != $this->ReturnKey();


    }

    public function IsOtherOptionsSelected($currentUser): bool
    {
        return $currentUser->step == "start_menu" && request('message.text') == $this->OtherIranEstekhdamServices() && request('message.text') != $this->ReturnKey();


    }

    public function IsMainWebSiteSelected($currentUser): bool
    {
        return $currentUser->step == "other_option_menu" && request('message.text') == $this->GoToMainWebSite() && request('message.text') != $this->ReturnKey();


    }

    public function IsDownloadSelected($currentUser): bool
    {
        return $currentUser->step == "other_option_menu" && request('message.text') == $this->Application() && request('message.text') != $this->ReturnKey();


    }


    private function IsCreateCvSelected($currentUser): bool
    {
        return $currentUser->step == "other_option_menu" && request('message.text') == $this->CreateAndReceiveCV() && request('message.text') != $this->ReturnKey();

    }

    private function IsQuestionsSampleSelected($currentUser): bool
    {
        return $currentUser->step == "other_option_menu" && request('message.text') == $this->HiringQuestionsSample() && request('message.text') != $this->ReturnKey();

    }

    private function IsBooksSelected($currentUser): bool
    {
        return $currentUser->step == "other_option_menu" && request('message.text') == $this->HiringBooksAndQuestion() && request('message.text') != $this->ReturnKey();

    }

    private function IsIntroduceVideoSelected($currentUser): bool
    {
        return $currentUser->step == "other_option_menu" && request('message.text') == $this->IntoduceIranEstekhdam() && request('message.text') != $this->ReturnKey();

    }

    private function IsContactUsSelected($currentUser): bool
    {
        return $currentUser->step == "other_option_menu" && request('message.text') == $this->ContactUs() && request('message.text') != $this->ReturnKey();


    }

    //endregion

    private function BackButtonPressed($currentUser)
    {
        switch ($currentUser->step) {
            case "search_menu":
            case "subscription_menu":
            case "govern_bank_hiring_menu":
            case "other_option_menu":
            case "subscription_menu_state":
                $this->sendStartMenuMessageOnNavigateBack();
                break;
            case "subscription_menu_gender":
                $this->ShowStatesListMenu();
                break;
            case "subscription_menu_work_time":
                $this->ShowGenderSelectionMenu();
                break;
            case "subscription_menu_job_mode":
                $this->ShowWorkTimeModeMenu();
                break;
            case "subscription_menu_experience":
                $this->ShowJobModeMenu();
                break;
            case "subscription_menu_job_field_search":
            case "subscription_menu_experience_amount":
                $this->ShowExperienceMenu();
                break;
            case "subscription_menu_education_field_search":
            case "subscription_menu_job_field":
            case "subscription_menu_ask_second_job":
            case "subscription_menu_ask_third_job":
            case "subscription_menu_job_field_search_second":
            case "subscription_menu_job_field_search_third":
                $this->showSearchInJobstMessage();
                break;
            case "subscription_menu_maghta":
            case "subscription_menu_education_field":
            case "subscription_menu_ask_second_education":
            case "subscription_menu_ask_third_education":
            case "subscription_menu_education_field_searching":
                $this->showSearchInEducationMessage();
                break;

            case "subscription_menu_job_field_second":
                $this->ShowSuccessfulAndChooseSecond();
                break;
            case "subscription_menu_education_field_search_second":
            case "subscription_menu_education_field_second":
                $this->showSearchInJobstMessage();
                break;


            case "subscription_menu_education_field_search_third":
            case "subscription_menu_education_field_third":
                $this->showSearchInJobstMessageSecond();
                break;
        }

    }


}
