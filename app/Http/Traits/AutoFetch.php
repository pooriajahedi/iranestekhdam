<?php


namespace App\Http\Traits;


use App\Models\BanksHiring;
use App\Models\Company;
use App\Models\CtegoriesCombination;
use App\Models\EducationField;
use App\Models\GovernmentAgency;
use App\Models\JobField;
use App\Models\JobOffer;
use App\Models\JobOfferContact;
use App\Models\JobOfferMeta;
use App\Models\State;
use App\Models\UserAutomaticSubscription;
use Carbon\Carbon;
use GuzzleHttp\Client;

trait AutoFetch
{

    public function FetchStates()
    {
        $client = new Client;
        $results = $client->request('GET', 'https://iranestekhdam.ir/dasteh-ostanha');
        $items = json_decode($results->getBody());

        $keyboard = array();
        $combination = array();

        foreach ($items as $state) {
            if (State::where('cat_id', $state->catid)->first() == null) {
                $state->catname = trim(str_replace("آگهی", "", $state->catname));
                $state->catname = trim(str_replace("استخدام", "", $state->catname));
                array_push($keyboard, ["title" => $state->catname, "cat_id" => $state->catid]);
            }
        }
        State::insert($keyboard);
        foreach ($items as $state) {
            if (CtegoriesCombination::where('service_id', $state->catid)->first() == null) {
                $state->catname = trim(str_replace("آگهی", "", $state->catname));
                $state->catname = trim(str_replace("استخدام", "", $state->catname));
                array_push($combination, ["title" => $state->catname, "service_id" => $state->catid]);
            }
        }
        CtegoriesCombination::insert($combination);
    }

    public function FetchEducationField(): int
    {
//        EducationField::truncate();

        $client = new Client;
        $results = $client->request('GET', 'https://iranestekhdam.ir/reshteh-tahsili');
        $items = json_decode($results->getBody());
        $educations = array();
        $educationsCombine = array();
        $count = 0;
        foreach ($items as $education) {
            if (EducationField::where('cat_id', $education->catid)->first() == null) {
                $education->catname = trim(str_replace("استخدام", "", $education->catname));
                $education->catname = trim(str_replace("رشته", "", $education->catname));
                array_push($educations, ["title" => $education->catname, "cat_id" => $education->catid]);
                $count++;
            }
        }
        EducationField::insert($educations);
        foreach ($items as $education) {
            if (CtegoriesCombination::where('service_id', $education->catid)->first() == null) {
                $education->catname = trim(str_replace("استخدام", "", $education->catname));
                $education->catname = trim(str_replace("رشته", "", $education->catname));
                array_push($educationsCombine, ["title" => $education->catname, "service_id" => $education->catid]);
                $count++;
            }
        }
        CtegoriesCombination::insert($educationsCombine);

        //Check Edited Or Deleted Items
        $educationsItem = EducationField::all();
        foreach ($educationsItem as $dbItem) {
            $found = false;
            foreach ($items as $serviceItem) {
                if ($dbItem->cat_id == $serviceItem->catid) {
                    $found = true;
                    $title=$serviceItem->catname;
                    $title = trim(str_replace("استخدام", "", $title));
                    $title = trim(str_replace("رشته", "", $title));
                    if ($dbItem->title != $title) {
                        $dbItem->title = $title;
                        $dbItem->save();
                        $combineItem = CtegoriesCombination::where('service_id', $serviceItem->catid)->first();
                        $combineItem->title = $title;
                        $combineItem->save();
                    }
                }
            }
            if ($found == false) {
                $dbItem->delete();
            }
        }
        return $count;

    }

    public function FetchWorkField(): int
    {
//        EducationField::truncate();

        $client = new Client;
        $results = $client->request('GET', 'https://iranestekhdam.ir/reshteh-shoghli');
        $items = json_decode($results->getBody());
        $jobFItems = array();
        $jobFItemsCombine = array();
        $count = 0;

        foreach ($items as $jobField) {
            if (JobField::where('cat_id', $jobField->catid)->first() == null) {
                $jobField->catname = trim(str_replace("استخدام", "", $jobField->catname));
                array_push($jobFItems, ["title" => $jobField->catname, "cat_id" => $jobField->catid]);
                $count++;
            }
        }

        foreach ($items as $jobField) {
            if (CtegoriesCombination::where('service_id', $jobField->catid)->first() == null) {
                $jobField->catname = trim(str_replace("استخدام", "", $jobField->catname));
                array_push($jobFItemsCombine, ["title" => $jobField->catname, "service_id" => $jobField->catid]);
            }
        }
        CtegoriesCombination::insert($jobFItemsCombine);
        JobField::insert($jobFItems);

        $jobDBItems = JobField::all();
        foreach ($jobDBItems as $dbItem) {
            $found = false;
            foreach ($items as $serviceItem) {
                if ($dbItem->cat_id == $serviceItem->catid) {
                    $found = true;
                    if ($dbItem->title !=trim(str_replace("استخدام", "", $serviceItem->catname))) {
                        $dbItem->title = trim(str_replace("استخدام", "", $serviceItem->catname));
                        $dbItem->save();
                        $combineItem = CtegoriesCombination::where('service_id', $serviceItem->catid)->first();
                        $combineItem->title = trim(str_replace("استخدام", "", $serviceItem->catname));
                        $combineItem->save();
                    }
                }
            }
            if ($found == false) {
                $dbItem->delete();
            }
        }
        return $count;
    }

