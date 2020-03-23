@extends('dashboard')

@section('page', 'master')

@section('style')
    <link rel="stylesheet" href="/css/dashboard.studio.css">
@endsection

@section('content')
    <div class="studio-wrapper">


        <h3 align="center">Create Master</h3>
        <form class="studio-form" method="post" action="/dashboard/master"
              enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="master_name">Master name</label>
                <input required type="text" name="master_name"
                       class="form-control">
            </div>

            <div class="form-group">
                <label for="master_nickname">Master nickname</label>
                <input required type="text" name="master_nickname"
                       class="form-control">
            </div>

            <div class="form-group">
                <label for="master_location">Master location</label>
                <input type="text" name="master_location"
                       class="form-control">
            </div>

            <div class="form-group">
                <label for="master_location">Master recommended</label>
                <select required name="category_id" class="form-control">
                    <option value="0">No</option>
                    <option value="1">Recommend</option>
                    <option value="2">Most Recommend</option>
                </select>
            </div>

            <div class="form-group">
                <label for="master_recommended">Master category</label>
                <select required name="master_recommended" class="form-control">
                    @foreach($categories as $cg)
                        <option value="{{ $cg['category_id'] }}">{{ $cg['category_name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="user_name">User name</label>
                <input required type="text" name="user_name"
                       class="form-control">
            </div>
            <div class="form-group">
                <label for="user_email">User email</label>
                <input required type="text" name="user_email"
                       class="form-control">
            </div>
            <div class="form-group">
                <label for="user_password">New password</label>
                <input type="password" name="user_password"
                       class="form-control">
            </div>
            <div class="form-group">
                <label for="confirm_user_password">Confirm password</label>
                <input type="password" name="confirm_user_password"
                       class="form-control">
            </div>
            <div class="form-group">
                <label for="user_pic">User profile picture</label><br>
                <img src="" class="preview">
                <input type="file" name="user_pic" accept="image/*">
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

          @if($errors->any())
          alert('{{ $errors->first() }}')
          @endif
      })
    </script>
@endsection