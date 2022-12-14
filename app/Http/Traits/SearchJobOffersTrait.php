<?php


namespace App\Http\Traits;


use App\Jobs\ScheduleJobOffer;
use App\Models\EducationField;
use App\Models\JobOffer;
use App\Models\State;
use App\Models\User;
use App\Models\UserSearch;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Morilog\Jalali\Jalalian;
use Telegram\Bot\Keyboard\Keyboard;
use function App\Helpers\appendTexts;
use function App\Helpers\ConvertToUTF8;
use function App\Helpers\SendTelegramMessage;
use function App\Helpers\SendTelegramMessageAsHTMLWithUserId;
use function App\Helpers\SendTelegramMessageWithCustomUserId;
use function App\Helpers\SendTelegramMessageAsHTML;

trait SearchJobOffersTrait
{
    use MenuKeyboardTrait;

    public function search($keyword, $oldUser)
    {
        $user = User::find($oldUser->id);

        $skip = 0;
        $take = 5;
        $count = JobOffer::where('title', 'LIKE', '%' . $keyword . '%')->orderBy('id', 'desc')->count();
        if ($count == 0) {
            SendTelegramMessage($this->NoResultFound(), $this->searchWithReturnButton());

        } else {
            if ($user->Search != null) {
                $user->Search->current_page = 0;
                $skip = $user->Search->current_page * $take;
//                $user->Search->current_page += 1;
                $user->Search->keyword = $keyword;
                $user->Search->total_page = $count;
                $user->Search->save();
                $user->save();
            } else {
                UserSearch::create([
                    "user_id" => $user->id,
                    "keyword" => $keyword,
                    "current_page" => 0,
                    "total_page" => $count
                ]);
            }
            $job = JobOffer::where('title', 'LIKE', '%' . $keyword . '%')->orderBy('id', 'desc')->skip($skip)->take($take)->get();
            $keyboard = $this->searchWithReturnButton();

            if ($count > $take) {
                $keyboard = $this->searchWithNextButton();
            }
            $res = "";
            foreach ($job as $item) {
                $res .= $this->createJobOfferBanner2($item);
                SendTelegramMessageAsHTML(ConvertToUTF8($res), $this->getJobOfferKeyboard($item));
                $res = "";

            }
            $page = 1;
            $totalPages = ((int)($count / $take)) + 1;
            SendTelegramMessage('?????????? ?????????? ???????? ' . $page . ' ???? ' . $totalPages, $keyboard);
        }

    }

    public function nextPage($oldUser)
    {
        $user = User::find($oldUser->id);
        if ($user == null || $user->Search == null) {
            SendTelegramMessage($this->NoResultFound(), $this->searchWithReturnButton());
            return;
        }
        $skip = 0;
        $take = 5;
        $count = JobOffer::where('title', 'LIKE', '%' . $user->Search->keyword . '%')->orderBy('id', 'desc')->count();
        if ($count == 0) {
            SendTelegramMessage($this->NoResultFound(), $this->searchWithReturnButton());

        } else {
            if ($user->Search != null) {
                $skip = ($user->Search->current_page + 1) * $take;
                if ($skip > $count) {
                    SendTelegramMessage($this->NoResultFound(), $this->searchWithPreviousButton());
                } else {
                    $user->Search->current_page += 1;
//                $user->Search->current_page += 1;
                    $user->Search->total_page = $count;
                    $user->Search->save();
                    $user->save();
                }
            }
        }
        $job = JobOffer::where('title', 'LIKE', '%' . $user->Search->keyword . '%')->orderBy('id', 'desc')->skip($skip)->take($take)->get();

        $keyboard = $this->searchWithReturnButton();


        if ($skip + $take > $count) {
            $keyboard = $this->searchWithPreviousButton();
        } else {
            $keyboard = $this->searchWithNextAndPreviousButton();

        }
        $res = "";
        foreach ($job as $item) {
            $res .= $this->createJobOfferBanner2($item);
            SendTelegramMessageAsHTML(ConvertToUTF8($res), $this->getJobOfferKeyboard($item));
            $res = "";

        }

        $page = $user->Search->current_page+1;
        $totalPages = ((int)($count / $take)) + 1;
        SendTelegramMessage('?????????? ?????????? ???????? ' . $page . ' ???? ' . $totalPages, $keyboard);

    }

    public
    function previousPage($oldUser)
    {
        $user = User::find($oldUser->id);
        if ($user == null || $user->Search == null) {
            SendTelegramMessage($this->NoResultFound(), $this->searchWithReturnButton());
            return;
        }
        $skip = 0;
        $take = 5;
        $count = JobOffer::where('title', 'LIKE', '%' . $user->Search->keyword . '%')->orderBy('id', 'desc')->count();
        if ($count == 0) {
            SendTelegramMessage($this->NoResultFound(), $this->searchWithReturnButton());

        } else {
            if ($user->Search != null) {
                $skip = ($user->Search->current_page - 1) * $take;
                if ($skip < 0) {
                    SendTelegramMessage($this->NoResultFound(), $this->searchWithPreviousButton());
                } else {
                    $user->Search->current_page -= 1;
//                $user->Search->current_page += 1;
                    $user->Search->total_page = $count;
                    $user->Search->save();
                    $user->save();
                }
            }
        }
        $job = JobOffer::where('title', 'LIKE', '%' . $user->Search->keyword . '%')->orderBy('id', 'desc')->skip($skip)->take($take)->get();

        $keyboard = $this->searchWithReturnButton();

        if ($skip < 10) {
            $keyboard = $this->searchWithNextButton();
        } else {
            $keyboard = $this->searchWithNextAndPreviousButton();

        }
        $res = "";

        foreach ($job as $item) {
            $res .= $this->createJobOfferBanner2($item);
            SendTelegramMessageAsHTML(ConvertToUTF8($res), $this->getJobOfferKeyboard($item));
            $res = "";

        }
        $page = $user->Search->current_page+1;
        $totalPages = ((int)($count / $take)) + 1;
        SendTelegramMessage('?????????? ?????????? ???????? ' . $page . ' ???? ' . $totalPages, $keyboard);

    }


    private function createJobOfferBanner($jobOffer, $keyboard)
    {
        $arr = [" ??? " . $jobOffer->title, " "];
        if ($this->getGenderType($jobOffer) != null) {
            array_push($arr, $this->getGenderType($jobOffer));
            array_push($arr, " ");
        }
        if ($this->getWorkModeType($jobOffer) != null) {
            array_push($arr, $this->getWorkModeType($jobOffer));
            array_push($arr, " ");

        }
        if ($this->getWorkModeTime($jobOffer) != null) {
            array_push($arr, $this->getWorkModeTime($jobOffer));
            array_push($arr, " ");

        }
        if ($this->getGradeType($jobOffer) != null) {
            array_push($arr, $this->getGradeType($jobOffer));
            array_push($arr, " ");

        }
        if ($this->getExperienceType($jobOffer) != null) {
            array_push($arr, $this->getExperienceType($jobOffer));
            array_push($arr, " ");

        }
        array_push($arr, '<a href="' . $jobOffer->link . '">???????????? ???????? ????????</a>');
        array_push($arr, " ");


        if ($jobOffer->contact->registerLink != null) {
            array_push($arr, '<a href="' . $jobOffer->contact->registerLink . '">?????????? ??????????  </a>');
        }
        array_push($arr, "\n");

        SendTelegramMessageAsHTML(appendTexts($arr), $keyboard);
    }


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

    public function findStateName($job): ?string
    {
        $res = null;
        $states = State::all();
        foreach ($states as $state) {

            if ($this->findInRelation($job, $state->cat_id)) {
                return $state->title;
            }
        }
        return null;
    }

