import './bootstrap.js';

$(function(){

    // set sidebar and content container heights to fit the rest of page so that there would not be a whole page scrollbar that only scrolls to hide the header
    function update_heights(height, header_height){
        $('.page-content,.page-sidebar').css('height', (parseInt(height) - parseInt(header_height)) + 'px');
    }
    $(window).on('resize', function(){
        update_heights($(this)[0].innerHeight, $('header').css('height'));
    });
    update_heights($(window)[0].innerHeight, $('header').css('height'));
});