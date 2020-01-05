@php
    $categories = \App\Category::get();
@endphp
@extends('app')

@section('title', 'Master')
@section('page', 'master')

@section('style')
    <link rel="stylesheet" href="/css/master.css">
@endsection

@section('content')
    <section class="master-header">
        <div class="bg-header">
        </div>
        <div class="header-content">
            <h1 class="header">Explore the real master</h1>
            <div class="search-box-wrapper">
                <img src="/img/icon/search-solid.svg" class="svg">
                <input class="search-box" placeholder="Master name / Activity you like" type="text"
                       onKeyUp="handleChange(this)">
                <button class="button" onclick="goTo('master')">Explore</button>
            </div>
            <div class="master-interest">
                <h2 class="header">Master you may interest</h2>
                <div class="master-list">
                    @foreach($masters as $keyMaster => $master)
                        <div class="master-category">
                            <h3 class="header">{{ $master[0]['category_name'] }} master</h3>
                            <div class="master-content">
                                @foreach($master as $key => $mst)
                                    <div class="master-detail {{ ($keyMaster * 2) + ($key) >= 3 ? 'right' : '' }}">
                                        @component('components.master-card', ['noimage'=>true, 'animate'=>true, 'size'=>70, 'data'=>$mst])
                                        @endcomponent
                                        <div class="image-wrapper">
                                            <img src="{{ $mst['user_pic'] }}" alt="">
                                        </div>
                                        <div class="name">{{ $mst['master_name'] }}</div>
                                        <div class="badge {{ $mst['master_most_recommend'] !== 0 ? '--most' : ($mst['master_recommend'] !== 0 ? '--rec' : '')}}">{{ $mst['master_most_recommend'] !== 0 ? 'Most recommended' : ($mst['master_recommend'] !== 0 ? 'Recommended' : '')}}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <section id="master" class="master-profile-section">
        <div class="section-container">
            <div class="search-wrapper">
                <div class="category-name">Italian Master</div>
                <div class="search-box-wrapper" style="position:relative">
                    <img src="/img/icon/search-solid.svg" class="svg">
                    <input class="search-box" placeholder="Master name / Activity you like"
                           type="text" onKeyUp="handleChange(this)">
                </div>
            </div>
            <div class="filter-category" align="center">
                @include('components.category-interest')
            </div>

            <div class="master-wrapper">
                @include('components.master-list', ['masters' => $allMasters])
            </div>
        </div>
    </section>
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
        var figure = $('.master-wrapper').delegate('.master-video', 'click', function () {
          var played = $(this).attr('played') == 'true'
          if (!played) {
            $(this).children('.video-wrapper').children('.video').get(0).play()
          } else {
            $(this).children('.video-wrapper').children('.video').get(0).pause()
          }
          $(this).children('.video-wrapper').children('.play-wrapper').toggleClass('d-none')
          $(this).attr('played', !played)
        })

        $('.master-detail').hover(function () {
          $(this).children('.activity-detail').fadeIn()
        }, function () {
          $(this).children('.activity-detail').fadeOut()
        })

      })

    </script>

    <script>
      var interestSelected = function () {
        goTo('master')

        $.ajax({
          url: '/content/master/category?category=[' + MasterStudio.categorySelected.toString() + ']',
          type: 'get',
          processData: false,
          contentType: 'application/json',
          data: JSON.stringify({
            '_token': $('meta[name="csrf-token"]').attr('content'),
          }),
          success: function (data) {
            $('.master-wrapper').html(data)
            var lazyLoadInstance = new LazyLoad({
              elements_selector: '.lazy',
              // ... more custom settings?
            })
            replaceSvg()
          },
          error: function (error) {
            console.log(error)
          },
        })
      }
    </script>

    <script>
      function debounce(f, ms) {
        let timer = null

        return function (...args) {
          const onComplete = () => {
            f.apply(this, args)
            timer = null
          }

          if (timer) {
            clearTimeout(timer)
          }

          timer = setTimeout(onComplete, ms)
        }
      }

      var handleChange = function (e) {
        $('.master-wrapper').html(
          '<div class="search-result">Loading...</div>',
        )

        debounce(function () {
          const val = e.value

          $.ajax({
            url: '/content/master/search?keyword=' + val,
            type: 'get',
            processData: false,
            contentType: 'application/json',
            data: JSON.stringify({
              '_token': $('meta[name="csrf-token"]').attr('content'),
            }),
            success: function (res) {
              $('.master-wrapper').html(res)
              var lazyLoadInstance = new LazyLoad({
                elements_selector: '.lazy',
                // ... more custom settings?
              })
              replaceSvg()
            },
            error: function (error) {
              console.log(error)
            },
          })

        }, 700)()
      }

    </script>
@endsection
