<?php

class event extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_events($range_begin = null, $range_end = null, $limit = null, $raw = false)
    {
        // Load event helper
        $this->load->helper('event_helper');

        // Build query
        $this->db->select('e.*, et.name AS type_name, et.css_class AS css_class, et.icon_family AS icon_family, et.icon AS icon');
        $this->db->from('events AS e');
        $this->db->join('event_types AS et', 'e.type_id = et.id', 'left');
        if (!empty($range_begin)) $this->db->where('DATE_FORMAT(`date_start`, "%Y-%m-%d") >= ', chr(34) . $range_begin . chr(34), false);
        if (!empty($range_end)) $this->db->where('DATE_FORMAT(`date_start`, "%Y-%m-%d") <= ', chr(34) . $range_end . chr(34), false);
        $this->db->order_by('date_start, date_last_updated');
        if (!empty($limit)) $this->db->limit($limit);

        // Get results
        $results = $this->db->get();

        // Begin building return variable (array if records found, false if not)
        $return = ($results->num_rows() > 0 ? array() : false);

        // Loop through each row in recordset, if applicable
        foreach ($results->result_array() as $row)
        {
            if ($raw)
            {
                // Process event data
                process_event_data($row);

                // Add row to return
                $return[] = $row;
            }
            else
            {
                // Determine date key
                $row['date_key'] = (!empty($row['date_start']) ? date('Y-m-d', strtotime($row['date_start'])) : null);

                // Create new date key record if no other exists
                if (!array_key_exists($row['date_key'], $return)) $return[$row['date_key']] = array();

                // Process event data
                process_event_data($row);

                // Add row to return variable
                $return[$row['date_key']][] = $row;
            }
        }

        return $return;
    }

    function get_day_events($date)
    {
        // Get events over date "range"
        return $this->get_events($date, $date);
    }

    function get_events_by_type($type)
    {
        // Load event helper
        $this->load->helper('event_helper');

        // Build query
        $this->db->select('e.*, et.name AS type_name, et.css_class AS css_class, et.icon_family AS icon_family, et.icon AS icon');
        $this->db->from('events AS e');
        $this->db->join('event_types AS et', 'e.type_id = et.id', 'left');
        $_sort = 'asc';
        switch ($type)
        {
            case 'past':
                $this->db->where('date_start <= ', date('Y-m-d H:i:s'));
                $this->db->where_in('status', array(EVENT_STATUS_CONFIRMED, EVENT_STATUS_TENTATIVE));
                $_sort = 'desc';
                break;
            case 'tentative':
                $this->db->where('date_start > ', date('Y-m-d H:i:s'));
                $this->db->where('status', EVENT_STATUS_TENTATIVE);
                break;
            case 'cancelled':
                $this->db->where('status', EVENT_STATUS_CANCELLED);
                break;
            case 'upcoming':    // Redundant, but points to intended behavior
            default:
                $this->db->where('date_start > ', date('Y-m-d H:i:s'));
                $this->db->where('status', EVENT_STATUS_CONFIRMED);
        }
        $this->db->order_by('date_start', $_sort);

        // Get results
        $results = $this->db->get();

        // Initialize return variable
        $return = array();

        // Loop through each row in recordset, if applicable
        foreach ($results->result_array() as $row)
        {
            // Process event data
            process_event_data($row);

            // Add row to return
            $return[] = $row;
        }

        return $return;
    }

    function get_event($slug, $year = null, $month = null)
    {
        // Load event helper
        $this->load->helper('event_helper');

        // Build query
        $this->db->select('e.*, et.name AS type_name, et.css_class AS css_class, et.icon_family AS icon_family, et.icon AS icon');
        $this->db->from('events AS e');
        $this->db->join('event_types AS et', 'e.type_id = et.id', 'left');
        $this->db->where('e.slug', $slug);
        if (!is_null($year))
        {
            $this->db->where('YEAR(e.date_start)', $year, false);
        }
        if (!is_null($month))
        {
            $this->db->where('MONTH(e.date_start)', $month, false);
        }
        $this->db->limit(1);

        // Get results
        $results = $this->db->get();

        // Store results
        $row = $results->row_array();

        // Process event data
        process_event_data($row);

        // Return event
        return $row;
    }

    function get_event_by_id($id, $process = true)
    {
        // Load event helper
        $this->load->helper('event_helper');

        // Build query
        $this->db->select('e.*, et.name AS type_name, et.css_class AS css_class, et.icon_family AS icon_family, et.icon AS icon');
        $this->db->from('events AS e');
        $this->db->join('event_types AS et', 'e.type_id = et.id', 'left');
        $this->db->where('e.id', $id);
        $this->db->limit(1);

        // Get results
        $results = $this->db->get();

        // If no results return false
        if ($results->num_rows() == 0) return false;

        // Store results
        $row = $results->row_array();

        // Process event data
        if ($process) process_event_data($row);

        // Return event
        return $row;
    }

    function getEventTypes()
    {
        // Build query
        $this->db->select('*');
        $this->db->from('event_types');
        $this->db->order_by('sort_order');

        // Get results
        $results = $this->db->get();

        // Return results
        return $results->result_array();
    }
}