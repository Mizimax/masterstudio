<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - Master Studio</title>
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
                                <img src="/img/icon/user-circle-regular.svg" class="svg" />
                                |
                                <span class="menu-name">Your profile</span>
                            </a>
                        </div>
                        <div class="sub-menu">
                            <a href="/profile">
                                <img src="/img/icon/user-circle-regular.svg" class="svg" />
                                |
                                <span class="menu-name">My activities</span>
                            </a>
                        </div>
                        <div class="sub-menu">
                            <a href="/profile">
                                <img src="/img/icon/user-circle-regular.svg" class="svg" />
                                |
                                <span class="menu-name">Following</span>
                            </a>
                        </div>
                        <br><br>
                        <div class="sub-menu">
                            <a href="#">
                                <img src="/img/icon/user-circle-regular.svg" class="svg" />
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

    <div class="footer text-center text-md-left">
        <div class="footer-wrapper">
            <h1 class="logo-name">MASTER STUDIO</h1>
            <div class="row flex-column flex-sm-row">
                <div class="col menu-list">
                    <div class="title">Menu</div>
                    <a href="/">
                        <div id="home-footer" class="menu">Home</div>
                    </a>
                    <a href="/activity">
                        <div id="activity-footer" class="menu">Activities</div>
                    </a>
                    <a href="/master">
                        <div id="master-footer" class="menu">Master</div>
                    </a>
                    <a href="/studio">
                        <div id="studio-footer" class="menu">Studio</div>
                    </a>
                    <a href="/become">
                        <div id="become-footer" class="menu">Become master</div>
                    </a>
                </div>
                <div class="col follow-us">
                    <div class="title">Follow us</div>
                    <div class="follow">
                        <div class="fb-page" data-href="https://www.facebook.com/salehere/"
                             data-tabs="timeline" data-width="" data-height="250"
                             data-small-header="false" data-adapt-container-width="true"
                             data-hide-cover="false" data-show-facepile="true">
                            <blockquote cite="https://www.facebook.com/salehere/"
                                        class="fb-xfbml-parse-ignore"><a
                                        href="https://www.facebook.com/salehere/"></a></blockquote>
                        </div>
                    </div>
                </div>
                <div class="col email-sub">
                    <div class="title">Up to date your activities</div>
                    <div class="email" align="right">
                        <input class="input w-100 font-italic color-black" type="text"
                               placeholder="Your contact email here">
                        <button class="sub-btn primary-bg mt-2" type="button">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom" align="center">
        Allright reserved @master studio <span style="margin-left: 30px;">Since : 2019</span>
    </div>

    <!-- Facebook Page -->
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous"
            src="https://connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v4.0&appId=1395710807149187&autoLogAppEvents=1"></script>

    @if(config('app.env') == 'local')
        <script id="__bs_script__">//<![CDATA[
          document.write('<script async src=\'http://HOST:3000/browser-sync/browser-sync-client.js?v=2.18.6\'><\/script>'.replace('HOST', location.hostname))
          //]]>
        </script>
    @endif
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/js/bootstrap.min.js"></script>
    @yield('script')
    <script>
        var MasterStudio = {
            videoHover: {
                play: false
            },
            videoPreview: {
                play: false,
                src: ''
            }
        }
    </script>
    <script src="/js/app.js"></script>
    <script>
      $(document).ready(function () {
        $('#' + page + '-menu').addClass('active')
        $('.footer #' + page + '-footer').addClass('active')
        /*
        * Replace all SVG images with inline SVG
        */
        jQuery('img.svg').each(function () {
          var $img = jQuery(this)
          var imgID = $img.attr('id')
          var imgClass = $img.attr('class')
          var imgURL = $img.attr('src')

          jQuery.get(imgURL, function (data) {
            // Get the SVG tag, ignore the rest
            var $svg = jQuery(data).find('svg')

            // Add replaced image's ID to the new SVG
            if (typeof imgID !== 'undefined') {
              $svg = $svg.attr('id', imgID)
            }
            // Add replaced image's classes to the new SVG
            if (typeof imgClass !== 'undefined') {
              $svg = $svg.attr('class', imgClass + ' replaced-svg')
            }

            // Remove any invalid XML tags as per http://validator.w3.org
            $svg = $svg.removeAttr('xmlns:a')

            // Check if the viewport is set, if the viewport is not set the SVG wont't scale.
            if (!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
              $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
            }

            // Replace image with new SVG
            $img.replaceWith($svg)

          }, 'xml')

        })
          @yield('scriptready')
      })
    </script>
</body>
</html>
