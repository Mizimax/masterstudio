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

        @if($activity)
            <h3 align="center">Activity {{ $activity['activity_id'] }}</h3>
            <form onsubmit="editor()" class="studio-form" method="post"
                  action="/dashboard/activity/{{ $activity['activity_id'] }}"
                  enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="activity_name">Activity name</label>
                    <input required type="text" name="activity_name"
                           value="{{ $activity['activity_name'] }}"
                           class="form-control">
                </div>

                <div class="form-group">
                    <label for="master_nickname">Activity url</label>
                    <input required type="text" name="activity_url_name"
                           value="{{ $activity['activity_url_name'] }}"
                           class="form-control">
                </div>

                <div class="form-group">
                    <label for="studio_description">Activity description</label>
                    <textarea required name="activity_description"
                              class="form-control">{{ $activity['activity_description'] }}</textarea>
                </div>

                <div class="form-group">
                    <label for="activity_description">Activity preparing</label>
                    <input type="hidden" name="activity_prepare" id="editor-input">
                    <div class="text-editor" id="editor">
                        {!! $activity['activity_prepare'] !!}
                    </div>
                </div>

                <div class="form-group">
                    <label for="master_recommended">Activity category</label>
                    <select required name="master_recommended" class="form-control">
                        <option value="{{ $activity['category_id'] }}">{{ $categories[array_search($activity['category_id'], array_column($categories->toArray(), 'category_id'))]['category_name'] }}</option>
                        @foreach($categories as $cg)
                            @if($cg['category_id'] != $activity['category_id'])
                                <option value="{{ $cg['category_id'] }}">{{ $cg['category_name'] }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="master_recommended">Activity achievement</label>
                    <select required name="master_recommended" class="form-control">
                        <option value="{{ $activity['achievement_id'] }}">{{ $achievement[array_search($activity['achievement_id'], array_column($achievement->toArray(), 'achievement_id'))]['achievement_name'] }}</option>
                        @foreach($achievement as $ach)
                            @if($ach['achievement_id'] != $activity['achievement_id'])
                                <option value="{{ $ach['achievement_id'] }}">{{ $ach['achievement_name'] }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="activity_video">Activity video</label><br>
                    <div class="image-wrapper" id="bg-video">
                        @foreach($activity['activity_video'] as $i => $video)
                            <video src="{{ $video }}" class="preview" autoplay muted playsinline>
                            </video>
                            <input type="file" name="activity_video[]"
                                   accept="video/*">
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-primary mt-2" onclick="addVideo()">+
                        Add another video
                    </button>
                </div>

                <div class="form-group">
                    <label for="studio_icon">Activity image</label><br>

                    <div class="image-wrapper" id="bg-image">
                        @foreach($activity['activity_pic'] as $pic)
                            <img src="{{ $pic }}" class="preview">
                            <input type="file" name="activity_pic[]" accept="image/*">
                        @endforeach
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
                        @foreach ($activity['activity_benefit'] as $benefit)
                            <div class="benefit-card"
                                 style="background-image: url('{{ $benefit['bg'] }}'); padding-top: {{ $benefit['text'] != '' ? '' : '180px' }}">
                                <div class="overlay" style="border-radius: 10px;"></div>
                                <div class="edit-wrapper" tabindex="-1">
                                    <div class="edit-pic">
                                        <img class="icon" src="/img/icon/edit.png">
                                    </div>
                                    <input class="benefit-file --bg benefit-bg" name="bg[]"
                                           id="benefit-bg"
                                           type="file" accept="image/*">
                                    <input class="benefit-file --icon benefit-pic" name="pic[]"
                                           id="benefit-icon"
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
                                    <img class="svg" src="{{ $benefit['pic'] }}" alt="">
                                    <div class="name"><input type="text" name="benefit_name[]"
                                                             value="{{ $benefit['name'] }}"
                                                             style="width: 100%"></div>
                                    @if($benefit['text'] != '')
                                        <div class="description">
                                            <textarea name="benefit_desc[]" id="" cols="30"
                                                      rows="10">{{ $benefit['text'] }}</textarea>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group">
                    <label for="activity_difficult">Activity difficult</label>
                    <select required name="activity_difficult" class="form-control">
                        <option value="{{ $activity['activity_difficult'] }}">{{ $activity['activity_difficult'] }}</option>
                        @if($activity['activity_difficult'] == 'Basic')
                            <option value="Advance">Advance</option>
                        @else
                            <option value="Basic">Basic</option>
                        @endif
                    </select>
                </div>

                <div class="form-group">
                    <label for="activity_difficult">Activity time type</label>
                    <select required name="activity_difficult" class="form-control">
                        <option value="{{ $activity['activity_time_type'] }}">{{ $activity['activity_time_type'] == 0 ? 'One time Activity' : 'Routine Activity' }}</option>
                        @if($activity['activity_time_type'] == 0)
                            <option value="1">Routine Activity</option>
                        @else
                            <option value="0">One time Activity</option>
                        @endif
                    </select>
                </div>

                <div class="form-group">
                    <label for="activity_apply_start">Activity apply date</label><br />
                    <input type="date" name="activity_apply_start"
                           value="{{ $activity['activity_apply_start'] }}"> -
                    <input type="date" name="activity_apply_end"
                           value="{{ $activity['activity_apply_end'] }}">
                </div>

                <div class="form-group">
                    <label for="activity_start">Activity start date</label><br />
                    <input type="date" name="activity_start"
                           value="{{ $activity['activity_start'] }}"> -
                    <input type="date" name="activity_end" value="{{ $activity['activity_end'] }}">
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
                        <input name="activity_routine_day"
                               value="{{ $activity['activity_routine_day'] }}" type="hidden">
                    </div>
                </div>

                <div class="form-group">
                    <label for="activity_start">Activity time start</label><br />
                    <input type="time" name="activity_start"
                           value="{{ $activity['activity_time_start'] }}"> -
                    <input type="time" name="activity_end"
                           value="{{ $activity['activity_time_end'] }}">
                </div>

                <div class="form-group">
                    <label for="activity_price">Activity price</label>
                    <div class="d-flex" style="width: 250px">
                        <input required type="text" name="activity_price"
                               value="{{ $activity['activity_price'] }}"
                               class="form-control">
                        <select name="activity_price_type" class="form-control"
                                style="width: 120px; margin-left: 10px">
                            @if($activity['activity_price_type'] == 0)
                                <option value="0">per activity</option>
                                <option value="1">per hour</option>
                            @else
                                <option value="1">per hour</option>
                                <option value="0">per activity</option>
                            @endif
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="activity_hour">Activity hour</label>
                    <input required type="text" name="activity_hour"
                           value="{{ $activity['activity_hour'] }}"
                           class="form-control" style="width: 140px">

                </div>

                <div class="form-group">
                    <label for="activity_max">Activity max apply</label>
                    <input required type="text" name="activity_max"
                           value="{{ $activity['activity_max'] }}"
                           class="form-control" style="width: 140px">

                </div>

                <div class="form-group">
                    <label for="activity_location_name">Activity location name</label>
                    <input required type="text" name="activity_location_name"
                           value="{{ $activity['activity_location_name'] }}"
                           class="form-control">

                </div>

                <div class="form-group">
                    <label for="activity_location">Activity location url</label>
                    <input required type="text" name="activity_location"
                           value="{{ $activity['activity_location'] }}"
                           class="form-control">

                </div>

                <div class="form-group">
                    <label for="studio_icon">Activity sponsor</label><br>

                    <div class="image-wrapper" id="sponsor-image">
                        @foreach($activity['activity_sponsors'] as $sponsor)
                            <input type="text" name="sponsor_name[]" value="{{ $sponsor['name'] }}"
                                   placeholder="Sponsor name"><br />
                            <input type="text" name="sponsor_link[]" value="{{ $sponsor['link'] }}"
                                   placeholder="Sponsor link"><br />
                            <img src="{{ $sponsor['url'] }}" class="preview">
                            <input type="file" name="sponsor_pic[]" accept="image/*">
                            <br /> <br />
                        @endforeach
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
        @else
            <div align="center" style="padding: 20px">
                You don't own this studio.<br>
                The studio can only be edited by the owner
            </div>
        @endif


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
            <input type="text" name="sponsor_name[]" placeholder="Sponsor name"><br />
                            <input type="text" name="sponsor_link[]" placeholder="Sponsor link"><br />
                            <img src="" class="preview">
                            <input type="file" name="sponsor_pic[]" accept="image/*">
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
                                    <input class="benefit-file --bg benefit-bg" name="bg[]" id="benefit-bg"
                                           type="file" accept="image/*">
                                    <input class="benefit-file --icon benefit-pic" name="pic[]" id="benefit-icon"
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
                                    <div class="name"><input type="text" name="benefit_name[]" placeholder="Title"
                                                             value=""
                                                                     style="width: 100%"></div>

                  <div class="description">
                      <textarea name="benefit_desc[]" id="" cols="30"
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