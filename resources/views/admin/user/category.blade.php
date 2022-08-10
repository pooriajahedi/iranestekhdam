@extends('admin.layout.layout')
@section('title','دسته کاربری')
@section('page')
    <div class="row">
        <div class="col-12 col-md-5">
            <div class="widget has-shadow">
                <div class="widget-header bordered no-actions">دسته بندی</div>
                <form method="post" @if(isset($edit)) action="/admin/user/category/edit/store/{!! $edit->id !!}" @else action="/admin/user/category/new/store" @endif>
                <div class="widget-body">
                    <div class="form-group">
                        <label>عنوان</label>
                        <input type="text" class="form-control" name="title" value="{!! $edit->title ?? '' !!}">
                    </div>
                    <div class="form-group">
                        <label>درصد تخفیف</label>
                        <div class="input-group">
                            <input type="number" class="form-control text-center" name="description" value="{!! $edit->description ?? '' !!}">
                            <span class="input-group-append"><label class="input-group-text">%</label></span>
                        </div>
                    </div>
                </div>
                <div class="widget-footer">
                    <input type="submit" class="btn btn-primary" value="ثبت">
                </div>
                </form>
            </div>
        </div>
        <div class="col-12 col-md-7">
            <div class="widget has-shadow">
                <div class="widget-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                            <tr>
                                <th class="text-center">عنوان</th>
                                <th class="text-center">درصد تخفیف</th>
                                <th class="text-center">مدیریت</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list as $item)
                                <tr>
                                    <td class="text-center">{!! $item->title ?? '' !!}</td>
                                    <td class="text-center">%{!! $item->description ?? 0 !!}</td>
                                    <td class="text-center">
                                        <a href="/admin/user/category/edit/{!! $item->id !!}"><i class="la la-edit"></i></a>
                                        <a class="delete-item" href="/admin/user/category/delete/{!! $item->id !!}"><i class="la la-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
