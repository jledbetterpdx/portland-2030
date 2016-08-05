<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flockblog extends PDX_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load blog model
        $this->load->model('apps/blog');
    }

    public function _remap($method, $params = array())
    {
        // Login check
        if (!$this->_is_logged_in()) $this->_login_redirect();

        if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }
        show_404();
    }

    public function index()
    {
        // Get events
        $event_types = array('upcoming', 'past', 'tentative', 'cancelled');
        $events      = array();

        foreach ($event_types as $event_type)
        {
            $events[$event_type] = $this->event->get_events_by_type($event_type);
        }

        // Load page variables
        $vars = array(
            'page' => array(
                'title' => 'Event List',
                'css'   => array(
                    '/assets/css/jquery.easytabs.css',
                    '/assets/css/jquery.tablesorter.css'
                ),
                'js'    => array(
                    '/assets/js/jquery.easytabs.min.js',
                    '/assets/js/jquery.tablesorter.min.js',
                    '/assets/templates/members/js/events/index.js'
                )
            ),
            'events' => $events
        );
        //
        $this->load->vars($vars);

        $this->load->view('templates/members/header');
        $this->load->view('templates/members/debug');
        $this->load->view('templates/members/pages/events/index');
        $this->load->view('templates/members/footer');
    }

    public function write()
    {
        $this->_writeedit('write');
    }

    public function edit($id)
    {
        $this->_writeedit('edit', $id);
    }

    public function _writeedit($action, $post_id = null)
    {
        // Load page variables
        $vars = array(
            'page' => array(
                'css'   => array(
                    '/assets/css/jquery.redactor.css',
                    '/assets/templates/members/css/blog/writeedit.css'
                ),
                'js'    => array(
                    '/assets/js/jquery.redactor.min.js',
                    '/assets/templates/members/js/blog/writeedit.js'
                )
            ),
            'post'          => false,
            'visibilities'  => $this->blog->getVisibilities(),
            'statuses'      => $this->blog->getStatuses(),
            'action'        => $action
        );

        // Setup temporary and page variables based on type
        switch ($action)
        {
            case 'edit':
                // Temporary variables
                $_log_action = LOG_ACTION_EDIT;
                $_verb       = 'edited';

                // Set page variables
                $vars['page']['title'] = 'Edit Post';
                $vars['page']['icon']  = 'pencil';

                // Get event data
                $vars['event'] = $this->blog->getPostByID($post_id);

                break;
            case 'write':
            default:
                // Temporary variables
                $_log_action = LOG_ACTION_ADD;
                $_verb       = 'added';

                // Set page variables
                $vars['page']['title'] = 'Write New Post';
                $vars['page']['icon']  = 'plus';

                break;
        }

        // Initialize temporary success variable
        $_success = null;

        /*
        // Form validation
        if ($this->form_validation->run('add_edit_event') == false)
        {
            // Set error delimiters
            // @todo Move to lang file once I determine a permanent error delimiter
            $this->form_validation->set_error_delimiters('<div class="error"><i class="fa fa-exclamation-triangle"></i>', '</div>');

            // Store temporary success variable as failure if post is not false
            if ($this->input->post() !== false) $_success = false;
        }
        else
        {
            // Load admin model
            $this->load->model('admin');

            // Store POST vars locally
            $post = $this->input->post();

            // Store temporary success variable as success
            $_success = true;

            // Perform different database actions based on type
            switch ($action)
            {
                case 'edit':
                    // Edit event in calendar
                    $this->admin->event__edit_event($post, $event_id);

                    // Update event data
                    $vars['event'] = $this->event->get_event_by_id($event_id, true);
                    break;
                case 'add':
                default:
                    // Add event to calendar (overwrites null $event_id value)
                    $event_id = $this->admin->event__add_event($post);

                    break;
            }

            // Log adding event
            $this->_log($_log_action, LOG_OBJECT_EVENT, LOG_LEVEL_SUCCESS, 'Event #' . $event_id . ' (' . $post['name'] . ') was successfully ' . $_verb . '.', $event_id, $post);
        }
        */

        // Add success variable - tells page to display "success" message to visitor
        $vars['success'] = $_success;

        $this->load->vars($vars);

        $this->load->view('templates/members/header');
        $this->load->view('templates/members/debug');
        $this->load->view('templates/members/pages/blog/writeedit');
        $this->load->view('templates/members/footer');
    }

    public function test($id)
    {
        $this->load->model('');
    }

    public function cancel()
    {
        // Load admin model
        $this->load->model('admin');

        // Get POST variables
        $post = $this->input->post();

        // Store individual values
        $id     = $post['id'];
        $reason = $post['reason'];

        // Verify if ID is present
        if (empty($id))
        {
            $this->_log(LOG_ACTION_CANCEL, LOG_OBJECT_EVENT, LOG_LEVEL_ALERT, 'No ID provided for cancellation', null, $post);
            $this->_msg_redirect('/members/events', 'alert', 'You provided an invalid ID or reason for cancellation');
        }

        // Verify if reason is present
        if (empty($reason))
        {
            $this->_log(LOG_ACTION_CANCEL, LOG_OBJECT_EVENT, LOG_LEVEL_ALERT, 'No reason provided for cancellation', $id, $post);
            $this->_msg_redirect('/members/events', 'alert', 'You provided an invalid ID or reason for cancellation');
        }

        // Verify if event exists
        if (false === ($event = $this->event->get_event_by_id($id, false)))
        {
            $this->_log(LOG_ACTION_CANCEL, LOG_OBJECT_EVENT, LOG_LEVEL_ALERT, 'Event #' . $id . ' cannot be cancelled because it does not exist', $id, $post);
            $this->_msg_redirect('/members/events', 'alert', 'The event you attempted to cancel doesn\'t exist');
        }

        // Make the call to delete the record from the database
        $this->admin->event__cancel_event($id);

        // Add reason to event data for logging purposes
        $event['reason'] = $reason;

        // Log cancellation event
        $this->_log(LOG_ACTION_CANCEL, LOG_OBJECT_EVENT, LOG_LEVEL_SUCCESS, 'Event #' . $id . ' was successfully cancelled: ' . $reason, $id, $event);

        // Redirect to events list with success message
        $this->_msg_redirect('/members/events', 'success', 'You have successfully cancelled "' . $event['name'] . '"');
    }

    public function uncancel()
    {
        // Load admin model
        $this->load->model('admin');

        // Get POST variables
        $post = $this->input->post();

        // Store individual values
        $id     = $post['id'];
        $reason = $post['reason'];

        // Verify if ID is present
        if (empty($id))
        {
            $this->_log(LOG_ACTION_UNCANCEL, LOG_OBJECT_EVENT, LOG_LEVEL_ALERT, 'No ID provided for uncancellation', null, $post);
            $this->_msg_redirect('/members/events', 'alert', 'You provided an invalid ID or reason for uncancellation');
        }

        // Verify if reason is present
        if (empty($reason))
        {
            $this->_log(LOG_ACTION_UNCANCEL, LOG_OBJECT_EVENT, LOG_LEVEL_ALERT, 'No reason provided for uncancellation', $id, $post);
            $this->_msg_redirect('/members/events', 'alert', 'You provided an invalid ID or reason for uncancellation');
        }

        // Verify if event exists
        if (false === ($event = $this->event->get_event_by_id($id, false)))
        {
            $this->_log(LOG_ACTION_UNCANCEL, LOG_OBJECT_EVENT, LOG_LEVEL_ALERT, 'Event #' . $id . ' cannot be uncancelled because it does not exist', $id, $post);
            $this->_msg_redirect('/members/events', 'alert', 'The event you attempted to uncancel doesn\'t exist');
        }

        // Make the call to delete the record from the database
        $this->admin->event__uncancel_event($id);

        // Add reason to event data for logging purposes
        $event['reason'] = $reason;

        // Log cancellation event
        $this->_log(LOG_ACTION_UNCANCEL, LOG_OBJECT_EVENT, LOG_LEVEL_SUCCESS, 'Event #' . $id . ' was successfully uncancelled: ' . $reason, $id, $event);

        // Redirect to events list with success message
        $this->_msg_redirect('/members/events', 'success', 'You have successfully uncancelled "' . $event['name'] . '"');
    }

    public function delete()
    {
        // Load admin model
        $this->load->model('admin');

        // Get POST variables
        $post = $this->input->post();

        // Store individual values
        $id     = $post['id'];
        $reason = $post['reason'];

        // Verify if ID is present
        if (empty($id))
        {
            $this->_log(LOG_ACTION_DELETE, LOG_OBJECT_EVENT, LOG_LEVEL_ALERT, 'No ID provided for deletion', null, $post);
            $this->_msg_redirect('/members/events', 'alert', 'You provided an invalid ID or reason for deletion');
        }

        // Verify if reason is present
        if (empty($reason))
        {
            $this->_log(LOG_ACTION_DELETE, LOG_OBJECT_EVENT, LOG_LEVEL_ALERT, 'No reason provided for deletion', $id, $post);
            $this->_msg_redirect('/members/events', 'alert', 'You provided an invalid ID or reason for deletion');
        }

        // Verify if event exists
        if (false === ($event = $this->event->get_event_by_id($id, false)))
        {
            $this->_log(LOG_ACTION_DELETE, LOG_OBJECT_EVENT, LOG_LEVEL_ALERT, 'Event #' . $id . ' cannot be deleted because it does not exist', $id, $post);
            $this->_msg_redirect('/members/events', 'alert', 'The event you attempted to delete doesn\'t exist');
        }

        // Make the call to delete the record from the database
        $this->admin->event__delete_event($id);

        // Add reason to event data for logging purposes
        $event['reason'] = $reason;

        // Log deletion event
        $this->_log(LOG_ACTION_DELETE, LOG_OBJECT_EVENT, LOG_LEVEL_SUCCESS, 'Event #' . $id . ' was successfully deleted: ' . $reason, $id, $event);

        // Redirect to events list with success message
        $this->_msg_redirect('/members/events', 'success', 'You have successfully deleted "' . $event['name'] . '" from the database');
    }

    public function info($id)
    {
        // Get event data
        $event = $this->event->get_event_by_id($id);

        // Output test data
        echo '<p>Info page coming soon, raw data below</p>';
        echo '<pre>';
        var_dump($event);
        echo '<pre>';
    }
}
