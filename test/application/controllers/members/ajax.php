<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends PDX_Controller
{
    /**
     * @method  void    __construct
     */
    public function __construct()
    {
        parent::__construct();
        // Load blog model
        $this->load->model('apps/blog');
    }

    /**
     * @method  mixed   _remap  Catches all requests to check for login before forwarding
     * @param   string  $domain The domain the request is for; can be an app like "blog"
     * @param   array   $params Any parameters included in the request
     * @return  mixed           The requested method or a 404 page
     */
    public function _remap($domain, $params = [])
    {
        // Output as JSON
        header('Content-Type: application/json');

        // Login check (401 if not logged in)
        if (!$this->_is_logged_in())
        {
            // Set response header and die
            header('HTTP/1.1 401 Unauthorized');
            die();
        }

        // Strip first parameter out as the action
        $action = array_shift($params) ?: null;

        // Build method to search for
        $method = $domain . (empty($action) ? '' : '__' . $action);

        // Redirect if method exists
        if (method_exists($this, $method)) return call_user_func_array(array($this, $method), $params);

        // 404 if method doesn't exist
        show_404();
    }

    /**
     * @method  void    generate_permalink  Creates a permalink slug from text and an app
     */
    function generate_slug()
    {
        // See if POST check error is generated
        $_error = ($this->input->post('text') === false || $this->input->post('app') === false);

        // POST checks
        if ($_error)
        {
            header('HTTP/1.1 406 Method Not Allowed');
            header('Access-Control-Allow-Methods: POST');
            die();
        }

        // Get title and app from POST
        $text = $this->input->post('text');
        $app  = $this->input->post('app');

        // Temporary iterator variables
        $i       = 0;
        $_exists = true;    // Assume slug exists until proven not
        $_check  = null;    // Will get set in first while loop

        // Make slug
        $_slug = url_title($text, '-', true);

        // Loop to check if slug exists
        while ($_exists)
        {
            // Build check slug
            $_check  = $_slug . ($i > 0 ? '-' . $i : '');

            // Check for existence
            $_exists = $this->{$app}->slugExists($_check);

            // If it exists (or doesn't exist but we're on 1), bump the number
            // (Avoids having text-1 between text and text-2, for example)
            if ($_exists || ($_exists === false && $i == 1))
            {
                $_exists = true;    // Force true -- only matters for $i = 1
                $i++;
            }

            // Emergency killer
            if ($i >= 10000) break;
        }

        // Save check slug as definitive slug
        $_slug = $_check;

        // Output eventual slug
        echo json_encode($_slug);
    }

    /**
     * @method  void    blog__get_images    Outputs JSON for blog images
     */
    public function blog__get_images()
    {
        // Get image list
        $images = $this->appimage->getBlogImages();

        // Output JSON data
        outputImagesJSON($images);
    }

    // @todo Refactor and genericize
    public function blog__upload_image()
    {
        // Set return type
        header('Content-Type: application/json');

        // Check to see if files variable is even present (400 bad request)
        if (!isset($_FILES) || !array_key_exists('file', $_FILES))
        {
            header('HTTP/1.1 400 Bad Request');
            die();
        }

        // Retrieve file
        $file = $_FILES['file'];

        // Upload error checks
        switch($file['error'])
        {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                header('HTTP/1.1 413 Request Entity Too Large');
                die();
            case UPLOAD_ERR_NO_FILE:
            case UPLOAD_ERR_NO_TMP_DIR:
                header('HTTP/1,1 404 Not Found');
                die();
            case UPLOAD_ERR_CANT_WRITE:
                header('HTTP/1.1 403 Forbidden');
                die();
            case UPLOAD_ERR_EXTENSION:
                header('HTTP/1.1 500 Internal Server Error');
                die();
            case UPLOAD_ERR_PARTIAL:
            default:
                header('HTTP/1.1 406 Not Acceptable');
                die();
        }

        // Load valid image MIME types
        $valid_mimetypes = [
            image_type_to_extension(IMAGETYPE_JPEG, true) => image_type_to_mime_type(IMAGETYPE_JPEG),
            image_type_to_extension(IMAGETYPE_PNG, true)  => image_type_to_mime_type(IMAGETYPE_PNG)
        ];

        // Get EXIF image type
        $filetype = exif_imagetype($file['tmp_name']);

        // Throw error if not correct MIME type
        if (!in_array(image_type_to_mime_type($filetype), array_values($valid_mimetypes)))
        {
            header('HTTP/1.1 415 Unsupported Media Type');
            die();
        }

        // Start redirecting, resizing and renaming files
        $id          = time();
        $fileext     = str_ireplace('jpeg', 'jpg', image_type_to_extension($filetype, false));
        $dotext      = '.' . $fileext;
        $filename    = $id . $dotext;
        $temp_dir    = $file['tmp_name'];
        $base_dir    = PATH_IMAGE_UPLOADS_ROOT . SEP . PATH_IMAGE_APP_BLOG . SEP;
        $www_dir     = PATH_IMAGE_UPLOADS_WWW . SEP . PATH_IMAGE_APP_BLOG . SEP;
        $upload_dirs = [
            PATH_IMAGE_SIZE_ORIGINAL => $base_dir . PATH_IMAGE_SIZE_ORIGINAL . SEP . $filename,
            PATH_IMAGE_SIZE_BANNER   => $base_dir . PATH_IMAGE_SIZE_BANNER . SEP . $filename,
            PATH_IMAGE_SIZE_THUMB    => $base_dir . PATH_IMAGE_SIZE_THUMB . SEP . $filename,
            PATH_IMAGE_SIZE_ICON     => $base_dir . PATH_IMAGE_SIZE_ICON  . SEP . $filename,
        ];
        $www_dirs = [
            PATH_IMAGE_SIZE_ORIGINAL => $www_dir . $id . PATH_IMAGE_SUFFIX_ORIGINAL . $dotext,
            PATH_IMAGE_SIZE_BANNER   => $www_dir . $id . PATH_IMAGE_SUFFIX_BANNER . $dotext,
            PATH_IMAGE_SIZE_THUMB    => $www_dir . $id . PATH_IMAGE_SUFFIX_THUMB . $dotext,
            PATH_IMAGE_SIZE_ICON     => $www_dir . $id . PATH_IMAGE_SUFFIX_ICON . $dotext,
        ];

        // Get uploaded image info
        $info = getimagesize($temp_dir);
        list($_sw, $_sh) = $info;

        // Create file to resize
        switch ($info['mime'])
        {
            case image_type_to_mime_type(IMAGETYPE_JPEG):
                $image_create_func = 'imagecreatefromjpeg';
                $image_save_func = 'imagejpeg';
                break;
            case image_type_to_mime_type(IMAGETYPE_PNG):
                $image_create_func = 'imaegcreatefrompng';
                $image_save_func = 'imagepng';
                break;
            default:    // Unsupported media type catchall (should never run)
                header('HTTP/1.1 415 Unsupported Media Type');
                die();
        }

        // Create image handler
        $img = $image_create_func($temp_dir);

        // Get image upload data
        $_settings = getImageUploadSettings();

        // Loop through each image setting
        // @todo Refactor into helper function or method?
        foreach ($_settings as $_size => $_setting)
        {
            // Create temporary image variable
            $_img = null;

            // Store build data
            $build_data = [];

            // Settings shared by all image size
            $build_data['src']['width']   = $_sw;
            $build_data['src']['height']  = $_sh;
            $build_data['src']['ratio']   = $build_data['src']['width'] / $build_data['src']['height'];

            // Check if resizing to long size
            if (array_key_exists('long', $_setting))
            {
                // If width longer than height
                if ($build_data['src']['ratio'] >= 1)
                {
                    $_short = $_sh * (1 / $build_data['src']['ratio']);
                }
                else
                {
                    $_short = $_sw * $build_data['src']['ratio'];
                }
                // Calculate the short side
                //$_short =
            }
            else
            {
                $build_data['dest']['width']  = $_setting['width'];
                $build_data['dest']['height'] = $_setting['height'];
            }

            // Build some ratios
            $build_data['dest']['ratio'] = $build_data['dest']['width'] / $build_data['dest']['height'];

            // Perform different actions based on size and ratios
            switch ($_size)
            {
                case PATH_IMAGE_SIZE_ICON:
                    // If width is longer than or equal to height
                    if ($build_data['src']['ratio'] >= 1)
                    {
                        // Crop and resize image vertically
                        $_img = resizeImageVertically($img, $build_data);
                    }
                    // If width is shorter than height
                    elseif ($build_data['src']['ratio'] < 1)
                    {
                        // Crop and resize image horizontally
                        $_img = resizeImageHorizontally($img, $build_data);
                    }
                    break;
                case PATH_IMAGE_SIZE_THUMB:
                case PATH_IMAGE_SIZE_BANNER:
                    // If width is longer than or equal to height
                    if ($build_data['src']['ratio'] >= 1)
                    {
                        // If source is wider than destination
                        if ($build_data['src']['ratio'] >= $build_data['dest']['ratio'])
                        {
                            // Crop and resize image vertically
                            $_img = resizeImageVertically($img, $build_data);
                        }
                        else
                        {
                            // Crop and resize image horizontally
                            $_img = resizeImageHorizontally($img, $build_data);
                        }
                    }
                    // If width is shorter than height
                    elseif ($build_data['src']['ratio'] < 1)
                    {
                        // Crop and resize image vertically
                        $_img = resizeImageHorizontally($img, $build_data);
                    }
                    break;
                default:
                    header('HTTP/1.1 400 Bad Request');
                    die();
            }

            // Save as appropriate type
            $image_save_func($_img, $upload_dirs[$_size], $_setting['quality']);

            // Destroy image resource
            imagedestroy($_img);
        }

        // Assuming everything saved properly...
        // Destroy image resource
        imagedestroy($img);

        // Build array of data to save to DB
        $insert = [
            'id'                    => $id,
            'orig_name'             => $file['name'],
            'app'                   => PATH_IMAGE_APP_BLOG,
            'ext'                   => $fileext,
            'date_uploaded'         => date('Y-m-d H:i:s'),
            'date_last_modified'    => date('Y-m-d H:i:s')
        ];

        // Save image data to DB
        $record = $this->blog->uploadBlogImage($insert);

        // Throw error if record not added
        if (!$record)
        {
            header('HTTP/1.1 406 Not Acceptable');
            die();
        }

        // Add the paths to the insert data
        $insert['paths']  = $www_dirs;
        $insert['record'] = $record;

        // Return the newly stored image data
        echo json_encode($insert);
        exit;
    }

    /**
     * @method  void    rotator__get_images    Outputs JSON for rotator images
     */
    public function rotator__get_images()
    {
        // Get image list
        $images = $this->appimage->getRotatorImages();

        // Output JSON data
        outputImagesJSON($images);
    }

    /**
     * @method  void    sponsors__get_images    Outputs JSON for sponsor images
     */
    public function sponsors__get_images()
    {
        // Get image list
        $images = $this->appimage->getSponsorImages();

        // Output JSON data
        outputImagesJSON($images);
    }
}

