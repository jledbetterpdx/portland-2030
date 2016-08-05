$(document).ready(function()
{
    // Activate cancel event forms
    $('a.admin-icon.cancel').on('click', function()
    {
        $id   = $(this).data('id');
        $form = $('#cancel_' + $id);
        $form.submit();
    });

    // Activate uncancel event forms
    $('a.admin-icon.uncancel').on('click', function()
    {
        $id   = $(this).data('id');
        $form = $('#uncancel_' + $id);
        $form.submit();
    });

    // Activate uncancel event forms
    $('a.admin-icon.delete').on('click', function()
    {
        $id   = $(this).data('id');
        $form = $('#delete_' + $id);
        $form.submit();
    });

    // Form cancel action
    $('form.cancel-action').each(function(index)
    {
        // Get ID
        var $id = $(this).data('id');

        // Add ID field to form
        $(this).append('<input type="hidden" name="id" value="' + $id + '" />');

        // Add submit
        $(this).on('submit', function(event)
        {
            // Prompt for cancellation reason
            reason = prompt('To confirm, please log the reason for cancellation below.', '');

            // Only progress if reason entered
            if (reason != null && reason.trim() != '')
            {
                // Add reason field to form
                $(this).append('<input type="hidden" name="reason" value="' + reason + '" />');

                // Return (implies form submission)
                return;
            }

            // Prevent form submission
            event.preventDefault();
        });
    });

    // Form uncancel action
    $('form.uncancel-action').each(function(index)
    {
        // Get ID
        var $id = $(this).data('id');

        // Add ID field to form
        $(this).append('<input type="hidden" name="id" value="' + $id + '" />');

        // Add submit
        $(this).on('submit', function(event)
        {
            // Prompt for cancellation reason
            reason = prompt('To confirm, please log the reason for uncancellation below.', '');

            // Only progress if reason entered
            if (reason != null && reason.trim() != '')
            {
                // Add reason field to form
                $(this).append('<input type="hidden" name="reason" value="' + reason + '" />');

                // Return (implies form submission)
                return;
            }

            // Prevent form submission
            event.preventDefault();
        });
    });

    // Form delete action
    $('form.delete-action').each(function(index)
    {
        // Get ID
        var $id = $(this).data('id');

        // Add ID field to form
        $(this).append('<input type="hidden" name="id" value="' + $id + '" />');

        // Add submit
        $(this).on('submit', function(event)
        {
            // Prompt for cancellation reason
            reason = prompt('To confirm, please log the reason for deletion below.\n\nWARNING: THIS ACTION CANNOT BE UNDONE.', '');

            // Only progress if reason entered
            if (reason != null && reason.trim() != '')
            {
                // Add reason field to form
                $(this).append('<input type="hidden" name="reason" value="' + reason + '" />');

                // Return (implies form submission)
                return;
            }

            // Prevent form submission
            event.preventDefault();
        });
    });

    // Build tabs
    $('#tab-container').easytabs({
        animate: false
    });

    // Build tables
    $('table.tablesorter.results').each(function(index)
    {
        // Get ID
        var $id  = $(this).attr('id');
        var sort = ($id == 'past-list' ? 1 : 0);
        if (console) console.log($id);
        if (console) console.log(sort);

        $(this).tablesorter(
        {
            sortList: [[1, sort]],
            headers:
            {
                4:
                {
                    sorter: false
                }
            }
        });
    });
});
