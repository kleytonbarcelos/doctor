function PrintElement(element)
{
    $(element).find('.no-print').hide();
    setTimeout(function()
    {
        $(element).print();
        setTimeout(function()
        {
            $(element).find('.no-print').show();
        }, 2000);
    }, 1000);
}