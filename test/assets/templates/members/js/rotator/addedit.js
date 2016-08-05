// File variable
var file;

// Prepare file variable
function prepareFileUpload(event)
{
    file = event.target.files;
}

$(document).ready(function()
{
    // Shorthand/recycled jQuery objects
    var $image_id            = $('#image_id');
    var $image_previous_icon = $('.image_previous_icon');
    var $image_upload        = $('#image_upload');
    var $image_upload_button = $('#image_upload_button');
    var $upload_image        = $('form#upload_image');

    // Prepare file upon change
    $image_upload.on('change', prepareFileUpload);

    // Selecting a previous image to reuse
    $(document).on("click", ".image_previous_icon", function()
    {
        // Temporary variables
        var select, id;
        var $this = $(this);

        if ($this.hasClass('selected'))
        {
            // Unselect and remove ID from hidden field
            select = false;
            id     = false;
        }
        else
        {
            // Select and add ID to hidden field
            select = true;
            id     = $this.data('image-id');
        }

        // Remove selection from all icons
        $image_previous_icon.removeClass('selected');
        // Add back select if it was previously on a different icon
        if (select === true) $this.addClass('selected');
        // Sets image ID
        $image_id.val(id);
    });

    $upload_image.submit(function(event)
    {
        // Full stop on any default actions
        event.stopPropagation();
        event.preventDefault();

        // Disable and change text of upload button
        $image_upload_button.prop('disabled', true).html('Uploading...');

        // Form data prep
        var _data = new FormData();
        $.each(file, function(key, value)
        {
            _data.append(key, value);
        });

        // AJAX it
        $.ajax({
            url: '/members/rotator/upload',
            type: 'POST',
            data: _data,
            cache: false,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(data, status, xhr)
            {
                if (data.success === true)
                {
                    
                }
                else
                {

                }
            },
            error:
            {

            },
            complete:
            {

            }
        });
    });

});