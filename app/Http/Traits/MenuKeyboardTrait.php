<?php


namespace App\Http\Traits;


use App\Models\EducationField;
use App\Models\JobField;
use App\Models\State;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Keyboard\Keyboard;
use function App\Helpers\getOptions;

trait MenuKeyboardTrait
{
    use MessageKeywordIncomingHandlerTrait;

    public function mainMenuKeyboard(): Keyboard
    {
        $items = [
            [$this->GetSubscriptionKey()],
            [$this->SearchAmongAll()],
            [$this->RegisterInVirtualJobFinding(), $this->GovernmentsAdBanksHiring()],
            [$this->OtherIranEstekhdamServices(), $this->SubmitJobOffersForEmployer()],
        ];
        return Keyboard::make([
            'keyboard' => $items,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);
    }

    public function subscriptionMainMenuSetSexKeyboard(): Keyboard
    {
        $items = [
            [$this->ReturnKey(),],
            [$this->FemaleKey(), $this->MaleKey()],
            [ $this->NotMatter()],

        ];
        return Keyboard::make([
            'keyboard' => $items,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }

    public function searchInJobsListKeyboard(): Keyboard
    {
        $items = [
            [$this->ReturnKey()],
            [$this->NotNeeded()],

        ];
        return Keyboard::make([
            'keyboard' => $items,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }

    public function searchInEducationListKeyboard(): Keyboard
    {
        $items = [
            [$this->ReturnKey()],
            [$this->NotNeeded()],

        ];
        return Keyboard::make([
            'keyboard' => $items,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }

    public function continueSubmittingKeyboard(): Keyboard
    {
        $items = [
            [$this->ReturnKey()],
            [$this->NoSelection(),$this->YesSelection()],

        ];
        return Keyboard::make([
            'keyboard' => $items,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }

    public function subscriptionMainMenuKeyboard(): Keyboard
    {
        $items = [
            [$this->FinishSelection(), $this->SelectStateKey()],

        ];
        return Keyboard::make([
            'keyboard' => $items,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }
    public function subscriptionMainMenuKeyboardWithActiveSelection(): Keyboard
    {
        $items = [
            [$this->FinishSelection(), $this->RetrySet()],

        ];
        return Keyboard::make([
            'keyboard' => $items,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }

    public function subscriptionMainMenuKeyboardEnabled(): Keyboard
    {
        $items = [
            [$this->ReturnKey()],
            [$this->SelectStateKey(), $this->DisableSubscription()],

        ];
        return Keyboard::make([
            'keyboard' => $items,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }

    public function banksAndGovernmentHiringKeyboard(): Keyboard
    {
        $items = [
            [$this->ReturnKey()],
            [$this->GovernmentalHiring(), $this->BanksHiring()],


        ];
        return Keyboard::make([
            'keyboard' => $items,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }

    public function subscriptionStateKeyboard(): Keyboard
    {

        $states = State::orderBy('title', 'Asc')->get();
        $keyboardItems = array();
        array_push($keyboardItems, [$this->ReturnKey()]);

        for ($i = 0; $i < sizeof($states); $i += 1) {
            if (sizeof($states) % 2 == 0) {

                array_push($keyboardItems, [$states[$i]->title, $states[$i += 1]->title]);
                if ($i == sizeof($states) - 1) {
                }

            } else {
                if ($i == sizeof($states) - 1) {
                    array_push($keyboardItems, [ $states[$i]->title]);
                } else {
                    array_push($keyboardItems, [$states[$i]->title, $states[++$i]->title]);
                }
            }
        }
        return Keyboard::make([
            'keyboard' => $keyboardItems,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }

    public function subscriptionMainMenuSetWorkTimeKeyboard(): Keyboard
    {
        $items = [
            [$this->ReturnKey()],
            [$this->PartTime(), $this->FullTime()],
            [$this->NotMatter()],

        ];
        return Keyboard::make([
            'keyboard' => $items,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }

    public function subscriptionJobModeKeyboard(): Keyboard
    {
        $items = [
            [$this->ReturnKey()],
            [$this->RemoteWorkButton(), $this->InPlaceButton()],
            [$this->StudentButton(), $this->NewBieLearnerButton()],
            [$this->NotMatter(), $this->RetiredButton()],

        ];
        return Keyboard::make([
            'keyboard' => $items,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }

    public function subscriptionJobExperienceKeyboard(): Keyboard
    {
        $items = [
            [$this->ReturnKey()],
            [$this->NeedExperience(), $this->NoExperience()],
            [$this->NotMatter()],

        ];
        return Keyboard::make([
            'keyboard' => $items,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }

    public function subscriptionMaghateTahsiliKeyboard(): Keyboard
    {
        $items = [
            [$this->ReturnKey()],
            [$this->Diploma(), $this->UnderDiploma()],
            [$this->Bachelor(), $this->AboveDiploma()],
            [$this->PHD(), $this->MA()],
            [ $this->NotMatter()],

        ];
        return Keyboard::make([
            'keyboard' => $items,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }

    public function firstStepSubmittedKeyboard(): Keyboard
    {
        $items = [
            [$this->FinishSelection(), $this->ResetAutomaticSubscription()],

        ];
        return Keyboard::make([
            'keyboard' => $items,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }

    public function AutoSubscriptionDone(): Keyboard
    {
        $items = [
            [$this->ReturnKey()],

        ];
        return Keyboard::make([
            'keyboard' => $items,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }


    public function searchKeyboard(): Keyboard
    {
        $items = [
            [$this->ReturnKey()],

        ];
        return Keyboard::make([
            'keyboard' => $items,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }

    public function otherOptionKeyboard(): Keyboard
    {
        $items = [
            [ $this->ReturnKey(),],
            [$this->Application(), $this->GoToMainWebSite()],
            [$this->HiringQuestionsSample(), $this->CreateAndReceiveCV()],
            [$this->IntoduceIranEstekhdam(), $this->HiringBooksAndQuestion()],
            [ $this->ContactUs()],

        ];
        return Keyboard::make([
            'keyboard' => $items,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }

    public function applicationDownloadUrlKeyboard(): Keyboard
    {

        return Keyboard::make()
            ->inline()
            ->row(
                Keyboard::inlineButton(['text' => 'دریافت از گوگل پلی', 'url' => getOptions('app_google_play')]),
                Keyboard::inlineButton(['text' => 'دریافت از بازار', 'url' => getOptions('app_bazar')]),
            );
    }

    public function subscriptionJobListKeyboard($search): Keyboard
    {

        $jobs = JobField::orWhere('title', 'like', '%' . $search . '%')->get();

        $keyboardItems = array();

        if ($jobs == null || $jobs->count() == 0) {
            array_push($keyboardItems, [$this->ReturnKey()]);
        } else {
            for ($i = 0; $i < sizeof($jobs); $i += 1) {
                if (sizeof($jobs) % 2 == 0) {

                    array_push($keyboardItems, [$jobs[$i]->title, $jobs[$i += 1]->title]);
                    if ($i == sizeof($jobs) - 1) {
                        array_push($keyboardItems, [$this->ReturnKey()]);
                    }

                } else {
                    if ($i == sizeof($jobs) - 1) {
                        array_push($keyboardItems, [$this->ReturnKey(), $jobs[$i]->title]);
                    } else {
                        array_push($keyboardItems, [$jobs[$i]->title, $jobs[++$i]->title]);
                    }
                }
            }
        }
        return Keyboard::make([
            'keyboard' => $keyboardItems,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }

    public function subscriptionEducationListKeyboard($keyword): Keyboard
    {

        $jobs = EducationField::orWhere('title', 'like', '%' . $keyword . '%')->get();
        $keyboardItems = array();
        if ($jobs == null || $jobs->count() == 0) {
            array_push($keyboardItems, [$this->ReturnKey()]);
        } else {
            for ($i = 0; $i < sizeof($jobs); $i += 1) {
                if (sizeof($jobs) % 2 == 0) {

                    array_push($keyboardItems, [$jobs[$i]->title, $jobs[$i += 1]->title]);
                    if ($i == sizeof($jobs) - 1) {
                        array_push($keyboardItems, [$this->ReturnKey()]);
                    }

                } else {
                    if ($i == sizeof($jobs) - 1) {
                        array_push($keyboardItems, [$this->ReturnKey(), $jobs[$i]->title]);
                    } else {
                        array_push($keyboardItems, [$jobs[$i]->title, $jobs[++$i]->title]);
                    }
                }
            }
        }
        return Keyboard::make([
            'keyboard' => $keyboardItems,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }

    public function amountOfExperienceOnPositiveSelectionKeyboard(): Keyboard
    {
        $items = [
            [$this->TwoYears(), $this->OneYear()],
            [$this->FourYears(), $this->ThreeYears()],
            [$this->MoreThanTenYears(), $this->FiveToNineYears()],
            [$this->ReturnKey(), $this->NotHavingExperience()],

        ];
        return Keyboard::make([
            'keyboard' => $items,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }

    public function searchWithNextButton(): Keyboard
    {
        $items = [
            [$this->ReturnKey(), $this->NextRecords()],

        ];
        return Keyboard::make([
            'keyboard' => $items,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }

    public function searchWithNextAndPreviousButton(): Keyboard
    {
        $items = [
            [$this->PreviousRecords(), $this->NextRecords()],
            [$this->ReturnKey()],

        ];
        return Keyboard::make([
            'keyboard' => $items,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }

    public function searchWithPreviousButton(): Keyboard
    {
        $items = [
            [$this->ReturnKey(), $this->PreviousRecords()],

        ];
        return Keyboard::make([
            'keyboard' => $items,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }

    public function searchWithReturnButton(): Keyboard
    {
        $items = [
            [$this->NewKeyWord()],
            [$this->ReturnKey()],

        ];
        return Keyboard::make([
            'keyboard' => $items,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }

    public function SearchSubscriptionAgain(): Keyboard
    {
        $items = [
            [$this->RetrySelection()],
            [$this->ReturnKey()],

        ];
        return Keyboard::make([
            'keyboard' => $items,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }

}


