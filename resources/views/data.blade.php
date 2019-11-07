@extends('layouts.app')

@section('content')
<form action={{url('admin/news')}} method='post'>
    @csrf
    <div class="form-group">
        <label>{{ trans('admin.title') }}</label>
        <input type="text" class="form-control" name="title" value="{{ old('title') }}">
    </div>

    <div class="form-group">
        <label>{{ trans('admin.desc') }}</label>
        <input type="text" class="form-control" name="desc" value="{{ old('desc') }}">
    </div>

    <div class="form-group">
        <label>{{ trans('admin.body') }}</label>
        <textarea class="form-control" id="summary-ckeditor" name="body">{!! old('body') !!}</textarea>
    </div>

    <div class="form-group">
        <label>{{ trans('admin.addby') }}</label>
        <input type="text" class="form-control" name="addby" value="{{ old('addby') }}">
    </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script>
    CKEDITOR.replace( 'summary-ckeditor', {
        filebrowserUploadUrl: "{{ asset('/laravel-filemanager/upload?type=Files&_token='.csrf_token()) }}",
        filebrowserImageBrowseUrl: '{{ asset("/laravel-filemanager?type=Images") }}',
        filebrowserImageUploadUrl: '{{ asset("/laravel-filemanager/upload?type=Images&_token=".csrf_token()) }}',
        filebrowserBrowseUrl: '{{ asset("/laravel-filemanager?type=Files") }}',
        height:400,
        filebrowserUploadMethod: 'post',
    });
</script>
@endsection

