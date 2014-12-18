@extends('layouts._table')

@section('title')
Messages
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
{{ Form::open(array('url' =>'/msgs/list')) }}
@if(sizeof($messages)==0)
No Messages for you currently
@else
{{ Form::submit('Submit Info',array('class'=>'btn btn-success')); }}
@endif
@stop

@section('tableheader')
Your messages
@stop

@section('tabledesc')
@if(sizeof($messages)!=0)
Approve or Reject for Rental.
@endif
@stop

@section('tabledata')
<th> Message Details</th>
<th> Message from</th>
<th> Approve / Reject</th>
@if(sizeof($messages)!=0)
@if($i=0)
@endif
@foreach($messages as $message)
<tr>
    <td> {{{ $message['msg_text'] }}} </td>
    <td> {{{ $owner_names[$i++] }}}  </td>
    <td>
        @if($message['action_ind'] == 'Y')
            {{ Form::select('select[]',array('Approve','Reject'),array('class'=>'form-control')) }}
            {{ Form::hidden('id[]', $message['book_id'] ) }}
            {{ Form::hidden('msg_id[]',$message['id'] ) }}
        @endif
    </td>
</tr>
@endforeach
@endif
{{ Form::close() }}
@stop