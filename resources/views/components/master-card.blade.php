<!-- Activity Detail -->
@php
    $size = !empty($size) ? $size : 100;
    $data = [1];
@endphp
@if(!empty($data))
    <div class="activity-detail {{!empty($animate) ? '--animate' : '' }} justify-content-between flex-wrap">
    <div class="activity-title">
        <div class="image-wrapper" style="margin-top: -{{ $size/2 }}px; width: {{ $size }}px; height: {{ $size }}px">
            @if(empty($noimage))
                <img style="width: {{ $size }}px; height: {{ $size }}px" src="/img/profile.jpg" alt="">
            @endif
        </div>
        <div class="title-wrapper">
            <div class="title">Mistrio Waso</div>
            <div class="badge">Italian food master</div>
        </div>
        <div class="follow-wrapper">
            <div class="follow-icon">
                <img src="/img/icon/caret-down-solid.svg" alt="Follow ..." class="svg">
            </div>
            <div class="text">Follow</div>
        </div>
    </div>
        <div class="master-stat-wrapper">
            <div class="master-stat">
                <div class="header">
                    Disciples
                </div>
                <div class="detail">700</div>
            </div>
            <div class="master-stat">
                <div class="header">
                    Followers
                </div>
                <div class="detail --start">
                    2,000
            </div>
            </div>
            <div class="master-stat">
                <div class="header">
                    Mastered
            </div>
                <div class="detail">4</div>
        </div>
    </div>
        <div class="activity-story">
            @php
                $activitys = [0,1,2,3,4,5,6,7,8,9,10]
            @endphp
            @foreach ($activitys as $activity)
                <div class="activity-wrapper">
                    <div class="activity-card">
                        <div class="video-wrapper">
                            <video class="video lazy" loop muted>
                                <source data-src="/video/activity.mp4"
                                        type="video/mp4" />
                            </video>
                        </div>

                        <div class="title-wrapper">
                            <div class="title">Basic Italian Food</div>
                            <div class="activity-join">
                                <div class="participant image-wrapper">
                                    <img src="/img/profile.jpg" alt="">
                                </div>
                                <div class="participant image-wrapper">
                                    <img src="/img/profile.jpg" alt="">
                                </div>
                                <div class="participant image-wrapper">
                                    <img src="/img/profile.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="button-wrapper my-1" align="center">
            <button class="button mr-2">Request<br>custom activity</button>
            <button class="button ml-2">view profile</button>
    </div>
</div>
@endif
<!-- End Activity Detail -->
