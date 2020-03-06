<!-- Activity Detail -->
@php
    $size = !empty($size) ? $size : 100;
    $data = !empty($data) ? $data : [];
@endphp
@if(!empty($data))
    <div class="activity-detail {{!empty($animate) ? '--fade' : '' }} justify-content-between flex-wrap">
    <div class="activity-title">
        <div class="image-wrapper" style="margin-top: -{{ $size/2 }}px; width: {{ $size }}px; height: {{ $size }}px">
            @if(empty($noimage))
                <img style="width: {{ $size }}px; height: {{ $size }}px" src="/img/profile.jpg" alt="">
            @endif
        </div>
        <div class="title-wrapper">
            <div class="title">{{ $data['master_name'] }}</div>
            <div class="badge">{{ $data['category_name'] }} master</div>
        </div>
        @if(!$me)
            @if(!$isFollower)
                <form action="/master/{{ $data['master_id'] }}"
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
    </div>
        <div class="master-stat-wrapper">
            <div class="master-stat">
                <div class="header">
                    Disciples
                </div>
                <div class="detail">{{ number_format($data['master_disciple']) }}</div>
            </div>
            <div class="master-stat">
                <div class="header">
                    Followers
                </div>
                <div class="detail --start">
                    {{ $data['master_follower'] }}
                </div>
            </div>
            <div class="master-stat">
                <div class="header">
                    Mastered
            </div>
                <div class="detail">{{ $data['master_mastered'] }}</div>
        </div>
    </div>
        <div class="activity-story">
            @php
                $stories = \App\ActivityStory::from('activity_stories as as')
				->join('activities as act', 'as.activity_id', 'act.activity_id')
				->where('act.user_id', $data['user_id'])
				->get();
            @endphp
            @if($stories->isEmpty())
                <div class="no-act" align="center">No activity now.</div>
            @endif
            @foreach ($stories as $story)
                @php
                    $story['users_activity'] = \App\UserActivity::join('users', 'user_activities.user_id', 'users.user_id')->where('activity_id', $story['activity_id'])->where('user_activity_paid', 1)->get();
                @endphp
                <div class="activity-wrapper">
                    <div class="activity-card">
                        <div class="video-wrapper">
                            <video class="video lazy" loop muted playsinline>
                                <source data-src="{{ $story['activity_story_video'] }}"
                                        type="video/mp4" />
                            </video>
                        </div>

                        <div class="title-wrapper">
                            <div class="title" align="left">{{ $story['activity_name'] }}</div>
                            <div class="activity-join">
                                @foreach($story['users_activity'] as $usersStory)
                                    <div class="participant image-wrapper">
                                        <img src="{{ $usersStory['user_pic'] }}"
                                             alt="{{ $usersStory['user_name'] }}"
                                             onclick="window.location.href = '/user/{{ $usersStory['user_id'] }}'">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="button-wrapper my-1" align="center">
            <button class="button mr-2">Request<br>custom activity</button>
            <button class="button ml-2"
                    onclick="window.location='/master/{{ $data['master_id'] }}'">view profile
            </button>
    </div>
</div>
@endif
<!-- End Activity Detail -->
