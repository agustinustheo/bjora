<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bjora</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}" />
    </head>
    <body>
        <nav class="bg-dark">
            <div class="container-navbar">
                <div class="navbar-header">
                    <span class="navbar-brand text-danger">Bjora</span>
                </div>
                <div id="navbarNav">
                    <ul class="navbar-nav navbar-align-right">
                        <li class="nav-item active">
                            <a class="nav-link text-light" href="/login">Login <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="/register">Register</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="container-navbar">
                <div class="navbar-header nav-time">
                    <span class="text-light" id="time">00:00:00</span>
                </div>
            </div>
        </nav>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <div class="container main-container">
            @yield('content')
        </div>
        <footer class="page-footer bg-dark text-center p-3">
            <span class="text-light">©️&nbsp;2019&nbsp;Copyright&nbsp;<span class="text-danger">Bjora.com</span></span>
        </footer>
    </body>
</html>
