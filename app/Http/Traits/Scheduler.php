<?php


namespace App\Http\Traits;


use App\Jobs\ScheduleJobOffer;
use App\Models\EducationField;
use App\Models\JobField;
use App\Models\JobOffer;
use App\Models\State;
use App\Models\UserAutomaticSubscription;
use Carbon\Carbon;
use Morilog\Jalali\Jalalian;
use Telegram\Bot\Keyboard\Keyboard;
use function App\Helpers\getOptions;

trait Scheduler
{

    function sendForSubscribedUser()
    {
        $subscribedUsers = UserAutomaticSubscription::all();
        $job = JobOffer::with('meta')->whereDate('created_at', Carbon::today())->get();
        $delay = 5;
        foreach ($subscribedUsers as $user) {
            $sendItems = array();
            foreach ($job as $item) {
                $foundItems = array();


                if (in_array($user->state_id, str_getcsv($item->cats))) {
//                    if ($user->user_id == 224) {
//                        array_push($sendItems, $item);
//                        array_push($foundItems, $item->id);
//                    }
                    if ($this->checkFirstJob($item, $user)) {
                        if ($this->checkJobOfferV2($item, $user)) {
                            array_push($sendItems, $item);
                            array_push($foundItems, $item->id);
                        }
                        if ($this->checkSecondJob($item, $user) && $this->checkIfAddedYet($foundItems, $item) == false) {
                            if ($this->checkJobOfferV2($item, $user)) {
                                array_push($sendItems, $item);
                                array_push($foundItems, $item->id);
                                if ($this->checkThirdJob($item, $user) && $this->checkIfAddedYet($foundItems, $item) == false) {
                                    if ($this->checkJobOfferV2($item, $user)) {
                                        array_push($sendItems, $item);
                                        array_push($foundItems, $item->id);
                                    }
                                }
                            }
                        }

                    }
                    if ($this->checkFirstEducation($item, $user) && $this->checkIfAddedYet($foundItems, $item) == false) {
                        if ($this->checkJobOfferV2($item, $user)) {
                            array_push($sendItems, $item);
                            array_push($foundItems, $item->id);
                        }
                        if ($this->checkSecondEducation($item, $user) && $this->checkIfAddedYet($foundItems, $item) == false) {
                            if ($this->checkJobOfferV2($item, $user)) {
                                array_push($sendItems, $item);
                                array_push($foundItems, $item->id);
                                if ($this->checkThirdEducation($item, $user) && $this->checkIfAddedYet($foundItems, $item) == false) {
                                    if ($this->checkJobOfferV2($item, $user)) {
                                        array_push($sendItems, $item);
                                        array_push($foundItems, $item->id);
                                    }
                                }
                            }
                        }
                    }
                }

                /*
                                if (in_array($user->state_id, str_getcsv($item->cats)) && $this->checkFirstJob($item, $user)) {
                                    if ($this->checkJobOfferV2($item, $user)) {
                                        array_push($sendItems, $item);
                                    }

                //                    $this->createJobOfferBanner2($item, $user->user, $arr);
                                } else if ($user->second_job_id != 8595800 && in_array($user->state_id, str_getcsv($item->cats)) && $this->checkSecondJob($item, $user)) {
                                    if ($this->checkJobOfferV2($item, $user)) {
                                        array_push($sendItems, $item);
                                    }

                //                    $this->createJobOfferBanner2($item, $user->user, $arr);
                                } else if (in_array($user->state_id, str_getcsv($item->cats)) && $this->checkThirdJob($item, $user)) {
                                    if ($this->checkJobOfferV2($item, $user)) {
                                        array_push($sendItems, $item);
                                    }

                //                    $this->createJobOfferBanner2($item, $user->user, $arr);
                                } else if ($user->second_job_id != 8595800 || $user->second_education_id != 8595900) {
                                    if (in_array($user->state_id, str_getcsv($item->cats)) && $this->checkJobOfferSecond($item, $user)) {
                                        array_push($sendItems, $item);
                                    }
                                } else if ($user->third_job_id != 85951000 || $user->third_education_id != 85951100) {
                                    if (in_array($user->state_id, str_getcsv($item->cats)) && $this->checkJobOfferThird($item, $user)) {
                                        array_push($sendItems, $item);
                                    }
                                }*/
            }

            $res = "";
            for ($i = 0; $i < count($sendItems); $i++) {
                $res .= $this->createJobOfferBanner2($sendItems[$i]);
                ScheduleJobOffer::dispatch($res, $user->user, $this->getJobOfferKeyboard($sendItems[$i]))->delay(Carbon::now()->addSeconds($delay += 5));
                $res = "";

            }
        }
    }

    private function checkIfAddedYet($foundItems, $item): bool
    {
        foreach ($foundItems as $foundItem) {
            if ($foundItem == $item->id) {
                return true;
            }
        }
        return false;
    }

    private function checkFirstJob($jobOffer, $user): bool
    {
        if ($user->job_id == 8595600) {
            return false;
        } else {
            return $this->findInRelation($jobOffer, $user->job_id);

        }
    }

