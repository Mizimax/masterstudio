@extends('dashboard')

@section('page', 'story')

@section('style')
    <link rel="stylesheet" href="/css/dashboard.studio.css?v=1.1">
    <style>
        .svg {

        }
    </style>
@endsection

@section('content')
    <div class="studio-wrapper">

        <h3 class="mt-4">Stories</h3>
        <div class="activity-story h-100">
            @foreach ($stories as $story)
                @php
                    $storyCreated = new DateTime($story['created_at']);
                    $now = new DateTime(date("Y-m-d H:i:s"));
                    $story['story_day_ago'] = $storyCreated->diff($now);
                    $story['users_activity'] = \App\UserActivity::join('users', 'user_activities.user_id', 'users.user_id')->where('activity_id', $story['activity_id'])->where('user_activity_paid', 1)->get();
                @endphp
                <div class="activity-wrapper" style="position: relative">
                    <form method="post" action="/dashboard/story/{{ $story['activity_story_id'] }}"
                          onsubmit="return deleteStory()">
                        <input name="_method" type="hidden" value="DELETE">
                        @csrf
                        <img src="/img/icon/close.svg" class="svg close-btn">
                    </form>
                    <div class="activity-card">
                        <div class="video-wrapper">
                            <video class="video lazy" loop muted playsinline>
                                <source data-src="{{ $story['activity_story_video'] }}"
                                        type="video/mp4" />
                            </video>
                        </div>

                        <div class="title-wrapper">
                            <div class="title" align="left">{{ $story['activity_name'] }}</div>
                            <div class="activity-join">
                                @foreach($story['users_activity'] as $usersStory)
                                    <div class="participant image-wrapper">
                                        <img src="{{ $usersStory['user_pic'] }}"
                                             alt="{{ $usersStory['user_name'] }}"
                                             onclick="window.location.href = '/user/{{ $usersStory['user_id'] }}'">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="location">{{ $story['story_day_ago']->m !== 0 ? $story['story_day_ago']->m . ' months ' : '' }}{{ $story['story_day_ago']->d !== 0 ? $story['story_day_ago']->d . ' days ' : '' }}
                        @if($story['story_day_ago']->m === 0)
                            {{ $story['story_day_ago']->h !== 0 ? $story['story_day_ago']->h . ' hours' : $story['story_day_ago']->i . ' minutes' }}
                        @endif
                        ago: {{ $story['activity_location_name'] }}</div>
                </div>
            @endforeach
        </div>

        <h3 class="mt-4">Lessons</h3>
        <div class="activity-story h-100">
            @foreach ($lessons as $story)
                @php
                    $storyCreated = new DateTime($story['created_at']);
                    $now = new DateTime(date("Y-m-d H:i:s"));
                    $story['story_day_ago'] = $storyCreated->diff($now);
                    $story['users_activity'] = \App\UserActivity::join('users', 'user_activities.user_id', 'users.user_id')->where('activity_id', $story['activity_id'])->where('user_activity_paid', 1)->get();
                @endphp
                <div class="activity-wrapper" style="position: relative">
                    <form method="post" action="/dashboard/story/{{ $story['activity_story_id'] }}"
                          onsubmit="return deleteStory()">
                        <input name="_method" type="hidden" value="DELETE">
                        @csrf
                        <img src="/img/icon/close.svg" class="svg close-btn">
                    </form>
                    <div class="activity-card">
                        <div class="video-wrapper">
                            <video class="video lazy" loop muted playsinline>
                                <source data-src="{{ $story['activity_story_video'] }}"
                                        type="video/mp4" />
                            </video>
                        </div>

                        <div class="title-wrapper">
                            <div class="title" align="left">{{ $story['activity_name'] }}</div>
                            <div class="activity-join">
                                @foreach($story['users_activity'] as $usersStory)
                                    <div class="participant image-wrapper">
                                        <img src="{{ $usersStory['user_pic'] }}"
                                             alt="{{ $usersStory['user_name'] }}"
                                             onclick="window.location.href = '/user/{{ $usersStory['user_id'] }}'">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="location">{{ $story['story_day_ago']->m !== 0 ? $story['story_day_ago']->m . ' months ' : '' }}{{ $story['story_day_ago']->d !== 0 ? $story['story_day_ago']->d . ' days ' : '' }}
                        @if($story['story_day_ago']->m === 0)
                            {{ $story['story_day_ago']->h !== 0 ? $story['story_day_ago']->h . ' hours' : $story['story_day_ago']->i . ' minutes' }}
                        @endif
                        ago: {{ $story['activity_location_name'] }}</div>
                </div>
            @endforeach
        </div>

    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@12.0.0/dist/lazyload.min.js"></script>
    <script>
      function deleteStory() {
        var result = confirm('Confirm to delete?')
        if (!result) {
          return false
        }

      }

      var replaceSvg = function (callback) {
        /*
      * Replace all SVG images with inline SVG
      */
        jQuery('img.svg').each(function () {
          var $img = jQuery(this)
          var imgID = $img.attr('id')
          var imgClass = $img.attr('class')
          var imgURL = $img.attr('src')

          jQuery.get(imgURL, function (data) {
            // Get the SVG tag, ignore the rest
            var $svg = jQuery(data).find('svg')

            // Add replaced image's ID to the new SVG
            if (typeof imgID !== 'undefined') {
              $svg = $svg.attr('id', imgID)
            }
            // Add replaced image's classes to the new SVG
            if (typeof imgClass !== 'undefined') {
              $svg = $svg.attr('class', imgClass + ' replaced-svg')
            }

            // Remove any invalid XML tags as per http://validator.w3.org
            $svg = $svg.removeAttr('xmlns:a')

            // Check if the viewport is set, if the viewport is not set the SVG wont't scale.
            if (!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
              $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
            }

            // Replace image with new SVG
            $img.replaceWith($svg)

            callback()

          }, 'xml')
        })
      }

      $(document).ready(function () {
        var lazyLoadInstance = new LazyLoad({
          elements_selector: '.lazy',
          // ... more custom settings?
        })
        replaceSvg(function () {
          $('svg').off('click').on('click', function () {
            $(this).parent().submit()
          })
        })
      })
    </script>
@endsection