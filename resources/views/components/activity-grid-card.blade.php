@php
    $size = !empty($size) ? $size : 100;
    $activities = !empty($queryActivities) ? $queryActivities : (!empty($activities) ? $activities : '');
@endphp
@foreach ($activities as $activity)
    <div class="activity-card-wrapper">
        <div class="activity-card">
            <div class="video-wrapper">
                <video class="video lazy" loop muted>
                    <source data-src="https://maxang.me/activity.mp4"
                            type="video/mp4" />
                </video>
                <div class="fadeoutpper d-none">
                    <img src="/img/icon/play-circle-solid.svg" class="svg">
                </div>
                <button class="button --detail" onclick="window.location.href = '/activity/1'">view detail</button>
                <div class="activity-tabs">
                    <div class="icon-wrapper --join">

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
                @component('components.activity-card', ['noimage'=>true, 'size'=>$size, 'animate'=>true])
                @endcomponent
                <div class="image-wrapper" style="width: {{$size/1.2}}px; height: {{$size/1.2}}px">
                    <img src="/img/profile.jpg" alt="">
                </div>
            </div>

            <div class="title-wrapper">
                <div class="title">Basic Italian Food</div>
            </div>
        </div>
    </div>
@endforeach
