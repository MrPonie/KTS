$(function() {
    $('.navlist-item-container').each(function(){
        let container = $(this);
        let up_icon = $(this).find('.navlist-sublist-trigger-up-icon').first();
        let down_icon = $(this).find('.navlist-sublist-trigger-down-icon').first();
        let triggers = $(this).find('.navlist-sublist-trigger');
        
        function on_trigger_click() {
            if(container.hasClass('expanded')){
                container.removeClass('expanded');
                up_icon.addClass('hidden');
                down_icon.removeClass('hidden');
                $(this).removeClass('active');
            }else{
                container.addClass('expanded');
                up_icon.removeClass('hidden');
                down_icon.addClass('hidden');
                $(this).addClass('active');
            }
        }
        
        triggers.each(function(){
            if(container.hasClass('expanded')){
                up_icon.removeClass('hidden');
                down_icon.addClass('hidden');
                $(this).addClass('active');
            }else{
                up_icon.addClass('hidden');
                down_icon.removeClass('hidden');
                $(this).removeClass('active');
            }
        });
        triggers.on('click', on_trigger_click);
    });
});