@extends('layouts._table')

@section('title')
Address
@stop

@section('flashmsg')
{{{ isset($flash_message) ?$flash_message : '' }}}
@stop

@section('tableheader')
Address for the recipients of the books
@stop

@section('tabledesc')
Address of the recipients who you have approved
@stop

@section('tabledata')
<th>
    Title of the book
</th>
<th>
    Requester Name
</th>
<th>
    Address
</th>
<th>
    Email Id
</th>
@if(sizeof($owners)==0)
No titles to report.
@else
@for($i =0; $i
< count($owners) ; $i++)
<tr>
    <td>
        {{{ $books[$i]->
        title }}}
    </td>
    <td>
        {{{ $owners[$i]->
        first_name . $owners[$i]->
        last_name }}}
    </td>
    <td>
        {{{ $owners[$i]->
        address1 . $owners[$i]->
        address2 . $owners[$i]->
        city . $owners[$i]->
        state . $owners[$i]->
        zip_code }}}
    </td>
    <td>
        {{{ $emails[$i]->
        email }}}
    </td>
</tr>
@endfor
@endif
@stop