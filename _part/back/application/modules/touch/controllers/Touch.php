<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Touch extends MX_Controller {

    private $prefix            = 'touch';
    private $table_db          = 'touch';
    private $table_prefix      = 'touch_';
    private $pagetitle         = 'Touch';
    
    private $table_db_role     = 'role';
    private $table_prefix_role = 'role_';
    private $rule_valid        = 'xss_clean|encode_php_tags';

	function __construct() {
        parent::__construct();
        $this->load->model('m_touch');

    }

    /* START touch Core Controller */

    public function index()
    {   
        $data['pagetitle']  = $this->pagetitle;
        $data['instance']   = $this->prefix;

        # link breadcrumb bisa kosong, jika kosong cuman tampil text 
        $data['breadcrumb'] = ['Touch' => $this->prefix];

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
        $data['breadcrumb'] = ['Touch' => $this->prefix, 'Add' => $this->prefix.'/show_add'];
        $js['custom']       = ['form-validation'];

        $this->template->display($this->prefix.'_add', $data, $js);
    }

    public function show_edit($id)
    {
        csrf_init();

        $data['pagetitle']  = $this->pagetitle;
        $data['instance']   = $this->prefix;
        $data['url']        = $this->prefix.'/show_edit/'.$id;
        $data['breadcrumb'] = ['Touch' => $this->prefix, 'Edit' => $this->prefix.'/show_edit/'.$id];
        $js['custom']       = ['form-validation'];

        $data['id']         = $id;
        # id dalam bentuk encript, lihat di cdn_helper strEncrypt()
        $data['records']    = $this->m_global->get_data_all($this->table_db, NULL, [strEncrypt('touch_id', TRUE) => $id])[0];
        $this->template->display($this->prefix.'_edit', $data, $js);
    }

    public function show_detail($id)
    {
        csrf_init();

        $data['pagetitle']  = $this->pagetitle;
        $data['instance']   = $this->prefix;
        $data['url']        = $this->prefix.'/show_edit/'.$id;
        $data['breadcrumb'] = ['Touch' => $this->prefix, 'Detail' => $this->prefix.'/show_detail/'.$id];
        $js['custom']       = ['form-validation'];

        $data['id']         = $id;
        # id dalam bentuk encript, lihat di cdn_helper strEncrypt()
        $data['records']    = $this->m_global->get_data_all($this->table_db, NULL, [strEncrypt('touch_id', TRUE) => $id])[0];
        $this->template->display($this->prefix.'_detail', $data, $js);
    }

    public function action_add()
    {
        $input['ex_csrf_token'] = @$this->input->post('ex_csrf_token');

        # ini jika ada upload file di form add, kalo ga ada, hapus coy
        $config['upload_path']   = '../public/images/touch_touch/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = '1024';

        #ini juga ni
        $this->load->library('upload', $config);

        if ( csrf_get_token() != $input['ex_csrf_token']){
            $data['status'] = 2;
            $data['message'] = 'For security reason, we can\'t proccess your action!';

            echo json_encode($data);
        } else {

            $this->form_validation->set_rules('touch_isi'   , 'isi'     , 'trim|xss_clean|required');
            $this->form_validation->set_rules('touch_judul' , 'Name'    , 'trim|xss_clean|required');
            $this->form_validation->set_rules('touch_link'  , 'Link'    , 'trim|xss_clean|required');
            $this->form_validation->set_rules('pu_foto'     , 'Picture' , 'trim|xss_clean');

            if ( $this->form_validation->run($this) )
            {
                    if (!$this->upload->do_upload('pu_foto')){
                        $data['status'] = 0;
                        $data['message'] = 'File must be Image and max size 1024Kb';
                        echo json_encode($data);
                        die();
                    }else{
                        // $re                               = $this->m_global->get_data_all($this->table_db, NULL, [strEncrypt($this->table_prefix.'id', TRUE) => $id], $this->table_prefix.'pict')[0];
                        $upload                           = $this->upload->data();
                        $data[$this->table_prefix.'pict'] = $upload['file_name'];
                    }

                    $link = $this->input->post('touch_link');
                    if($link != ''){
                        if (!is_numeric(strpos(strtolower($this->input->post('touch_link')),'http://'))) {
                            if(!is_numeric(strpos(strtolower($this->input->post('touch_link')),'https://')))
                            {
                               $link = 'http://'.$this->input->post('touch_link');
                            }
                        }
                    }

                    $data[$this->table_prefix.'judul']         = $this->input->post('touch_judul');
                    $data[$this->table_prefix.'isi']           = $this->input->post('touch_isi');
                    $data[$this->table_prefix.'link']          = $link;
                    $data[$this->table_prefix.'is_active']     = '1';
                    $data[$this->table_prefix.'insert_date']   = date('Y-m-d H:i:s');
                    $data[$this->table_prefix.'insert_member'] = $this->session->userdata('user_data')->member_id;
                    // $data[$this->table_prefix.'touch_id']            = $this->touchdata->touch_id;

                    $result = $this->m_global->insert($this->table_db, $data);

                    if( $result['status'] )
                    {
                        $data['status'] = 1;
                        # sesuai in pesan message dengan aksi yang telah di proses, judul atau variabel bisa di masukkin.
                        $data['message'] = 'Successfully add touch with Title <strong>'.$this->input->post('touch_judul').'</strong></strong>';
                        echo json_encode($data);
                    } else {
                        # menghapus gambar yg udah di upload jika sql gagal,
                        # hapus jika tidak ada upload file

                        $data['status'] = 0;
                        #ini sesuaiin juga
                        $data['message'] = 'Failed add touch with Title <strong>'.$this->input->post('touch_judul').'</strong></strong>';

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
            $this->form_validation->set_rules('touch_isi'   , 'isi'     , 'trim|xss_clean|required');
            $this->form_validation->set_rules('touch_judul' , 'Name'    , 'trim|xss_clean|required');
            $this->form_validation->set_rules('touch_link'  , 'Link'    , 'trim|xss_clean|required');
            $this->form_validation->set_rules('pu_foto'     , 'Picture' , 'trim|xss_clean');

            if ($this->form_validation->run($this))
            {
                // # Jika ada file yang diupload
                if(!empty($_FILES)){
                    $config['upload_path']   = '../public/images/touch_touch/';
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
                $link = $this->input->post('touch_link');
                if($link != ''){
                    if (!is_numeric(strpos(strtolower($this->input->post('touch_link')),'http://'))) {
                        if(!is_numeric(strpos(strtolower($this->input->post('touch_link')),'https://')))
                        {
                           $link = 'http://'.$this->input->post('touch_link');
                        }
                    }
                }

                $data[$this->table_prefix.'judul']         = $this->input->post('touch_judul');
                $data[$this->table_prefix.'isi']           = $this->input->post('touch_isi');
                $data[$this->table_prefix.'link']          = $link;
                $data[$this->table_prefix.'update_date']   = date('Y-m-d H:i:s');
                $data[$this->table_prefix.'update_member']     = $this->session->userdata('user_data')->member_id;
                # jika kosong tidak dirubah
               

                $result = $this->m_global->update($this->table_db, $data, [strEncrypt('touch_id', TRUE) => $id]);

                if( $result )
                {
                    if(isset($re->touch_pict)){
                        unlink('../public/images/touch_touch/'.$re->touch_pict);
                    }
                    $data['status'] = 1;
                    $data['message'] = 'Successfully edit touch with Title <strong>'.$this->input->post('touch_judul').'</strong></strong>';

                    echo json_encode($data);

                } else {
                    if(!empty($_FILES))
                    {
                        unlink('../public/images/touch_touch/'.$upload['file_name']);
                    }

                    $data['status'] = 0;
                    $data['message'] = 'Failed edit touch with Title <strong>'.$this->input->post('touch_judul').'</strong></strong>';
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
			'judul'       => $this->table_prefix.'judul',
			'isi'         => $this->table_prefix.'isi',
			'link'        => $this->table_prefix.'link',
			'is_active'   => $this->table_prefix.'is_active',
			'update_date' => $this->table_prefix.'update_date'
        ];

        # 'where' buat where yang pake =, standar lah
        $where      = NULL;
        # where_e untuk where yang kosongan alias ga ada nambah escape (otomastis), =. 
        # bisa di bedain dengan where bentuk array, kalo ini text asli langsung masuk ke sql
        $where_e    = NULL;
        $where[$this->table_prefix.'is_active !='] = '99';
        if(@$_REQUEST['action'] == 'filter')
        {
            $where = [];
            foreach ($aCari as $key => $value) {
                if($_REQUEST[$key] != '')
                {
                    if($key == 'update_date'){
                        $tmp = explode(' - ', $_REQUEST[$key]);
                        $where_e = "DATE(touch_update_date) BETWEEN '".$this->db->escape_str($tmp[0])."' AND '".$this->db->escape_str($tmp[1])."'";
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

        $select = 'touch_id, touch_insert_member, touch_is_active,'.implode(',' , $aCari);
        $result = $this->m_global->get_data_all($this->table_db, NULL, $where, $select, $where_e, $order, $iDisplayStart, $iDisplayLength);
        
        //echo $this->db->last_query();
        $i = 1 + $iDisplayStart;
        foreach ($result as $rows) {
            if ($this->session->userdata('user_data')->member_role == '1') {
                $action =   '<a data-original-title="Change Status touch" href="'.base_url( $this->prefix.'/change_status_by/'.strEncrypt($rows->touch_id).'/'.($rows->touch_is_active == 1 ? '0' : '1' ) ).'" class="tooltips btn-icon-only btn btn-sm '.($rows->touch_is_active == 0 ? 'grey-cascade' : ($rows->touch_is_active == 99 ? 'red-sunglo' : 'green-meadow')). '" onClick="return f_status(1, this, event)"><i title="'.($rows->touch_is_active == 0 ? 'InActive' : ($rows->touch_is_active == 99 ? 'Deleted' : 'Active') ).'" class="fa fa'.($rows->touch_is_active == 0 ? '-eye-slash' : ($rows->touch_is_active == 99 ? '-trash-o' : '-eye') ).'"></i></a> '.
                            '<a data-original-title="Edit touch Data" href="'.base_url( $this->prefix.'/show_edit/'.strEncrypt($rows->touch_id) ).'" class="btn btn-icon-only btn-sm blue-madison ajaxify tooltips"><i class="fa fa-edit"></i></a> '.
                            '<a data-original-title="Detail touch Data" href="'.base_url( $this->prefix.'/show_detail/'.strEncrypt($rows->touch_id) ).'" class="btn btn-icon-only btn-sm yellow ajaxify tooltips"><i class="fa fa-search"></i></a> '.
                            '<a data-original-title="Delete touch Data" href="'.base_url( $this->prefix.'/change_status_by/'.strEncrypt($rows->touch_id).'/99/'.($rows->touch_is_active == 99 ? 'true' : '' )).'" class="btn btn-icon-only btn-sm red-sunglo tooltips" onClick="return f_status(2, this, event)"><i class="fa fa-times"></i></a>';
            }elseif ($this->session->userdata('user_data')->member_role != '1') {
                if ($this->session->userdata('user_data')->member_id == $rows->touch_insert_member) {
                    $action =   '<a data-original-title="Change Status touch" href="'.base_url( $this->prefix.'/change_status_by/'.strEncrypt($rows->touch_id).'/'.($rows->touch_is_active == 1 ? '0' : '1' ) ).'" class="tooltips btn-icon-only btn btn-sm '.($rows->touch_is_active == 0 ? 'grey-cascade' : ($rows->touch_is_active == 99 ? 'red-sunglo' : 'green-meadow')). '" onClick="return f_status(1, this, event)"><i title="'.($rows->touch_is_active == 0 ? 'InActive' : ($rows->touch_is_active == 99 ? 'Deleted' : 'Active') ).'" class="fa fa'.($rows->touch_is_active == 0 ? '-eye-slash' : ($rows->touch_is_active == 99 ? '-trash-o' : '-eye') ).'"></i></a> '.
                                '<a data-original-title="Edit touch Data" href="'.base_url( $this->prefix.'/show_edit/'.strEncrypt($rows->touch_id) ).'" class="btn btn-icon-only btn-sm blue-madison ajaxify tooltips"><i class="fa fa-edit"></i></a> '.
                                '<a data-original-title="Detail touch Data" href="'.base_url( $this->prefix.'/show_detail/'.strEncrypt($rows->touch_id) ).'" class="btn btn-icon-only btn-sm yellow ajaxify tooltips"><i class="fa fa-search"></i></a> '.
                                '<a data-original-title="Delete touch Data" href="'.base_url( $this->prefix.'/change_status_by/'.strEncrypt($rows->touch_id).'/99/'.($rows->touch_is_active == 99 ? 'true' : '' )).'" class="btn btn-icon-only btn-sm red-sunglo tooltips" onClick="return f_status(2, this, event)"><i class="fa fa-times"></i></a>';
                }else{
                    $action =   '<a data-original-title="Detail touch Data" href="'.base_url( $this->prefix.'/show_detail/'.strEncrypt($rows->touch_id) ).'" class="btn btn-icon-only btn-sm yellow ajaxify tooltips"><i class="fa fa-search"></i></a> ';
                }
            }
            $records["data"][] = [
                '<input type="checkbox" name="id[]" value="'.strEncrypt($rows->touch_id).'">',
                $i,

                $rows->touch_judul,
                substr($rows->touch_isi,0,50).' ...',
                '<a data-original-title="touch Link" href="'.$rows->touch_link.'" class="tooltips" target="_blank">'.substr($rows->touch_link,0,30).'...'.'</i></a> ',
                $rows->touch_is_active == 1 ? 'Active' :  ($rows->touch_is_active == 99 ? 'Deleted' : 'InActive'),
                $rows->touch_update_date == '' ? 'has not been updated' : tgl_format($rows->touch_update_date),
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
        $data[$this->table_prefix.'is_active']             = $status;
        $data[$this->table_prefix.'update_date']        = date('Y-m-d H:i:s');

        $result = $this->m_global->update($this->table_db, $data, NULL, $where);
    }

    public function change_status_by($id, $status, $stat = FALSE)
    {
        if($stat){
            $re     = $this->m_global->get_data_all($this->table_db, NULL, [strEncrypt($this->table_prefix.'id', TRUE) => $id], $this->table_prefix.'pict')[0];
            $result = $this->m_global->delete($this->table_db, [strEncrypt($this->table_prefix.'id', true) => $id]);
            if($result){
                unlink('../public/images/touch_touch/'.$re->touch_pict);
                $data['status'] = 1;
            }else{
                $data['status'] = 0;
            }

            echo json_encode($data);

        }else{
            $result = $this->m_global->update($this->table_db, [$this->table_prefix.'is_active' => $status], [strEncrypt($this->table_prefix.'id', true) => $id]);
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