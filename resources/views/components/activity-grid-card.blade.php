@php
    $activities = !empty($queryActivities) ? $queryActivities : (!empty($activities) ? $activities : '');
@endphp
@foreach ($activities as $activity)
    <div class="activity-card-wrapper">
        <div class="activity-card">
            <div class="video-wrapper">
                <video class="video lazy" loop muted>
                    <source data-src="/video/activity.mp4"
                            type="video/mp4" />
                </video>
                <div class="play-wrapper">
                    <img src="/img/icon/play-circle-solid.svg" class="svg">
                </div>
                <button class="button --detail" onclick="window.location.href = '/activity/1'">view detail</button>
                <div class="activity-tabs">
                    <div class="icon-wrapper --join">
                        <img src="/img/icon/user-circle-regular.svg" class="svg">
                    </div>
                    <div class="icon-wrapper --pin">
                        <img src="/img/icon/user-circle-regular.svg" class="svg">
                    </div>
                    <div class="icon-wrapper --invite">
                        <img src="/img/icon/user-circle-regular.svg" class="svg">
                    </div>
                </div>
            </div>
            <div class="overlay"></div>
            <div class="master-profile">
                @component('components.activity-card', ['noimage'=>true, 'size'=>75])
                @endcomponent
                <div class="image-wrapper">
                    <img src="/img/profile.jpg" alt="">
                </div>
            </div>

            <div class="title-wrapper">
                <div class="title">Basic Italian Food</div>
            </div>
        </div>
    </div>
@endforeach
