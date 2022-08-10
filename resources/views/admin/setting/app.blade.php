@extends('admin.layout.layout')
@section('title','تنظیمات اپلیکیشن')
@section('page')
    <div class="widget has-shadow">
        <div class="widget-header bordered no-actions"><h5>تنظیمات اپلیکیشن</h5></div>
        <form method="post" action="/admin/setting/store">
            <div class="widget-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label>لینک دانلود فایل اندروید</label>
                            <input type="text" class="form-control" name="android_download_link"
                                   value="{!! getOption('android_download_link') !!}">
                        </div>
                        <div class="col-12 col-md-6">
                            <label>توضیحات دانلود اپ</label>
                            <input type="text" class="form-control" name="app_download_description"
                                   value="{!! getOption('app_download_description') !!}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label>لینک دانلود فایل ios</label>
                            <input type="text" class="form-control" name="ios_download_link"
                                   value="{!! getOption('ios_download_link') !!}">
                        </div>
                        <div class="col-12 col-md-6">
                            <label>لیتک اینستاگرام</label>
                            <input type="text" class="form-control" name="instagram_link"
                                   value="{!! getOption('instagram_link') !!}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label>setting.nivad_api_keyios</label>
                            <input type="text" class="form-control" name="nivad_api_keyios"
                                   value="{!! getOption('nivad_api_keyios') !!}">
                        </div>
                        <div class="col-12 col-md-6">
                            <label>setting.nivad_app_secret</label>
                            <input type="text" class="form-control" name="nivad_app_secret"
                                   value="{!! getOption('nivad_app_secret') !!}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <label>کد بازار</label>
                            <input type="text" class="form-control" name="bazar_code"
                                   value="{!! getOption('bazar_code') !!}">
                        </div>
                        <div class="col-12 col-md-4">
                            <label>setting.socialServiceApi</label>
                            <input type="text" class="form-control" name="social_service_api"
                                   value="{!! getOption('social_service_api') !!}">
                        </div>
                        <div class="col-12 col-md-4">
                            <label>setting.bazar_active</label>
                            <input type="text" class="form-control" name="bazar_active"
                                   value="{!! getOption('bazar_active') !!}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>پکیج اپلیکیشن</label>
                    <input type="text" class="form-control text-center" name="app_package"
                           value="{!! getOption('app_package') !!}">
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="h-10"></div>
                            <div class="h-10"></div>
                            <div class="h-10"></div>
                            <input type="hidden" name="ads-enable" value="0">
                            <input type="checkbox" name="ads-enable" value="1"
                                   @if(getOption('ads-enable',0) == 1) checked @endif>&nbsp;فعالسازی تبلیغات
                        </div>
                        <div class="col-12 col-md-6">
                            <label>init key</label>
                            <input type="text" class="form-control" name="init-key"
                                   value="{!! getOption('init-key') !!}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label>reward banner</label>
                            <input type="text" class="form-control" name="reward-banner"
                                   value="{!! getOption('reward-banner') !!}">
                        </div>
                        <div class="col-12 col-md-6">
                            <label>banner key</label>
                            <input type="text" class="form-control" name="banner-key"
                                   value="{!! getOption('banner-key') !!}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <label>نمایش پاپ آپ در نرم افزار</label>
                            <select name="start_app_pop_up" class="form-control">
                                <option value="1" @if(getOption('start_app_pop_up') == '1') selected @endif>فعال
                                </option>
                                <option value="0" @if(getOption('start_app_pop_up') =='0') selected @endif>غیرفعال
                                </option>
                            </select>
                        </div>
                        <div class="col-12 col-md-5">
                            <label>متن پاپ آپ</label>
                            <input type="text" class="form-control" name="start_app_pop_up_text"
                                   value="{!! getOption('start_app_pop_up_text') !!}">
                        </div>
                        <div class="col-12 col-md-4">
                            <label>لینک پاپ آپ</label>
                            <input type="text" class="form-control" name="start_app_pop_up_url"
                                   value="{!! getOption('start_app_pop_up_url') !!}">
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
