<?php

class appimage extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function getAppImageList()
    {
        // Build query to pull possible enum values from app column in the image table
        // @todo Refactor into actual DB table for maintenance
        $this->db->select('SUBSTRING(`COLUMN_TYPE`,5)', false);
        $this->db->from('`information_schema`.`COLUMNS`');
        $this->db->where('`TABLE_SCHEMA`=', 'portland2030', false);
        $this->db->where('`TABLE_NAME`=', 'image_uploads', false);
        $this->db->where('`COLUMN_NAME`=', 'app', false);

        // Get results
        $results = $this->db->get();

        // Return results
        return $results->result_array() ?: false;
    }

    function get_active_rotator_images()
    {
        return $this->get_rotator_images(false);
    }

    function get_rotator_images($archived = null)
    {
        // Build query
        $this->db->select('ri.*' . ($archived !== true ? ', rio.image_order' : ''));
        $this->db->from('rotator_images AS ri');
        // Include image order if returning active rotator images
        if ($archived !== true) $this->db->join('rotator_image_order AS rio', 'ri.id = rio.image_id', 'left');
        // Include archive flag if not returning all rotator images
        if (!is_null($archived)) $this->db->where('archived', (int)$archived);
        if ($archived !== true) $this->db->order_by('image_order');
        $this->db->order_by('slug');

        // Get results
        $results = $this->db->get();

        // Return results
        return $results->result_array() ?: false;
    }

    /**
     * @method  mixed   getBlogImages   Returns a list of images uploaded via blog app
     * @returns array|bool              The list or false
     */
    function getBlogImages()
    {
        return $this->_getImages('blog');
    }

    /**
     * @method  mixed   getRotatorImages    Returns a list of images uploaded via rotator app
     * @returns array|bool                  The list or false
     */
    function getRotatorImages()
    {
        return $this->_getImages('rotator');
    }

    /**
     * @method  mixed   getSponsorImages    Returns a list of images uploaded via sponsors app
     * @returns array|bool                  The list or false
     */
    function getSponsorImages()
    {
        return $this->_getImages('sponsors');
    }

    /**
     * @method  mixed       _getImages  Returns a list of images uploaded via any or all apps
     * @param   string|bool app         (Optional) Filters list to a single app if not false
     * @returns array|bool              The list or false
     */
    function _getImages($app = false)
    {
        // Build query
        $this->db->select('*');
        $this->db->from('image_uploads');
        // Limit by app if indicated
        if (!empty($app)) $this->db->where('app', $app);
        $this->db->order_by('date_uploaded', 'desc');

        // Get results
        $results = $this->db->get();

        // Store results
        $return = $results->result_array();

        // Reformat images if not empty or zero results
        if (!empty($return)) formatImagesByID($return);

        // Return results
        return $return;
    }
}