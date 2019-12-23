@php
    $stories = !empty($queryStories) ? $queryStories : (!empty($stories) ? $stories : '');
@endphp
<div class="activity-story {{!empty($hover) && $hover ? '--hover': ''}}">
    @foreach ($stories as $story)
        @php
            $story['users_activity'] = \App\UserActivity::join('users', 'user_activities.user_id', 'users.user_id')->where('activity_id', $story['activity_id'])->get();
        @endphp
        <div class="activity-wrapper">
            <div class="activity-card">
                <div class="video-wrapper">
                    <video class="video lazy" loop muted>
                        <source data-src="{{ $story['activity_story_video'] }}"
                                type="video/mp4"/>
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
