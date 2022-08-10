@extends('admin.layout.layout')
@section('title','تنظیمات')
@section('page')
    <div class="widget has-shadow">
        <div class="widget-header bordered no-actions">
            <h5>تنظیمات اصلی</h5>
        </div>
        <form method="post" action="/admin/setting/store">
            <div class="widget-body">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label>عنوان سایت</label>
                            <input type="text" class="form-control" name="site_title" value="{!! getOption('site_title') !!}">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label>کلمات کلیدی</label>
                            <input type="text" class="form-control" name="site_keyword" value="{!! getOption('site_keyword') !!}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>توصیف سایت</label>
                    <input type="text" class="form-control" name="site_description" value="{!! getOption('site_description') !!}">
                </div>
                <div class="form-group">
                    <label>کپی رایت</label>
                    <input type="text" class="form-control" name="site_copyright" value="{!! getOption('site_copyright') !!}">
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <label>ایمیل اصلی سایت</label>
                            <input type="email" class="form-control text-right" dir="ltr" name="admin_email" value="{!! getOption('admin_email') !!}">
                        </div>
                        <div class="col-6">
                            <label>ایمیل ارسال اطلاعیه</label>
                            <input type="email" class="form-control text-right" dir="ltr" name="alert_email" value="{!! getOption('alert_email') !!}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <label>نوع ثبت نام کاربر جدید</label>
                            <select name="register_type" class="form-control">
                                <option value="not_confirm" @if(getOption('register_type') == 'register_type') selected @endif>بدون تایید</option>
                                <option value="email_confirm" @if(getOption('register_type') == 'email_confirm') selected @endif>تایید ایمیل</option>
                                <option value="sms_confirm" @if(getOption('register_type') == 'sms_confirm') selected @endif>تایید پیامکی</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label>مبلغ هدیه مشاهده تبلیغات</label>
                            <div class="input-group">
                                <input type="text" class="form-control text-center" name="coin_amount" value="{!! getOption('coin_amount',10) !!}">
                                <div class="input-group-append">
                                    <span class="input-group-text">تومان</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>متن بخش هدیه معرف</label>
                    <textarea class="form-control" rows="10" name="ref_code_description">{!! getOption('ref_code_description','') !!}</textarea>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <label>مبلغ هدیه معرفی شده</label>
                            <div class="input-group">
                                <input type="number" name="get_ref_amount" class="form-control text-center" value="{!! getOption('get_ref_amount') !!}">
                                <div class="input-group-append">
                                    <span class="input-group-text">تومان</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <label>مبلغ هدیه معرفی کننده</label>
                            <div class="input-group">
                                <input type="number" name="ref_amount" class="form-control text-center" value="{!! getOption('ref_amount') !!}">
                                <div class="input-group-append">
                                <span class="input-group-text">تومان</span>
                            </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <label>هزینه هر گردونه شانس</label>
                            <div class="input-group">
                                <input type="number" name="chance_price" class="form-control text-center" value="{!! getOption('chance_price') !!}">
                                <div class="input-group-append">
                                <span class="input-group-text">تومان</span>
                            </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <label>مبلغ هدیه کامنت گوگل</label>
                            <div class="input-group">
                                <input type="number" name="google_comment_amount" class="form-control text-center" value="{!! getOption('google_comment_amount') !!}">
                                <div class="input-group-append">
                                <span class="input-group-text">تومان</span>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <label>تعداد نظرات نمایشی سایت</label>
                            <input type="number" class="form-control text-center" name="site_comment_count" value="{!! getOption('site_comment_count') !!}">
                        </div>
                        <div class="col-12 col-md-3">
                            <label>تعداد نظرات نمایشی اپلیکیشن</label>
                            <input type="number" class="form-control text-center" name="app_comment_count" value="{!! getOption('app_comment_count') !!}">
                        </div>
                        <div class="col-12 col-md-3">
                            <label>وضعیت نمایش نظرات</label>
                            <select name="site_comment_enable" class="form-control">
                                <option value="1" @if(getOption('site_comment_enable',0) == 1) selected @endif>فعال</option>
                                <option value="0" @if(getOption('site_comment_enable',0) == 0) selected @endif>غیرفعال</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3">
                            <label>فاصله بین هدیه روزانه</label>
                            <div class="input-group">
                                <input type="number" class="form-control text-center" name="daily_gift_delay" value="{!! getOption('daily_gift_delay') !!}">
                                <span class="input-group-append">
                                    <span class="input-group-text">ساعت</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <label>سرویس دهنده هدیه اعتماد</label>
                            <select name="trust_gift_service" class="form-control">
                                <option value="just_another_panel" @if(getOption('trust_gift_service','') == 'just_another_panel') selected @endif>Just Another Panel</option>
                                <option value="social_service" @if(getOption('trust_gift_service','') == 'social_service') selected @endif>Social Service</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3">
                            <label>شماره سرویس هدیه اعتماد</label>
                            <input type="text" name="trust_gift_service_id" class="form-control text-center" value="{!! getOption('trust_gift_service_id') !!}">
                        </div>
                        <div class="col-12 col-md-3">
                            <label>سرویس دهنده هدیه روزانه</label>
                            <select name="daily_gift_service" class="form-control">
                                <option value="just_another_panel" @if(getOption('daily_gift_service','') == 'just_another_panel') selected @endif>Just Another Panel</option>
                                <option value="social_service" @if(getOption('daily_gift_service','') == 'social_service') selected @endif>Social Service</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3">
                            <label>شماره سرویس هدیه روزانه</label>
                            <input type="text" name="daily_gift_service_id" class="form-control text-center" value="{!! getOption('daily_gift_service_id') !!}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <label>تعداد درخواست هدیه اعتماد</label>
                            <input type="number" class="form-control text-center" name="trust_gift_request_count" value="{!!  getOption('trust_gift_request_count') !!}">
                        </div>
                        <div class="col-12 col-md-3">
                            <label>تعداد درخواست هدیه روزانه</label>
                            <input type="number" class="form-control text-center" name="daily_gift_request_count" value="{!!  getOption('daily_gift_request_count') !!}">
                        </div>
                        <div class="col-12 col-md-3">
                            <label>فاصله بین گردونه شانس</label>
                            <div class="input-group">
                                <input type="number" class="form-control text-center" name="chance_delay" value="{!! getOption('chance_delay') !!}">
                                <span class="input-group-append">
                                    <span class="input-group-text">ساعت</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <label>سرویس دهنده سفارش آزاد</label>
                            <select name="free_order_service" class="form-control">
                                <option value="just_another_panel" @if(getOption('free_order_service','') == 'just_another_panel') selected @endif>Just Another Panel</option>
                                <option value="social_service" @if(getOption('free_order_service','') == 'social_service') selected @endif>Social Service</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3">
                            <label>شماره سرویس سفارش آزاد</label>
                            <input type="number" name="free_order_service_id" class="form-control text-center" value="{!! getOption('free_order_service_id') !!}">
                        </div>
                        <div class="col-12 col-md-3">
                            <label>تعداد درخواست سفارش آزاد</label>
                            <input type="number" class="form-control text-center" name="free_order_request_count" value="{!!  getOption('free_order_request_count') !!}">
                        </div>
                        <div class="col-12 col-md-3">
                            <label>حداکثر تعداد سفارش روزانه</label>
                            <input type="number" class="form-control text-center" name="free_order_request_day" value="{!!  getOption('free_order_request_day') !!}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget-footer text-right">
                <input type="submit" class="btn btn-primary" value="ثبت تغییرات">
            </div>
        </form>
    </div>

    <div class="widget has-shadow">
        <div class="widget-header bordered no-actions">
            <h5>تغییر رمزعبور مدیریت</h5>
        </div>
        <form method="post" action="/admin/setting/password/update">
            <div class="widget-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label>رمز عبور</label>
                            <input type="password" class="form-control text-center" name="password" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label>تکرار رمز عبور</label>
                            <input type="password" class="form-control text-center" name="re_password" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget-footer text-right">
                <input type="submit" class="btn btn-primary" value="تغییر رمز عبور"/>
            </div>
        </form>
    </div>

    <div class="widget has-shadow">
        <div class="widget-header bordered no-actions">
            <h4>ریست اطلاعات</h4>
        </div>
        <div class="widget-body">
            <a href="/admin/setting/reset/google" onclick="return confirm('آیا از ریست کردن دیتابیس کامنت های گوگل اطمینان دارید؟')" class="btn btn-primary">ریست کامنت های گوگل</a>
        </div>
    </div>
@endsection
