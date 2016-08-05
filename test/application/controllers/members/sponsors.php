<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sponsors extends PDX_Controller {

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

    public function rotator()
    {
        $vars = array(
            'page' => array(
                'title' => 'Manage Rotator Images',
                'js'    => array(
                    '/assets/templates/members/js/manage/rotator.js'
                )
            )
        );

        $this->load->vars($vars);

        $this->load->view('templates/members/header');
        $this->load->view('templates/members/pages/manage/rotator');
        $this->load->view('templates/members/footer');
    }

    public function sponsors()
    {
        // Stub for sponsor management
    }
}