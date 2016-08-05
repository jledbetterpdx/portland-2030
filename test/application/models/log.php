<?php

class log extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function entry($action_id, $object_id, $level_id, $message, $action_by, $object_instance, $data)
    {
        // Build insert array
        $insert = array(
            'action_id'       => $action_id,
            'object_id'       => $object_id,
            'level_id'        => $level_id,
            'object_instance' => $object_instance,
            'action_by'       => $action_by,
            'message'         => $message,
            'data'            => $data,
            'date_logged'     => date('Y-m-d H:i:s')
        );

        // Insert log into database
        $this->db->insert('log', $insert);

        // Return insert ID
        return $this->db->insert_id();
    }
}

