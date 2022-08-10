<?php


namespace App\Helpers;


use App\Models\CtegoriesCombination;
use App\Models\Option;
use App\Models\User;
use App\Models\UserAutomaticSubscription;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Morilog\Jalali\Jalalian;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Laravel\Facades\Telegram;

function getOptions($key): string
{
    $option = Option::where('meta', $key)->first();
    if ($option) {
        return $option->value;
    } else {
        return "";
    }
}

function userCountByDay($day = 0)
{
    return User::whereDate('created_at', Carbon::today()->addDays($day))->count();
}


function setOption($meta, $value, $mode = null)
{
    Option::updateOrCreate(
        ['meta' => $meta],
        ['value' => $value]
    );
}

function SendTelegramMessage($text, $keyboard = null)
{
    if (!$keyboard) {
        Telegram::sendMessage([
            'chat_id' => request('message.chat.id'),
            'text' => $text,

        ]);
    } else {
        Telegram::sendMessage([
            'chat_id' => request('message.chat.id'),
            'text' => $text,
            'reply_markup' => $keyboard
        ]);
    }

}


function createInput($file, $fileName): InputFile
{
    return InputFile::create($file, $fileName);

}

function SendIntroVideo()
{

    $client = new Client;
    $results = $client->request('GET', 'https://api.telegram.org/bot' . env('BOT_TOKEN') . '/sendVideo?chat_id=' . request('message.chat.id') . '&video=BAACAgQAAxkBAAILbGILihx9syzN-mskDeseL43oMgevAAI3CQACiRRhUL80KUUF76OEIwQ');

}


function ConvertToUTF8($text)
{

    $encoding = mb_detect_encoding($text, mb_detect_order(), false);

    if ($encoding == "UTF-8") {
        $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');
    }


    $out = iconv(mb_detect_encoding($text, mb_detect_order(), false), "UTF-8//IGNORE", $text);


    return $out;
}

function SendTelegramMessageAsHTML($text, $keyboard = null)
{
    if (!$keyboard) {
        Telegram::sendMessage([
            'chat_id' => request('message.chat.id'),
            'text' => $text,
            "parse_mode" => "HTML",
            "disable_web_page_preview", true

        ]);
    } else {
        Telegram::sendMessage([
            'chat_id' => request('message.chat.id'),
            'text' => $text,
            "parse_mode" => "HTML",
            'reply_markup' => $keyboard,
            "disable_web_page_preview", true
        ]);
    }

}


function SendTelegramMessageAsHTMLWithUserId($text, $user, $keyboard = null)
{
    if (!$keyboard) {
        Telegram::sendMessage([
            'chat_id' => $user->chat_id,
            'text' => $text,
            "parse_mode" => "HTML"

        ]);
    } else {
        Telegram::sendMessage([
            'chat_id' => $user->chat_id,
            'text' => $text,
            "parse_mode" => "HTML",
            'reply_markup' => $keyboard,

        ]);
    }

}


function SendTelegramMessageWithCustomUserId($text, $user, $keyboard = null)
{
    if (!$keyboard) {
        Telegram::sendMessage([
            'chat_id' => $user->chat_id,
            'text' => $text,

        ]);
    } else {
        Telegram::sendMessage([
            'chat_id' => $user->chat_id,
            'text' => $text,
            'reply_markup' => $keyboard
        ]);
    }

}

function inJson($key, $json = null)
{
    if ($json == null || $json == '' || !is_array(json_decode($json)))
        return false;

    $array = json_decode($json, true);
    if (in_array($key, $array))
        return true;

    return false;
}

function appendTexts(...$params): string
{
    $text = "";
    foreach (func_get_args()[0] as $item) {
        $text .= " " . $item . "\n";
    }
    return $text;
}


