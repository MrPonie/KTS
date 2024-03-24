function update_empty_list_notice(list) {
    list.find('.user-select-list-empty-notice').css('display', list.find('ul li').length>0 ? 'none' : 'block');
}

function get_user_list_item_html(item_value, item_name) {
    return `
    <li data-user-select-list-item-value="`+item_value+`">
        <p>`+item_name+`</p>
        <button type="button">Remove</button>
    </li>
    `;
}

function add_item_to_user_list(list, item_value, item_name) {
    let users = list.data('users');
    let list_list = list.find('.user-select-list-list');

    users.push(item_value);
    list.data('users', users);
    list_list.html(list_list.html()+get_user_list_item_html(item_value, item_name));

    list_list.find('li').each(function(){
        let item = $(this);
        item.find('button').on('click', function(){
            item.remove();
            remove_item_from_list(list, item);
            update_empty_list_notice(list);
        });
    });

    console.log('after add', list.data('users'));
}

function remove_item_from_list(list, item) {
    let users = list.data('users');
    let item_value = item.data('user-select-list-item-value');
    let index = users.indexOf(item_value);

    if(index >= 0) {
        users.splice(index, 1);
        list.data('users', users);
    }

    console.log('after remove', list.data('users'));
}

$(function(){
    $('.user-select-list').each(function(){        
        let list = $(this);
        
        let list_users = list.data('users');
        if(!list_users) {
            list_users = [];
            list.data('users', []);
        }

        let list_list = list.find('.user-select-list-list');

        let add_button = list.find('.user-select-search-add-button');
        let search_input = list.find('.select-search-search-input');
        let search_selected_input = list.find('.select-search-input');

        add_button.on('click', function(){
            add_item_to_user_list(list, search_selected_input.val(), search_input.val());
            search_input.val('');
            search_selected_input.val('');
            add_button.prop('disabled', true);
        });

        document.addEventListener("livewire:load", function(){
            console.log('livewire load');
            window.livewire.hook('beforeDomUpdate', function(){
                console.log('livewire before dom update');
                add_button.prop('disabled', true);
            });
        });

        window.addEventListener('select-search-changed', event => {
            console.log('select search changed');
        });

        search_selected_input.on('change', function(){
            console.log('search selected change');
        });

        search_input.on('change', function(){
            add_button.prop('disabled', false);
            console.log('search input change');
        });

        list_users.forEach(user => {
            list_list.html(list_list.html()+get_user_list_item_html(user));
        });

        list_list.find('li').each(function(){
            let item = $(this);
            $(this).find('button').on('click', function(){
                item.remove();
                remove_item_from_list(list, item);
                update_empty_list_notice(list);
            });
        });

        update_empty_list_notice(list);
    });

    $('.user-select-list').each(function() {
        console.log($(this).data('users'));
    });
});