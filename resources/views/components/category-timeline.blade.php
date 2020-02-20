<div class="category-timeline">
    @if($timelines->isEmpty())
        <div class="your-info">
            <span class="level">LV. 1</span>
            <div class="progress">
                <div class="progress-bar" role="progressbar"
                     style="width: 50%" aria-valuenow="50"
                     aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <span class="timespend-badge">Time spend</span>
            <span class="timespend">0 hours</span>
            <span id="category-name" class="category"></span>
        </div>
    @else
        <div class="your-info">
            <span class="level">LV. {{ $timelines[0]['user_level'] }}</span>
            <div class="progress">
                <div class="progress-bar" role="progressbar"
                     style="width: 50%" aria-valuenow="50"
                     aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <span class="timespend-badge">Time spend</span>
            <span class="timespend">{{ $timelines[0]['user_hour'] }} hours</span>
            <span class="category">{{ $timelines[0]['category_name'] }}</span>
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
                <div class="activity-story">
                    <video class="video image lazy" loop muted>
                        <source data-src="{{ $timeline['activity_story_video'] }}"
                                type="video/mp4" />
                    </video>
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