@extends('admin.layout.layout')
@section('title','فرصت های شغلی ')
@section('page')
    <div class="widget has-shadow">
        <div class="widget-header bordered no-actions d-flex align-items-center" style="position: relative">
            <h4>گزارشات موقعیت های شغلی</h4>
        </div>
        <div class="widget-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                    <tr>
                        <th class="text-center">موقعیت شغلی</th>
                        <th class="text-center">عنوان</th>
                        <th class="text-center">توضیحات</th>
                        <th class="text-center">زمان ایجاد</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list as $item)
                        <tr>
                            <td class="text-center">{!! \App\Helpers\getJobOfferLink( $item->jobOffer->link) !!}</td>
                            <td class="text-center text-small">{!! $item->title ?? '-' !!}</td>
                            <td class="text-center text-small">{!! $item->description ?? '-' !!}</td>
                            <td class="text-center">{!! \App\Helpers\convertCreateAtToPersianDateTime( $item->updated_at) !!}</td>

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
