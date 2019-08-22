@extends('app')

@section('title', 'Home')
@section('page', 'home')

@section('style')
    <link rel="stylesheet" href="/css/home.css">
@endsection

@section('content')
    <section class="video-header">
        <!-- Carousel -->
        <div id="carousel" class="carousel slide" data-ride="carousel">
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

        <!-- Content Header -->
        <div class="content-wrapper">
            <!-- Activity Name , Search -->
            <div class="activity-name">
                <h1 class="header">@Master Studio</h1>
                <h2 class="subheader d-block d-lg-none d-xl-block ml-3 ml-sm-5 pl-sm-2">Meet Real <a href="#"></a>Chef
                </h2>
                <input class="search-box" placeholder="Search your activities..." type="text">
            </div>
            <!-- End Activity Name , Search -->
            <div class="activity-detail-wrapper d-none d-lg-flex">
                <!-- Activity Detail -->
                <div class="activity-detail justify-content-between flex-wrap">
                    <div class="activity-title">
                        <div class="image-wrapper">
                            <img src="/img/profile.jpg" alt="">
                        </div>
                        <div class="title-wrapper">
                            <div class="title">Mistrio Waso</div>
                            <div class="badge">Italian food master</div>
                        </div>
                    </div>
                    <div class="activity-content">
                        <h3 class="header">The spirit of ingredient</h3>
                        <div class="row result-course no-gutters">
                            <div class="col text-center">
                                <div class="image-wrapper">
                                    <img src="/img/profile.jpg" alt="">
                                </div>
                                <div class="text">secret of ingredients</div>
                            </div>
                            <div class="col text-center">
                                <div class="image-wrapper">
                                    <img src="/img/profile.jpg" alt="">
                                </div>
                                <div class="text">secret of ingredients</div>
                            </div>
                            <div class="col text-center">
                                <div class="image-wrapper">
                                    <img src="/img/profile.jpg" alt="">
                                </div>
                                <div class="text">secret of ingredients</div>
                            </div>
                        </div>
                    </div>
                    <div class="activity-add">
                        <div class="time-location">
                            <div class="header-title">
                                <div class="header">
                                    Register until
                                </div>
                                <div class="detail">10 Dec 2019</div>
                            </div>
                            <div class="header-title">
                                <div class="header">
                                    Start at
                                </div>
                                <div class="detail --start">
                                    10 Dec 2019<br>
                                    10 Dec 2019<br>
                                    10 Dec 2019
                                </div>
                            </div>
                            <div class="header-title">
                                <div class="header">
                                    Location
                                </div>
                                <div class="detail">10 Dec 2019</div>
                            </div>
                        </div>
                        <div class="badge-wrapper my-1">
                            <div class="badge mr-2">3 month activity</div>
                            <div class="badge">Basic - Intermediate</div>
                        </div>
                    </div>
                </div>
                <!-- End Activity Detail -->
                <div class="activity-tabs">
                    <div class="activity-tab --join">
                        <div class="icon-wrapper"></div>
                        <div class="text">Join activity</div>
                    </div>
                    <div class="activity-tab --pin">
                        <div class="icon-wrapper"></div>
                        <div class="text">Pin activity</div>
                    </div>
                    <div class="activity-tab --invite">
                        <div class="icon-wrapper"></div>
                        <div class="text">Invite friend</div>
                    </div>
                    <div class="activity-tab --share">
                        <div class="icon-wrapper"></div>
                        <div class="text">Share</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Content Header -->
    </section>

    <section class="live-activity">
        <h3 class="header">Live Activity</h3>
        <div class="category-interest">
            <div class="interest-activity">
                <div class="icon"></div>
                <div class="name">badminton</div>
            </div>
            <div class="interest-activity">
                <div class="icon"></div>
                <div class="name">golf</div>
            </div>
            <div class="interest-activity">
                <div class="icon"></div>
                <div class="name">chef</div>
            </div>
            <div class="add-interest-activity">
                <div class="icon"></div>
                <div class="name">Add interest</div>
            </div>
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
                                <source data-src="/video/activity.mp4"
                                        type="video/mp4"/>
                            </video>
                        </div>
                        <div class="image-wrapper">
                            <img src="/img/profile.jpg" alt="">
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
@endsection

@section('scriptfile')
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@12.0.0/dist/lazyload.min.js"></script>
@endsection

@section('script')
    var lazyLoadInstance = new LazyLoad({
    elements_selector: ".lazy"
    // ... more custom settings?
    });
@endsection