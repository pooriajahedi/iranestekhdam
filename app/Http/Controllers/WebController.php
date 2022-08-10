<?php

namespace App\Http\Controllers;

use App\Http\Traits\AutoFetch;
use App\Http\Traits\Scheduler;
use App\Models\BanksHiring;
use App\Models\CtegoriesCombination;
use App\Models\GovernmentAgency;
use App\Models\JobField;
use App\Models\JobOffer;
use App\Models\Option;
use App\Models\State;
use App\Models\User;
use App\Models\UserAutomaticSubscription;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Morilog\Jalali\Jalalian;
use Telegram\Bot\Keyboard\Keyboard;
use function App\Helpers\appendTexts;
use function App\Helpers\SendTelegramMessage;
use function App\Helpers\SendTelegramMessageWithCustomUserId;

class WebController extends Controller
{
    use AutoFetch;
    use Scheduler;


    public function write()
    {
        echo Carbon::now();
    }

    public function storeData()
    {
        JobOffer::truncate();
        $client = new Client;
        $results = $client->request('GET', 'https://iranestekhdam.ir/wp-includes/certificates/android_app_feed.php');
        $random = collect(json_decode(json_encode((array)simplexml_load_string($results->getBody())), true));
        $items = $random->get("channel")["item"];
        foreach ($items as $item) {
            JobOffer::create([
                "title" => $item['title'],
                "content" => $this->removeUnUsedTags(base64_decode($item["content"])),
                "url" => is_array($item['link']) ? null : $item['link'],
                "email" => is_array($item['email']) ? null : $item['email'],
                "phone_number" => is_array($item['phone']) ? null : $item['phone'],
                "whatsapp" => is_array($item['whatsapp']) ? null : $item['whatsapp'],
                "telegram" => is_array($item['telegram']) ? null : $item['telegram'],
                "website" => is_array($item['website']) ? null : $item['website'],
                "fax" => is_array($item['fax']) ? null : $item['fax'],
                "address" => is_array($item['address']) ? null : $item['address'],
                "register_url" => is_array($item['registerLink']) ? null : $item['registerLink'],
                "postal_code" => is_array($item['postalCode']) ? null : $item['postalCode'],
            ]);
        }
        return ["fetch was successful"];

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

    public function testSplit()
    {
        $ob = JobOffer::find(102);
        $items = str_getcsv($ob->cats);
        foreach ($items as $item) {
            echo $item;
            echo "<br/>";
        }
        echo print_r(str_getcsv($ob->cats));
    }

    private function checkTitleExists($title, $url)
    {
//        JobOffer::where('title',$title)->where('')
    }

    public function fetchJobOffers()
    {
       $updates= $this->fetchRecruitmentAnnouncement();

    }

    public function fetchJobFields()
    {

        $client = new Client;
        $results = $client->request('GET', 'https://iranestekhdam.ir/reshteh-shoghli');
        $items = json_decode($results->getBody());
        $jobFItems = array();

        foreach ($items as $jobField) {
            $jobField->catname = trim(str_replace("استخدام", "", $jobField->catname));
            array_push($jobFItems, ["title" => $jobField->catname, "service_id" => $jobField->catid]);
        }
        CtegoriesCombination::insert($jobFItems);
    }

    public function fetchEducations()
    {

        $client = new Client;
        $results = $client->request('GET', 'https://iranestekhdam.ir/reshteh-tahsili');
        $items = json_decode($results->getBody());
        $jobFItems = array();

        foreach ($items as $education) {
            $education->catname = trim(str_replace("استخدام", "", $education->catname));
            $education->catname = trim(str_replace("رشته", "", $education->catname));
            array_push($jobFItems, ["title" => $education->catname, "service_id" => $education->catid]);
        }
        CtegoriesCombination::insert($jobFItems);
    }



    public function test2()
    {
    }






}
