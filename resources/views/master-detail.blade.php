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
    <section class="master-detail-section">
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
                            <div class="no-story">No story now.</div>
                        @endif
                        @foreach ($stories as $story)
                            @php
                                $story['users_activity'] = \App\UserActivity::join('users', 'user_activities.user_id', 'users.user_id')->where('activity_id', $story['activity_id'])->get();
                            @endphp
                            <div class="activity-wrapper">
                                <div class="activity-card">
                                    <div class="video-wrapper">
                                        <video class="video lazy" loop muted>
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
                                     onclick="$('#followMaster').submit()">
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
                                <div class="activity-wrapper">
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
                                <div class="activity-wrapper">
                                    @include('components.activity-grid-card', ['size' => 80, 'nohover' => '55', 'activities'=>$pastActivities])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="gallery">
                    <div class="gallery-wrapper">
                        <div class="gallery-flex --first">
                            @php
                                $count = count($master['master_activity_pic']);
                                if(count($master['master_activity_pic']) === 1)
                                    $count = 2;
                            @endphp
                            @for($i = 0; $i < floor($count/2); $i++)
                                <div class="image-container {{ $me ? 'me' : '' }}" tabindex="-1">
                                    <img src="{{ $master['master_activity_pic'][$i] }}"
                                         class="image">
                                    @if($me)
                                        <button class="delete-btn"
                                                onclick="deletePicGallery({{ $i }}, this)"></button>
                                    @endif
                                </div>
                            @endfor
                        </div>
                            <div class="gallery-flex --second">
                                @for($i = floor(count($master['master_activity_pic'])/2); $i < count($master['master_activity_pic']); $i++)
                                    <div class="image-container {{ $me ? 'me' : '' }}"
                                         tabindex="-1">
                                        <img src="{{ $master['master_activity_pic'][$i] }}"
                                             class="image">
                                        @if($me)
                                            <button class="delete-btn"
                                                    onclick="deletePicGallery({{ $i }}, this)"></button>
                                        @endif
                                    </div>
                                @endfor
                            </div>

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
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@12.0.0/dist/lazyload.min.js"></script>
    <script>
      $(document).ready(function () {
        var lazyLoadInstance = new LazyLoad({
          elements_selector: '.lazy',
          // ... more custom settings?
        })

        $('.master-profile').hover(function () {
          $(this).children('.activity-detail').fadeIn()
        }, function () {
          $(this).children('.activity-detail').fadeOut()
        })

        $('.activity-wrapper .video').hover(function () {
          $(this).get(0).play()
        }, function () {
          $(this).get(0).pause()
        })

        $('.activity-overlay').hover(function () {
          $(this).siblings('.video-wrapper').children('.video').get(0).play()
        }, function () {
          $(this).siblings('.video-wrapper').children('.video').get(0).pause()
        })

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

      var activity_pic = @json($master['master_activity_pic'])

      function deletePicGallery(id, ele) {
        activity_pic.splice(id, 1)
        $.ajax({
          url: '/master/{{ $master['master_id'] }}/gallery',
          type: 'delete',
          dataType: 'json',
          processData: false,
          contentType: 'application/json',
          headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
          },
          data: JSON.stringify({ 'master_activity_pic': activity_pic }),
          success: function (res) {
            $(ele).parent().remove()
          },
        })
      }

      function addPicGallery() {
        var formData = new FormData()
        formData.append('image', $('.add-file')[0].files[0])
        formData.append('master_activity_pic', JSON.stringify(activity_pic))

        $.ajax({
          url: '/master/{{ $master['master_id'] }}/gallery',
          type: 'post',
          headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
          },
          data: formData,
          contentType: false,
          processData: false,
          success: function (res) {
            var dataResult = res.data
            var firstGallery = $('.gallery-flex.--first').children().length
            var secondGallery = $('.gallery-flex.--second').children().length
            activity_pic.push(dataResult['filename'])
            var galleryHtml = `
                <div class="image-container {{ $me ? 'me' : '' }}" tabindex="-1">
                                    <img src="${dataResult['filename']}"
                                         class="image">
                                    @if($me)
              <button class="delete-btn"
                      onclick="deletePicGallery(${activity_pic.length - 1}, this)"></button>
                                        @endif
              </div>
`
            if (firstGallery < secondGallery) {
              $('.gallery-flex.--first').append(galleryHtml)
            } else {
              $('.gallery-flex.--second').append(galleryHtml)
            }
          },
        })
      }
    </script>
@endsection
