@php
    $categories = \App\Category::get();
    $user['user_gallery'] = json_decode($user['user_gallery'], true);
    $user['user_gallery'] = array_reverse($user['user_gallery']);
@endphp
@extends('app')

@section('title', 'User - ' . $user['user_name'])
@section('page', 'home')

@section('style')
    <link rel="stylesheet" href="/css/profile.css?v=1.0">
@endsection

@section('content')
    <div class="profile-wrapper">
        <div class="profile-container">
            <div class="profile-card-wrapper">
                <div class="profile-image">
                    <img id="image-profile" class="image" src="{{ $user['user_pic'] }}" alt="">
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
                <div class="profile-detail">
                    <h1 class="name">{{ $user['user_name'] }}</h1>
                    <span>User level : {{ $user['user_level'] }}</span>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar"
                             style="width: {{ $user['user_exp']/$user['user_exp_max'] * 100 }}%"
                             aria-valuenow="{{ $user['user_exp']/$user['user_exp_max'] * 100 }}"
                             aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    {{--                    <span>Active on</span>--}}
                </div>
                <div class="profile-detail-badge {{ $me ? 'align-self-center' : '' }}">
                    <div class="profile-action">
                        {{--                        <div class="follow-icon">--}}
                        {{--                            <img src="/img/icon/caret-down-solid.svg" alt="Follow ..." class="svg">--}}
                        {{--                        </div>--}}
                        @if(!$me)
                            @if(!$isFollower)
                                <form action="{{ url()->current() }}" method="post">
                                    @endif
                                    @csrf
                                    <button class="follow-btn {{ $isFollower ? 'followed' : '' }}">{{ $isFollower ? 'Followed' : '+ Follow' }}</button>
                                </form>
                            @endif
                    </div>
                    <div class="master-stat-wrapper">
                        <div class="master-stat">
                            <div class="header">
                                Followers
                            </div>
                            <div class="detail">{{ $followers - 1 }}</div>
                        </div>
                        <div class="master-stat">
                            <div class="header">
                                Masters
                            </div>
                            <div class="detail">{{ count($masters) }}</div>
                        </div>
                        <div class="master-stat">
                            <div class="header">
                                Activities
                            </div>
                            <div class="detail">{{ count($nowActivities) + count($pastActivities) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @if($isFollower)
                <div class="profile-card-wrapper --timeline">
                    <div class="header-tab">
                        @include('components.category-interest', ['active' => true, 'me' => $me ? 1 : 2])
                        <div class="achievement-tab d-none">
                            <div class="achievement">Achievement</div>
                            <div id="achievement" class="d-flex flex-grow-1"></div>
                        </div>
                    </div>
                    <div id="category-timeline" class="category-timeline-wrapper"></div>
                </div>
            @endif
            <div class="nav-tab nav nav-pill justify-content-sm-center justify-content-start flex-nowrap d-none d-sm-flex"
                 align="center">
                <a class="tab-link active" href="#activity" role="tab"
                   data-toggle="tab">{{ $me ? 'Your' : 'User' }}
                    Activities</a>
                <a class="tab-link" href="#gallery" role="tab" data-toggle="tab">Gallery</a>
                <a class="tab-link" href="#studio" role="tab" data-toggle="tab">Visited</a>
                <a class="tab-link" href="#suggest" role="tab" data-toggle="tab">Followed
                    master</a>
            </div>
            <div class="nav-tab-mobile nav-tab nav nav-pill justify-content-sm-center justify-content-start flex-nowrap d-flex d-sm-none"
                 align="center">
                <a order="1" class="tab-link col-sm-auto col-4 active" href="#activity"
                   role="tab"
                   data-toggle="tab">{{ $me ? 'Your' : 'User' }}
                    Activities</a>
                <a order="2" class="tab-link col-sm-auto col-4" href="#gallery" role="tab"
                   data-toggle="tab">Gallery</a>
                <a order="3" class="tab-link col-sm-auto col-4" href="#studio" role="tab"
                   data-toggle="tab">Visited</a>
                <a order="4"
                   class="tab-link col-sm-auto col-4" href="#suggest" role="tab"
                   data-toggle="tab">Followed master</a>
            </div>
            <div class="profile-card-wrapper" style="display: block">
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
                    <div role="tabpanel" class="tab-pane fade in" id="gallery">
                        <div class="gallery-wrapper">
                            @include('components.gallery', ['galleries' => $user['user_gallery']])
                        </div>
                        @if($me)
                            <div class="add-button">
                                <img src="/img/icon/plus-solid.svg" class="svg">
                                <input type="file" accept="image/*" class="add-file">
                            </div>
                        @endif

                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="studio">
                        <div align="center">No visited studio now.</div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="suggest">
                        @if($masters->isEmpty())
                            <div class="no-follow-master" align="center">
                                No followed master now.
                            </div>
                        @else
                            <div class="follow-wrapper"
                                 style="margin-top: 20px">

                                @foreach($masters as $master)
                                    <div class="followed-master col-sm-6 col-md-3 col-12"
                                         onclick="window.location.href='/master/{{ $master['master_id'] }}'">
                                        <div class="image-wrapper">
                                            <img src="{{ $master['user_pic'] }}" alt="">
                                        </div>
                                        <div class="name">{{ $master['master_name'] }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@12.0.0/dist/lazyload.min.js"></script>
    <script>

      $(document).ready(function () {
        var lazyLoadInstance = new LazyLoad({
          elements_selector: '.lazy',
          // ... more custom settings?
        })

        $('.category-timeline-wrapper').delegate('.close-btn', 'click', function () {
          $(this).parent().submit()
        })

        $('.activity-overlay').hover(function () {
            $(this).siblings('.video-wrapper').children('.video').get(0).play()
          }, function () {
            $(this).siblings('.video-wrapper').children('.video').get(0).pause()
          })

          @if($isFollower)
          if ($('.interest-activity.active').length !== 0 || {{ $me ? 'true' : 'false' }}) {
            $.ajax({
              url: '/content/timeline/[' + $('.interest-activity.active').attr('cat-id') + ']/{{ $user['user_id'] }}',
              type: 'get',
              processData: false,
              contentType: 'application/json',
              data: JSON.stringify({
                '_token': $('meta[name="csrf-token"]').attr('content'),
              }),
              success: function (data) {
                $('#category-timeline').html(data)
                var lazyLoadInstance = new LazyLoad({
                  elements_selector: '.lazy',
                  // ... more custom settings?
                })
                $('.activity-story-lesson > .video').hover(function () {
                  $(this).get(0).play()
                }, function () {
                  $(this).get(0).pause()
                })

                $('#category-name').text($('.interest-activity.active').children('.name').text())
              },
            })

            $.ajax({
              url: '/content/achievement/' + $('.interest-activity.active').attr('cat-id') + '/{{ $user['user_id'] }}',
              type: 'get',
              processData: false,
              contentType: 'application/json',
              data: JSON.stringify({
                '_token': $('meta[name="csrf-token"]').attr('content'),
              }),
              success: function (data) {

                $('#achievement').html(data)
                $('#achievement').parent().removeClass('d-none')

              },
              error: function (error) {
                console.log(error)
                $('#achievement').html('')
                $('#achievement').parent().addClass('d-none')
              },
            })

          } else {
            $('.profile-card-wrapper.--timeline').addClass('d-none')
          }

          @endif

          $('.master-profile').hover(function () {
            $(this).children('.activity-detail').fadeIn()
          }, function () {
            $(this).children('.activity-detail').fadeOut()
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

        $('#profile-img').change(function () {
          changeProfile()
        })

          @if($me)

          $('.add-file').change(addPicGallery)

          @endif
      })

              @if($me)


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
          url: '/user/{{ $user['user_id'] }}/gallery/' + id,
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
          url: '/user/{{ $user['user_id'] }}/gallery',
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

      @endif

      @if($isFollower)

      function interestSelected(element) {
        $('.interest-activity.active').removeClass('active')

        var categorySelected = $(element).attr('cat-id')

        $(element).addClass('active')

        $.ajax({
          url: '/content/timeline/[' + categorySelected + ']/' + '{{ $user['user_id'] }}',
          type: 'get',
          processData: false,
          contentType: 'application/json',
          data: JSON.stringify({
            '_token': $('meta[name="csrf-token"]').attr('content'),
          }),
          success: function (data) {
            $('#category-timeline').html(data)
            var lazyLoadInstance = new LazyLoad({
              elements_selector: '.lazy',
              // ... more custom settings?
            })
            $('.activity-story-lesson > .video').hover(function () {
              $(this).get(0).play()
            }, function () {
              $(this).get(0).pause()
            })

            $('#category-name').text($(element).children('.name').text())
          },
        })

        $.ajax({
          url: '/content/achievement/' + categorySelected + '/' + '{{ $user['user_id'] }}',
          type: 'get',
          processData: false,
          contentType: 'application/json',
          data: JSON.stringify({
            '_token': $('meta[name="csrf-token"]').attr('content'),
          }),
          success: function (data) {
            $('#achievement').html(data)
            $('#achievement').parent().removeClass('d-none')
          },
          error: function (error) {
            console.log(error)
            $('#achievement').html('')
            $('#achievement').parent().addClass('d-none')
          },
        })
      }

        @endif


    </script>
@endsection
