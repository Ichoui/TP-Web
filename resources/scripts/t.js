$(function () {
    $('.burger .bars').on("click", function () {
        $('.header').toggle();
    });
    $('.menu').load('menu.html');

});