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
<th> Title of the book </th>
<th> Requester Name </th>
<th> Address </th>
<th> Email Id</th>

@if(is_null($owners))
No titles to report.
@else
@for($i =0; $i<1 ; $i++)
<tr>
    <td>{{{ $books[$i]->title }}}</td>
    <td>{{{ $owners[$i]->first_name . $owners[$i]->last_name }}}</td>
    <td>{{{ $owners[$i]->address1 . $owners[$i]->address2 . $owners[$i]->city . $owners[$i]->state . $owners[$i]->zip_code }}}</td>
</tr>
@endfor
@endif
@stop






