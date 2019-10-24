function getActivityPath() {
  return '/content/activity/' + (this.loadCount + 1)
}

function calculateTimeDuration(secs) {
  var min = Math.floor(secs / 60)
  var sec = Math.floor(secs - (min * 60))
  if (sec < 10) {
    sec = '0' + sec
  }
  return min + ':' + sec
}

$(document).ready(function () {

  var mediaStream

  var lazyLoadInstance = new LazyLoad({
    elements_selector: '.lazy',
    // ... more custom settings?
  })

  // video hover
  var figure = $('.activity-story .video').hover(hoverVideo, hideVideo)

  //hover
  activityHover()

  $('.all-activity .activity-grid').infiniteScroll({
    // options
    path: getActivityPath,
    append: '.activity-card-wrapper',
    status: '.loading-wrapper',
  })

  $('.all-activity .activity-grid').on('append.infiniteScroll', function (event, response) {
    if (lazyLoadInstance) {
      lazyLoadInstance.update()
    }
    activityHover()
  })

  $('.add-button').click(function () {

    var countup

    $('.record-video').addClass('d-flex')

    $('.record-video').off('click').on('click', function (event) {
      if ($(event.target).hasClass('record-video')) {
        $(this).toggleClass('d-flex')
        mediaStream.stop()
      }
    })

    navigator.getUserMedia({
        video: true,
        audio: true,
      },
      function (stream) {
        let recorder = RecordRTC(stream, {
          type: 'video',
        })
        mediaStream = stream
        $('.video-preview > video')[0].srcObject = stream
        $('.record-btn').off('click').on('click', function () {
            console.log('record')
            if (!MasterStudio.videoPreview.play) {
              recorder.startRecording()
              $(this).text('Stop recording...')

              var sec = 0
              $('.time-record > .time').text('0:00')
              countup = setInterval(function () {
                var countText = calculateTimeDuration(++sec)
                $('.time-record > .time').text(countText)
              }, 1000)
            } else {
              recorder.stopRecording(function () {
                let blob = recorder.getBlob()
                invokeSaveAsDialog(blob)
              })
              $(this).text('Start recording')
              clearInterval(countup)
            }
            $(this).toggleClass('recording')
            MasterStudio.videoPreview.play = !MasterStudio.videoPreview.play
          },
        )
      },
      function (error) {
        $('.cantaccess').addClass('d-block')
      },
    )
  })
})