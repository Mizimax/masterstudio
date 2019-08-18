<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - Master Studio</title>
    @yield('style')
    <script>
      var page = '@yield('page')'
    </script>
</head>
<body>
    <!--Navbar-->
    <div class="navbar-wrapper">
        <nav class="navbar navbar-expand-md bg-white">
            <a class="navbar-brand" href="#">Master Studio</a>

            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="user-info-menu row no-gutters">
                <div class="col-auto px-2 image-wrapper">
                    <img class="border-circle" src="/img/profile.jpg" width="50"
                         title="Profile image"
                         alt="Profile image">
                </div>
                <div class="col d-none d-lg-block">
                    <div class="name">
                        Tammanoon Jomjaturong
                    </div>
                    <div class="user-progress pb-1">
                        <div class="row no-gutters">
                            <div class="col-auto mr-1 level">L. 49</div>
                            <div class="col" style="margin-top: 3px;">
                                <div class="progress">
                                    <div class="progress-bar bg-primary" role="progressbar"
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
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a id="home-menu" class="nav-link px-3" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a id="activity-menu" class="nav-link px-3" href="/activity">Activities</a>
                    </li>
                    <li class="nav-item">
                        <a id="master-menu" class="nav-link px-3" href="/master">Master</a>
                    </li>
                    <li class="nav-item">
                        <a id="studio-menu" class="nav-link px-3" href="/studio">Studio</a>
                    </li>
                    <li class="nav-item">
                        <a id="become-menu" class="nav-link px-3" href="/master/become">Become
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
    @if(config('app.env') == 'local')
        <script id="__bs_script__">//<![CDATA[
          document.write('<script async src=\'http://HOST:3000/browser-sync/browser-sync-client.js?v=2.18.6\'><\/script>'.replace('HOST', location.hostname))
          //]]>
        </script>
    @endif
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/js/bootstrap.min.js"></script>
    <script src="/js/app.js"></script>
    <script>
      $(document).ready(function () {
        $('#' + page + '-menu').addClass('active')
          @yield('script')
      })
    </script>
    @yield('scriptfile')
</body>
</html>
