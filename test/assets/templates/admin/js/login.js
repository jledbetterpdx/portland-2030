$(document).ready(function()
{
    $('#login').on('submit', function()
    {
        var $submit     = $('#submit');
        var $submit_box = $('#submit_box');

        $submit_box.addClass('login-action');
        $submit.addClass('disabled').val('Logging In').prop('disabled', true);
    });

    $('#cancel').on('click', function()
    {
        document.location.href = "/";
    });
});