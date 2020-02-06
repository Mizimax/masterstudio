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

//   $('.activity-story').hover(function () {
//     var self = this;
//     $(function() {
//       $("html, body").mousewheel(function(event, delta) {
//         self.scrollLeft -= (delta * 30);
//         event.preventDefault();
//       });
//     });
//   }, function () {
//     $("html, body").unbind('mousewheel');
//   })
//
//   var scrollPosition = [
//     self.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft,
//     self.pageYOffset || document.documentElement.scrollTop  || document.body.scrollTop
//   ];
//   var html = jQuery('html'); // it would make more sense to apply this to body, but IE7 won't have that
//   html.data('scroll-position', scrollPosition);
//   html.data('previous-overflow', html.css('overflow'));
//   html.css('overflow', 'hidden');
//   window.scrollTo(scrollPosition[0], scrollPosition[1]);
//
//
// // un-lock scroll position
//   var html = jQuery('html');
//   var scrollPosition = html.data('scroll-position');
//   html.css('overflow', html.data('previous-overflow'));
//   window.scrollTo(scrollPosition[0], scrollPosition[1])

})