@extends('admin.layout.layout')
@section('title','تنظیمات محتوی')
@section('page')
    <div class="widget has-shadow">
        <div class="widget-header bordered no-actions"><h5>تنظیمات محتوی</h5></div>
        <form method="post" action="/admin/setting/store">
            <div class="widget-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label>عنوان متن اول</label>
                            <input type="text" class="form-control" name="content_1_title" value="{!! getOption('content_1_title') !!}">
                        </div>
                        <div class="col-12 col-md-6">
                            <label>عنوان متن دوم</label>
                            <input type="text" class="form-control" name="content_2_title" value="{!! getOption('content_2_title') !!}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>متن اول</label>
                    <textarea class="form-control" name="content_1_text" rows="10">{!! getOption('content_1_text') !!}</textarea>
                </div>
                <div class="form-group">
                    <label>متن دوم</label>
                    <textarea class="form-control" name="content_2_text" rows="10">{!! getOption('content_2_text') !!}</textarea>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label>ایمیل تماس</label>
                            <input type="text" class="form-control text-left" name="contact_email" value="{!! getOption('contact_email') !!}">
                        </div>
                        <div class="col-12 col-md-6">
                            <label>تلفن تماس</label>
                            <input type="text" class="form-control text-left" dir="ltr" name="contact_phone" value="{!! getOption('contact_phone') !!}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label>لینک تلگرام</label>
                            <input type="text" class="form-control text-left" name="telegram_url" value="{!! getOption('telegram_url') !!}">
                        </div>
                        <div class="col-12 col-md-6">
                            <label>لینک اینستاگرام</label>
                            <input type="text" class="form-control text-left" dir="ltr" name="instagram_url" value="{!! getOption('instagram_url') !!}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>کد باکس اول</label>
                    <textarea class="form-control" name="nemad_1_code" rows="10">{!! getOption('nemad_1_code') !!}</textarea>
                </div>
                <div class="form-group">
                    <label>کد باکس دوم</label>
                    <textarea class="form-control" name="nemad_2_code" rows="10">{!! getOption('nemad_2_code') !!}</textarea>
                </div>

            </div>
            <div class="widget-footer text-right">
                <input type="submit" class="btn btn-primary" value="ثبت تغییرات">
            </div>
        </form>
    </div>
@stop
