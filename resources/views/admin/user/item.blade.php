@extends('admin.layout.layout')
@section('title','ویرایش کاربر')
@section('page')
    <div class="widget has-shadow">
        <div class="widget-header bordered no-actions d-flex align-items-center">
            <h4>کاربر "{!! $edit->mobile ?? '' !!}"</h4>
        </div>
        <div class="widget-body sliding-tabs">
            <ul class="nav nav-tabs" id="example-one" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active show" id="base-tab-1" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">پروفایل</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="base-tab-2" data-toggle="tab" href="#tab-2" role="tab" aria-controls="tab-2" aria-selected="false">تراکنش‌ها</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="base-tab-3" data-toggle="tab" href="#tab-3" role="tab" aria-controls="tab-3" aria-selected="false">سفارشات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="base-tab-3" data-toggle="tab" href="#tab-4" role="tab" aria-controls="tab-3" aria-selected="false">تیکت</a>
                </li>
            </ul>
            <div class="tab-content pt-3">
                <div class="tab-pane fade active show" id="tab-1" role="tabpanel" aria-labelledby="base-tab-1">
                    <form method="post" action="/admin/user/edit/store/{!! $edit->id !!}">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-4">
                                    <label>نام و نام خانوادگی</label>
                                    <input type="text" disabled="disabled" class="form-control" value="{!! $edit->name ?? '' !!}&nbsp;{!! $edit->family ?? '' !!}">
                                </div>
                                <div class="col-4">
                                    <label>نام کاربری</label>
                                    <input type="text" disabled="disabled" class="form-control" value="{!! $edit->username ?? '' !!}">
                                </div>
                                <div class="col-4">
                                    <label>ایمیل</label>
                                    <input type="text" class="form-control" disabled="disabled" value="{!! $edit->email ?? '' !!}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <label>کیف‌پول</label>
                                    <input type="text" class="form-control" name="wallet" value="{!! $edit->wallet ?? '' !!}">
                                </div>
                                <div class="col-6">
                                    <label>شماره‌همراه</label>
                                    <input type="text" class="form-control" disabled="disabled" value="{!! $edit->mobile ?? '' !!}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <label>وضعیت</label>
                                    <select name="mode" class="form-control">
                                        <option value="sms" @if($edit->mode == 'sms') selected @endif>در انتظار فعال کردن موبایل</option>
                                        <option value="email" @if($edit->mode == 'email') selected @endif>در انتظار فعال کردن ایمیل</option>
                                        <option value="active" @if($edit->mode == 'active') selected @endif>فعال</option>
                                        <option value="deactive" @if($edit->mode == 'deactive') selected @endif>غیرفعال</option>
                                        <option value="banned" @if($edit->mode == 'banned') selected @endif>بن‌شده</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label>کدفعال‌سازی</label>
                                    <input type="text" class="form-control text-center" name="verification_code" value="{!! $edit->verification_code ?? '' !!}">
                                </div>
                                <div class="col-12 col-md-4">
                                    <label>دسته کاربری</label>
                                    <select name="category_id" class="form-control">
                                        <option value="">انتخاب نشده</option>
                                        @foreach($ucategories as $uc)
                                            <option value="{!! $uc->id ?? '' !!}" @if(isset($edit) && $edit->category_id == $uc->id) selected @endif>{!! $uc->title !!}({!! $uc->description ?? '' !!}%)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <input type="submit" class="btn btn-primary" value="ثبت تغییرات">
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="tab-2" role="tabpanel" aria-labelledby="base-tab-2">
                    <div class="alert alert-info" role="alert">
                        <strong>لیست ده تراکنش آخر کاربر</strong>
                    </div>
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                            <tr>
                                <th>عنوان</th>
                                <th class="text-center">مبلغ</th>
                                <th class="text-center">نوع</th>
                                <th class="text-center">سفارش</th>
                                <th class="text-center">تخفیف</th>
                                <th class="text-center">تاریخ</th>
                                <th class="text-center">درگاه</th>
                                <th class="text-center">وضعیت</th>
                            </tr>
                            </thead>
                            @foreach($list as $item)
                                <tr>
                                    <th>{!! $item->title ?? '-' !!}</th>
                                    <th class="text-center">{!! $item->amount ?? '' !!}</th>
                                    <th class="text-center">
                                        @if($item->type == 'wallet')
                                            <div class="badge badge-info">افزایش اعتبار</div>
                                        @else
                                            <div class="badge badge-primary">سفارش</div>
                                        @endif
                                    </th>
                                    <th class="text-center">{!! $item->product->title ?? '-' !!}</th>
                                    <th class="text-center">{!! $item->discount ?? '-' !!}</th>
                                    <th class="text-center">{!! getJDate($item->created_at) !!}</th>
                                    <th class="text-center">@if($item->gateway == 'wallet') <div class="badge badge-primary">کیف پول</div> @else <div class="badge badge-info">درگاه بانک</div> @endif</th>
                                    <th class="text-center">{!! getMode('transaction', $item->mode) !!}</th>
                                </tr>
                            @endforeach
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-3" role="tabpanel" aria-labelledby="base-tab-3">
                    <div class="alert alert-info" role="alert">
                        <strong>لیست ده سفارش آخر کاربر</strong>
                    </div>
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                            <tr>
                                <th class="text-center">محصول</th>
                                <th class="text-center">پرداختی</th>
                                <th class="text-center">تخفیف</th>
                                <th class="text-center">تاریخ</th>
                                <th class="text-center">وضعیت</th>
                                <th class="text-center">عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $item)
                                <tr>
                                    <td class="text-center"><a href="/admin/product/list?id={!! $item->product->id ?? '' !!}">{!! $item->product->title ?? '' !!}</a></td>
                                    <td class="text-center">{!! $item->amount ?? '' !!}</td>
                                    <td class="text-center">{!! $item->discount ?? '-' !!}</td>
                                    <td class="text-center">{!! getJDate($item->created_at) !!}</td>
                                    <td class="text-center">{!! getMode('order',$item->mode) !!}</td>
                                    <td class="text-center">
                                        @if($item->mode == 'paid')
                                            <a title="ارسال درخواست انجام" href="javascript:void(0);" data-toggle="modal" data-target="#modal-send-{!! $item->id !!}"><i class="la la-send"></i></a>
                                            <div class="modal fade" id="modal-send-{!! $item->id !!}">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="modelTitleId">ارسال درخواست</h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-left">
                                                            با تایید این گزینه درخواست سفارش برای سرویس‌دهنده ارسال شده و سفارش به وضعیت "درحال‌انجام" تغییر خواهد کرد
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">انصراف
                                                            </button>
                                                            <a href="/admin/order/send/{!! $item->id !!}" class="btn btn-danger">اطمینان دارم</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <a data-toggle="popover" data-trigger="hover" data-placement="top" class="confirm-item" data-content="بازگشت‌وجه و کنسل کردن سفارش" href="/admin/order/reject/{!! $item->id !!}"><i class="la la-fast-backward"></i></a>
                                        <a data-toggle="popover" data-trigger="hover" data-placement="top" data-content="مشاهده جزئیات سفارش" href="/admin/order/edit/{!! $item->id !!}"><i class="la la-desktop"></i></a>
                                        <a class="confirm-item" href="/admin/order/action?action=reject&id={!! $item->id !!}"><i class="la la-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-4" role="tabpanel" aria-labelledby="base-tab-3">
                    <div class="alert alert-info" role="alert">
                        <strong>لیست ده تیکت آخر کاربر</strong>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th>عنوان</th>
                                <th class="text-center">وضعیت</th>
                                <th class="text-center">دپارتمان</th>
                                <th class="text-center">تاریخ ایجاد</th>
                                <th class="text-center">تاریخ بروزرسانی</th>
                                <th class="text-center">تنظیمات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tickets as $item)
                                <tr>
                                    <td>{!! $item->title ?? '' !!}</td>
                                    <td class="text-center">{!! getMode('ticket', $item->mode) !!}</td>
                                    <td class="text-center">{!! $item->category->title ?? '' !!}</td>
                                    <td class="text-center">{!! getJDate($item->created_at) !!}</td>
                                    <td class="text-center">{!! getJDate($item->updated_at) !!}</td>
                                    <td class="text-center">
                                        <a title="مدیریت" href="javascript:void(0);" data-toggle="modal" data-target="#editor-{!! $item->id !!}"><i class="la la-edit"></i></a>
                                        <a title="ارسال پاسخ" href="/admin/support/reply/{!! $item->id !!}"><i class="la la-envelope"></i></a>
                                        <a class="delete-item" href="/admin/support/delete/{!! $item->id !!}"><i class="la la-trash"></i></a>
                                    </td>
                                </tr>
                                <div class="modal fade" id="editor-{!! $item->id !!}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form method="post" action="/admin/support/edit/store/{!! $item->id !!}">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>دپارتمان</label>
                                                        <select name="category_id" class="form-control">
                                                            @foreach($categories as $category)
                                                                <option @if($item->category_id == $category->id) selected @endif value="{!! $category->id !!}">{!! $category->title ?? '' !!}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>وضعیت</label>
                                                        <select name="mode" class="form-control">
                                                            <option value="new" @if($item->mode == 'new') selected @endif>جدید</option>
                                                            <option value="waiting" @if($item->mode == 'waiting') selected @endif>در انتظار پاسخ</option>
                                                            <option value="answered" @if($item->mode == 'answered') selected @endif>پاسخ داده شده</option>
                                                            <option value="closed" @if($item->mode == 'closed') selected @endif>بسته</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">خروج</button>
                                                    <button type="submit" class="btn btn-primary">ثبت</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
