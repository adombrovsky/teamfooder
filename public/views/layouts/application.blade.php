<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Laravel4 & Backbone | Nettuts</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A single page blog built using Backbone.js, Laravel, and Twitter Bootstrap">
    <meta name="author" content="Conar Welsh">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-tagsinput.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chosen.css') }}" rel="stylesheet">
    <script type="text/javascript">
        var loggedUser = {{$user}}
        var loginUrl = {{$loginUrl}}
    </script>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="{{ asset('js/html5shiv.js') }}"></script>
    <![endif]-->
</head>

<body>
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Food delivery</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                @if ($user === 'false')
                    <li><a href="/login">Login</a></li>
                    <li><a href="/registration">Registration</a></li>
                @else
                    <li><a href="/orders">Food requests</a></li>
                    <li><a href="/orders/create"><span class="glyphicon glyphicon-plus"></span>Create food request</a></li>
                    <li><a href="/dev/logout" data-bypass="true">Logout</a></li>
                @endif
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>
<!-- Begin page content -->
<div class="container container-fluid" data-role="main">
</div>

<div class="footer">
    <div class="container">
        <p class="text-muted">Place sticky footer content here.</p>
    </div>
</div>
<div id="notifications"></div>
<script src="{{ asset('js/libs/require.js') }}" data-main="{{ asset('js/app.js') }}"></script>
@yield('scripts')
</body>
</html>
