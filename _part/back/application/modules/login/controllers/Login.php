<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MX_Controller {

    private $prefix         = 'Member';
    private $table_db       = 'member';
    private $table_prefix   = 'member_';

    function __construct() {
        parent::__construct();
    }

    public function index(){
        $data['pagetitle']  = 'Login Page';

        if (isset($_COOKIE['user_logged'])) {
            $user   = $_COOKIE['user_logged']['user'];
            $pass   = $_COOKIE['user_logged']['pass'];

            $password   = md5_mod($pass);
            $result     = $this->m_global->get_data_all($this->table_db, NULL, ['member_email' => $user, 'member_password' => $password]);
            if(!empty($result)){
                if ($result[0]->member_status == '1') {
                    $this->session->set_userdata('user_data', $result[0]);

                    redirect(base_url().'dashboard');
                } else {
                    $this->session->set_flashdata('status', '<div class="alert alert-danger"><strong>Error!</strong> Your account is not authorized for login.</div>');
                    redirect(base_url().'login');
                }
            }else{
                $this->session->set_flashdata('status', '<div class="alert alert-danger"><strong>Error!</strong> Wrong Username or Password.</div>');
                redirect(base_url().'login');
            }

        }

        $this->load->view('login/login', $data);
    }

    public function cek_login(){

        $this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|xss_clean|required');
        // echo "<pre>";
        // print_r ($this->input->post());
        // echo "</pre>".'<br/>'.$this->form_validation->run($this);exit();
        if ($this->form_validation->run($this) == TRUE){
            $email      = $this->input->post('email');

            // $salt= $this->m_global->get_data_all($this->table_db, NULL, ['member_email' => $email], 'member_salt')[0];
            
            $password   = strEncrypt($this->input->post('password'));

            $result = $this->m_global->get_data_all($this->table_db, NULL, ['member_email' => $email, 'member_password' => $password]);
            if(!empty($result)){
                if ($result[0]->member_status == '1') {
                    
                    $this->session->set_userdata('user_data', $result[0]);

                    $check = isset($_POST['remember'])?$_POST['remember']:'';
                    if ($check) {
                        setcookie('user_logged[user]', $this->input->post('email'), time() + 3600, "/");
                        setcookie('user_logged[pass]', $this->input->post('password'), time() + 3600, "/");
                    }

                    redirect(base_url().'dashboard');
                } else {
                    $this->session->set_flashdata('status', '<div class="alert alert-danger"><strong>Error!</strong> Your account is not authorized for login.</div>');
                    redirect(base_url().'login');
                }
            }else{
                $this->session->set_flashdata('status', '<div class="alert alert-danger"><strong>Error!</strong> Wrong Email or Password.</div>');
                redirect(base_url().'login');
            }
        }else{
            $this->session->set_flashdata('status', '<div class="alert alert-danger"><strong>Error!</strong> Field can not be empty.</div>');
            redirect(base_url().'login');
        }
    }

    function out(){
        $this->session->sess_destroy();

        if (isset($_COOKIE['user_logged'])) {
            setcookie('user_logged[user]', '', time() - 3600, '/');
            setcookie('user_logged[pass]', '', time() - 3600, '/');
        }

        redirect('login', 'refresh');
    }
}