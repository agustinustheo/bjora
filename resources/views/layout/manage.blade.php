<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name') }}</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}" />
    </head>
    <body>
        <nav class="bg-dark p-1">
            <div class="container-navbar">
                <div class="navbar-header d-flex align-items-center">
                    <a class="navbar-brand text-danger navbar-link" href="/">Bjora</a>
                    @if(Auth::check())
                    {{-- <a class="nav-link text-light d-block mt-1 mr-3" href="/question">Manage</a> --}}
                    <div class="dropdown nav-link text-light d-block mt-1 mr-3">
                        <button class="dropbtn">Manage
                          <i class="fa fa-caret-down"></i>
                        </button>
                        @if(Auth::user()->name == 'Admin')
                            <div class="dropdown-content">
                              <a href="">Manage Question</a>
                              <a href="{{route('view-all-user')}}">Manage User</a>
                              <a href="{{route('view-all-topic')}}">Manage Topic</a>
                            </div>
                        @else
                            <div class="dropdown-content">
                                <a href="">My Question</a>
                                <a href="/question/add">Add Question</a>
                            </div>
                        @endif
                    </div> 
                    @endif
                </div>
                @if(Auth::check())
                <div id="navbarNav">
                    <ul class="navbar-nav navbar-align-right">
                        <li class="nav-item active">
                            <a class="nav-link text-light" href="/profile">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="/logout">Log Out</a>
                        </li>
                    </ul>
                </div>
                @else 
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
                @endif
            </div>
            <div class="container-navbar">
                <div class="navbar-header nav-time">
                    <span class="text-light" id="time"><?php echo date('Y-m-d H:i:s'); ?></span>
                </div>
            </div>
        </nav>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="{{ URL::asset('js/application.js') }}"></script>
        <div class="container main-container">
            @yield('content')
        </div>
        <footer class="page-footer bg-dark text-center p-3 mt-4">
            <span class="text-light">©️&nbsp;2019&nbsp;Copyright&nbsp;<a class="text-danger footer-link" href="/">Bjora.com</a></span>
        </footer>
    </body>
</html>
