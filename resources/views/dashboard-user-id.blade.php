@extends('dashboard')

@section('page', 'studio')

@section('style')
    <link rel="stylesheet" href="/css/dashboard.studio.css">
@endsection

@section('content')
    <div class="studio-wrapper">

        @if($user)
            <h3 align="center">User {{ $user['user_id'] }}</h3>
            <form class="studio-form" method="post"
                  action="/dashboard/user/{{ $user['user_id'] }}"
                  enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="user_name">User name</label>
                    <input required type="text" name="user_name"
                           value="{{ $user['user_name'] }}"
                           class="form-control">
                </div>
                <div class="form-group">
                    <label for="user_email">User email</label>
                    <input required type="text" name="user_email"
                           value="{{ $user['user_email'] }}"
                           class="form-control">
                </div>
                <div class="form-group">
                    <label for="user_email">New password</label>
                    <input type="password" name="user_password"
                           class="form-control">
                </div>
                <div class="form-group">
                    <label for="user_email">Confirm password</label>
                    <input type="password" name="confirm_user_password"
                           class="form-control">
                </div>
                <div class="form-group">
                    <label for="user_pic">User profile picture</label><br>
                    <img src="{{ $user['user_pic'] }}" class="preview">
                    <input type="file" name="user_pic" accept="image/*">
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
