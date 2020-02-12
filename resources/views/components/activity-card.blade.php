<!-- Activity Detail -->
@php
    $size = !empty($size) ? $size : 100;
    $benefits = json_decode('[{"pic":"/img/profile.jpg","bg":"/img/Deepsea.jpg","name":"Benefit 1","text":"Benefit 1 description"},{"pic":"/img/profile.jpg","bg":"/img/Deepsea.jpg","name":"Benefit 1","text":"Benefit 1 description"},{"pic":"/img/profile.jpg","bg":"/img/Deepsea.jpg","name":"Benefit 1","text":"Benefit 1 description"}]', true);
    $activity = !empty($activity) ?
                        $activity : [
                            'master_name' => 'test name',
                            'category_name' => 'category',
                            'activity_name' => 'Activity name test',
                            'activity_benefit' => $benefits,
                            'activity_time_diff' => (object) ['m'=> 20],
                            'activity_difficult' => 'Intermediate',
                            'activity_apply_end' => '2019-02-02',
                            'activity_start' => '2019-02-03',
                            'activity_location_name' => 'Sanarmbad',
                            'activity_time_type' => 0,
                            'activity_routine_day' => ["1","2"],
                            'activity_time_start' => '12:00',
                            'activity_time_end' => '18:00',
                            'activity_day_left' => '12 days',
                        ];
@endphp
@if(!empty($activity))
    <div class="activity-detail {{!empty($animate) ? '--fade' : '' }} justify-content-between flex-wrap"
         style="max-width: 290px">
        <div class="activity-title" style="margin-left: 5px">
            <div class="image-wrapper"
                 style="margin-top: -{{ $size/2.1 }}px; width: {{ $size }}px; height: {{ $size }}px">
                @if(empty($noimage))
                    <img style="width: {{ $size }}px; height: {{ $size }}px; cursor: pointer"
                         src="{{ $activity['user_pic'] }}"
                         alt=""
                         onclick="window.location.href='/master/{{ $activity['master_id'] }}'">
                @endif
            </div>
            <div class="title-wrapper" style="margin-left: {{ $size/6 }}px" align="left">
                <div class="title" style="cursor: pointer;"
                     onclick="window.location.href='/master/{{ $activity['master_id'] }}'">{{ $activity['master_name'] }}</div>
                <div class="badge">{{ $activity['category_name'] }} master</div>
            </div>
        </div>
        <div class="activity-content">
            <h3 class="header"
                style="font-size: {{ $size/4 }}px">{{ $activity['activity_name'] }}</h3>

            <div class="row result-course no-gutters">
                @foreach($activity['activity_benefit'] as $benefit)
                    <div class="col text-center">
                        <div class="image-wrapper">
                            <img src="{{ $benefit['pic'] }}"
                                 style="width: {{ $size/2 }}px; height: {{ $size/2 }}px" alt="">
                        </div>
                        <div class="text">{{ $benefit['name'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="activity-add">
            <div class="time-location">
                <div class="header-title">
                    <div class="header">
                        Register until
                    </div>
                    <div class="detail">{{ $activity['activity_apply_end'] }}</div>
                </div>
                <div class="header-title">
                    <div class="header">
                        Start at
                    </div>
                    <div class="detail --start">
                        {{ $activity['activity_start'] }}<br>
                        {{ $activity['activity_time_type'] === 1 ? 'Every ' : '' }}
                        @foreach($activity['activity_routine_day'] as $day)
                            {{ toDayText($day) }}{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                        <br>
                        {{ $activity['activity_time_start'] . ' - ' . $activity['activity_time_end'] }}
                    </div>
                </div>
                <div class="header-title">
                    <div class="header">
                        Location
                    </div>
                    <div class="detail">{{ $activity['activity_location_name'] }}</div>
                </div>
            </div>
            <div class="badge-wrapper">
                <div class="badge mr-2">
                    @if($activity['activity_time_type'] === 1)
                        Routine
                    @else
                        {{ $activity['activity_day_left'] }}
                    @endif
                    activity
                </div>
                <div class="badge">Difficult - {{ $activity['activity_difficult'] }}</div>
            </div>
        </div>
    </div>
    <!-- End Activity Detail -->
@endif
