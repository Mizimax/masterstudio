<link rel="stylesheet" href="/css/studio.css">
<style>
    img[src^='/img/studio'] {
        border-radius: 50%;
        object-fit: cover;
    }
</style>

<div id="map" style="width: 100%; height: 100vh">

</div>

<div class="map-detail" style="display: none">

</div>

<script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@12.0.0/dist/lazyload.min.js"></script>
<script src="/js/category.js"></script>
<script>
  $(document).ready(function () {
    var lazyLoadInstance = new LazyLoad({
      elements_selector: '.lazy',
      // ... more custom settings?
    })

    $('.interest-activity').click(function () {
      $(this).toggleClass('active')
    })

    $('.map-detail').hover(function () {
      $(this).css('display', 'block')
    }, function () {
      $(this).css('display', 'none')
    })

  })
</script>
<script>

  var mapCard = function (studio, i) {
    var pics = JSON.parse(studio.studio_pic)

    var carouselIndicators = pics.map(function (value, index) {
      return `<li data-target="#carousel" data-slide-to="${index}" class="${index === 0
                                                                            ? 'active'
                                                                            : ''}"></li>`
    }).join('\n')

    var carouselText = pics.map(function (value, index) {
      return `
        <div class="carousel-item ${index === 0 ? 'active' : ''}">
          <img class="gallery" src="${value}">
        </div>
        `
    }).join('\n')

    // var masterText = studio.masters.map(function (value, index) {
    //   return `
    //   <img class="master" src="${value}">
    // `
    // }).join('\n');
    return `
            <div class="map-card" id="studioId" val="${studio.studio_id}">
            <div class="map-header">
                <div class="title">${studio.studio_name}</div>
                <div class="subtitle">${studio.studio_title}</div>
                <div class="follow-wrapper">
                    <img src="/img/icon/footstep.svg" alt="" class="svg">
                </div>
            </div>
            <div id="carousel" style="margin: 10px 0" class="carousel slide carousel-fade"
                 data-ride="carousel" data-interval="2000">

              <ul class="carousel-indicators" style="margin-bottom: 10px">
                  ${carouselIndicators}
              </ul>

                <div class="carousel-inner">
                    ${carouselText}
                </div>
            </div>
          <div class="master-list">

          </div>
          </div>
          <a href="/studio/${studio.studio_id}">
          <button class="studio-button">view studio profile</button>
          </a>
        `
  }
