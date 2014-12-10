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

@section('tableheader')
My Library
@stop

@section('tabledesc')
You currently own the below books.
    You can delete books if you dont want to have them is swap
    You can make the books available for rent. All the books are initially made not available.
    You can also edit the details of any book.
@stop

@section('tabledata')
<th> Delete </th>
<th> Title of the book </th>
<th> Available for Rent </th>
<th> Edit</th>
{{ Form::open(array('url' => '/book/list')) }}

@foreach($books as $book)
<tr>
    <td>{{ Form::checkbox('Delete[]',$book['id']) }}</td>
    <td>{{{ $book['title'] }}}</td>
    <td>{{ Form::checkbox('AvailableforRent[]', $book['id'],$book['ready_to_swap'] ) }}</td>
    <td>  <a href='/book/edit/{{$book['id']}}'>Edit</a></td>
</tr>
@endforeach
<div class='form-group'>
    {{ Form::submit('Save'); }}
</div>
{{ Form::close() }}
@stop






