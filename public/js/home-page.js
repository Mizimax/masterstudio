$(document).ready(function () {
  var lazyLoadInstance = new LazyLoad({
    elements_selector: '.lazy',
    // ... more custom settings?
  })

  // video hover
  var figure = $('.activity-story .video').hover(hoverVideo, hideVideo)

  //hover
  activityHover()

  // $('.activity-detail-wrapper').hover(function () {
  //   $(this).children('.activity-tabs').fadeToggle(500);
  // },function () {
  //   $(this).children('.activity-tabs').fadeToggle(500);
  // })
})