function getJTimeStamp($type = 'day')
{
    if ($type == 'day') {
        $startDateTimeStamp = jmktime(0, 0, 0, custom_jdate('m', time()), custom_jdate('d', time()), custom_jdate('Y', time()));
        $expireDateTimeStamp = jmktime(23, 59, 59, custom_jdate('m', time()), custom_jdate('d', time()), custom_jdate('Y', time()));
    }
    if ($type == 'month') {
        $startDateTimeStamp = jmktime(0, 0, 0, custom_jdate('m', time()), 0, custom_jdate('Y', time()));
        $expireDateTimeStamp = jmktime(23, 59, 59, custom_jdate('m', time()), custom_jdate('d', time()), custom_jdate('Y', time()));
    }

    return ['first' => date('Y-m-d H:i:s', $startDateTimeStamp), 'last' => date('Y-m-d H:i:s', $expireDateTimeStamp)];
}

function getDateByNum($day = 0)
{
    $timeStamp = $day * 86400;
    $Time = time() - $timeStamp;
    return custom_jdate('Y/m/d', $Time);
}


function getMode($status)
{
    switch ($status) {
        case '1':
            return '<label class="badge badge-success">فعال</label>';
            break;
        case '0':
            return '<label class="badge">غیرفعال</label>';
            break;
    }
}

function getJobSubmitStatus($status)
{
    switch ($status) {
        case 'new':
            return '<label class="badge badge-info">جدید</label>';
            break;
        case 'reviewed':
            return '<label class="badge badge-warning">در دست بررسی</label>';
            break;
        case 'accepted':
            return '<label class="badge badge-success">پذیرفته شده</label>';
            break;
        case 'rejected':
            return '<label class="badge badge-danger">عدم تایید</label>';
            break;
    }
}

function getTicketPriority($priority)
{
    switch ($priority) {
        case 'low':
            return '<label class="badge badge-info">پایین</label>';
            break;
        case 'normal':
            return '<label class="badge badge-success">عادی</label>';
            break;
        case 'high':
            return '<label class="badge badge-warning">بالا</label>';
            break;
        case 'critical':
            return '<label class="badge badge-danger">فوری</label>';
            break;
    }
}

function getTicketStatus($status)
{
    switch ($status) {
        case 'waiting':
            return '<label class="badge badge-success">جدید</label>';
            break;
        case 'admin_answer':
            return '<label class="badge badge-success">پاسخ ادمین</label>';
            break;
        case 'user_answer':
            return '<label class="badge badge-success">پاسخ کاربر</label>';
            break;
        case 'closed':
            return '<label class="badge badge-warning">بسته</label>';
            break;
    }
}

function getUserMode($status)
{
    switch ($status) {
        case 'active':
            return '<label class="badge badge-success">فعال</label>';
            break;
        case 'block':
            return '<label class="badge">غیرفعال</label>';
            break;
    }
}

function getJobOfferLink($link)
{

    return '<a target="_blank" href="' . $link . '">' . 'مشاهده' . '</a>';
}

function convertCreateAtToPersianDateTime($createdAt)
{
    $date = Jalalian::forge(Carbon::createFromFormat('Y-m-d H:i:s', $createdAt));
    return $date;

}


function getItemFromCombination($id)
{
    if ($id == 8595100) {
        return "هر دو";
    } elseif ($id == 8595200) {
        return "همه ساعات کاری";

    } elseif ($id == 8595300) {
        return "همه حالات همکاری";

    } elseif ($id == 8595400) {
        return "همه سوابق کاری ";

    } elseif ($id == 8595600) {
        return "همه شغل ها";

    } elseif ($id == 8595700) {
        return "همه رشته های تحصیلی";

    } elseif ($id == 8595500) {
        return "همه مقاطع تحصیلی";

    } elseif ($id == 8595800) {
        return "انتخاب نشده";

    } elseif ($id == 8595900) {
        return "انتخاب نشده";

    } elseif ($id == 85951000) {
        return "انتخاب نشده";

    } elseif ($id == 85951100) {
        return "انتخاب نشده";

    } else {
        $item = CtegoriesCombination::where('service_id', $id)->first();
        if ($item) {
            return $item->title;

        } else {
            return "";
        }
    }


}


