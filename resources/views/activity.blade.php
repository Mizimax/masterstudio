@php
    $categories = \App\Category::from('categories as cg')->select(\DB::raw('cg.*,(SELECT COUNT(*) FROM masters AS ms WHERE ms.category_id = cg.category_id) AS master_count'))->get();
@endphp
@extends('app')

@section('title', 'Activities')
@section('page', 'activity')

@section('style')
    <link rel="stylesheet" href="/css/activity.css">
@endsection

@section('content')
    <section class="activity-header">
        <!-- Carousel -->
        <div id="carousel" class="carousel slide carousel-fade" data-ride="carousel"
             data-interval="60000">
            <!-- Indicators -->
            <ul class="carousel-indicators">
                @foreach($headActivities as $key => $headVideo)
                    <li data-target="#carousel" data-slide-to="{{ $key }}"
                        class="{{ $loop->first ? 'active' : ''}}"></li>
                @endforeach
            </ul>
            <!-- End Indicators -->

            <!-- Slideshow -->
            <div class="carousel-inner">
                @foreach($headActivities as $key => $headActivity)
                    @php
                        $headActivity['activity_benefit'] = json_decode($headActivity['activity_benefit'], true);
                        $headActivity['activity_video'] = json_decode($headActivity['activity_video'], true)[0];
			            $headActivity['activity_routine_day'] = str_split($headActivity['activity_routine_day']);
			            $start = new DateTime($headActivity->activity_start);
                        $end = new DateTime($headActivity->activity_end);
                        $headActivity['activity_time_diff'] = $start->diff($end) ;
			            $headActivity['activity_day_left'] = $headActivity['activity_time_diff']->m === 0 ? $headActivity['activity_time_diff']->d . ' days' : $headActivity['activity_time_diff']->m . ' months';
                    @endphp
                    <div class="carousel-item {{ $key === 0 ? 'active' : ''}}">
                        <video class="video video-fluid lazy"
                               style="transform: scale({{ parse_url($headActivity['category_video'], PHP_URL_QUERY) }})"
                               autoplay loop muted>
                            <source data-src="{{ $headActivity['category_video'] }}"
                                    type="video/mp4" />
                        </video>
                        <!-- Content Header -->
                        <div class="content-wrapper">
                            <!-- Activity Name , Search -->
                            <div class="activity-name">
                                <h1 class="header">@Master Studio</h1>
                                <h2 class="subheader">Meet Real <a class="chef"
                                                                   href="#">{{ $headActivity['category_name'] }}</a>
                                </h2>
                            </div>
                            <!-- End Activity Name , Search -->
                            <div class="activity-detail-wrapper">

                                <div class="activity-tabs d-none d-sm-flex">
                                    <div class="activity-tab"
                                         onclick="window.location.href= '/activity/{{ $headActivity['activity_url_name'] }}'">
                                        <div class="icon-wrapper --join">
                                        </div>
                                        <div class="text">{{ $headActivity['activity_join'] === 0 ? 'Join' : 'View'}}
                                            activity
                                        </div>
                                    </div>

                                    <div class="activity-tab --pinact {{ ($headActivity['activity_join'] === 0 && $headActivity['activity_pin'] === 0) ? '' : 'd-none' }}"
                                         onclick="pinActivity({{ $headActivity['activity_id'] }}, '{{ $headActivity["activity_name"] }}', this)">
                                        <div class="icon-wrapper --pin">
                                        </div>
                                        <div class="text">Pin activity</div>
                                    </div>
                                    <div class="activity-tab --pinact {{ ($headActivity['activity_join'] === 0 && $headActivity['activity_pin'] !== 0) ? '' : 'd-none' }}"
                                         onclick="unpinActivity({{ $headActivity['activity_id'] }}, '{{ $headActivity["activity_name"] }}', this)">
                                        <div class="icon-wrapper --unpin">
                                        </div>
                                        <div class="text">Unpin activity</div>
                                    </div>

                                    <div class="activity-tab --share" tabindex="-1">
                                        <div class="icon-wrapper --share">
                                        </div>
                                        <div class="text">Share</div>
                                        <div class="share-dropdown">
                                            <div class="icon-wrapper --dropdown --copy"
                                                 onclick="copy()" data-toggle="tooltip"
                                                 data-placement="bottom" title="Click to copy">
                                            </div>
                                            <div class="icon-wrapper --dropdown --facebook"
                                                 onclick="facebook()" data-toggle="tooltip"
                                                 data-placement="bottom" title="Facebook share">
                                            </div>
                                            <div class="icon-wrapper --dropdown --email"
                                                 onclick="email()" data-toggle="tooltip"
                                                 data-placement="bottom" title="Email share">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @include('components.activity-card', ['size'=>80, 'activity'=> $headActivity])
                            </div>
                        </div>
                        <!-- End Content Header -->
                    </div>
                @endforeach
                {{--                <div class="carousel-item">--}}
                {{--                    <video class="video video-fluid" autoplay loop muted>--}}
                {{--                        <source src="https://mdbootstrap.com/img/video/forest.mp4"--}}
                {{--                                type="video/mp4" />--}}
                {{--                    </video>--}}
                {{--                </div>--}}
                {{--                <div class="carousel-item">--}}
                {{--                    <video class="video video-fluid" autoplay loop muted>--}}
                {{--                        <source src="https://mdbootstrap.com/img/video/Agua-natural.mp4"--}}
                {{--                                type="video/mp4" />--}}
                {{--                    </video>--}}
                {{--                </div>--}}
            </div>
            <!-- End Slideshow -->
        </div>
        <!-- End Carousel -->
        <div class="search-group" tabindex="-1">
            <input class="search-box" placeholder="Search your activities..." type="text"
                   onKeyUp="handleChange(this)">
            <div class="search-dropdown --header">

            </div>
        </div>
        <div class="overlay --header"
             style="z-index: 9; background: linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0.2) 60%, rgba(0,0,0,0.8) 100%);"></div>
        <div class="half-square"></div>
    </section>

    <section class="your-activity">
        <textarea style="opacity:0; height: 0; padding: 0;" id="url"></textarea>
        <h3 class="header">Your Activity</h3>
        @include('components.category-interest')
        @if(!empty($user))
            <div class="activity-timeline">
                <div class="your-activity-timeline">
                    <div class="image-container">
                        <div class="your-image image-wrapper">
                            <img class="border-circle shadow" src="{{ $user['user_pic'] }}"
                                 width="80"
                                 height="80"
                                 title="Profile image"
                                 alt="Profile image">
                        </div>
                    </div>
                    <div class="your-info">
                        <h3 class="name">{{ $user['user_name'] }}</h3>
                        <span class="level">LV. {{ $user['user_level'] }}</span>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar"
                                 style="width: 50%" aria-valuenow="50"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <span class="timespend-badge">Time spend</span>
                        <span class="timespend">{{ $user['user_hour'] }} hours</span>
                        {{--                    <span class="category">Badminton</span>--}}
                    </div>
                </div>
                <div class="activity-timeline-expand">
                    <div class="text">activity timeline <img src="/img/icon/caret-down-solid.svg"
                                                             class="svg"></div>
                </div>
                <div class="activity-story">
                    @if($stories->isEmpty())
                        <div class="no-story">
                            <img src="/img/icon/camera-solid.svg" class="svg">
                            <p class="title">Share your first journey. Click!</p>
                            <br>
                        </div>
                    @endif
                    @foreach ($stories as $story)
						<?php
						$story['users_activity'] = \App\UserActivity::join('users', 'user_activities.user_id', 'users.user_id')->where('activity_id', $story['activity_id'])->get();
						?>
                        <div class="activity-wrapper">
                            <div class="activity-card">
                                <div class="video-wrapper">
                                    <video class="video lazy" loop muted>
                                        <source data-src="{{ $story['activity_story_video'] }}"
                                                type="video/mp4" />
                                    </video>
                                </div>

                                <div class="master-profile">
                                    <div class="image-wrapper">
                                        <img src="{{ $story['user_pic'] }}" alt="">
                                    </div>
                                </div>

                                <div class="title-wrapper">
                                    <div class="title"
                                         align="left">{{ $story['activity_name'] }}</div>
                                    <div class="activity-join">
                                        @foreach($story['users_activity'] as $userStory)
                                            <div class="participant image-wrapper">
                                                <img src="{{ $userStory['user_pic'] }}" alt="">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="location">Yesterday: JAJA Studio</div>
                        </div>
                    @endforeach
                </div>

                @if(!$stories->isEmpty())
                <div class="add-activity-story">
                    <div class="add-button">
                        <img src="/img/icon/plus-solid.svg" class="svg">
                    </div>
                </div>
                @endif
            </div>
        @endif
        <section id="activity" class="all-activity"
                 style="margin-top: 70px; background-image: url('{{ $categories[0]->category_bg }}')">
            <div class="content">
                <h3 class="header">All activities</h3>
                <div class="search-group" tabindex="-1" align="left">
                    <input class="search-box" placeholder="Search your activities..." type="text"
                           onKeyUp="activityHandleChange(this)">
                </div>
                <div id="activity-wrapper" class="activity-grid">
                    @include('components.activity-grid-card', ['activities'=>$activities, 'size'=>80])
                </div>
                <div class="loading-wrapper">
                    <div class="lds-ellipsis infinite-scroll-request">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <div class="overlay"></div>
        </section>
    </section>

    <div class="record-video">
        <div class="activity-select" style="margin-bottom: 10px">
            <select class="form-control" name="activity-story" id="activity-story">
                <option>Select activity you want to share story.</option>
                @foreach($myActivities as $myActivity)
                    <option value="{{ $myActivity['activity_id'] }}">{{ $myActivity['activity_name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="video-preview">
            <video class="video" autoplay></video>
            <div class="cantaccess">This function requires camera and microphone access.</div>
            <div class="time-record" align="center">
                <span class="time">0:00</span> / 1:00 minute
            </div>
        </div>
        <div class="d-flex">
            <button id="upload-btn" class="record-btn mr-2 d-none">Upload</button>
            <button class="record-btn">Start recording</button>
        </div>
        {{--        <div class="overlay"></div>--}}
    </div>
@endsection

@section('script')
    <script src="/js/infinite-scroll.pkgd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@12.0.0/dist/lazyload.min.js"></script>
    <script src="https://www.WebRTC-Experiment.com/RecordRTC.js"></script>
    <script src="/js/activity.js"></script>
    <script src="/js/activity-page.js"></script>
    <script type="text/javascript" src="https://cdn.omise.co/omise.js">
    </script>

    <script>
      var categoryHtml = `
            @foreach($categories as $category)
        <div onclick="getActivityCategory({{ $category['category_id'] }})"
                     class="search-result">
                <img class="svg" src="{{ $category['category_pic'] }}">
                <span class="category">{{ $category['category_name'] }}</span>
                <span class="nomaster">{{ $category['master_count'] }} master</span>
            </div>
            @endforeach
        `
      var loadingHtml = `
            <div class="activity-loading">Loading...</div>
        `
    </script>

    <script>
      $(document).ready(function () {
        $('.search-dropdown').delegate('.search-result', 'click', function () {
          $(this).parent().parent().blur()
        })

        $('.search-dropdown.--activity, .search-dropdown.--header').html(categoryHtml)
        replaceSvg()
      })
    </script>

    <script>
      MasterStudio.myCategory = {
      @foreach($categories as $category)
      {{$category['category_id']}} : @json($category),
      @endforeach
      }

    </script>

    <script>
      var loadingHtml = `
            <div class="activity-loading" align="center">Loading...</div>
        `

      var getActivityCategory = function (category_id) {
        goTo('activity')

        $('#activity').css('background-image', 'url(' + MasterStudio.myCategory[category_id]['category_bg'] + ')')

        $('#activity-wrapper').html(loadingHtml)
        $.ajax({
          url: '/content/activities?category=' + category_id,
          type: 'get',
          processData: false,
          contentType: 'application/json',
          data: JSON.stringify({
            '_token': $('meta[name="csrf-token"]').attr('content'),
          }),
          success: function (data) {
            $('#activity-wrapper').html(data)
            var lazyLoadInstance = new LazyLoad({
              elements_selector: '.lazy',
              // ... more custom settings?
            })
          },
          error: function (error) {
            console.log(error)
          },
        })
      }

      var interestSelected = function () {
        goTo('activity')

        var selectedCategory = MasterStudio.categorySelected.length !== 0
                               ? MasterStudio.categorySelected[0]
                               : 0
        if (selectedCategory === 0) {
          $('#activity').css('background-image', 'url(\'/img/default-bg.jpg\')')
        } else {
          var categoryBg = MasterStudio.myCategory[selectedCategory]['category_bg']
          $('#activity').css('background-image', 'url(' + categoryBg + ')')
        }

        $('#activity-wrapper').html(loadingHtml)
        $.ajax({
          url: '/content/activities?category=[' + MasterStudio.categorySelected.toString() + ']',
          type: 'get',
          processData: false,
          contentType: 'application/json',
          data: JSON.stringify({
            '_token': $('meta[name="csrf-token"]').attr('content'),
          }),
          success: function (data) {
            $('#activity-wrapper').html(data)
            var lazyLoadInstance = new LazyLoad({
              elements_selector: '.lazy',
              // ... more custom settings?
            })
          },
          error: function (error) {
            console.log(error)
          },
        })
      }

    </script>

    <script>
      function debounce(f, ms) {

        let timer = null

        return function (...args) {
          const onComplete = () => {
            f.apply(this, args)
            timer = null
          }

          if (timer) {
            clearTimeout(timer)
          }

          timer = setTimeout(onComplete, ms)
        }
      }

      var handleChange = function (e) {
        $(e).next().html(
          '<div class="search-result">Loading...</div>',
        )

        debounce(function () {
          const val = e.value

          if (val === '') {
            $(e).next().html(categoryHtml)
            replaceSvg()
            return
          }

          $.ajax({
            url: '/activity/search?keyword=' + val,
            type: 'get',
            processData: false,
            contentType: 'application/json',
            data: JSON.stringify({
              '_token': $('meta[name="csrf-token"]').attr('content'),
            }),
            success: function (res) {
              var result = res.data
              var searchHtml
              if (result.length != 0) {
                searchHtml = result.map(function (value, index) {
                  return `
                    <div onclick="window.location.href = '/activity/${value.activity_url_name}'" class="search-result">
                        <img class="svg" src="${value.category_pic}">
                        <span class="category">${value.activity_name}</span>
                    </div>
                `
                }).join('\n')
              } else {
                searchHtml = '<div class="search-result">No result.</div>'
              }
              $(e).next().html(searchHtml)
              replaceSvg()
            },
            error: function (error) {
              console.log(error)
            },
          })

        }, 700)()
      }

      var activityHandleChange = function (e) {
        $('#activity-wrapper').html(loadingHtml)

        debounce(function () {
          const val = e.value

          $.ajax({
            url: '/activity/search?key=' + val,
            type: 'get',
            processData: false,
            contentType: 'application/json',
            data: JSON.stringify({
              '_token': $('meta[name="csrf-token"]').attr('content'),
            }),
            success: function (data) {
              $('#activity-wrapper').html(data)
              var lazyLoadInstance = new LazyLoad({
                elements_selector: '.lazy',
                // ... more custom settings?
              })
            },
            error: function (error) {
              console.log(error)
            },
          })

        }, 700)()
      }

      var pinActivity = function (activity, name, ele) {
        $.ajax({
          url: '/activity/' + activity + '/pin',
          type: 'post',
          processData: false,
          contentType: 'application/json',
          data: JSON.stringify({
            '_token': $('meta[name="csrf-token"]').attr('content'),
          }),
          success: function (data) {
            modal('all')
            var alertHtml = `
            <div class="alert alert-success" role="alert">
              Activity ${name} was pinned !
            </div>
            `
            $('#my-activity').append(alertHtml)

            $(ele).parent().children('.--pinact').toggleClass('d-none')

          },
          error: function (err) {
            if (err.status === 401) {
              modal('login')
            } else if (err.status === 500) {
              modal('all')
              $(ele).parent().children('.--pinact').toggleClass('d-none')
            }
          },
        })
      }

      var unpinActivity = function (activity, name, ele) {
        $.ajax({
          url: '/activity/' + activity + '/unpin',
          type: 'post',
          processData: false,
          contentType: 'application/json',
          data: JSON.stringify({
            '_token': $('meta[name="csrf-token"]').attr('content'),
          }),
          success: function (data) {
            $(ele).parent().children('.--pinact').toggleClass('d-none')
          },
          error: function (err) {
            if (err.status === 401) {
              modal('login')
            }
          },
        })
      }

      var copy = function () {
        var Url = document.getElementById('url')
        Url.innerHTML = window.location.href
        Url.select()
        document.execCommand('copy')
        console.log('>> : ')
      }

      var email = function () {
        var url = window.location.href
        window.location.href = 'mailto:?subject=I wanted you to see this site&body=Check out this site ' + url
      }


    </script>
@endsection

