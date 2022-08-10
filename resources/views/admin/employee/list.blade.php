@extends('admin.layout.layout')
@section('title','درخواست')
@section('page')
    <div class="widget has-shadow">
        <div class="widget-header bordered no-actions d-flex align-items-center">
            <h4>فیلتر نمایش</h4>
        </div>
        <form>
            <div class="widget-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <label>عنوان</label>
                            <input type="text" class="form-control" name="title" value="{!! $_GET['title'] ?? '' !!}">
                        </div>
                        <div class="col-4">
                            <label>ترتیب نمایش</label>
                            <select name="order" class="form-control">
                                <option value="new"
                                        @if(isset($_GET['order']) && $_GET['order'] == 'new') selected @endif>جدید به
                                    قدیم
                                </option>
                                <option value="old"
                                        @if(isset($_GET['order']) && $_GET['order'] == 'old') selected @endif>قدیم به
                                    جدید
                                </option>
                            </select>
                        </div>

                        <div class="col-4">
                            <label>وضعیت</label>
                            <select name="status" class="form-control">
                                <option value="">همه
                                </option>
                                <option value="new"
                                        @if(isset($_GET['status']) && $_GET['status'] == 'new') selected @endif>جدید
                                </option>
                                <option value="reviewed"
                                        @if(isset($_GET['status']) && $_GET['status'] == 'reviewed') selected @endif>در
                                    حال بررسی
                                </option>

                                <option value="accepted"
                                        @if(isset($_GET['status']) && $_GET['status'] == 'accepted') selected @endif>
                                    پذیرفته شده
                                </option>

                                <option value="rejected"
                                        @if(isset($_GET['status']) && $_GET['status'] == 'rejected') selected @endif>عدم
                                    تایید
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <div class="widget-footer text-right">
                <input type="submit" class="btn btn-primary" value="جستجو">
            </div>
        </form>
    </div>
    <div class="widget has-shadow">
        <div class="widget-header bordered no-actions d-flex align-items-center" style="position: relative">
            <h4>درخواست های ثبت موقعیت  شغلی کارفرمایان</h4>
            <a href="{{route('job_offer.update')}}" title="به روز رسانی لیست" style="position: absolute;left: 20px;"><i
                    style="font-size: 1.3em;" class="la la-refresh"></i></a>
        </div>
        <div class="widget-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th class="text-center">شناسه</th>
                        <th class="text-center">عنوان</th>
                        <th class="text-center">توضیحات</th>
                        <th class="text-center">زمان ایجاد</th>
                        <th class="text-center">وضعیت</th>
                        <th class="text-center">عملیات</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list as $item)
                        <tr>
                            <td class="text-center">{!! $item->id ?? '-' !!}</td>
                            <td class="text-center">{!! $item->title ?? '-' !!}</td>
                            <td class="text-center">{!! Str::limit($item->text, 30, $end='...') !!}</td>
                            <td class="text-center">{!! \App\Helpers\convertCreateAtToPersianDateTime( $item->created_at) !!}</td>
                            <td class="text-center">{!! \App\Helpers\getJobSubmitStatus( $item->status) !!}</td>

                            <td class="text-center">

                                <a title="تایید"  href="{{route('employee.request.accept',$item->id)}}"><i
                                        class="la la-check"></i></a>
                                <a title="عدم تایید"   href="{{route('employee.request.reject',$item->id)}}"><i
                                        class="la la-close"></i></a>
                                <a title="در دست بررسی"   href="{{route('employee.request.review',$item->id)}}"><i
                                        class="la la-info-circle"></i></a>

                                <a title="جزییات" href="{{route('employee.request.info',$item->id)}}"><i
                                        class="la la-eye"></i></a>
                                @if($item->file_name!=null)

                                    <a  title="دانلود ضمیمه"  href="{{route('employee.request.download',$item->id)}}"><i
                                            class="la la-download"></i></a>
                                @endif
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if($list->hasPages())
            <div class="widget-footer text-center ">
                {!! $list->appends($_GET)->links() !!}
            </div>
        @endif
    </div>
@endsection
