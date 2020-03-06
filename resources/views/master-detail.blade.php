@php
    $categories = \App\Category::get();
@endphp
@extends('app')

@section('title', 'Activities')
@section('page', 'master')

@section('style')
    <link rel="stylesheet" href="/css/master-detail.css">
    <style>
        #map {
            margin-top: 20px;
            height: 500px !important;
        }
    </style>
@endsection

@section('content')
    <section class="master-detail-section"
             style="background-image: url({{ $master['master_background'] }})">
        <div class="overlay"></div>
        <div class="master-container">
            <h1 class="header">Master Profile</h1>
            <div class="master-profile-card-wrapper">
                <div class="image-container">
                    <div class="image-wrapper">
                        <img id="image-profile" src="{{ $master['user_pic'] }}" alt="">
                        @if($me)
                            <div class="edit-wrapper" tabindex="-1">
                                <div class="edit-pic">
                                    <img class="icon" src="/img/icon/edit.png">
                                </div>
                                <input type="file" accept="image/*" id="profile-img">
                                <div class="edit-dropdown">
                                    <div class="edit-menu edit">Change profile
                                        picture
                                    </div>
                                    <div class="edit-menu" onclick="deleteProfile()">Delete profile
                                        picture
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="master-profile-card">
                    <div class="master-info" align="center">
                        <div class="title">{{ $master['master_name'] }}</div>
                        <div class="badge">{{ $master['category_name'] }} Master</div>
                        <div class="master-badge">
                            @if($master['master_most_recommend'] !== 0)
                                <div class="badge {{ $master['master_most_recommend'] === 1 ? '--basic' : '--advance' }}">
                                    Most {{ $master['master_most_recommend'] === 1 ? 'basic' : 'advance' }}
                                    recommended
                                </div>
                            @endif
                            @if($master['master_recommend'] !== 0)
                                <div class="badge {{ $master['master_recommend'] === 1 ? '--basic' : '--advance' }}"
                                     style="margin-top: 5px">
                                    {{ $master['master_recommend'] === 1 ? 'basic' : 'advance' }}
                                    recommended
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="activity-story d-sm-flex d-none" style="margin-top:0;">
                        @if($stories->isEmpty())
                            @if($me)
                                <div class="no-story">
                                    <img src="/img/icon/camera-solid.svg" class="svg">
                                    <p class="title">Share your first journey. Click!</p>
                                    <br>
                                </div>
                            @else
                                <div class="no-story-now">No story now.</div>
                            @endif
                        @endif
                        @foreach ($stories as $story)
                            @php
                                $story['users_activity'] = \App\UserActivity::join('users', 'user_activities.user_id', 'users.user_id')->where('activity_id', $story['activity_id'])->where('user_activity_paid', 1)->get();
                            @endphp
                            <div class="activity-wrapper">
                                <div class="activity-card">
                                    <div class="video-wrapper">
                                        <video class="video lazy" loop muted playsinline>
                                            <source data-src="{{ $story['activity_story_video'] }}"
                                                    type="video/mp4" />
                                        </video>
                                    </div>

                                    <div class="title-wrapper">
                                        <div class="title">{{ $story['activity_name'] }}</div>
                                        <div class="activity-join">
                                            @foreach($story['users_activity'] as $usersStory)
                                                <div class="participant image-wrapper">
                                                    <img src="{{ $usersStory['user_pic'] }}"
                                                         alt="{{ $usersStory['user_name'] }}"
                                                         onclick="window.location.href = '/user/{{ $usersStory['user_id'] }}'">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="master-action d-sm-block d-none">
                        <div class="actions">
                            <div class="action-wrapper">
                                <button class="join-button">Join<br>Activity</button>
                                <span>1 Activity available</span>
                            </div>
                            @if(!$me)
                                @if(!$isFollower)
                                    <form action="{{ url()->current() }}"
                                          method="post">
                                        @csrf
                                    </form>
                                @endif
                                <div class="follow-wrapper"
                                     onclick="$(this).prev().submit()">
                                    <div class="follow-icon {{ $isFollower ? 'followed' : '' }}">
                                        <img src="/img/icon/footstep.svg" alt="Follow ..."
                                             class="svg">
                                    </div>
                                    <div class="text"> {{ $isFollower ? 'Followed' : 'Follow' }}</div>
                                </div>

                            @endif

                        </div>
                        <div class="core-actions" style="margin-top: 70px">
                            <button class="request-button">Request<br>custom activity</button>
                        </div>
                    </div>
                </div>
                <div class="master-action-mobile d-block d-sm-none">
                    <div class="action --join">Join<br />Activity</div>
                    <div class="action --follow">Follow</div>
                    <div class="action --custom">Custom<br />Activity</div>
                </div>
            </div>
            <div class="master-stat-wrapper row">
                <div class="master-stat col-sm-2">
                    <div class="header">
                        Disciples
                    </div>
                    <div class="detail">{{ number_format($master['master_disciple']) }}</div>
                </div>
                <div class="master-stat col-sm-2">
                    <div class="header">
                        Followers
                    </div>
                    <div class="detail --start">
                        {{ number_format($master['master_follower']) }}
                    </div>
                </div>
                <div class="master-stat col-sm-2">
                    <div class="header">
                        Mastered
                    </div>
                    <div class="detail">{{ number_format($master['master_mastered']) }}</div>
                </div>
            </div>
            <div class="nav-tab nav nav-pill justify-content-sm-center justify-content-start flex-nowrap d-none d-sm-flex"
                 align="center">
                <a order="1" class="tab-link col-sm-auto col-4 active" href="#activity" role="tab"
                   data-toggle="tab">Master
                    Activities</a>
                <a order="2" class="tab-link col-sm-auto col-4" href="#gallery" role="tab"
                   data-toggle="tab">Gallery</a>

                @if($master['studio_id'] || $master['master_location'])
                    <a order="3" class="tab-link col-sm-auto col-4" href="#studio" role="tab"
                       data-toggle="tab">{{ $master['studio_id'] ? 'Studio' : 'Location' }}</a>
                @endif

                <a order="{{ $master['studio_id'] || $master['master_location'] ? '4' : '3' }}"
                   class="tab-link col-sm-auto col-4" href="#suggest" role="tab" data-toggle="tab">Master
                    Suggestion</a>
            </div>

            <div class="nav-tab-mobile nav-tab nav nav-pill justify-content-sm-center justify-content-start flex-nowrap d-flex d-sm-none"
                 align="center">
                <a order="1" class="tab-link col-sm-auto col-4 active" href="#activity" role="tab"
                   data-toggle="tab">Master
                    Activities</a>
                <a order="2" class="tab-link col-sm-auto col-4" href="#gallery" role="tab"
                   data-toggle="tab">Gallery</a>

                @if($master['studio_id'] || $master['master_location'])
                    <a order="3" class="tab-link col-sm-auto col-4" href="#studio" role="tab"
                       data-toggle="tab">{{ $master['studio_id'] ? 'Studio' : 'Location' }}</a>
                @endif

                <a order="{{ $master['studio_id'] || $master['master_location'] ? '4' : '3' }}"
                   class="tab-link col-sm-auto col-4" href="#suggest" role="tab" data-toggle="tab">Master
                    Suggestion</a>
            </div>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active show" id="activity">
                    <div class="activity-wrapper">
                        <div class="now-activity">
                            <div class="header">Now Activities</div>
                            <div class="content">
                                @if($nowActivities->isEmpty())
                                    <div class="no-act">No activity now.</div>
                                @endif
                                <div class="activity-wrapper activity-grid">
                                    @include('components.activity-grid-card', ['size' => 80, 'nohover' => '55', 'activities'=>$nowActivities])
                                </div>
                            </div>

                        </div>
                        <div class="past-activity">
                            <div class="header">Past Activitie</div>
                            <div class="content">
                                @if($pastActivities->isEmpty())
                                    <div class="no-act">No activity now.</div>
                                @endif
                                <div class="activity-wrapper activity-grid">
                                    @include('components.activity-grid-card', ['size' => 80, 'nohover' => '55', 'activities'=>$pastActivities])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="gallery">
                    <div class="gallery-wrapper">
                        @include('components.gallery', ['galleries' => $master['master_activity_pic']])

                    </div>
                    @if($me)
                        <div class="add-button">
                            <img src="/img/icon/plus-solid.svg" class="svg">
                            <input type="file" accept="image/*" class="add-file">
                        </div>
                    @endif
                </div>
                @if($master['studio_id'] || $master['master_location'])
                    <div role="tabpanel" class="tab-pane fade" id="studio">
                        @if($master['studio_id'])
                            @include('components.map', ['active' => true, 'studios' => [$master], 'show' => true])
                        @else
                            <iframe class="location-iframe" src="{{ $master['master_location'] }}"
                                    frameborder="0"></iframe>
                        @endif
                    </div>
                @endif
                <div role="tabpanel" class="tab-pane fade" id="suggest">
                    <div class="d-flex flex-wrap">
                        @include('components.activity-grid-card', ['size' => 80, 'nohover' => '55', 'activities'=>$nowActivities])
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if($me)
        <div class="record-video">
            <div class="activity-select" style="margin-bottom: 10px">
                <select class="form-control" name="activity-story" id="activity-story">
                    <option>Select activity you want to share story.</option>
                    @foreach($nowActivities as $myActivity)
                        <option value="{{ $myActivity['activity_id'] }}">{{ $myActivity['activity_name'] }}</option>
                    @endforeach
                    @foreach($pastActivities as $myActivity)
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
    @if($me)
        <script src="https://www.WebRTC-Experiment.com/RecordRTC.js"></script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@12.0.0/dist/lazyload.min.js"></script>
    <script>
      $(document).ready(function () {
        var lazyLoadInstance = new LazyLoad({
          elements_selector: '.lazy',
          // ... more custom settings?
        })

          @if($me)
          $('.no-story').click(function () {

            var countup

            $('.record-video').addClass('d-flex')

            $('.record-video').off('click').on('click', function (event) {
              if ($(event.target).hasClass('record-video')) {
                $(this).toggleClass('d-flex')
                mediaStream.stop()
              }
            })

            navigator.getUserMedia = (navigator.getUserMedia ||
              navigator.webkitGetUserMedia ||
              navigator.mozGetUserMedia ||
              navigator.msGetUserMedia
            )

            navigator.getUserMedia({
                video: true,
                audio: true,
              },
              function (stream) {
                var recorder = RecordRTC(stream, {
                  type: 'video',
                })
                mediaStream = stream
                var video = $('.video-preview > video')[0]
                video.srcObject = stream

                $('.record-btn').off('click').on('click', function () {
                    console.log('record')
                    if (!MasterStudio.videoPreview.play) {
                      recorder.startRecording()
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
                          var formData = new FormData()
                          formData.append('video-blob', fileObject)
                          formData.append('_token', $('meta[name="csrf-token"]').attr('content'))

                          $.ajax({
                            url: '/activity/' + $('#activity-story').val() + '/story',
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
              },
              function (error) {
                $('.cantaccess').addClass('d-block')
              },
            )
          })
          @endif

          $('.master-profile').hover(function () {
            $(this).children('.activity-detail').fadeIn()
          }, function () {
            $(this).children('.activity-detail').fadeOut()
          })

        var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream
        if (!iOS) {
          $('.activity-wrapper .video').hover(function () {
            $(this).get(0).play()
          }, function () {
            $(this).get(0).pause()
          })
        } else {
          $('.activity-wrapper .video').on('touchend', function () {
            $(this).get(0).play()
          })
        }

        if (!iOS) {
          $('.activity-overlay').hover(function () {
            $(this).siblings('.video-wrapper').children('.video').get(0).play()
          }, function () {
            $(this).siblings('.video-wrapper').children('.video').get(0).pause()
          })
        } else {
          $('.activity-overlay').on('touchend', function () {
            $(this).siblings('.video-wrapper').children('.video').get(0).play()
          })
        }

        $('#profile-img').change(function () {
          changeProfile()
        })

        var curTrans = 33.33

        $('.nav-tab-mobile > .tab-link').click(function () {
          var curOrder = parseInt($('.nav-tab-mobile >.tab-link.active').attr('order'))
          var targetOrder = parseInt($(this).attr('order'))
          var result = targetOrder - curOrder
          var trans = curTrans - 33.33 * result
          curTrans = trans
          $(this).parent().css('transform', 'translateX(' + trans + '%)')
        })

        $('.add-file').change(addPicGallery)
      })

      function changeProfile() {
        var formData = new FormData()
        formData.append('image', $('#profile-img')[0].files[0])

        $.ajax({
          url: '/user/{{ Auth::id() }}/profile/change',
          type: 'post',
          headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
          },
          data: formData,
          contentType: false,
          processData: false,
          success: function (res) {
            $('#image-profile').attr('src', res['image_url'])
          },
        })
      }

      function deleteProfile() {
        $.ajax({
          url: '/user/' + {{ Auth::id() }} +'/profile/delete',
          type: 'post',
          dataType: 'json',
          processData: false,
          contentType: 'application/json',
          data: JSON.stringify({
            '_token': $('meta[name="csrf-token"]').attr('content'),
          }),
          success: function (res) {
            $('#image-profile').attr('src', res['image_url'])
          },
        })
      }

      function deletePicGallery(id) {
        $.ajax({
          url: '/master/{{ $user['user_id'] }}/gallery/' + id,
          type: 'delete',
          processData: false,
          contentType: 'application/json',
          headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
          },
          success: function (data) {
            $('.gallery-wrapper').html(data)
          },
          error: function (res) {
            console.log('>> res: ', res)
          },
        })
      }

      function addPicGallery() {
        var formData = new FormData()
        formData.append('image', $('.add-file')[0].files[0])

        $.ajax({
          url: '/master/{{ $user['user_id'] }}/gallery',
          type: 'post',
          headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
          },
          data: formData,
          contentType: false,
          processData: false,
          success: function (data) {
            $('.gallery-wrapper').html(data)
          },
        })
      }
    </script>
@endsection
