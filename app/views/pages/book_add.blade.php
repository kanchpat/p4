@extends('layouts._master')

@section('title')
Add a new book
@stop

@section('flashmsg')
@if(Session::has('flash_message'))
{{ Session::get('flash_message') }}
@endif
@stop


@section('errormsg')
@foreach($errors->
all() as $message)
{{ $message }}
@endforeach
@stop


@section('form')
{{ Form::open(array('action' =>
'BookController@showGoogleBooks','files'=>
true)) }}
{{ Form::label('search books','Search Book') }}
{{ Form::text('search_text'); }}
{{ Form::submit('Find Book with Title/Author',array('class'=>
'btn btn-success')); }}
{{ Form::close() }}
@stop
