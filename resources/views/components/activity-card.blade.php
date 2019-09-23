<!-- Activity Detail -->
@php
    $size = !empty($size) ? $size : 100;
@endphp
<div style="padding: {{ $size/8 }}px"
     class="activity-detail {{!empty($animate) ? '--animate' : '' }} justify-content-between flex-wrap">
    <div class="activity-title" style="margin-left: 5px">
        <div class="image-wrapper" style="margin-top: -{{ $size/2.1 }}px; width: {{ $size }}px; height: {{ $size }}px">
            @if(empty($noimage))
                <img style="width: {{ $size }}px; height: {{ $size }}px" src="/img/profile.jpg" alt="">
            @endif
        </div>
        <div class="title-wrapper" style="margin-left: {{ $size/6 }}px">
            <div class="title">Mistrio Waso</div>
            <div class="badge">Italian food master</div>
        </div>
    </div>
    <div class="activity-content">
        <h3 class="header" style="font-size: {{ $size/4 }}px">The spirit of ingredient</h3>
        <div class="row result-course no-gutters">
            <div class="col text-center">
                <div class="image-wrapper">
                    <img src="/img/profile.jpg" style="width: {{ $size/2.5 }}px; height: {{ $size/2.5 }}px" alt="">
                </div>
                <div class="text">secret of ingredients</div>
            </div>
            <div class="col text-center">
                <div class="image-wrapper">
                    <img src="/img/profile.jpg" style="width: {{ $size/2.5 }}px; height: {{ $size/2.5 }}px" alt="">
                </div>
                <div class="text">secret of ingredients</div>
            </div>
            <div class="col text-center">
                <div class="image-wrapper">
                    <img src="/img/profile.jpg" style="width: {{ $size/2.5 }}px; height: {{ $size/2.5 }}px" alt="">
                </div>
                <div class="text">secret of ingredients</div>
            </div>
        </div>
    </div>
    <div class="activity-add">
        <div class="time-location">
            <div class="header-title">
                <div class="header">
                    Register until
                </div>
                <div class="detail">10 Dec 2019</div>
            </div>
            <div class="header-title">
                <div class="header">
                    Start at
                </div>
                <div class="detail --start">
                    10 Dec 2019<br>
                    10 Dec 2019<br>
                    10 Dec 2019
                </div>
            </div>
            <div class="header-title">
                <div class="header">
                    Location
                </div>
                <div class="detail">10 Dec 2019</div>
            </div>
        </div>
        <div class="badge-wrapper my-1">
            <div class="badge mr-2">3 month activity</div>
            <div class="badge">Basic - Intermediate</div>
        </div>
    </div>
</div>
<!-- End Activity Detail -->
