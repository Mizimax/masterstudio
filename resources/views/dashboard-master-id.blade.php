@extends('dashboard')

@section('page', 'master')

@section('style')
    <link rel="stylesheet" href="/css/dashboard.studio.css">
@endsection

@section('content')
    <div class="studio-wrapper">

        @if($master)
            <h3 align="center">Studio {{ $master['master_id'] }}</h3>
            <form class="studio-form" method="post"
                  action="/dashboard/studio/{{ $master['master_id'] }}"
                  enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="studio_name">Master name</label>
                    <input required type="text" name="studio_name"
                           value="{{ $master['master_name'] }}"
                           class="form-control">
                </div>
                <div class="form-group">
                    <label for="studio_name">Studio title</label>
                    <input required type="text" name="studio_title"
                           value="{{ $master['studio_title'] }}"
                           class="form-control">
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
                    <label for="studio_description">Studio description</label>
                    <textarea required name="studio_description"
                              class="form-control">{{ $studios['studio_description'] }}</textarea>
                </div>
                <div class="form-group">
                    <label for="studio_location">Studio location</label>
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
                    <label for="studio_icon">Studio background</label><br>

                    <div class="image-wrapper" id="bg-image">
                        @foreach($studios['studio_bg'] as $bg)
                            <img src="{{ $bg }}" class="preview">
                            <input type="file" name="studio_bg[]" accept="image/*">
                        @endforeach
                    </div>


                    <button type="button" class="btn btn-primary mt-2" onclick="addImage()">+
                        Add another image
                    </button>
                </div>
                <div class="form-group">
                    <label for="studio_icon">Studio video</label><br>
                    <video src="{{ $studios['studio_video'][0] }}" class="preview">
                    </video>
                    <input type="file" name="studio_video[]" accept="video/*">
                </div>
                <div class="form-group">
                    <label for="studio_icon">Studio background video</label><br>
                    <div class="image-wrapper" id="bg-video">
                        @foreach($studios['studio_video'] as $i => $video)
                            @if($i != 0)
                                <video src="{{ $video }}" class="preview">
                                </video>
                                <input type="file" name="studio_video[]"
                                       accept="video/*">
                            @endif
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-primary mt-2" onclick="addVideo()">+
                        Add another video
                    </button>
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
    </script>

    <script>
      $(document).ready(function () {
        $('.studio-form').delegate('input[type=file]', 'change', function () {

          $(this).prev().attr('src', URL.createObjectURL(this.files[0]))
        })
      })
    </script>
@endsection