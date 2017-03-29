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
            'selected': selected ? 0 : 1,
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
});
