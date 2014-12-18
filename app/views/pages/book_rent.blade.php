@extends('layouts._table')

@section('title')
Books
@stop

@section('flashmsg')
@if(Session::has('flash_message'))
{{ Session::get('flash_message') }}
@endif
@stop

@section('tableheader')
Selection of books available for Rental
@stop


@section('form')
{{ Form::open(array('url' => '/book/rent')) }}
{{ Form::submit('Rent now',array('class'=> 'btn btn-success')); }}
@stop

@section('tabledata')
<th> Title of the book </th>
<th> Cover of the book</th>
<th>   Rent this </th>
@foreach($books as $book)
<tr>
    <td> {{{ $book['title'] }}} </td>
    <td> <img src='{{ $book['cover'] }}' > </td>
    <td> {{ Form::checkbox('BookRent[]',$book['id']) }} </td>
</tr>
@endforeach
{{ Form::close() }}
@stop
