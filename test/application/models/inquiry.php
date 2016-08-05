<?php

class inquiry extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function insert_inquiry($insert)
    {
        $this->db->insert('inquiries', $insert);
    }

    function insert_spam($insert)
    {
        $this->db->insert('spam', $insert);
    }
}