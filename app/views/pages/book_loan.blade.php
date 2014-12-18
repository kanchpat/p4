@extends('layouts._table')

@section('title')
Books
@stop

@section('flashmsg')
@if(Session::has('flash_message'))
{{ Session::get('flash_message') }}
@endif
@stop

@section('form')
{{ Form::open(array('url' =>
'/book/loan')) }}
@if(sizeof($renters) == 0)
You currently do not have any rentals
@else
{{ Form::submit('Past Rental', array('class'=>
'btn btn-success','name' =>
'action')) }}
{{ Form::submit('Initiate Return', array('class'=>
'btn btn-success','name' =>
'action')) }}
@endif
@stop

@section('tableheader')
My Rental
@stop

@section('tabledesc')
@if(sizeof($renters) == 0)
Please rent using the link
<a href='/book/rent'>
    Browse books available for Rent
</a>
@else
Initiate Return - When you are ready to return the book, initate return.
<br>
Owner would be notified they would need to verify if the book has reached.
<br>
@endif
@stop

@section('tabledata')

<th> Title of the book </th>
<th> Cover of the book</th>
<th>   Date Issued </th>
<th>    Date Return </th>
<th>  Initiate Return </th>
@foreach($renters as $renter)
<tr>
    @foreach($renter-> books as $book)
    <td> {{{ $book['title'] }}} </td>
    <td> <img src='{{ $book['cover'] }}' > </td>
    <td> {{{ $renter['rental_date'] }}} </td>
    <td> {{{ $renter['return_date'] }}} </td>
    <td> {{ Form::checkbox('BookReturn[]',$renter['id']) }} </td>
    @endforeach
</tr>
@endforeach
{{ Form::close() }}
@stop