<?php

class rotator extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_archived_rotator_images()
    {
        return $this->get_rotator_images(true);
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

        // Initialize return variable
        return $results->result_array();
    }
}