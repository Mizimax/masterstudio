@php
    $categories = \App\Category::get();
@endphp
@extends('app')

@section('title', 'Studio')
@section('page', 'studio')

@section('style')
    <link rel="stylesheet" href="/css/studio-detail.css?v=1.1">
@endsection

@section('content')
    @php
        $user = Auth::user();
    @endphp
    @if(Auth::check())
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
                        <form id="reviewForm" class="review-form">
                            @csrf
                            <div class="form-group">
                                <label for="review_text" style="padding-left: 0; font-size: 14px;">Reviewer
                                    : {{ Auth::user()->user_name }}</label>
                                <textarea required id="review_text" name="review_text"
                                          class="form-control" placeholder="Review..."></textarea>
                            </div>

                            <div class="modal-action justify-content-center">
                                <button type="button" class="primary-button" onclick="addReview()">
                                    Add your review
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <section class="studio-header">
        <!-- Carousel -->
        <div id="carousel" class="carousel slide carousel-fade" data-ride="carousel"
             data-interval="60000">
            <!-- Indicators -->
            <ul class="carousel-indicators">
                @foreach($studio['studio_bg'] as $key => $bg)
                    <li data-target="#carousel" data-slide-to="{{ $key }}"
                        class="{{ $loop->first ? 'active' : ''}}"></li>
                @endforeach
            </ul>
            <!-- End Indicators -->

            <!-- Slideshow -->
            <div class="carousel-inner">
                @foreach($studio['studio_bg'] as $bg)
                    <div class="carousel-item {{ $loop->first ? 'active' : ''}}">
                        <img class="studio-bg" src="{{ $bg }}">
                    </div>
                @endforeach
            </div>
        </div>
        <div class="studio-header-wrapper">
            <div class="studio-header-content">
                <img src="{{ $studio['studio_icon'] }}" alt="" class="studio-icon">
                <h1 class="studio-name">{{ $studio['studio_name'] }}</h1>
                <h3 class="studio-location">{{ $studio['studio_title'] }}</h3>
                <div class="action-wrapper" align="center">
                    <div class="action-button">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}"
                           target="_blank">
                            <div class="icon-wrapper --share">
                            </div>
                            <span class="text">Share</span>
                        </a>
                    </div>

                    <div class="action-button">
                        <button class="join-button">Join<br>Activity</button>
                    </div>
                    <div class="action-button">
                        @if(!$isFollower)
                            <form id="followStudio" action="{{ url()->current() }}"
                                  method="post">
                                @csrf
                            </form>
                        @endif
                        <div class="follow-icon {{ $isFollower ? 'followed' : '' }}"
                             onclick="$('#followStudio').submit()">
                            <img src="/img/icon/footstep.svg"
                                 alt="Follow ..."
                                 class="svg">
                        </div>
                        <span class="text">{!! $isFollower ? 'Followed' : 'follow<br />studio' !!}</span>
                    </div>
                </div>
                <div class="checkin">
                    @include('components/activity-story', ['stories'=>$stories, 'notime' => true])
                </div>

            </div>
        </div>
    </section>

    <div class="studio-detail-container">
        <section class="studio-detail">
            <div class="detail-header"
                 style="background-image: url('{{ count($studio['studio_bg']) != 0 ? $studio['studio_bg'][0] : '' }}')">
                <div class="bg-blur"
                     style="background-image: url('{{ count($studio['studio_bg']) != 0 ? $studio['studio_bg'][0] : '' }}')"></div>
                <div class="content">
                    <h1 class="title">{{ $studio['studio_name'] }}</h1>
                    <div class="studio-line">
                        <img src="{{ $studio['studio_icon'] }}" class="studio-icon">
                    </div>
                    <div class="nav-tab nav nav-pill">
                        <a class="tab-link active" href="#description" role="tab" data-toggle="tab">Description</a>
                        <a class="tab-link" href="#gallery" role="tab" data-toggle="tab">Gallery</a>
                        <a class="tab-link" href="#review" role="tab" data-toggle="tab">Review</a>
                        <a class="tab-link" href="#location" role="tab"
                           data-toggle="tab">Location</a>
                    </div>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active show" id="description">
                            <div class="video-wrapper" played="false">
                                <video class="video lazy pointer" loop muted playsinline>
                                    <source data-src="{{ count($studio['studio_video']) != 0 ? $studio['studio_video'][0] : '' }}"
                                            type="video/mp4" />
                                </video>
                                <div class="play-wrapper">
                                    <img src="/img/icon/play-circle-solid.svg" class="svg">
                                </div>
                            </div>
                            <p class="description" align="left">
                                {{ $studio['studio_description'] }}
                            </p>
                        </div>
                        <div role="tabpanel" class="tab-pane fade in" id="gallery">
                            <div class="gallery-wrapper">
                                @include('components.gallery', ['galleries' => $studio['studio_pic']])
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade in" id="review">
                            @if(!empty($reviews) && count($reviews) !== 0)
                                <div class="review-wrapper">
                                    @foreach($reviews as $review)
                                        <div class="review-card">
                                            <img src="{{ $review['user_pic'] }}" class="image" />
                                            <div class="name">{{ $review['user_name'] }}</div>
                                            <div class="review">
                                                {{ $review['review_text'] }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="review-wrapper" align="centerz">
                                    <div class="no-review">No review now.</div>
                                </div>
                            @endif
                            @if(Auth::check())
                                <button class="add-review" onclick="$('#modal').modal()">Add your
                                    review
                                </button>
                            @endif
                        </div>
                        <div role="tabpanel" class="tab-pane fade in" id="location">
                            <iframe
                                    class="studio-location"
                                    src="{{ $studio['studio_location'] }}"
                                    height="320" frameborder="0" style="border:0;"
                                    allowfullscreen=""></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @if(!empty($stories) && count($stories) !== 0)
            <section class="studio-master checkout">
                <h4 class="title">Studio Stories</h4>
                <div class="activity-wrapper">
                    @include('components/activity-story', ['stories'=>$stories])
                </div>
            </section>
        @endif
        @if(!empty($masters) && count($masters) !== 0)
            <section class="studio-master">
                <h4 class="title">Master @Studio</h4>
                <div class="master-studio-padding">
                    @include('components.master-list', ['masters' => $masters, 'userme' => Auth::user()])
                </div>
            </section>
        @endif
        @if(!empty($masters) && count($masters) !== 0)
            <section class="studio-activity">
                <h4 class="title">Activity happening here</h4>
                <div class="activity-wrapper flex-wrap">
                    @include('components.activity-grid-card', ['activities'=>$activities, 'size'=>80, 'nohover' => '55'])
                </div>
            </section>
        @endif
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
        // video click
        $('.video-wrapper').click(function () {
          var played = $(this).attr('played') == 'true'
          if (!played) {
            $(this).children().get(0).play()
          } else {
            $(this).children().get(0).pause()
          }
          $(this).children('.play-wrapper').toggleClass('d-none')
          $(this).attr('played', !played)
        })

        // video click
        $('.master-video').click(function () {
          var played = $(this).attr('played') == 'true'
          if (!played) {
            $(this).children('.video-wrapper').children('.video').get(0).play()
          } else {
            $(this).children('.video-wrapper').children('.video').get(0).pause()
          }
          $(this).children('.video-wrapper').children('.play-wrapper').toggleClass('d-none')
          $(this).attr('played', !played)
        })

        $('.activity-wrapper .video').hover(function () {
          $(this).get(0).play()
        }, function () {
          $(this).get(0).pause()
        })

        $('.activity-overlay').hover(function () {
          $(this).siblings('.video-wrapper').children('.video').get(0).play()
        }, function () {
          $(this).siblings('.video-wrapper').children('.video').get(0).pause()
        })

      })
    </script>

    <script>

      var addReview = function () {
        $.ajax({
          url: '/studio/{{ $studio['studio_id'] }}/review',
          type: 'post',
          dataType: 'json',
          processData: false,
          contentType: 'application/json',
          data: JSON.stringify({
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'review_text': $('#review_text').val(),
          }),
          success: function (res) {
            var reviewHtml = `
                    <div class="review-card" id="newReview">
                        <img src="{{ !empty($user) ? $user->user_pic : '' }}" class="image" />
                        <div class="name">{{ !empty($user) ? $user->user_name : '' }}</div>
                        <div class="review">
                            ${$('#review_text').val()}
                        </div>
                    </div>
                `
            if ($('.review-wrapper > ')) {
              $('.review-wrapper').prepend(reviewHtml)
            }
            $('#modal').modal('toggle')
            // window.location.hash = '#newReview';
          },
        })
      }
    </script>
@endsection