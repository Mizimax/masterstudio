@if($nowActivities->isEmpty() && $pastActivities->isEmpty())
    <div style="padding:100px; font-size: 25px" align="center">No activity now.</div>
@endif
@if(!$nowActivities->isEmpty())
    <h3 class="header">Your next activity</h3>
    @foreach($nowActivities as $nowActivity)
        @php
            $videos = json_decode($nowActivity['activity_video'], true);
            $pics = json_decode($nowActivity['activity_pic'], true);
            $video = count($videos) !== 0 ? $videos[0] : '';
            $pic = count($pics) !== 0 ? $videos[0] : '';
        @endphp
        <div class="my-activity-card">
            <div class="image-wrapper">
                @if($pic !== '')
                    <img class="image" src="{{ $pic }}">
                @else
                    <video class="image" loop muted>
                        <source src="{{ $video }}"
                                type="video/mp4" />
                    </video>
                @endif
            </div>
            <div class="description">
                <h3 class="header">{{ $nowActivity['activity_name'] }}</h3>
                <p class="content">
                    Date start : {{ $nowActivity['activity_start'] }}<br />
                    Period : Every sunday 4 week<br />
                    Master : {{ $nowActivity['master_name'] }}
                </p>
            </div>
            <div class="action">
                <span class="price-status">{{ number_format($nowActivity['activity_price']) }} Bath {{ $nowActivity['user_activity_paid'] === 0 ? 'Interested' : 'Paid' }}</span>
                @if($nowActivity['user_activity_paid'] === 0)
                    <button class="pay-button" onclick="modal('join')">Pay now</button>
                    <button class="pay-button --outline"
                            onclick="window.location.href='/activity/{{ $nowActivity['activity_url_name'] }}'">
                        View activity detail
                    </button>
                @endif
                @if($nowActivity['user_activity_paid'] === 1)
                    <button class="pay-button"
                            onclick="window.location.href='/activity/{{ $nowActivity['activity_url_name'] }}'">
                        View activity detail
                    </button>
                    <button class="pay-button --outline">Cancel booked</button>
                @endif
            </div>
        </div>
    @endforeach
@endif
@if(!$pastActivities->isEmpty())
    <h3 class="header">Your passed activity</h3>
    @foreach($pastActivities as $pastActivity)
        @php
            $videos = json_decode($pastActivity['activity_video'], true);
            $pics = json_decode($pastActivity['activity_pic'], true);
            $video = count($videos) !== 0 ? $videos[0] : '';
            $pic = count($pics) !== 0 ? $videos[0] : '';
        @endphp
        <div class="my-activity-card">
            <div class="image-wrapper">
                @if($pic !== '')
                    <img class="image" src="{{ $pic }}">
                @else
                    <video class="image" loop muted>
                        <source src="{{ $video }}"
                                type="video/mp4" />
                    </video>
                @endif
            </div>
            <div class="description">
                <h3 class="header">{{ $pastActivity['activity_name'] }}</h3>
                <p class="content">
                    Date start : {{ $pastActivity['activity_start'] }}<br />
                    Period : Every sunday 4 week<br />
                    Master : {{ $pastActivity['master_name'] }}
                </p>
            </div>
            <div class="action">
                <span class="price-status">{{ number_format($pastActivity['activity_price']) }} Bath paid</span>
                <button class="pay-button">View activity detail</button>
                <button class="pay-button --orange" onclick="window.locaiton">View progress</button>
            </div>
        </div>
    @endforeach
@endif