$(document).ready(function()
{
    $('#forgot_password_window').on('submit', function()
    {
        var $send     = $('#send');
        var $send_box = $('#send_box');

        $send_box.addClass('send-action icon-disabled');
        $send.val('Sending').prop('disabled', true);
    });

    $('#back').on('click', function()
    {
        document.location.href = '/members/login';
    });
});