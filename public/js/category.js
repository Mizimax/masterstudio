$(document).ready(function () {

  var interestActive = function () {
    $(this).toggleClass('active')
  }

  $('.add-interest-activity > .search-dropdown > .search-result').click(function () {
    var categoryName = $(this).children('.category').text()
    var categoryPic = $(this).children('.svg')[0].outerHTML
    var categoryId = parseInt($(this).children('.category-id').val(), 10)

    var html = `
       <div class="interest-activity" tabindex="-1" onclick="$(this).toggleClass('active')">
            <div class="icon">
                ${categoryPic}
            </div>
            <div class="name">${categoryName}</div>
       </div>
    `

    MasterStudio.myCategory = { categoryId, categoryName, categoryPic }
    $('.category-interest > .interest-group').append(html)

    if ($(this).parent().children().length !== 1) {
      $(this).remove()
    } else {
      $(this).parent().text('You already selected all categories.')
    }

  })

  $('.interest-activity').click(interestActive)

})