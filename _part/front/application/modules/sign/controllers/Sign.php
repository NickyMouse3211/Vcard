<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sign extends CI_Controller {

	private $prefix         = 'master/schedule';

	public function __construct()
	{
		parent::__construct();
	}

	public function sign_in()
	{
		$email      	= $this->input->post('email');
		$password   	= $this->input->post('pass');

		$result = $this->m_global->get_data_all('member', NULL, ['member_email' => $email, 'member_password' => strencrypt($password)]);
		if(!empty($result) && $result[0]->member_status == '1'){
		    $this->session->set_userdata('user_data', $result[0]);

            setcookie('user_logged[user]', $this->input->post('email'), time() + 3600, "/");
            setcookie('user_logged[pass]', $this->input->post('password'), time() + 3600, "/");
		    echo '1';
		    exit();
		}else{
		    echo '0';
			exit();
		}
	}

	function sign_out(){
	    $this->session->sess_destroy();
	    if (isset($_COOKIE['user_logged'])) {
	        setcookie('user_logged[user]', '', time() - 3600, '/');
	        setcookie('user_logged[pass]', '', time() - 3600, '/');
	    }
	}

}

/* End of file sign.php */
/* Location: ./application/controllers/sign.php */