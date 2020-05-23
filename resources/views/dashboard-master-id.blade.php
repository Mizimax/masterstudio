@extends('dashboard')

@section('page', 'master')

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
        @if($master)
            <h3 align="center">Master {{ $master['master_id'] }}</h3>
            <form class="studio-form" method="post"
                  action="/dashboard/master/{{ $master['master_id'] }}"
                  onsubmit="emailCheck()"
                  enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="master_name">Master name</label>
                    <input required type="text" name="master_name"
                           value="{{ $master['master_name'] }}"
                           class="form-control">
                </div>

                <div class="form-group">
                    <label for="master_nickname">Master nickname</label>
                    <input required type="text" name="master_nickname"
                           value="{{ $master['master_nickname'] }}"
                           class="form-control">
                </div>

                <div class="form-group">
                    <label for="master_location">Studio</label>
                    <select name="studio_id" class="form-control" required>
                        <option value="{{ $master['studio_id'] }}">{{ $studios[array_search($master['studio_id'], array_column($studios->toArray(), 'studio_id'))]['studio_name'] }}</option>
                        @foreach($studios as $studio)
                            @if($studio->studio_id !==  $master['studio_id'])
                                <option value="{{ $studio['studio_id'] }}">{{ $studio['studio_name'] }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="master_recommend">Master recommended</label>
                    <select required name="master_recommend" class="form-control">
                        @if($master['master_recommend'] === 1)
                            <option value="1">Recommend</option>
                            <option value="2">Most Recommend</option>
                        @else
                            <option value="2">Most Recommend</option>
                            <option value="1">Recommend</option>
                        @endif
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="category_id">Master category</label>
                    <select required name="category_id" class="form-control">
                        <option value="{{ $master['category_id'] }}">{{ $categories[array_search($master['category_id'], array_column($categories->toArray(), 'category_id'))]['category_name'] }}</option>
                        @foreach($categories as $cg)
                            @if($cg['category_id'] != $master['category_id'])
                                <option value="{{ $cg['category_id'] }}">{{ $cg['category_name'] }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="user_name">User name</label>
                    <input required type="text" name="user_name"
                           value="{{ $master['user_name'] }}"
                           class="form-control">
                </div>
                <div class="form-group">
                    <label for="user_email">User email</label>
                    <input type="text" name="user_email"
                           value="{{ $master['user_email'] }}"
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
                    <img src="{{ $master['user_pic'] }}" class="preview">
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

      function emailCheck() {
        if ($('input[name=user_email]').val() == '{{ $master['user_email'] }}') {
          $('input[name=user_email]').val('')
        }
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