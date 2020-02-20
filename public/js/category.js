var categoryInit = function () {
  $('.add-interest-activity > .search-dropdown > .search-resultt').click(function () {
    var categoryName = $(this).children('.category').text()
    var categoryPic = $(this).children('.svg')[0].outerHTML
    var categoryId = parseInt($(this).children('.category-id').val(), 10)

    $.ajax({
      url: '/api/category/' + categoryId,
      type: 'post',
      dataType: 'json',
      processData: false,
      contentType: 'application/json',
      data: JSON.stringify({
        '_token': $('meta[name="csrf-token"]').attr('content'),
      }),
    })

    var html = `
       <div id="cat-${categoryId}" class="interest-activity" tabindex="-1" cat-id="${categoryId}">
            <div class="icon-container d-none" align="center">
                <img src="/img/icon/close.svg" class="svg">
            </div>
            <div class="icon">
                ${categoryPic}
            </div>
            <div class="name">${categoryName}</div>
            <input class="category-id" id="category-id" type="hidden"
                           value="${categoryId}">
       </div>
    `
    $('.category-interest > .interest-group').append(html)

    replaceSvg()

    if ($('.search-resultt.d-flex').length !== 0) {
      $(this).removeClass('d-flex')

      if ($('.search-resultt.d-flex').length === 0) {
        $(this).siblings('.already').removeClass('d-none')
      }

    }

    if ($('.interest-activity').length != 0) {
      $('.edit.d-none').removeClass('d-none')
    } else {
      $('.edit').addClass('d-none')
    }

  })

  MasterStudio.categorySelected = []
  $('.interest-group').delegate('.interest-activity', 'click', function (e) {
    if ($(e.target).parents('.icon-container').length !== 0) {
      var id = $(this).attr('id')
      $(this).remove()
      $('#' + id + '-select').addClass('d-flex')
      $.ajax({
        url: '/api/category/' + $(this).attr('cat-id'),
        type: 'delete',
        dataType: 'json',
        processData: false,
        contentType: 'application/json',
        data: JSON.stringify({
          '_token': $('meta[name="csrf-token"]').attr('content'),
        }),
      })
      if ($('.search-resultt.d-flex').length !== 0) {
        $('.already').addClass('d-none')
      }
      if ($('.interest-activity').length != 0) {
        $('.edit.d-none').removeClass('d-none')
      } else {
        $('.edit').addClass('d-none')
      }
      return false
    }
    $(this).toggleClass('active')
    var categoryId = parseInt($(this).children('#category-id').val(), 10)
    if ($(this).hasClass('active')) {
      MasterStudio.categorySelected.push(categoryId)
    } else {
      var index = MasterStudio.categorySelected.indexOf(categoryId)
      if (index !== -1) MasterStudio.categorySelected.splice(index, 1)
    }
    interestSelected(this)
  })

  $('.category-interest > .edit').click(function () {
    $('.interest-activity > .icon-container').toggleClass('d-none')
  })

  $('.add-interest-activity').click(function () {
    $('.interest-activity > .icon-container').addClass('d-none')
  })
}

$(document).ready(function () {
  categoryInit()
})