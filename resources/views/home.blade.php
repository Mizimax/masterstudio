@extends('app')

@section('title', 'Home')
@section('page', 'home')

@section('style')
    <link rel="stylesheet" href="/css/home.css">
@endsection

@section('content')
    <section class="video-header">
        <div id="carousel" class="carousel slide" data-ride="carousel">

            <!-- Indicators -->
            <ul class="carousel-indicators">
                <li data-target="#carousel" data-slide-to="0" class="active"></li>
                <li data-target="#carousel" data-slide-to="1"></li>
                <li data-target="#carousel" data-slide-to="2"></li>
            </ul>

            <!-- The slideshow -->
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

        </div>
        <div class="content-wrapper justify-content-between">
            <div class="activity-name">
                <h1 class="header">@Master Studio</h1>
                <h2 class="subheader ml-5 pl-2">Meet Real <a href="#"></a>Chef</h2>
                <input class="search-box" placeholder="Search your activities..." type="text">
            </div>
            <div class="activity-detail">
                <div class="image-wrapper">
                    <img src="/img/profile.jpg" alt="">
                </div>
                <div class="activity-content">
                    <h3 class="header">The spirit of ingredient</h3>
                    <div class="row no-gutters">
                        <div class="col">
                            <div class="icon-wrapper">
                                <img src="/img/profile.jpg" alt="">
                            </div>
                            <span class="text">secret of ingredients</span>
                        </div>
                        <div class="col">
                            <div class="icon-wrapper">
                                <img src="/img/profile.jpg" alt="">
                            </div>
                            <span class="text">secret of ingredients</span>
                        </div>
                        <div class="col">
                            <div class="icon-wrapper">
                                <img src="/img/profile.jpg" alt="">
                            </div>
                            <span class="text">secret of ingredients</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
