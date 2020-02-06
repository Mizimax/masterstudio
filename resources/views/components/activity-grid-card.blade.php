@php
    $size = !empty($size) ? $size : 80;
    $activities = !empty($queryActivities) ? $queryActivities : (!empty($activities) ? $activities : []);
@endphp
@if($activities->isEmpty() && isset($isSearching))
    <div class="activity-loading">No result.</div>
@endif
@foreach ($activities as $activity)
    @php
        if(!is_array($activity['activity_benefit'])) {
                $activity['activity_benefit'] = json_decode($activity['activity_benefit'], true);
                $activity['activity_video'] = json_decode($activity['activity_video'], true)[0];
                $activity['activity_routine_day'] = str_split($activity['activity_routine_day']);
                $start = new DateTime($activity->activity_start);
                $end = new DateTime($activity->activity_end);
                $activity['activity_time_diff'] = $start->diff($end) ;
                $activity['activity_day_left'] = $activity['activity_time_diff']->m === 0 ? $activity['activity_time_diff']->d + 1 . ' days' : $activity['activity_time_diff']->m . ' months';

    }
    @endphp
    <div class="activity-card-wrapper {{ !empty($nohover) ? 'pointer' : '' }}"
            {{ !empty($nohover) ? "onclick=window.location.href='/activity/".$activity['activity_url_name']."'" : ""}}>
        <div class="activity-card">
            <div class="video-wrapper">
                <video class="video lazy" loop muted>
                    <source data-src="{{ $activity['activity_video'] }}"
                            type="video/mp4" />
                </video>
                <div class="fadeoutpper d-none">
                    <img src="/img/icon/play-circle-solid.svg" class="svg">
                </div>
                <div class="activity-tabs">
                    <div class="icon-wrapper --join"
                         onclick="window.location.href = '/activity/{{ $activity['activity_url_name']  }}'">

                    </div>
                    <div class="icon-wrapper --pin --pinact {{ $activity['activity_pin'] !== 0 ? 'd-none' : '' }}"
                         onclick="pinActivity({{ $activity['activity_id'] }}, '{{ $activity["activity_name"] }}', this)">
                    </div>

                    <div class="icon-wrapper --unpin --pinact {{ $activity['activity_pin'] === 0 ? 'd-none' : '' }}"
                         onclick="unpinActivity({{ $activity['activity_id'] }}, '{{ $activity["activity_name"] }}', this)">
                    </div>

                    <div class="icon-wrapper --share" tabindex="-1">
                        <div class="share-dropdown">\
                            <div class="icon-wrapper --dropdown --copy" onclick="copy()"
                                 data-toggle="tooltip" data-placement="bottom"
                                 title="Click to copy">
                            </div>
                            <div class="icon-wrapper --dropdown --facebook" onclick="facebook()"
                                 data-toggle="tooltip" data-placement="bottom"
                                 title="Facebook share">
                            </div>
                            <div class="icon-wrapper --dropdown --email" onclick="email()"
                                 data-toggle="tooltip" data-placement="bottom" title="Email share">
                            </div>
                        </div>
                        <textarea style="opacity:0; height: 0; padding: 0;" id="url"></textarea>
                    </div>

                </div>
            </div>
            <div class="overlay activity-overlay --hover"></div>
            <div class="master-profile">
                @if(empty($nohover))
                    @component('components.activity-card', ['noimage'=>true, 'size'=>$size, 'animate'=>true, 'activity' => $activity])
                    @endcomponent
                @endif
                <div class="image-wrapper" style="width: {{$size/1.2}}px; height: {{$size/1.2}}px">
                    <img src="{{ $activity['user_pic'] }}" alt="{{ $activity['master_name'] }}">
                </div>

                @if(empty($nohover))
                    <button class="button --detail d-none"
                            onclick="window.location.href = '/activity/{{ $activity['activity_url_name']  }}'">
                        view detail
                    </button>
                @endif
            </div>

            <div class="title-wrapper">
                <div class="title">{{ $activity['activity_name'] }}</div>
            </div>
        </div>
    </div>
@endforeach
