@php
    $categories = \App\Category::get();
    $user['user_gallery'] = json_decode($user['user_gallery'], true);
@endphp
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
                    <img id="image-profile" class="image" src="{{ $user['user_pic'] }}" alt="">
                    @if($me)
                        <div class="edit-wrapper" tabindex="-1">
                            <div class="edit-pic">
                                <img class="icon" src="/img/icon/edit.png">
                            </div>
                            <input type="file" accept="image/*" id="profile-img">
                            <div class="edit-dropdown">
                                <div class="edit-menu edit">Change profile
                                    picture
                                </div>
                                <div class="edit-menu" onclick="deleteProfile()">Delete profile
                                    picture
                                </div>
                            </div>
                        </div>
                    @endif
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
                            <div class="detail">{{ count($masters) }}</div>
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
            <div class="nav-tab nav nav-pill justify-content-sm-center justify-content-start flex-nowrap d-none d-sm-flex"
                 align="center">
                <a class="tab-link active" href="#activity" role="tab"
                   data-toggle="tab">{{ $me ? 'Your' : 'User' }}
                    Activities</a>
                <a class="tab-link" href="#gallery" role="tab" data-toggle="tab">Gallery</a>
                <a class="tab-link" href="#studio" role="tab" data-toggle="tab">Visited</a>
                <a class="tab-link" href="#suggest" role="tab" data-toggle="tab">Followed
                    master</a>
            </div>
            <div class="nav-tab-mobile nav-tab nav nav-pill justify-content-sm-center justify-content-start flex-nowrap d-flex d-sm-none"
                 align="center">
                <a order="1" class="tab-link col-sm-auto col-4 active" href="#activity"
                   role="tab"
                   data-toggle="tab">{{ $me ? 'Your' : 'User' }}
                    Activities</a>
                <a order="2" class="tab-link col-sm-auto col-4" href="#gallery" role="tab"
                   data-toggle="tab">Gallery</a>
                <a order="3" class="tab-link col-sm-auto col-4" href="#studio" role="tab"
                   data-toggle="tab">Visited</a>
                <a order="4"
                   class="tab-link col-sm-auto col-4" href="#suggest" role="tab"
                   data-toggle="tab">Followed master</a>
            </div>
            <div class="profile-card-wrapper" style="display: block">
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active show" id="activity">
                        <div class="activity-wrapper">
                            <div class="now-activity">
                                <div class="header">Now Activities</div>
                                <div class="content">
                                    @if($nowActivities->isEmpty())
                                        <div class="no-act">No activity now.</div>
                                    @endif
                                    <div class="activity-wrapper">
                                        @include('components.activity-grid-card', ['size' => 80, 'nohover' => '55', 'activities'=>$nowActivities])
                                    </div>
                                </div>

                            </div>
                            <div class="past-activity">
                                <div class="header">Past Activitie</div>
                                <div class="content">
                                    @if($pastActivities->isEmpty())
                                        <div class="no-act">No activity now.</div>
                                    @endif
                                    <div class="activity-wrapper">
                                        @include('components.activity-grid-card', ['size' => 80, 'nohover' => '55', 'activities'=>$pastActivities])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade in" id="gallery">
                        <div class="gallery-wrapper">
                            <div class="gallery-flex --first">
                                @php
                                    $count = count($user['user_gallery']);
                                    if(count($user['user_gallery']) === 1)
                                        $count = 2;
                                @endphp
                                @for($i = 0; $i < floor($count/2); $i++)
                                    <div class="image-container {{ $me ? 'me' : '' }}"
                                         tabindex="-1">
                                        <img src="{{ $user['user_gallery'][$i] }}"
                                             class="image">
                                        @if($me)
                                            <button class="delete-btn"
                                                    onclick="deletePicGallery({{ $i }}, this)"></button>
                                        @endif
                                    </div>
                                @endfor
                            </div>
                            <div class="gallery-flex --second">
                                @for($i = floor(count($user['user_gallery'])/2); $i < count($user['user_gallery']); $i++)
                                    <div class="image-container {{ $me ? 'me' : '' }}"
                                         tabindex="-1">
                                        <img src="{{ $user['user_gallery'][$i] }}"
                                             class="image">
                                        @if($me)
                                            <button class="delete-btn"
                                                    onclick="deletePicGallery({{ $i }}, this)"></button>
                                        @endif
                                    </div>
                                @endfor
                            </div>

                        </div>
                        @if($me)
                            <div class="add-button">
                                <img src="/img/icon/plus-solid.svg" class="svg">
                                <input type="file" accept="image/*" class="add-file">
                            </div>
                        @endif
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="studio">

                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="suggest">
                        <div class="follow-wrapper" style="margin-top: 20px">
                            @foreach($masters as $master)
                                <div class="followed-master col-sm-6 col-md-3 col-12"
                                     onclick="window.location.href='/master/{{ $master['master_id'] }}'">
                                    <div class="image-wrapper">
                                        <img src="{{ $master['user_pic'] }}" alt="">
                                    </div>
                                    <div class="name">{{ $master['master_name'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
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
          url: '/content/timeline/1/' + '{{ $user['user_id'] }}',
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
          url: '/content/achievement/1/' + '{{ $user['user_id'] }}',
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

        var curTrans = 33.33

        $('.nav-tab-mobile > .tab-link').click(function () {
          var curOrder = parseInt($('.nav-tab-mobile >.tab-link.active').attr('order'))
          var targetOrder = parseInt($(this).attr('order'))
          var result = targetOrder - curOrder
          var trans = curTrans - 33.33 * result
          curTrans = trans
          console.log('>> curTrans: ', curTrans)
          $(this).parent().css('transform', 'translateX(' + trans + '%)')
        })

        $('.interest-activity').click(function () {
          $('.interest-activity.active').removeClass('active')
          $(this).toggleClass('active')
          var categorySelected = $(this).children('#category-id').val()

          $.ajax({
            url: '/content/timeline/' + categorySelected + '/' + '{{ $user['user_id'] }}',
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
            url: '/content/achievement/' + categorySelected + '/' + '{{ $user['user_id'] }}',
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

        $('#profile-img').change(function () {
          changeProfile()
        })

        $('.add-file').change(addPicGallery)
      })

      var user_gallery = @json($user['user_gallery'])

      function deletePicGallery(id, ele) {
        user_gallery.splice(id, 1)
        $.ajax({
          url: '/user/{{ $user['user_id'] }}/gallery',
          type: 'delete',
          dataType: 'json',
          processData: false,
          contentType: 'application/json',
          headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
          },
          data: JSON.stringify({ 'user_gallery': user_gallery }),
          success: function (res) {
            $(ele).parent().remove()
          },
        })
      }

      function addPicGallery() {
        var formData = new FormData()
        formData.append('image', $('.add-file')[0].files[0])
        formData.append('user_gallery', JSON.stringify(user_gallery))

        $.ajax({
          url: '/user/{{ $user['user_id'] }}/gallery',
          type: 'post',
          headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
          },
          data: formData,
          contentType: false,
          processData: false,
          success: function (res) {
            var dataResult = res.data
            var firstGallery = $('.gallery-flex.--first').children().length
            var secondGallery = $('.gallery-flex.--second').children().length
            user_gallery.push(dataResult['filename'])
            var galleryHtml = `
                <div class="image-container {{ $me ? 'me' : '' }}" tabindex="-1">
                                    <img src="${dataResult['filename']}"
                                         class="image">
                                    @if($me)
              <button class="delete-btn"
                      onclick="deletePicGallery(${user_gallery.length - 1}, this)"></button>
                                        @endif
              </div>
`
            if (firstGallery < secondGallery) {
              $('.gallery-flex.--first').append(galleryHtml)
            } else {
              $('.gallery-flex.--second').append(galleryHtml)
            }
          },
        })
      }


    </script>
@endsection
