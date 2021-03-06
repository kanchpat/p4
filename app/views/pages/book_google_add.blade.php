@extends('layouts._table')

@section('title')
Add a new book
@stop

@section('flashmsg')
@if(Session::has('flash_message'))
{{ Session::get('flash_message') }}
@endif
@stop

@section('form')

{{ Form::open(array('action' => 'BookController@postCreate','files'=> true)) }}
{{Form::submit('Add Book',array('class'=>'btn btn-success')); }}
@stop

@section('tableheader')
@if(isset($books))
Selection of books available for that Title. Can't find the book you have, try changing the search criteria
@endif
@stop
@section('tabledata')
@if(isset($books))
<th> Title</th>
<th> Author</th>
<th> ISBN </th>
<th> Cover</th>
<th> Select for your library</th>
@if($i=0)
@endif
@foreach($books as $book)
<tr>
    <td>{{{ $book['title'] }}}</td>
    <td>{{{ $book['author'] }}}</td>
    <td>{{{ $book['isbn'] }}} </td>
    <td> <img src='{{ $book['cover'] }}' > </td>
    <td> {{ Form::checkbox('select_book[]',$i++) }} </td>

    {{ Form::hidden('title[]', $book['title'] ) }}
    {{ Form::hidden('author[]', $book['author'] ) }}
    {{ Form::hidden('isbn[]', $book['isbn'] ) }}
    {{ Form::hidden('cover[]', $book['cover'] ) }}

</tr>
@endforeach
@endif
{{Form::close() }}
@stop
