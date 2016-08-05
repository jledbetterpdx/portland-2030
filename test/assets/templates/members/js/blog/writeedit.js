$(document).ready(function()
{
    // Variables
    var post_image_icon_imgs        = '#post_image_icons img';
    var post_image_icon_prefix      = 'post_image_icon_';
    var post_image_icon             = '#' + post_image_icon_prefix;

    // Form fields
    var $slug                   = $('#slug');
    var $title                  = $('#title');
    var $image_id               = $('#image_id');
    var $image_upload           = $('#image_upload');
    var $image_upload_button    = $('#image_upload_button');
    var $category_add           = $('#category_add');
    var $category_add_button    = $('#category_add_button');
    var $category_id            = $('#category_id');
    var $category_options       = $('#category_id option');

    // Misc. DOM elements
    var $post_image_icons           = $('#post_image_icons');
    var $post_section_permalink     = $('#post_section_permalink');
    var $post_permalink_slug        = $('#post_permalink_slug');
    var $post_permalink_slug_input  = $('#post_permalink_slug_input');
    var $slug_update                = $('#slug_update');
    var $slug_cancel                = $('#slug_cancel');


    function slugify(text, app)
    {
        // Build AJAX call to get and set slug
        $.ajax({
            method: 'POST',
            data:
            {
                'text' : text,
                'app'  : app
            },
            url: '/members/ajax/generate_slug',
            success: function(slug)
            {
                // Show permalink box
                $post_section_permalink.removeClass('hidden');
                // Update slug label
                $post_permalink_slug.text(slug);
                // Update hidden slug text box value
                $slug.val(slug);
                // Remove data flag and remove the blur event itself, to stop it running again
                $title.removeData('set-permalink').off('blur');
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                // Create toast notification
                makeToast('Could not create permalink: ' + errorThrown);
                if (console) console.log('ERRORS: ' + textStatus);
            }
        });
    }

    function loadBlogImages()
    {
        // Build throbber object
        $throbber = $('<div class="init throbber"><i class="fa-fw fa fa-cog fa-spin"></i> Loading...</div>');
        // Remove all blog images from the list
        $post_image_icons.html('').append($throbber);

        // Build AJAX call to add images to gallery
        $.ajax({
            method: 'POST',
            url: '/members/ajax/blog/get_images',
            success: function(images)
            {
                // Loop through each image
                for (idx in images)
                {
                    // Image shorthand
                    _image = images[idx];

                    // Make and append image
                    makeImage(_image, true, $post_image_icons);
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                // Create toast notification
                makeToast('Could not load blog images: ' + errorThrown);
                if (console) console.log('ERRORS: ' + textStatus);
            },
            complete: function()
            {
                // Remove throbber
                garbage = $throbber.detach();
            }
        });
    }

    function makeImage(image, append, attachTo)
    {
        // Create new image
        $_image = $('<img>');
        // Store attributes
        $_image.attr('src', image.paths.icon);
        $_image.attr('id', post_image_icon_prefix + image.id);
        $_image.attr('alt', image.orig_name);
        $_image.attr('title', image.orig_name + ' (Uploaded ' + image.date_uploaded + ')');
        $_image.data('id', image.id);

        // Append image to the list
        if (append)
        {
            $_image.appendTo(attachTo);
        }
        else
        {
            $_image.prependTo(attachTo);
        }
    }

    function makeToast(message)
    {
        // Create toast notification
        $_toast = $('<div></div>').html(message).addClass('toast');
        // Show and self-remove toast notification
        $_toast.appendTo('body').fadeIn(400, function()
        {
            // Self-removal timeout
            setTimeout(function()
            {
                $_toast.fadeOut(400, function()
                {
                    garbage = $_toast.detach();
                });
            }, 6000);
        });
    }

    $(document).on("click", post_image_icon_imgs, function()
    {
        // Store currently existing image icons locally
        $post_image_icon_imgs = $(post_image_icon_imgs);
        // Check if current image is selected
        // @todo Compare hidden field to data field instead of classes
        _selected = $(this).hasClass('selected');
        // Remove all selected classes from all images
        $post_image_icon_imgs.removeClass('selected');
        // Check if this was selected
        if (_selected)
        {
            // Remove selected image
            $image_id.val('');
        }
        else
        {
            // Add selected class back to this instance
            $(this).addClass('selected');
            // Set selected image
            $image_id.val($(this).data('id'));
        }
    });

    if ($title.data('set-permalink') == true)
    {
        $title.on('blur', function()
        {
            // Get temporary variable
            title = $title.val().trim();

            // Generate slug
            if (title != '') slugify(title, 'blog');
        });
    }

    // Handles initiating slug change
    $post_permalink_slug.on('dblclick', function()
    {
        // Hide slug label
        $post_permalink_slug.addClass('hidden');
        // Show slug input box and controls
        $post_permalink_slug_input.removeClass('hidden');
        // Save original slug as data attribute, then give input focus
        $slug.data('revert', $slug.val()).focus();
    });

    // Handles updating slug
    $slug_update.on('click', function()
    {
        // Treat a blank permalink box like a cancel
        if ($slug.val().trim() == '')
        {
            $slug_cancel.click();
        }
        else
        {
            // Hide input box and controls
            $post_permalink_slug_input.addClass('hidden');
            // Slugify text
            slugify($slug.val(), 'blog');
            // Show slug label
            $post_permalink_slug.removeClass('hidden');
        }
    });

    // Handles cancelling slug update
    $slug_cancel.on('click', function()
    {
        // Hide input box and controls
        $post_permalink_slug_input.addClass('hidden');
        // Show slug label
        $post_permalink_slug.removeClass('hidden');
        // Reset input box value
        $slug.val($post_permalink_slug.text());
    });

    // Handles image upload button click (fires hidden file field)
    $image_upload_button.on('click', function()
    {
        $image_upload.click();
    });

    // Handles image upload logic
    // @link http://abandon.ie/notebook/simple-file-uploads-using-jquery-ajax   Adapted from this script
    // @author  Abban Dunne
    $image_upload.on('change', function(event)
    {
        // Get first file
        var file = event.target.files[0] || false;

        // Error out if no file
        if (!file) return;

        // Stop stuff happening (unsure if need?)
        event.stopPropagation(); // Stop stuff happening
        event.preventDefault(); // Totally stop stuff happening

        // Build throbber object
        $throbber = $('<div class="icon throbber" title="Uploading image..."><i class="fa-fw fa fa-cog fa-spin"></i></div>');
        // Remove all blog images from the list
        $post_image_icons.prepend($throbber);

        // Create a new formData object
        var data = new FormData();

        // Append file to form data
        data.append('file', file);

        $.ajax({
            url: '/members/ajax/blog/upload_image',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            success: function(data, textStatus, jqXHR)
            {
                if (console) console.dir(data);
                // Remove throbber
                garbage = $throbber.detach();
                // Make and prepend image
                makeImage(data, false, $post_image_icons);
                // Select icon by firing the new image's click event
                // Handles
                $(post_image_icon + data.id).click();
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                // Create toast notification
                makeToast('Cannot upload image: ' + errorThrown);
                if (console) console.log('ERRORS: ' + textStatus);
                if (console) console.log('THROWN: ' + errorThrown);
                if (console) console.dir(jqXHR);
            },
            complete: function()
            {
                // Remove throbber (will be ignored if successful)
                garbage = $throbber.detach();
                // Remove filename from image upload
                $image_upload.val('');
            }
        });
    });

    $category_add_button.on('click', function()
    {
        // Store trimmed category name
        category = $category_add.val().trim();
        // Only proceed if there's a category value to add
        if (!category) return;
        // Remove category value from new name box
        $category_add.val('');
        // Check if category already exists
        var exists;
        $category_options.each(function()
        {
            var $self = $(this);
            if ($self.text() == category)
            {
                $self.prop('selected', true);
                exists = true;
            }
            else
            {
                exists = exists || false;
            }
        });
        // Return if already exists
        if (exists === true) return;
        // Build category option
        $new_option = $('<option></option>').attr('value', '').text(category).data('is-custom', true);
        // Append new option to end of select box
    });

    /* Redactor WYSIWYG editor code */
    var buttons = ['bold', 'italic', 'underline', 'deleted', '|', 'alignleft', 'aligncenter', 'alignright', 'justify', '|', 'fontcolor', 'backcolor', '|', 'unorderedlist', 'orderedlist', 'indent', 'outdent', '|', 'image', 'video', 'file', 'table', 'link', '|', 'horizontalrule', '|', 'uploadmedia'];
    $('#post').redactor(
    {
        buttons: buttons,
        buttonsCustom: {
            uploadmedia: {
                title: 'Upload Media',
                callback: function(obj)
                {
                    if (console) console.dir(obj);
                    alert('Sorry: Media upload coming in future update.');
                }
            }
        },
        minHeight: 300
    });

    /* Load all blog images */
    loadBlogImages();

});