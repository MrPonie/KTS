$(function(){
    $('.user-button-container').each(function(){
        let popup = $(this).find('.user-button-popup');
        let btn = $(this).find('.user-button');
        $(document).on('click', function(e){
            if(!popup.hasClass('hidden')){
                if(!popup.is(e.target) && popup.has(e.target).length === 0 && !btn.is(e.target) && btn.has(e.target).length === 0){
                    popup.addClass('hidden');
                }
            }
        });
        btn.on('click', function(){
            if(popup.hasClass('hidden')) popup.removeClass('hidden');
            else popup.addClass('hidden');
        });
    });
});