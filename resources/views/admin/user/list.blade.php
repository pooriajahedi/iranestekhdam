@extends('admin.layout.layout')
@section('title','لیست کاربران')
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
                            <label>نام</label>
                            <input type="text" class="form-control" name="name" value="{!! $_GET['name'] ?? '' !!}">
                        </div>
                        <div class="col-md-4">
                            <label>نام کاربری تلگرام</label>
                            <input type="text" class="form-control" name="user_name"
                                   value="{!! $_GET['family'] ?? '' !!}">
                        </div>
                        <div class="col-4">
                            <label>وضعیت</label>
                            <select name="mode" class="form-control">
                                <option value="">همه</option>
                                <option value="active"
                                        @if(isset($_GET['mode']) && $_GET['mode'] == 'active') selected @endif>فعال
                                </option>
                                <option value="block"
                                        @if(isset($_GET['mode']) && $_GET['mode'] == 'block') selected @endif>غیرفعال
                                </option>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">

                        <div class="col-6">
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
            <h4>لیست کاربران</h4>
            <a href="/admin/user/excel" title="خروجی اکسل" style="position: absolute;left: 20px;"><i
                    style="font-size: 1.3em;" class="la la-file"></i></a>
        </div>
        <div class="widget-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th class="text-center">ردیف</th>
                        <th class="text-center">نام</th>
                        <th class="text-center">شناسه تلگرام</th>
                        <th class="text-center">تاریخ عضویت</th>
                        <th class="text-center">وضعیت</th>
                        <th class="text-center">عملیات</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list as $item)
                        <tr>
                            <td class="text-center">{{ $loop->index +1}}</td>
                            <td class="text-center">{!! $item->name ?? '-' !!}</td>
                            <td class="text-center">{!! $item->user_name ?? '-' !!}</td>
                            <td class="text-center">{!! \App\Helpers\convertCreateAtToPersianDateTime( $item->created_at) !!}</td>
                            <td class="text-center">{!! \App\Helpers\getUserMode( $item->status) !!}</td>
                            <td class="text-center">
                                <a target="_blank" title="ارسال پیام مستقیم"
                                   href="{{route('user.direct',$item->id)}}"><i class="la la-user-secret"></i></a>
                                <a title="تبدیل وضعیت" href="{{route('user.changeStatus',$item->id)}}"><i
                                        class="la la-refresh"></i></a>
                                <a class="delete-item" href="{{route('user.delete',$item->id)}}"><i
                                        class="la la-trash"></i></a>
                                @if($item->AutomaticSelection!=null)
                                    <a title="مشاهده انتخاب های دریافت خودکار" target="_blank" href="{{route('user.show.subscription',$item->id)}}"><i
                                            class="la la-eye"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if($list->hasPages())
            <div class="widget-footer text-center">
                {!! $list->appends($_GET)->links() !!}
            </div>
        @endif
    </div>
@endsection
