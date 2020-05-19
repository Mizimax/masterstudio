@extends('dashboard')

@section('page', 'studio')

@section('style')
    <link rel="stylesheet" href="/css/dashboard.studio.css?v=1.1">
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
                <div class="form-group">
                    <label for="studio_location">Studio location<span class="required">
                            * Embed url only !</span></label>
                    <input type="text" required name="studio_location"
                           value="{{ $studios['studio_location'] }}"
                           class="form-control">
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
      $(document).ready(function () {
        $('.studio-form').delegate('input[type=file]', 'change', function () {

          $(this).prev().attr('src', URL.createObjectURL(this.files[0]))
        })
      })
    </script>
@endsection