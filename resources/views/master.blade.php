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
            <h1 class="header">Explore the real master...</h1>
            <div class="search-box-wrapper">
                <input class="search-box" placeholder="Search your activities..." type="text">
                <button class="button">Explore</button>
            </div>
            <div class="master-interest">
                <h2 class="header">Master you may interest</h2>
                <div class="master-list">
                    <div class="master-category">
                        <h3 class="header">Fishery master</h3>
                        <div class="master-content">
                            <div class="master-detail">
                                @component('components.master-card', ['noimage'=>true, 'animate'=>true, 'size'=>70])
                                @endcomponent
                                <div class="image-wrapper">
                                    <img src="/img/profile.jpg" alt="">
                                </div>
                                <div class="name">Adam</div>
                                <div class="badge">Beginner most recommended</div>
                            </div>
                            <div class="master-detail">
                                @component('components.master-card', ['noimage'=>true, 'animate'=>true, 'size'=>70])
                                @endcomponent
                                <div class="image-wrapper">
                                    <img src="/img/profile.jpg" alt="">
                                </div>
                                <div class="name">Adam</div>
                                <div class="badge">Beginner most recommended</div>
                            </div>
                        </div>
                    </div>
                    <div class="master-category">
                        <h3 class="header">Fishery master</h3>
                        <div class="master-content">
                            <div class="master-detail">
                                @component('components.master-card', ['noimage'=>true, 'animate'=>true, 'size'=>70])
                                @endcomponent
                                <div class="image-wrapper">
                                    <img src="/img/profile.jpg" alt="">
                                </div>
                                <div class="name">Adam</div>
                                <div class="badge">Beginner most recommended</div>
                            </div>
                            <div class="master-detail right">
                                @component('components.master-card', ['noimage'=>true, 'animate'=>true, 'size'=>70])
                                @endcomponent
                                <div class="image-wrapper">
                                    <img src="/img/profile.jpg" alt="">
                                </div>
                                <div class="name">Adam</div>
                                <div class="badge">Beginner most recommended</div>
                            </div>
                        </div>
                    </div>
                    <div class="master-category">
                        <h3 class="header">Fishery master</h3>
                        <div class="master-content">
                            <div class="master-detail right">
                                @component('components.master-card', ['noimage'=>true, 'animate'=>true, 'size'=>70])
                                @endcomponent
                                <div class="image-wrapper">
                                    <img src="/img/profile.jpg" alt="">
                                </div>
                                <div class="name">Adam</div>
                                <div class="badge">Beginner most recommended</div>
                            </div>
                            <div class="master-detail right">
                                @component('components.master-card', ['noimage'=>true, 'animate'=>true, 'size'=> 70])
                                @endcomponent
                                <div class="image-wrapper">
                                    <img src="/img/profile.jpg" alt="">
                                </div>
                                <div class="name">Adam</div>
                                <div class="badge">Beginner most recommended</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="master-profile-section">
        <div class="section-container">
            <div class="search-wrapper">
                <div class="category-name">Italian Master</div>
                <div class="search-box-wrapper">
                    <input class="search-box" placeholder="Master name / Activity you like" type="text">
                </div>
            </div>
            <div class="filter-category" align="center">
                @include('components.category-interest')
            </div>
            <div class="master-profile-wrapper">
                <div class="master-profile">
                    <div class="your-activity-timeline">
                        <div class="image-container">
                            <div class="your-image image-wrapper">
                                <img class="border-circle shadow" src="/img/profile.jpg" width="120"
                                     height="120"
                                     title="Profile image"
                                     alt="Profile image">
                            </div>
                        </div>
                        <div class="your-info" align="center">
                            <h3 class="name">Soma Stamp</h3>
                            <span class="category">Badminton</span>
                            <span class="">2 hours</span>
                            <div class="master-stat">
                                <div class="header">
                                    Disciples
                                </div>
                                <div class="detail">700</div>
                            </div>
                            <div class="master-stat">
                                <div class="header">
                                    Followers
                                </div>
                                <div class="detail --start">
                                    2,000
                                </div>
                            </div>
                            <div class="master-stat">
                                <div class="header">
                                    Mastered
                                </div>
                                <div class="detail">4</div>
                            </div>
                        </div>
                    </div>
                    <div class="master-video">
                        <video class="video video-fluid" autoplay loop muted>
                            <source src="https://mdbootstrap.com/img/video/Tropical.mp4"
                                    type="video/mp4"/>
                        </video>
                        <div class="master-action">
                            <div class="actions">
                                <div class="action-wrapper">
                                    <button class="join-button">Join<br>Activity</button>
                                    <span>1 Activity available</span>
                                </div>
                                <div class="follow-wrapper">
                                    <div class="follow-icon">
                                        <img src="/img/icon/caret-down-solid.svg" alt="Follow ..." class="svg">
                                    </div>
                                    <div class="text">Follow</div>
                                </div>
                            </div>
                            <div class="core-actions">
                                <button class="request-button">Request<br>custom activity</button>
                                <button class="view-profile-button">view profile</button>
                            </div>
                        </div>
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
        })
    </script>
@endsection
