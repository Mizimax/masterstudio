@extends('dashboard')

@section('page', 'activity')

@section('style')
    <link rel="stylesheet" href="/css/dashboard.master.css?v=1.1">
@endsection

@section('content')
    <div class="container --master">
        <div class="content-list">
            @if(count($activities) != 0)
                <div align="center">
                    <a href="/dashboard/activity/add">
                        <button class="primary-button" style="padding: 10px 20px;">+ Add activity
                        </button>
                    </a>
                </div>
            @else
                <div align="center" style="padding: 20px">
                    You don't own any activity.<br>
                    The activity can only be edited by the owner
                </div>
            @endif


            {{--                @foreach($activities as $activity)--}}
            {{--                    <div class="content-container">--}}
            {{--                        <a href="/dashboard/activity/{{ $activity['activity_id'] }}"--}}
            {{--                           style="flex: 1;">--}}
            {{--                            <div class="content">--}}
            {{--                                <div class="name">--}}
            {{--                                    {{ $activity['activity_name'] }}--}}
            {{--                                </div>--}}
            {{--                                <div class="master">--}}
            {{--                                    {{ $activity['master_name'] }}--}}
            {{--                                </div>--}}
            {{--                            </div>--}}
            {{--                        </a>--}}
            {{--                        <form method="post" onsubmit="return deleteActivity()"--}}
            {{--                              action="/dashboard/activity/{{ $activity['activity_id'] }}"--}}
            {{--                              style="margin-left: 10px">--}}
            {{--                            <input name="_method" type="hidden" value="DELETE">--}}
            {{--                            @csrf--}}
            {{--                            <button class="btn btn-danger" type="submit">Delete</button>--}}
            {{--                        </form>--}}
            {{--                    </div>--}}
            {{--                @endforeach--}}

            <div class="summary-wrapper mt-4">
                <div class="custom-dropdown" style="width: 200px">
                    <select name="month">
                        <option value="">Current month</option>
                        <option value="">Current month</option>
                        <option value="">March 2020</option>
                    </select>
                </div>

                <div class="my-2 mt-4">Total users join activity in this month : <span
                            id="joinUser"></span> users
                </div>
                <div class="my-2">Total income in this month : <span id="income"></span> Baht</div>
                <div class="my-2">Total activity in this month : {{ count($activities) }}
                    activities
                </div>
                <div class="my-2">Total users interest in this month : <span id="interest"></span>
                    users
                </div>
            </div>

            <div class="custom-dropdown"
                 style="width: 200px; margin-left: auto; margin-right: 50px;">
                <select id="category" name="month">
                    <option value="0">All category</option>
                    <option value="0">All category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category['category_id'] }}">{{ $category['category_name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div id="activity-wrapper" style="display: flex" class="flex-wrap mt-4">
                @php
                    $count = 0;
                    $interest = 0;
                    $income = 0
                @endphp
                @foreach($activities as $activity)
                    @php
                        $joinUserNo = \App\UserActivity::from('user_activities as ua')
                                    ->join('users AS u', 'u.user_id', '=', 'ua.user_id')
                                    ->where('ua.activity_id', $activity['activity_id'])
                                    ->where('ua.user_activity_paid', 1)->count();

                        $interestUserNo = \App\UserActivity::from('user_activities as ua')
                                    ->join('users AS u', 'u.user_id', '=', 'ua.user_id')
                                    ->where('ua.activity_id', $activity['activity_id'])
                                    ->where('ua.user_activity_status', 0)->count();
                        $interest += $interestUserNo;
                        $count += $joinUserNo;
                        $income += $activity['activity_price'] * $joinUserNo;
                    @endphp
                    <div class="activity-summary">
                        <input type="hidden" name="category_id"
                               value="{{ $activity['category_id'] }}">
                        <div class="head">{{ $activity['activity_name'] }}</div>
                        <div class="d-flex">
                            <div class="indicator">Owner</div>
                            <div class="value">{{ $activity['master_name'] }}</div>
                        </div>
                        <div class="d-flex">
                            <div class="indicator">End registration</div>
                            <div class="value">{{ $activity['activity_apply_end'] }}</div>
                        </div>
                        <div class="d-flex">
                            <div class="indicator">Start activity</div>
                            <div class="value">{{ $activity['activity_start'] }}</div>
                        </div>
                        <div class="d-flex">
                            <div class="indicator">Join user</div>
                            <div class="value">{{ $joinUserNo }}
                                / {{ $activity['activity_max'] }}</div>
                        </div>
                        <div class="d-flex">
                            <div class="indicator">Available</div>
                            <div class="value">{{ $activity['activity_max'] - $joinUserNo }}
                                / {{ $activity['activity_max'] }}</div>
                        </div>
                        <div class="d-flex">
                            <div class="indicator">Retention users</div>
                            <div class="value">{{ $activity['activity_user_retention'] }}
                                / {{ $activity['activity_max'] }}</div>
                        </div>
                        <div class="d-flex">
                            <div class="indicator">Pay users</div>
                            <div class="value">{{ $joinUserNo }}</div>
                        </div>
                        <div class="d-flex">
                            <div class="indicator">Interested users</div>
                            <div class="value">{{ $interestUserNo }}</div>
                        </div>
                        <div class="d-flex">
                            <div class="indicator">Total earns</div>
                            <div class="value">{{ $activity['activity_price'] * $joinUserNo }}</div>
                        </div>
                        <div class="d-flex">
                            <div class="indicator">@master</div>
                            <div class="value"></div>
                        </div>
                        <button onclick="window.location='/dashboard/activity/{{ $activity['activity_id'] }}'"
                                class="primary-button w-100">Edit Activity
                        </button>
                        <form method="post" onsubmit="return deleteActivity()"
                              action="/dashboard/activity/{{ $activity['activity_id'] }}"
                              style="margin-left: 10px">
                            <input name="_method" type="hidden" value="DELETE">
                            @csrf
                            <div align="center" style="margin-top: 5px;">
                                <button type="submit" style="border: none">Cancel Activity</button>
                            </div>
                        </form>


                    </div>
                @endforeach
            </div>
            <div id="activity-wrapper-filter" class="d-flex flex-wrap mt-4">

            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>
      var dropdownInit = function () {

        var x, i, j, selElmnt, a, b, c
        /* Look for any elements with the class "custom-dropdown": */
        x = document.getElementsByClassName('custom-dropdown')

        for (i = 0; i < x.length; i++) {
          selElmnt = x[i].getElementsByTagName('select')[0]
          /* For each element, create a new DIV that will act as the selected item: */
          a = document.createElement('DIV')
          a.setAttribute('class', 'select-selected')
          a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML
          x[i].appendChild(a)
          /* For each element, create a new DIV that will contain the option list: */
          b = document.createElement('DIV')
          b.setAttribute('class', 'select-items select-hide')
          for (j = 1; j < selElmnt.length; j++) {
            /* For each option in the original select element,
            create a new DIV that will act as an option item: */
            c = document.createElement('DIV')
            c.innerHTML = selElmnt.options[j].innerHTML
            c.addEventListener('click', function (e) {
              /* When an item is clicked, update the original select box,
              and the selected item: */
              var y, i, k, s, h
              s = this.parentNode.parentNode.getElementsByTagName('select')[0]
              h = this.parentNode.previousSibling
              for (i = 0; i < s.length; i++) {
                if (s.options[i].innerHTML == this.innerHTML) {
                  s.selectedIndex = i
                  h.innerHTML = this.innerHTML
                  y = this.parentNode.getElementsByClassName('same-as-selected')
                  for (k = 0; k < y.length; k++) {
                    y[k].removeAttribute('class')
                  }
                  this.setAttribute('class', 'same-as-selected')
                  break
                }
              }
              h.click()
            })
            b.appendChild(c)
          }
          x[i].appendChild(b)
          a.addEventListener('click', function (e) {
            /* When the select box is clicked, close any other select boxes,
            and open/close the current select box: */
            e.stopPropagation()
            closeAllSelect(this)
            this.nextSibling.classList.toggle('select-hide')
            this.classList.toggle('select-arrow-active')
          })
        }

        function closeAllSelect(elmnt) {
          /* A function that will close all select boxes in the document,
          except the current select box: */
          var x, y, i, arrNo = []
          x = document.getElementsByClassName('select-items')
          y = document.getElementsByClassName('select-selected')
          for (i = 0; i < y.length; i++) {
            if (elmnt == y[i]) {
              arrNo.push(i)
            } else {
              y[i].classList.remove('select-arrow-active')
            }
          }
          for (i = 0; i < x.length; i++) {
            if (arrNo.indexOf(i)) {
              x[i].classList.add('select-hide')
            }
          }
        }

        /* If the user clicks anywhere outside the select box,
        then close all select boxes: */
        document.addEventListener('click', closeAllSelect)
      }
    </script>
    <script>
      function deleteActivity() {
        var result = confirm('Confirm to delete?')
        if (!result) {
          return false
        }

      }

      function getActivityByCategory(category) {
        return $('#activity-wrapper > .activity-summary').filter(function (index, item) {
          var categoryId = $(item).find('input[type=hidden]').val()
          return categoryId == category
        })
      }

      $(document).ready(function () {
        dropdownInit()

        $('#joinUser').text('{{ $count }}')
        $('#income').text('{{ $income }}')
        $('#interest').text('{{ $interest }}')

        $('#category').siblings('.select-items').click(function () {
          if ($('#category').val() == 0) {
            $('#activity-wrapper').css('height', 'auto')
            $('#activity-wrapper').css('overflow', 'auto')
            $('#activity-wrapper-filter').css('height', '0px')
            $('#activity-wrapper-filter').css('overflow', 'hidden')
            return false
          }
          $('#activity-wrapper').css('height', '0px')
          $('#activity-wrapper').css('overflow', 'hidden')
          $('#activity-wrapper-filter').css('height', 'auto')
          $('#activity-wrapper-filter').css('overflow', 'auto')
          var activityFilter = getActivityByCategory($('#category').val()).clone()
          $('#activity-wrapper-filter').html(activityFilter)
        })
      })
    </script>
@endsection