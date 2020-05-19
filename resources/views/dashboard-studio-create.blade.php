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
        <h3 align="center">Create Studio</h3>
        <form class="studio-form" method="post" action="/dashboard/studio"
              enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="studio_name">Studio name</label>
                <input required type="text" name="studio_name"
                       class="form-control">
            </div>
            <div class="form-group">
                <label for="studio_name">Studio title</label>
                <input required type="text" name="studio_title"
                       class="form-control">
            </div>
            <div class="form-group">
                <label for="studio_user">Studio owner</label>
                <select required name="studio_user" class="form-control">
                    <option value="">Select studio owner</option>
                    @foreach($masters as $master)

                        <option value="{{ $master['user_id'] }}">{{ $master['master_name'] }}</option>

                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="category_id">Category</label>
                <select required name="category_id" class="form-control">
                    <option value="">Select category</option>
                    @foreach($categories as $cg)
                        <option value="{{ $cg['category_id'] }}">{{ $cg['category_name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="studio_description">Studio description<span class="required"> * ความยาวไม่เกิน 500 คำ</span></label>
                <textarea required name="studio_description"
                          class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="studio_location">Studio location</label>
                <input type="text" required name="studio_location"
                       class="form-control">
            </div>
            <div class="form-group">
                <label for="studio_icon">Studio icon</label><br>
                <img src="" class="preview">
                <input type="file" name="studio_icon" accept="image/*">
            </div>
            <div class="form-group">
                <label for="studio_icon">Studio background<span class="required"> * Dimension : 1280 x 720</span></label><br>

                <div class="image-wrapper" id="bg-image">
                    <img src="" class="preview">
                    <input type="file" name="studio_bg[]" accept="image/*">
                </div>

                <button type="button" class="primary-button mt-2" onclick="addImage()">+
                    Add another image
                </button>
            </div>
            <div class="form-group">
                <label for="studio_icon">Studio video<span class="required"><br />* Resolution : 720p, Dimension : 1280 x 720, Lenght : 3 min</span></label><br>
                <video src="" class="preview">
                </video>
                <input type="file" name="studio_video[]" accept="video/*">
            </div>
            <div class="form-group">
                <label for="studio_icon">Studio background video<span class="required"><br />* Resolution : 720p, Dimension : 1280 x 720, Lenght : 3 min</span></label><br>
                <div class="image-wrapper" id="bg-video">

                    <video src="" class="preview">
                    </video>
                    <input type="file" name="studio_video[]"
                           accept="video/*">

                </div>
                <button type="button" class="primary-button mt-2" onclick="addVideo()">+
                    Add another video
                </button>
            </div>
            <div class="submit-wrapper">
                <button class="btn btn-primary btn-fixed" type="submit">
                    Save
                </button>
            </div>
        </form>


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
    </script>

    <script>
      $(document).ready(function () {
        $('.studio-form').delegate('input[type=file]', 'change', function () {

          $(this).prev().attr('src', URL.createObjectURL(this.files[0]))
        })
      })
    </script>
@endsection