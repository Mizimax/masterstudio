@extends('dashboard')

@section('page', 'activity')

@section('style')
    <link rel="stylesheet" href="/css/dashboard.studio.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
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
        <h3 align="center">Create Activity</h3>
        <form onsubmit="editor()" class="studio-form" method="post"
              action="/dashboard/activity"
              enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="activity_name">Activity name</label>
                <input required type="text" name="activity_name"
                       class="form-control">
            </div>

            <div class="form-group">
                <label for="master_nickname">Activity url</label>
                <input required type="text" name="activity_url_name"
                       class="form-control">
            </div>

            <div class="form-group">
                <label for="studio_description">Activity description</label>
                <textarea required name="activity_description"
                          class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="activity_description">Activity preparing</label>
                <input type="hidden" name="activity_prepare" id="editor-input">
                <div class="text-editor" id="editor">
                </div>
            </div>

            <div class="form-group">
                <label for="master_recommended">Activity category</label>
                <select required name="master_recommended" class="form-control">
                    @foreach($categories as $cg)
                        <option value="{{ $cg['category_id'] }}">{{ $cg['category_name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="master_recommended">Activity achievement</label>
                <select required name="master_recommended" class="form-control">
                    @foreach($achievement as $ach)
                        <option value="{{ $ach['achievement_id'] }}">{{ $ach['achievement_name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="activity_video">Activity video</label><br>
                <div class="image-wrapper" id="bg-video">
                </div>
                <button type="button" class="btn btn-primary mt-2" onclick="addVideo()">+
                    Add another video
                </button>
            </div>

            <div class="form-group">
                <label for="studio_icon">Activity image</label><br>

                <div class="image-wrapper" id="bg-image">
                </div>


                <button type="button" class="btn btn-primary mt-2" onclick="addImage()">+
                    Add another image
                </button>
            </div>

            <div class="form-group">
                <label for="activity_benefit">Activity benefit</label><br />
                <div align="center">
                    <button type="button" class="btn btn-primary mt-2" onclick="addBenefit()">+
                        Add another benefit
                    </button>
                </div>
                <div class="benefit-wrapper">
                </div>
            </div>

            <div class="form-group">
                <label for="activity_difficult">Activity difficult</label>
                <select required name="activity_difficult" class="form-control">
                    <option value="Basic">Basic</option>
                    <option value="Advance">Advance</option>
                </select>
            </div>

            <div class="form-group">
                <label for="activity_difficult">Activity time type</label>
                <select required name="activity_difficult" class="form-control">
                    <option value="0">One time Activity</option>
                    <option value="1">Routine Activity</option>
                </select>
            </div>

            <div class="form-group">
                <label for="activity_apply_start">Activity apply date</label><br />
                <input type="date" name="activity_apply_start"> -
                <input type="date" name="activity_apply_end">
            </div>

            <div class="form-group">
                <label for="activity_start">Activity start date</label><br />
                <input type="date" name="activity_start"> -
                <input type="date" name="activity_end">
            </div>

            <div class="form-group">
                <label for="goal">Routine day</label>
                <div class="d-flex justify-content-between">
                    <button type="button" class="select-button flex-grow-1" value="1">Monday
                    </button>
                    <button type="button" class="select-button flex-grow-1" value="2">Tuesday
                    </button>
                    <button type="button" class="select-button flex-grow-1" value="3">
                        Wednesday
                    </button>
                    <button type="button" class="select-button flex-grow-1" value="4">Thursday
                    </button>
                    <button type="button" class="select-button flex-grow-1" value="5">Friday
                    </button>
                    <button type="button" class="select-button flex-grow-1" value="6">Saturday
                    </button>
                    <button type="button" class="select-button flex-grow-1" value="7">Sunday
                    </button>
                    <input name="activity_routine_day" type="hidden">
                </div>
            </div>

            <div class="form-group">
                <label for="activity_start">Activity time start</label><br />
                <input type="time" name="activity_start"> -
                <input type="time" name="activity_end">
            </div>

            <div class="form-group">
                <label for="activity_price">Activity price</label>
                <div class="d-flex" style="width: 250px">
                    <input required type="text" name="activity_price"
                           class="form-control">
                    <select name="activity_price_type" class="form-control"
                            style="width: 120px; margin-left: 10px">
                        <option value="0">per activity</option>
                        <option value="1">per hour</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="activity_hour">Activity hour</label>
                <input required type="text" name="activity_hour"
                       class="form-control" style="width: 140px">

            </div>

            <div class="form-group">
                <label for="activity_max">Activity max apply</label>
                <input required type="text" name="activity_max"
                       class="form-control" style="width: 140px">

            </div>

            <div class="form-group">
                <label for="activity_location_name">Activity location name</label>
                <input required type="text" name="activity_location_name"
                       class="form-control">

            </div>

            <div class="form-group">
                <label for="activity_location">Activity location url</label>
                <input required type="text" name="activity_location"
                       class="form-control">

            </div>

            <div class="form-group">
                <label for="studio_icon">Activity sponsor</label><br>

                <div class="image-wrapper" id="sponsor-image">
                </div>


                <button type="button" class="btn btn-primary mt-2" onclick="addSponsor()">+
                    Add another sponsor
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
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
      var quill = new Quill('#editor', {
        theme: 'snow',
      })

    </script>

    <script>
      function addImage() {
        var bg = `
            <img src="" class="preview">
            <input type="file" name="activity_pic[]" accept="image/*">
        `
        $('#bg-image').append(bg)
      }

      function addSponsor() {
        var sponsor = `
            <input required type="text" name="sponsor_name[]" placeholder="Sponsor name"><br />
                            <input required type="text" name="sponsor_link[]" placeholder="Sponsor link"><br />
                            <img src="" class="preview">
                            <input required type="file" name="sponsor_pic[]" accept="image/*">
                            <br/> <br/>
        `
        $('#sponsor-image').append(sponsor)

      }

      function addVideo() {
        var bg = `
            <video src="" class="preview" autoplay loop muted playsinline>
                                    </video>
            <input type="file" name="activity_video[]" accept="video/*">
        `
        $('#bg-video').append(bg)
      }

      function addBenefit() {
        var benefit = `
            <div class="benefit-card"
                                 style="background-color: white">
                                <div class="overlay" style="border-radius: 10px;"></div>
                                <div class="edit-wrapper" tabindex="-1">
                                    <div class="edit-pic">
                                        <img class="icon" src="/img/icon/edit.png">
                                    </div>
                                    <input class="benefit-file --bg benefit-bg" name="bg[]" required id="benefit-bg"
                                           type="file" accept="image/*">
                                    <input class="benefit-file --icon benefit-pic" name="pic[]" required id="benefit-icon"
                                           type="file" accept="image/*">
                                    <div class="edit-dropdown">
                                        <div class="edit-menu edit" onclick="benefitBg(this)">
                                            Change background
                                        </div>
                                        <div class="edit-menu edit" onclick="benefitPic(this)">
                                            Change icon
                                        </div>
                                    </div>
                                </div>
                                <div class="content">
                                    <img class="svg" src="/img/profile.jpg" alt="">
                                    <div class="name"><input type="text" required name="benefit_name[]" placeholder="Title"
                                                             value=""
                                                                     style="width: 100%"></div>

                  <div class="description">
                      <textarea required name="benefit_desc[]" id="" cols="30"
                                rows="10" placeholder="Description"></textarea>
                                                </div>

                  </div>
              </div>
        `

        $('.benefit-wrapper').append(benefit)

      }

      function editor() {
        $('#editor-input').val(JSON.stringify($('#editor > .ql-editor').html()))
      }

      function sortAlphabet(str) {
        var arraySplit = str.split('')
        var arraySort = arraySplit.sort()
        var arrayJoin = arraySplit.join('')
        return arrayJoin
      }

      function selectButton() {
        $('.select-button').off('click').on('click', function () {
          var input = $(this).siblings('input[type="hidden"]')
          var value = $(this).attr('value')
          if ($(this).hasClass('active')) {
            var index = input.val().indexOf(value)
            var newValue = input.val()
            var result = sortAlphabet(newValue.slice(0, index) + newValue.slice(index + 1))
            input.val(result)
          } else {
            var appendValue = input.val() + value
            input.val(sortAlphabet(appendValue))
          }
          $(this).toggleClass('active')
        })
      }

      function benefitBg(ele) {
        $(ele).parent().siblings('.benefit-file.--bg').trigger('click')
      }

      function benefitPic(ele) {
        $(ele).parent().siblings('.benefit-file.--icon').trigger('click')
      }

      $('.edit-wrapper').delegate('.benefit-file.--bg', 'change', function () {
        $(this).parents('.benefit-card').css('background-image', 'url(' + URL.createObjectURL(this.files[0]) + ')')
      })

      $('.benefit-file.--icon').change(function () {
        $(this).parents('.benefit-card').children('.content').children('.svg').attr('src', URL.createObjectURL(this.files[0]))
      })
    </script>

    <script>
      $(document).ready(function () {
        $('.studio-form').delegate('input[type=file]', 'change', function () {

          $(this).prev().attr('src', URL.createObjectURL(this.files[0]))

        })

        selectButton()
          @if($errors->any())
          alert('{{ $errors->first() }}')
          @endif
      })
    </script>
@endsection