window.onload = function() {
    $('.input-select-search').each(function(){
        let results = $(this).find('.select-search-search-results');
        let search_input = $(this).find('.select-search-input');
        let search_search_input = $(this).find('.select-search-search-input');
        $(this).find('.select-search-search-input')
        .on('focus', function(){
            results.removeClass('hidden');
        })
        .on('focusout', function(){
            results.addClass('hidden');
        });

        let observer = new MutationObserver(function(mutationList, observer) {
            setTimeout(function(){
                $('.select-search-option-button').on('click', function(){
                    console.log('option clicked');
                    search_input.val($(this).data('option-value'));
                    search_search_input.val($(this).html());
                });
                results.find('.select-search-option-button').each(function(){console.log($(this).data('option-value'))})
                console.log('mutated');
            }, 1000);
        });

        observer.observe(results[0], {subtree:true, childList:true});
    });
}