    public function fetchRecruitmentAnnouncement(): int
    {
        $client = new Client;
        $results = $client->request('GET', 'https://iranestekhdam.ir/wp-includes/certificates/get-ads');
        $jobPositions = json_decode($results->getBody());
        $updatedCount = 0;
        foreach ($jobPositions as $jobPosition) {
            if (JobOffer::withTrashed()->where('link', $jobPosition->link)->first() == null) {
                $job = JobOffer::create([
                    "title" => $jobPosition->title,
                    "content" => $this->removeUnUsedTags(($jobPosition->content)),
                    "applyLink" => $jobPosition->applyLink,
                    "cats" => $jobPosition->cats,
                    "company_description" => $jobPosition->companyDescription,
                    "company_logo" => $jobPosition->companyLogo,
                    "company_name" => $jobPosition->companyName,
                    "district" => $jobPosition->district,
                    "introduction" => $jobPosition->introduction,
                    "link" => $jobPosition->link,
                    "payamak" => $jobPosition->payamak,
                    "plan" => $jobPosition->plan,
                    "state" => $jobPosition->state,
                    "time_detail" => $jobPosition->timeDetails,

                ]);
                $items = str_getcsv($jobPosition->cats);
                $keyboard = array();


                JobOfferContact::create([
                    "job_offer_id" => $job->id,
                    "email" => $jobPosition->contacts->email,
                    "phone" => $jobPosition->contacts->phone,
                    "sms" => $jobPosition->contacts->sms,
                    "whatsapp" => $jobPosition->contacts->whatsapp,
                    "telegram" => $jobPosition->contacts->telegram,
                    "website" => $jobPosition->contacts->website,
                    "fax" => $jobPosition->contacts->fax,
                    "address" => $jobPosition->contacts->address,
                    "postalCode" => $jobPosition->contacts->postalCode,
                    "registerLink" => $jobPosition->contacts->registerLink,
                ]);
                foreach ($items as $item) {
                    if ($item != null)
                        JobOfferMeta::create([
                            "job_offer_id" => $job->id,
                            "value" => $item,
                        ]);
                }
                $updatedCount++;
            }
        }

        return $updatedCount;

    }


    public function fetchCompanies(): int
    {
        $client = new Client;
        $results = $client->request('GET', 'https://kar.iranestekhdam.ir/feed/companies');
        $companies = json_decode($results->getBody());
        $updatedCount = 0;
        foreach ($companies as $company) {
            if (Company::where('company_id', $company->id)->first() == null) {
                $com = Company::create([
                    "company_id" => $company->id,
                    "name" => $company->name,
                    "logo" => $company->logo,
                    "content" => $company->content,
                    "category" => $company->category,
                    "user_count" => $company->user_count,
                    "area" => $company->area,
                    "website" => $company->website,
                ]);
                $updatedCount++;
            }
        }

        return $updatedCount;

    }

    private function removeUnUsedTags($content): string

