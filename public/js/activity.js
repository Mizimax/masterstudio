function activityHover() {
  $('.activity-card > .video-wrapper').off('mouseenter').on('mouseenter', function () {
    var self = this
    var index = $(this).parent().parent().index()
    $(this).siblings('.master-profile').addClass('active')
    $(this).parent().addClass('hover')
    $(this).parent().removeClass('fixedMid')
    $(this).parent().removeClass('left')
    $(this).parent().removeClass('right')
    $(this).parent().removeClass('mid')
    if ($(window).width() <= 809) {
      $(this).parent().addClass('fixedMid')
    } else {
      if (index % 3 === 0) {
        $(this).parent().addClass('left')
      } else if (index % 3 === 2) {
        $(this).parent().addClass('right')
      } else {
        $(this).parent().addClass('mid')
      }
    }

    $(this).children('.video').get(0).play()
    MasterStudio.videoHover.play = true

    $(this).parent().children('.overlay').addClass('d-block')
    $(this).off('click').on('click', function () {
      if (!MasterStudio.videoHover.play) {
        $(this).children('.video').get(0).play()
      } else {
        $(this).children('.video').get(0).pause()
      }
      $(this).children('.play-wrapper').toggleClass('d-none')
      MasterStudio.videoHover.play = !MasterStudio.videoHover.play
    })

    $('.overlay.d-block').one('mouseenter', function () {
      $(self).parent().removeClass('hover')
      $(this).removeClass('d-block')
      $(self).siblings('.master-profile').removeClass('active')

      $(self).children('.video').get(0).pause()
      $(self).children('.play-wrapper').addClass('d-none')
      MasterStudio.videoHover.play = false
    })
  })
}

function hoverVideo(e) {
  $(this).get(0).play()
}

function hideVideo(e) {
  $(this).get(0).pause()
}

$(document).ready(function () {
  $('.master-profile').hover(function () {
    $(this).children('.activity-detail').fadeIn()
  }, function () {
    $(this).children('.activity-detail').fadeOut()
  })
})