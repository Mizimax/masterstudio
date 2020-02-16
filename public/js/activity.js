function hoverActivity(event) {
  return function () {
    var ele = $(this).siblings('.video-wrapper')
    var index = ele.parent().parent().index()
    ele.siblings('.master-profile').addClass('active')
    ele.siblings('.master-profile').children('.button').removeClass('d-none')
    ele.parent().addClass('hover')
    ele.parent().removeClass('fixedMid')
    ele.parent().removeClass('left')
    ele.parent().removeClass('right')
    ele.parent().removeClass('mid')
    if ($(window).width() <= 809) {
      ele.parent().addClass('fixedMid')
    } else {
      if (index % 3 === 0) {
        ele.parent().addClass('left')
      } else if (index % 3 === 2) {
        ele.parent().addClass('right')
      } else {
        ele.parent().addClass('mid')
      }
    }

    ele.children('.video').get(0).play()
    MasterStudio.videoHover.play = true

    ele.parent().children('.overlay').removeClass('--hover')
    ele.off('click').on('click', function () {
      if (!MasterStudio.videoHover.play) {
        $(this).children('.video').get(0).play()
      } else {
        $(this).children('.video').get(0).pause()
      }
      $(this).children('.play-wrapper').toggleClass('d-none')
      MasterStudio.videoHover.play = !MasterStudio.videoHover.play
    })

    ele.parent().children('.overlay').one(event, function () {
      ele.parent().removeClass('hover')
      setTimeout(() => {
        $(this).addClass('--hover')
      }, 100)
      ele.siblings('.master-profile').removeClass('active')
      ele.siblings('.master-profile').children('.button').addClass('d-none')

      ele.children('.video').get(0).pause()
      ele.children('.play-wrapper').addClass('d-none')
      MasterStudio.videoHover.play = false
    })
  }
}

function activityHover() {

  var tap = ('ontouchstart' in document.documentElement)

  if (tap) {
    $('.button.--detail.--mobile').addClass('d-block')

    $('#activity-wrapper').delegate('.activity-overlay.--hover', 'touchend', function () {
      $(this).hover(function () {
        $(this).siblings('.video-wrapper').children('.video').get(0).play()
      }, function () {
        $(this).siblings('.video-wrapper').children('.video').get(0).pause()
      })
    })
  } else {
    $('#activity-wrapper').delegate('.activity-overlay.--hover', 'mouseenter', hoverActivity('mouseenter'))
  }

}

function hoverVideo(e) {
  $(this).get(0).play()
}

function hideVideo(e) {
  $(this).get(0).pause()
}

$(document).ready(function () {
  $('#activity-wrapper').delegate('.master-profile', 'mouseenter', function () {
    $(this).children('.activity-detail').fadeIn()
  })
  $('#activity-wrapper').delegate('.master-profile', 'mouseleave', function () {
    $(this).children('.activity-detail').fadeOut()
  })

  $('.activity-story .master-profile').on('mouseenter', function () {
    console.log('>> : ')
    $(this).children('.activity-detail').fadeIn()
  })
  $('.activity-story .master-profile').on('mouseleave', function () {
    $(this).children('.activity-detail').fadeOut()
  })
})