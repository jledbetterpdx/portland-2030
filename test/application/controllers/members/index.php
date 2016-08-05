<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends PDX_Controller {

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
        $vars = array(
            'page' => array(
                'title' => 'Members Area'
            )
        );

        $this->load->vars($vars);

        $this->load->view('templates/members/header');
        $this->load->view('templates/members/debug');
        $this->load->view('templates/members/pages/index');
        $this->load->view('templates/members/footer');


    }

    public function add()
    {
        $vars = array(
            'page' => array(
                'title' => 'Add Event',
                'js'    => array(
                    '/assets/templates/members/js/event/add.js'
                )
            )
        );

        $this->load->vars($vars);

        $this->load->view('templates/members/header');
        $this->load->view('templates/members/pages/event/add');
        $this->load->view('templates/members/footer');
    }

    public function edit($id)
    {

    }

    public function remove($id)
    {

    }

    public function test($id)
    {
        $vars = array(
            'page' => array(
                'title' => 'Test ' . $id
            )
        );

        $this->load->vars($vars);

        $this->load->view('templates/members/header');
        $this->load->view('templates/members/debug');
        $this->load->view('templates/members/pages/index');
        $this->load->view('templates/members/footer');
    }
}