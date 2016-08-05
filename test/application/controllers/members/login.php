<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends PDX_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    /*
    public function _remap($method, $params = array())
    {
        if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }
        show_404();
    }
    */

    public function index()
    {
        $vars = array(
            'page' => array(
                'title' => 'Login',
                'css'   => array(
                    '/assets/templates/members/css/login.css'
                ),
                'js'    => array(
                    '/assets/templates/members/js/login.js'
                ),
                'hide_menu' => true
            )
        );

        $this->load->vars($vars);

        $this->load->view('templates/members/header');
        $this->load->view('templates/members/login');
        $this->load->view('templates/members/footer');
    }

    public function logout()
    {
        // Destroy session variables
        $_vars = array(
            'member_id'      => '',
            'first_name'     => '',
            'status_id'      => '',
            'committee_ids'  => '',
            'officer_ids'   => '',
            'permission_ids' => ''
        );
        $this->session->unset_userdata($_vars);

        // Set flash data and redirect
        $this->_login_redirect('success', 'You have successfully logged out');
    }

    public function verify()
    {
        // Load admin model
        $this->load->model('admin');

        // Store POST variables locally
        $user = $this->input->post('username');
        $pass = $this->input->post('password');

        // Get user info
        $member = $this->admin->login__get_user($user);

        // Check username/encrypted password combo in database
        #$member = $this->admin->login__verify($user, md5($pass));

        // Validation checks
        if (empty($member) || !is_array($member))   // Member not found
        {
            // Set flash items and redirect
            $this->_login_redirect('warning', 'You provided an invalid username or password');
        }
        elseif (!empty($member['password_enc']) && !password_verify($pass, $member['password_enc']))    // If using encryption and invalid password
        {
            // Set flash items and redirect
            $this->_login_redirect('warning', 'You provided an invalid username or password');
        }
        // @todo Remove below after all passwords migrated
        elseif (!empty($member['password']) && md5($pass) !== $member['password'])  // If using legacy "encryption" and invalid password
        {
            // Set flash items and redirect
            $this->_login_redirect('warning', 'You provided an invalid username or password');
        }
        // @todo Remove above after all passwords migrated
        elseif (in_array($member['status_id'], array(MEMBER_STATUS_INACTIVE, MEMBER_STATUS_DELETED)))   // Inactive or deleted member
        {
            // Set flash items and redirect
            $this->_login_redirect('alert', 'This member account has been deactivated');
        }
        elseif (!empty($member['password_reset']))  // Password reset sent
        {
            // Set flash items and redirect
            $this->_login_redirect('info', 'You have requested a password reset, which was sent to your email address');
        }
        elseif (empty($member['password']) && empty($member['password_enc']) && empty($member['password_reset']))   // Uninitialized member account -- catchall
        {
            // Set flash items and redirect
            $this->_login_redirect('warning', 'You provided an invalid username or password');
        }

        // Update encrypted password if using legacy or if the algorithm is updated
        // Intended to wean members off of insecure MD5 hashes without them noticing
        if (empty($member['password_enc']) || password_needs_rehash($member['password_enc'], PASSWORD_DEFAULT))
        {
            // Generate new password hash
            $_pass = password_hash($pass, PASSWORD_DEFAULT);

            // Update member info
            $this->admin->member__update_password($member['member_id'], $_pass);
        }

        // Unset all password variables
        unset($member['password']);
        unset($member['password_enc']);
        unset($member['password_reset']);

        // Set session variables
        $this->session->set_userdata($member);

        // Redirect to main menu
        redirect('/members', 'location');
    }

    public function reset_password($code)
    {
        // Load admin model
        $this->load->model('admin');

        // Determine if code is valid
        if (!$this->admin->member__validate_reset_code($code))
        {
            // Send error message
            $this->_login_redirect('alert', 'You provided an invalid ID or pass code');
        }

        // Page variables
        $vars = array(
            'page' => array(
                'title' => 'Reset My Password',
                'css'   => array(
                    '/assets/templates/members/css/login.css'
                ),
                'js'    => array(
                    '/assets/templates/members/js/reset_password.js'
                ),
                'hide_menu' => true
            ),
            'code' => $code
        );

        // Load page variables into all views
        $this->load->vars($vars);

        // Load views
        $this->load->view('templates/members/header');
        $this->load->view('templates/members/reset_password');
        $this->load->view('templates/members/footer');
    }

    public function forgot_password()
    {
        $vars = array(
            'page' => array(
                'title' => 'Forgot My Password',
                'css'   => array(
                    '/assets/templates/members/css/login.css'
                ),
                'js'    => array(
                    '/assets/templates/members/js/forgot_password.js'
                ),
                'hide_menu' => true
            )
        );

        $this->load->vars($vars);

        $this->load->view('templates/members/header');
        $this->load->view('templates/members/forgot_password');
        $this->load->view('templates/members/footer');
    }

    public function send_password_link()
    {
        // Load member model
        $this->load->model('admin');

        // Get username
        $username = $this->input->post('username');

        // Redirect if no member found
        if (false === ($member = $this->admin->member__get_info_by_username($username)))
        {
            $this->_msg_redirect('/members/login/forgot_password', 'alert', 'We could not find a member account with that username');
        }

        // Update user's password reset code and prepare data array for email
        $data = array(
            'code' => $this->admin->member__set_password_reset_code($member['id'])
        );

        // Build email message
        $email = $this->load->view('templates/system/email/password_reset_link', $data, true);

        // Build email headers
        $headers   = array();
        $headers[] = 'From: 20-30 PDX Automailer <webmaster@portland2030.org>';
        $headers[] = 'Reply-To: webmaster@portland2030.org';
        $headers   = implode("\r\n", $headers);
        #    $headers[] = 'X-Mailer: PHP/' . phpversion();
        #    $headers[] = 'MIME-Version: 1.0';
        #    $headers[] = 'Content-type: text/plain; charset=iso-8859-1';

        // Set subject
        $subject = '[20-30 PDX] Password Reset Request for ' . $member['first_name'] . ' ' . $member['last_name'];

        // Send emails to necessary parties
        #mail('webmaster@portland2030.org', $subject, $email, $headers);    // For debugging purposes
        mail($member['email'], $subject, $email, $headers);

        // Redirect to main login page
        $this->_login_redirect('success', 'You have successfully sent a password reset request to your email address');
    }

    function verify_password_reset()
    {
        // Load admin model
        $this->load->model('admin');

        // Store local variables
        $username = $this->input->post('username');
        $code     = $this->input->post('reset_code');
        $password = $this->input->post('password');
        $confirm  = $this->input->post('password_confirm');

        // Auditing
        $data = array(
            'username'   => $username,
            'reset_code' => $code
        );

        // Empty check
        //@todo Refactor out when upgrading to PHP7
        $_password = trim($password);
        $_confirm  = trim($confirm);

        // Redirect if either field is empty
        if (empty($_password) || empty($_confirm))
        {
            $this->_log(LOG_ACTION_RESET, LOG_OBJECT_PASSWORD, LOG_LEVEL_ALERT, 'An invalid password was provided', null, $data);
            $this->_msg_redirect('/members/login', 'alert', 'One of your password fields was blank');
        }

        // Redirect if passwords don't match
        if ($password !== $confirm)
        {
            $this->_log(LOG_ACTION_RESET, LOG_OBJECT_PASSWORD, LOG_LEVEL_ALERT, 'An invalid password was provided', null, $data);
            $this->_msg_redirect('/members/login', 'alert', 'You provided passwords that don\'t match.');
        }

        // Redirect if no member found
        if (false === ($member = $this->admin->member__get_info_by_username($username)))
        {
            $this->_log(LOG_ACTION_RESET, LOG_OBJECT_PASSWORD, LOG_LEVEL_ALERT, 'An invalid username was provided', null, $data);
            $this->_msg_redirect('/members/login', 'alert', 'We could not find a member account with that username');
        }

        // Redirect if reset codes don't match
        if ($code !== $member['password_reset'])
        {
            $this->_log(LOG_ACTION_RESET, LOG_OBJECT_PASSWORD, LOG_LEVEL_ALERT, 'An invalid password reset code was provided', $member['id'], $data, $member['id']);
            $this->_msg_redirect('/members/login', 'alert', 'You provided an invalid password reset code');
        }

        // Reset password
        $this->admin->member__update_password($member['id'], password_hash($password, PASSWORD_DEFAULT));

        // Log the reset
        $message = $member['first_name'] . ' ' . $member['last_name'] . ' successfully reset their password';
        $this->_log(LOG_ACTION_RESET, LOG_OBJECT_PASSWORD, LOG_LEVEL_SUCCESS, $message, $member['id'], $data, $member['id']);

        // Redirect to main login page with success message
        $this->_msg_redirect('/members/login', 'success', 'You have successfully reset your password');
    }
}