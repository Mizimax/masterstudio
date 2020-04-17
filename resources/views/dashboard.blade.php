<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/css/dashboard.css">
    @yield('style')
    <script>
      var page = '@yield('page')'
    </script>
</head>
<body>
    <!--Navbar-->
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
                            <a id="user-menu" class="nav-link px-2 px-lg-3" href="/dashboard/user">User</a>
                        </li>
                        <li class="nav-item">
                            <a id="story-menu" class="nav-link px-2 px-lg-3"
                               href="/dashboard/story">Story</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a id="master-menu" class="nav-link px-2 px-lg-3" href="/dashboard/master">Master</a>
                    </li>
                    <li class="nav-item">
                        <a id="activity-menu" class="nav-link px-2 px-lg-3"
                           href="/dashboard/activity">Activity</a>
                    </li>
                    <li class="nav-item">
                        <a id="studio-menu" class="nav-link px-2 px-lg-3" href="/dashboard/studio">Studio</a>
                    </li>
                        <li class="nav-item">
                            <a id="mail-menu" class="nav-link px-2 px-lg-3"
                               href="/dashboard/mail">Email</a>
                        </li>
                </ul>
            </div>

        </nav>
    </div>
    <!--/.Navbar-->

    <div class="content-wrapper">
        @yield('content')
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script>
      $(document).ready(function () {
        $('#' + page + '-menu').addClass('active')
      })
    </script>
    @yield('script')
</body>
</html>