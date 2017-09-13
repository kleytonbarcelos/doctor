$(document).ready(function()
{
    $('.valor').priceFormat({
        prefix: 'R$ ',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });
});