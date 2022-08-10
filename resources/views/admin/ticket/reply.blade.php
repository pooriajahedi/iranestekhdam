@extends('admin.layout.layout')
@section('title', $ticket->subject)
@section('page')
    <style>
        .user-widget .widget-header{
            background-color: #0f6674;
            color: #fafafa;
        }
        .user-widget .widget-header h4{
            color: #fafafa;
        }
        .admin-widget .widget-header{
            background-color: #3b5998;
            color: #fafafa;
        }
        .admin-widget .widget-header h4{
            color: #fafafa;
        }
    </style>
    @if($ticket->status == 'closed')
        <div class="alert alert-danger" role="alert">
            <strong>توجه! شما در حال بررسی یک تیکت بسته شده هستید.</strong>
        </div>
    @endif
    <div class="widget user-widget has-shadow">
        <div class="widget-header bordered no-actions d-flex align-items-center"><h4>{!! $ticket->subject ?? '' !!}</h4></div>
        <div class="widget-body">
            {!! $ticket->body ?? '-' !!}

        </div>
        <div class="widget-footer text-right">
            {!! \App\Helpers\convertCreateAtToPersianDateTime($ticket->created_at) !!}
        </div>
    </div>
    @foreach($replies as $message)
        @if($message->type == 'user')
            <div class="widget has-shadow admin-widget">
                <div class="widget-header bordered no-actions d-flex align-items-center"><h4>کاربر</h4></div>
                <div class="widget-body">{!! $message->text ?? '' !!}</div>
                <div class="widget-footer text-right">

                    {!! \App\Helpers\convertCreateAtToPersianDateTime($message->created_at) !!}
                </div>
            </div>
        @else
            <div class="widget has-shadow user-widget">
                <div class="widget-header bordered no-actions d-flex align-items-center"><h4>پشتیبان</h4></div>
                <div class="widget-body">{!! $message->text ?? '' !!}</div>
                <div class="widget-footer text-right">

                    {!! \App\Helpers\convertCreateAtToPersianDateTime($message->created_at) !!}
                </div>
            </div>
        @endif
    @endforeach
    @if($ticket->status == 'closed')

    @else
        <div class="widget has-shadow">
        <div class="widget-header bordered no-actions d-flex align-items-center"><h4>ارسال پاسخ</h4></div>
        <form method="post" action="/admin/support/reply/store/{!! $ticket->id !!}">
            @csrf
            <div class="widget-body">
                <div class="form-group">
                    <label>متن</label>
                    <textarea class="form-control" rows="10" name="text"></textarea>
                </div>
                <div class="h-10"></div>
            </div>
            <div class="widget-footer text-right">
                <input type="submit" class="btn btn-primary" value="ارسال">
            </div>
        </form>
    </div>
    @endif
@endsection
