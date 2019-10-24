@extends('app')

@section('title', 'Activities')
@section('page', 'master')

@section('style')
    <link rel="stylesheet" href="/css/master-detail.css">
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
                        <div class="title">Mistrio Waso</div>
                        <div class="badge">Italian Food Master</div>
                        <div class="master-badge">
                            <div class="badge --basic">Most basic recommended</div>
                            <div class="badge --advance" style="margin-top: 5px">Most advance
                                recommended
                            </div>
                        </div>
                    </div>
                    <div class="activity-story">
                        @foreach ($allActivities as $activity)
                            <div class="activity-wrapper">
                                <div class="activity-card">
                                    <div class="video-wrapper">
                                        <video class="video lazy" loop muted>
                                            <source data-src="https://maxang.me/activity.mp4"
                                                    type="video/mp4" />
                                        </video>
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
                    <div class="master-action">
                        <div class="actions">
                            <div class="action-wrapper">
                                <button class="join-button">Join<br>Activity</button>
                                <span>1 Activity available</span>
                            </div>
                            <div class="follow-wrapper">
                                <div class="follow-icon">
                                    <img src="/img/icon/caret-down-solid.svg" alt="Follow ..."
                                         class="svg">
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
            <div class="master-stat-wrapper">
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
            <div class="nav-tab nav nav-pill">
                <a class="tab-link active" href="#activity" role="tab" data-toggle="tab">Master
                    Activities</a>
                <a class="tab-link" href="#gallery" role="tab" data-toggle="tab">Gallery</a>
                <a class="tab-link" href="#studio" role="tab" data-toggle="tab">Studio</a>
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
                                @include('components.activity-grid-card', ['size' => 80, 'activities'=>$nowActivities])
                            </div>

                        </div>
                        <div class="past-activity">
                            <div class="header">Past Activitie</div>
                            <div class="content">
                                @include('components.activity-grid-card', ['size' => 80, 'activities'=>$pastActivities])
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="gallery">
                    <div class="activity-wrapper d-flex pt-4">
                        <img class="mr-3" src="/img/Deepsea.jpeg" width="200" height="200" alt="">
                        <img class="mx-3" src="/img/Deepsea.jpeg" width="200" height="200" alt="">
                        <img class="mx-3" src="/img/Deepsea.jpeg" width="200" height="200" alt="">
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="studio">studio</div>
                <div role="tabpanel" class="tab-pane fade" id="suggest">suggest</div>
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
      })
    </script>
@endsection
