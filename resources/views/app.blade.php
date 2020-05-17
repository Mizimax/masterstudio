<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- SEO -->
    <meta name="description" content="@Master Studio - Meet real master.">
    <meta name="keywords" content="Master Studio,Master,Studio,Event">
    <meta name=”robots” content=”index,follow”>
    <meta name="revisit-after" content="7 days">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Facebook og -->
    <meta property="og:url"
          content="https://atmaster.maxang.me" />
    <meta property="og:type" content="Website" />
    <meta property="og:title" content="@yield('title') - Master Studio" />
    <meta property="og:description" content="@Master Studio - Meet real master." />
    <meta property="og:image"
          content="/img/preview.png" />

    <title>@yield('title') - Master Studio</title>
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css?v=1.0">
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

            @if (Auth::check())

                <div class="user-info-menu row no-gutters">
                    <div class="profile-dropdown">
                        <div class="profile-space">
                            <div class="col-auto px-2 image-wrapper">
                                <img class="border-circle" src="{{ $user['user_pic'] }}" width="45"
                                     height="45"
                                     title="{{ $user['user_name'] }}"
                                     alt="{{ $user['user_name'] }}">
                            </div>
                            <div class="d-none d-lg-block profile-detail">
                                <div class="name">
                                    {{ $user['user_name'] }}
                                </div>
                                <div class="user-progress pb-1">
                                    <div class="row no-gutters">
                                        <div class="col-auto mr-1 level">
                                            L. {{ $user['user_level'] }}</div>
                                        <div class="col" style="margin-top: 3px;">
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar"
                                                     style="width: {{ $user['user_exp']/$user['user_exp_max'] * 100 }}%"
                                                     aria-valuenow="50"
                                                     aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="coin">
                                    <img class="icon" src="/img/icon/coin.png"
                                         alt="coin"> {{ $user['user_coin'] }}
                                </div>
                            </div>
                        </div>
                        <div class="profile-menu">
                            <div class="sub-menu">
                                <a href="/user/me">
                                    <span class="menu-name">Your profile</span>
                                </a>
                            </div>
                            <div class="sub-menu">
                                <a href="#" onclick="modal('all')">
                                    <span class="menu-name">My activities</span>
                                </a>
                            </div>
                            <div class="sub-menu">
                                <a href="#" onclick="modal('follow')">
                                    <span class="menu-name">Following</span>
                                </a>
                            </div>
                            @if(Auth::user()->master_id)
                                <div class="sub-menu">
                                    <a href="/dashboard">
                                        <span class="menu-name">Dashboard</span>
                                    </a>
                                </div>
                            @endif
                            <br>
                            <div class="sub-menu --logout">
                                <a style="font-size: 14px; color: red;" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <span class="menu-name">
                                            Logout
                                        <form id="logout-form" action="/logout/back"
                                              method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="login">
                    <a href="#" data-toggle="modal" onclick="modal('login')">Login</a>
                </div>
            @endif

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto mt-2 mr-1 mt-md-0">
                    <li class="nav-item">
                        <a id="home-menu" class="nav-link px-2 px-lg-3" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a id="activity-menu" class="nav-link px-2 px-lg-3" href="/activity">Activity</a>
                    </li>
                    <li class="nav-item">
                        <a id="master-menu" class="nav-link px-2 px-lg-3" href="/master">Master</a>
                    </li>
                    <li class="nav-item">
                        <a id="studio-menu" class="nav-link px-2 px-lg-3" href="/studio">Studio</a>
                    </li>
                    <li class="nav-item">
                        <a id="become-menu" class="nav-link px-2 px-lg-3" href="#"
                           onclick="modal('become')">Become
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
    <!-- Policy Modal -->
    <div class="modal fade" id="policyModal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="logo-wrapper">
                        <img src="/img/logo.png" alt="Master Studio" class="logo">
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
    <!-- Policy Modal -->
    <div class="modal --policy fade" id="policyModal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="logo-wrapper">
                        <img src="/img/logo.png" alt="Master Studio" class="logo">
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
    <!-- Policy Modal -->
    <div class="modal --policy fade" id="termModal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="logo-wrapper">
                        <img src="/img/logo.png" alt="Master Studio" class="logo">
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="logo-wrapper">
                        <img src="/img/logo.png" alt="Master Studio" class="logo">
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>

    <div class="footer text-center text-md-left">
        <div class="footer-wrapper">
            <img src="/img/logo.png" alt="Master Studio" class="logo">
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
                    <a href="#privacy" onclick="$('#policyModal').modal('toggle')">
                        <div id="privacy" class="menu">Privacy Policy</div>
                    </a>
                    <a href="#term" onclick="$('#termModal').modal('toggle')">
                        <div id="term" class="menu">Terms and Conditions</div>
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

    {{--    @if(config('app.env') == 'local')--}}
    {{--        <script id="__bs_script__">//<![CDATA[--}}
    {{--          document.write('<script async src=\'http://HOST:3000/browser-sync/browser-sync-client.js?v=2.18.6\'><\/script>'.replace('HOST', location.hostname))--}}
    {{--          //]]>--}}
    {{--        </script>--}}
    {{--    @endif--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script>
      var MasterStudio = {
        videoHover: {
          play: false,
        },
        videoPreview: {
          play: false,
          src: '',
        },
      }
    </script>
    <script src="/js/app.js"></script>
    <script src="/js/category.js"></script>
    <script>
      var replaceSvg = function () {
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
      }
      $(document).ready(function () {
        $('#' + page + '-menu').addClass('active')
        $('.footer #' + page + '-footer').addClass('active')

        replaceSvg()

        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        })
                  @if(!$user)
        var hash = location.hash.substr(1)

        if (hash === 'login') {
          modal('login')
        }
          @endif

      })
    </script>
    <script>
      var dropdownInit = function () {

        var x, i, j, selElmnt, a, b, c
        /* Look for any elements with the class "custom-dropdown": */
        x = document.getElementsByClassName('custom-dropdown')

        for (i = 0; i < x.length; i++) {
          selElmnt = x[i].getElementsByTagName('select')[0]
          /* For each element, create a new DIV that will act as the selected item: */
          a = document.createElement('DIV')
          a.setAttribute('class', 'select-selected')
          a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML
          x[i].appendChild(a)
          /* For each element, create a new DIV that will contain the option list: */
          b = document.createElement('DIV')
          b.setAttribute('class', 'select-items select-hide')
          for (j = 1; j < selElmnt.length; j++) {
            /* For each option in the original select element,
            create a new DIV that will act as an option item: */
            c = document.createElement('DIV')
            c.innerHTML = selElmnt.options[j].innerHTML
            c.addEventListener('click', function (e) {
              /* When an item is clicked, update the original select box,
              and the selected item: */
              var y, i, k, s, h
              s = this.parentNode.parentNode.getElementsByTagName('select')[0]
              h = this.parentNode.previousSibling
              for (i = 0; i < s.length; i++) {
                if (s.options[i].innerHTML == this.innerHTML) {
                  s.selectedIndex = i
                  h.innerHTML = this.innerHTML
                  y = this.parentNode.getElementsByClassName('same-as-selected')
                  for (k = 0; k < y.length; k++) {
                    y[k].removeAttribute('class')
                  }
                  this.setAttribute('class', 'same-as-selected')
                  break
                }
              }
              h.click()
            })
            b.appendChild(c)
          }
          x[i].appendChild(b)
          a.addEventListener('click', function (e) {
            /* When the select box is clicked, close any other select boxes,
            and open/close the current select box: */
            e.stopPropagation()
            closeAllSelect(this)
            this.nextSibling.classList.toggle('select-hide')
            this.classList.toggle('select-arrow-active')
          })
        }

        function closeAllSelect(elmnt) {
          /* A function that will close all select boxes in the document,
          except the current select box: */
          var x, y, i, arrNo = []
          x = document.getElementsByClassName('select-items')
          y = document.getElementsByClassName('select-selected')
          for (i = 0; i < y.length; i++) {
            if (elmnt == y[i]) {
              arrNo.push(i)
            } else {
              y[i].classList.remove('select-arrow-active')
            }
          }
          for (i = 0; i < x.length; i++) {
            if (arrNo.indexOf(i)) {
              x[i].classList.add('select-hide')
            }
          }
        }

        /* If the user clicks anywhere outside the select box,
        then close all select boxes: */
        document.addEventListener('click', closeAllSelect)
      }
    </script>
    <script>
      var login = function () {
        $.ajax({
          url: '/login',
          type: 'post',
          dataType: 'json',
          processData: false,
          contentType: 'application/json',
          data: JSON.stringify({
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'user_email': $('#user_email').val(),
            'password': $('#user_password').val(),
          }),
          complete: function (res) {
            if (res.status === 200) {
              window.location.reload()
            } else {
              var jsonData = res.responseJSON
              var errors = jsonData.errors
              Object.keys(errors).forEach(function (key) {
                $('#login-error').text(errors[key])
                return false
              })

            }
          },
        })
      }

      var register = function () {
        $.ajax({
          url: '/register',
          type: 'post',
          data: $('#registerForm').serialize(),
          success: function (res) {
            activeTab('interestTab')
          },
          error: function (err) {
            var errors = err.responseJSON.errors
            for (let key in errors) {
              var input = $('input[name=' + key + ']')
              var element = input.siblings('.error-msg')
              if (input.length === 0) {
                input = $('select[name=' + key + ']')
                element = input.parents('.form-group').children('.error-msg')
              }
              element.removeClass('d-none')
              element.children('.text').text(errors[key])
            }
          },
        })
      }

      var addInterest = function (categoryId) {
        $.ajax({
          url: '/api/category/' + categoryId,
          type: 'post',
          dataType: 'json',
          processData: false,
          contentType: 'application/json',
          data: JSON.stringify({
            '_token': $('meta[name="csrf-token"]').attr('content'),
          }),
        })
      }

      var getMap = function () {
        $.ajax({
          url: '/content/map',
          type: 'get',
          success: function (res) {
            $('#studioTab').html(res)
          },
        })
      }

      var getAllActivity = function () {
        $.ajax({
          url: '/content/allActivity',
          type: 'get',
          data: JSON.stringify({
            '_token': $('meta[name="csrf-token"]').attr('content'),
          }),
          success: function (data) {
            $('#my-activity').append(data)
          },
          error: function (error) {
            console.log(error)
          },
        })
      }

      var getFollowMaster = function () {
        $.ajax({
          url: '/content/follow/master',
          type: 'get',
          data: JSON.stringify({
            '_token': $('meta[name="csrf-token"]').attr('content'),
          }),
          success: function (data) {
            $('#masterTab').html(data)
            replaceSvg()
            // video click
            var figure = $('.master-video').click(function () {
              var played = $(this).attr('played') == 'true'
              if (!played) {
                $(this).children('.video-wrapper').children('.video').get(0).play()
              } else {
                $(this).children('.video-wrapper').children('.video').get(0).pause()
              }
              $(this).children('.video-wrapper').children('.play-wrapper').toggleClass('d-none')
              $(this).attr('played', !played)
            })
          },
          error: function (error) {
            console.log(error)
          },
        })
      }
    </script>
    <script>
      var interestMaster = []

      function activeTab(tab) {
        $('.nav-tabs a[href="#' + tab + '"]').tab('show')
        $('#modal .modal-dialog').css('max-width', '380px')
        if (tab === 'interestTab') {
          replaceSvg()
          $('#modal .modal-dialog').css('max-width', '450px')
          $('.interest-badge').off('click').on('click', function () {
            $(this).toggleClass('active')
            var interestId = parseInt($(this).children('.val').val(), 10)
            addInterest(interestId)
          })
        } else if (tab === 'moreTab') {
          selectButton()
        } else if (tab === 'paymentTab') {
          $('#modal .modal-header').removeClass('d-none')
          replaceSvg()
          $('.payment-badge').off('click').on('click', function () {
            $(this).parent().children('.active').removeClass('active')
            $(this).toggleClass('active')
            $('.form-card-wrapper').hide()
          })

          $('#newCard').on('click', function () {
            $('.form-card-wrapper').show()
          })
        } else if (tab === 'studioTab' || tab === 'masterTab') {
          $('#modal .modal-dialog').css('max-width', '900px')
          $('#modal .modal-dialog').css('width', '95%')
          if ($('#studioTab').html().trim() === '') {
            getMap()
          }

        } else if (tab === 'become1Tab') {
          $('#modal .modal-dialog').css('max-width', '450px')
          replaceSvg()
          $('.interest-badge').on('click', function () {
            $(this).toggleClass('active')
            var interestId = parseInt($(this).children('.val').val(), 10)
            interestMaster.push(interestId)
          })
        } else if (tab === 'become2Tab') {
          uploadBox()
          $('#becomeSubmit').submit
        }

      }

      var selectButton = function () {
        $('.select-button').off('click').on('click', function () {
          $(this).parent().children('.active').removeClass('active')
          $(this).toggleClass('active')
          $(this).siblings('input[type="hidden"]').val($(this).attr('value'))
        })
      }

      var uploadBox = function () {
        $('.form-box').change(function () {
          $(this).attr('title', '')
          var self = $(this)
          var file = this.files[0]
          var fileReader = new FileReader()
          fileReader.readAsDataURL(file)

          fileReader.onload = function (e) {
            self.css('background-image', 'url(' + e.target.result + ')')
          }

        })
      }

      var registerModal = `
      <ul class="nav nav-tabs d-none" id="registerTabLink" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="register-tab" data-toggle="tab" href="#registerTab" role="tab" aria-controls="home" aria-selected="true">Register</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="interest-tab" data-toggle="tab" href="#interestTab" role="tab" aria-controls="profile" aria-selected="false">Interest</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="more-tab" data-toggle="tab" href="#moreTab" role="tab" aria-controls="contact" aria-selected="false">More</a>
  </li>
</ul>
            <div class="tab-content" id="registerTabPane">
              <div class="tab-pane fade in show active" id="registerTab" role="tabpanel" aria-labelledby="register-tab">
                <form id="registerForm" onsubmit="register();return false;" class="register-form">
            @csrf
        <div class="headerName">Registration</div>
        <div class="form-group">
            <label for="user_firstname">Firstname</label>
            <input required type="text" name="user_firstname" id="user_firstname" class="form-control"
                   placeholder="Firstname">
        </div>
        <div class="form-group">
            <label for="user_surname">Surname</label>
            <input required type="text" name="user_surname" id="user_surname" class="form-control"
                   placeholder="Surname">
        </div>
        <div class="form-group">
            <label for="user_email">Email</label>
            <span class="error-msg d-none">
                <img class="svg" src="/img/icon/exclamation-circle-solid.svg" />
                <span class="text"></span>
            </span>
            <input required type="email" name="user_email" id="user_email" class="form-control"
                   placeholder="Email">
        </div>
        <div class="form-group">
            <label for="user_birth">Date of birth</label>
            <span class="error-msg d-none">
                <img class="svg" src="/img/icon/exclamation-circle-solid.svg" />
                <span class="text"></span>
            </span>
            <div class="birth-wrapper">
                <div class="custom-dropdown">
                    <select name="user_day">
                        <option value="">Day</option>
                        @for($i = 1; $i <= 31; $i++)
        <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
        </select>
</div>
<div class="custom-dropdown" style="flex:1 1 30px;">
<select name="user_month">
<option value="">Month</option>
<option value="1">January</option>
<option value="2">February</option>
<option value="3">March</option>
<option value="4">April</option>
<option value="5">May</option>
<option value="6">June</option>
<option value="7">July</option>
<option value="8">August</option>
<option value="9">September</option>
<option value="10">October</option>
<option value="11">November</option>
<option value="12">December</option>
</select>
</div>
<div class="custom-dropdown">
<select name="user_year">
<option value="">Year</option>
@for($i = 2019; $i >= 1905; $i--)
        <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
        </select>
    </div>
</div>
</div>
<div class="form-group">
<label for="user_password">Password</label>
<span class="error-msg d-none">
    <img class="svg" src="/img/icon/exclamation-circle-solid.svg" />
    <span class="text"></span>
</span>
<input required type="password" id="user_password" name="user_password"
       id="password" class="form-control" placeholder="Password">
</div>
<div class="form-group">
<label for="user_password_confirmation">Re-password</label>
<span class="error-msg d-none">
    <img class="svg" src="/img/icon/exclamation-circle-solid.svg" />
    <span class="text"></span>
</span>
<input required type="password" id="user_password_confirmation"
       name="user_password_confirmation" class="form-control"
       placeholder="Re-password">
</div>

<div class="modal-action justify-content-end">

<button type="submit" class="primary-button">Next</button>

</div>
</form>
              </div>
              <div class="tab-pane fade" id="interestTab" role="tabpanel" aria-labelledby="interest-tab">
              <div class="interest-modal" align="center">
                        <h3 class="header">What you interested?</h3>
                        <div class="sub-header">can choose more than 1</div>
                        <input class="search-interest" type="text"
                               placeholder="Search what interest?">
                        <div class="interest-wrapper">
                            @foreach($categories as $category)
        <div class="interest-badge">
            <img src="{{ $category['category_pic'] }}" class="svg">
                                <div class="name">{{ $category['category_name'] }}</div>
                                <input type="hidden" class="val" value="{{ $category['category_id'] }}">
                            </div>
                            @endforeach
        </div>
        <div class="modal-action justify-content-end">
            <button class="primary-button" onclick="activeTab('moreTab')">Next
            </button>
        </div>
    </div>
</div>
<div class="tab-pane fade" id="moreTab" role="tabpanel" aria-labelledby="more-tab">
    <form id="moreForm" action="/add/more" method="post">
    @csrf
        <div class="interest-modal">

                            <div class="headerName">Registration</div>
                            <h3 class="question-header">What are you looking for ?</h3>
                            <div class="form-group">
                                <label for="goal" class="question">What are you aiming?</label>
                                <textarea name="user_goal" class="search-interest --goal"
                                          placeholder="Your goal your passion"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="goal" class="question">Are you basing in Thailand?</label>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="select-button flex-grow-1" value="0">Yes</button>
                                    <button type="button" class="select-button flex-grow-1" value="1">No</button>
                                    <button type="button" class="select-button flex-grow-1" value="2">Both</button>
                                    <input name="user_base_in_th" type="hidden">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="goal" class="question">Which one you prefer?</label>
                                    <button type="button" class="select-button" value="0">Group activity</button><br>
                                    <button type="button" class="select-button" value="1">Solo activity</button><br>
                                    <button type="button" class="select-button" value="2">Both</button>
                                    <input name="user_interest_type" type="hidden">

                            </div>
                            <div class="form-group">
                                <label for="goal" class="question">Rating how professional you
                                    want</label>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="select-button --circle" value="1">1</button>
                                    <button type="button" class="select-button --circle" value="2">2</button>
                                    <button type="button" class="select-button --circle" value="3">3</button>
                                    <button type="button" class="select-button --circle" value="4">4</button>
                                    <button type="button" class="select-button --circle" value="5">5</button>
                                    <button type="button" class="select-button --circle" value="6">6</button>
                                    <button type="button" class="select-button --circle" value="7">7</button>
                                    <input name="user_prof_rate" type="hidden">
                                </div>
                            </div>
                            <div class="modal-action justify-content-end">
                                <button class="primary-button">Done
                                </button>
                            </div>
                        </div>
                        </form>
    </div>
    </div>
`
      var loginModal = `
           @if(!$user)
          <div id="login-error" style="color: red;" align="center"></div>
          <form id="loginForm" class="register-form" onsubmit="login(); return false;">
                        <div class="form-group">
                            <label for="user_email">Email</label>
                            <input required type="text" id="user_email" class="form-control"
                                   placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="user_password">Password</label>
                            <input required type="password" id="user_password" name="user_password"
                                   id="password" class="form-control" placeholder="Password">
                        </div>

                    <div class="modal-action justify-content-center">
                        <button type="button" class="primary-button --outline" onclick="modal('register')">Register</button>
                        <button type="submit" class="primary-button">Login</button>
                    </div>
                    <div align="center"><a href="/password/reset" style="font-size: 13px;">Forgot password ?</a></div>
                    <br/>
            </form>
            @endif
          `

      var allActivityModal = `
        <div id="my-activity" class="my-activity">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                <div class="all-activity-header" align="center">All Activities</div>

        </div>
      `

      var followModal = `
<div class="follow-container">
 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="header" align="center">Followed</div>
                        <ul class="nav nav-tabs justify-content-center border-bottom-0"
                            id="followTabLink" role="tablist">
                            <li class="nav-item mx-1">
                                <a class="nav-link pay-button --outline active"
                                   href="#masterTab"
                                   style="border-radius: 15px; padding: 10px 50px;" id="master-tab"
                                   onclick="activeTab('masterTab')">Master</a>
                            </li>
                            <li class="nav-item mx-1">
                                <a class="nav-link pay-button --outline"
                                   href="#studioTab"
                                   style="border-radius: 15px; padding: 10px 50px;" id="studio-tab"
                                   onclick="activeTab('studioTab')">Studio</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="followTabPane">
                            <div class="category-wrapper my-4" align="center">
{{--                                @include('components.category-interest')--}}
        </div>
        <div class="tab-pane py-3 fade in show active" id="masterTab" role="tabpanel"
             aria-labelledby="register-tab" align="center">

        </div>
        <div class="tab-pane py-3 fade in" id="studioTab" role="tabpanel" align="center">

        </div>
    </div>
</div>
`

      var becomeModal = `
        <ul class="nav nav-tabs d-none" id="becomeTabLink" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="become1-tab" data-toggle="tab"
                               href="#become1Tab" role="tab" aria-controls="home"
                               aria-selected="true">Register</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="become2-tab" data-toggle="tab"
                               href="#become2Tab" role="tab" aria-controls="profile"
                               aria-selected="false">Interest</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="more-tab" data-toggle="tab" href="#moreTab"
                               role="tab" aria-controls="contact" aria-selected="false">More</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="becomeTabPane">
                        {{--                        <h3>Become Master</h3>--}}
        <div class="tab-pane fade in show active" id="become1Tab" role="tabpanel"
             aria-labelledby="register-tab">
            <div class="interest-modal" align="center">
                <h3 class="header">What your mastered about?</h3>
                <div class="sub-header">can choose more than 1</div>
                <input class="search-interest" type="text"
                       placeholder="Search what interest?">
                <div class="interest-wrapper">
@foreach($categories as $category)
        <div class="interest-badge">
            <img src="{{ $category['category_pic'] }}" class="svg">
                                            <div class="name">{{ $category['category_name'] }}</div>
                                            <input type="hidden" class="val"
                                                   value="{{ $category['category_id'] }}">
                                        </div>
                                    @endforeach
        </div>
    </div>
    <div class="modal-action justify-content-end">
        <button class="primary-button" onclick="activeTab('become2Tab')">
            Next
        </button>
    </div>
</div>
<div class="tab-pane fade in" id="become2Tab" role="tabpanel"
     aria-labelledby="register-tab">
    <h5 align="center">Fill information</h5>
    <form method="post" action="/become" enctype="multipart/form-data">
        @csrf
        <input type="hidden" value="">
        <div class="form-group">
            <label for="cert">Certification</label>
            <div class="d-flex">
                <input title="Upload" type="file" name="cert_1" id="user_firstname"
                       class="form-control form-box"
                       placeholder="card number">
                <input title="Upload" type="file" name="cert_2" id="user_firstname"
                       class="form-control form-box"
                       placeholder="card number">
                <input title="Upload" type="file" name="cert_3" id="user_firstname"
                       class="form-control form-box"
                       placeholder="card number">
            </div>
        </div>
        <div class="form-group">
            <label for="pro_desc">Profession description</label>
            <textarea required name="pro_desc" class="search-interest --goal"
                      placeholder="Describe about yourself / your master"></textarea>
        </div>
        <div class="form-group">
            <label for="phone_number">Phone number</label>
            <input required type="text" name="phone_number" id="user_firstname"
                   class="form-control"
                   placeholder="Your phone number">
        </div>
        <div class="form-group">
            <label for="email_contact">Email contact</label>
            <input required type="text" name="email_contact" id="user_firstname"
                   class="form-control"
                   placeholder="Your email">
        </div>
        <div class="form-group">
            <label for="card_number">Goal of becoming master</label>
            <div class="d-flex justify-content-between">
                <button type="button" class="select-button --box" value="1">Finding disciple</button>
                <button type="button" class="select-button --box" value="2">Learn how to teach</button>
                <button type="button" class="select-button --box" value="3">Business + Master</button>
                <button type="button" class="select-button --box" value="3">Voice up</button>
                <input name="goal" type="hidden">
            </div>
        </div>
        <div class="form-group">
            <label for="card_number">Your profile</label>
            <div class="d-flex">
                <input title="Upload" type="file" name="profile_pic" id="user_firstname"
                       class="form-control form-box">
            </div>
        </div>
        <div class="form-group">
            <label for="card_number">Upload theme pic</label>
            <div class="d-flex">
                <input title="Upload" type="file" name="theme_pic_1" id="user_firstname"
                       class="form-control form-box"
                       placeholder="card number">
                <input title="Upload" type="file" name="theme_pic_2" id="user_firstname"
                       class="form-control form-box"
                       placeholder="card number">
                <input title="Upload" type="file" name="theme_pic_3" id="user_firstname"
                       class="form-control form-box"
                       placeholder="card number">
            </div>
        </div>
        <div class="modal-action justify-content-end">
            <button class="primary-button --outline" onclick="activeTab('become1Tab')">Back
            </button>
            <button class="primary-button" type="submit">
                Send request
            </button>
        </div>
     </form>
</div>
</div>
`

      var modal = function (name, options) {
        $('#modal').modal('show')
        $('#modal .modal-header').removeClass('d-none')

        if (name === 'login') {
          $('#modal .modal-body').html(loginModal)
        } else if (name === 'register') {
          $('#modal .modal-body').html(registerModal)
          dropdownInit()
          replaceSvg()
        } else if (name === 'join') {

          $('#modal .modal-body').html(paymentModal(options['data']))
          $('#modal .modal-header').addClass('d-none')
          if (options['payment'] === 'success') {
            activeTab('paymentSuccessTab')
            replaceSvg()
          } else {
            activeTab('confirmTab')
          }
          var script = $('#omise').html()
          $('#omiseForm').append(script)
        } else if (name === 'all') {
          $('#modal .modal-dialog').css('max-width', '800px')
          $('#modal .modal-header').addClass('d-none')
          $('#modal .modal-body').html(allActivityModal)
          getAllActivity()
        } else if (name === 'follow') {
          $('#modal .modal-dialog').css('max-width', '900px')
          $('#modal .modal-header').addClass('d-none')
          $('#modal .modal-body').html(followModal)
          getFollowMaster()
          categoryInit()
        } else if (name === 'become') {
          $('#modal .modal-dialog').css('max-width', '450px')
          $('#modal .modal-body').html(becomeModal)
          activeTab('become1Tab')
          selectButton()
        }
      }

      var closeModal = function () {
        $('#modal').modal('hide')
      }

      selectButton()
    </script>
    <script>
      var goTo = function (name) {
        $('html, body').animate({
          scrollTop: $('#' + name).offset().top,
        }, 500)
      }
    </script>
    @yield('script')
</body>
</html>
