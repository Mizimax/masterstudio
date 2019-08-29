@extends('app')

@section('title', 'Activities')
@section('page', 'activity')

@section('style')
    <link rel="stylesheet" href="/css/activity.css">
@endsection

@section('content')
    <section class="">

    </section>

    <section class="your-activity">
        <h3 class="header">Live Activity</h3>
        <div class="category-interest">
            <div class="interest-activity">
                <div class="icon"></div>
                <div class="name">badminton</div>
            </div>
            <div class="interest-activity">
                <div class="icon"></div>
                <div class="name">golf</div>
            </div>
            <div class="interest-activity">
                <div class="icon"></div>
                <div class="name">chef</div>
            </div>
            <div class="add-interest-activity">
                <div class="icon"></div>
                <div class="name">Add interest</div>
            </div>
        </div>
        <div class="activity-timeline">

        </div>
    </section>

    <section class="all-activity">
        <div class="content">
            <h3 class="header">All activities</h3>
            <input class="search input-transparent" placeholder="Search your activities..."
                   type="text">
            <div class="activity-grid">
                @php
                    $activities = [0,1,2,3,4,5]
                @endphp
                @include('components.activity-grid-card', ['activities'=>$activities])
            </div>
            <div class="loading-wrapper">
                <div class="lds-ellipsis infinite-scroll-request">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        <div class="overlay"></div>
    </section>
@endsection

@section('script')
    <script src="/js/infinite-scroll.pkgd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@12.0.0/dist/lazyload.min.js"></script>
    <script>
      function getActivityPath() {
        return '/content/activity/all'
      }
    </script>
@endsection

@section('scriptready')
    var lazyLoadInstance = new LazyLoad({
    elements_selector: ".lazy"
    // ... more custom settings?
    });

    $('.all-activity .activity-grid').infiniteScroll({
    // options
    path: getActivityPath,
    append: '.activity-card-wrapper',
    status: '.loading-wrapper',
    });

    $('.all-activity .activity-grid').on( 'append.infiniteScroll', function( event, response ) {
    if (lazyLoadInstance) {
    lazyLoadInstance.update();
    }
    });
@endsection