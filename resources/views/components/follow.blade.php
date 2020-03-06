@if($masters->isEmpty())
    <div class="no-follow">No followed master.</div>
@endif
@foreach ($masters as $key => $master)
    @php
        $master['activity_video'] = json_decode($master['activity_video'], true)[0];
    @endphp
    <div class="master-profile-wrapper">
        <div class="master-profile">
            <div class="your-activity-timeline">
                <div class="image-container">
                    <div class="your-image image-wrapper">
                        <img class="border-circle shadow"
                             src="{{ $master['user_pic'] }}"
                             width="120"
                             height="120"
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
                        <div class="detail">{{ number_format($master['master_masted']) }}</div>
                    </div>
                </div>
            </div>
            <div class="master-video" played="false">
                <div class="video-wrapper">
                    <video class="video video-fluid" loop muted playsinline>
                        <source src="{{ $master['activity_video'] }}"
                                type="video/mp4" />
                    </video>

                    <div class="play-wrapper">
                        <img src="/img/icon/play-circle-solid.svg"
                             class="svg">
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
                        </div>
                    </div>
                    <div class="core-actions">
                        <button class="request-button">Request<br>custom
                            activity
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