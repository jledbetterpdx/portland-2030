<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Photos extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
	{
		$vars = array('page' => array('title' => 'Photos'));
		
		$this->load->vars($vars);
		
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/header');
		//$this->load->view('templates/' . GLOBAL_TEMPLATE . '/pages/photos/index');
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/coming-soon');
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/footer');
	}
}

/* End of file photos.php */
/* Location: ./application/controllers/photos.php */