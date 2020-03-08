<div class="activity-story {{!empty($hover) && $hover ? '--hover': ''}} h-100">
    @if($stories->isEmpty())
        @if(isset($me))
            <div class="no-story">
                <img src="/img/icon/camera-solid.svg" class="svg">
                <p class="title">Share your first journey. Click!</p>
                <br>
            </div>
        @endif
    @endif
    @foreach ($stories as $story)
        @php
            $storyCreated = new DateTime($story['created_at']);
            $now = new DateTime(date("Y-m-d H:i:s"));
            $story['story_day_ago'] = $storyCreated->diff($now);
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
            <div class="location">{{ $story['story_day_ago']->d !== 0 ? $story['story_day_ago']->d . ' days ' : '' }}{{ $story['story_day_ago']->h !== 0 ? $story['story_day_ago']->h . ' hours' : $story['story_day_ago']->i . ' minutes' }}
                ago: {{ $story['activity_location_name'] }}</div>
        </div>
    @endforeach
</div>
