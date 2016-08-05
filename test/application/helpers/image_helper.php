<?php

function formatImagesByID(&$images = [])
{
    // Error out if images are empty
    if (empty($images)) return false;

    // Temporary images array
    $_images  = [];

    // Loop through each image in the received array
    foreach ($images as $_image)
    {
        // Build image paths
        $_image['paths'] = buildImagePaths($_image);

        // Add to temporary image array
        $_images[] = $_image;
    }

    // Swap arrays
    $images = $_images;

    // Success!
    return true;
}

function unflattenImageInfo(&$item = [])
{
    // Error out if item is empty
    if (empty($item)) return false;

    // Temporary image paths array
    $_paths = [];

    // Reform item array's image data into a nested array
    $_image = [];
    foreach ($item as $_key => $_value)
    {
        // Check if key begins with "image_"
        if (stripos($_key, 'image_') !== false)
        {
            // Strip out "image_" from key and store in temporary image array
            $_newkey            = str_ireplace('image_', '', $_key);
            $_image[$_newkey]   = $_value;

            // Drop old field
            unset($item[$_key]);
        }
    }

    // Create new image field to contain temporary image array
    $item['image'] = $_image;
    // Add paths to image info array
    $item['image']['paths'] = buildImagePaths($_image);
    // Garbage collection sanity check
    unset($_image);

    // Success!
    return true;
}

function buildImagePaths($image)
{
    // Temporary paths variable
    $_paths = [];

    // Loop through each image size and build path from data
    foreach (getImageUploadSettings() as $_size => $_data)
    {
        // Build path
        $_paths[$_size] = PATH_IMAGE_UPLOADS_WWW . SEP . $image['app'] . SEP . $image['id'] . $_data['suffix'] . '.' . $image['ext'];
    }

    // Return all paths
    return $_paths;
}

function outputImagesJSON($images)
{
    // Get error status (null or false)
    $_error = (is_null($images) || $images === false);

    // If an error is thrown, send a 400 bad request header
    if ($_error)
    {
        header('HTTP/1.1 400 Bad Request');
        die();
    }

    // Write JSON to file
    echo json_encode($images);
}

/**
 * @function getImageUploadSettings  Returns the settings for images to build path info from
 * @todo Refactor out the magic numbers to either global.php or another config file
 * @returns array   The image settings list
 */
function getImageUploadSettings()
{
    // Build sizes array
    $sizes =
    [
        PATH_IMAGE_SIZE_BANNER =>
        [
            'width'   => 1000,
            'height'  => 400,
            'suffix'  => PATH_IMAGE_SUFFIX_BANNER,
            'quality' => 90
        ],
        PATH_IMAGE_SIZE_ICON =>
        [
            'width'   => 60,
            'height'  => 60,
            'suffix'  => PATH_IMAGE_SUFFIX_ICON,
            'quality' => 50
        ],
        PATH_IMAGE_SIZE_ORIGINAL =>
        [
            'suffix'  => PATH_IMAGE_SUFFIX_ORIGINAL,
            'quality' => 100,
            'long'    => 2000
        ],
        PATH_IMAGE_SIZE_THUMB =>
        [
            'width'  => 150,
            'height' => 100,
            'suffix' => PATH_IMAGE_SUFFIX_THUMB,
            'quality' => 70
        ],
    ];
    return $sizes;
}

function resizeImageVertically(&$img, $data)
{
    // Make image calculations
    $_half_w_src  = $data['src']['width'] / 2;
    $_half_w_dest = $data['dest']['width'] / 2;
    $data['ratios']['resize'] = $data['dest']['height'] / $data['src']['height'];
    $_left_x = $_half_w_src - ($_half_w_dest * (1 / $data['ratios']['resize']));
    $_right_x = $_half_w_src + ($_half_w_dest * (1 / $data['ratios']['resize']));

    // Set crop rectangle
    $crop = [
        'x' => $_left_x,
        'y' => 0,
        'width' => $_right_x - $_left_x,
        'height' => $data['src']['height']
    ];

    // Build image
    return _resizeImage($img, $crop, $data['dest']);
}

function resizeImageHorizontally(&$img, $data)
{
    // Make image calculations
    $_half_h_src  = $data['src']['height'] / 2;
    $_half_h_dest = $data['dest']['height'] / 2;
    $data['ratios']['resize'] = $data['dest']['width'] / $data['src']['width'];
    $_top_y = $_half_h_src - ($_half_h_dest * (1 / $data['ratios']['resize']));
    $_bottom_y = $_half_h_src + ($_half_h_dest * (1 / $data['ratios']['resize']));

    // Set crop rectangle
    $crop = [
        'x' => 0,
        'y' => $_top_y,
        'width' => $data['src']['width'],
        'height' => $_bottom_y - $_top_y
    ];

    // Build image
    return _resizeImage($img, $crop, $data['dest']);
}

function _resizeImage(&$img, $crop, $resize)
{
    // Perform shrinking operation
    /*
    if (function_exists('imagecrop') && function_exists('imagescale'))
    {
        var_dump($crop);
        // Crop, then resample down to width
        $_img = imagescale(imagecrop($img, $crop), $resize['width'], $resize['height'], IMG_BICUBIC_FIXED);
    }
    else
    {
    */
        // Create new true color image
        $_img = imagecreatetruecolor($resize['width'], $resize['height']);
        // Resample down to width and crop height
        imagecopyresampled($_img, $img, 0, 0, $crop['x'], $crop['y'], $resize['width'], $resize['height'], $crop['width'], $crop['height']);
    /*
    }
    */
    return $_img;
}