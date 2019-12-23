@extends('app')

@section('title', 'Activities')
@section('page', 'activity')

@section('style')
    <link rel="stylesheet" href="/css/activity.css">
@endsection

@section('content')
    <section class="activity-header">
        <!-- Carousel -->
        <div id="carousel" class="carousel slide carousel-fade" data-ride="carousel"
             data-interval="60000">
            <!-- Indicators -->
            <ul class="carousel-indicators">
                @foreach($headActivities as $key => $headVideo)
                    <li data-target="#carousel" data-slide-to="{{ $key }}"
                        class="{{ $loop->first ? 'active' : ''}}"></li>
                @endforeach
            </ul>
            <!-- End Indicators -->

            <!-- Slideshow -->
            <div class="carousel-inner">
                @foreach($headActivities as $key => $headActivity)
                    @php
                        $headActivity['activity_benefit'] = json_decode($headActivity['activity_benefit'], true);
                        $headActivity['activity_video'] = json_decode($headActivity['activity_video'], true)[0];
			            $headActivity['activity_routine_day'] = str_split($headActivity['activity_routine_day']);
			            $start = new DateTime($headActivity->activity_start);
                        $end = new DateTime($headActivity->activity_end);
                        $headActivity['activity_time_diff'] = $start->diff($end) ;
			            $headActivity['activity_day_left'] = $headActivity['activity_time_diff']->m === 0 ? $headActivity['activity_time_diff']->d . ' days' : $headActivity['activity_time_diff']->m . ' months';
                    @endphp
                    <div class="carousel-item {{ $key === 0 ? 'active' : ''}}">
                        <video class="video video-fluid lazy"
                               style="transform: scale({{ parse_url($headActivity['category_video'], PHP_URL_QUERY) }})"
                               autoplay loop muted>
                            <source data-src="{{ $headActivity['category_video'] }}"
                                    type="video/mp4" />
                        </video>
                        <!-- Content Header -->
                        <div class="content-wrapper">
                            <!-- Activity Name , Search -->
                            <div class="activity-name">
                                <h1 class="header">@Master Studio</h1>
                                <h2 class="subheader ml-3 ml-sm-5 pl-sm-2">Meet Real <a class="chef"
                                                                                        href="#">{{ $headActivity['category_name'] }}</a>
                                </h2>
                            </div>
                            <!-- End Activity Name , Search -->
                            <div class="activity-detail-wrapper">
                                <div class="activity-tabs d-none d-sm-block">
                                    <div class="activity-tab"
                                         onclick="window.location.href= '/activity/{{ $headActivity['activity_url_name'] }}'">
                                        <div class="icon-wrapper --join">
                                        </div>
                                        <div class="text">Join activity</div>
                                    </div>
                                    <div class="activity-tab">
                                        <div class="icon-wrapper --pin">
                                        </div>
                                        <div class="text">Pin activity</div>
                                    </div>
                                    <div class="activity-tab">
                                        <div class="icon-wrapper --invite">
                                        </div>
                                        <div class="text">Invite friend</div>
                                    </div>
                                    <div class="activity-tab">
                                        <div class="icon-wrapper --share">
                                        </div>
                                        <div class="text">Share</div>
                                    </div>
                                </div>
                                @include('components.activity-card', ['size'=>80, 'activity'=> $headActivity])
                            </div>
                        </div>
                        <!-- End Content Header -->
                    </div>
                @endforeach
                {{--                <div class="carousel-item">--}}
                {{--                    <video class="video video-fluid" autoplay loop muted>--}}
                {{--                        <source src="https://mdbootstrap.com/img/video/forest.mp4"--}}
                {{--                                type="video/mp4" />--}}
                {{--                    </video>--}}
                {{--                </div>--}}
                {{--                <div class="carousel-item">--}}
                {{--                    <video class="video video-fluid" autoplay loop muted>--}}
                {{--                        <source src="https://mdbootstrap.com/img/video/Agua-natural.mp4"--}}
                {{--                                type="video/mp4" />--}}
                {{--                    </video>--}}
                {{--                </div>--}}
            </div>
            <!-- End Slideshow -->
        </div>
        <!-- End Carousel -->
        <div class="search-group" tabindex="-1" style="width: 450px">
            <input class="search-box" placeholder="Search your activities..." type="text">
            <div class="search-dropdown">
                <div class="search-result">
                    <img class="svg" src="/img/icon/badminton.svg">
                    <span class="category">Badminton</span>
                    <span class="nomaster">78 master</span>
                </div>
                <div class="search-result">
                    <img class="svg" src="/img/icon/golf.svg">
                    <span class="category">Golf</span>
                    <span class="nomaster">7 master</span>
                </div>
                <div class="search-result">
                    <img class="svg" src="/img/icon/chef.svg">
                    <span class="category">Chef</span>
                    <span class="nomaster">8 master</span>
                </div>
                <div class="search-result">
                    <img class="svg" src="/img/icon/badminton.svg">
                    <span class="category">Badminton</span>
                    <span class="nomaster">78 master</span>
                </div>
            </div>
        </div>
        <div class="half-square"></div>
    </section>

    <section class="your-activity">
        <h3 class="header">Your Activity</h3>
        @include('components.category-interest')
        @if(!empty($user))
            <div class="activity-timeline">
                <div class="your-activity-timeline">
                    <div class="image-container">
                        <div class="your-image image-wrapper">
                            <img class="border-circle shadow" src="{{ $user['user_pic'] }}"
                                 width="80"
                                 height="80"
                                 title="Profile image"
                                 alt="Profile image">
                        </div>
                    </div>
                    <div class="your-info">
                        <h3 class="name">{{ $user['user_name'] }}</h3>
                        <span class="level">LV. {{ $user['user_level'] }}</span>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar"
                                 style="width: 50%" aria-valuenow="50"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <span class="timespend-badge">Time spend</span>
                        <span class="timespend">{{ $user['user_hour'] }} hours</span>
                        {{--                    <span class="category">Badminton</span>--}}
                    </div>
                </div>
                <div class="activity-timeline-expand">
                    <div class="text">activity timeline <img src="/img/icon/caret-down-solid.svg"
                                                             class="svg"></div>
                </div>
                <div class="activity-story">
                    @foreach ($stories as $story)
					    <?php
					    $story['users_activity'] = \App\UserActivity::join('users', 'user_activities.user_id', 'users.user_id')->where('activity_id', $story['activity_id'])->get();
					    ?>
                        <div class="activity-wrapper">
                            <div class="activity-card">
                                <div class="video-wrapper">
                                    <video class="video lazy" loop muted>
                                        <source data-src="{{ $story['activity_story_video'] }}"
                                                type="video/mp4" />
                                    </video>
                                </div>

                                <div class="master-profile">
                                    <div class="image-wrapper">
                                        <img src="{{ $story['user_pic'] }}" alt="">
                                    </div>
                                </div>

                                <div class="title-wrapper">
                                    <div class="title"
                                         align="left">{{ $story['activity_name'] }}</div>
                                    <div class="activity-join">
                                        @foreach($story['users_activity'] as $userStory)
                                            <div class="participant image-wrapper">
                                                <img src="{{ $userStory['user_pic'] }}" alt="">
                                            </div>
                                        @endforeach
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
        @endif
    </section>

    <div class="record-video">
        <div class="activity-select" style="margin-bottom: 10px">
            <select class="form-control" name="activity-story" id="activity-story">
                <option>Select activity you want to share story.</option>
                @foreach($myActivities as $myActivity)
                    <option value="{{ $myActivity['activity_id'] }}">{{ $myActivity['activity_name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="video-preview">
            <video class="video" autoplay></video>
            <div class="cantaccess">This function requires camera and microphone access.</div>
            <div class="time-record" align="center">
                <span class="time">0:00</span> / 1:00 minute
            </div>
        </div>
        <div class="d-flex">
            <button id="upload-btn" class="record-btn mr-2 d-none">Upload</button>
            <button class="record-btn">Start recording</button>
        </div>
        {{--        <div class="overlay"></div>--}}
    </div>

    <section class="all-activity">
        <div class="content">
            <h3 class="header">All activities</h3>
            <div class="search-group" tabindex="-1" align="left">
                <input class="search-box" placeholder="Search your activities..." type="text">
                <div class="search-dropdown">
                    <div class="search-result">
                        <img class="svg" src="/img/icon/badminton.svg">
                        <span class="category">Badminton</span>
                        <span class="nomaster">78 master</span>
                    </div>
                    <div class="search-result">
                        <img class="svg" src="/img/icon/golf.svg">
                        <span class="category">Golf</span>
                        <span class="nomaster">7 master</span>
                    </div>
                    <div class="search-result">
                        <img class="svg" src="/img/icon/chef.svg">
                        <span class="category">Chef</span>
                        <span class="nomaster">8 master</span>
                    </div>
                    <div class="search-result">
                        <img class="svg" src="/img/icon/badminton.svg">
                        <span class="category">Badminton</span>
                        <span class="nomaster">78 master</span>
                    </div>
                </div>
            </div>
            <div class="activity-grid">
                @include('components.activity-grid-card', ['activities'=>$activities, 'size'=>80])
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

