<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - Master Studio</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    @yield('style')
    <script>
        var page = '@yield('page')'
    </script>
</head>
<body>
<!--Navbar-->
<div class="navbar-wrapper">
    <nav class="navbar navbar-light navbar-expand-md bg-white">
        <a class="navbar-brand primary-color" href="#">Master Studio</a>

        <button class="navbar-toggler border-0 mr-1" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon primary-color"></span>
        </button>

        <div class="user-info-menu row no-gutters">
            <div class="profile-dropdown">
                <div class="profile-space"></div>
                <div class="profile-menu">
                    <div class="sub-menu">
                        <a href="/profile">
                            <img src="/img/icon/user-circle-regular.svg" class="svg"/>
                            |
                            <span class="menu-name">Your profile</span>
                        </a>
                    </div>
                    <div class="sub-menu">
                        <a href="/profile">
                            <img src="/img/icon/user-circle-regular.svg" class="svg"/>
                            |
                            <span class="menu-name">My activities</span>
                        </a>
                    </div>
                    <div class="sub-menu">
                        <a href="/profile">
                            <img src="/img/icon/user-circle-regular.svg" class="svg"/>
                            |
                            <span class="menu-name">Following</span>
                        </a>
                    </div>
                    <br><br>
                    <div class="sub-menu">
                        <a href="#">
                            <img src="/img/icon/user-circle-regular.svg" class="svg"/>
                            |
                            <span class="menu-name --logout">Logout</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-auto px-2 image-wrapper">
                <img class="border-circle" src="/img/profile.jpg" width="40" height="40"
                     title="Profile image"
                     alt="Profile image">
            </div>
            <div class="col d-none d-lg-block profile-detail">
                <div class="name">
                    Tammanoon Jomjaturong
                </div>
                <div class="user-progress pb-1">
                    <div class="row no-gutters">
                        <div class="col-auto mr-1 level">L. 49</div>
                        <div class="col" style="margin-top: 3px;">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar"
                                     style="width: 50%" aria-valuenow="50"
                                     aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-aut ml-1 levelup">50</div>
                    </div>
                </div>
                <div class="coin">
                    9999
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mt-2 mt-md-0">
                <li class="nav-item">
                    <a id="home-menu" class="nav-link px-2 px-lg-3" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a id="activity-menu" class="nav-link px-2 px-lg-3" href="/activity">Activities</a>
                </li>
                <li class="nav-item">
                    <a id="master-menu" class="nav-link px-2 px-lg-3" href="/master">Master</a>
                </li>
                <li class="nav-item">
                    <a id="studio-menu" class="nav-link px-2 px-lg-3" href="/studio">Studio</a>
                </li>
                <li class="nav-item">
                    <a id="become-menu" class="nav-link px-2 px-lg-3" href="/master/become">Become
                        master</a>
                </li>
            </ul>
        </div>

    </nav>
</div>
<!--/.Navbar-->
<div class="content">
    @yield('content')
</div>

<div class="footer">
    <div class="footer-wrapper">
        <h1 class="logo-name">MASTER STUDIO</h1>
        <div class="row">
            <div class="col">
                <div class="menu"></div>
            </div>
            <div class="col">
                <div class="follow"></div>
            </div>
            <div class="col">
                <div class="email"></div>
            </div>
        </div>
    </div>
    <div class="footer-bottom" align="center">
        Allright reserved @master studio <span style="margin-left: 30px;">Since : 2019</span>
    </div>
</div>

@if(config('app.env') == 'local')
    <script id="__bs_script__">//<![CDATA[
        document.write('<script async src=\'http://HOST:3000/browser-sync/browser-sync-client.js?v=2.18.6\'><\/script>'.replace('HOST', location.hostname))
        //]]>
    </script>
@endif
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/js/bootstrap.min.js"></script>
<script src="/js/app.js"></script>
@yield('scriptfile')
<script>
    $(document).ready(function () {
        $('#' + page + '-menu').addClass('active')
        @yield('script')
    })
</script>

</body>
</html>
