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


@section('tableheader')
Past Rental
@stop

@section('tabledesc')
Past Rental
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
    @endforeach
</tr>
@endforeach
@stop







