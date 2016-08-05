<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class http404 extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
	{
        // Set header to 404
        $this->output->set_status_header('404');

        $vars = array(
            'page' => array(
                'title' => 'Page Not Found'
            )
        );

        // Load variables
        $this->load->vars($vars);

        // Set template
        $_template = GLOBAL_TEMPLATE;
        if ($this->uri->segment(1) == 'members') $_template = 'members';    // Special members area template

        // Load templates
        $this->load->view('templates/' . $_template . '/header');
        $this->load->view('templates/' . $_template . '/404');
        $this->load->view('templates/' . $_template . '/footer');
	}
}

/* End of file http404.php */
/* Location: ./application/controllers/http404.php */