@extends('admin.layout.layout')
@section('title','دریافت خودکار کاربر')
@section('page')
    <div class="widget has-shadow">
        <div class="widget-header bordered no-actions d-flex align-items-center">
            <h4>مشاهده تنظیمات دریافت خودکار آگهی </h4>
        </div>
        <form>
            <div class="widget-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label>نام</label>
                            <input type="text" class="form-control" disabled name="name"
                                   value="{!! $user->name ?? '' !!}">
                        </div>
                        <div class="col-md-4">
                            <label>نام کاربری تلگرام</label>
                            <input type="text" class="form-control" name="user_name" disabled
                                   value="{!! $user->user_name ?? '' !!}">
                        </div>
                        <div class="col-4">
                            <label>وضعیت دریافت خودکار آگهی</label>
                            <select disabled name="mode" class="form-control">
                                <option value="">همه</option>
                                <option value="active"
                                        @if($user->AutomaticSelection != null) selected @endif>مشترک
                                </option>
                                <option value="block"
                                        @if($user->AutomaticSelection == null) selected @endif>عدم اشتراک
                                </option>

                            </select>
                        </div>
                    </div>
                </div>
                @if($user->AutomaticSelection != null)
                <div class="form-group">
                    <div class="row">

                        <div class="col-4">
                            <label>استان</label>
                            <input type="text" class="form-control" disabled name="name"
                                   value="{!! \App\Helpers\getItemFromCombination($user->AutomaticSelection->state_id) !!}">
                        </div>
                        <div class="col-4">
                            <label>جمسیت</label>
                            <input type="text" class="form-control" disabled name="name"
                                   value="{!! \App\Helpers\getItemFromCombination($user->AutomaticSelection->gender_id) !!}">
                        </div>
                        <div class="col-4">
                            <label>ساعت کاری</label>
                            <input type="text" class="form-control" disabled name="name"
                                   value="{!! \App\Helpers\getItemFromCombination($user->AutomaticSelection->work_time_id) !!}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">

                        <div class="col-4">
                            <label>نوع همکاری</label>
                            <input type="text" class="form-control" disabled name="name"
                                   value="{!! \App\Helpers\getItemFromCombination($user->AutomaticSelection->work_mode_id) !!}">
                        </div>
                        <div class="col-4">
                            <label>سابقه</label>
                            <input type="text" class="form-control" disabled name="name"
                                   value="{!! \App\Helpers\getItemFromCombination($user->AutomaticSelection->experience_time_id) !!}">
                        </div>
                        <div class="col-4">
                            <label>مقطع تحصیلی</label>
                            <input type="text" class="form-control" disabled name="name"
                                   value="{!! \App\Helpers\getItemFromCombination($user->AutomaticSelection->grade_id) !!}">
                        </div>
                    </div>
                </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-6">
                                <label>شفل انتخابی</label>
                                <input type="text" class="form-control" disabled name="name"
                                       value="{!! \App\Helpers\getUserSubscribedJobs($user->AutomaticSelection->id) !!}">
                            </div>
                            <div class="col-6">
                                <label>رشته انتخابی</label>
                                <input type="text" class="form-control" disabled name="name"
                                       value="{!! \App\Helpers\getUserSubscribedEducation($user->AutomaticSelection->id) !!}">
                            </div>

                        </div>
                    </div>
                @endif
            </div>

        </form>
    </div>
@endsection
