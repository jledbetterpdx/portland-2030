<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flockblog extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        show_404();
    }

    public function test()
    {
        $this->load->model('apps/blog');
        echo '<pre>' . PHP_EOL;
        var_dump($this->blog->getPostByID(1));
        echo '</pre>' . PHP_EOL;
    }

}

/* End of file flockblog.php */
/* Location: ./application/controllers/flockblog.php */