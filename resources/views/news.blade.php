@extends('layouts.app')

@section('content')
<a class="btn btn-success" href="news/create">{{ trans('admin.newscreate') }}</a>
<hr>
<form action={{url('admin/news/delete')}} method='post'>
    <input type='hidden' name='_token' value='{{csrf_token()}}' />
    <input type='hidden' name='_method' value='DELETE'/>
<table class="table table-dark">
<thead>
  <tr>
    <th>ID</th>
    <th>Title</th>
    <th>Desc</th>
    <th>Body</th>
    <th>Addby</th>
    <th>Delete Status</th>
    <th>Checkbox</th>
    {{-- <th>Delete</th> --}}
  </tr>
</thead>
<tbody>
@foreach($all_news as $news)
<tr>
    <td>{{$news->id}}</td>

    <td>{{$news->title}}</td>

    <td>{{$news->desc}}</td>

    <td>{!! $news->body !!}</td>

    <td>{{$news->addby}}</td>
    <td>{{ !empty( $news->deleted_at )?'Trashed':'Published' }}</td>
    <td>
        <input type="checkbox" name="id[]" value="{{ $news->id }}">
    </td>
    {{-- <td>
            <form action={{ route('admin.news.destroy', $news->id )}} method='post'>
                <input type='hidden' name='_token' value='{{csrf_token()}}' />
                <input type='hidden' name='_method' value='DELETE'/>
                <input type='submit' class='btn btn-danger' value='Delete' />
    </td> --}}

</tr>
@endforeach
        <input type='submit' class='btn btn-primary' name='restore' value='Restore' />
        <input type='submit' class='btn btn-warning' name='softdelete' value='Soft Delete' />
        <input type='submit' class='btn btn-danger' name='forcedelete' value='Force Delete' />
    </form>
</tbody>

</table>
@endsection
