@extends('app')

@section('title', 'Activities')
@section('page', 'activity')

@section('style')
    <link rel="stylesheet" href="/css/activity.css">
@endsection

@section('content')
    <section class="activity-header">
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
                        <div class="activity-detail-wrapper d-none d-md-flex">
                            @include('components.activity-card', ['size' => 70])
                            @include('components.activity-card', ['size' => 70])
                            @include('components.activity-card', ['size' => 70])
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
                                    <source data-src="/video/activity.mp4"
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
    <!-- recommended -->
    <script src="https://www.WebRTC-Experiment.com/RecordRTC.js"></script>
    <script>
        function getActivityPath() {
            return '/content/activity/all'
        }

        function calculateTimeDuration(secs) {
            var min = Math.floor(secs / 60)
            var sec = Math.floor(secs - (min * 60))
            if (sec < 10) {
                sec = '0' + sec
            }
            return min + ':' + sec
        }

        $(document).ready(function () {

            var mediaStream;

            var lazyLoadInstance = new LazyLoad({
                elements_selector: '.lazy',
                // ... more custom settings?
            })

            $('.all-activity .activity-grid').infiniteScroll({
                // options
                path: getActivityPath,
                append: '.activity-card-wrapper',
                status: '.loading-wrapper',
            })

            $('.all-activity .activity-grid').on('append.infiniteScroll', function (event, response) {
                if (lazyLoadInstance) {
                    lazyLoadInstance.update()
                }
            })

            $('.add-button').click(function () {

                var countup

                $('.record-video').addClass('d-flex')

                $('.record-video').off('click').on('click', function (event) {
                    if ($(event.target).hasClass('record-video')) {
                        $(this).toggleClass('d-flex')
                        mediaStream.stop();
                    }
                })

                navigator.getUserMedia({
                        video: true,
                        audio: true,
                    },
                    function (stream) {
                        let recorder = RecordRTC(stream, {
                            type: 'video',
                        })
                        mediaStream = stream;
                        $('.video-preview > video')[0].srcObject = stream
                        $('.record-btn').off('click').on('click', function () {
                                console.log('record');
                                if (!MasterStudio.videoPreview.play) {
                                    recorder.startRecording()
                                    $(this).text('Stop recording...')

                                    var sec = 0
                                    $('.time-record > .time').text('0:00')
                                    countup = setInterval(function () {
                                        var countText = calculateTimeDuration(++sec)
                                        $('.time-record > .time').text(countText)
                                    }, 1000)
                                } else {
                                    recorder.stopRecording(function () {
                                        let blob = recorder.getBlob()
                                        invokeSaveAsDialog(blob)
                                    })
                                    $(this).text('Start recording')
                                    clearInterval(countup)
                                }
                                $(this).toggleClass('recording')
                                MasterStudio.videoPreview.play = !MasterStudio.videoPreview.play
                            },
                        )
                    },
                    function (error) {
                        $('.cantaccess').addClass('d-block')
                    }
                )
            })
        })
    </script>
@endsection

