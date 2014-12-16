<!DOCTYPE html>
<html>
<head>

    <title>@yield('title','Book Swapper')</title>
    @include('includes.head')
    @yield('head')
</head>
<body>
@include('includes.main')
<div class="container">
    <header class="row">
        <h1>@yield('header') </h1>
    </header>
</div>

<div class='alert-warning'> @yield('flashmsg') </div>
@if(Session::has('error_message'))
<div class='alert alert-danger'> @yield('errormsg')</div>
@endif
<div class="form-group">
    @yield('form')
</div>

@include('includes.footer')
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>

</body>
</html>
