@extends('layouts._table')

@section('title')
Books
@stop

@section('body')
@if(sizeof($books) == 0)
No results
@endif
@stop


@section('flashmsg')
@if(Session::has('flash_message'))
{{ Session::get('flash_message') }}
@endif
@stop

@section('form')
{{ Form::open(array('url' =>
'/book/list')) }}
@if(sizeof($books) !=0)
{{ Form::submit('Update Book Info',array('class'=>
'btn btn-success')); }}
@endif
@stop

@section('tableheader')
My Library
@stop

@section('tabledesc')
@if(sizeof($books) != 0)
You currently own the below books.
<br>
You can delete books if you no longer have the book or You can make the books available for rent
<br>
You can also edit the details of any book.
@else
You currently do not own any books. Please add books from
<a href='/book/create'>
    Add Books
</a>
@endif
@stop

@section('tabledata')
<th>
    Delete
</th>
<th>
    Title of the book
</th>
<th>
    Available for Rent
</th>
<!--//
<th>
Edit
</th>
-->

@foreach($books as $book)
<tr>
    @if($book['ready_to_swap'] == 'Y')
    <td>
        {{ Form::checkbox('Delete[]',$book['id']) }}
    </td>
    @else
    <td>
        {{ Form::checkbox('Delete[]', $book['id'],false,array('disabled') ) }}
    </td>
    @endif
    <td>
        {{{ $book['title'] }}}
    </td>
    @if($book['ready_to_swap'] == 'Y')
    <td>
        {{ Form::select('AvailableforRent[]', array('Y'=>
        "Available" ,"N"=>
        "Not Available"),"Y") }}
    </td>
    @else
    <td>
        {{ Form::select('AvailableforRent[]', array('Y'=>
        "Available" ,"N"=>
        "Not Available"),"N") }}
    </td>
    @endif
    {{ Form::hidden('id[]', $book['id'] ) }}
    <!--//
  <td>

  <a href='/book/edit/{{$book['id']}}'>
  Edit
  </a>
  </td>
  -->
</tr>
@endforeach
{{ Form::close() }}

@stop