<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vcard extends MX_Controller {

    private $prefix            = 'vcard';
    private $table_db          = 'vcard';
    private $table_prefix      = 'vcard_';
    private $pagetitle         = 'Vcard';
    
    private $table_db_role     = 'role';
    private $table_prefix_role = 'role_';
    private $rule_valid        = 'xss_clean|encode_php_tags';

	function __construct() {
        parent::__construct();

    }

    /* START vcard Core Controller */

    public function index()
    {   
        $data['pagetitle']  = $this->pagetitle;
        $data['instance']   = $this->prefix;

        # link breadcrumb bisa kosong, jika kosong cuman tampil text 
        $data['breadcrumb'] = ['vcard' => $this->prefix];

        # kalo js emang ga kepake, hapus ya. folder: \assets\admin\pages\scripts
        $js['custom']       = ['table-ajax','upload'];

        $this->template->display($this->prefix, $data, $js);
    }

    # pake prefix 'show_' untuk menampilin halaman yang masih dalam 1 controller
    public function show_add()
    {
        # csrf masih banyak bug, sering tidak cocok. kalo ada yg bisa revisi, kasih tau developernya bro :D
        csrf_init();

        $data['pagetitle']  = $this->pagetitle;
        $data['instance']   = $this->prefix;
        $data['url']        = $this->prefix.'/show_add';
        $data['breadcrumb'] = ['vcard' => $this->prefix, 'Add' => $this->prefix.'/show_add'];
        $js['custom']       = ['form-validation'];

        $this->template->display($this->prefix.'_add', $data, $js);
    }

    public function show_edit($id)
    {
        csrf_init();

        $data['pagetitle']  = $this->pagetitle;
        $data['instance']   = $this->prefix;
        $data['url']        = $this->prefix.'/show_edit/'.$id;
        $data['breadcrumb'] = ['vcard' => $this->prefix, 'Edit' => $this->prefix.'/show_edit/'.$id];
        $js['custom']       = ['form-validation'];

        $data['id']         = $id;
        # id dalam bentuk encript, lihat di cdn_helper strEncrypt()
        $data['records']    = $this->m_global->get_data_all($this->table_db, NULL, [strEncrypt('vcard_id', TRUE) => $id])[0];
        $this->template->display($this->prefix.'_edit', $data, $js);
    }

    public function show_detail($id)
    {
        csrf_init();

        $data['pagetitle']  = $this->pagetitle;
        $data['instance']   = $this->prefix;
        $data['url']        = $this->prefix.'/show_edit/'.$id;
        $data['breadcrumb'] = ['vcard' => $this->prefix, 'Detail' => $this->prefix.'/show_detail/'.$id];
        $js['custom']       = ['form-validation'];

        $data['id']         = $id;
        # id dalam bentuk encript, lihat di cdn_helper strEncrypt()
        $data['records']    = $this->m_global->get_data_all($this->table_db, NULL, [strEncrypt('vcard_id', TRUE) => $id])[0];
        $this->template->display($this->prefix.'_detail', $data, $js);
    }

    public function action_add()
    {
        $input['ex_csrf_token'] = @$this->input->post('ex_csrf_token');

        # ini jika ada upload file di form add, kalo ga ada, hapus coy
        $config['upload_path'] = './public/images/vcard/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '1024';
        #ini juga ni
        $this->load->library('upload', $config);

        if ( csrf_get_token() != $input['ex_csrf_token']){
            $data['status'] = 2;
            $data['message'] = 'For security reason, we can\'t proccess your action!';

            echo json_encode($data);
        } else {
            $this->form_validation->set_rules('vcard_email', 'Email', 'required|valid_email|callback_check_email[]');
            $this->form_validation->set_rules('vcard_name', 'Name', 'trim|xss_clean|required');
            $this->form_validation->set_rules('vcard_password', 'vcard Password', 'trim|xss_clean|required');
            $this->form_validation->set_rules('vcard_role', 'Periode To', 'trim|xss_clean|required');
            $this->form_validation->set_message('check_email','The Email field must contain a unique value.');

            if ( $this->form_validation->run($this) )
            {

                    $data[$this->table_prefix.'name']        = $this->input->post('vcard_name');
                    $data[$this->table_prefix.'password']    = strEncrypt($this->input->post('vcard_password'));
                    $data[$this->table_prefix.'email']       = $this->input->post('vcard_email');
                    $data[$this->table_prefix.'role']        = $this->input->post('vcard_role');
                    $data[$this->table_prefix.'status']      = '1';
                    $data[$this->table_prefix.'insert_date'] = date('Y-m-d H:i:s');
                    $data[$this->table_prefix.'insert_id']   = $this->session->userdata('user_data')->vcard_id;
                    // $data[$this->table_prefix.'vcard_id']            = $this->vcarddata->vcard_id;

                    $result = $this->m_global->insert($this->table_db, $data);

                    if( $result['status'] )
                    {
                        $data['status'] = 1;
                        # sesuai in pesan message dengan aksi yang telah di proses, Nama atau variabel bisa di masukkin.
                        $data['message'] = 'Successfully add vcard with Nama <strong>'.$this->input->post('vcard_name').'</strong></strong>';
                        echo json_encode($data);
                    } else {
                        # menghapus gambar yg udah di upload jika sql gagal,
                        # hapus jika tidak ada upload file

                        $data['status'] = 0;
                        #ini sesuaiin juga
                        $data['message'] = 'Failed add vcard with Nama <strong>'.$this->input->post('vcard_name').'</strong></strong>';

                        echo json_encode($data);
                    }
            } else {
                $data['status']     = 3;
                $str                = ['<p>', '</p>'];
                $str_replace        = ['<li>', '</li>'];
                $data['message']    = str_replace($str, $str_replace, validation_errors());

                echo json_encode($data);
            }
            // echo validation_errors();
        }
    }

    public function action_edit($id)
    {
        $input['ex_csrf_token'] = @$this->input->post('ex_csrf_token');

        if (csrf_get_token() != $input['ex_csrf_token']){
            $data['status'] = 2;
            $data['message'] = 'For security reason, we can\'t proccess your action!';

            echo json_encode($data);
        } else {
            $this->form_validation->set_rules('vcard_email'        , 'Email'           , 'trim|xss_clean|required|callback_check_email['.$id.']');
            $this->form_validation->set_rules('vcard_name'         , 'Name'            , 'trim|xss_clean|required');
            $this->form_validation->set_rules('vcard_nick_name'    , 'Nick Name'       , 'trim|xss_clean|required');
            $this->form_validation->set_rules('vcard_tempat_lahir' , 'Place of Birth'  , 'trim|xss_clean|required');
            $this->form_validation->set_rules('vcard_tanggal_lahir', 'Date of Birth'   , 'trim|xss_clean|required');
            $this->form_validation->set_rules('vcard_alamat'       , 'Address'         , 'trim|xss_clean');
            $this->form_validation->set_rules('vcard_sign'         , 'Sign'            , 'trim|xss_clean');
            $this->form_validation->set_rules('vcard_phone'      , 'Phone'           , 'trim|xss_clean');
            $this->form_validation->set_rules('vcard_guild_name'   , 'Guild Name'      , 'trim|xss_clean');
            $this->form_validation->set_rules('vcard_couple'       , 'Couple Nick Name', 'trim|xss_clean');
            $this->form_validation->set_rules('vcard_password'     , 'vcard Password' , 'trim|xss_clean');
            $this->form_validation->set_rules('pu_foto'             , 'Picture'         , 'trim|xss_clean');
            $this->form_validation->set_rules('vcard_role'         , 'Role'            , 'trim|xss_clean|required');
            $this->form_validation->set_message('check_email'       ,'The Email field must contain a unique value.');

            if ($this->form_validation->run($this))
            {

                // # Jika ada file yang diupload
                if(!empty($_FILES)){
                    $config['upload_path']   = '../public/images/vcard/';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config['max_size']      = '1024';

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('pu_foto')){
                        $data['status'] = 0;
                        $data['message'] = 'File must be Image and max size 1024Kb';
                        echo json_encode($data);
                        die();
                    }else{
                        $re                               = $this->m_global->get_data_all($this->table_db, NULL, [strEncrypt($this->table_prefix.'id', TRUE) => $id], $this->table_prefix.'pict')[0];
                        $upload                           = $this->upload->data();
                        $data[$this->table_prefix.'pict'] = $upload['file_name'];
                    }
                } // end IF !empty($_FILES

                $data[$this->table_prefix.'email']              = $this->input->post('vcard_email');
                $data[$this->table_prefix.'name']               = $this->input->post('vcard_name');
                $data[$this->table_prefix.'nick_name']          = $this->input->post('vcard_nick_name');
                $data[$this->table_prefix.'tempat_lahir']       = $this->input->post('vcard_tempat_lahir');
                $data[$this->table_prefix.'tanggal_lahir']      = date('Y-m-d', strtotime($this->input->post('vcard_tanggal_lahir')));
                $data[$this->table_prefix.'alamat']             = $this->input->post('vcard_alamat');
                $data[$this->table_prefix.'sign']               = $this->input->post('vcard_sign');
                $data[$this->table_prefix.'phone']     = $this->input->post('vcard_phone');
                $data[$this->table_prefix.'guild_name']         = $this->input->post('vcard_guild_name');
                $data[$this->table_prefix.'couple']             = $this->input->post('vcard_couple');
                $data[$this->table_prefix.'role']               = $this->input->post('vcard_role');
                $data[$this->table_prefix.'update_date']        = date('Y-m-d H:i:s');
                $data[$this->table_prefix.'update_id']          = $this->session->userdata('user_data')->vcard_id;
                # jika kosong tidak dirubah
                if($this->input->post('vcard_password') != ''){
                    $data[$this->table_prefix.'password']           = strEncrypt($this->input->post('vcard_password'));
                }

                $result = $this->m_global->update($this->table_db, $data, [strEncrypt('vcard_id', TRUE) => $id]);

                if( $result )
                {
                    if(isset($re->vcard_pict)){
                        unlink('../public/images/vcard/'.$re->vcard_pict);
                    }
                    $data['status'] = 1;
                    $data['message'] = 'Successfully edit vcard with Nama <strong>'.$this->input->post('vcard_name').'</strong></strong>';

                    echo json_encode($data);

                } else {
                    if(!empty($_FILES))
                    {
                        unlink('../public/images/vcard/'.$re->vcard_foto);
                    }

                    $data['status'] = 0;
                    $data['message'] = 'Failed edit vcard with Nama <strong>'.$this->input->post('vcard_name').'</strong></strong>';
                    echo json_encode($data);
                }
            } else {
                $data['status'] = 3;
                $str                = ['<p>', '</p>'];
                $str_replace        = ['<li>', '</li>'];
                $data['message']    = str_replace($str, $str_replace, validation_errors());
                echo json_encode($data);
            }
        }
    }
    // validasi
    public function check_email($str, $id){
        if ($id != '') {
            $result = $this->m_global->validation($this->table_db, [strEncrypt($this->table_prefix.'id', TRUE).' <>' => $id, $this->table_prefix.'email' => $str]);
        }else{
            $result = $this->m_global->validation($this->table_db, [$this->table_prefix.'email' => $str]);
        }
        
        return $result;
    }
    // end validasi
    public function select()
    {   
        if(@$_REQUEST['customActionType'] == 'group_action'){
            $aChk = [0, 1, 99];
            if(in_array(@$_REQUEST['customActionName'], $aChk)){
                $this->change_status($_REQUEST['customActionName'], [strEncrypt($this->table_prefix.'id', true).' IN ' => "('".implode("','", $_REQUEST['id'] )."')"]);
            }
        }

        $aCari = [
            'name'          => $this->table_prefix.'name',
            'email'         => $this->table_prefix.'email',
            'phone'         => $this->table_prefix.'phone',
            'role'          => $this->table_prefix.'role',
            'status'        => $this->table_prefix.'status',
            'update_date'   => $this->table_prefix.'update_date'
        ];

        # 'where' buat where yang pake =, standar lah
        $where      = NULL;
        # where_e untuk where yang kosongan alias ga ada nambah escape (otomastis), =. 
        # bisa di bedain dengan where bentuk array, kalo ini text asli langsung masuk ke sql
        $where_e    = NULL;
        $where[$this->table_prefix.'status !='] = '99';
        if(@$_REQUEST['action'] == 'filter')
        {
            $where = [];
            foreach ($aCari as $key => $value) {
                if($_REQUEST[$key] != '')
                {
                    if($key == 'update_date'){
                        $tmp = explode(' - ', $_REQUEST[$key]);
                        $where_e = "DATE(vcard_update_date) BETWEEN '".$this->db->escape_str($tmp[0])."' AND '".$this->db->escape_str($tmp[1])."'";
                    } else {
                        $where[$value.' LIKE '] = '%'.$_REQUEST[$key].'%';
                    }
                }
            }
        }

        $keys = array_keys($aCari);
        @$order = [$aCari[$keys[($_REQUEST['order'][0]['column']-2)]], $_REQUEST['order'][0]['dir']];

        $iTotalRecords  = $this->m_global->count_data_all($this->table_db, NULL, $where, $where_e);
        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
        $iDisplayStart  = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $records = array();
        $records["data"] = array(); 

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        $select = 'vcard_id, vcard_status,'.implode(',' , $aCari);
        $result = $this->m_global->get_data_all($this->table_db, NULL, $where, $select, $where_e, $order, $iDisplayStart, $iDisplayLength);
        
        $selectrole = 'role_id, role_nama';
        $role =  $this->m_global->get_data_all($this->table_db_role, NULL, NULL, $selectrole);
        $roles = [];
        foreach ($role as $key) {
            $roles[$key->role_id] = $key->role_nama;
        }
        //echo $this->db->last_query();
        $i = 1 + $iDisplayStart;
        foreach ($result as $rows) {
            if ($this->session->userdata('user_data')->vcard_role == '1') {
                $action =   '<a data-original-title="Change Status vcard" href="'.base_url( $this->prefix.'/change_status_by/'.strEncrypt($rows->vcard_id).'/'.($rows->vcard_status == 1 ? '0' : '1' ) ).'" class="tooltips btn-icon-only btn btn-sm '.($rows->vcard_status == 0 ? 'grey-cascade' : ($rows->vcard_status == 99 ? 'red-sunglo' : 'green-meadow')). '" onClick="return f_status(1, this, event)"><i title="'.($rows->vcard_status == 0 ? 'InActive' : ($rows->vcard_status == 99 ? 'Deleted' : 'Active') ).'" class="fa fa'.($rows->vcard_status == 0 ? '-eye-slash' : ($rows->vcard_status == 99 ? '-trash-o' : '-eye') ).'"></i></a> '.
                            '<a data-original-title="Edit vcard Data" href="'.base_url( $this->prefix.'/show_edit/'.strEncrypt($rows->vcard_id) ).'" class="btn btn-icon-only btn-sm blue-madison ajaxify tooltips"><i class="fa fa-edit"></i></a> '.
                            '<a data-original-title="Detail vcard Data" href="'.base_url( $this->prefix.'/show_detail/'.strEncrypt($rows->vcard_id) ).'" class="btn btn-icon-only btn-sm yellow ajaxify tooltips"><i class="fa fa-search"></i></a> '.
                            '<a data-original-title="Delete vcard Data" href="'.base_url( $this->prefix.'/change_status_by/'.strEncrypt($rows->vcard_id).'/99/'.($rows->vcard_status == 99 ? '/true' : '' )).'" class="btn btn-icon-only btn-sm red-sunglo tooltips" onClick="return f_status(2, this, event)"><i class="fa fa-times"></i></a>';
            }elseif ($this->session->userdata('user_data')->vcard_role != '1') {
                if ($rows->vcard_role > $this->session->userdata('user_data')->vcard_role || $this->session->userdata('user_data')->vcard_id == $rows->vcard_id) {
                    $action =   '<a data-original-title="Change Status vcard" href="'.base_url( $this->prefix.'/change_status_by/'.strEncrypt($rows->vcard_id).'/'.($rows->vcard_status == 1 ? '0' : '1' ) ).'" class="tooltips btn-icon-only btn btn-sm '.($rows->vcard_status == 0 ? 'grey-cascade' : ($rows->vcard_status == 99 ? 'red-sunglo' : 'green-meadow')). '" onClick="return f_status(1, this, event)"><i title="'.($rows->vcard_status == 0 ? 'InActive' : ($rows->vcard_status == 99 ? 'Deleted' : 'Active') ).'" class="fa fa'.($rows->vcard_status == 0 ? '-eye-slash' : ($rows->vcard_status == 99 ? '-trash-o' : '-eye') ).'"></i></a> '.
                                '<a data-original-title="Edit vcard Data" href="'.base_url( $this->prefix.'/show_edit/'.strEncrypt($rows->vcard_id) ).'" class="btn btn-icon-only btn-sm blue-madison ajaxify tooltips"><i class="fa fa-edit"></i></a> '.
                                '<a data-original-title="Detail vcard Data" href="'.base_url( $this->prefix.'/show_detail/'.strEncrypt($rows->vcard_id) ).'" class="btn btn-icon-only btn-sm yellow ajaxify tooltips"><i class="fa fa-search"></i></a> '.
                                '<a data-original-title="Delete vcard Data" href="'.base_url( $this->prefix.'/change_status_by/'.strEncrypt($rows->vcard_id).'/99/'.($rows->vcard_status == 99 ? '/true' : '' )).'" class="btn btn-icon-only btn-sm red-sunglo tooltips" onClick="return f_status(2, this, event)"><i class="fa fa-times"></i></a>';
                }else{
                    $action =   '<a data-original-title="Detail vcard Data" href="'.base_url( $this->prefix.'/show_detail/'.strEncrypt($rows->vcard_id) ).'" class="btn btn-icon-only btn-sm yellow ajaxify tooltips"><i class="fa fa-search"></i></a> ';
                }
            }
            $records["data"][] = [
                '<input type="checkbox" name="id[]" value="'.strEncrypt($rows->vcard_id).'">',
                $i,

                $rows->vcard_name,
                $rows->vcard_email,
                $rows->vcard_phone,
                $roles[$rows->vcard_role],
                $rows->vcard_status == 1 ? 'Active' :  ($rows->vcard_status == 99 ? 'Deleted' : 'InActive'),
                $rows->vcard_update_date == '' ? 'has not been updated' : tgl_format($rows->vcard_update_date),
                $action,
            ];
            $i++;
        }

        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;

        echo json_encode($records);
    }

    public function change_status($status, $where)
    {
        $data[$this->table_prefix.'status']             = $status;
        $data[$this->table_prefix.'update_date']        = date('Y-m-d H:i:s');

        $result = $this->m_global->update($this->table_db, $data, NULL, $where);
    }

    public function change_status_by($id, $status, $stat = FALSE)
    {
        if($stat){
            $result = $this->m_global->delete($this->table_db, [strEncrypt($this->table_prefix.'id', true) => $id]);
            if($result){
                $data['status'] = 1;
            }else{
                $data['status'] = 0;
            }

            echo json_encode($data);

        }else{
            $result = $this->m_global->update($this->table_db, [$this->table_prefix.'status' => $status], [strEncrypt($this->table_prefix.'id', true) => $id]);
            if($result){
                $data['status'] = 1;
            }else{
                $data['status'] = 0;
            }

            echo json_encode($data);
        }
    }

}

/* End of file config.php */
/* Location: ./application/modules/config/controllers/config.php */