@extends('layouts._main')

@section('title')
Reset Password
@stop


@section('header')
Reset Password
@stop

@section('flashmsg')
@if(Session::has('flash_message'))
{{ Session::get('flash_message') }}
@endif
@stop

@section('errormsg')
@if (Session::has('error_message'))
    {{ Session::get('error_message')}}
@endif
@stop

@section('form')
{{ Form::open(array('route' => array('pages.update', $token))) }}

<p>{{ Form::label('email', 'Email') }}
    {{ Form::text('email',null) }}</p>

<p>{{ Form::label('password', 'Password') }}
    {{ Form::password('password') }}</p>

<p>{{ Form::label('password_confirmation', 'Password confirm') }}
    {{ Form::password('password_confirmation') }}</p>

{{ Form::hidden('token', $token) }}

<p>{{ Form::submit('Submit',array('class'=>'btn btn-success')) }}</p>

{{ Form::close() }}

@stop
