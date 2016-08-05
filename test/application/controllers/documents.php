<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Documents extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
	{
		$vars = array('page' => array('title' => 'Documents'));
		
		$this->load->vars($vars);
		
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/header');
		//$this->load->view('templates/' . GLOBAL_TEMPLATE . '/pages/documents/index');
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/coming-soon');
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/footer');
	}
    
    public function download($file)
    {
		$vars = array('page' => array('title' => 'Download Information'));
		
		$this->load->vars($vars);
		
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/header');
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/coming-soon');
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/footer');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */