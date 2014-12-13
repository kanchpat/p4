@extends('layouts._master')

@section('title')
Add a new book
@stop

@section('flashmsg')
@if(Session::has('flash_message'))
{{ Session::get('flash_message') }}
@endif
@stop


@section('form')
{{ Form::open(array('action' => 'BookController@showGoogleBooks','files'=>true)) }}
{{ Form::label('title','Title') }}
{{ Form::text('title'); }}
{{ Form::submit('Find Book with Title/Author',array('class'=>'btn btn-success')); }}
{{ Form::close() }}
@stop

