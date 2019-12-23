@extends('app')

@section('title', 'Studio')
@section('page', 'home')

@section('style')
    <link rel="stylesheet" href="/css/profile.css">
@endsection

@section('content')
    <div class="profile-wrapper">
        <div class="profile-container">
            <div class="profile-card-wrapper">
                <div class="profile-image">
                    <img class="image" src="{{ $user['user_pic'] }}" alt="">
                </div>
                <div class="profile-detail">
                    <h1 class="name">{{ $user['user_name'] }}</h1>
                    <span>user lvl : {{ $user['user_level'] }}</span>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar"
                             style="width: 50%" aria-valuenow="50"
                             aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    {{--                    <span>Active on</span>--}}
                </div>
                <div class="profile-detail-badge {{ $me ? 'align-self-center' : '' }}">
                    <div class="profile-action">
                        {{--                        <div class="follow-icon">--}}
                        {{--                            <img src="/img/icon/caret-down-solid.svg" alt="Follow ..." class="svg">--}}
                        {{--                        </div>--}}
                        @if(!$me)
                            @if(!$isFollower)
                                <form action="{{ url()->current() }}" method="post">
                                    @endif
                                    @csrf
                                    <button class="follow-btn {{ $isFollower ? 'followed' : '' }}">{{ $isFollower ? 'Followed' : '+ Follow' }}</button>
                                </form>
                            @endif
                    </div>
                    <div class="master-stat-wrapper">
                        <div class="master-stat">
                            <div class="header">
                                Followers
                            </div>
                            <div class="detail">{{ $followers - 1 }}</div>
                        </div>
                        <div class="master-stat">
                            <div class="header">
                                Masters
                            </div>
                            <div class="detail">{{ $masters }}</div>
                        </div>
                        <div class="master-stat">
                            <div class="header">
                                Activities
                            </div>
                            <div class="detail">{{ count($nowActivities) + count($pastActivities) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @if($isFollower)
                <div class="profile-card-wrapper --timeline" style="display: block">
                    <div class="header-tab">
                        @include('components.category-interest', ['active' => true, 'me' => $me ? 1 : 2])
                        <div class="achievement-tab d-none">
                            <div class="achievement">Achievement</div>
                            <div id="achievement" class="d-flex flex-grow-1"></div>
                        </div>
                    </div>
                    <div id="category-timeline" class="category-timeline-wrapper"></div>
                </div>
            @endif
            <div class="profile-card-wrapper" style="display: block">
                <div class="nav-tab nav nav-pill">
                    <a class="tab-link active" href="#activity" role="tab"
                       data-toggle="tab">{{ $me ? 'Your' : 'User' }}
                        Activities</a>
                    <a class="tab-link" href="#gallery" role="tab" data-toggle="tab">Gallery</a>
                    <a class="tab-link" href="#studio" role="tab" data-toggle="tab">Visited</a>
                    <a class="tab-link" href="#suggest" role="tab" data-toggle="tab">Followed
                        master</a>
                </div>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active show" id="activity">
                        <div class="activity-wrapper">
                            <div class="now-activity">
                                <div class="header">Now Activities</div>
                                <div class="content">
                                    @include('components.activity-grid-card', ['activities'=>$nowActivities, 'size' => 80, 'nohover' => '55'])
                                </div>

                            </div>
                            <div class="past-activity">
                                <div class="header">Past Activitie</div>
                                <div class="content">
                                    @include('components.activity-grid-card', ['activities'=>$pastActivities, 'size' => 80, 'nohover' => '55'])
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade in" id="gallery">
                        <div class="gallery-wrapper">
                            <div class="gallery-flex">
                                <img src="/img/Deepsea.jpeg" class="image">
                                <img src="/img/Deepsea.jpeg" class="image">
                                <img src="/img/Deepsea.jpeg" class="image">
                                <img src="/img/Deepsea.jpeg" class="image">
                                <img src="/img/Deepsea.jpeg" class="image">
                                <img src="/img/Deepsea.jpeg" class="image">
                            </div>
                            <div class="gallery-flex --second">
                                <img src="/img/Deepsea.jpeg" class="image">
                                <img src="/img/Deepsea.jpeg" class="image">
                                <img src="/img/Deepsea.jpeg" class="image">
                                <img src="/img/Deepsea.jpeg" class="image">
                                <img src="/img/Deepsea.jpeg" class="image">
                                <img src="/img/Deepsea.jpeg" class="image">
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="studio">
                        @include('components.map', ['active' => true, 'me' => $me ? 1 : 2])
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="suggest"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@12.0.0/dist/lazyload.min.js"></script>
    <script>

      $(document).ready(function () {
        var lazyLoadInstance = new LazyLoad({
          elements_selector: '.lazy',
          // ... more custom settings?
        })

        $('.add-interest-activity > .search-dropdown > .search-result').click(function () {
          var categoryName = $(this).children('.category').text()
          var categoryPic = $(this).children('.svg')[0].outerHTML
          var categoryId = parseInt($(this).children('.category-id').val(), 10)

          $.ajax({
            url: '/api/category/' + categoryId,
            type: 'post',
            dataType: 'json',
            processData: false,
            contentType: 'application/json',
            data: JSON.stringify({
              '_token': $('meta[name="csrf-token"]').attr('content'),
            }),
          })

          var html = `
       <div class="interest-activity" tabindex="-1" onclick="$(this).toggleClass('active')">
            <div class="icon">
                ${categoryPic}
            </div>
            <div class="name">${categoryName}</div>
       </div>
    `

          MasterStudio.myCategory = { categoryId, categoryName, categoryPic }
          $('.category-interest > .interest-group').append(html)

          if ($(this).parent().children().length !== 1) {
            $(this).remove()
          } else {
            $(this).parent().text('You already selected all categories.')
          }

        })

        $.ajax({
          url: 'http://localhost/content/timeline/1/' + '{{ $user['user_id'] }}',
          type: 'get',
          processData: false,
          contentType: 'application/json',
          data: JSON.stringify({
            '_token': $('meta[name="csrf-token"]').attr('content'),
          }),
          success: function (data) {
            $('#category-timeline').html(data)
            var lazyLoadInstance = new LazyLoad({
              elements_selector: '.lazy',
              // ... more custom settings?
            })
            $('.activity-story > .video').hover(function () {
              $(this).get(0).play()
            }, function () {
              $(this).get(0).pause()
            })
          },
          error: function (error) {
            console.log(error)
            $('.profile-card-wrapper.--timeline').addClass('d-none')
          },
        })

        $.ajax({
          url: 'http://localhost/content/achievement/1/' + '{{ $user['user_id'] }}',
          type: 'get',
          processData: false,
          contentType: 'application/json',
          data: JSON.stringify({
            '_token': $('meta[name="csrf-token"]').attr('content'),
          }),
          success: function (data) {

            $('#achievement').html(data)
            $('#achievement').parent().removeClass('d-none')

          },
          error: function (error) {
            console.log(error)
            $('#achievement').html('')
            $('#achievement').parent().addClass('d-none')
            $('.category-interest')
          },
        })

        $('.master-profile').hover(function () {
          $(this).children('.activity-detail').fadeIn()
        }, function () {
          $(this).children('.activity-detail').fadeOut()
        })

        $('.interest-activity').click(function () {
          $('.interest-activity.active').removeClass('active')
          $(this).toggleClass('active')
          var categorySelected = $(this).children('#category-id').val()

          $.ajax({
            url: 'http://localhost/content/timeline/' + categorySelected + '/' + '{{ $user['user_id'] }}',
            type: 'get',
            processData: false,
            contentType: 'application/json',
            data: JSON.stringify({
              '_token': $('meta[name="csrf-token"]').attr('content'),
            }),
            success: function (data) {
              $('#category-timeline').html(data)
              var lazyLoadInstance = new LazyLoad({
                elements_selector: '.lazy',
                // ... more custom settings?
              })
              $('.activity-story > .video').hover(function () {
                $(this).get(0).play()
              }, function () {
                $(this).get(0).pause()
              })
            },
          })

          $.ajax({
            url: 'http://localhost/content/achievement/' + categorySelected + '/' + '{{ $user['user_id'] }}',
            type: 'get',
            processData: false,
            contentType: 'application/json',
            data: JSON.stringify({
              '_token': $('meta[name="csrf-token"]').attr('content'),
            }),
            success: function (data) {
              $('#achievement').html(data)
            },
            error: function (error) {
              console.log(error)
            },
          })
        })

      })
    </script>
@endsection
