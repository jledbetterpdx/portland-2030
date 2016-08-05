<?php

class admin extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function login__verify($username, $enc_password, $legacy = false)
    {
        // Build query
        $this->db->select('`m`.`id` AS `member_id`', false);
        $this->db->select('`m`.`first_name`', false);
        $this->db->select('`m`.`password_reset`', false);
        $this->db->select('`m`.`status_id`', false);
        $this->db->select('GROUP_CONCAT(DISTINCT `mc`.`committee_id` ORDER BY `mc`.`committee_id`) AS `committee_ids`', false);
        $this->db->select('GROUP_CONCAT(DISTINCT `mo`.`officer_id` ORDER BY `mo`.`officer_id`) AS `officer_ids`', false);
        $this->db->select('GROUP_CONCAT(DISTINCT `mp`.`permission_id` ORDER BY `mp`.`permission_id`) AS `permission_ids`', false);
        $this->db->from('members AS m');
        $this->db->join('member_committees AS mc', 'm.id = mc.member_id', 'left');
        $this->db->join('member_officers AS mo', 'm.id = mo.member_id', 'left');
        $this->db->join('member_permissions AS mp', 'm.id = mp.member_id', 'left');
        $this->db->where('username', $username);
        if ($legacy === true)
        {
            $this->db->where('password', $enc_password);
        }
        else
        {
            $this->db->where('password_enc', $enc_password);
        }
        $this->db->group_by('m.id');
        $this->db->limit(1);

        // Get results
        $results = $this->db->get();
        $return  = $results->row_array();

        // Return results
        return (empty($return) ? false : $return);
    }

    function login__get_user($username)
    {
        // Build query
        $this->db->select('`m`.`id` AS `member_id`', false);
        $this->db->select('`m`.`first_name`', false);
        $this->db->select('`m`.`password`', false);
        $this->db->select('`m`.`password_enc`', false);
        $this->db->select('`m`.`password_reset`', false);
        $this->db->select('`m`.`status_id`', false);
        $this->db->select('GROUP_CONCAT(DISTINCT `mc`.`committee_id` ORDER BY `mc`.`committee_id`) AS `committee_ids`', false);
        $this->db->select('GROUP_CONCAT(DISTINCT `mo`.`officer_id` ORDER BY `mo`.`officer_id`) AS `officer_ids`', false);
        $this->db->select('GROUP_CONCAT(DISTINCT `mp`.`permission_id` ORDER BY `mp`.`permission_id`) AS `permission_ids`', false);
        $this->db->from('members AS m');
        $this->db->join('member_committees AS mc', 'm.id = mc.member_id', 'left');
        $this->db->join('member_officers AS mo', 'm.id = mo.member_id', 'left');
        $this->db->join('member_permissions AS mp', 'm.id = mp.member_id', 'left');
        $this->db->where('username', $username);
        $this->db->group_by('m.id');
        $this->db->limit(1);

        // Get results
        $results = $this->db->get();
        $return  = $results->row_array();

        // Return results
        return (empty($return) ? false : $return);
    }

    function member__validate_reset_code($code)
    {
        // Build query
        $this->db->select('id');
        $this->db->from('members');
        $this->db->where('password_reset', $code);
        $this->db->limit(1);

        // Get results
        $results = $this->db->get();
        $return  = $results->row_array();

        // Return boolean
        return (!empty($return));
    }

    function member__set_password_reset_code($member_id)
    {
        // Load string helper
        $this->load->helper('string');

        // Randomize link code
        $code = random_string('alnum', 40);

        // Determine updater ID
        $modifier_id = (!empty($this->session->userdata('member_id')) ? $this->session->userdata('member_id') : SYSTEM_MEMBER_ID);

        // Store new last modified date as current time
        $last_modified = date('Y-m-d H:i:s');

        // Build data to update
        $update = array(
            'date_last_modified' => $last_modified,
            'password_reset'     => $code,
            'last_modified_by'   => $modifier_id
        );

        // Build query
        $this->db->where('id', $member_id);
        $this->db->update('members', $update);

        // Return generated code
        return $code;
    }

    function member__get_info_by_username($username)
    {
        // Build query
        $this->db->select('*');
        $this->db->from('members');
        $this->db->where('username', $username);
        $this->db->limit(1);

        // Make call to database
        $results = $this->db->get();

        // Set return variable
        $return = ($results->num_rows() > 0 ? $results->row_array() : false);

        // Duh
        return $return;
    }

    function member__reset_password($id, $hash)
    {
        // Build update array
        $update = array(
            'password'           => $hash,
            'password_reset'     => null,
            'date_last_modified' => date('Y-m-d H:i:s'),
            'last_modified_by'   => $id
        );

        // Update user account and reset password
        $this->db->where('id', $id);
        $this->db->update('members', $update);
    }

    function member__update_password($id, $hash)
    {
        // Build update array
        $update = array(
            'password_enc'       => $hash,
            'password'           => null,
            'password_reset'     => null,
            'date_last_modified' => date('Y-m-d H:i:s'),
            'last_modified_by'   => $id
        );

        // Update user account and reset password
        $this->db->where('id', $id);
        $this->db->update('members', $update);
    }

    function event__add_event($event)
    {
        return $this->event__add_edit_event('add', $event);
    }

    function event__edit_event($event, $id)
    {
        return $this->event__add_edit_event('edit', $event, $id);
    }

    function event__add_edit_event($type, $event, $id = null)
    {
        // Initially combine dates (start_date is always included)
        $_next_day = date('n/j/Y', strtotime($event['start_date'] . ' +1 day'));
        if (empty($event['end_date']))
        {
            if (empty($event['end_time']))
            {
                $event['end_date'] = (empty($event['start_time']) ? $_next_day : $event['start_date']);
            }
            else
            {
                $event['end_date'] = $event['start_date'];
            }
        }
        if (empty($event['start_time'])) $event['start_time'] = '12 am';
        if (empty($event['end_time']))   $event['end_time']   = $event['start_time'];

        // Manipulate dates based on checkbox states
        if (!empty($event['no_end_date']))
        {
            $event['end_date'] = (!empty($event['all_day_event']) ? $_next_day : $event['start_date']);
            $event['end_time'] = $event['start_time'];
        }
        elseif (!empty($event['all_day_event']))
        {
            $event['end_date'] = (!empty($event['end_date']) ? $event['end_date'] : $_next_day);
            $event['end_time'] = '12 am';
        }
        $event['date_start'] = date('Y-m-d H:i:s', strtotime($event['start_date'] . ' ' . $event['start_time']));
        $event['date_end']   = date('Y-m-d H:i:s', strtotime($event['end_date'] . ' ' . $event['end_time']));
        unset($event['start_date']);
        unset($event['start_time']);
        unset($event['end_date']);
        unset($event['end_time']);

        // Correct for blank latitude/longitude
        if (empty($event['latitude'])) $event['latitude'] = null;
        if (empty($event['longitude'])) $event['longitude'] = null;

        // Change '-' to null
        if ($event['status'] == '-') $event['status'] = null;

        // Add recordkeeping fields
        $event['date_last_updated'] = date('Y-m-d H:i:s');
        $event['last_updated_by']   = $this->session->userdata('member_id');

        // Initialize return variable (null for calls as void function)
        $return = null;

        // Determine database calls and some event values based on type
        switch ($type)
        {
            case 'edit':
                // Boolean fields
                if (empty($event['all_day_event'])) $event['all_day_event'] = 0;
                if (empty($event['multiday_event'])) $event['multiday_event'] = 0;
                if (empty($event['rsvp_only'])) $event['rsvp_only'] = 0;
                if (empty($event['hide_address'])) $event['hide_address'] = 0;

                // Update event in database
                $this->db->where('id', $id);
                $this->db->update('events', $event);

                break;
            case 'add':
            default:
                // Creation recordkeeping
                $event['date_added'] = date('Y-m-d H:i:s');
                $event['added_by']   = $this->session->userdata('member_id');

                // Add slug
                $event['slug'] = url_title($event['name'], '-', true);

                // Add event to database
                $this->db->insert('events', $event);

                // Set return variable to insert ID
                $return = $this->db->insert_id();

                break;
        }

        // Return insert ID
        return $return;
    }

    function event__cancel_event($id)
    {
        $this->event__cancel_uncancel_event($id);
    }

    function event__uncancel_event($id)
    {
        $this->event__cancel_uncancel_event($id, true);
    }

    function event__cancel_uncancel_event($id, $uncancel = false)
    {
        // Build update query
        $update = array(
            'status'            => (int)$uncancel, // Shortcut to set 0 (cancelled) or 1 (confirmed/uncancelled)
            'date_last_updated' => date('Y-m-d H:i:s'),
            'last_updated_by'   => $this->session->userdata('member_id')
        );

        // Cancel or uncancel event
        $this->db->where('id', $id);
        $this->db->update('events', $update);
    }

    function event__delete_event($id)
    {
        // Delete event from main events table
        $this->db->where('id', $id);
        $this->db->delete('events');

        // Delete event from link table
        $this->db->where('event_id', $id);
        $this->db->delete('event_links');
    }
}