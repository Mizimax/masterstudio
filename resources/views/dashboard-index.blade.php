@extends('dashboard')

@section('page', 'dashboard')

@section('style')
    <link rel="stylesheet" href="/css/dashboard.master.css?v=1.0">
@endsection

@section('content')
    <div class="container --master">
        <div class="content-list">
            <div class="d-flex align-items-center">
                <div class="custom-dropdown" style="width: 200px">
                    <select name="month">
                        <option value="">All months</option>
                        <option value="">All months</option>
                        <option value="">March 2020</option>
                    </select>
                </div>
                <form class="ml-4" action="/dashboard/export" method="post">
                    @csrf
                    <button class="primary-button" type="submit" class="export">Export</button>
                </form>
            </div>
            <div class="summary-wrapper mt-4">
                <div class="my-2 mt-4">Activity : {{ $allActivityCount }} activities
                </div>
                <div class="my-2">Master : {{ $allMasterCount }} masters</div>
                <div class="my-2">User : {{ $allUserActivityCount }}
                    activities
                </div>
                <div class="my-2">User in activity : {{ $allUserActivityCount }}
                    users
                </div>
                <div class="my-2">User in following :
                    {{ $allFollowCount }} users
                </div>
                <div class="my-2">Total income :
                    {{ $totalIncome }} baht
                </div>
                <div class="my-2">Category :
                    {{ count($categories) }} categories
                </div>
                <br />

                <div class="d-flex align-items-center">
                    <div class="custom-dropdown" style="width: 200px">
                        <select id="category" name="month">
                            <option value="{{ $categories[0]['category_id'] }}">{{ $categories[0]['category_name'] }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category['category_id'] }}">{{ $category['category_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <form class="ml-4" action="/dashboard/category/export/"
                          onsubmit="$(this).attr('action', '/dashboard/category/export/' + $('#category').val())"
                          method="post">
                        @csrf
                        <button class="primary-button" type="submit" class="export">Export</button>
                    </form>
                </div>
                <div id="category-wrapper">

                </div>
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
      $(document).ready(function () {
        dropdownInit()

        $('#category').siblings('.select-items').click(function () {
          $.ajax({
            url: '/dashboard/category/' + $('#category').val() + '/info',
            type: 'get',
            processData: false,
            contentType: 'application/json',
            data: JSON.stringify({
              '_token': $('meta[name="csrf-token"]').attr('content'),
            }),
            success: function (data) {
              $('#category-wrapper').html(data)
            },
            error: function (error) {
              console.log(error)
            },
          })
        })

        $.ajax({
          url: '/dashboard/category/1/info',
          type: 'get',
          processData: false,
          contentType: 'application/json',
          data: JSON.stringify({
            '_token': $('meta[name="csrf-token"]').attr('content'),
          }),
          success: function (data) {
            $('#category-wrapper').html(data)
          },
          error: function (error) {
            console.log(error)
          },
        })

      })
    </script>
@endsection