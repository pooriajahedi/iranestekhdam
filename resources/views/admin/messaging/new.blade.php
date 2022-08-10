@extends('admin.layout.layout')
@section('title','ارسال پیام همگانی')
@section('page')
    <div class="widget has-shadow">
        <div class="widget-header bordered no-actions d-flex align-items-center">
            <h4>ارسال پیام گروهی به تمام کاربران </h4>
        </div>
        <form enctype="multipart/form-data" method="post" action="{{route('messaging.send')}}">
            @csrf

            <div class="widget-body">
                <div class="form-group">
                    <label class="text text-primary">* جهت جلوگیری از اسپم شدن توسط سرور های تلگرام ، پیام با تاخیری در حدود 10 الی 20 ثانیه و با وقفه 3 ثانیه ای ارسال خواهد شد</label>
                    <div class="row">
                        <div class="col-md-4">
                            <label>متن پیام</label>
                            <textarea rows = "5" required cols = "120" name = "name"></textarea>
                        </div>

                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label>عکس </label>
                            <input data-label="Upload" name="picture" class="form-control" type="file">
                            <label class="text text-primary">* در صورتی که عکس وارد نشود پیام به صورت متنی ارسال خواهد شد</label>

                        </div>

                    </div>
                </div>

            </div>
            <div class="widget-footer text-right">
                <input type="submit" class="btn btn-primary" @if(!isset($edit)) value="ثبت جدید"
                       @else value="ثبت ویرایش" @endif>
            </div>
        </form>
    </div>
@endsection
