@php
    $stories = !empty($queryStories) ? $queryStories : (!empty($stories) ? $stories : '');
@endphp
<div class="activity-story {{!empty($hover) && $hover ? '--hover': ''}}">
    @foreach ($stories as $story)
        <div class="activity-wrapper">
            <div class="activity-card">
                <div class="video-wrapper">
                    <video class="video lazy" loop muted>
                        <source data-src="https://maxang.me/activity.mp4"
                                type="video/mp4"/>
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
