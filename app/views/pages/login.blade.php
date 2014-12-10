@extends('layouts._master')

@section('title')
Log in
@stop


@section('header')
Log in
@stop

@section('body')
@if(Session::get('flash_message'))
<div class='flash-message'>{{ Session::get('flash_message') }}</div>
@endif
@stop

@section('form')
{{ Form::open(array('url' => '/login')) }}

{{ Form::label('email') }}
{{ Form::text('email',null,array('class'=>'form-control','t_small'=>'Small')) }}

{{ Form::label('password') }}
{{ Form::password('password',array('class'=>'form-control','t_small'=>'Small')) }}
<br>

{{ Form::submit('Submit',array('class'=>'btn btn-success')) }}

{{ Form::close() }}

@stop