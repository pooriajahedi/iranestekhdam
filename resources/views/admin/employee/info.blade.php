@extends('admin.layout.layout')
@section('title','جزئیات درخواست')
@section('page')
    <div class="widget has-shadow">
        <div class="widget-header bordered no-actions d-flex align-items-center">
            <h4>مشاهده جزئیات</h4>
        </div>
        <form>
            <div class="widget-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label>عنوان</label>
                            <input type="text" class="form-control" disabled name="name"
                                   value="{!! $item->title ?? '' !!}">
                        </div>
                        <div class="col-4">
                            <label>تلفن همراه</label>
                            <input type="text" class="form-control" disabled name="name"
                                   value="{!! $item->mobile_number ?? ''!!}">
                        </div>
                        <div class="col-4">
                            <label>وضعیت درخواست</label>
                            <select disabled name="mode" class="form-control">
                                <option value="new"
                                        @if($item->status != null && $item->status=='new')  selected @endif>جدید
                                </option>
                                <option value="reviewed"
                                        @if($item->status != null && $item->status=='reviewed') selected @endif>در
                                    حال بررسی
                                </option>

                                <option value="accepted"
                                        @if($item->status != null && $item->status=='accepted') selected @endif>

                                    پذیرفته شده
                                </option>

                                <option value="rejected"
                                        @if($item->status != null && $item->status=='rejected') selected @endif>

                                    عدم تایید
                                </option>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <label>متن درخواست</label>
                            <input type="text" class="form-control" name="user_name" disabled
                                   value="{!! $item->text ?? '' !!}">
                        </div>

                    </div>
                </div>
                <div class="form-group">
                    <div class="row">

                        <div class="col-4">
                            <label>ایمیل</label>
                            <input type="text" class="form-control" disabled name="name"
                                   value="{!! $item->email ?? '' !!}">
                        </div>
                        <div class="col-4">
                            <label>تلفن </label>
                            <input type="text" class="form-control" disabled name="name"
                                   value="{!! $item->phone_number ?? ''!!}">
                        </div>
                        <div class="col-4">
                            <label>پست الکترونیک</label>
                            <input type="text" class="form-control" disabled name="name"
                                   value="{!! $item->email ?? ''!!}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        @if($item->file_name!=null)
                            <div class="col-2">
                                <a class="btn btn-info" href="{{route('employee.request.download',[$item->id])}}">
                                    دانلود ضمیمه
                                </a>
                            </div>
                        @endif
                    </div>
                </div>


            </div>

        </form>
    </div>
@endsection
