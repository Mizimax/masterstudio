var figure = $(".activity-story .video").hover( hoverVideo, hideVideo );

function hoverVideo(e) {
  $(this).get(0).play();
}

function hideVideo(e) {
  $(this).get(0).pause();
}