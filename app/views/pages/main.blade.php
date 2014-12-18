@extends('layouts._master')

@section('title')
Welcome to Book Swapper
@stop

@section('head')
<style type="text/css">
    body
    {
        margin-bottom: 60px;
        background-image: url('/img/book-swapper.jpg');
        background-repeat: no-repeat;
        background-position: center;
    }
</style>
<title>
    Welcome to Book Swapper
</title>
@stop

@section('flashmsg')
@if(Session::has('flash_message'))
{{ Session::get('flash_message') }}
@endif
@stop
@section('loginfo')
Hello
{{{isset($name) ? $name : Auth::user()->
email }}}
@stop
