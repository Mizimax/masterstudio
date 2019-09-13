$(document).ready(function () {
  var lazyLoadInstance = new LazyLoad({
    elements_selector: '.lazy',
    // ... more custom settings?
  })

  // video hover
  var figure = $('.activity-story .video').hover(hoverVideo, hideVideo)

  //hover
  activityHover()
})