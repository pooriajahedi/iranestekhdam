@extends('admin.layout.layout')
@section('title','تنظیمات درگاه پیامک')
@section('page')
    <div class="widget">
        <div class="widget-header bordered no-actions">
            <h4>تنظیمات درگاه پیامک</h4>
        </div>
        <form method="post" action="/admin/setting/store">
            <div class="widget-body">
                <div class="form-group">
                    <label>انتخاب درگاه پیامک</label>
                    <select name="sms_gateway" class="form-control">
                        <option value="off" @if(getOption('sms_gateway') == 'off') selected @endif>خاموش</option>
                        <option value="smsir" @if(getOption('sms_gateway') == 'smsir') selected @endif>اس ام اس آی آر</option>
                        <option value="kavenegar" @if(getOption('sms_gateway') == 'kavenegar') selected @endif>کاوه نگار</option>
                    </select>
                </div>
                <div class="alert alert-info" role="alert">
                     جهت بروزرسانی کلید کاوه نگار فایل .env موجود در روت را با یک ادیتور باز کرده و کلید تبادل را بدون فاصله جلوی عبارت KAVENEGAR_APIKEY تایپ کنید
                </div>
                <div class="alert alert-info" role="alert">
                     جهت بروزرسانی کلید اس ام اس آی‌آر فایل .env موجود در روت را با یک ادیتور باز کرده و همه قسمت‌های بخش SmsIr را تکمیل کنید
                </div>
                <div class="alert alert-warning" role="alert">
                    <strong>هنگام تایپ یا جایگزاری اطلاعات در فایل .env از قرار دادن فاصله اجتناب کنید!</strong>
                </div>
            </div>
            <div class="widget-footer text-right">
                <input type="submit" class="btn btn-primary" value="ثبت">
            </div>
        </form>
    </div>
@endsection
