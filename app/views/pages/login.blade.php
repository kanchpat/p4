@extends('layouts._master')

@section('title')
Log in
@stop


@section('header')
Log in
@stop

@section('content')
@if(Session::get('flash_message'))
<div class='flash-message'>{{ Session::get('flash_message') }}</div>
@endif
@stop

@section('form')
{{ Form::open(array('url' => '/login')) }}

{{ Form::label('email') }}
{{ Form::text('email','sam@gmail.com') }}

{{ Form::label('password') }} (sam)
{{ Form::password('password') }}

{{ Form::submit('Submit') }}

{{ Form::close() }}

@stop