    {
        $content = str_replace('</h2>', "\n", $content);
        $content = str_replace('</p>', "\n", $content);
        $content = str_replace('<br />', "\n", $content);
        $content = str_replace('</span>', " ", $content);
        for ($x = 0; $x <= 10; $x++) {
            $content = str_replace('<td style="text-align: center;">$x</td>', "", $content);
        }
        $content = str_replace('<td style="text-align: center;">عنوان شغل', "", $content);
        $content = str_replace('<td>عنوان شغلی</td>', "", $content);
        $content = str_replace('<td style="text-align: right;">شرایط احراز</td>', "", $content);
        $content = str_replace('<td style="text-align: right;">شرایط احراز', "", $content);
        $content = str_replace('<td style="text-align: center;">ردیف', "", $content);
        $content = str_replace('<tr>
            <td style="text-align: center;">ردیف</td>
            <td style="text-align: center;">عنوان شغل</td>
            <td style="text-align: right;">شرایط احراز</td>
        </tr>', "", $content);
        $content = str_replace('</td>', "", $content);
        $content = str_replace('</tr>', "\n", $content);
        $content = str_replace('&nbsp', "", $content);
        return strip_tags($content);
    }


    public function findDesiredJobsInAutoSubscribedUsers()
        //1- Get list of users who has submitted for automatic job offers
        //2-Search in all today job offers where has the same values in 'Meta' as has been submitted in automatic announcements.

    {
        //1
        $subscribedUsers = UserAutomaticSubscription::all();
        foreach ($subscribedUsers as $subscribedUser) {
            $user = JobOffer::with('meta')->whereHas('meta', function ($q) {
                $q->where('vale', 9999);
            })->get();
        }
    }

    public function getAllBanksHiring(): int
    {
        $client = new Client;
        $results = $client->request('GET', 'https://iranestekhdam.ir/category/agahi-estekhdam/%D8%A7%D8%B3%D8%AA%D8%AE%D8%AF%D8%A7%D9%85-%D8%A8%D9%87-%D8%AA%D9%81%DA%A9%DB%8C%DA%A9-%DA%A9%D9%84/%D8%A7%D8%B3%D8%AA%D8%AE%D8%AF%D8%A7%D9%85-%D9%87%D8%A7%DB%8C-%D8%B3%D8%A7%D8%B2%D9%85%D8%A7%D9%86-%D9%87%D8%A7%DB%8C-%D8%AF%D9%88%D9%84%D8%AA%DB%8C/%D8%A7%D8%B3%D8%AA%D8%AE%D8%AF%D8%A7%D9%85-%D8%A8%D8%A7%D9%86%DA%A9-%D9%87%D8%A7-agahi-estekhdam-sarasari/feed');
        $random = collect(json_decode(json_encode((array)simplexml_load_string($results->getBody())), true));
        $items = $random->get("channel")["item"];
        $count = 0;
        foreach ($items as $item) {
            $hire = BanksHiring::where('guid', $item['guid'])->count();
            if ($hire == 0) {
                BanksHiring::create([
                    "title" => $item['title'],
                    "link" => $item['link'],
                    "guid" => $item['guid'],
                ]);
                $count++;
            }
        }
        return $count;
    }

    public function governmentHiring(): int
    {
        $client = new Client;
        $results = $client->request('GET', 'https://iranestekhdam.ir/category/%D8%A7%DB%8C%D8%B1%D8%A7%D9%86-%D8%A7%D8%B3%D8%AA%D8%AE%D8%AF%D8%A7%D9%85/agahi-estekhdam-sarasari/feed');
        $random = collect(json_decode(json_encode((array)simplexml_load_string($results->getBody())), true));
        $items = $random->get("channel")["item"];
        $count = 0;

        foreach ($items as $item) {
            $hire = GovernmentAgency::where('guid', $item['guid'])->first();
            if (!$hire) {
                GovernmentAgency::create([
                    "title" => $item['title'],
                    "link" => $item['link'],
                    "guid" => $item['guid'],
                ]);
                $count++;

            }
        }
        return $count;

    }

    function removeJobOffersMoreThan40DaysAgo()
    {
        $removeItems = JobOffer::withTrashed()->whereDate('created_at', '<', Carbon::now()->addDays(-40))->get();
        foreach ($removeItems as $key) {
            $key->forceDelete();
        }

    }

    public function fillDB()
    {
        ############ جنسیت #########

        CtegoriesCombination::create([
            "title" => "مرد",
            "service_id" => 76399,
        ]);


        CtegoriesCombination::create([
            "title" => "زن",
            "service_id" => 76400,
        ]);


        CtegoriesCombination::create([
            "title" => "زن و مرد",
            "service_id" => 8595100,
        ]);
        ############ مقاطع تحصیلی  #########

        CtegoriesCombination::create([
            "title" => "زیر دیپلم",
            "service_id" => 21891,
        ]);

        CtegoriesCombination::create([
            "title" => "دیپلم",
            "service_id" => 21892,
        ]);

        CtegoriesCombination::create([
            "title" => "فوق دیپلم",
            "service_id" => 21893,
        ]);

        CtegoriesCombination::create([
            "title" => "لیسانس",
            "service_id" => 21894,
        ]);

        CtegoriesCombination::create([
            "title" => "فوق لیسانس",
            "service_id" => 21895,
        ]);

        CtegoriesCombination::create([
            "title" => "دکتری",
            "service_id" => 21896,
        ]);

        CtegoriesCombination::create([
            "title" => "همه مقاطع تحصیلی",
            "service_id" => 8595500,
        ]);

        CtegoriesCombination::create([
            "title" => "اگهی ویژه",
            "service_id" => 71194,
        ]);

        ############ ساعت کاری #########

        CtegoriesCombination::create([
            "title" => "تمام وقت",
            "service_id" => 1021031,
        ]);
        CtegoriesCombination::create([
            "title" => "نیمه وقت",
            "service_id" => 85293,
        ]);
        CtegoriesCombination::create([
            "title" => "ساعت کاری فرقی نمی کند",
            "service_id" => 8595200,
        ]);
        ############ میزان حقوق #########

        CtegoriesCombination::create([
            "title" => "حقوق توافقی",
            "service_id" => 1023031,
        ]);
        CtegoriesCombination::create([
            "title" => "حقوق پایه وزارت کار",
            "service_id" => 1023032,
        ]);
        CtegoriesCombination::create([
            "title" => "از 3 میلیون تومان",
            "service_id" => 1023033,
        ]);
        CtegoriesCombination::create([
            "title" => "از 4 میلیون تومان",
            "service_id" => 1023034,
        ]);
        CtegoriesCombination::create([
            "title" => "از 5 میلیون ترمان",
            "service_id" => 1023035,
        ]);
        CtegoriesCombination::create([
            "title" => "از 6 میلیون تومان",
            "service_id" => 1023036,
        ]);
        CtegoriesCombination::create([
            "title" => "از 7 میلیون تومان",
            "service_id" => 1023037,
        ]);
        CtegoriesCombination::create([
            "title" => "از 8 میلیون تومان",
            "service_id" => 1023038,
        ]);
        CtegoriesCombination::create([
            "title" => "از 9 میلیون تومان",
            "service_id" => 1023039,
        ]);
        CtegoriesCombination::create([
            "title" => "از 10 میلیون تومان",
            "service_id" => 1023040,
        ]);
        CtegoriesCombination::create([
            "title" => "از 11 میلیون تومان",
            "service_id" => 1023041,
        ]);
        CtegoriesCombination::create([
            "title" => "از 12 میلیون تومان",
            "service_id" => 1023042,
        ]);
        CtegoriesCombination::create([
            "title" => "از 13 میلیون تومان",
            "service_id" => 1023043,
        ]);
        CtegoriesCombination::create([
            "title" => "از 14 میلیون تومان",
            "service_id" => 1023044,
        ]);
        CtegoriesCombination::create([
            "title" => "15 میلیون تومان به بالا",
            "service_id" => 1023045,
        ]);


        ############ نوع همکاری #########
        CtegoriesCombination::create([
            "title" => "حضوری",
            "service_id" => 1021032,
        ]);
        CtegoriesCombination::create([
            "title" => "دورکاری",
            "service_id" => 19087,
        ]);
        CtegoriesCombination::create([
            "title" => "کارآموز",
            "service_id" => 78191,
        ]);
        CtegoriesCombination::create([
            "title" => "دانشجو",
            "service_id" => 13558,
        ]);
        CtegoriesCombination::create([
            "title" => "بازنشسته",
            "service_id" => 16388,
        ]);
        CtegoriesCombination::create([
            "title" => "نوع همکاری فرقی نمی کند",
            "service_id" => 8595300,
        ]);

        ############ سابقه کاری #########
        CtegoriesCombination::create([
            "title" => "بدون سابقه کار",
            "service_id" => 1021033,
        ]);
        CtegoriesCombination::create([
            "title" => "1 سال سابقه کار",
            "service_id" => 1022031,
        ]);
        CtegoriesCombination::create([
            "title" => "2 سال سابقه کار",
            "service_id" => 1022032,
        ]);
        CtegoriesCombination::create([
            "title" => "3 سال سابقه کار",
            "service_id" => 1022033,
        ]);
        CtegoriesCombination::create([
            "title" => "4 سال سابقه کار",
            "service_id" => 1022034,
        ]);
        CtegoriesCombination::create([
            "title" => "5 تا 9 سال سابقه کار",
            "service_id" => 1022035,
        ]);
        CtegoriesCombination::create([
            "title" => "10 سال به بالا سابقه کار",
            "service_id" => 1022036,
        ]);
        CtegoriesCombination::create([
            "title" => "سابقه کار مهم نیست",
            "service_id" => 8595400,
        ]);

        ############ شغل#########
        CtegoriesCombination::create([
            "title" => "همه شغل ها",
            "service_id" => 8595600,
        ]);
        ############ شغل#########

        ########### همه رشته های تحصیلی#########

        CtegoriesCombination::create([
            "title" => "همه رشته های تحصیلی",
            "service_id" => 8595700,
        ]);
        ########### همه رشته های تحصیلی#########
        ########### انتخاب دوم#########

        CtegoriesCombination::create([
            "title" => "بدون شغل دوم",
            "service_id" => 8595800,
        ]);
        CtegoriesCombination::create([
            "title" => "بدون رشته دوم",
            "service_id" => 8595900,
        ]);
        ########### انتخاب دوم#########
        ########### انتخاب سوم#########

        CtegoriesCombination::create([
            "title" => "بدون شغل سوم",
            "service_id" => 85951000,
        ]);
        CtegoriesCombination::create([
            "title" => "بدون رشته سوم",
            "service_id" => 85951100,
        ]);
        ########### انتخاب سوم#########


    }

}
