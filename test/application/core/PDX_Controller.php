<?php

class PDX_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Load permission arrays
        $permissions = array
        (
            'events' => array
            (
                MEMBER_PERMISSION_ADD_EVENTS,
                MEMBER_PERMISSION_EDIT_EVENTS,
                MEMBER_PERMISSION_CANCEL_EVENTS,
                MEMBER_PERMISSION_DELETE_EVENTS
            ),
            'members' => array
            (
                MEMBER_PERMISSION_ADD_MEMBERS,
                MEMBER_PERMISSION_EDIT_MEMBERS,
                MEMBER_PERMISSION_REMOVE_MEMBERS,
                MEMBER_PERMISSION_RESET_PASSWORDS,
                MEMBER_PERMISSION_CHANGE_MEMBER_ACCESS,
                MEMBER_PERMISSION_CHANGE_MEMBER_ROLE
            ),
            'inquiries' => array
            (
                MEMBER_PERMISSION_VIEW_INQUIRIES,
                MEMBER_PERMISSION_RESPOND_INQUIRIES
            ),
            'rotator_images' => array
            (
                MEMBER_PERMISSION_ADD_ROTATOR_IMAGES,
                MEMBER_PERMISSION_EDIT_ROTATOR_IMAGES,
                MEMBER_PERMISSION_ARCHIVE_ROTATOR_IMAGES,
                MEMBER_PERMISSION_DELETE_ROTATOR_IMAGES,
            ),
            'sponsors' => array
            (
                MEMBER_PERMISSION_ADD_SPONSORS,
                MEMBER_PERMISSION_EDIT_SPONSORS,
                MEMBER_PERMISSION_PAUSE_SPONSORS,
                MEMBER_PERMISSION_DELETE_SPONSORS,
            ),
            'maintenance' => array
            (
                MEMBER_PERMISSION_VIEW_LOG
            ),
            'blog_posts' => array
            (
                MEMBER_PERMISSION_WRITE_BLOG_POSTS,
                MEMBER_PERMISSION_UNPUBLISH_BLOG_POSTS,
                MEMBER_PERMISSION_DELETE_BLOG_POSTS,
            ),
            'blog_comments' => array
            (
                MEMBER_PERMISSION_DISEMVOWEL_COMMENTS,
                MEMBER_PERMISSION_DELETE_COMMENTS,
                MEMBER_PERMISSION_MARK_COMMENT_SPAM
            )
        );

        // Load session variable into all views
        $session = $this->session->all_userdata();

        // Explode known ID arrays into native arrays
        $this->_explode(',', $session['committee_ids']);
        $this->_explode(',', $session['officer_ids']);
        $this->_explode(',', $session['permission_ids']);

        $this->load->vars(
            array(
                'session'     => $session,
                'permissions' => $permissions
            )
        );
    }

    public function _explode($delimiter, &$var)
    {
        $var = explode($delimiter, $var) ?: [];
    }

    public function _is_logged_in()
    {
        // Return if member ID exists
        $id = $this->session->userdata('member_id');
        return !empty($id);
    }

    public function _login_redirect($class = 'alert', $message = 'You must be logged in to view this page')
    {
        // Pass any class/message to generic flash message function
        $this->_msg_redirect('/members/login', $class, $message);
    }

    public function _msg_redirect($location, $class, $message)
    {
        $this->session->set_flashdata('class', $class);
        $this->session->set_flashdata('message', $message);
        redirect($location, 'location');
    }

    public function _log($action_id, $object_id, $level_id, $message, $object_instance = null, $data = null, $action_by = null)
    {
        // Load log model
        $this->load->model('log');

        // Get action performer ID
        if (empty($action_by)) $action_by = $this->session->userdata('member_id');

        // Force JSON encoding if object or array
        if (is_object($data) || is_array($data)) $data = stripslashes(json_encode($data));

        // Log entry and return ID
        $entry_id = $this->log->entry($action_id, $object_id, $level_id, $message, $action_by, $object_instance, $data);
        return $entry_id;
    }
}