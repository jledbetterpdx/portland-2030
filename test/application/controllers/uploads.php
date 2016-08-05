<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @class Uploads  Handles image uploads
 */
class Uploads extends CI_Controller {

    /**
     * @method  void    __construct Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @method  void    image   Simple passthrough script to show uploaded images stored below the web root
     * @param   string  $app    The application the image was stored by, like blog or rotator
     * @param   string  $size   The image size, like banner or thumb
     * @param   int $id The ID of the image, usually a timestamp
     * @param   string  $ext    The extension of the image
     */
    public function image($app, $size, $id, $ext)
    {
        // Build path
        $_path = PATH_IMAGE_UPLOADS_ROOT . SEP . $app . SEP . $size . SEP . $id . '.' . $ext;

        // Create image based on format
        switch ($ext)
        {
            case 'gif':
                $_input  = 'imagecreatefromgif';
                $_output = 'imagegif';
                $_type   = IMAGETYPE_GIF;
                break;
            case 'jpg':
            case 'jpeg':
                $_input  = 'imagecreatefromjpeg';
                $_output = 'imagejpeg';
                $_type   = IMAGETYPE_JPEG;
                break;
            case 'png':
                $_input  = 'imagecreatefrompng';
                $_output = 'imagepng';
                $_type   = IMAGETYPE_PNG;
                break;
            default:
                show_404();
                return; // This should never run
        }

        // Run appropriate image handle creation function
        $_ih = @$_input($_path);

        // Throw 404 if image not found
        if (!$_ih)
        {
            show_404();
            return;
        }

        // Set content type
        header('Content-Type: ' . image_type_to_mime_type($_type));

        // Output image to browser
        $_output($_ih);

        // Destroy image
        imagedestroy($_ih);
    }
}

/* End of file uploads.php */
/* Location: ./application/controllers/uploads.php */