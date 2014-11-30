@extends('layouts._master')

@section('title')
Log in
@stop

@section('header')
Signup
@stop

@section('body')

@foreach($errors->all() as $message)
<div class='error'>{{ $message }}</div>
@endforeach

@stop

@section('form')
{{ Form::open(array('url' => '/signup')) }}

{{ Form::label('email','Email') }}
{{ Form::text('email',null,array('class'=>'form-control','t_medium'=>'Medium')) }}
<br>
{{ Form::label('password','Password') }}
{{ Form::password('password',array('class'=>'form-control','t_medium'=>'Medium')) }}
<small>Min 8 alphanumeric characters</small>
<br>
{{ Form::submit('Submit',array('class'=>'btn btn-primary')) }}

{{ Form::close() }}
@stop