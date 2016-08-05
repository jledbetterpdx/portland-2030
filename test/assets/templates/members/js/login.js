$(document).ready(function()
{
    $('#login_window').on('submit', function()
    {
        var $submit     = $('#submit');
        var $submit_box = $('#submit_box');

        $submit_box.addClass('login-action icon-disabled');
        $submit.val('Logging In').prop('disabled', true);
    });

    $('#cancel').on('click', function()
    {
        document.location.href = "/";
    });
});