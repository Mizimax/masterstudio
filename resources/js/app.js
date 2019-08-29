var figure = $(".activity-story .video").hover( hoverVideo, hideVideo );

function hoverVideo(e) {
  $(this).get(0).play();
}

function hideVideo(e) {
  $(this).get(0).pause();
}

$('.activity-card > .video-wrapper').hover(function () {
  console.log('hover')
  $(this).addClass('hover')
  $('.activity-card > .overlay').addClass('d-block')
})

$('.activity-card > .overlay').click(function () {
  $(this).removeClass('d-block')
  $(this).addClass('d-none')
})
