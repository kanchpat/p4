<!DOCTYPE html>
<html>
<head>

    <title>@yield('title','Book Swapper')</title>
    @include('includes.head')

    @yield('head')


</head>
<body>
@include('includes.header')

@yield('content')

<div class='alert-warning'> @yield('flashmsg') </div>

<div class="container">
    <div class="page-header">
        <h1>  @yield('header') </h1>
    </div>
    <p> @yield ('parainfo') </p>
</div>


@yield('body')

  <div class="form">
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
