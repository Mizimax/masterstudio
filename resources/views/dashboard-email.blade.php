@extends('dashboard')

@section('page', 'user')

@section('style')
    <link rel="stylesheet" href="/css/dashboard.studio.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        #editor-container {
            height: 250px;
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
        <h3 align="center">Send mail</h3>
        <form class="studio-form" method="post"
              action="/dashboard/mail"
              onsubmit="editor()"
              enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="user_name">Send to</label>
                <select required name="email_sendto" class="form-control" onchange="sendTo(this)">
                    <option value="">Select target</option>
                    <option value="1">All subscriber</option>
                    <option value="2">All users</option>
                    <option value="3">All masters</option>
                    <option value="4">Specific user</option>
                </select>
            </div>
            <div class="form-group d-none" id="specific">
                <label for="user_email">Specific user</label>
                <select name="email_user"
                        class="form-control">
                    <option value="">Select user</option>
                    @foreach($users as $user)
                        <option value="{{ $user['user_id'] }}">{{ $user['user_id'] . ' ' . $user['user_name'] . ' ' . $user['user_email'] }}</option>
                    @endforeach
                </select>
            </div>
            {{--            <div class="form-group">--}}
            {{--                <label for="user_email">Template</label>--}}
            {{--                <select required name="email_template" id="template" class="form-control">--}}
            {{--                    <option value="">Select template</option>--}}
            {{--                    <option value="1">News</option>--}}
            {{--                    <option value="2">Custom</option>--}}
            {{--                </select>--}}
            {{--            </div>--}}
            <div class="form-group">
                <label for="user_email">Subject</label>
                <input required type="text" name="email_subject"
                       class="form-control">
            </div>
            <div class="form-group">
                <label for="user_pic">Description</label><br>
                <input type="hidden" name="email_description" id="editor-input">
                <div id="editor-container">

                </div>

            </div>
            <div align="center">
                <button class="btn btn-primary" type="submit">
                    Send
                </button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script src="/js/quill.min.js"></script>

    <script>
      var toolbarOptions = [
        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
        ['blockquote', 'code-block'],

        [{ 'header': 1 }, { 'header': 2 }],               // custom button values
        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
        [{ 'indent': '-1' }, { 'indent': '+1' }],          // outdent/indent
        [{ 'direction': 'rtl' }],                         // text direction

        [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        ['link', 'image', 'video'],          // add's image support
        [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
        [{ 'align': [] }],

        ['clean'],                                         // remove formatting button
      ]

      var quill = new Quill('#editor-container', {
        modules: {
          toolbar: toolbarOptions,
        },
        theme: 'snow',
      })
    </script>

    <script>

      var newsTemplate = `Hello, <span class="text-name"></span><br/><p style="text-indent: 50px">dafasmfdmklsamkfdlmsafmksamf</p><br/>Best regards, <span class="text-name"></span>

        `


    </script>

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

      function editor() {
        $('#editor-input').val($('#editor-container > .ql-editor').html())
      }

      function sendTo(ele) {
        if (ele.value == 4) {
          $('#specific').removeClass('d-none')
        } else {
          $('#specific').addClass('d-none')
        }
      }
    </script>

    <script>
      $(document).ready(function () {
        $('.studio-form').delegate('input[type=file]', 'change', function () {

          $(this).prev().attr('src', URL.createObjectURL(this.files[0]))

        })

        // $('#template').change(function () {
        //   if ($(this).val() == 1) {
        //     $('#editor-container > .ql-editor').html(newsTemplate)
        //   } else {
        //     $('#editor-container > .ql-editor').html()
        //   }
        // })

          @if($errors->any())
          alert('{{ $errors->first() }}')
          @endif
      })
    </script>
@endsection
