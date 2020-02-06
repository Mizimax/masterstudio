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
       <div class="interest-activity" tabindex="-1">
            <div class="icon">
                ${categoryPic}
            </div>
            <div class="name">${categoryName}</div>
            <input class="category-id" id="category-id" type="hidden"
                           value="${categoryId}">
       </div>
    `
    $('.category-interest > .interest-group').append(html)

    if ($(this).parent().children().length !== 1) {
      $(this).remove()
    } else {
      $(this).parent().text('You already selected all categories.')
    }

  })

  MasterStudio.categorySelected = []
  $('.interest-group').delegate('.interest-activity', 'click', function () {
    $(this).toggleClass('active')
    var categoryId = parseInt($(this).children('#category-id').val(), 10)
    if ($(this).hasClass('active')) {
      MasterStudio.categorySelected.push(categoryId)
    } else {
      var index = MasterStudio.categorySelected.indexOf(categoryId)
      if (index !== -1) MasterStudio.categorySelected.splice(index, 1)
    }
    interestSelected()
  })
}

$(document).ready(function () {
  categoryInit()
})