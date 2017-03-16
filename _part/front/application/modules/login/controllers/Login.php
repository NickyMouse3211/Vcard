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
		$this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|xss_clean|required');
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
                    $this->session->set_userdata('user_data', $result[0]);
                    $result[0]->vcard_id     = strEncryptcode($result[0]->vcard_id);
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
        } else{
        	$data['status'] = false;
            $data['msg']	= validation_errors();

            echo json_encode($data);
        }
	}

	public function register() {
        $this->form_validation->set_rules('link', 'Link', 'trim|xss_clean|required');
        $this->form_validation->set_rules('name', 'Name', 'trim|xss_clean|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|xss_clean|required');
        $this->form_validation->set_rules('c_password', 'Password Confirmation', 'trim|xss_clean|required');

        if ($this->form_validation->run($this) == TRUE) {
        	if ($this->input->post('password') == $this->input->post('c_password')) {
        		$data[$this->pref.'link'] 		= $this->input->post('link');
        		$data[$this->pref.'name'] 		= $this->input->post('name');
        		$data[$this->pref.'email'] 		= $this->input->post('email');

        		$result = $this->m_global->insert($this->table_db, $data);

                if( $result['status'] )
                {
                	newcode($this->db->insert_id(), $this->input->post('email'), $this->input->post('password'));
                    $data['status'] = true;
                    # sesuai in pesan message dengan aksi yang telah di proses, Nama atau variabel bisa di masukkin.
                    $data['msg'] = 'Successfully add vcard with Link <strong>'.$this->input->post('link').'</strong></strong>';
                    echo json_encode($data);
                } else {
                    # menghapus gambar yg udah di upload jika sql gagal,
                    # hapus jika tidak ada upload file

                    $data['status'] = false;
                    #ini sesuaiin juga
                    $data['msg'] = 'Failed add vcard with Link <strong>'.$this->input->post('link').'</strong></strong>';

                    echo json_encode($data);
                }
        	} else {
        		$data['status'] = false;
	            $data['msg']	= 'Password and Password Confirmation not match';

	            echo json_encode($data);
        	}
        } else{
        	$data['status'] = false;
            $data['msg']	= validation_errors();

            echo json_encode($data);
        }
	}

}
