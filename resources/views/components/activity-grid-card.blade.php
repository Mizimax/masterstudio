@php
    $size = !empty($size) ? $size : 80;
    $activities = !empty($queryActivities) ? $queryActivities : (!empty($activities) ? $activities : []);
@endphp
@foreach ($activities as $activity)
    @php
        $activity['activity_benefit'] = json_decode($activity['activity_benefit'], true);
        $activity['activity_video'] = json_decode($activity['activity_video'], true)[0];
        $activity['activity_routine_day'] = str_split($activity['activity_routine_day']);
        $start = new DateTime($activity->activity_start);
        $end = new DateTime($activity->activity_end);
        $activity['activity_time_diff'] = $start->diff($end) ;
        $activity['activity_day_left'] = $activity['activity_time_diff']->m === 0 ? $activity['activity_time_diff']->d + 1 . ' days' : $activity['activity_time_diff']->m . ' months';
    @endphp
    <div class="activity-card-wrapper"
         onclick="window.location.href='/activity/{{ $activity['activity_url_name'] }}'">
        <div class="activity-card">
            <div class="video-wrapper">
                <video class="video lazy" loop muted>
                    <source data-src="{{ $activity['activity_video'] }}"
                            type="video/mp4" />
                </video>
                <div class="fadeoutpper d-none">
                    <img src="/img/icon/play-circle-solid.svg" class="svg">
                </div>
                @if(empty($nohover))
                    <button class="button --detail"
                            onclick="window.location.href = '/activity/{{ $activity['activity_url_name']  }}'">
                        view detail
                    </button>
                @endif
                <div class="activity-tabs">
                    <div class="icon-wrapper --join"
                         onclick="window.location.href = '/activity/{{ $activity['activity_url_name']  }}'">

                    </div>
                    <div class="icon-wrapper --pin">

                    </div>
                    <div class="icon-wrapper --invite">

                    </div>
                    <div class="icon-wrapper --share">

                    </div>
                </div>
            </div>
            <div class="overlay"></div>
            <div class="master-profile">
                @if(empty($nohover))
                    @component('components.activity-card', ['noimage'=>true, 'size'=>$size, 'animate'=>true, 'activity' => $activity])
                    @endcomponent
                @endif
                <div class="image-wrapper" style="width: {{$size/1.2}}px; height: {{$size/1.2}}px">
                    <img src="{{ $activity['user_pic'] }}" alt="{{ $activity['master_name'] }}">
                </div>
            </div>

            <div class="title-wrapper">
                <div class="title">{{ $activity['activity_name'] }}</div>
            </div>
        </div>
    </div>
@endforeach
