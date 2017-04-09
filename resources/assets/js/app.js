window.$ = require('jquery');

function enableClassIf(enabledCondition, target, clazz) {
    if (enabledCondition) {
        $(target).addClass(clazz);
    }
    else {
        $(target).removeClass(clazz);
    }
}

$('.build-chooser-item').on('click', function() {
    if ($(this).hasClass('disabled')) {
        return;
    }

    const target = $(this);
    const componentId = $(this).attr('data-component-id');
    const componentType = $(this).attr('data-component-type');
    const selected = $(this).hasClass('selected');

    enableClassIf(!selected, target, 'selected');

    $.ajax(ajaxSelectUrl, {
        data: {
            'component-id': componentId,
            'component-type': componentType,
            // the selected property was toggled
            'count': selected ? 0 : 1,
        },
        dataType: 'json'
    }).done((data) => {
        if (data.disable) {
            for (let componentId of data.disable) {
                $(`.build-chooser-item[data-component-id=${componentId}]`).addClass('disabled');
            }
        }
        else if (data.enable) {
            for (let componentId of data.enable) {
                $(`.build-chooser-item[data-component-id=${componentId}]`).removeClass('disabled');
            }
        }
    });
})/*.find('.build-chooser-item-quantity-button').on('click', function() {
    const chooserItem = $(this).closest('.build-chooser-item');
    const textElem = $(this).siblings('.build-chooser-item-quantity-text');
    const selected = $(chooserItem).hasClass('selected');
    let propagate = false;

    if (!selected && $(this).hasClass('add')) {
        textElem.text('1');
        propagate = true;
    }

    return propagate;
})*/;
