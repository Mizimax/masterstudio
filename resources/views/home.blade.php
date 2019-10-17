@extends('app')

@section('title', 'Home')
@section('page', 'home')

@section('style')
    <link rel="stylesheet" href="/css/home.css">
@endsection

@section('content')
    <section class="video-header">
        <!-- Carousel -->
        <div id="carousel" class="carousel slide carousel-fade" data-ride="carousel">
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
                        $headActivity['activity_time_diff'] = $start->diff($end);
			            $headActivity['activity_day_left'] = $headActivity['activity_time_diff']->m === 0 ? $headActivity['activity_time_diff']->d . ' days' : $headActivity['activity_time_diff']->m . ' months';
                    @endphp
                    <div class="carousel-item {{ $key === 0 ? 'active' : ''}}">
                        <video class="video video-fluid" autoplay loop muted>
                            <source src="{{ $headActivity['activity_video'] }}"
                                    type="video/mp4" />
                        </video>
                        <!-- Content Header -->
                        <div class="content-wrapper">
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
                                <div class="activity-tabs d-none d-sm-block">
                                    <div class="activity-tab"
                                         onclick="window.location.href= '/activity/{{ $headActivity['activity_url_name'] }}'">
                                        <div class="icon-wrapper --join">
                                        </div>
                                        <div class="text">Join activity</div>
                                    </div>
                                    <div class="activity-tab">
                                        <div class="icon-wrapper --pin">
                                        </div>
                                        <div class="text">Pin activity</div>
                                    </div>
                                    <div class="activity-tab">
                                        <div class="icon-wrapper --invite">
                                        </div>
                                        <div class="text">Invite friend</div>
                                    </div>
                                    <div class="activity-tab">
                                        <div class="icon-wrapper --share">
                                        </div>
                                        <div class="text">Share</div>
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
            <input class="search-box" placeholder="Search your activities..." type="text">
            <div class="search-dropdown">
                <div class="search-result">
                    <img class="svg" src="/img/icon/badminton.svg">
                    <span class="category">Badminton</span>
                    <span class="nomaster">78 master</span>
                </div>
                <div class="search-result">
                    <img class="svg" src="/img/icon/golf.svg">
                    <span class="category">Golf</span>
                    <span class="nomaster">7 master</span>
                </div>
                <div class="search-result">
                    <img class="svg" src="/img/icon/chef.svg">
                    <span class="category">Chef</span>
                    <span class="nomaster">8 master</span>
                </div>
                <div class="search-result">
                    <img class="svg" src="/img/icon/badminton.svg">
                    <span class="category">Badminton</span>
                    <span class="nomaster">78 master</span>
                </div>
            </div>
        </div>

        <div class="half-square"></div>
    </section>

    <section class="live-activity">
        <h3 class="header">Live Activity</h3>
        @include('components.category-interest')
        <div class="activity-story --hover">
            @php
                $activitys = [0,1,2,3,4,5,6,7,8,9,10]
            @endphp
            @foreach ($activitys as $activity)
                <div class="activity-wrapper">
                    <div class="activity-card">
                        <div class="video-wrapper">
                            <video class="video lazy" loop muted>
                                <source data-src="https://maxang.me/activity.mp4"
                                        type="video/mp4" />
                            </video>
                        </div>

                        <div class="master-profile">
                            @component('components.activity-card', ['noimage'=>true, 'size'=>80, 'animate'=>true])
                            @endcomponent
                            <div class="image-wrapper">
                                <img src="/img/profile.jpg" alt="">
                            </div>
                        </div>

                        <div class="title-wrapper">
                            <div class="title">Basic Italian Food</div>
                            <div class="activity-join">
                                <div class="participant image-wrapper">
                                    <img src="/img/profile.jpg" alt="">
                                </div>
                                <div class="participant image-wrapper">
                                    <img src="/img/profile.jpg" alt="">
                                </div>
                                <div class="participant image-wrapper">
                                    <img src="/img/profile.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="location">Yesterday: JAJA Studio</div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="activity-you">
        <div class="content">
            <h3 class="header">Activity for you</h3>
            <div class="search-group" tabindex="-1" style="max-width: 400px">
                <input class="search-box" placeholder="Search your activities..." type="text">
                <div class="search-dropdown">
                    <div class="search-result">
                        <img class="svg" src="/img/icon/badminton.svg">
                        <span class="category">Badminton</span>
                        <span class="nomaster">78 master</span>
                    </div>
                    <div class="search-result">
                        <img class="svg" src="/img/icon/golf.svg">
                        <span class="category">Golf</span>
                        <span class="nomaster">7 master</span>
                    </div>
                    <div class="search-result">
                        <img class="svg" src="/img/icon/chef.svg">
                        <span class="category">Chef</span>
                        <span class="nomaster">8 master</span>
                    </div>
                    <div class="search-result">
                        <img class="svg" src="/img/icon/badminton.svg">
                        <span class="category">Badminton</span>
                        <span class="nomaster">78 master</span>
                    </div>
                </div>
            </div>
            <div class="activity-grid">
                @include('components.activity-grid-card', ['activities'=>$activities, 'size'=>80])
            </div>
        </div>
        <div class="overlay"></div>
    </section>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@12.0.0/dist/lazyload.min.js"></script>
    <script src="https://css-tricks.com/examples/HorzScrolling/jquery.mousewheel.js"></script>
    <script src="/js/activity.js"></script>
    <script src="/js/home-page.js"></script>
    <script src="/js/category.js"></script>
@endsection
