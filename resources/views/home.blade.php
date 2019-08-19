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
                                type="video/mp4" />
                    </video>
                </div>
                <div class="carousel-item">
                    <video class="video video-fluid" autoplay loop muted>
                        <source src="https://mdbootstrap.com/img/video/forest.mp4"
                                type="video/mp4" />
                    </video>
                </div>
                <div class="carousel-item">
                    <video class="video video-fluid" autoplay loop muted>
                        <source src="https://mdbootstrap.com/img/video/Agua-natural.mp4"
                                type="video/mp4" />
                    </video>
                </div>
            </div>
            <!-- End Slideshow -->
        </div>
        <!-- End Carousel -->

        <!-- Content Header -->
        <div class="content-wrapper justify-content-around flex-md-row">
            <!-- Activity Name , Search -->
            <div class="activity-name">
                <h1 class="header">@Master Studio</h1>
                <h2 class="subheader ml-3 ml-sm-5 pl-sm-2">Meet Real <a href="#"></a>Chef</h2>
                <input class="search-box" placeholder="Search your activities..." type="text">
            </div>
            <!-- End Activity Name , Search -->
            <!-- Activity Detail -->
            <div class="activity-detail justify-content-between flex-wrap  d-none d-md-block">
                <div class="image-wrapper">
                    <img src="/img/profile.jpg" alt="">
                </div>
                <div class="activity-content">
                    <h3 class="header">The spirit of ingredient</h3>
                    <div class="row result-course no-gutters">
                        <div class="col text-center">
                            <div class="image-wrapper">
                                <img src="/img/profile.jpg" alt="">
                            </div>
                            <span class="text">secret of ingredients</span>
                        </div>
                        <div class="col text-center">
                            <div class="image-wrapper">
                                <img src="/img/profile.jpg" alt="">
                            </div>
                            <span class="text">secret of ingredients</span>
                        </div>
                        <div class="col text-center">
                            <div class="image-wrapper">
                                <img src="/img/profile.jpg" alt="">
                            </div>
                            <span class="text">secret of ingredients</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Activity Detail -->
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
            <div class="activity-card">
                <div class="video-wrapper">
                    <video class="video" autoplay loop muted>
                        <source src="/video/activity.mp4"
                                type="video/mp4" />
                    </video>
                </div>
                <div class="title-wrapper">
                    <div class="title">Basic Italian Food</div>
                    <div class="activity-join">
                        <div class="participant image-wrapper">
                            <img src="" alt="">
                        </div>
                        <div class="participant image-wrapper">
                            <img src="" alt="">
                        </div>
                        <div class="participant image-wrapper">
                            <img src="" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
