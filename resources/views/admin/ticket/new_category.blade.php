@extends('admin.layout.layout')
@section('title','دسته بندی')
@section('page')
    <div class="widget has-shadow">
        <div class="widget-header bordered no-actions d-flex align-items-center">
            @if(isset($edit))
                <h4>ویرایش دسته بندی</h4>
            @else
                <h4>دسته بندی جدید</h4>
            @endif
        </div>
        <form method="post" @if(isset($edit)) action="{{route('support.category.edit.store',$edit->id)}}"
              @else action="{{route('support.category.new.store')}}" @endif>
            @csrf
            <div class="widget-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <label>عنوان</label>
                            <input type="text" class="form-control text-left" dir="rtl" name="title" required
                                   value="{!! $edit->title ?? '' !!}">
                        </div>
                    </div>
                </div>

            </div>
            <div class="widget-footer text-right">
                <input type="submit" class="btn btn-primary" @if(!isset($edit)) value="ثبت جدید"
                       @else value="ثبت ویرایش" @endif>
            </div>
        </form>
    </div>
@endsection
