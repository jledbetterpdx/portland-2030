<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
	{
		//$vars = array('page' => array('title' => 'Testing Title'));
		
		//$this->load->vars($vars);
		
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/header');
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/pages/main/index');
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/footer');
	}
    
    public function about()
    {
		$vars = array('page' => array('title' => 'About Us'));
		
		$this->load->vars($vars);
		
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/header');
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/pages/main/about');
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/footer');
    }
    
    public function join()
    {
		$vars = array('page' => array('title' => 'Join Us!'));
		
		$this->load->vars($vars);
		
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/header');
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/pages/main/join');
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/footer');
    }
    
    public function temp()
    {
		$vars = array('page' => array('title' => 'Page Coming Soon!'));
		
		$this->load->vars($vars);
		
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/header');
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/coming-soon');
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/footer');
    }
    
    public function donate()
    {
		$vars = array('page' => array('title' => 'Donate to Us'));

		$this->load->vars($vars);

		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/header');
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/pages/main/donate');
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/footer');
    }

    public function links()
    {
		$vars = array('page' => array('title' => 'Links'));

		$this->load->vars($vars);

		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/header');
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/pages/main/links');
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/footer');
    }

    public function contact()
    {
        $vars = array('page' => array('title' => 'Contact Us'));

        if ($this->form_validation->run('contact') == false)
        {
            // Set error delimiters
            // @todo Move to lang file once I determine a permanent error delimiter
            $this->form_validation->set_error_delimiters('<div class="error"><i class="fa fa-exclamation-triangle"></i>', '</div>');
        }
        else
        {
            // Load inquiry model
            $this->load->model('inquiry');

            // Initialize spam variable
            $is_spam = false;

            // Add success variable - tells page to display "success" message to visitor
            $vars['success'] = true;

            // Store POST vars locally
            $post = $this->input->post();

            // Back up POST vars in JSON
            $post['post_json'] = json_encode($post);

            // Determine if request is spam
            if (array_key_exists('email', $post) && !empty($post['email']))
            {
                // Set spam flag to true
                $is_spam = true;
            }
            else
            {
                // Drop dummy field and pass data to real 'email field
                $post['email'] = $post['liame'];
            }

            // Unset email field
            unset($post['liame']);

            // Add logging fields
            $post['sent']       = date('Y-m-d H:i:s');
            $post['ip_address'] = $this->input->ip_address();

            // Pass data to tables
            if ($is_spam)
            {
                // Log in spam table
                $this->inquiry->insert_spam($post);
            }
            else
            {
                // Log in new inquiry table
                $this->inquiry->insert_inquiry($post);

                // Build email message
                $email = $this->load->view('templates/system/email/new_inquiry_text', $post, true);

                // Build email headers
                $headers   = array();
                $headers[] = 'From: 20-30 PDX Automailer <webmaster@portland2030.org>';
                $headers[] = 'Reply-To: no-reply@portland2030.org';
                $headers   = implode("\r\n", $headers);
                #    $headers[] = 'X-Mailer: PHP/' . phpversion();
                #    $headers[] = 'MIME-Version: 1.0';
                #    $headers[] = 'Content-type: text/plain; charset=iso-8859-1';

                // Set subject
                $subject = '[20-30 PDX] New Inquiry from ' . $post['first_name'] . ' ' . $post['last_name'];

                // Send emails to necessary parties
                mail('webmaster@portland2030.org', $subject, $email, $headers);
                mail('president@portland2030.org', $subject, $email, $headers);
            }
        }

        $this->load->vars($vars);

        $this->load->view('templates/' . GLOBAL_TEMPLATE . '/header');
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/pages/main/contact');
		$this->load->view('templates/' . GLOBAL_TEMPLATE . '/footer');
    }

    public function info()
    {
        phpinfo();
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */