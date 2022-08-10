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
            SendTelegramMessage('نمایش نتایج صفحه ' . $page . ' از ' . $totalPages, $keyboard);
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
        SendTelegramMessage('نمایش نتایج صفحه ' . $page . ' از ' . $totalPages, $keyboard);

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
        SendTelegramMessage('نمایش نتایج صفحه ' . $page . ' از ' . $totalPages, $keyboard);

    }


    private function createJobOfferBanner($jobOffer, $keyboard)
    {
        $arr = [" ✅ " . $jobOffer->title, " "];
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
        array_push($arr, '<a href="' . $jobOffer->link . '">مشاهده فرصت شغلی</a>');
        array_push($arr, " ");


        if ($jobOffer->contact->registerLink != null) {
            array_push($arr, '<a href="' . $jobOffer->contact->registerLink . '">ارسال رزومه  </a>');
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
            $jobBanner .= ' 🔻 ' . $jobOffer->companyName . "\n";
        }
        if ($this->findStateName($jobOffer)!=null) {
            $jobBanner .= ' 📍 استان: ' . $this->findStateName($jobOffer) . "\n";
        }
        if ($jobOffer->district != null) {
            $jobBanner .= ' 🔺 منطقه: ' . $jobOffer->district . "\n";
        }

        $jobBanner .= ' 🗓 تاریخ:  ' . $date->getYear() . '/' . $date->getMonth() . '/' . $date->getDay() . "\n";

        $jobBanner .= '⁃⁃⁃⁃⁃⁃⁃⁃⁃⁃⁃⁃⁃⁃⁃⁃⁃⁃⁃⁃⁃' . "\n";

        $jobBanner .= " 💢 " . $jobOffer->title . "\n" . "\n";

        $jobBanner .= " ◻️سایر اطلاعات تکمیلی: " . "\n";

        if ($this->getGenderType($jobOffer) != null) {
            $jobBanner .= $this->getGenderType($jobOffer) . "\n";

        }
        if ($this->getWorkModeTime($jobOffer) != null) {
            $jobBanner .= $this->getWorkModeTime($jobOffer) . "\n";

        }
        if ($jobOffer->timeDetails != null) {
            $jobBanner .= '▫️روز کاری:  ' . $jobOffer->timeDetails . "\n";
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
        $jobBanner .= "\n" . '👁‍🗨 جهت مشاهده اطلاعات تماس این آگهی و یا ارسال رزومه از گزینه های زیر استفاده کنید:' . "\n";


        return $jobBanner;
    }

    private function getJobOfferKeyboard($jobOffer): Keyboard
    {
        if ($jobOffer->contact->registerLink == null) {
            return Keyboard::make()
                ->inline()
                ->row(
                    Keyboard::inlineButton(['text' => 'مشاهده اطلاعات تماس', 'url' => $jobOffer->link]),
                );
        } else {
            return Keyboard::make()
                ->inline()
                ->row(
                    Keyboard::inlineButton(['text' => 'مشاهده اطلاعات تماس', 'url' => $jobOffer->link]),
                    Keyboard::inlineButton(['text' => 'ارسال رزومه', 'url' => $jobOffer->contact->registerLink]),
                );

        }
    }

    private function getGenderType($jobOffer): ?string
    {
        $gender = "▫️ جنسیت : ";
        if (!in_array(76399, str_getcsv($jobOffer->cats)) && !in_array(76400, str_getcsv($jobOffer->cats))) {
            return $gender . " مرد و زن ";
        } else if (in_array(76399, str_getcsv($jobOffer->cats))) {
            return $gender . " مرد  ";
        } else if (in_array(76400, str_getcsv($jobOffer->cats))) {
            return $gender . "زن ";
        }

        return null;
    }

    private function getWorkModeType($jobOffer): ?string
    {
        $gender = "▫️ نوع همکاری : ";
        if (in_array(1021032, str_getcsv($jobOffer->cats))) {
            return $gender . "حضوری";
        } else if (in_array(19087, str_getcsv($jobOffer->cats))) {
            return $gender . "دورکاری";
        } else if (in_array(78191, str_getcsv($jobOffer->cats))) {
            return $gender . "کارآموز";

        } else if (in_array(13558, str_getcsv($jobOffer->cats))) {
            return $gender . "دانشجو";

        } else if (in_array(16388, str_getcsv($jobOffer->cats))) {
            return $gender . "بازنشسته";
        }

        return null;
    }

    private function getSalary($jobOffer): ?string
    {
        $gender = "▫️ حقوق: ";
        if (in_array(1023031, str_getcsv($jobOffer->cats))) {
            return $gender . "توافقی";
        } else if (in_array(1023032, str_getcsv($jobOffer->cats))) {
            return $gender . "حداقل حقوق پایه وزارت کار";
        } else if (in_array(1023033, str_getcsv($jobOffer->cats))) {
            return $gender . "از 3 میلیون تومان";
        } else if (in_array(1023034, str_getcsv($jobOffer->cats))) {
            return $gender . "از 4 میلیون تومان";
        } else if (in_array(1023035, str_getcsv($jobOffer->cats))) {
            return $gender . "از 5 میلیون تومان";
        } else if (in_array(1023036, str_getcsv($jobOffer->cats))) {
            return $gender . "از 6 میلیون تومان";
        } else if (in_array(1023037, str_getcsv($jobOffer->cats))) {
            return $gender . "از 7 میلیون تومان";
        } else if (in_array(1023038, str_getcsv($jobOffer->cats))) {
            return $gender . "از 8 میلیون تومان";
        } else if (in_array(1023039, str_getcsv($jobOffer->cats))) {
            return $gender . "از 9 میلیون تومان";
        } else if (in_array(1023040, str_getcsv($jobOffer->cats))) {
            return $gender . "از 10 میلیون تومان";
        } else if (in_array(1023041, str_getcsv($jobOffer->cats))) {
            return $gender . "از 11 میلیون تومان";
        } else if (in_array(1023042, str_getcsv($jobOffer->cats))) {
            return $gender . "از 12 میلیون تومان";
        } else if (in_array(1023043, str_getcsv($jobOffer->cats))) {
            return $gender . "از 13 میلیون تومان";
        } else if (in_array(1023044, str_getcsv($jobOffer->cats))) {
            return $gender . "از 14 میلیون تومان";
        } else if (in_array(1023045, str_getcsv($jobOffer->cats))) {
            return $gender . "15 میلیون تومان به بالا";
        }

        return null;
    }

    private function getWorkModeTime($jobOffer): ?string
    {
        $gender = "▫️ ساعت کاری : ";
        if (in_array(1021031, str_getcsv($jobOffer->cats))) {
            return $gender . "تمام وقت ";
        } else if (in_array(85293, str_getcsv($jobOffer->cats))) {
            return $gender . "نیمه وقت";
        }

        return null;
    }

    private function getGradeType($jobOffer): ?string
    {
        $gender = "▫️ مقطع  : ";
        $attached = false;
        if (in_array(21891, str_getcsv($jobOffer->cats))) {
            $gender .= "زیر دیپلم ";
            $attached = true;
        }

        if (in_array(21892, str_getcsv($jobOffer->cats))) {
            if ($attached) {
                $gender .= " - ";
            }
            $gender .= " دیپلم ";
            $attached = true;

        }

        if (in_array(21893, str_getcsv($jobOffer->cats))) {
            if ($attached) {
                $gender .= " - ";
            }
            $gender .= "فوق دیپلم ";
            $attached = true;

        }

        if (in_array(21894, str_getcsv($jobOffer->cats))) {

            if ($attached) {
                $gender .= " - ";
            }
            $gender .= "لیسانس ";
            $attached = true;

        }

        if (in_array(21895, str_getcsv($jobOffer->cats))) {
            if ($attached) {
                $gender .= " - ";
            }
            $gender .= "فوق لیسانس ";
            $attached = true;

        }
        if (in_array(21896, str_getcsv($jobOffer->cats))) {
            if ($attached) {
                $gender .= " - ";
            }
            $gender .= "دکتری ";
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
        $gender = "▫️ سابقه  : ";
        if (in_array(1021033, str_getcsv($jobOffer->cats))) {
            return $gender . "ندارد";
        } else if (in_array(1022031, str_getcsv($jobOffer->cats))) {
            return $gender . "1 سال ";
        } else if (in_array(1022032, str_getcsv($jobOffer->cats))) {
            return $gender . "2 سال";
        } else if (in_array(1022033, str_getcsv($jobOffer->cats))) {
            return $gender . "3 سال";
        } else if (in_array(1022034, str_getcsv($jobOffer->cats))) {
            return $gender . "4 سال";
        } else if (in_array(1022035, str_getcsv($jobOffer->cats))) {
            return $gender . "5 الی 9 سال";
        } else if (in_array(1022036, str_getcsv($jobOffer->cats))) {
            return $gender . " 10 سال به بالا";
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
                    $res = '▫رشته تحصیلی: ' . $jobField->title;
                } else {
                    $res .= ' - ' . $jobField->title;

                }
                $count++;
            }
        }
        return $res;
    }

}
