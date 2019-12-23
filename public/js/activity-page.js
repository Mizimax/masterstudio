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

    navigator.getUserMedia = (navigator.getUserMedia ||
      navigator.webkitGetUserMedia ||
      navigator.mozGetUserMedia ||
      navigator.msGetUserMedia)

    navigator.getUserMedia({
        video: true,
        audio: true,
      },
      function (stream) {
        var recorder = RecordRTC(stream, {
          type: 'video',
        })
        mediaStream = stream
        var video = $('.video-preview > video')[0]
        video.srcObject = stream


        $('.record-btn').off('click').on('click', function () {
            console.log('record')
            if (!MasterStudio.videoPreview.play) {
              recorder.startRecording()
              $('#upload-btn').addClass('d-none')
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
                // we need to upload "File" --- not "Blob"
                var fileObject = new File([blob], 'video', {
                  type: 'video/mp4',
                })

                var URL = window.URL || window.webkitURL
                var src = URL.createObjectURL(fileObject)

                var video = $('.video-preview > video')[0]
                video.src = src

                $('#upload-btn').removeClass('d-none')

                $('#upload-btn').off('click').on('click', function () {
                  var formData = new FormData()
                  formData.append('video-blob', fileObject)
                  formData.append('_token', $('meta[name="csrf-token"]').attr('content'))

                  $.ajax({
                    url: '/activity/' + $('#activity-story').val() + '/story',
                    type: 'post',
                    headers: {
                      'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (res) {
                      window.location.reload()
                    },
                  })
                })

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