@extends('layouts._master')

@section('title')
Forgot Password
@stop


@section('header')
Forgot Password
@stop

@section('flashmsg')
@if(Session::has('flash_message'))
{{ Session::get('flash_message') }}
@endif
@stop

@section('errormsg')
@if (Session::has('error'))
{{ trans(Session::get('reason')) }}
@elseif (Session::has('success'))
An email with the password reset has been sent.
@endif
@stop

@section('form')
{{ Form::open(array('route' => 'pages.request')) }}
<p>{{ Form::label('email', 'Email') }}
    {{ Form::text('email') }}</p>
<p>{{ Form::submit('Submit') }}</p>
{{ Form::close() }}
@stop
