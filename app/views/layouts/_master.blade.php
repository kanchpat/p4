<!DOCTYPE html>
<html>
<head>

    <title>@yield('title','Book Swapper')</title>
    @include('includes.head')

    @yield('head')


</head>
<body>
@include('includes.header')

<div class="container">
    <header class="row">
        <h1>@yield('header') </h1>
    </header>
</div>

@if(Session::has('errors'))
    <div class='alert alert-danger'> @yield('errormsg')</div>
@endif
<div class='alert-warning'> @yield('flashmsg') </div>

     <p> @yield ('parainfo') </p>

<div class="text-center">
@yield('body')
</div>

<div class="form-group col-xs-6 col-sm-6 col-md-6">
            @yield('form')
</div>

  <div class="logininfo">
      @yield('loginfo')
  </div>


@include('includes.footer')
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>

</body>
</html>
