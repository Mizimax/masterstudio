@php
    $categories = \App\Category::get();
@endphp
@extends('app')

@section('title', 'Master')
@section('page', 'master')

@section('style')
    <link rel="stylesheet" href="/css/master.css">
@endsection

@section('content')
    <section class="master-header">
        <div class="bg-header">
        </div>
        <div class="header-content">
            <h1 class="header">Explore the real master</h1>
            <div class="search-box-wrapper">
                <img src="/img/icon/search-solid.svg" class="svg">
                <input class="search-box" placeholder="Master name / Activity you like" type="text">
                <button class="button">Explore</button>
            </div>
            <div class="master-interest">
                <h2 class="header">Master you may interest</h2>
                <div class="master-list">
                    @foreach($masters as $keyMaster => $master)
                        <div class="master-category">
                            <h3 class="header">{{ $master[0]['category_name'] }} master</h3>
                            <div class="master-content">
                                @foreach($master as $key => $mst)
                                    <div class="master-detail {{ ($keyMaster * 2) + ($key) >= 3 ? 'right' : '' }}">
                                        @component('components.master-card', ['noimage'=>true, 'animate'=>true, 'size'=>70, 'data'=>$mst])
                                        @endcomponent
                                        <div class="image-wrapper">
                                            <img src="{{ $mst['user_pic'] }}" alt="">
                                        </div>
                                        <div class="name">{{ $mst['master_name'] }}</div>
                                        <div class="badge {{ $mst['master_most_recommend'] !== 0 ? '--most' : ($mst['master_recommend'] !== 0 ? '--rec' : '')}}">{{ $mst['master_most_recommend'] !== 0 ? 'Most recommended' : ($mst['master_recommend'] !== 0 ? 'Recommended' : '')}}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <section class="master-profile-section">
        <div class="section-container">
            <div class="search-wrapper">
                <div class="category-name">Italian Master</div>
                <div class="search-box-wrapper" style="position:relative">
                    <img src="/img/icon/search-solid.svg" class="svg">
                    <input class="search-box" placeholder="Master name / Activity you like"
                           type="text">
                </div>
            </div>
            <div class="filter-category" align="center">
                @include('components.category-interest')
            </div>

            @foreach ($allMasters as $key => $allMaster)
                @php
                    $allMaster['activity_video'] = json_decode($allMaster['activity_video'], true)[0];
                @endphp
                <div class="master-profile-wrapper"
                     style="{{ $key == 0 ? 'margin-top: -40px': ''}}">
                    <div class="master-profile">
                        <div class="your-activity-timeline">
                            <div class="image-container">
                                <div class="your-image image-wrapper">
                                    <img class="border-circle shadow"
                                         src="{{ $allMaster['user_pic'] }}"
                                         width="120"
                                         height="120"
                                         title="Profile image"
                                         alt="Profile image">
                                </div>
                            </div>
                            <div class="your-info" align="center">
                                <h3 class="name">{{ $allMaster['master_name'] }}</h3>
                                <span class="category">{{ $allMaster['category_name'] }}</span>
                                <div class="master-stat">
                                    <div class="header">
                                        Disciples
                                    </div>
                                    <div class="detail">{{ number_format($allMaster['master_disciple']) }}</div>
                                </div>
                                <div class="master-stat">
                                    <div class="header">
                                        Followers
                                    </div>
                                    <div class="detail --start">
                                        {{ number_format($allMaster['master_follower']) }}
                                    </div>
                                </div>
                                <div class="master-stat">
                                    <div class="header">
                                        Mastered
                                    </div>
                                    <div class="detail">{{ number_format($allMaster['master_mastered']) }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="master-video" played="false">
                            <div class="video-wrapper">
                                <video class="video video-fluid" loop muted>
                                    <source src="{{ $allMaster['activity_video'] }}"
                                            type="video/mp4" />
                                </video>

                                <div class="play-wrapper">
                                    <img src="/img/icon/play-circle-solid.svg" class="svg">
                                </div>
                            </div>
                            <div class="overlay"></div>
                            <div class="master-action">
                                <div class="actions">
                                    <div class="action-wrapper">
                                        <button class="join-button"
                                                onclick="window.location='/activity/{{ $allMaster['activity_url_name'] }}'">
                                            Join<br>Activity
                                        </button>
                                        <span>1 Activity available</span>
                                    </div>
                                    <div class="follow-wrapper">
                                        <div class="follow-icon">
                                            <img src="/img/icon/footstep.svg"
                                                 alt="Follow ..."
                                                 class="svg">
                                        </div>
                                        <div class="text">Follow</div>
                                    </div>
                                </div>
                                <div class="core-actions">
                                    <button class="request-button">Request<br>custom activity
                                    </button>
                                    <button class="view-profile-button"
                                            onclick="window.location='/master/{{ $allMaster['master_id'] }}'">
                                        view profile
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
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

        $('.master-detail').hover(function () {
          $(this).children('.activity-detail').fadeIn()
        }, function () {
          $(this).children('.activity-detail').fadeOut()
        })

      })
    </script>
@endsection
