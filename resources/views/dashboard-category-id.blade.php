@extends('dashboard')

@section('page', 'category')

@section('style')
    <link rel="stylesheet" href="/css/dashboard.studio.css?v=1.0">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css?v=1.0" rel="stylesheet">
    <style>
        .text-editor {
            border: none;
            overflow: auto;
            outline: none;

            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            box-shadow: none;

            resize: none; /*remove the resize handle on the bottom right*/
            width: 100%;
            height: 100px;
        }
    </style>
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
        <h3 align="center">Edit Category</h3>
        <form onsubmit="editor()" class="studio-form" method="post"
              action="/dashboard/category/{{ $category['category_id'] }}"
              enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="activity_name">Category name</label><br />
                <input required type="text" name="category_name"
                       value="{{ $category['category_name'] }}"
                       class="form-control" maxlength="50">
            </div>

            <div class="form-group">
                <label for="activity_name">Category icon<span class="required"> * Extension : .png or .svg</span></label><br />
                <img src="{{ $category['category_pic'] }}" class="preview">
                <input type="file" name="category_pic">
            </div>

            <div class="form-group">
                <label for="activity_name">Category background<span class="required"> * Dimension : 1280 x 720</span></label><br />
                <img src="{{ $category['category_bg'] }}" class="preview">
                <input type="file" name="category_bg">
            </div>

            <div class="form-group">
                <label for="activity_name">Category video<span class="required"><br />* Resolution : 720p, Dimension : 1280 x 720, Lenght : 3 min</span></label><br />
                <div class="image-wrapper" id="bg-video">
                    <video src="{{ $category['category_video'] }}" class="preview" autoplay loop
                           muted playsinline>
                    </video>
                    <input type="file" name="category_video" accept="video/*">
                </div>
            </div>

            <div align="center">
                <button class="btn btn-primary mt-2" type="submit">
                    Edit
                </button>
            </div>
        </form>


    </div>
@endsection

@section('script')



    <script>
      $(document).ready(function () {
        $('.studio-wrapper').delegate('input[type=file]', 'change', function () {

          $(this).prev().attr('src', URL.createObjectURL(this.files[0]))

        })

          @if($errors->any())
          alert('{{ $errors->first() }}')
          @endif
      })
    </script>
@endsection