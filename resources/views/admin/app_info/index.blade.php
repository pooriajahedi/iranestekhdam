@extends('admin.layout.layout')
@section('title','تنظیمات نرم افزار')
@section('page')
    <div class="widget has-shadow">
        <div class="widget-header bordered no-actions d-flex align-items-center">
            <h4>ویرایش تنظیمات نرم افزار </h4>
        </div>
        <form action="{{route('appInfo.update')}}" method="post">
            @csrf
            <div class="widget-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label>نسخه نرم افزار</label>
                            <input type="text" class="form-control"  name="app_version"
                                   value="{!! $appInfo->app_version ?? '' !!}">
                        </div>
                        <div class="col-md-4">
                            <label>پیام نسخه جدید</label>
                            <input type="text" class="form-control" name="update_note"
                                   value="{!! $appInfo->update_note ?? '' !!}">
                        </div>
                        <div class="col-md-4">
                            <label>لینک دانلود اخرین نسخه</label>
                            <input type="text" class="form-control" name="download_url"
                                   value="{!! $appInfo->download_url ?? '' !!}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label>اجباری بودن به روز رسانی</label>
                            <select  name="force_update" class="form-control">
                                <option value="1"
                                        @if($appInfo->force_update == '1') selected @endif>اجباری
                                </option>
                                <option value="0"
                                        @if($appInfo->force_update == '0') selected @endif>اختیاری
                                </option>

                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>لینک ارسال رزومه</label>
                            <input type="text" class="form-control" name="resume_url"
                                   value="{!! $appInfo->resume_url ?? '' !!}">
                        </div>
                        <div class="col-md-4">
                            <label>متن اشتراک گزاری</label>
                            <input type="text" class="form-control" name="share_text"
                                   value="{!! $appInfo->share_text ?? '' !!}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label>متن درباره ما</label>
                            <input type="text" class="form-control" name="about_text"
                                   value="{!! $appInfo->about_text ?? '' !!}">
                        </div>

                        <div class="col-md-4">
                            <label>ایمیل</label>
                            <input type="text" class="form-control" name="email"
                                   value="{!! $appInfo->email ?? '' !!}">
                        </div>
                        <div class="col-md-4">
                            <label>آدرس</label>
                            <input type="text" class="form-control" name="address"
                                   value="{!! $appInfo->address ?? '' !!}">
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label>تلفن تماس</label>
                            <input type="text" class="form-control" name="tel"
                                   value="{!! $appInfo->tel ?? '' !!}">
                        </div>

                        <div class="col-md-4">
                            <label>وب سایت</label>
                            <input type="text" class="form-control" name="website"
                                   value="{!! $appInfo->website ?? '' !!}">
                        </div>
                        <div class="col-md-4">
                            <label>لینک کانال تلگرام</label>
                            <input type="text" class="form-control" name="telegram_id"
                                   value="{!! $appInfo->telegram_id ?? '' !!}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget-footer text-right">

                <input type="submit" class="btn btn-primary"
                       value=" ویرایش">
            </div>
        </form>
    </div>
@endsection
