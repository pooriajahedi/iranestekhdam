@extends('admin.layout.layout')
@section('title','تنظیمات ربات')
@section('page')
    <div class="widget has-shadow">
        <div class="widget-header bordered no-actions"><h5>تنظیمات ربات</h5></div>
        <form method="post" action="{{route('setting.store.bot')}}">
            @csrf
            <div class="widget-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <label>لینک سایت اصلی</label>
                            <input type="text" class="form-control" name="url"
                                   value="{!! \App\Helpers\getOptions('url') !!}">
                        </div>

                    </div>
                </div>

                <hr>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label>لینک دانلود گوگل پلی</label>
                            <input type="text" class="form-control" name="app_google_play"
                                   value="{!! \App\Helpers\getOptions('app_google_play') !!}">
                        </div>
                        <div class="col-12 col-md-6">
                            <label>لیتک دانلود بازار</label>
                            <input type="text" class="form-control" name="app_bazar"
                                   value="{!! \App\Helpers\getOptions('app_bazar') !!}">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label>ساخت رزومه</label>
                            <input type="text" class="form-control" name="create_cv"
                                   value="{!! \App\Helpers\getOptions('create_cv') !!}">
                        </div>
                        <div class="col-12 col-md-6">
                            <label>نمونه سوالات استخدامی</label>
                            <input type="text" class="form-control" name="hiring_questions_example"
                                   value="{!! \App\Helpers\getOptions('hiring_questions_example') !!}">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label>جزوات و کتاب ها</label>
                            <input type="text" class="form-control" name="hiring_sample_books"
                                   value="{!! \App\Helpers\getOptions('hiring_sample_books') !!}">
                        </div>
                        <div class="col-12 col-md-6">
                            <label>کاربابی مجازی</label>
                            <input type="text" class="form-control" name="virtual_finding_job"
                                   value="{!! \App\Helpers\getOptions('virtual_finding_job') !!}">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label>ثبت نام کارفرمایان</label>
                            <input type="text" class="form-control" name="employers_submit_job_offer"
                                   value="{!! \App\Helpers\getOptions('employers_submit_job_offer') !!}">
                        </div>
                        <div class="col-12 col-md-6">
                            <label>تماس با ما</label>
                            <input type="text" class="form-control" name="contact_us"
                                   value="{!! \App\Helpers\getOptions('contact_us') !!}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget-footer text-right">
                <input type="submit" class="btn btn-primary" value="ثبت تغییرات">
            </div>
        </form>
    </div>
@stop
