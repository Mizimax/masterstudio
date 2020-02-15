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
})