</script>
<script>
  var map

  function initMap() {
    map = new google.maps.Map(
      document.getElementById('map'),
      {
        center: new google.maps.LatLng(13.7357318, 100.5260661), zoom: 12, styles: [{
          'featureType': 'all', 'elementType': 'labels.text.fill',
          'stylers': [{ 'color': '#7c93a3' }, { 'lightness': '-10' }],
        }, {
          'featureType': 'administrative.country', 'elementType': 'geometry',
          'stylers': [{ 'visibility': 'on' }],
        }, {
          'featureType': 'administrative.country', 'elementType': 'geometry.stroke',
          'stylers': [{ 'color': '#a0a4a5' }],
        }, {
          'featureType': 'administrative.province', 'elementType': 'geometry.stroke',
          'stylers': [{ 'color': '#62838e' }],
        }, {
          'featureType': 'landscape', 'elementType': 'geometry.fill',
          'stylers': [{ 'color': '#dde3e3' }],
        }, {
          'featureType': 'landscape.man_made', 'elementType': 'geometry.stroke',
          'stylers': [{ 'color': '#3f4a51' }, { 'weight': '0.30' }],
        }, {
          'featureType': 'poi', 'elementType': 'all',
          'stylers': [{ 'visibility': 'simplified' }],
        }, {
          'featureType': 'poi.attraction', 'elementType': 'all',
          'stylers': [{ 'visibility': 'on' }],
        }, {
          'featureType': 'poi.business', 'elementType': 'all',
          'stylers': [{ 'visibility': 'off' }],
        }, {
          'featureType': 'poi.government', 'elementType': 'all',
          'stylers': [{ 'visibility': 'off' }],
        }, {
          'featureType': 'poi.park', 'elementType': 'all', 'stylers': [{ 'visibility': 'on' }],
        }, {
          'featureType': 'poi.place_of_worship', 'elementType': 'all',
          'stylers': [{ 'visibility': 'off' }],
        }, {
          'featureType': 'poi.school', 'elementType': 'all',
          'stylers': [{ 'visibility': 'off' }],
        }, {
          'featureType': 'poi.sports_complex', 'elementType': 'all',
          'stylers': [{ 'visibility': 'off' }],
        }, {
          'featureType': 'road', 'elementType': 'all',
          'stylers': [{ 'saturation': '-100' }, { 'visibility': 'on' }],
        }, {
          'featureType': 'road', 'elementType': 'geometry.stroke',
          'stylers': [{ 'visibility': 'on' }],
        }, {
          'featureType': 'road.highway', 'elementType': 'geometry.fill',
          'stylers': [{ 'color': '#bbcacf' }],
        }, {
          'featureType': 'road.highway', 'elementType': 'geometry.stroke',
          'stylers': [{ 'lightness': '0' }, { 'color': '#bbcacf' }, { 'weight': '0.50' }],
        }, {
          'featureType': 'road.highway', 'elementType': 'labels',
          'stylers': [{ 'visibility': 'on' }],
        }, {
          'featureType': 'road.highway', 'elementType': 'labels.text',
          'stylers': [{ 'visibility': 'on' }],
        }, {
          'featureType': 'road.highway.controlled_access', 'elementType': 'geometry.fill',
          'stylers': [{ 'color': '#ffffff' }],
        }, {
          'featureType': 'road.highway.controlled_access', 'elementType': 'geometry.stroke',
          'stylers': [{ 'color': '#a9b4b8' }],
        }, {
          'featureType': 'road.arterial', 'elementType': 'labels.icon',
          'stylers': [{ 'invert_lightness': true }, { 'saturation': '-7' }, { 'lightness': '3' }, { 'gamma': '1.80' }, { 'weight': '0.01' }],
        }, {
          'featureType': 'transit', 'elementType': 'all', 'stylers': [{ 'visibility': 'off' }],
        }, {
          'featureType': 'water', 'elementType': 'geometry.fill',
          'stylers': [{ 'color': '#a3c7df' }],
        }],
      })

    var studios = [
            @foreach($studios as $studio)
      {
        lat: {{ $studio['studio_lat' ]}},
        long: {{ $studio['studio_long' ]}},
        studio: @json($studio),
        icon: {
          url: '{{ $studio['studio_icon'] }}', // url
          scaledSize: new google.maps.Size(50, 50), // scaled size
        },
      },
        @endforeach
    ]

    // Create markers.
    for (var i = 0; i < studios.length; i++) {
      var marker =
        new google.maps.Marker({
          position: new google.maps.LatLng(studios[i].lat, studios[i].long),
          icon: studios[i].icon,
          map: map,
        })
      marker.addListener('mouseover', function (e) {
        var lat = Math.round(e.latLng.lat() * 10000000) / 10000000
        var long = Math.round(e.latLng.lng() * 10000000) / 10000000
        var x = e.ya.x
        var y = e.ya.y

        var studio = studios.find(function (studio) {
          return studio.lat == lat && studio.long == long
        })
        // $('.map-detail .title').text(lat)

        $('.map-detail').css('display', 'block')
        $('.map-detail').css('top', y)
        $('.map-detail').css('left', x)

        if ($('.map-detail').html().trim() === '' || $('.map-detail #studioId').attr('val') != studio.studio.studio_id) {
          $('.map-detail').html(mapCard(studio.studio))
          $.ajax({
            url: '/content/studio/' + studio.studio.studio_id + '/master',
            type: 'get',
            success: function (res) {
              $('.map-detail .master-list').html(res)
            },
          })
        }

      })
      marker.addListener('mouseout', function () {

        $('.map-detail').css('display', {{ empty($show) ? 'none' : 'block' }})
      })

    }

  }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBCKX_QDAbkV66e1NLEnJ2KDH0b1bALvIc&callback=initMap">
</script>