    private function checkFirstEducation($jobOffer, $user): bool
    {
        if ($user->education_id == 8595700) {
            return false;
        } else {
            return $this->findInRelation($jobOffer, $user->education_id);

        }
    }

    private function checkSecondJob($jobOffer, $user): bool
    {
        if ($user->second_job_id == 8595800) {
            return false;
        } else {
            return $this->findInRelation($jobOffer, $user->second_job_id);
        }
    }

    private function checkSecondEducation($jobOffer, $user): bool
    {
        if ($user->second_education_id == 8595900) {
            return false;
        } else {
            return $this->findInRelation($jobOffer, $user->second_education_id);
        }
    }

    private function checkThirdJob($jobOffer, $user): bool
    {
        if ($user->third_job_id == 85951000) {
            return false;
        } else {
            return $this->findInRelation($jobOffer, $user->third_job_id);

        }
    }

    private function checkThirdEducation($jobOffer, $user): bool
    {
        if ($user->third_education_id == 85951100) {
            return false;
        } else {
            return $this->findInRelation($jobOffer, $user->third_education_id);

        }
    }

    private function checkJobOffer($jobOffer, $user): bool
    {
        $res = true;
        if ($user->gender_id != 8595100) {
            $res = $this->findInRelation($jobOffer, $user->gender_id);
        }

        if ($user->work_time_id != 8595200 && $res) {
            $res = $this->findInRelation($jobOffer, $user->work_time_id);
        }
        if ($user->work_mode_id != 8595300 && $res) {
            $res = $this->findInRelation($jobOffer, $user->work_mode_id);
        }
        if ($user->experience_type_id != 8595400 && $res) {
            $res = $this->findInRelation($jobOffer, $user->experience_type_id);
        }
        if ($user->grade_id != 8595500 && $res) {
            $res = $this->findInRelation($jobOffer, $user->grade_id);
        }
        if ($user->job_id != 8595600 && $res) {
            $res = $this->findInRelation($jobOffer, $user->job_id);
        }
        if ($user->education_id != 8595700 && $res) {
            $res = $this->findInRelation($jobOffer, $user->education_id);
        }
        return $res;
    }


    private function checkJobOfferV2($jobOffer, $user): bool
    {
        $res = true;
        if ($user->gender_id != 8595100) {
            $res = $this->findInRelation($jobOffer, $user->gender_id);
        }

        if ($user->work_time_id != 8595200 && $res) {
            $res = $this->findInRelation($jobOffer, $user->work_time_id);
        }
        if ($user->work_mode_id != 8595300 && $res) {
            $res = $this->findInRelation($jobOffer, $user->work_mode_id);
        }
        if ($user->experience_type_id != 8595400 && $res) {
            $res = $this->findInRelation($jobOffer, $user->experience_type_id);
        }
        if ($user->grade_id != 8595500 && $res) {
            $res = $this->findInRelation($jobOffer, $user->grade_id);
        }

        return $res;
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

    private function checkJobOfferSecond($jobOffer, $user): bool
    {
        $res = true;
        if ($user->gender_id != 8595100) {
            $res = $this->findInRelation($jobOffer, $user->gender_id);
        }
        if ($user->work_time_id != 8595200 && $res) {
            $res = $this->findInRelation($jobOffer, $user->work_time_id);
        }
        if ($user->work_mode_id != 8595300 && $res) {
            $res = $this->findInRelation($jobOffer, $user->work_mode_id);
        }
        if ($user->experience_type_id != 8595400 && $res) {
            $res = $this->findInRelation($jobOffer, $user->experience_type_id);
        }
        if ($user->grade_id != 8595500 && $res) {
            $res = $this->findInRelation($jobOffer, $user->grade_id);
        }
        if ($user->second_job_id != 8595800 && $res) {
            $res = $this->findInRelation($jobOffer, $user->second_job_id);
        }
        if ($user->second_education_id != 8595900 && $res) {
            $res = $this->findInRelation($jobOffer, $user->second_education_id);
        }
        return $res;
    }

    private function checkJobOfferThird($jobOffer, $user): bool
    {
        $res = true;
        if ($user->gender_id != 8595100) {
            $res = $this->findInRelation($jobOffer, $user->gender_id);
        }

        if ($user->work_time_id != 8595200 && $res) {
            $res = $this->findInRelation($jobOffer, $user->work_time_id);
        }
        if ($user->work_mode_id != 8595300 && $res) {
            $res = $this->findInRelation($jobOffer, $user->work_mode_id);
        }
        if ($user->experience_type_id != 8595400 && $res) {
            $res = $this->findInRelation($jobOffer, $user->experience_type_id);
        }
        if ($user->grade_id != 8595500 && $res) {
            $res = $this->findInRelation($jobOffer, $user->grade_id);
        }
        if ($user->third_job_id != 85951000 && $res) {
            $res = $this->findInRelation($jobOffer, $user->third_job_id);
        }
        if ($user->third_education_id != 85951100 && $res) {
            $res = $this->findInRelation($jobOffer, $user->third_education_id);
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
        if ($this->findStateName($jobOffer) != null) {
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
}
