@extends('admin.layout.layout')
@section('title','مدیران')
@section('page')
    <div class="widget has-shadow">
        <div class="widget-header bordered no-actions d-flex align-items-center">
            @if(isset($edit))
                <h4>ویرایش مدیر</h4>
            @else
                <h4>مدیر جدید</h4>
            @endif
        </div>
        <form method="post" @if(isset($edit)) action="{{route('manager.update',$edit->id)}}"
              @else action="{{route('manager.store')}}" @endif>
            @csrf
            <div class="widget-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <label>نام کاربری</label>
                            <input type="text" class="form-control text-right" dir="ltr" name="user_name" required
                                   value="{!! $edit->user_name ?? '' !!}">
                        </div>
                        <div class="col-6">
                            <label>رمز ورود</label>
                            <input type="text" class="form-control text-right" dir="ltr" name="password"
                                   required
                                   @if(isset($edit)) value="{!! decrypt($edit->password) !!}" @endif>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <label>شماره موبایل</label>
                            <input type="text" class="form-control" name="mobile" value="{!! $edit->mobile ?? '' !!}">
                        </div>
                        <div class="col-6">
                            <label>وضعیت</label>
                            <select name="active" class="form-control">
                                <option value="1" @if(isset($edit) && $edit->active == '1') selected @endif>فعال</option>
                                <option value="0" @if(isset($edit) && $edit->active == '0') selected @endif>غیرفعال
                                </option>
                            </select>
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
