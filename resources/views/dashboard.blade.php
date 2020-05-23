<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard</title>
    <link rel="stylesheet" href="/css/dashboard.css?v=1.2">
    @if($user['user_type'] != 'admin')
        <style>
            body {
                background: white;
            }
        </style>
    @endif
    @yield('style')
    <script>
      var page = '@yield('page')'
    </script>
</head>
<body>
    <!--Navbar-->
    @if(Auth::check())
        <div class="navbar-wrapper">
            <nav class="navbar navbar-light navbar-expand-md bg-white">
                <a class="navbar-brand primary-color" href="/">
                    <img src="/img/logo/logo.png" alt="Master Studio" class="logo">
                    <img src="/img/logo/logo-mobile.png" alt="Master Studio" class="logo-mobile">
                </a>

                <button class="navbar-toggler border-0 mr-1" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon primary-color"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto mt-2 mr-1 mt-md-0">
                        @if($user['user_type'] == 'admin')
                            <li class="nav-item">
                                <a id="dashboard-menu" class="nav-link px-2 px-lg-3"
                                   href="/dashboard">Overview</a>
                            </li>
                            <li class="nav-item">
                                <a id="user-menu" class="nav-link px-2 px-lg-3"
                                   href="/dashboard/user">User</a>
                            </li>
                            <li class="nav-item --border">
                                <a id="story-menu" class="nav-link px-2 px-lg-3"
                                   href="/dashboard/story">Story</a>
                            </li>
                            <li class="nav-item">
                                <a id="category-menu" class="nav-link px-2 px-lg-3"
                                   href="/dashboard/category">Categories</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a id="studio-menu" class="nav-link px-2 px-lg-3"
                               href="/dashboard/studio">Studio</a>
                        </li>
                        <li class="nav-item">
                            <a id="master-menu" class="nav-link px-2 px-lg-3"
                               href="/dashboard/master">Master</a>
                        </li>
                        <li class="nav-item {{ $user['user_type'] == 'admin' ? '--border' : '' }}">
                            <a id="activity-menu" class="nav-link px-2 px-lg-3"
                               href="/dashboard/activity">Activity</a>
                        </li>
                        @if($user['user_type'] == 'admin')
                            <li class="nav-item">
                                <a id="mail-menu" class="nav-link px-2 px-lg-3"
                                   href="/dashboard/mail">Email</a>
                            </li>
                        @endif
                        @if(\Auth::check())

                            <li class="nav-item --border --left">
                                <a id="mail-menu" class="nav-link px-2 px-lg-3"
                                   href=""
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout
                                    <form id="logout-form" action="/logout/back" method="post"
                                          style="display: none">
                                        @csrf
                                    </form>
                                </a>
                            </li>
                        @else
                            <li class="nav-item --border --left">
                                <a id="mail-menu" class="nav-link px-2 px-lg-3"
                                   href="/dashboard/login">Login</a>
                            </li>
                        @endif
                    </ul>
                </div>

            </nav>
        </div>
    @endif
<!--/.Navbar-->

    @if(Auth::check())
        <div class="content-wrapper">
            @yield('content')
        </div>
    @else
        <div class="login-form-wrapper">
            <div class="form-header"
                 style="border-bottom: 1px solid #f14ea6; padding-bottom: 20px; margin-bottom: 20px;">
                <img src="/img/logo/logo.png" alt="Master Studio" class="logo">
                <div align="center" style="color: #f14ea6; font-size: 30px; font-weight: bold">
                    Administer
                </div>
            </div>
            <div id="login-error" style="color: red;" align="center"></div>
            <form id="loginForm" class="register-form" action="/login" method="post">
                @csrf
                <div class="form-group">
                    <label for="user_email">Email</label>
                    <input style="border-color: #f14ea6; box-shadow: none" required type="text"
                           id="user_email" name="user_email" class="form-control mt-2">
                </div>
                <div class="form-group">
                    <label for="user_password">Password</label>
                    <input style="border-color: #f14ea6; box-shadow: none" required type="password"
                           id="password" name="password"
                           id="password" class="form-control mt-2">
                </div>

                <div class="modal-action justify-content-center">
                    <button type="submit" class="primary-button w-100"
                            style="padding: 10px; border-radius: 10px; font-size: 18px; font-weight: bold">
                        Login
                    </button>
                </div>
            </form>
        </div>
    @endif

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script>
      $(document).ready(function () {
        $('#' + page + '-menu').addClass('active')
          @if(!Auth::check())
          @if($errors->any())
          alert('{{ $errors->first() }}')
          @endif
          @endif
      })
    </script>
    @yield('script')
</body>
</html>