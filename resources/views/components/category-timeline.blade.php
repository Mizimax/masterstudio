<div class="category-timeline">
    @if(!$onlyTimeline)
        <div class="your-info">
            <span class="level">LV. {{ $ugInfo['user_level'] }}</span>
            <div class="progress">
                <div class="progress-bar" role="progressbar"
                     style="width: {{ $ugInfo['user_exp'] / $ugInfo['user_exp_max'] * 100 }}%"
                     aria-valuenow="{{ $ugInfo['user_exp'] / $ugInfo['user_exp_max'] * 100 }}"
                     aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <span class="timespend-badge">Time spend</span>
            <span class="timespend">{{ $ugInfo['user_hour'] }} hours</span>
            <span class="category">{{ $ugInfo['category_name'] }}</span>
        </div>
    @endif
    <div class="activity-timeline">
        <hr class="line">
        <div class="activity-line">
            <div class="your-timeline">
                <div class="title"><span class="name">{{ $me ? 'Your' : $user['user_name'] }}</span>
                    Timeline
                </div>
                <img class="image" src="{{ $user['user_pic'] }}"
                     alt="{{ $user['user_name'] }}">
            </div>
            @foreach($timelines as $timeline)
                <div class="activity-story-lesson">
                    <video class="video image lazy" loop muted playsinline>
                        <source data-src="{{ $timeline['activity_story_video'] }}"
                                type="video/mp4" />
                    </video>
                    <div class="name" align="center">{{ $timeline['activity_name']  }}</div>
                </div>
            @endforeach
        </div>
        @if($me)
            <div class="add-button">
                <img src="/img/icon/plus-solid.svg" class="svg">
            </div>
        @endif
    </div>
</div>