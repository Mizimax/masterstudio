@extends('app')

@section('title', 'Activities')
@section('page', 'activity')

@section('style')
    <link rel="stylesheet" href="/css/activity.css">
@endsection

@section('content')
    <section class="">

    </section>

    <section class="your-activity">
        <h3 class="header">Your Activity</h3>
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
        <div class="activity-timeline">
            <div class="your-activity-timeline">
                <div class="image-container">
                    <div class="your-image image-wrapper">
                        <img class="border-circle shadow" src="/img/profile.jpg" width="80" height="80"
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

                            <div class="master-profile">
                                @component('components.activity-card', ['noimage'=>true, 'size'=>75])
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
    <!-- recommended -->
    <script src="https://www.WebRTC-Experiment.com/RecordRTC.js"></script>
    <script>
        function getActivityPath() {
            return '/content/activity/all'
        }
    </script>
@endsection

@section('scriptready')
    var lazyLoadInstance = new LazyLoad({
    elements_selector: ".lazy"
    // ... more custom settings?
    });

    $('.all-activity .activity-grid').infiniteScroll({
    // options
    path: getActivityPath,
    append: '.activity-card-wrapper',
    status: '.loading-wrapper',
    });

    $('.all-activity .activity-grid').on( 'append.infiniteScroll', function( event, response ) {
    if (lazyLoadInstance) {
    lazyLoadInstance.update();
    }
    });

    $('.add-button').click(function(){
    navigator.mediaDevices.getUserMedia({
    video: true,
    audio: true
    }).then(async function(stream) {
    let recorder = RecordRTC(stream, {
    type: 'video'
    });
    recorder.startRecording();

    const sleep = m => new Promise(r => setTimeout(r, m));
    await sleep(3000);

    recorder.stopRecording(function() {
    let blob = recorder.getBlob();
    invokeSaveAsDialog(blob);
    });
    });
    })
@endsection
