@extends('admin.layout.layout')
@section('title','مدیران')
@section('page')
    <div class="widget has-shadow">
        <div class="widget-header bordered no-actions d-flex align-items-center">
            <h4>لیست مدیران</h4>
        </div>
        <div class="widget-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th>نام کاربری</th>
                        <th class="text-center">دسترسی</th>
                        <th class="text-center">وضعیت</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($list as $item)
                            <tr>
                                <td>{!! $item->user_name ?? '' !!}</td>

                                <td class="text-center">{!! \App\Helpers\getMode($item->active) !!}</td>
                                <td class="text-center">
                                    <a href="/admin/manager/edit/{!! $item->id !!}"><i class="la la-edit"></i></a>
                                    <a class="delete-item" href="/admin/manager/delete/{!! $item->id !!}"><i class="la la-trash"></i></a>
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
