@extends('admin.layout.layout')
@section('title','فرصت های شغلی ')
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
                            <input type="text" class="form-control" name="name" value="{!! $_GET['name'] ?? '' !!}">
                        </div>
                        <div class="col-md-4">
                            <label>شهر</label>
                            <input type="text" class="form-control" name="user_name"
                                   value="{!! $_GET['family'] ?? '' !!}">
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
            <h4>موقعیت های شغلی</h4>
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
                        <th class="text-center">لینک</th>
                        <th class="text-center">زمان ایجاد</th>
                        <th class="text-center">عملیات</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list as $item)
                        <tr>
                            <td class="text-center">{!! $item->id ?? '-' !!}</td>
                            <td class="text-center">{!! $item->title ?? '-' !!}</td>
                            <td class="text-center">{!! \App\Helpers\getJobOfferLink( $item->link) !!}</td>
                            <td class="text-center">{!! \App\Helpers\convertCreateAtToPersianDateTime( $item->updated_at) !!}</td>

                            <td class="text-center">
                                <a class="delete-item" href="{{route('job_offer.delete',$item->id)}}"><i
                                        class="la la-trash"></i></a>
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
