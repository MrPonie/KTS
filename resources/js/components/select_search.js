window.onload = function() {
    $('.select-search').each(function(){
        let results = $(this).find('.search-results');
        $(this).find('.search-input')
        .on('focus', function(){
            results.removeClass('hidden');
        })
        .on('focusout', function(){
            results.addClass('hidden');
        });
    });
}

document.addEventListener('livewire:load', function () {
    Livewire.hook('message.processed', (message, component) => {
        document.querySelector('.search-input').value = component.get('search');
    });
});