@extends('layouts._table')

@section('title')
Books
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

@section('form')
{{ Form::open(array('url' => '/msgs/list')) }}
{{ Form::submit('Submit Info',array('class'=>'btn btn-success')); }}
@stop

@section('tableheader')
Your messages
@stop

@section('tabledesc')
Approve or Reject for Rental.
@stop

@section('tabledata')
<th> Message Details </th>
<th> User Requested by </th>
<th> Approve / Reject </th>

@if($i=0)
@endif
@foreach($messages as $message)
<tr>
    <td>{{{ $message['msg_text'] }}}</td>
    <td>{{{ $owner_names[$i++] }}}</td>
    <td>
        @if($message['action_ind'] == 'Y')
        {{ Form::select('select[]',array('Approve','Reject'),array('class'=>'form-control')) }}
        {{ Form::hidden('id[]', $message['book_id'] ) }}
        {{ Form::hidden('msg_id[]',$message['id'] ) }}
        @endif
    </td>
</tr>
@endforeach
{{ Form::close() }}
@stop






