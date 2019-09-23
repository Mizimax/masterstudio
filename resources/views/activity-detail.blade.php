@extends('app')

@section('title', 'Activities')
@section('page', 'activity')

@section('style')
    <link rel="stylesheet" href="/css/activity-detail.css">
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
                </div>
                <div class="carousel-item">
                    <video class="video video-fluid" autoplay loop muted>
                        <source src="https://mdbootstrap.com/img/video/Tropical.mp4"
                                type="video/mp4"/>
                    </video>
                </div>
                <div class="carousel-item">
                    <video class="video video-fluid" autoplay loop muted>
                        <source src="https://mdbootstrap.com/img/video/Tropical.mp4"
                                type="video/mp4"/>
                    </video>
                </div>
            </div>
            <!-- End Slideshow -->
            <div class="activity-header-detail">
                @include('components/activity-card', ['size' => 80])
                <div class="activity-action">
                    <div class="price">THB 1,500</div>
                    <button class="join-button">Join activity</button>
                    <button class="milestone-button">Set as milestone</button>
                    <div class="availability-wrapper">
                        <div class="availability">
                            <div class="title">Availability</div>
                            <div class="number">5/8</div>
                        </div>
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
            <div class="vr-exp">
                <div class="image-wrapper">
                    <img class="svg" src="/img/icon/play-circle-solid.svg" alt="">
                </div>
                <div class="text">VR experience</div>
            </div>
        </div>
        <!-- End Carousel -->
    </section>

    <section class="activity-detail-section">
        <div class="activity-section --header">
            <h1 class="title">The spirit of the ingredient</h1>
            <h2 class="subtitle">"Every ingredient have there own spirit and every fractral of spirit can differentiate
                the taste"</h2>
        </div>
        <div class="activity-section --exp">
            <div class="title">Activity Experiences</div>
            <div class="benefit-wrapper">
                @php
                    $activitys = [0,1,2]
                @endphp
                @foreach ($activitys as $key => $activity)
                    <div class="benefit-card" style="background: url('/img/Deepsea.jpeg')">
                        <img class="svg" src="/img/profile.jpg" alt="">
                        <div class="name">secret of ingredients</div>
                        <div class="description">Every ingredient have there own spirit and every fractral of spirit can
                            differentiate the taste
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="more-button">More detail <img class="svg" src="/img/icon/caret-down-solid.svg"></button>
        </div>
        <div class="activity-section --studio">
            <div class="studio-wrapper">
                <div class="google-map">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13041.000141488994!2d100.49078499776775!3d13.650917617558623!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e2a251bb6b0cf1%3A0xf656e94ff13324ad!2sKing%20Mongkut%E2%80%99s%20University%20of%20Technology%20Thonburi!5e0!3m2!1sen!2sth!4v1569249162314!5m2!1sen!2sth"
                        height="320" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                </div>
                <div class="studio-detail">
                    <h3 class="title">Studio@</h3>
                    <h4 class="sub-title">Piazzale italian dining school</h4>
                    <div class="studio-section">
                        <div class="title">About studio</div>
                        <div class="content">Italian food studio with 10years+ experience masters</div>
                    </div>
                    <div class="studio-section">
                        <div class="title">Studio promotion</div>
                        <div class="content">
                            @php
                                $activitys = [0,1,2]
                            @endphp
                            @foreach ($activitys as $key => $activity)
                                <div class="promo-code">
                                    <div class="name">first comer discount 10%</div>
                                    <div class="badge">10% off</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="activity-section --story">
            <div class="title">Master story</div>
            @php
                $stories = [0,1,2]
            @endphp
            @include('components/activity-story', ['stories' => $stories])
        </div>
        <div class="activity-section --prepward">
            <div class="prepare-reward">
                <div class="prepare-wrapper">
                    <div class="title">Preparation</div>
                    <div class="content">

                    </div>
                </div>
                <div class="reward-wrapper">
                    <div class="title">System reward</div>
                    <div class="reward-detail">
                        <div class="image-wrapper">
                            <img src="/img/icon/user-circle-regular.svg" alt="" class="svg">
                        </div>
                        <div class="reward-text">
                            <div class="name">Experiences</div>
                            <div class="reward">1,320 EXP (30 hours)</div>
                            <div class="description"></div>
                        </div>
                    </div>
                    <div class="reward-detail">
                        <div class="image-wrapper">
                            <img src="/img/icon/user-circle-regular.svg" alt="" class="svg">
                        </div>
                        <div class="reward-text">
                            <div class="name">Achievement</div>
                            <div class="reward">Basic degree italian food and wine</div>
                            <div class="description">3 level : bronze/silver/gold</div>
                        </div>
                    </div>
                    <div class="reward-detail">
                        <div class="image-wrapper">
                            <img src="/img/icon/user-circle-regular.svg" alt="" class="svg">
                        </div>
                        <div class="reward-text">
                            <div class="name">Studio Reputation</div>
                            <div class="reward">Middle class</div>
                            <div class="description"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="activity-section --suggest">
            <div class="title">Master suggestion next...</div>
            <div class="suggest-wrapper">
                @php
                    $activities = [0,1,2]
                @endphp
                @include('components.activity-grid-card', ['activities'=>$activities, 'size' => 80])
            </div>
        </div>
        <div class="activity-section --comment">
            <div class="title">Disciple Commented</div>
            @php
                $comments = [0,1,2]
            @endphp
            @foreach($comments as $key => $comment)
                <div class="comment-wrapper">
                    <div class="disciple-profile">
                        <div class="image-wrapper">
                            <img src="/img/profile.jpg" alt="">
                        </div>
                        <div class="name">monotone</div>
                        <span class="category-level">Italian level 9</span>
                        <div class="agree-no">
                            <img src="/img/icon/plus-solid.svg" class="svg"> 139 agree
                        </div>
                    </div>
                    <div class="comment-detail">
                        <span
                            class="badge {{ $key === 0 ? '--mostly': ''}}">{{ $key === 0 ? 'mostly': ''}} recommended</span>
                        <div class="title">Most recommend for beginner</div>
                        <div class="comment">
                            Most recommend for beginner Most recommend for beginner Most recommend for beginner Most
                            recommend for beginner
                        </div>
                        <button class="readmore">read more...</button>
                        <div class="join-since">join activity at : 1 year ago</div>
                    </div>
                    <div class="comment-image">
                        <img class="image" src="/img/Deepsea.jpeg">
                        <img class="image" src="/img/Deepsea.jpeg">
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
        })
    </script>
@endsection
