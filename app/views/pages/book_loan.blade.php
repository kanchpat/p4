@extends('layouts._table')

@section('title')
Books
@stop

@section('body')
@if(sizeof($renters) == 0)
No results
@endif
@stop


@section('flashmsg')
@if(Session::has('flash_message'))
{{ Session::get('flash_message') }}
@endif
@stop

@section('form')
{{ Form::open(array('url' => '/book/loan')) }}
{{ Form::submit('Past Rental', array('class'=>'btn btn-success','name' => 'action')) }}
{{ Form::submit('Initiate Return', array('class'=>'btn btn-success','name' => 'action')) }}
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
@foreach($renters as $renter)
<tr>
    @foreach($renter->books as $book)
        <td>{{{ $book['title'] }}}</td>
    <td>{{{ $renter['rental_date'] }}}</td>
    <td>{{{ $renter['return_date'] }}}</td>
    <td>{{ Form::checkbox('BookReturn[]',$renter['id']) }}
    @endforeach
</tr>
@endforeach
{{ Form::close() }}
@stop