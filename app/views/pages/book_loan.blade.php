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
My Rental
@stop

@section('tabledesc')
Initiate Return - When you are ready to return the book, initate return.<br>
Owner would be notified and in 3 days they would need to verify if the book has reached.<br>
Maximum available Rentals are 5
@stop

@section('tabledata')
<th> Title of the book </th>
<th> Date Issued </th>
<th> Date Return </th>
<th> Initiate Return</th>
@foreach($books as $book)
<tr>
    <td>{{{ $book['title'] }}}</td>
    <td></td>
    <td></td>
    <td>{{ Form::checkbox('BookReturn','id') }}</td>
</tr>
@endforeach
@stop

@section('form')
{{ Form::submit('Past Rental'); }}
@stop






