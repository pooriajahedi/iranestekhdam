@extends('admin.layout.layout')
@section('title','پیام رسانی')
@section('page')
    <div class="widget has-shadow">
        <div class="widget-header bordered no-actions d-flex align-items-center">
            <h4>ارسال پیام مستقیم </h4>
        </div>
        <form method="post" action="{{route('user.direct.send',$id)}}">
            @csrf
            <div class="widget-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label>متن پیام </label>
                            <input aria-multiline="true" type="text" class="form-control text-right"  name="message" required
                                   >
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget-footer text-right">
                <input type="submit" class="btn btn-primary" value="ارسال پیام">
            </div>
        </form>
    </div>
@endsection
