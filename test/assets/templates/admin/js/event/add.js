$(document).ready(function()
{
    var $field = $('.field');

    $field.on('focus', function()
    {
        $this       = $(this);
        id          = $this.attr('id');
        $example    = $('#examples_' + id);

        if (console)
        {
            console.log('$this    = ' + $this.attr('id'));
            console.log('id       = ' + id);
            console.log('$example = ' + $example.attr('id'));
        }

        $example.show(0);
    });

    $field.on('blur', function()
    {
        $this       = $(this);
        id          = $this.attr('id');
        $example    = $('#examples_' + id);

        if (console)
        {
            console.log('$this    = ' + $this.attr('id'));
            console.log('id       = ' + id);
            console.log('$example = ' + $example.attr('id'));
        }

        $example.hide(0);
    });
});