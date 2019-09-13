function activityHover() {
  $('.activity-card > .video-wrapper').off('mouseenter').on('mouseenter', function () {
    var self = this
    var index = $(this).parent().parent().index()
    $(this).addClass('hover')
    if ($(window).width() <= 539) {
      $(this).addClass('mid')
    } else if ($(window).width() <= 809) {
      if (index % 2 === 0) {
        $(this).addClass('left')
      } else {
        $(this).addClass('right')
      }
    } else {
      if (index % 3 === 0) {
        $(this).addClass('left')
      } else if (index % 3 === 2) {
        $(this).addClass('right')
      } else {
        $(this).addClass('mid')
      }
    }

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
      $(self).removeClass('hover')
      $(this).removeClass('d-block')

      $(self).children('.video').get(0).pause()
      $(self).children('.play-wrapper').removeClass('d-none')
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