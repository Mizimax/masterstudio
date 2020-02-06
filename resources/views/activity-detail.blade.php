@php
    $categories = \App\Category::get();
@endphp
@extends('app')

@section('title', 'Activities')
@section('page', 'activity')

@section('style')
    <link rel="stylesheet" href="/css/activity-detail.css">
    <script data-ad-client="ca-pub-1666764035078228" async
            src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
@endsection

@section('content')
    @php
        $activity['activity_benefit'] = json_decode($activity['activity_benefit'], true);
        $activity['activity_video'] = json_decode($activity['activity_video'], true);
        $activity['activity_sponsors'] = json_decode($activity['activity_sponsors'], true);
        $activity['activity_routine_day'] = str_split($activity['activity_routine_day']);
        $start = new DateTime($activity->activity_start);
        $end = new DateTime($activity->activity_end);
        $activity['activity_time_diff'] = $start->diff($end) ;
        $activity['activity_day_left'] = $activity['activity_time_diff']->m === 0 ? $activity['activity_time_diff']->d + 1 . ' days' : $activity['activity_time_diff']->m . ' months';

    @endphp
    <section class="activity-header">
        <!-- Carousel -->
        <div id="carousel" class="carousel slide carousel-fade" data-ride="carousel">
            <!-- Indicators -->
            <ul class="carousel-indicators">
                @foreach($activity['activity_video'] as $key => $video)
                    <li data-target="#carousel" data-slide-to="{{ $key }}"
                        class="{{ $loop->first ? 'active' : ''}}"></li>
                @endforeach
            </ul>
            <!-- End Indicators -->

            <!-- Slideshow -->
            <div class="carousel-inner">
                @foreach($activity['activity_video'] as $video)
                    <div class="carousel-item {{ $loop->first ? 'active' : ''}}">
                        <video class="video video-fluid" autoplay loop muted>
                            <source src="{{ $video }}"
                                    type="video/mp4" />
                        </video>
                    </div>
                @endforeach
            </div>
            <!-- End Slideshow -->
            <div class="activity-header-detail">
                @include('components/activity-card', ['size' => 80])
                <div class="activity-action">
                    <div class="price">
                        THB {{ number_format($activity['activity_price']) }} {{ $activity['activity_price_type'] === 0 ? '' : '/ Hour' }}</div>
                    @if(!$isJoined)
                        <button class="join-button" onclick="joinActivity()">Join activity</button>

                        <button class="milestone-button --pinact {{ $activity['activity_pin'] !== 0 ? 'd-none' : '' }}"
                                onclick="pinActivity({{ $activity['activity_id'] }}, '{{ $activity["activity_name"] }}', this)">
                            Pin Activity
                        </button>

                        <button class="milestone-button --pinact {{ $activity['activity_pin'] === 0 ? 'd-none' : '' }}"
                                onclick="unpinActivity({{ $activity['activity_id'] }}, '{{ $activity["activity_name"] }}', this)">
                            Unpin Activity
                        </button>

                    @endif
                    <div class="availability-wrapper">
                        <div class="availability">
                            <div class="title">Availability</div>
                            <div class="number">{{ count($joinUsers) }}
                                /{{ $activity['activity_max'] }}</div>
                        </div>
                        <div class="activity-join">
                            @foreach($joinUsers as $user)
                                <div class="participant image-wrapper pointer"
                                     onclick="window.location.href='/user/{{ $user['user_id'] }}'">
                                    <img src="{{ $user['user_pic'] }}" alt="">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @if($activity['activity_vr'])
                <div class="vr-exp">
                    <div class="image-wrapper">
                        <img class="svg" src="/img/icon/play-circle-solid.svg" alt="">
                    </div>
                    <div class="text">VR experience</div>
                </div>
            @endif
        </div>
        <!-- End Carousel -->
    </section>

    <section class="activity-detail-section">
        <div class="side-sponsor">
            @foreach($activity['activity_sponsors'] as $sponsor)
                <img src="{{ $sponsor['url'] }}" alt="" class="sponsor"
                     onclick="window.location.href='{{ $sponsor['link'] }}'">
            @endforeach
        </div>

        <div class="content">
            <div class="activity-section --header">
                <h1 class="title">{{ $activity['activity_name'] }}</h1>
                <h2 class="subtitle">{{ $activity['activity_description'] }}</h2>
            </div>
            <div class="activity-section --exp">
                <div class="title">Activity Experiences</div>
                <div class="benefit-wrapper">
                    @foreach ($activity['activity_benefit'] as $benefit)
                        <div class="benefit-card"
                             style="background-image: url('{{ $benefit['bg'] }}'); padding-top: {{ $benefit['text'] != '' ? '' : '180px' }}">
                            <div class="overlay" style="border-radius: 10px;"></div>
                            <div class="content">
                                <img class="svg" src="{{ $benefit['pic'] }}" alt="">
                                <div class="name">{{ $benefit['name'] }}</div>
                                @if($benefit['text'] != '')
                                    <div class="description">{{ $benefit['text'] }}</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                {{--                <button class="more-button">More detail <img class="svg"--}}
                {{--                                                             src="/img/icon/caret-down-solid.svg">--}}
                {{--                </button>--}}
            </div>
            <div class="activity-section --studio">
                <div class="studio-wrapper"
                     style="flex-direction: {{ $activity['studio_id'] ? 'row' : 'column-reverse' }}">
                    <div class="google-map"
                         style="{{ $activity['studio_id'] ? '' : 'margin-top: 20px; flex: 1;' }}">
                        <iframe
                                src="{{ $activity['activity_location'] }}"
                                height="320" frameborder="0" style="border:0;"
                                allowfullscreen=""></iframe>
                    </div>
                    <div class="studio-detail">

                        <h3 class="title">{{ $activity['studio_name'] ? $activity['studio_name'] : $activity['activity_location_name'] }}</h3>
                        @if($activity['studio_id'])
                            <h4 class="sub-title">{{ $activity['studio_description'] }}</h4>
                            <div class="studio-section">
                                <div class="title">About studio</div>
                                <div class="content">{{ $activity['studio_description'] }}</div>
                            </div>
                            <div class="studio-section">
                                <div class="title">Studio promotion</div>
                                <div class="content">
                                    @php
                                        $activitys = [0,1,2]
                                    @endphp
                                    @foreach ($activitys as $key => $activityss)
                                        <div class="promo-code">
                                            <div class="name">first comer discount 10%</div>
                                            <div class="badge">10% off</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @if(!$stories->isEmpty())
                <div class="activity-section --story">
                    <div class="title">Master story</div>
                    @include('components/activity-story', ['stories' => $stories])
                </div>
            @endif
            <div class="activity-section --prepward">
                <div class="prepare-reward">
                    <div class="prepare-wrapper">
                        <div class="title">Preparation</div>
                        <div class="content">{!! $activity['activity_prepare'] !!}</div>
                    </div>
                    <div class="reward-wrapper">
                        <div class="title">System reward</div>
                        <div class="reward-detail">
                            <div class="image-wrapper">
                                <img src="/img/icon/user-circle-regular.svg" alt="" class="svg">
                            </div>
                            <div class="reward-text">
                                <div class="name">Experiences</div>
                                <div class="reward">{{ $activity['activity_hour'] * $activity['category_exp'] }}
                                    EXP
                                    @if($activity['activity_price_type'] === 0)
                                        ({{ $activity['activity_hour'] }} hours)
                                    @else
                                        / Hour
                                    @endif
                                </div>
                                <div class="description"></div>
                            </div>
                        </div>
                        <div class="reward-detail">
                            <div class="image-wrapper">
                                <img src="/img/icon/user-circle-regular.svg" alt="" class="svg">
                            </div>
                            <div class="reward-text">
                                <div class="name">Achievement</div>
                                <div class="reward">{{ $activity['achievement_name'] }}</div>
                                <div class="description">{{ $activity['achievement_text'] }}</div>
                            </div>
                        </div>
                        <div class="reward-detail">
                            <div class="image-wrapper">
                                <img src="/img/icon/user-circle-regular.svg" alt="" class="svg">
                            </div>
                            <div class="reward-text">
                                <div class="name">Studio Reputation</div>
                                <div class="reward">{{ $activity['activity_difficult'] }} class
                                </div>
                                <div class="description"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="activity-section --suggest">
                <div class="title">Master suggestion next...</div>
                <div class="suggest-wrapper">
                    @include('components.activity-grid-card', ['activities'=>$activities, 'size' => 80, 'nohover' => '55'])
                </div>
            </div>

            @if(!$comments->isEmpty() || $isJoined)
                <div class="activity-section --comment">
                    <div class="title">Disciple Commented</div>
                    @foreach($comments as $key => $comment)
                        <div class="comment-wrapper">
                            <div class="disciple-profile">
                                <div class="image-wrapper">
                                    <img src="{{ $comment['user_pic'] }}" alt="">
                                </div>
                                <div class="name">{{ $comment['user_name'] }}</div>
                                <span class="category-level">{{ $comment['category_name'] }} level {{ $comment['user_level'] }}</span>
                                <div class="agree-no">
                                    <img src="/img/icon/plus-solid.svg"
                                         class="svg"> {{ $comment['comment_agree'] }} agree
                                </div>
                            </div>
                            <div class="comment-detail">
                                @if($comment['comment_rate'] != 'normal')
                                    <span class="badge {{ $comment['comment_rate'] === 'recommended' ? '': '--mostly'}}">{{ $comment['comment_rate'] }}</span>
                                @endif
                                <div class="title">{{ $comment['comment_title'] }}</div>
                                <div class="comment">
                                    {{ $comment['comment_text'] }}
                                </div>
                                @if(strlen($comment['comment_text']) > 170)
                                    <button class="readmore">read more...</button>
                                @endif
                                <div class="join-since">join activity at : 1 year ago</div>
                            </div>
                            <div class="comment-image">
                                @php
                                    $comment['comment_pic'] = json_decode($comment['comment_pic'], true);
                                @endphp
                                @foreach($comment['comment_pic'] as $commentImg)
                                    <div class="image-wrapper">
                                        <img class="image" src="{{ $commentImg }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    @if($isJoined)
                        <button class="add-comment"
                                onclick="$('#modal').modal('toggle'); uploadBox();">+ Add
                            comment
                        </button>
                    @endif
                </div>
            @endif

            <div class="activity-section --sponsor">
                <div class="title">Sponsors</div>
                <div class="sponsor-wrapper">
                    @foreach($activity['activity_sponsors'] as $sponsor)
                        <div class="sponsor">
                            <img src="{{ $sponsor['url'] }}" alt=""
                                 onclick="window.location.href = '{{ $sponsor['link'] }}'">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="side-advertise">
            <div class="googlea">Google ads</div>
        </div>
    </section>
    @if($isJoined)
        <!-- Modal -->
        <div class="modal fade" id="modal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="logo-wrapper">
                            <img src="/img/logo.png" alt="Master Studio" class="logo">
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="reviewForm" method="post" onsubmit="addComment(); return false;"
                              class="review-form">
                            @csrf
                            <div class="form-group">
                                <label for="review_text" style="padding-left: 0; font-size: 14px;">Commented
                                    by
                                    : {{ Auth::user()->user_name }}</label>
                                <textarea required id="comment_text" name="comment_text"
                                          class="form-control" placeholder="Comment..."></textarea>
                                <br />
                                <label for="review_text" style="padding-left: 0; font-size: 14px;">Add
                                    activity picture</label>
                                <div class="d-flex">
                                    <input title="Upload" type="file" accept="image/*"
                                           class="form-control form-box img-input"
                                           placeholder="card number">
                                    <input title="Upload" type="file" accept="image/*"
                                           class="form-control form-box img-input"
                                           placeholder="card number">
                                    <input title="Upload" type="file" accept="image/*"
                                           class="form-control form-box img-input"
                                           placeholder="card number">
                                </div>
                            </div>

                            <div class="modal-action justify-content-center">
                                <button type="submit" class="primary-button">
                                    Add comment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@12.0.0/dist/lazyload.min.js"></script>
    <script src="/js/activity.js"></script>
    <script>
      $(document).ready(function () {
        var lazyLoadInstance = new LazyLoad({
          elements_selector: '.lazy',
          // ... more custom settings?
        })

        $('.video-wrapper .video').hover(function () {
          $(this).get(0).play()
        }, function () {
          $(this).get(0).pause()
        })

        $('.activity-overlay').hover(function () {
          $(this).siblings('.video-wrapper').children('.video').get(0).play()
        }, function () {
          $(this).siblings('.video-wrapper').children('.video').get(0).pause()
        })
          @if(\Session::has('success'))
          joinActivity('success')
          @endif

          @if($errors->any())
          joinActivity()
          @endif
      })
    </script>

    <script>

                @if($isJoined)
      var addComment = function () {
          var formData = new FormData()

          formData.append('comment_text', $('#comment_text').val())

          $('.img-input').each(function (index, element) {
            var value = element.files[0]
            formData.append('comment_pic_' + index, value)
          })

          $.ajax({
            url: '/activity/{{ $activity['activity_id'] }}/comment',
            type: 'post',
            headers: {
              'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
              window.location.reload()
            },
          })

        }
                @endif

                @if(!$isJoined)

      var pinActivity = function (activity, name, ele) {
          $.ajax({
            url: '/activity/' + activity + '/pin',
            type: 'post',
            processData: false,
            contentType: 'application/json',
            data: JSON.stringify({
              '_token': $('meta[name="csrf-token"]').attr('content'),
            }),
            success: function (data) {
              modal('all')
              var alertHtml = `
            <div class="alert alert-success" role="alert">
              Activity ${name} was pinned !
            </div>
            `
              $('#my-activity').append(alertHtml)

              $(ele).parent().children('.--pinact').toggleClass('d-none')
            },
            error: function (err) {
              if (err.status === 401) {
                modal('login')
              } else if (err.status === 500) {
                modal('all')
                $(ele).parent().children('.--pinact').toggleClass('d-none')
              }
            },
          })
        }

      var unpinActivity = function (activity, name, ele) {
        $.ajax({
          url: '/activity/' + activity + '/unpin',
          type: 'post',
          processData: false,
          contentType: 'application/json',
          data: JSON.stringify({
            '_token': $('meta[name="csrf-token"]').attr('content'),
          }),
          success: function (data) {
            $(ele).parent().children('.--pinact').toggleClass('d-none')
          },
          error: function (err) {
            if (err.status === 401) {
              modal('login')
            }
          },
        })
      }

                @endif

      var joinActivity = function (state) {
                    @if(Auth::check())
          var cardHtml = `
            @foreach($cards as $card)

            <div class="payment-badge" card="{{ $card->card_id }}">
                    <img src="/img/icon/credit-card-regular.svg" class="svg">
                    <div class="name"><img class="card-icon" src="/img/{{ $card->card_type }}.png"><br /><span
                                class="card-number">{{ substr_replace($card->card_no, '******', 5, 6) }}</span></div>
                </div>

            @endforeach
            `
          var options = {
            data: {
              name: '{{ $activity['activity_name'] }}',
              price: {{ $activity['activity_price'] }},
              id: {{ $activity['activity_id'] }},
              pic: {{ $activity['activity_pic'] }},
              priceName: '{{ number_format($activity['activity_price']) }}',
              cardHtml: cardHtml,
            },
            payment: state,
          }
          modal('join', options)
                    @else
                    modal('login')
                    @endif

        }

    </script>
@endsection
