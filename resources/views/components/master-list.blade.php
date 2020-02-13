@if($masters->isEmpty())
    <div class="search-result">No master.</div>
@endif
@foreach ($masters as $key => $master)
    @php
        $master['activity_video'] = json_decode($master['activity_video'], true)[0];
        $isFollower = ($master['follower'] === 1 ? true : false);
        $me = ($master['user_id'] === $userme['user_id']);
    @endphp
    <div class="master-profile-wrapper {{ $key == 0 && !isset($noFollow) ? '--first': ''}}">
        <div class="master-profile">
            <div class="your-activity-timeline">
                <div class="image-container">
                    <div class="your-image image-wrapper">
                        <img style="width: 120px; height: 120px; object-fit: cover"
                             class="border-circle shadow"
                             src="{{ $master['user_pic'] }}"
                             title="Profile image"
                             alt="Profile image">
                    </div>
                </div>
                <div class="your-info" align="center">
                    <h3 class="name">{{ $master['master_name'] }}</h3>
                    <span class="category">{{ $master['category_name'] }}</span>
                    <div class="master-stat">
                        <div class="header">
                            Disciples
                        </div>
                        <div class="detail">{{ number_format($master['master_disciple']) }}</div>
                    </div>
                    <div class="master-stat">
                        <div class="header">
                            Followers
                        </div>
                        <div class="detail --start">
                            {{ number_format($master['master_follower']) }}
                        </div>
                    </div>
                    <div class="master-stat">
                        <div class="header">
                            Mastered
                        </div>
                        <div class="detail">{{ number_format($master['master_mastered']) }}</div>
                    </div>
                </div>
            </div>
            <div class="master-action-mobile d-block d-sm-none">
                <div class="action --join"
                     onclick="window.location='/activity/{{ $master['activity_url_name'] }}'">
                    Join<br />Activity
                </div>
                @if(!isset($noFollow))
                    @if(!$me)
                        @if(!$isFollower)
                            <form action="/master/{{ $master['master_id'] }}"
                                  method="post">
                                @csrf
                            </form>
                        @endif
                        <div class="action --follow">Follow</div>
                    @endif
                @endif
                <div class="action --custom">Custom<br />Activity</div>
                <div class="action --profile"
                     onclick="window.location='/master/{{ $master['master_id'] }}'">View<br />Profile
                </div>
            </div>
            <div class="master-video" played="false">
                <div class="video-wrapper">
                    <video class="video video-fluid" loop muted>
                        <source src="{{ $master['activity_video'] }}"
                                type="video/mp4" />
                    </video>

                    <div class="play-wrapper">
                        <img src="/img/icon/play-circle-solid.svg" class="svg">
                    </div>
                </div>
                <div class="overlay"></div>
                <div class="master-action">
                    <div class="actions">
                        <div class="action-wrapper">
                            <button class="join-button"
                                    onclick="window.location='/activity/{{ $master['activity_url_name'] }}'">
                                Join<br>Activity
                            </button>
                            <span>1 Activity available</span>
                        </div>
                        @if(!isset($noFollow))
                            @if(!$me)
                                @if(!$isFollower)
                                    <form action="/master/{{ $master['master_id'] }}"
                                          method="post">
                                        @csrf
                                    </form>
                                @endif
                                <div class="follow-wrapper {{ $isFollower ? 'followed' : '' }}"
                                     onclick="$(this).prev().submit()">
                                    <div class="follow-icon">
                                        <img src="/img/icon/footstep.svg" alt="Follow ..."
                                             class="svg">
                                    </div>
                                    <div class="text"> {{ $isFollower ? 'Followed' : 'Follow' }}</div>
                                </div>

                            @endif
                        @endif
                    </div>
                    <div class="core-actions">
                        <button class="request-button">Request<br>custom activity
                        </button>
                        <button class="view-profile-button"
                                onclick="window.location='/master/{{ $master['master_id'] }}'">
                            view profile
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach