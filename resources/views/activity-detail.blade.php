@php
    $categories = \App\Category::get();
@endphp
@extends('app')

@section('title', 'Activities')
@section('page', 'activity')

@section('style')
    <link rel="stylesheet" href="/css/activity-detail.css?v=1.0">
    <script data-ad-client="ca-pub-1666764035078228" async
            src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
@endsection

@section('content')
    @php
        $activity['activity_benefit'] = json_decode($activity['activity_benefit'], true);
        $activity['activity_video'] = json_decode($activity['activity_video'], true);
        $activity['activity_pic'] = json_decode($activity['activity_pic'], true);
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
            <ul class="carousel-indicators d-sm-flex d-none">
                @foreach($activity['activity_video'] as $key => $video)
                    <li data-target="#carousel" data-slide-to="{{ $key }}"
                        class="{{ $loop->first ? 'active' : ''}}"></li>
                @endforeach
                @foreach($activity['activity_pic'] as $key => $pic)
                    <li data-target="#carousel"
                        data-slide-to="{{ count($activity['activity_video']) + $key }}"
                        class="{{ count($activity['activity_video']) == 0 ? 'active' : ''}}"></li>
                @endforeach
            </ul>
            <!-- End Indicators -->

            <!-- Slideshow -->
            <div class="carousel-inner">
                @foreach($activity['activity_video'] as $video)
                    <div align="center" class="carousel-item {{ $loop->first ? 'active' : ''}}">
                        <video class="video video-fluid" autoplay loop muted playsinline>
                            <source src="{{ $video }}"
                                    type="video/mp4" />
                        </video>
                    </div>
                @endforeach
                @foreach($activity['activity_pic'] as $pic)
                    <div align="center"
                         class="carousel-item {{ count($activity['activity_video']) == 0 ? 'active' : ''}}">
                        <img src="{{ $pic }}" style="height: 100vh; object-fit: cover">
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

                        <button class="milestone-button --pinact {{ ($activity['activity_join'] === 0 && $activity['activity_pin'] === 0) ? '' : 'd-none' }}"
                                onclick="pinActivity({{ $activity['activity_id'] }}, '{{ $activity["activity_name"] }}', this)">
                            Pin Activity
                        </button>

                        <button class="milestone-button --pinact {{ ($activity['activity_join'] === 0 && $activity['activity_pin'] !== 0) ? '' : 'd-none' }}"
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

                        <a href="/studio/{{ $activity['studio_id'] }}"><h3
                                    class="title">{{ $activity['studio_name'] ? $activity['studio_name'] : $activity['activity_location_name'] }}</h3>
                        </a>
                        @if($activity['studio_id'])
                            <h4 class="sub-title">{{ $activity['studio_title'] }}</h4>
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
                                <img src="/img/icon/levelup.png" alt="" class="svg">
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
                                <img src="/img/icon/badminton.png" alt="" class="svg">
                            </div>
                            <div class="reward-text">
                                <div class="name">Achievement</div>
                                <div class="reward">{{ $activity['achievement_name'] }}</div>
                                <div class="description">{{ $activity['achievement_text'] }}</div>
                            </div>
                        </div>
                        <div class="reward-detail">
                            <div class="image-wrapper">
                                <img src="/img/icon/basic.png" alt="" class="svg">
                            </div>
                            <div class="reward-text">
                                <div class="name">Activity difficult</div>
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
                            <img style="width: 200px; margin: 10px;" src="{{ $sponsor['url'] }}"
                                 alt=""
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
    <div class="modal fade" id="payment-modal" tabindex="-1" role="dialog"
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
                <div class="modal-body2">
                    <ul class="nav nav-tabs d-none" id="paymentTabLink" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="confirm-tab" data-toggle="tab"
                               href="#confirmTab" role="tab" aria-controls="confirm"
                               aria-selected="true">Confirm</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="payment-success-tab" data-toggle="tab"
                               href="#paymentSuccessTab" role="tab" aria-controls="payment-success"
                               aria-selected="false">Payment success</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="paymentTabPane">
                        <div class="tab-pane fade active show" id="confirmTab" role="tabpanel"
                             aria-labelledby="confirm-tab">
                            <div class="payment-success --confirm" align="center">
                                <h3 class="header">Booking Confirmation</h3>

                                <video src="{{  count($activity['activity_video']) != 0 ? $activity['activity_video'][0] : '' }}"
                                       style="width: 100%" autoplay muted play></video>

                                <p class="thx">You are joining </p>
                                <h3 class="name">"{{ $activity['activity_name'] }}"</h3>
                                <p class="total">total amount : <span class="price">{{ number_format($activity['activity_price']) }} Bath</span>
                                </p>
                                <div class="d-flex">
                                    <button class="pay-button --outline mb-3 mr-1"
                                            onclick="$('#payment-modal').modal('toggle');">Cancel
                                    </button>
                                    <form onsubmit="omiseOpen(event)" style="width: 100%"
                                          id="omiseForm" name="checkoutForm" method="POST"
                                          action="/activity/{{ $activity['activity_id'] }}/payment">
                                        @csrf
                                        <input type="hidden" name="omiseToken">
                                        <input type="hidden" name="omiseSource">
                                        <input type="hidden" name="amount"
                                               value="{{ $activity['activity_price'] }}">
                                        <button type="submit" class="pay-button">Confirm</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="tab-pane fade" id="paymentTab" role="tabpanel" aria-labelledby="payment-tab">

                            <div class="payment-wrapper">
                                <h3 class="header">Payment method</h3>
                                <div class="badge-wrapper">
                                    <div class="payment-badge active" id="newCard">
                                        <img src="/img/icon/credit-card-regular.svg" class="svg">
                                        <div class="name">new<br />debit/credit</div>
                                    </div>
                                    ${activity.cardHtml}
                                </div>
                                <div class="form-card-wrapper">
                                    <div class="card-support">
                                        <img class="card-icon" src="/img/visa.png" alt="">
                                        <img class="card-icon" src="/img/visa.png" alt="">
                                        <img class="card-icon" src="/img/visa.png" alt="">
                                    </div>
                                    <div class="form-group">
                                        <label for="card_number">Card number</label>
                                        <input type="text" name="card_number" id="user_firstname"
                                               class="form-control"
                                               placeholder="card number">
                                    </div>
                                    <div class="form-group">
                                        <label for="card_name">Name on card</label>
                                        <input type="text" name="card_name" id="user_firstname"
                                               class="form-control"
                                               placeholder="name on card">
                                    </div>
                                    <div class="d-flex">
                                        <div class="form-group flex-grow-1 mr-2">
                                            <label for="card_exp">Expiration date</label>
                                            <input type="text" name="card_exp" id="user_firstname"
                                                   class="form-control"
                                                   placeholder="MM/YY">
                                        </div>
                                        <div class="form-group flex-grow-1">
                                            <label for="card_ccv">CCV</label>
                                            <input type="text" name="card_ccv" id="user_firstname"
                                                   class="form-control"
                                                   placeholder="CVV">
                                        </div>
                                    </div>
                                </div>
                                <button class="pay-button mt-3" onclick="activeTab('paymentSuccessTab')">Pay now</button>
                            </div>
                            <br />
                        </div> -->
                        <div class="tab-pane fade" id="paymentSuccessTab" role="tabpanel"
                             aria-labelledby="payment-success-tab">
                            <div class="payment-success" align="center">
                                <h3 class="header">Payment Confirmation</h3>
                                <img src="/img/icon/check-circle-solid.svg" class="svg">
                                <h5 class="thx">Thank you !</h5>
                                <p class="booking">You just
                                    booked {{ $activity['activity_name'] }}</p>
                                <h5 class="price">{{ number_format($activity['activity_price']) }}
                                    Bath</h5>
                                <img src="{{ count($activity['activity_pic']) !== 0 ? $activity['activity_pic'][0] : (count($activity['activity_video']) !== 0 ? $activity['activity_video'][0] : '') }}"
                                     class="activity-image">
                                <button class="pay-button"
                                        onclick="$('#payment-modal').modal('hide');modal('all')">
                                    View all
                                    activity
                                </button>
                                <button class="pay-button mb-3 --outline"
                                        onclick="$('#payment-modal').modal('hide')">
                                    Back to homepage
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@12.0.0/dist/lazyload.min.js"></script>
    <script type="text/javascript" src="https://cdn.omise.co/omise.js">
    </script>
    <script src="/js/activity.js"></script>
    <script>
      $(document).ready(function () {
        var lazyLoadInstance = new LazyLoad({
          elements_selector: '.lazy',
          // ... more custom settings?
        })

        OmiseCard.configure({
          publicKey: 'pkey_test_5ikuyw9bd25g1ku53mh',
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

        var hash = location.hash.substr(1)
        if (hash === 'pay') {
          joinActivity()
        }
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
                    $('#payment-modal').modal('toggle')
          if (state === 'success') {
            console.log('>> : ')
            $('.nav-tabs a[href="#paymentSuccessTab"]').tab('show')
          }
                    @else
                    modal('login')
                    @endif

        }

      var omiseOpen = function (event) {
        event.preventDefault()
        OmiseCard.open({
          amount: {{ $activity['activity_price'] }} * 100,
          currency: 'THB',
          onCreateTokenSuccess: (nonce) => {
            var form = $('#omiseForm')[0]
            if (nonce.startsWith('tokn_')) {
              form.omiseToken.value = nonce
            } else {
              form.omiseSource.value = nonce
            }

            form.submit()
          },
        })
      }

    </script>
@endsection
