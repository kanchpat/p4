@extends('layouts._table')

@section('title')
Books
@stop

@section('body')
@if(sizeof($books) == 0)
No results
@endif
@stop

@section('tableheader')
Selection of books available for Rental
@stop


@section('form')
{{ Form::open(array('url' => '/book/rent')) }}
@stop

@section('tabledata')
<th> Title of the book </th>
<th> Rent this </th>
@foreach($books as $book)
<tr>
    <td>{{{ $book['title'] }}}</td>
    <td>{{ Form::checkbox('BookRent[]',$book['id']) }}</td>
</tr>
@endforeach
{{ Form::submit('Rent now'); }}
{{ Form::close() }}
@stop
