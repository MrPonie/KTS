window.onload = function() {
    $('.input-select-search').each(function(){
        let results = $(this).find('.select-search-search-results');
        $(this).find('.select-search-search-input')
        .on('focus', function(){
            results.removeClass('hidden');
            console.log('search focus');
        })
        .on('focusout', function(){
            results.addClass('hidden');
            console.log('search focusout');
        });
    });
}