<?php


namespace App\Http\Traits;


trait MessageKeywordIncomingHandlerTrait
{

    public function ReturnKey(): string
    {
        return "بازگشت 🔙";
    }
    public function NotNeeded(): string
    {
        return "نیاز نیست";
    }
    public function NewKeyWord(): string
    {
        return "کلیدواژه جدید";
    }
    public function RetrySelection(): string
    {
        return "انتخاب مجدد";
    }
    public function RetrySet(): string
    {
        return "تنظیم مجدد";
    }
    public function YesSelection(): string
    {
        return "بله";
    }
    public function NoSelection(): string
    {
        return "خیر";
    }
    public function FinishSelection(): string
    {
        return "بازگشت به منوی اصلی";
    }

    public function GetStartKeyword(): string
    {
        return "/start";
    }

    public function GetSubscriptionKey(): string
    {
        return "تنظیمات دریافت خودکار آگهی به تفکیک مورد نیاز شما";
    }
    public function SearchAmongAll(): string
    {
        return "جستجوی متنی بین همه فرصت های شغلی";
    }

    public function GovernmentsAdBanksHiring(): string
    {
        return "استخدام سازمان های دولتی و بانکها";
    }
    public function SubmitJobOffersForEmployer(): string
    {
        return "درج آگهی استخدام";
    }
    public function OtherIranEstekhdamServices(): string
    {
        return "سایر امکانات ایران استخدام";
    }

    public function RegisterInVirtualJobFinding(): string
    {
        return "ثبت نام در کاریابی مجازی";
    }

    public function BanksHiring(): string
    {
        return "استخدام  بانکها 🏧";
    }
    public function GovernmentalHiring(): string
    {
        return "استخدام  موسسات دولتی 🏢";
    }

    //region Subscription Main menu
    public function SelectStateKey(): string
    {
        return "انتخاب استان";
    }
    public function DisableSubscription(): string
    {
        return "غیر فعال کردن دریافت خودکار";
    }
    //endregion

    //region State selection
    public function ret(): string
    {
        return "انتخاب استاد";
    }
    //endregion

    //region Sex Selection
    public function MaleKey(): string
    {
        return "مرد";
    }

    public function FemaleKey(): string
    {
        return "زن";
    }
    //endregion

    //region Work Time Selection
    public function FullTime(): string
    {
        return "تمام وقت";
    }

    public function PartTime(): string
    {
        return "نیمه وقت";
    }

    public function NotMatter(): string
    {
        return "فرقی نمی کند";
    }

    //endregion

    //region Job Experience
    public function NeedExperience(): string
    {
        return "داشته باشد";
    }

    public function NoExperience(): string
    {
        return "نداشته باشد";
    }


    //endregion

    //region Has Experience
    public function OneYear(): string
    {
        return "1 سال";
    }

    public function TwoYears(): string
    {
        return "2 سال";
    }

    public function ThreeYears(): string
    {
        return "3 سال";
    }

    public function FourYears(): string
    {
        return "4 سال";
    }

    public function FiveToNineYears(): string
    {
        return "5 الی 9 سال";
    }

    public function MoreThanTenYears(): string
    {
        return "بیشتر از 10 سال";
    }

    public function NotHavingExperience(): string
    {
        return "بدون سابقه";
    }


    //endregion
    //region Job Mode Selection
    public function InPlaceButton(): string
    {
        return "حضوری";
    }

    public function RemoteWorkButton(): string
    {
        return "دورکار";
    }

    public function NewBieLearnerButton(): string
    {
        return "کاراموز";
    }

    public function StudentButton(): string
    {
        return "دانشجو";
    }
    public function RetiredButton(): string
    {
        return "بازنشسته";
    }

    //endregion

    //region Maghate Tahsili
    public function UnderDiploma(): string
    {
        return "زیر دیپلم";
    }
    public function Diploma(): string
    {
        return "دیپلم";
    }
    public function AboveDiploma(): string
    {
        return "فوق دیپلم";
    }
    public function Bachelor(): string
    {
        return "لیسانس";
    }
    public function MA(): string
    {
        return "فوق لیسانس";

    }
    public function PHD(): string
    {
        return "دکتری";

    }
    //endregion

    //region First Setting Submitted
    public function Continue(): string
    {
        return "ادامه";
    }
    public function ResetAutomaticSubscription(): string
    {
        return "تنظیم مجدد دریافت";
    }
    //endregion


    //region Search
    public function NextRecords(): string
    {
        return "صفحه بعد";
    }
    public function PreviousRecords(): string
    {
        return "صفحه قبل";
    }
    public function NoResultFound(): string
    {
        return "نتیجه ای یافت نشد";
    }
    public function NoResultFoundInSubscription(): string
    {
        return "متأسفانه جستجوی شما نتیجه ای نداشت، لطفاً با کلمات کلیدی دیگری امتحان کنید.";
    }
    //endregion

    //region other option
    public function GoToMainWebSite(): string
    {
        return "رفتن به سایت اصلی 💻";
    }

    public function Application(): string
    {
        return "اپلیکیشن استخدام 📱";
    }

    public function CreateAndReceiveCV(): string
    {
        return "ساخت و دریافت فایل روزمه 📝";
    }
    public function HiringQuestionsSample(): string
    {
        return "نمونه سوالات استخدامی 🖊";
    }
    public function HiringBooksAndQuestion(): string
    {
        return "جزوات و کتاب های استخدامی 📕";
    }
    public function IntoduceIranEstekhdam(): string
    {
        return "کلیپ معرفی ایران استخدام 📽";
    }
    public function ContactUs(): string
    {
        return "تماس با ما 📞";
    }

    //endregion

}
