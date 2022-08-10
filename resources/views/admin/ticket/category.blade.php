@extends('admin.layout.layout')
@section('title','دسته بندی')
@section('page')

    <div class="widget has-shadow">
        <div class="widget-header bordered no-actions d-flex align-items-center" style="position: relative">
            <h4>دسته های پشتیبانی</h4>
        </div>
        <div class="widget-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th class="text-center">شناسه</th>
                        <th class="text-center">عنوان</th>
                        <th class="text-center">عملیات</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list as $item)
                        <tr>
                            <td class="text-center">{!! $item->id ?? '-' !!}</td>
                            <td class="text-center">{!! $item->title ?? '-' !!}</td>
                            <td class="text-center">
                                <a   href="{{route('support.category.edit',$item->id)}}"><i
                                        class="la la-edit"></i></a>
                                <a   href="{{route('support.category.delete',$item->id)}}"><i
                                        class="la la-remove"></i></a>

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
