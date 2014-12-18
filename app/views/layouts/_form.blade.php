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

     <p> @yield ('parainfo') </p>


<div class="form-group col-xs-6 col-sm-6 col-md-6">
            @yield('form')
</div>

<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">@yield('panel_head')</h3>
            </div>
            <div class="panel-body">
                <form role="form">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                @yield('form1_field')
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                @yield('form2_field')
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        @yield('form3_field')
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                @yield('form4_field')
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                @yield('form5_field')
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        @yield('form6_field')
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                @yield('form7_field')
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        @yield('form8_field')
                    </div>


                </form>
            </div>
        </div>
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
