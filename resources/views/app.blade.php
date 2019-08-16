<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - Master Studio</title>
    <link rel="stylesheet" href="/css/app.css">
    @yield('style')
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

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                           role="button" data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false">
                            Dropdown
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Disabled</a>
                    </li>
                </ul>
                <div class="user-info-menu row no-gutters">
                    <div class="col-auto px-2 image-wrapper">
                        <img class="border-circle" src="/img/profile.jpg" width="50" title="Profile image"
                             alt="Profile image">
                    </div>
                    <div class="col">
                        <div class="">
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
                        <div></div>
                    </div>
                </div>
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
    @yield('script')
</body>
</html>
