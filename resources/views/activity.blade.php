@extends('app')

@section('title', 'Activities')
@section('page', 'activity')

@section('style')
    <link rel="stylesheet" href="/css/activity.css">
@endsection

@section('content')
    <section class="activity-header">
        <!-- Carousel -->
        <div id="carousel" class="carousel slide carousel-fade" data-ride="carousel">
            <!-- Indicators -->
            <ul class="carousel-indicators">
                <li data-target="#carousel" data-slide-to="0" class="active"></li>
                <li data-target="#carousel" data-slide-to="1"></li>
                <li data-target="#carousel" data-slide-to="2"></li>
            </ul>
            <!-- End Indicators -->

            <!-- Slideshow -->
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <video class="video video-fluid" autoplay loop muted>
                        <source src="https://mdbootstrap.com/img/video/Tropical.mp4"
                                type="video/mp4"/>
                    </video>
                    <!-- Content Header -->
                    <div class="content-wrapper">
                        <!-- Activity Name , Search -->
                        <div class="activity-name">
                            <h1 class="header">@Master Studio</h1>
                            <h2 class="subheader">Meet Real <a href="#"></a>Chef
                            </h2>
                            <div class="search-box-wrapper">
                                <input class="search-box" placeholder="Search your activities..." type="text">
                            </div>
                        </div>
                        <!-- End Activity Name , Search ac-->
                        <div class="activity-detail-wrapper d-none d-sm-flex">
                            <div class="activity-story justify-content-md-end justify-content-center">
                                @php
                                    $activitys = [0,1,2]
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
                                                @component('components.activity-card', ['noimage'=>true, 'size'=>75, 'animate'=>true])
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
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- End Content Header -->
                </div>
                <div class="carousel-item">
                    <video class="video video-fluid" autoplay loop muted>
                        <source src="https://mdbootstrap.com/img/video/forest.mp4"
                                type="video/mp4"/>
                    </video>
                </div>
                <div class="carousel-item">
                    <video class="video video-fluid" autoplay loop muted>
                        <source src="https://mdbootstrap.com/img/video/Agua-natural.mp4"
                                type="video/mp4"/>
                    </video>
                </div>
            </div>
            <!-- End Slideshow -->
        </div>
        <!-- End Carousel -->
        <div class="half-square"></div>
    </section>

    <section class="your-activity">
        <h3 class="header">Your Activity</h3>
        @include('components.category-interest')
        <div class="activity-timeline">
            <div class="your-activity-timeline">
                <div class="image-container">
                    <div class="your-image image-wrapper">
                        <img class="border-circle shadow" src="/img/profile.jpg" width="80"
                             height="80"
                             title="Profile image"
                             alt="Profile image">
                    </div>
                </div>
                <div class="your-info">
                    <h3 class="name">Soma Stamp</h3>
                    <span class="level">LV. 1</span>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar"
                             style="width: 50%" aria-valuenow="50"
                             aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <span class="timespend-badge">Time spend</span>
                    <span class="timespend">2 hours</span>
                    <span class="category">Badminton</span>
                </div>
            </div>
            <div class="activity-timeline-expand">
                <div class="text">activity timeline <img src="/img/icon/caret-down-solid.svg" class="svg"></div>
            </div>
            <div class="activity-story">
                @php
                    $activitys = [0,1,2,3,4,5,6,7,8,9,10]
                @endphp
                @foreach ($activitys as $activity)
                    <div class="activity-wrapper">
                        <div class="activity-card">
                            <div class="video-wrapper">
                                <video class="video lazy" loop muted>
                                    <source data-src="https://maxang.me/activity.mp4"
                                            type="video/mp4"/>
                                </video>
                            </div>

                            <div class="master-profile">
                                @component('components.activity-card', ['noimage'=>true, 'size'=>75, 'animate'=>true])
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

            <div class="add-activity-story">
                <div class="add-button">
                    <img src="/img/icon/plus-solid.svg" class="svg">
                </div>
            </div>
        </div>
    </section>

    <div class="record-video">
        <div class="video-preview">
            <video class="video" autoplay></video>
            <div class="cantaccess">This function requires camera and microphone access.</div>
            <div class="time-record" align="center">
                <span class="time">0:00</span> / 1:00 minute
            </div>
        </div>
        <button class="record-btn">Start recording</button>
        {{--        <div class="overlay"></div>--}}
    </div>

    <section class="all-activity">
        <div class="content">
            <h3 class="header">All activities</h3>
            <input class="search input-transparent" placeholder="Search your activities..."
                   type="text">
            <div class="activity-grid">
                @php
                    $activities = [0,1,2,3,4,5]
                @endphp
                @include('components.activity-grid-card', ['activities'=>$activities])
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
@endsection

@section('script')
    <script src="/js/infinite-scroll.pkgd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@12.0.0/dist/lazyload.min.js"></script>
    <script src="https://www.WebRTC-Experiment.com/RecordRTC.js"></script>
    <script src="/js/activity.js"></script>
    <script src="/js/activity-page.js"></script>
@endsection

