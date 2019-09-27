@extends('app')

@section('title', 'Studio')
@section('page', 'studio')

@section('style')
    <link rel="stylesheet" href="/css/studio-detail.css">
@endsection

@section('content')
    <section class="studio-header">
        <div class="studio-header-wrapper">
            <div class="studio-header-content">
                <img src="/img/Deepsea.jpeg" alt="" class="studio-icon">
                <h1 class="studio-name">Windshire studio</h1>
                <h3 class="studio-location">Chinese bay</h3>
                <div class="action-wrapper" align="center">
                    <div class="action-button">
                        <div class="icon-wrapper --share">
                            <img src="/img/icon/user-circle-regular.svg" class="svg">
                        </div>
                        <span class="text">Share</span>
                    </div>
                    <div class="action-button">
                        <button class="join-button">Join<br>Activity</button>
                        <span class="text">1 Activity available</span>
                    </div>
                    <div class="action-button">
                        <div class="follow-icon">
                            <img src="/img/icon/caret-down-solid.svg"
                                 alt="Follow ..."
                                 class="svg">
                        </div>
                        <span class="text">follow<br />studio</span>
                    </div>
                </div>
                <div class="checkin"></div>
                @include('components/activity-story', ['stories'=>[0,1,2]])
            </div>
        </div>
    </section>

    <div class="studio-detail-container">
        <section class="studio-detail">
            <div class="detail-header">
                <div class="overlay"></div>
                <div class="content">
                    <h1 class="title">Windshire Studio</h1>
                    <div class="studio-line">
                        <img src="/img/Deepsea.jpeg" alt="" class="studio-icon">
                    </div>
                    <div class="nav-tab nav nav-pill">
                        <a class="tab-link active" href="#description" role="tab" data-toggle="tab">Description</a>
                        <a class="tab-link" href="#gallery" role="tab" data-toggle="tab">Gallery</a>
                        <a class="tab-link" href="#studio" role="tab" data-toggle="tab">Review</a>
                        <a class="tab-link" href="#suggest" role="tab" data-toggle="tab">Review</a>
                    </div>
                    <div class="video-wrapper">
                        <video class="video lazy" loop muted>
                            <source data-src="https://maxang.me/activity.mp4"
                                    type="video/mp4" />
                        </video>
                        <div class="play-wrapper">
                            <img src="/img/icon/play-circle-solid.svg" class="svg">
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active show" id="description">
                    Italian Food Master Italian Food Master Italian Food Master Italian Food Master
                    Italian Food Master Italian Food Master Italian Food Master Italian Food Master
                    Italian Food Master Italian Food Master Italian Food Master Italian Food Master
                    Italian Food Master Italian Food Master Italian Food Master Italian Food Master
                    Italian Food Master Italian Food Master Italian Food Master Italian Food Master
                    Italian Food Master Italian Food Master Italian Food Master
                </div>
            </div>
        </section>
        <section class="studio-master">
            <h4 class="title">Master @Studio</h4>
            @php
                $activitys = [0,1,2,3]
            @endphp
            @foreach ($activitys as $key => $activity)
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
                            @php
                                $activitys = [0,1,2,3,4]
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
            @endforeach
        </section>
        <section class="studio-activity">
            <h4 class="title">Activity happening here</h4>
            <div class="activity-wrapper">
                @php
                    $activities = [0,1,2,3]
                @endphp
                @include('components.activity-grid-card', ['activities'=>$activities, 'size'=>80])
            </div>
        </section>
    </div>
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