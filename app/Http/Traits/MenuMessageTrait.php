<?php


namespace App\Http\Traits;


trait MenuMessageTrait
{

    public function GetMainMenuMessageText(): string
    {
        return "به ربات ایران استخدام خوش آمدید";
    }

    public function GetMainMenuMessageTextOnNavigateBack(): string
    {
        return "یکی از خدمات زیر را انتخاب کنید";
    }

    public function GetMainMenuMessageForNewlyRegisteredUsersText(): string
    {
        return "کاربر جدید به ربات ایران استخدام خوش آمدید.";
    }

    public function GetSubscriptionMenuText(): string
    {
        return "در این قسمت تنظیمات مربوط به دریافت خودکار پیام های استخدامی را تنظیم کنید:";
    }

    public function blocked(): string
    {
        return "حساب شما به دلایل مسایل امنیتی مسدود شده است";
    }

    public function GetBanksAndGovernmentHiring(): string
    {
        return "یکی از دسته های زیر را انتخاب کنید";
    }

    public function GetSubscriptionMenuSelectStateText(): string
    {
        return "استان را انتخاب کنید:";
    }

    public function GetSubscriptionMenuSelectSexText(): string
    {
        return "جنسیت را انتخاب کنید:";
    }

    public function GetSubscriptionMenuWorkTimeModeSelectionText(): string
    {
        return "نوع ساعت کاری را انتخاب کنید:";
    }

    public function GetSubscriptionJobTypeText(): string
    {
        return "نوع همکاری را انتخاب کنید :";
    }

    public function GetSubscriptionExperienceText(): string
    {
        return "سابقه داشته باشد ؟ ";
    }

    public function GetMaghateTahsiliText(): string
    {
        return "مقطع تحصیلی مورد نظر را انتخاب کنید";
    }

    public function SelectJobText(): string
    {
        return "شغل مورد نظر خود را انتخاب کنید";
    }

    public function SelectFromJobsBelow(): string
    {
        return "از شغل های  زیر انتخاب کنید";
    }

    public function SelectFromEducationBelow(): string
    {
        return "از رشته های  زیر انتخاب کنید";
    }

    public function searchInJobs(): string
    {
        return "قصد دارید که آگهی های استخدام کدام شغل به صورت روزانه برای شما ارسال شود؟
❎ لطفاً جهت انتخاب، قسمتی از نام شغل را ارسال کنید.
✅ به عنوان مثال: منشی یا کارمند یا برق یا مکانیک یا مهندس عمران و...";
    }

    public function searchInJobsThird(): string
    {
        return "جهت جستجوی عنوان شغلی سوم ،  نظر قسمتی از نام را وارد کنید به عنوان مثال : برق";
    }

    public function searchInEducations(): string
    {
        return "قصد دارید که آگهی های استخدام کدام \"رشته تحصیلی\" به صورت روزانه برای شما ارسال شود؟
❎ لطفاً جهت انتخاب، قسمتی از نام\"رشته تحصیلی\" را ارسال کنید.
✅ به عنوان مثال: عمران، حسابدار، مدیریت بازرگانی و...";
    }

    public function SelectEducationText(): string
    {
        return "رشته تحصیلی مورد نظر را از لیست زیر انتخاب کنید :";
    }

    public function SelectAnOtherJobText(): string
    {
        return "آیا علاوه بر این شغل انتخاب شده قصد انتخاب شغل دیگری را هم به صورت همزمان دارید؟ (امکان انتخاب تا 3 شغل همزمان وجود دارد)";
    }

    public function SelectAnOtherEducationText(): string
    {
        return "آیا علاوه بر این رشته انتخاب شده قصد انتخاب رشته دیگری را هم به صورت همزمان دارید؟ (امکان انتخاب تا 3 شغل همزمان وجود دارد)";
    }

    public function SelectEducationTextSecond(): string
    {
        return " رشته تحصیلی را انتخاب کنید ؟";
    }

    public function FirstSettingSubmittedMessage(): string
    {
        return "تنظیمات دریافت آگهی شما ذخیره شد، از این پس شما آگهی های استخدامی ایران استخدام را با این تنظیمات دریافت خواهید کرد:";
    }

    public function FirstSettingSubmittedMessageSecond(): string
    {
        return "تنظیمات دریافت خودگار آگهی برای شفل و رشته دوم ذخیره شد، تمایل به انتخاب دیگر رشته ها و مشاغل هم دارید ؟ ";
    }

    public function StepDone(): string
    {
        return "تنظیمات دریافت آگهی شما ذخیره شد، از این پس شما آگهی های استخدامی ایران استخدام را با این تنظیمات دریافت خواهید کرد:";
    }

    public function SecondSettingSubmittedMessage(): string
    {
        return "تنظیمات دریافت خودگار آگهی دومین رشته و شغل ذخیره شد، تمایل به انتخاب دیگر رشته ها و مشاغل هم دارید ؟ ";
    }

    public function AmountOfExperience(): string
    {
        return "مدت زمان سابقه ؟";
    }

    public function EnterKeyWordToSearch(): string
    {
        return "کلید واژه مورد نظر را جهت جستجو وارد کنید:(یک کلید واژه مانند \"تهران\" \"حسابدار\" \"منشی\" \"کاراموز\")";
    }

    public function SelectDesireService(): string
    {
        return "یکی از سرویس های زیر را انتخاب کنید";
    }

    public function MainWebSiteItemMessage(): string
    {
        return "💢جهت استفاده از تمامی امکانات سایت ایران استخدام، از جمله مشاهده فرصتهای کاریابی، ساخت رزومه، آزمونهای آنلاین رایگان و ده ها امکانات دیگر بر روی لینک زیر کلیک کنید:
🔗https://iranestekhdam.ir/";
    }

    public function DownloadUrlMessage(): string
    {
        return "📲 از طریق اپلیکیشن سایت ایران استخدام بدون پرداخت هیچ گونه هزینه ای قادر خواهید بود که بر اساس \"استان\" و \"شغل\" و \"رشته تحصیلی\" مورد نظر خود تمام فرصت های شغلی سازمانهای دولتی و مراکز خصوصی و بانکها را به محض انتشار دریافت نمایید.
🔻امکانات:
◽️امکان تنظیم دریافت خودکار و کاملا هدفمند  آگهی های استخدامی بر اساس استان ، شغل ، رشته تحصیلی و جنسیت مورد نظر شما
◽️فعالسازی هشدار خودکار از طریق اعلانهای گوشی در صورت دریافت آگهی های جدید استخدامی متناسب با تنظیمات انجام شده شما
◽️امکان ذخیره سازی آگهی های مورد علاقه شما در بخش علاقه‌مندی‌ها
◽️بخش اختصاصی نمایش آگهی های استخدامی بانکها ، سازمانهای دولتی و شرکتهای خصوصی به صورت مجزا
◽️بخش اختصاصی نمایش تمامی آگهی های استخدام کشور بر اساس دسته بندی استانها به صورت مجزا
◽️بخش اختصاصی نمایش تمامی آگهی های استخدام کشور بر اساس شغل مورد نظر شما به صورت مجزا
◽️بخش اختصاصی نمایش تمامی آگهی های استخدام کشور بر اساس رشته تحصیلی مورد نظر شما به صورت مجزا
◽️بخش اختصاصی نمایش جدیدترین اخبار منتشر شده در زمینه اشتغال کارمندان و کارگران
◽️امکان جستجوی اختصاصی در بین آگهی های استخدامی کشور بر اساس انتخاب شما
◽️امکان اشتراک گذاری و ارسال به دیگران آگهی های استخدامی";
    }
}
