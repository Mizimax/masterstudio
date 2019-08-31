var figure = $(".activity-story .video").hover(hoverVideo, hideVideo);

function hoverVideo(e) {
    $(this).get(0).play();
}

function hideVideo(e) {
    $(this).get(0).pause();
}

$('.activity-card > .video-wrapper').off('mouseenter').on('mouseenter', function () {
    var self = this;
    $(this).addClass('hover');
    $(this).parent().children('.overlay').addClass('d-block');
    $(this).off('click').on('click', function () {
        console.log('play', MasterStudio.videoHover.play)
        if (!MasterStudio.videoHover.play)
            $(this).children('.video').get(0).play();
        else
            $(this).children('.video').get(0).pause();
        $(this).children('.play-wrapper').toggleClass('d-none');
        MasterStudio.videoHover.play = !MasterStudio.videoHover.play;
    })

    $('.overlay.d-block').one('click ', function () {
        $(self).removeClass('hover');
        $(this).removeClass('d-block');

        $(self).children('.video').get(0).pause();
        $(self).children('.play-wrapper').removeClass('d-none');
        MasterStudio.videoHover.play = false;
    })
})


