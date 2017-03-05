<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    private $title                        = 'Vcard';
    private $prefix                       = 'Vcard';
    private $table_db                     = 'vcard';
    private $table_prefix                 = 'vcard.';
    private $pref                         = 'vcard_';

	public function index($param='') {
		$this->template->display(strtolower(__CLASS__));
	}

	public function act_login() {
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        // echo "<pre>";
        // print_r ($this->input->post());
        // echo "</pre>".'<br/>'.$this->form_validation->run($this);exit();
        if ($this->form_validation->run($this) == TRUE){
            $email      = $this->input->post('email');

            // $salt= $this->m_global->get_data_all($this->table_db, NULL, ['vcard_email' => $email], 'vcard_salt')[0];
            $code     = cekCode($email);
            if (!$code) {
            	$data['status'] = false;
                $data['msg']	= 'Email Not Found';

                echo json_encode($data);
                exit();
            }
            $password = strEncrypt($this->input->post('password').$code);

            $result = $this->m_global->get_data_all($this->table_db, NULL, ['vcard_email' => $email, 'vcard_password' => $password]);
            if(!empty($result)){
                if ($result[0]->vcard_status == '1') {
                    $this->session->set_userdata('user_code', $code);
                    $result[0]->vcard_id = strEncryptcode($result[0]->vcard_id);
                    $this->session->set_userdata('user_data', $result[0]);

                    $check = isset($_POST['remember'])?$_POST['remember']:'';
                    if ($check) {
                        setcookie('user_logged[user]', $this->input->post('email'), time() + 3600, "/");
                        setcookie('user_logged[pass]', $this->input->post('password'), time() + 3600, "/");
                    }
                    changecode($email);
                    
                    $data['status'] = true;
                    $data['msg']	= 'Successfully Login User';

                    echo json_encode($data);

                    // redirect(base_url().'vcard');
                } else {
                    $data['status'] = false;
                    $data['msg']	= 'Your account is not authorized for login';

                    echo json_encode($data);
                }
            }else{
                $data['status'] = false;
                $data['msg']	= 'Wrong Email or Password';

                echo json_encode($data);
            }
        }else{
        	$data['status'] = false;
            $data['msg']	= validation_errors();

            echo json_encode($data);
        }
	}

}
