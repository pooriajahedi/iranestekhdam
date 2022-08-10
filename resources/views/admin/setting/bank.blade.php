@extends('admin.layout.layout')
@section('title','تنظیمات مالی')
@section('page')
    <div class="widget has-shadow">
        <div class="widget-header bordered no-actions">
            <h5>تنظیمات مالی</h5>
        </div>
        <form method="post" action="/admin/setting/store">
            <div class="widget-body">
                <div class="form-group">
                    <label>درگاه پیشفرض</label>
                    <select name="default_gateway" class="form-control">
                        <option @if(getOption('default_gateway') == 'zarinapl') selected @endif value="zarinpal">زرین پال</option>
                        <option @if(getOption('default_gateway') == 'payir') selected @endif value="payir">پی</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="form-group">
                            <label>مرچنت کد زرین‌پال</label>
                            <input type="text" class="form-control text-center" dir="ltr" name="zarinpal_merchant" value="{!! getOption('zarinpal_merchant') !!}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>پرداخت بیت کوین</label>
                            <select name="bitcoin_payment" class="form-control">
                                <option value="1" @if(getOption('bitcoin_payment') == 1) selected @endif>فعال</option>
                                <option value="0" @if(getOption('bitcoin_payment') == 0) selected @endif>غیرفعال</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="alert alert-warning" role="alert">
                    <strong>توجه</strong>
                    <span>درصورتی که درگاه پی را به عنوان درگاه پیشفرض انتخاب کردید ابتدا مقدار api_key را در فایل env وارد کنید</span>
                </div>
            </div>
            <div class="widget-footer text-right">
                <input type="submit" class="btn btn-primary" value="ثبت تغییرات">
            </div>
        </form>
    </div>
@stop
