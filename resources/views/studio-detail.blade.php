@extends('app')

@section('title', 'Studio')
@section('page', 'studio')

@section('style')
    <link rel="stylesheet" href="/css/studio-detail.css">
@endsection

@section('content')
    <section class="studio-header">
        <div class="studio-header-content">
            <img src="/img/Deepsea.jpeg" alt="" class="studio-icon">
            <h1 class="studio-name">Windshire studio</h1>
            <h3 class="studio-location">Chinese bay</h3>
            <div class="action-wrapper">
                <div class="action-button"></div>
                <div class="action-button"></div>
                <div class="action-button"></div>
            </div>
            <div class="checkin"></div>
            @include('components/activity-story', ['stories'=>[0,1,2]])
        </div>
    </section>
    <section class="studio-detail">

    </section>
    <section class="studio-master">

    </section>
    <section class="studio-activity">
        @php
            $activities = [0,1,2,3]
        @endphp
        @include('components.activity-grid-card', ['activities'=>$activities])
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
      })
    </script>
@endsection