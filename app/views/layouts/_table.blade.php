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
        @yield('header')
    </header>
</div>


@if(Session::has('errors'))
<div class='alert alert-danger'> @yield('errormsg')</div>
@endif
<div class='alert-warning'> @yield('flashmsg') </div>

<div class="form-group center_div">
    @yield('form')
</div>

<div class="container">
    <div class="panel panel-info">
        <!-- Default panel contents -->
        <div class="panel-heading">@yield('tableheader')</div>
        <div class="panel-body">
            <p>@yield('tabledesc') </p>
        </div>

        <!-- Table -->
        <table class="table table-bordered table-striped table-condensed table-hover table-nonfluid">
            @yield('tabledata')
        </table>
    </div>
</div>

@include('includes.footer')
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>

</body>
</html>
