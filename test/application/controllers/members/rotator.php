<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rotator extends PDX_Controller {

    public function __construct()
    {
        parent::__construct();
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
        exit('No direct script access allowed');
    }

    public function add()
    {
        // Stub for adding rotator image
    }

    public function edit($id)
    {
        // Stub for editing rotator image
    }

    public function manage()
    {
        // Load image model
        $this->load->model('image');

        // Get images
        $images = array(
            'active'   => $this->image->get_active_rotator_images(),
            'archived' => $this->image->get_archived_rotator_images()
        );

        // Set up page variables
        $vars = array(
            'page' => array(
                'title' => 'Manage Rotator Images',
                'css'   => array(
                    '/assets/css/jquery.easytabs.css',
                    '/assets/css/jquery.tablesorter.css',
                    '/assets/css/jquery.featherlight.css',
                    '/assets/css/jquery.featherlight.gallery.css'
                ),
                'js'    => array(
                    '/assets/css/jquery.featherlight.css',
                    '/assets/css/jquery.featherlight.gallery.css',
                    '/assets/templates/members/js/rotator/manage.js'
                )
            ),
            'images' => $images
        );

        $this->load->vars($vars);

        $this->load->view('templates/members/header');
        $this->load->view('templates/members/pages/rotator/manage');
        $this->load->view('templates/members/footer');
    }
}