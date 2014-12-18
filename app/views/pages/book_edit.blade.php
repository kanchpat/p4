@extends('layouts._master')

@section('title')
Edit
@stop

@section('head')

<h1>Edit</h1>
<h2> {{{ $book['title'] }}}</h2>

@stop

@section('form')

{{ Form::open(array('url' => '/book/edit')) }}

{{ Form::hidden('id',$book['id']); }}

<div class='form-group'>
    {{ Form::label('title','Title') }}
    {{ Form::text('title',$book['title']); }}
</div>
<div class='form-group'>
    {{ Form::label('Author', 'Author') }}
    {{ Form::text('author', $book['author']); }}
</div>
<div class='form-group'>
    {{ Form::label('ISBN', 'ISBN') }}
    {{ Form::text('isbn', $book['isbn']); }}
</div>
<div class='form-group'>
    {{ Form::label('cover','Cover Image URL') }}
    {{ Form::text('cover',$book['cover']); }}
</div>
<div class='form-group'>
    {{ Form::submit('Save'); }}
</div>
{{ Form::close() }}

@stop