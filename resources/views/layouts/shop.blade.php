<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

@yield('title')

<!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>

        @font-face {
            font-family: AAvanteBs; /* Имя шрифта */
            src: url(fonts/Avante-BS-Bold.ttf); /* Путь к файлу со шрифтом */
        }

        body {
            font-family: AAvanteBs;
            background-color: white;
            color: rgba(0, 0, 0, 0.65);
        }

        .bgcolor-1 {
            background-color: #d3165a;
        }

        .navbar-image {
            height: 100%;
        }
        .navbar{
            height: 170px;
        }
        .navbar-header, .navbar-brand, .navbar-collapse, .navbar-nav, .nav,
        .collapse, table{
            height: 100%;
        }
        td, tr, table{
            vertical-align: middle;
        }
    </style>
</head>
<body>
<div id="app" class="container-fluid">
    <nav class="navbar">
        <div class="">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar bgcolor-1"></span>
                    <span class="icon-bar bgcolor-1"></span>
                    <span class="icon-bar bgcolor-1"></span>
                </button>
                <a class="navbar-brand" href="/"><img  class="navbar-image" src="images/logo-v2.png" alt=""></a>
            </div>
            <div style="border: double;" class="collapse navbar-collapse" id="myNavbar">
                <table style="border: double; height: 100px" class="nav navbar-nav">
                    <tr style="height: 100px">
                        <td class="active"><a href="#">Home</a></td>
                        <td><a href="#">Page 2</a></td>
                        <td><a href="#">Page 3</a></td>
                    </tr>
                </table>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div>
        @yield('content')
    </div>

</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
