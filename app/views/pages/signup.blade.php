@extends('layouts._master')

@section('title')
Log in
@stop

@section('header')
Signup
@stop

@section('form')
{{ Form::open(array('url' => '/signup')) }}

{{ Form::label('email','Email') }}
{{Form::text('email',null,array('class'=>'form-control','t_small'=>'Small')) }}
<!--{{Form::text('email',null) }}-->
<br>
{{ Form::label('password','Password') }}
{{ Form::password('password',array('class'=>'form-control','t_small'=>'Small')) }}
<!--{{ Form::password('password') }}-->
Min 8 alphanumeric characters
<!--<small>Min 8 alphanumeric characters</small>-->
<br>
{{ Form::submit('Submit',array('class'=>'btn btn-success')) }}

{{ Form::close() }}
@stop


@section('errormsg')
@foreach($errors->all() as $message)
{{ $message }}
@endforeach
@stop

@section('flashmsg')
@if(Session::has('flash_message'))
{{ Session::get('flash_message') }}
@endif
@stop