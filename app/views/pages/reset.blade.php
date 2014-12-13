@extends('layouts._master')

@section('title')
Log in
@stop


@section('header')
Log in
@stop

@section('flashmsg')
@if(Session::has('flash_message'))
{{ Session::get('flash_message') }}
@endif
@stop

@section('errormsg')
@if (Session::has('error_message'))
{{ trans(Session::get('reason')) }}
@endif
@stop

@section('form')
{{ Form::open(array('route' => array('pages.update', $token))) }}

<p>{{ Form::label('email', 'Email') }}
    {{ Form::text('email') }}</p>

<p>{{ Form::label('password', 'Password') }}
    {{ Form::password('password') }}</p>

<p>{{ Form::label('password_confirmation', 'Password confirm') }}
    {{ Form::password('password_confirmation') }}</p>

{{ Form::hidden('token', $token) }}

<p>{{ Form::submit('Submit') }}</p>

{{ Form::close() }}

@stop
