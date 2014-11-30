@extends('layouts._master')

@section('title')
Add a new book
@stop

@section('content')
<h1>Add a new book</h1>
@stop

@section('form')

{{ Form::open(array('url' => '/book/create')) }}


{{ Form::label('title','Title') }}
{{ Form::text('title'); }}

{{ Form::hidden('owner_id', $owners); }}

{{ Form::label('author', 'Author') }}
{{ Form::text('author'); }}

{{ Form::label('cover','Cover Image URL') }}
{{ Form::text('cover'); }}

{{ Form::label('ISBN','ISBN') }}
{{ Form::text('isbn'); }}

{{Form::hidden('ready_to_swap','n') }}

{{ Form::submit('Add'); }}

{{ Form::close() }}

@stop
