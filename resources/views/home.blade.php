@php
    $categories = \App\Category::from('categories as cg')->select(\DB::raw('cg.*,(SELECT COUNT(*) FROM masters AS ms WHERE ms.category_id = cg.category_id) AS master_count'))->get();
@endphp
@extends('app')

@section('title', 'Home')
@section('page', 'home')

@section('style')
    <link rel="stylesheet" href="/css/home.css">
@endsection

@section('content')

    <section class="video-header">
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
                        <div class="content-wrapper" style="z-index: 10;">
                            <!-- Activity Name , Search -->
                            <div class="activity-name">
                                <h1 class="header">@Master Studio</h1>
                                <h2 class="subheader ml-3 ml-sm-5 pl-sm-2">Meet Real <a class="chef"
                                                                                        href="#">{{ $headActivity['category_name'] }}</a>
                                </h2>
                            </div>
                            <!-- End Activity Name , Search -->
                            <div class="activity-detail-wrapper">
                                @include('components.activity-card', ['size'=>80, 'activity'=> $headActivity])
                                <div class="activity-tabs d-none d-sm-flex">
                                    <div class="activity-tab"
                                         onclick="window.location.href= '/activity/{{ $headActivity['activity_url_name'] }}'">
                                        <div class="icon-wrapper --join">
                                        </div>
                                        <div class="text">Join activity</div>
                                    </div>

                                    <div class="activity-tab --pinact {{ $headActivity['activity_pin'] !== 0 ? 'd-none' : '' }}"
                                         onclick="pinActivity({{ $headActivity['activity_id'] }}, '{{ $headActivity["activity_name"] }}', this)">
                                        <div class="icon-wrapper --pin">
                                        </div>
                                        <div class="text">Pin activity</div>
                                    </div>
                                    <div class="activity-tab --pinact {{ $headActivity['activity_pin'] === 0 ? 'd-none' : '' }}"
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
        <div class="search-group" tabindex="-1" style="width: 450px">
            <input class="search-box" placeholder="Search your activities..." type="text"
                   onKeyUp="handleChange(this)">
            <div class="search-dropdown --header">

            </div>
        </div>
        <div class="overlay --header"
             style="z-index: 9; background: linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0.2) 60%, rgba(0,0,0,0.8) 100%);"></div>
        <div class="half-square"></div>

    </section>

    <section class="live-activity">
        <textarea style="opacity:0; height: 0; padding: 0;" id="url"></textarea>
        <h3 class="header">Live Activity</h3>
        @include('components.category-interest')
        <div class="wrapper">
            <div class="activity-story --hover">
                @foreach ($stories as $story)
                    @php
                        $story['activity_benefit'] = json_decode($story['activity_benefit'], true);
                        $story['activity_routine_day'] = str_split($story['activity_routine_day']);
                        $start = new DateTime($story->activity_start);
                        $end = new DateTime($story->activity_end);
                        $story['activity_time_diff'] = $start->diff($end) ;
                        $story['activity_day_left'] = $story['activity_time_diff']->m === 0 ? $story['activity_time_diff']->d . ' days' : $story['activity_time_diff']->m . ' months';
                        $storyCreated = new DateTime($story['story_created_at']);
                        $now = new DateTime(date("Y-m-d H:i:s"));
                        $story['story_day_ago'] = $storyCreated->diff($now);

                        $activity['users_activity'] = \App\UserActivity::join('users', 'user_activities.user_id', 'users.user_id')->where('activity_id', $story['activity_id'])->get();

                    @endphp
                    <div class="activity-wrapper">
                        <div class="activity-card">
                            <div class="video-wrapper">
                                <video class="video lazy" loop muted>
                                    <source data-src="{{ $story['activity_story_video'] }}"
                                            type="video/mp4" />
                                </video>
                            </div>

                            <div class="master-profile">
                                @component('components.activity-card', ['noimage'=>true, 'size'=>80, 'animate'=>true, 'activity' => $story])
                                @endcomponent
                                <div class="image-wrapper">
                                    <img onclick="window.location.href='/'"
                                         src="{{ $story['user_pic'] }}" alt="">
                                </div>
                            </div>

                            <div class="title-wrapper">
                                <div class="title" align="left">{{ $story['activity_name'] }}</div>
                                <div class="activity-join">
                                    @foreach($activity['users_activity'] as $usersStory)
                                        <div class="participant image-wrapper">
                                            <img src="{{ $usersStory['user_pic'] }}"
                                                 alt="{{ $usersStory['user_name'] }}"
                                                 onclick="window.location.href = '/user/{{ $usersStory['user_id'] }}'">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="location">{{ $story['story_day_ago']->d !== 0 ? $story['story_day_ago']->d . ' days ' : '' }}{{ $story['story_day_ago']->h !== 0 ? $story['story_day_ago']->h . ' hours' : '' }}
                            ago: {{ $story['activity_location_name'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
        <section id="activity" class="activity-you"
                 style="background-image: url('{{ $categories[0]->category_bg }}')">
            <div class="content">
                <h3 class="header">Activity for you</h3>
                <div class="search-group" tabindex="-1" style="max-width: 400px">
                    <input class="search-box" placeholder="Search your activities..." type="text"
                           onKeyUp="activityHandleChange(this)">
                </div>
                <div id="activity-wrapper" class="activity-grid">
                    @include('components.activity-grid-card', ['activities'=>$activities, 'size'=>80])
                </div>
            </div>
            <div class="overlay"></div>
        </section>
    </section>

@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@12.0.0/dist/lazyload.min.js"></script>
    <script src="https://css-tricks.com/examples/HorzScrolling/jquery.mousewheel.js"></script>
    <script src="/js/activity.js"></script>
    <script src="/js/home-page.js"></script>

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
        $('#carousel').on('slide.bs.carousel', function () {
          $('.carousel-item.active > .video').get(0).pause()
        })
        $('#carousel').on('slid.bs.carousel', function () {
          $('.carousel-item.active > .video').get(0).play()
        })

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
      var getActivityCategory = function (category_id) {
        goTo('activity')
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
