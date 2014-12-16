@extends('layouts._table')

@section('title')
Address
@stop

@section('flashmsg')
@if(Session::has('flash_message'))
{{ Session::get('flash_message') }}
@endif
@stop

@section('errormsg')
@if(Session::has('error_message'))
{{ Session::get('error_message') }}
@endif
@stop

@section('tableheader')
Address for the recipients of the books
@stop

@section('tabledesc')
Approve or Reject for Rental.
@stop

@section('tabledata')
<th> Message Details </th>
<th> Address </th>
<th> Approve / Reject </th>

@foreach($messages as $message)
<tr>
    <td>{{{ $message['msg_text'] }}}</td>
    @foreach($message->users as $user)
    <td>{{{ $user->address1. $user->address2 }}}</td>
     @endforeach
</tr>
@endforeach
@stop