function getUserSubscribedJobs($id)
{
    $text = "";
    $subscribe = UserAutomaticSubscription::find($id);
    if ($subscribe->job_id == 8595600) {
        return "نیازی نیست";
    } else {
        $item = CtegoriesCombination::where('service_id', $subscribe->job_id)->first();
        if ($item) {
            $text = $item->title;
        }
        if ($subscribe->second_job_id == 8595800) {
            return $text;
        } else {
            $item = CtegoriesCombination::where('service_id', $subscribe->second_job_id)->first();
            if ($item) {
                $text .= ' - ' . $item->title;
            }
            if ($subscribe->third_job_id == 85951000) {
                return $text;
            } else {
                $item = CtegoriesCombination::where('service_id', $subscribe->third_job_id)->first();
                if ($item) {
                    $text .= ' - ' . $item->title;
                }
                return $text;
            }
        }

    }


}

function getUserSubscribedEducation($id)
{
    $text = "";
    $subscribe = UserAutomaticSubscription::find($id);
    if ($subscribe->education_id == 8595700) {
        return "نیازی نیست";
    } else {
        $item = CtegoriesCombination::where('service_id', $subscribe->education_id)->first();
        if ($item) {
            $text = $item->title;
        }
        if ($subscribe->second_education_id == 8595900) {
            return $text;
        } else {
            $item = CtegoriesCombination::where('service_id', $subscribe->second_education_id)->first();
            if ($item) {
                $text .= ' - ' . $item->title;
            }
            if ($subscribe->third_education_id == 85951100) {
                return $text;
            } else {
                $item = CtegoriesCombination::where('service_id', $subscribe->third_education_id)->first();
                if ($item) {
                    $text .= ' - ' . $item->title;
                }
                return $text;
            }
        }

    }


}

function getCountOfSubscribersJobField($id)
{
    return UserAutomaticSubscription::where('job_id', $id)->orWhere('second_job_id', $id)->orWhere('third_job_id', $id)->count();
}

function getCountOfSubscribersEducation($id)
{
    return UserAutomaticSubscription::where('education_id', $id)->orWhere('second_education_id', $id)->orWhere('third_education_id', $id)->count();
}

function sendPhoto($file, $fileName, $caption, $chatId)
{
    Telegram::sendPhoto([

        "chat_id" => $chatId,
        "photo" => createInput($file, $fileName),
        "caption" => $caption

    ]);
}

function uploadAttachment($request): string
{
    $imageName = '';
    $imageName = time() . '.' . $request->attachment->extension();
    $request->attachment->move(public_path('uploads/ask'), $imageName);
    return $imageName;

}
function createContactArray($contact): array
{
    $res=[];
    array_push($res,["phone"=>convertPhoneNumberToArray('phone',$contact)]);
    array_push($res,["register_link"=>convertPhoneNumberToArray('register_link',$contact)]);
    array_push($res,["website"=>convertPhoneNumberToArray('website',$contact)]);
    array_push($res,["whatsapp"=>convertPhoneNumberToArray('whatsapp',$contact)]);
    array_push($res,["telegram"=>convertPhoneNumberToArray('telegram',$contact)]);
    array_push($res,["address"=>convertPhoneNumberToArray('address',$contact)]);
    array_push($res,["email"=>convertPhoneNumberToArray('email',$contact)]);
    return $res;
}

function convertPhoneNumberToArray($type,$item)
{
    switch ($type) {
        case 'register_link' :
            return  explode(',', $item->registerLink??"");
        case 'phone' :
            return  explode(',', $item->phone??"");
        case 'website':
            return  explode(',', $item->website??"");
        case 'whatsapp':
            return  explode(',', $item->whatsapp??"");
        case 'telegram':
            return  explode(',', $item->telegram??"");
        case 'address':
            return  explode(',', $item->address??"");
        case 'email':
            return  explode(',', $item->email??"");
    }

    function generateGrades() :array
    {
        $res=[];
        array_push($res,["زیر دیپلم"=>21891]);
        array_push($res,["دیپلم"=>21892]);
        array_push($res,["فوق دیپلم"=>21893]);
        array_push($res,["لیسانس"=>21894]);
        array_push($res,["فوق لیسانس"=>21895]);
        array_push($res,["دکتری"=>21896]);
        return $res;
    }

}
