@extends('app')

@section('title', 'Activities')
@section('page', 'activity')

@section('style')
    <link rel="stylesheet" href="/css/activity.css">
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
                               autoplay loop muted playsinline>
                                <source src="{{ $headActivity['category_video'] }}#t=2"
                                        type="video/mp4" />
                            </video>

                        <!-- Content Header -->
                        <div class="content-wrapper" style="z-index: 10;">
                            <!-- Activity Name , Search -->
                            <div class="activity-name">

                                <img class="logo-home" src="/img/logo/logo-home.png"
                                     alt="@Master Studio">

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
                            </div>
                        </div>
                        <!-- End Content Header -->
                    </div>
                @endforeach
            </div>
            <!-- End Slideshow -->
        </div>
        <!-- End Carousel -->
        <div class="search-group" tabindex="-1" style="max-width: 500px; width: 80%">
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
        @if(!empty($user) && !$myActivities->isEmpty())
            <div class="activity-timeline">
                <div class="nav-tab nav tabs-button flex-nowrap">
                    <a class="tab-link primary-button --outline active" data-toggle="tab"
                       href="#story" role="tab">
                        Story
                    </a>
                    <a id="lesson-button" class="tab-link primary-button --outline"
                       data-toggle="tab"
                       href="#lesson" role="tab">
                        Lesson
                    </a>
                </div>
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
                        <span class="level">LV. <span
                                    id="category-level">{{ $userCategories[0]['user_level'] }}</span></span>
                        <div class="progress">
                            <div id="category-exp" class="progress-bar" role="progressbar"
                                 style="width: {{ $userCategories[0]['user_exp']/$userCategories[0]['user_exp_max']*100 }}%"
                                 aria-valuenow="{{ $userCategories[0]['user_exp']/$userCategories[0]['user_exp_max']*100 }}"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <span class="timespend-badge">Time spend</span>
                        <span class="timespend"><span
                                    id="category-hour">{{ $userCategories[0]['user_hour'] }}</span> hours</span>
                        @if(!$userCategories->isEmpty())
                            <span id="category-badge"
                                  class="category">{{ $userCategories[0]['category_name'] }}</span>
                        @endif
                    </div>
                </div>
                {{--                <div class="activity-timeline-expand">--}}
                {{--                    <div class="text">activity timeline <img src="/img/icon/caret-down-solid.svg"--}}
                {{--                                                             class="svg"></div>--}}
                {{--                </div>--}}

                <div class="tab-content"
                     style="overflow-x: scroll; padding: 100px 20px 30px 20px; flex: 1">
                    <div role="tabpanel" class="tab-pane h-100 fade in active show"
                         id="story">
                        <div class="d-flex h-100">
                            <div class="activity-story h-100" style="padding: 0;">
                                @if($stories->isEmpty())
                                    <div class="no-story">
                                        <img src="/img/icon/camera-solid.svg" class="svg">
                                        <p class="title">Share your first journey. Click!</p>
                                        <br>
                                    </div>
                                @else
                                    @include('components.activity-story')
                                @endif

                            </div>

                            @if(!$stories->isEmpty())
                                <div class="add-activity-story">
                                    <div class="add-button">
                                        <img src="/img/icon/plus-solid.svg" class="svg">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane h-100 fade in" id="lesson">
                    </div>
                </div>
            </div>
        @endif
        <section id="activity" class="all-activity"
                 style="margin-top: 70px; background-image: url('{{ !$userCategories->isEmpty() ? $userCategories[0]->category_bg : $categories[0]->category_bg }}')">
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

    @if(!$myActivities->isEmpty())
        <div class="record-video">
            <div class="activity-select" style="margin-bottom: 10px">
                <select class="form-control" name="activity-story" id="activity-story">
                    <option value="0">Select activity you want to share story.</option>
                    @foreach($myActivities as $myActivity)
                        <option value="{{ $myActivity['activity_id'] }}">{{ $myActivity['activity_name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="video-preview">
                <video class="video" autoplay playsinline></video>
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
    @endif
@endsection

@section('script')
    <script src="/js/infinite-scroll.pkgd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@12.0.0/dist/lazyload.min.js"></script>
    <script src="https://cdn.temasys.io/adapterjs/0.15.x/adapter.min.js"></script>
    <script src="https://www.WebRTC-Experiment.com/RecordRTC.js"></script>
    <script src="/js/activity.js"></script>
    <script src="/js/activity-page.js"></script>
    <script type="text/javascript" src="https://cdn.omise.co/omise.js">
    </script>

    <script>
      var categoryHtml = `
      @foreach($userCategories as $category)
        <div onclick="getActivityCategory({{ $category['category_id'] }})"
                     class="search-result">
                <img class="svg" src="{{ $category['category_pic'] }}">
                <span class="category">{{ $category['category_name'] }}</span>
                <span class="nomaster">{{ $category['master_count'] }} master</span>
            </div>
            @endforeach
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

      function recordVideo(type) {
        return function () {
          var countup

          $('.record-video').addClass('d-flex')

          $('.record-video').off('click').on('click', function (event) {
            if ($(event.target).hasClass('record-video')) {
              $('#upload-btn').prop('disabled', false)
              $('#upload-btn').text('Upload')
              $(this).toggleClass('d-flex')
              mediaStream.stop()
            }
          })

          navigator.getUserMedia = (navigator.getUserMedia ||
            navigator.webkitGetUserMedia ||
            navigator.mozGetUserMedia ||
            navigator.msGetUserMedia
          )

          navigator.mediaDevices.getUserMedia({
            video: true,
              audio: true,
          }).then(
            function (stream) {
              var recorder = RecordRTC(stream, {
                type: 'video',
              })
              mediaStream = stream
              var video = $('.video-preview > video')[0]
              video.srcObject = stream
              alert('555')
              $('.record-btn').off('click').on('click', function () {
                  console.log('record')
                alert(MasterStudio.videoPreview.play)
                  if (!MasterStudio.videoPreview.play) {
                    recorder.startRecording()
                    $(this).prop('disabled', false)
                    $(this).text('Upload')
                    $('#upload-btn').addClass('d-none')
                    $(this).text('Stop recording...')

                    var sec = 0
                    $('.time-record > .time').text('0:00')
                    countup = setInterval(function () {
                      var countText = calculateTimeDuration(++sec)
                      $('.time-record > .time').text(countText)
                    }, 1000)
                  } else {
                    recorder.stopRecording(function () {
                      let blob = recorder.getBlob()
                      // we need to upload "File" --- not "Blob"
                      var fileObject = new File([blob], 'video', {
                        type: 'video/mp4',
                      })

                      var URL = window.URL || window.webkitURL
                      var src = URL.createObjectURL(fileObject)

                      var video = $('.video-preview > video')[0]
                      video.src = src

                      $('#upload-btn').removeClass('d-none')

                      $('#upload-btn').off('click').on('click', function () {
                        if ($('#activity-story').val() == '0') {
                          alert('Please select activity')
                          return false
                        }
                        $(this).prop('disabled', true)
                        $(this).text('Uploading...')
                        var formData = new FormData()
                        formData.append('video-blob', fileObject)
                        formData.append('_token', $('meta[name="csrf-token"]').attr('content'))
                        console.log('>> type: ', type)
                        $.ajax({
                          url: '/activity/' + $('#activity-story').val() + '/story' + (type
                                                                                       ? '?type=' + type
                                                                                       : ''),
                          type: 'post',
                          headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
                          },
                          data: formData,
                          contentType: false,
                          processData: false,
                          success: function (res) {
                            window.location.reload()
                          },
                        })
                      })

                    })
                    $(this).text('Start recording')
                    clearInterval(countup)
                  }
                  $(this).toggleClass('recording')
                  MasterStudio.videoPreview.play = !MasterStudio.videoPreview.play
                },
              )
            }
          ).catch(function (error) {
            $('.cantaccess').addClass('d-block')
          })
        }

      }
    </script>

    <script>
      $(document).ready(function () {
        $('.search-dropdown').delegate('.search-result', 'click', function () {
          $(this).parent().parent().blur()
        })

        $('.search-dropdown.--activity, .search-dropdown.--header').html(categoryHtml)
        replaceSvg()

        var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream
        if (!iOS) {
          $('#story .video').hover(function () {
            $(this).get(0).play()
          }, function () {
            $(this).get(0).pause()
          })
        } else {
          $('#story .video').on('touchend', function () {
            $(this).get(0).play()
          })
        }

          @if(!$iOS)
          $('#carousel').on('slide.bs.carousel', function () {
            $('.carousel-item.active > .video').get(0).pause()
          })
        $('#carousel').on('slid.bs.carousel', function () {
          $('.carousel-item.active > .video').get(0).play()
        })
          @else
          $('.overlay.--header').click(function () {
            $('.carousel-item.active > .video').get(0).play()
          })
          @endif

                  @if($user)


          if ($('#lesson').html().trim() == '') {
            $.ajax({
              url: '/content/timeline/[]/{{ $user['user_id'] }}?show=timeline',
              type: 'get',
              processData: false,
              contentType: 'application/json',
              data: JSON.stringify({
                '_token': $('meta[name="csrf-token"]').attr('content'),
              }),
              success: function (data) {
                $('#lesson').html(data)
                var lazyLoadInstance = new LazyLoad({
                  elements_selector: '.lazy',
                  // ... more custom settings?
                })
                var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream
                if (!iOS) {
                  $('.activity-story-lesson .video').hover(function () {
                    $(this).get(0).play()
                  }, function () {
                    $(this).get(0).pause()
                  })
                } else {
                  $('.activity-story-lesson .video').on('touchend', function () {
                    $(this).get(0).play()
                  })
                }
              },
            })
          }

        $('#story').delegate('.no-story', 'click', recordVideo())

        $('#story').delegate('.add-button', 'click', recordVideo())

        $('#lesson').delegate('.add-button', 'click', recordVideo('lesson'))

          @endif

      })
    </script>

    <script>
      MasterStudio.myCategory = {
      @foreach($userCategories as $category)
      {{$category['category_id']}} : @json($category),
      @endforeach
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
            activityHover()
          },
          error: function (error) {
            console.log(error)
          },
        })
      }

      var interestSelected = function () {
        var selectedCategory = MasterStudio.categorySelected.length !== 0
                               ? MasterStudio.categorySelected[0]
                               : Object.keys(MasterStudio.myCategory)[0]
        var lastCategory = MasterStudio.categorySelected.length !== 0
                           ? MasterStudio.categorySelected[MasterStudio.categorySelected.length - 1]
                           : Object.keys(MasterStudio.myCategory)[0]
        console.log('>> MasterStudio.myCategory[lastCategory]: ', MasterStudio.myCategory[lastCategory])
        var userHour = 'user_hour' in MasterStudio.myCategory[lastCategory]
                       ? MasterStudio.myCategory[lastCategory]['user_hour']
                       : 0
        var userLevel = 'user_level' in MasterStudio.myCategory[lastCategory]
                        ? MasterStudio.myCategory[lastCategory]['user_level']
                        : 1
        var userExp = 'user_exp' in MasterStudio.myCategory[lastCategory]
                      ? MasterStudio.myCategory[lastCategory]['user_exp'] / MasterStudio.myCategory[lastCategory]['user_exp_max'] * 100
                      : 0
        $('#category-badge').text(MasterStudio.myCategory[lastCategory]['category_name'])
        $('#category-hour').text(userHour)
        $('#category-level').text(userLevel)
        $('#category-exp').css('width', userExp + '%')
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
            activityHover()
          },
          error: function (error) {
            console.log(error)
          },
        })

                  @if($user)

        var selected = MasterStudio.categorySelected.length !== 0
                       ? MasterStudio.categorySelected.toString()
                       : ''
        $.ajax({
          url: '/content/timeline/[' + selected + ']/{{ $user['user_id'] }}?show=timeline',
          type: 'get',
          processData: false,
          contentType: 'application/json',
          data: JSON.stringify({
            '_token': $('meta[name="csrf-token"]').attr('content'),
          }),
          success: function (data) {
            $('#lesson').html(data)
            var lazyLoadInstance = new LazyLoad({
              elements_selector: '.lazy',
              // ... more custom settings?
            })
            var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream
            if (!iOS) {
              $('.activity-story-lesson .video').hover(function () {
                $(this).get(0).play()
              }, function () {
                $(this).get(0).pause()
              })
            } else {
              $('.activity-story-lesson .video').on('touchend', function () {
                $(this).get(0).play()
              })
            }
          },
        })

        if (selected == '') {
          selected = 'all'
        }

        $.ajax({
          url: '/content/story/[' + selected + ']/{{ $user['user_id'] }}',
          type: 'get',
          processData: false,
          contentType: 'application/json',
          data: JSON.stringify({
            '_token': $('meta[name="csrf-token"]').attr('content'),
          }),
          success: function (data) {
            $('#story').html(data)
            var lazyLoadInstance = new LazyLoad({
              elements_selector: '.lazy',
              // ... more custom settings?
            })
            var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream
            if (!iOS) {
              $('#story .video').hover(function () {
                $(this).get(0).play()
              }, function () {
                $(this).get(0).pause()
              })
            } else {
              $('#story .video').on('touchend', function () {
                $(this).get(0).play()
              })
            }
            replaceSvg()
          },
        })

          @endif

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
                searchHtml = '<div class="search-result">No activity.</div>'
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
              activityHover()
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

