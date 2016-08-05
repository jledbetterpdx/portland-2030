$(document).ready(function()
{
    $('#reset_password_window').on('submit', function()
    {
        var $resetpass     = $('#resetpass');
        var $resetpass_box = $('#resetpass_box');

        $resetpass_box.addClass('reset-action icon-disabled');
        $resetpass.val('Resetting').prop('disabled', true);
    });

    $('#back').on('click', function()
    {
        document.location.href = '/members/login';
    });
});