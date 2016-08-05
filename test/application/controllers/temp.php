<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Temp extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
	{
		$this->load->view('temp');
	}
	
	public function test()
	{
		$vars = array('page' => array('title' => 'Testing Title'));
		
		$this->load->vars($vars);
		
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/header');
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/index');
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/footer');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */