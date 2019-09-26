@extends('app')

@section('title', 'Studio')
@section('page', 'studio')

@section('style')
    <link rel="stylesheet" href="/css/studio.css">
@endsection

@section('content')
    <div id="map" style="width: 100%; height: 100vh">

    </div>
    <div class="map-detail" style="display: none">
        <div class="map-card">
            <div class="map-header">
                <div class="title">Windshire studio</div>
                <div class="subtitle">chinese bayy</div>
                <img src="/img/icon/play-circle-solid.svg" alt="" class="svg">
            </div>
            @include('components/activity-story', ['stories'=>[0,1,2,3], 'size'=>50])
            <div class="master-list">
                <img class="master" src="/img/profile.jpg" alt="">
                <img class="master" src="/img/profile.jpg" alt="">
                <img class="master" src="/img/profile.jpg" alt="">
                <img class="master" src="/img/profile.jpg" alt="">
            </div>
        </div>
        <a href="/studio/1">
            <button class="studio-button">view studio profile</button>
        </a>
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
      })
    </script>
    <script>
      var map

      function initMap() {
        map = new google.maps.Map(
          document.getElementById('map'),
          { center: new google.maps.LatLng(13.7357318, 100.5260661), zoom: 12 })

        var iconBase =
          'https://developers.google.com/maps/documentation/javascript/examples/full/images/'

        var icons = {
          parking: {
            icon: iconBase + 'parking_lot_maps.png',
          },
          library: {
            icon: iconBase + 'library_maps.png',
          },
          info: {
            icon: iconBase + 'info-i_maps.png',
          },
        }

        var studios = [
          {
            lat: 13.758054,
            long: 100.5445439,
            imgUrl: 'https://i.imgur.com/UDH8uMn.png',
          },
          {
            lat: 13.720896,
            long: 100.5026186,
            imgUrl: 'https://i.imgur.com/UDH8uMn.png',
          },
          {
            lat: 13.6759147,
            long: 100.5217145,
            position: new google.maps.LatLng(13.6759147, 100.5217145),
            imgUrl: 'https://i.imgur.com/UDH8uMn.png',
          },
        ]

        // Create markers.
        for (var i = 0; i < studios.length; i++) {
          var marker = new google.maps.Marker({
            position: new google.maps.LatLng(studios[i].lat, studios[i].long),
            icon: studios[i].imgUrl,
            map: map,
          })
          marker.addListener('mouseover', function (e) {
            var lat = Math.round(e.latLng.lat() * 10000000) / 10000000
            var long = Math.round(e.latLng.lng() * 10000000) / 10000000
            var x = e.xa.x
            var y = e.xa.y

            var studio = studios.find(function (studio) {
              return studio.lat == lat && studio.long == long
            })

            $('.map-detail .title').text(lat)

            $('.map-detail').css('display', 'block')
            $('.map-detail').css('top', y)
            $('.map-detail').css('left', x)

          })
        }

      }
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBCKX_QDAbkV66e1NLEnJ2KDH0b1bALvIc&callback=initMap">
    </script>
@endsection