    private function createJobOfferBanner2($jobOffer): string
    {
        $date = Jalalian::forge('today');
        $jobBanner = '';

        if ($jobOffer->companyName != null) {
            $jobBanner .= ' ???? ' . $jobOffer->companyName . "\n";
        }
        if ($this->findStateName($jobOffer)!=null) {
            $jobBanner .= ' ???? ??????????: ' . $this->findStateName($jobOffer) . "\n";
        }
        if ($jobOffer->district != null) {
            $jobBanner .= ' ???? ??????????: ' . $jobOffer->district . "\n";
        }

        $jobBanner .= ' ???? ??????????:  ' . $date->getYear() . '/' . $date->getMonth() . '/' . $date->getDay() . "\n";

        $jobBanner .= '???????????????????????????????????????????????????????????????' . "\n";

        $jobBanner .= " ???? " . $jobOffer->title . "\n" . "\n";

        $jobBanner .= " ?????????????? ?????????????? ????????????: " . "\n";

        if ($this->getGenderType($jobOffer) != null) {
            $jobBanner .= $this->getGenderType($jobOffer) . "\n";

        }
        if ($this->getWorkModeTime($jobOffer) != null) {
            $jobBanner .= $this->getWorkModeTime($jobOffer) . "\n";

        }
        if ($jobOffer->timeDetails != null) {
            $jobBanner .= '???????????? ????????:  ' . $jobOffer->timeDetails . "\n";
        }
        if ($this->getWorkModeType($jobOffer) != null) {
            $jobBanner .= $this->getWorkModeType($jobOffer) . "\n";
        }
        if ($this->getSalary($jobOffer) != null) {
            $jobBanner .= $this->getSalary($jobOffer) . "\n";
        }

        if ($this->getExperienceType($jobOffer) != null) {
            $jobBanner .= $this->getExperienceType($jobOffer) . "\n";

        }
        if ($this->getGradeType($jobOffer) != null) {
            $jobBanner .= $this->getGradeType($jobOffer) . "\n";
        }
        if ($res = $this->finJobs($jobOffer)) {
            $jobBanner .= $res . "\n";
        }
        $jobBanner .= "\n" . '??????????? ?????? ???????????? ?????????????? ???????? ?????? ???????? ?? ???? ?????????? ?????????? ???? ?????????? ?????? ?????? ?????????????? ????????:' . "\n";


        return $jobBanner;
    }

    private function getJobOfferKeyboard($jobOffer): Keyboard
    {
        if ($jobOffer->contact->registerLink == null) {
            return Keyboard::make()
                ->inline()
                ->row(
                    Keyboard::inlineButton(['text' => '???????????? ?????????????? ????????', 'url' => $jobOffer->link]),
                );
        } else {
            return Keyboard::make()
                ->inline()
                ->row(
                    Keyboard::inlineButton(['text' => '???????????? ?????????????? ????????', 'url' => $jobOffer->link]),
                    Keyboard::inlineButton(['text' => '?????????? ??????????', 'url' => $jobOffer->contact->registerLink]),
                );

        }
    }

    private function getGenderType($jobOffer): ?string
    {
        $gender = "?????? ?????????? : ";
        if (!in_array(76399, str_getcsv($jobOffer->cats)) && !in_array(76400, str_getcsv($jobOffer->cats))) {
            return $gender . " ?????? ?? ???? ";
        } else if (in_array(76399, str_getcsv($jobOffer->cats))) {
            return $gender . " ??????  ";
        } else if (in_array(76400, str_getcsv($jobOffer->cats))) {
            return $gender . "???? ";
        }

        return null;
    }

    private function getWorkModeType($jobOffer): ?string
    {
        $gender = "?????? ?????? ???????????? : ";
        if (in_array(1021032, str_getcsv($jobOffer->cats))) {
            return $gender . "??????????";
        } else if (in_array(19087, str_getcsv($jobOffer->cats))) {
            return $gender . "??????????????";
        } else if (in_array(78191, str_getcsv($jobOffer->cats))) {
            return $gender . "??????????????";

        } else if (in_array(13558, str_getcsv($jobOffer->cats))) {
            return $gender . "????????????";

        } else if (in_array(16388, str_getcsv($jobOffer->cats))) {
            return $gender . "????????????????";
        }

        return null;
    }

    private function getSalary($jobOffer): ?string
    {
        $gender = "?????? ????????: ";
        if (in_array(1023031, str_getcsv($jobOffer->cats))) {
            return $gender . "????????????";
        } else if (in_array(1023032, str_getcsv($jobOffer->cats))) {
            return $gender . "?????????? ???????? ???????? ?????????? ??????";
        } else if (in_array(1023033, str_getcsv($jobOffer->cats))) {
            return $gender . "???? 3 ???????????? ??????????";
        } else if (in_array(1023034, str_getcsv($jobOffer->cats))) {
            return $gender . "???? 4 ???????????? ??????????";
        } else if (in_array(1023035, str_getcsv($jobOffer->cats))) {
            return $gender . "???? 5 ???????????? ??????????";
        } else if (in_array(1023036, str_getcsv($jobOffer->cats))) {
            return $gender . "???? 6 ???????????? ??????????";
        } else if (in_array(1023037, str_getcsv($jobOffer->cats))) {
            return $gender . "???? 7 ???????????? ??????????";
        } else if (in_array(1023038, str_getcsv($jobOffer->cats))) {
            return $gender . "???? 8 ???????????? ??????????";
        } else if (in_array(1023039, str_getcsv($jobOffer->cats))) {
            return $gender . "???? 9 ???????????? ??????????";
        } else if (in_array(1023040, str_getcsv($jobOffer->cats))) {
            return $gender . "???? 10 ???????????? ??????????";
        } else if (in_array(1023041, str_getcsv($jobOffer->cats))) {
            return $gender . "???? 11 ???????????? ??????????";
        } else if (in_array(1023042, str_getcsv($jobOffer->cats))) {
            return $gender . "???? 12 ???????????? ??????????";
        } else if (in_array(1023043, str_getcsv($jobOffer->cats))) {
            return $gender . "???? 13 ???????????? ??????????";
        } else if (in_array(1023044, str_getcsv($jobOffer->cats))) {
            return $gender . "???? 14 ???????????? ??????????";
        } else if (in_array(1023045, str_getcsv($jobOffer->cats))) {
            return $gender . "15 ???????????? ?????????? ???? ????????";
        }

        return null;
    }

