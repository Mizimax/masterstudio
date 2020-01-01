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
                        <img src="/img/profile.jpg" alt="">
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
                    <div class="activity-story" style="margin-top:0;">
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
                    <div class="master-action">
                        <div class="actions">
                            <div class="action-wrapper">
                                <button class="join-button">Join<br>Activity</button>
                                <span>1 Activity available</span>
                            </div>
                            @if(!$me)
                                @if(!$isFollower)
                                    <form id="followMaster" action="{{ url()->current() }}"
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
            </div>
            <div class="master-stat-wrapper">
                <div class="master-stat">
                    <div class="header">
                        Disciples
                    </div>
                    <div class="detail">{{ number_format($master['master_disciple']) }}</div>
                </div>
                <div class="master-stat">
                    <div class="header">
                        Followers
                    </div>
                    <div class="detail --start">
                        {{ number_format($master['master_follower']) }}
                    </div>
                </div>
                <div class="master-stat">
                    <div class="header">
                        Mastered
                    </div>
                    <div class="detail">{{ number_format($master['master_mastered']) }}</div>
                </div>
            </div>
            <div class="nav-tab nav nav-pill">
                <a class="tab-link active" href="#activity" role="tab" data-toggle="tab">Master
                    Activities</a>
                <a class="tab-link" href="#gallery" role="tab" data-toggle="tab">Gallery</a>
                @if($master['studio_id'])
                    <a class="tab-link" href="#studio" role="tab" data-toggle="tab">Studio</a>
                @endif
                <a class="tab-link" href="#suggest" role="tab" data-toggle="tab">Master
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
                                @include('components.activity-grid-card', ['size' => 80, 'nohover' => '55', 'activities'=>$nowActivities])
                            </div>

                        </div>
                        <div class="past-activity">
                            <div class="header">Past Activitie</div>
                            <div class="content">
                                @if($pastActivities->isEmpty())
                                    <div class="no-act">No activity now.</div>
                                @endif
                                @include('components.activity-grid-card', ['size' => 80, 'nohover' => '55', 'activities'=>$pastActivities])
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="gallery">
                    <div class="gallery-wrapper">
                        <div class="gallery-flex">
                            @for($i = 0; $i < count($master['master_activity_pic'])/2; $i++)
                                <img src="{{ $master['master_activity_pic'][$i] }}" class="image">
                            @endfor
                        </div>
                        @if(count($master['master_activity_pic']) != 1)
                            <div class="gallery-flex --second">
                                @for($i = count($master['master_activity_pic'])/2; $i < count($master['master_activity_pic']); $i++)
                                    <img src="{{ $master['master_activity_pic'][$i] }}"
                                         class="image">
                                @endfor
                            </div>
                        @endif
                    </div>
                </div>
                @if($master['studio_id'])
                    <div role="tabpanel" class="tab-pane fade" id="studio">
                        @include('components.map', ['active' => true, 'studios' => [$master], 'show' => true])
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
      })
    </script>
@endsection
