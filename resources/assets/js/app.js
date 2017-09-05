window.$ = require('jquery');

$('.component').on('click', function () {
    if ($(this).hasClass('disabled')) {
        return;
    }

    const component = parseInt($(this).attr('data-component'));
    let selected = $(this).hasClass('selected');
    let count = parseInt($(this).attr('data-count'));

    $(this).toggleClass('selected', selected = !selected);
    $(this).attr('data-count', count += selected ? 1 : -1);

    $.ajax('/lab/select', {
        data: {
            id: component,
            count: count
        },
        dataType: 'json'
    }).done((data) => {
        let totalAmount = 0;

        $('.component').each(function (i, item) {
            $(item).toggleClass('disabled', data.disable.indexOf(parseInt($(item).attr('data-component'))) !== -1);
        });

        $('.component.selected').each(function (i, item) {
            totalAmount += parseInt($(item).attr('data-price'));
        });

        $('#checkout-button').attr('data-amount', parseInt(totalAmount));
    })
});