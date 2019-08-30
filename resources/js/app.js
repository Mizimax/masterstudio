var figure = $(".activity-story .video").hover(hoverVideo, hideVideo);

function hoverVideo(e) {
    $(this).get(0).play();
}

function hideVideo(e) {
    $(this).get(0).pause();
}

var MasterStudio = {
    videoHover: {
        play: false
    }
}

$('.activity-card > .video-wrapper').on('mouseenter', function () {
    var self = this;
    $(this).addClass('hover');
    $(this).parent().children('.overlay').addClass('d-block');
    $('.overlay.d-block').click(function () {
        $(self).removeClass('hover');
        $(this).removeClass('d-block');
    })
    $(this).click(function () {
        if (!MasterStudio.videoHover.play)
            $(this).children('.video').get(0).play();
        else
            $(this).children('.video').get(0).pause();
        $(this).children('.play-wrapper').toggleClass('d-none');
        MasterStudio.videoHover.play = !MasterStudio.videoHover.play;
    })
})


