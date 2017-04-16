window.$ = require('jquery');

/*
function enableClassIf(enabledCondition, target, clazz) {
    if (enabledCondition) {
        $(target).addClass(clazz);
    }
    else {
        $(target).removeClass(clazz);
    }
}

$('.build-chooser-item').on('click', function () {
    if ($(this).hasClass('disabled')) {
        return;
    }

    const selected = $(this).hasClass('selected');

    enableClassIf(!selected, this, 'selected');

    $.ajax(ajaxSelectUrl, {
        data: {
            'id': $(this).attr('data-component-id'),
            // the selected property was toggled
            'count': selected ? 0 : 1,
        },
        dataType: 'json'
    }).done((data) => {
        $('.build-chooser-item').each(function (i, item) {
            const id = parseInt($(item).attr('data-component-id'));

            $(`.build-chooser-item[data-component-id=${id}]`).toggleClass('disabled', data.disable.indexOf(id) !== -1);
        });
    });
})/!*.find('.build-chooser-item-quantity-button').on('click', function() {
 const chooserItem = $(this).closest('.build-chooser-item');
 const textElem = $(this).siblings('.build-chooser-item-quantity-text');
 const selected = $(chooserItem).hasClass('selected');
 let propagate = false;

 if (!selected && $(this).hasClass('add')) {
 textElem.text('1');
 propagate = true;
 }

 return propagate;
 })*!/;
*/