    private function getWorkModeTime($jobOffer): ?string
    {
        $gender = "?????? ???????? ???????? : ";
        if (in_array(1021031, str_getcsv($jobOffer->cats))) {
            return $gender . "???????? ?????? ";
        } else if (in_array(85293, str_getcsv($jobOffer->cats))) {
            return $gender . "???????? ??????";
        }

        return null;
    }

    private function getGradeType($jobOffer): ?string
    {
        $gender = "?????? ????????  : ";
        $attached = false;
        if (in_array(21891, str_getcsv($jobOffer->cats))) {
            $gender .= "?????? ?????????? ";
            $attached = true;
        }

        if (in_array(21892, str_getcsv($jobOffer->cats))) {
            if ($attached) {
                $gender .= " - ";
            }
            $gender .= " ?????????? ";
            $attached = true;

        }

        if (in_array(21893, str_getcsv($jobOffer->cats))) {
            if ($attached) {
                $gender .= " - ";
            }
            $gender .= "?????? ?????????? ";
            $attached = true;

        }

        if (in_array(21894, str_getcsv($jobOffer->cats))) {

            if ($attached) {
                $gender .= " - ";
            }
            $gender .= "???????????? ";
            $attached = true;

        }

        if (in_array(21895, str_getcsv($jobOffer->cats))) {
            if ($attached) {
                $gender .= " - ";
            }
            $gender .= "?????? ???????????? ";
            $attached = true;

        }
        if (in_array(21896, str_getcsv($jobOffer->cats))) {
            if ($attached) {
                $gender .= " - ";
            }
            $gender .= "?????????? ";
            $attached = true;

        }
        if (!in_array(21891, str_getcsv($jobOffer->cats)) && !in_array(21892, str_getcsv($jobOffer->cats)) && !in_array(21893, str_getcsv($jobOffer->cats)) &&
            !in_array(21894, str_getcsv($jobOffer->cats)) && !in_array(21895, str_getcsv($jobOffer->cats)) && !in_array(21896, str_getcsv($jobOffer->cats))
        ) {
            return null;

        }


        return $gender;
    }

    private function getExperienceType($jobOffer): ?string
    {
        $gender = "?????? ??????????  : ";
        if (in_array(1021033, str_getcsv($jobOffer->cats))) {
            return $gender . "??????????";
        } else if (in_array(1022031, str_getcsv($jobOffer->cats))) {
            return $gender . "1 ?????? ";
        } else if (in_array(1022032, str_getcsv($jobOffer->cats))) {
            return $gender . "2 ??????";
        } else if (in_array(1022033, str_getcsv($jobOffer->cats))) {
            return $gender . "3 ??????";
        } else if (in_array(1022034, str_getcsv($jobOffer->cats))) {
            return $gender . "4 ??????";
        } else if (in_array(1022035, str_getcsv($jobOffer->cats))) {
            return $gender . "5 ?????? 9 ??????";
        } else if (in_array(1022036, str_getcsv($jobOffer->cats))) {
            return $gender . " 10 ?????? ???? ????????";
        }


        return null;
    }

    public function finJobs($item): ?string
    {

        $res = null;
        $count = 0;
        foreach ($item->meta as $relation) {
            $jobField = EducationField::where('cat_id', $relation->value)->first();
            if ($jobField) {
                if ($count == 0) {
                    $res = '??????????? ????????????: ' . $jobField->title;
                } else {
                    $res .= ' - ' . $jobField->title;

                }
                $count++;
            }
        }
        return $res;
    }

}
