("use strict");
$ = jQuery;

$(document).ready(function () {
    // Initialize main slider
    $('.main-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: false,
        asNavFor: '.thumbnail-slider'
    });

    // Initialize thumbnail slider
    $('.thumbnail-slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.main-slider',
        dots: false,
        centerMode: true,
        focusOnSelect: true,
        arrows: false   
    });
});

