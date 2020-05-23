@extends('dashboard')

@section('page', 'studio')

@section('style')
    <link rel="stylesheet" href="/css/dashboard.studio.css?v=1.2">
@endsection

@section('content')
    <div class="studio-wrapper">
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{!! \Session::get('success') !!}</li>
                </ul>
            </div>
        @endif
        @if($studios)
            <h3 align="center">Studio {{ $studios['studio_id'] }}</h3>
            <form class="studio-form" method="post"
                  action="/dashboard/studio/{{ $studios['studio_id'] }}"
                  enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="studio_name">Studio name<span class="required"> * ความยาวไม่เกิน 50 คำ</span></label>
                    <input required type="text" name="studio_name"
                           value="{{ $studios['studio_name'] }}"
                           class="form-control">
                </div>
                <div class="form-group">
                    <label for="studio_name">Studio title<span class="required"> * ความยาวไม่เกิน 150 คำ</span></label>
                    <input required type="text" name="studio_title"
                           value="{{ $studios['studio_title'] }}"
                           class="form-control">
                </div>
                <div class="form-group">
                    <label for="studio_user">Studio owner</label>
                    <select required name="studio_user" class="form-control">
                        <option value="{{ $studios['studio_user'] }}">{{ count($masters) !== 0 ? $masters[array_search($studios['studio_user'], array_column($masters->toArray(), 'user_id'))]['master_name'] : $joinMasters[array_search($studios['studio_user'], array_column($joinMasters->toArray(), 'user_id'))]['master_name'] }}</option>
                        @foreach($joinMasters as $master)
                            @if($master['user_id'] != $studios['studio_user'])
                                <option value="{{ $master['user_id'] }}">{{ $master['master_name'] }}</option>
                            @endif
                        @endforeach
                        @foreach($masters as $master)
                            <option value="{{ $master['user_id'] }}">{{ $master['master_name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select required name="category_id" class="form-control">
                        <option value="{{ $studios['category_id'] }}">{{ $categories[array_search($studios['category_id'], array_column($categories->toArray(), 'category_id'))]['category_name'] }}</option>
                        @foreach($categories as $cg)
                            @if($cg['category_id'] != $studios['category_id'])
                                <option value="{{ $cg['category_id'] }}">{{ $cg['category_name'] }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="studio_description">Studio description<span class="required"> * ความยาวไม่เกิน 500 คำ</span></label>
                    <textarea required name="studio_description"
                              class="form-control">{{ $studios['studio_description'] }}</textarea>
                </div>
                <div class="form-group max">
                    <div class="flex column">
                        <label for="studio_location">Studio location</label>
                        <div>Current Location : {{ $studios['studio_location'] }}</div>
                        <br>
                        <input {{ !$studios['studio_location'] ? 'required' : '' }} type="text"
                               class="form-control" id="map-input" name="studio_location">
                        <div class="icon map mar-side" id="map" data-target="#map">
                            <span class="glyphicon glyphicon-map-marker"
                                  style="color:#ED1C24; font-size: 24px"></span>
                        </div>
                        <input type="hidden" name="studio_lat" id="studio-lat"
                               value="{{ $studios['studio_lat'] }}">
                        <input type="hidden" name="studio_long" id="studio-long"
                               value="{{ $studios['studio_long'] }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="studio_icon">Studio icon</label><br>
                    <img src="{{ $studios['studio_icon'] }}" class="preview">
                    <input type="file" name="studio_icon" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="studio_icon">Studio background<span class="required"> * Dimension : 1280 x 720</span></label><br>

                    <div class="image-wrapper" id="bg-image">
                        @foreach($studios['studio_bg'] as $bg)
                            <img src="{{ $bg }}" class="preview">
                            <input type="file" name="studio_bg[]" accept="image/*">
                        @endforeach
                    </div>


                    <button type="button" class="primary-button mt-2" onclick="addImage()">+
                        Add another image
                    </button>
                </div>

                <div class="form-group">
                    <label for="studio_icon">Studio video<span class="required"><br />* Resolution : 720p, Dimension : 1280 x 720, Lenght : 3 min</span></label><br>
                    @foreach($studios['studio_video'] as $video)
                        <video src="{{ $video }}" class="preview" autoplay muted
                               playsinline>
                        </video>
                        <input type="file" name="studio_video[]" accept="video/*">
                    @endforeach
                </div>


                <div class="form-group">
                    <label for="studio_icon">Studio background video<span class="required"><br />* Resolution : 720p, Dimension : 1280 x 720, Lenght : 3 min</span></label><br>
                    <div class="image-wrapper" id="bg-video">
                        @foreach($studios['studio_video'] as $i => $video)
                            @if($i != 0)
                                <video src="{{ $video }}" class="preview" autoplay muted
                                       playsinline>
                                </video>
                                <input type="file" name="studio_video[]"
                                       accept="video/*">
                            @endif
                        @endforeach
                    </div>
                    <button type="button" class="primary-button mt-2" onclick="addVideo()">+
                        Add another video
                    </button>
                </div>

                <div class="form-group">
                    <label for="studio_icon">Studio masters</label><br>
                    <ul id="master-list">
                        @foreach($joinMasters as $master)
                            <li class="my-2">{{ $master['master_name'] }}</li>
                        @endforeach
                    </ul>
                    @if(count($masters) !== 0)
                        <select class="form-control" id="add-master">
                            @foreach($masters as $master)
                                <option value="{{ $master['master_id'] }}">{{ $master['master_name'] }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="primary-button mt-2" onclick="addMaster()">
                            Add
                        </button>
                    @endif
                </div>

                <div class="submit-wrapper">
                    <button class="btn btn-primary btn-fixed" type="submit">
                        Save
                    </button>
                </div>
            </form>
        @else
            <div align="center" style="padding: 20px">
                You don't own this studio.<br>
                The studio can only be edited by the owner
            </div>
        @endif


    </div>
@endsection

@section('script')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuZw-uZ7-QCzHUXdmk7JxIdZRWK6jqknE&libraries=places&callback=initMap"
            async defer></script>
    <script>
      function addImage() {
        var bg = `
            <img src="" class="preview">
            <input type="file" name="studio_bg[]" accept="image/*">
        `
        $('#bg-image').append(bg)
      }

      function addVideo() {
        var bg = `
            <video src="" class="preview">
                                    </video>
            <input type="file" name="studio_video[]" accept="video/*">
        `
        $('#bg-video').append(bg)
      }

      function addMaster() {
        $.ajax({
          url: './{{ $studios['studio_id'] }}/master/' + $('#add-master').val(),
          type: 'post',
          processData: false,
          contentType: 'application/json',
          data: JSON.stringify({
            '_token': $('meta[name="csrf-token"]').attr('content'),
          }),
          success: function (data) {
            $('#master-list').append('<li class="mt-2">' + $('#add-master')[0].options[$('#add-master')[0].selectedIndex].text + '</li>')
            $('#add-master')[0].options[$('#add-master')[0].selectedIndex].remove()
          },
          error: function (err) {
          },
        })
      }
    </script>

    <script>
      var prevMarker
      var prevLocation

      function initMap() {
        var myLatlng = new google.maps.LatLng(13.847860, 100.604274)
        var mapOptions = {
          center: myLatlng,
          zoom: 12,
        }

        var maps = new google.maps.Map(document.getElementById('map'), mapOptions)

        var infowindow = new google.maps.InfoWindow()

        var autocomplete = new google.maps.places.Autocomplete(document.getElementById('map-input'))
        autocomplete.bindTo('bounds', maps)

        autocomplete.addListener('place_changed', function () {
          infowindow.close()
          var place = autocomplete.getPlace()

          prevLocation = place
          if (!place.geometry) {
            return
          }

          if (place.geometry.viewport) {
            maps.fitBounds(place.geometry.viewport)
          } else {
            maps.setCenter(place.geometry.location)
            maps.setZoom(12)
          }

          $('#studio-lat').val(place.geometry.location.lat())
          $('#studio-long').val(place.geometry.location.lng())

          prevMarker.setMap(null)

          // Set the position of the marker using the place ID and location.
          marker.setPlace({
            placeId: place.place_id,
            location: place.geometry.location,
          })
          marker.setVisible(true)
          prevMarker = marker

          infowindow.setContent('<b>' + place.name + '</b><br><br>' + place.adr_address + '')
          infowindow.open(maps, marker)
        })

        var marker = new google.maps.Marker({
          draggable: false,
          position: prevLocation ? prevLocation.location : myLatlng,
        })

        if (prevLocation) {
          marker.setPlace({
            placeId: prevLocation.place_id,
            location: prevLocation.geometry.location,
          })
          marker.setVisible(true)

          infowindow.setContent('<b>' + prevLocation.name + '</b><br><br>' + prevLocation.adr_address + '')
          infowindow.open(maps, marker)
        }

        prevMarker = marker

        google.maps.event.addListener(maps, 'place_changed', function (event) {
          console.log('>> event: ', event)
        })

        google.maps.event.addListener(maps, 'click', function (event) {
          var marker = new google.maps.Marker({
            position: event.latLng,
            map: maps,
          })
          if (event.placeId) {
            prevMarker.setMap(null)
            getDetail(maps, event.placeId)
          } else {
            infowindow.setContent('ไม่พบสถานที่')
            addMarker(maps, marker)
          }
          infowindow.open(maps, marker)

        })

        // Add a marker at the center of the map.
        addMarker(maps, marker)
      }

      function addMarker(map, marker) {

        prevMarker.setMap(null)
        prevMarker = marker

        marker.setMap(map)
      }

      function getDetail(maps, myPlaceId) {
        var service = new google.maps.places.PlacesService(maps)

        service.getDetails({
          placeId: myPlaceId,
        }, function (place, status) {
          prevMarker.setMap(null)
          if (status === google.maps.places.PlacesServiceStatus.OK) {
            $('#studio-lat').val(place.geometry.location.lat())
            $('#studio-long').val(place.geometry.location.lng())
            $('#map-input').val(place.name + ' ' + place.formatted_address)
          }
        })
      }
    </script>

    <script>
      $(document).ready(function () {
          @if($errors->any())
          alert('{{ $errors->first() }}')
          @endif
          $('.studio-form').delegate('input[type=file]', 'change', function () {

            $(this).prev().attr('src', URL.createObjectURL(this.files[0]))

          })
      })
    </script>
@endsection