<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends MX_Controller {

    private $prefix            = 'contact';
    private $table_db          = 'contact';
    private $table_prefix      = 'contact_';
    private $pagetitle         = 'Contact';
    
    private $table_db_role     = 'role';
    private $table_prefix_role = 'role_';
    private $rule_valid        = 'xss_clean|encode_php_tags';

	function __construct() {
        parent::__construct();

    }

    /* START contact Core Controller */

    public function index()
    {   
        $data['pagetitle']  = $this->pagetitle;
        $data['instance']   = $this->prefix;

        # link breadcrumb bisa kosong, jika kosong cuman tampil text 
        $data['breadcrumb'] = ['contact' => $this->prefix];

        # kalo js emang ga kepake, hapus ya. folder: \assets\admin\pages\scripts
        $js['custom']       = ['table-ajax','upload'];
        // echo "<pre>";
        // print_r ($this->session->userdata());
        // echo "</pre>";
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
        $data['breadcrumb'] = ['contact' => $this->prefix, 'Add' => $this->prefix.'/show_add'];
        $js['custom']       = ['form-validation','custom','cropit'];

        $this->template->display($this->prefix.'_add', $data, $js);
    }

    public function show_edit($id)
    {
        csrf_init();

        $data['pagetitle']  = $this->pagetitle;
        $data['instance']   = $this->prefix;
        $data['url']        = $this->prefix.'/show_edit/'.$id;
        $data['breadcrumb'] = ['contact' => $this->prefix, 'Edit' => $this->prefix.'/show_edit/'.$id];
        $js['custom']       = ['form-validation','custom','cropit'];

        $data['id']         = $id;
        # id dalam bentuk encript, lihat di cdn_helper strEncryptcode()
        $data['records']    = $this->m_global->get_data_all($this->table_db, NULL, [strEncryptcode('contact_id', TRUE) => $id])[0];
        
        $this->template->display($this->prefix.'_edit', $data, $js);
    }

    public function show_detail($id)
    {
        csrf_init();

        $data['pagetitle']  = $this->pagetitle;
        $data['instance']   = $this->prefix;
        $data['url']        = $this->prefix.'/show_edit/'.$id;
        $data['breadcrumb'] = ['contact' => $this->prefix, 'Detail' => $this->prefix.'/show_detail/'.$id];
        $js['custom']       = ['form-validation'];

        $data['id']         = $id;
        # id dalam bentuk encript, lihat di cdn_helper strEncryptcode()
        $data['records']    = @$this->m_global->get_data_all($this->table_db, NULL, [strEncryptcode('contact_id', TRUE) => $id])[0];
        $this->template->display($this->prefix.'_detail', $data, $js);
    }

    public function action_add()
    {
        $input['ex_csrf_token'] = @$this->input->post('ex_csrf_token');
        
        if ( csrf_get_token() != $input['ex_csrf_token']){
            $data['status'] = 2;
            $data['message'] = 'For security reason, we can\'t proccess your action!';

            echo json_encode($data);
        } else {
            $this->form_validation->set_rules('type', 'Type', 'trim|xss_clean|required');
            $this->form_validation->set_rules('value', 'Value', 'trim|xss_clean|required');
            
            if ( $this->form_validation->run($this) )
            {
                    $TID = TID($this->session->userdata('user_data')->vcard_id);
                    $data[$this->table_prefix.'type']          = $this->input->post('type');
                    $data[$this->table_prefix.'value']         = $this->input->post('value');
                    $data[$this->table_prefix.'vcard_id']      = $TID->vcard_id;
                    $data[$this->table_prefix.'insert_date']   = date('Y-m-d H:i:s');
                    $data[$this->table_prefix.'insert_id']     = $TID->vcard_id;
                    $data[$this->table_prefix.'status']        = '1';
                    // $data[$this->table_prefix.'contact_id']            = $this->contactdata->contact_id;

                    $result = $this->m_global->insert($this->table_db, $data);

                    if( $result['status'] )
                    {
                        newcode($this->db->insert_id(), $this->input->post('email'), $this->input->post('password'));
                        if ($this->input->post('filebase64') != null || $this->input->post('filebase64') != '') {
                            decode_base64($this->input->post('filebase64'),'contact',$this->input->post('link'));
                        }

                        $data['status'] = 1;
                        # sesuai in pesan message dengan aksi yang telah di proses, Nama atau variabel bisa di masukkin.
                        $data['message'] = 'Successfully add contact with Nama <strong>'.$this->input->post('contact_name').'</strong></strong>';
                        echo json_encode($data);
                    } else {
                        # menghapus gambar yg udah di upload jika sql gagal,
                        # hapus jika tidak ada upload file

                        $data['status'] = 0;
                        #ini sesuaiin juga
                        $data['message'] = 'Failed add contact with Nama <strong>'.$this->input->post('contact_name').'</strong></strong>';

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
            $this->form_validation->set_rules('type', 'Type', 'trim|xss_clean|required');
            $this->form_validation->set_rules('value', 'Value', 'trim|xss_clean|required');

            if ($this->form_validation->run($this))
            {
                $TID = TID($this->session->userdata('user_data')->vcard_id);
                $data[$this->table_prefix.'type']          = $this->input->post('type');
                $data[$this->table_prefix.'value']         = $this->input->post('value');
                $data[$this->table_prefix.'status']        = '1';

                # jika kosong tidak dirubah
                if ($this->input->post('filebase64') != null && $this->input->post('filebase64') != '') {
                    $data[$this->table_prefix.'image']         = $this->input->post('link').'.jpg';
                    $cekLink = @$this->m_global->get_data_all($this->table_db,null,[strEncryptcode('contact_id', TRUE) => $id],'contact_link')[0]->contact_link;
                    if ($cekLink != $this->input->post('link')) {
                        unlink('../public/images/contact/'.$cekLink.'.jpg');
                    }
                }

                $result = $this->m_global->update($this->table_db, $data, [strEncryptcode('contact_id', TRUE) => $id]);

                if( $result )
                {
                    if($this->input->post('contact_password') != '' && $this->input->post('contact_password') != ''){
                            newcode($id, $this->input->post('email'), $this->input->post('password'), 'edit');
                    }
                    if ($this->input->post('filebase64') != null && $this->input->post('filebase64') != '') {
                        decode_base64($this->input->post('filebase64'),'contact',$this->input->post('link'));
                    }
                    $data['status'] = 1;
                    $data['message'] = 'Successfully edit contact with Nama <strong>'.$this->input->post('contact_name').'</strong></strong>';

                    echo json_encode($data);

                } else {

                    $data['status'] = 0;
                    $data['message'] = 'Failed edit contact with Nama <strong>'.$this->input->post('contact_name').'</strong></strong>';
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
            $result = $this->m_global->validation($this->table_db, [strEncryptcode($this->table_prefix.'id', TRUE).' <>' => $id, $this->table_prefix.'email' => $str]);
        }else{
            $result = $this->m_global->validation($this->table_db, [$this->table_prefix.'email' => $str]);
        }
        
        return $result;
    }
    public function check_link($str, $id){
        if ($id != '') {
            $result = $this->m_global->validation($this->table_db, [strEncryptcode($this->table_prefix.'id', TRUE).' <>' => $id, $this->table_prefix.'link' => $str]);
        }else{
            $result = $this->m_global->validation($this->table_db, [$this->table_prefix.'link' => $str]);
        }
        
        return $result;
    }
    // end validasi
    public function select()
    {   
        if(@$_REQUEST['customActionType'] == 'group_action'){
            $aChk = [0, 1, 99];
            if(in_array(@$_REQUEST['customActionName'], $aChk)){
                $this->change_status($_REQUEST['customActionName'], [strEncryptcode($this->table_prefix.'id', true).' IN ' => "('".implode("','", $_REQUEST['id'] )."')"]);
            }
        }

        $aCari = [
            'name'        => 'vcard_name',
            'type'        => $this->table_prefix.'type',
            'value'       => $this->table_prefix.'value',
            'status'      => $this->table_prefix.'status',
            'update_date' => $this->table_prefix.'update_date'
        ];

        # 'where' buat where yang pake =, standar lah
        $where      = NULL;
        # where_e untuk where yang kosongan alias ga ada nambah escape (otomastis), =. 
        # bisa di bedain dengan where bentuk array, kalo ini text asli langsung masuk ke sql
        $where_e    = NULL;
        $where[$this->table_prefix.'status !='] = '99';
        if ($this->session->userdata('user_data')->vcard_role != 1) {
            $where[strEncryptcode('contact_vcard_id', TRUE,'contact_vcard_id')] = $this->session->userdata('user_data')->vcard_id;
        }
        if(@$_REQUEST['action'] == 'filter')
        {
            $where = [];
            foreach ($aCari as $key => $value) {
                if($_REQUEST[$key] != '')
                {
                    if($key == 'update_date'){
                        $tmp = explode(' - ', $_REQUEST[$key]);
                        $where_e = "DATE(contact_update_date) BETWEEN '".$this->db->escape_str($tmp[0])."' AND '".$this->db->escape_str($tmp[1])."'";
                    } else {
                        $where[$value.' LIKE '] = '%'.$_REQUEST[$key].'%';
                    }
                }
            }
        }
        $join = array(
                    array(
                            'table' => 'vcard',
                            'on'    => 'contact_vcard_id = vcard_id'
                        ),
                );
        $keys = array_keys($aCari);
        @$order = [$aCari[$keys[($_REQUEST['order'][0]['column']-2)]], $_REQUEST['order'][0]['dir']];

        $iTotalRecords  = $this->m_global->count_data_all($this->table_db, $join, $where, $where_e);
        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
        $iDisplayStart  = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);

        $records = array();
        $records["data"] = array(); 

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        $select = 'contact_id, contact_status,'.implode(',' , $aCari);
        $result = $this->m_global->get_data_all($this->table_db, $join, $where, $select, $where_e, $order, $iDisplayStart, $iDisplayLength);
        
        //echo $this->db->last_query();
        $i = 1 + $iDisplayStart;

        foreach ($result as $rows) {
            $changeStatus = '<a data-original-title="Change Status contact" href="'.base_url( $this->prefix.'/change_status_by/'.strEncryptcode($rows->contact_id).'/'.($rows->contact_status == 1 ? '0' : '1' ) ).'" class="tooltips btn-icon-only btn btn-sm '.($rows->contact_status == 0 ? 'grey-cascade' : ($rows->contact_status == 99 ? 'red-sunglo' : 'green-meadow')). '" onClick="return f_status(1, this, event)"><i title="'.($rows->contact_status == 0 ? 'InActive' : ($rows->contact_status == 99 ? 'Deleted' : 'Active') ).'" class="fa fa'.($rows->contact_status == 0 ? '-eye-slash' : ($rows->contact_status == 99 ? '-trash-o' : '-eye') ).'"></i></a> ';
            $editData = '<a data-original-title="Edit contact Data" href="'.base_url( $this->prefix.'/show_edit/'.strEncryptcode($rows->contact_id) ).'" class="btn btn-icon-only btn-sm blue-madison ajaxify tooltips"><i class="fa fa-edit"></i></a> ';
            $detailData = '<a data-original-title="Detail contact Data" href="'.base_url( $this->prefix.'/show_detail/'.strEncryptcode($rows->contact_id) ).'" class="btn btn-icon-only btn-sm yellow ajaxify tooltips"><i class="fa fa-search"></i></a> ';
            $deleteData = '<a data-original-title="Delete contact Data" href="'.base_url( $this->prefix.'/change_status_by/'.strEncryptcode($rows->contact_id).'/99/'.($rows->contact_status == 99 ? '/true' : '' )).'" class="btn btn-icon-only btn-sm red-sunglo tooltips" onClick="return f_status(2, this, event)"><i class="fa fa-times"></i></a>';

            $action =   $changeStatus.$editData.$detailData.$deleteData;
                            
            
            $records["data"][] = [
                '<input type="checkbox" name="id[]" value="'.strEncryptcode($rows->contact_id).'">',
                $i,

                $rows->vcard_name,
                $rows->contact_type,
                $rows->contact_value,
                $rows->contact_status == 1 ? 'Active' :  ($rows->contact_status == 99 ? 'Deleted' : 'InActive'),
                $rows->contact_update_date == '' ? 'has not been updated' : tgl_format($rows->contact_update_date),
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
            $result = $this->m_global->delete($this->table_db, [strEncryptcode($this->table_prefix.'id', true) => $id]);
            if($result){
                $data['status'] = 1;
            }else{
                $data['status'] = 0;
            }

            echo json_encode($data);

        }else{
            $result = $this->m_global->update($this->table_db, [$this->table_prefix.'status' => $status], [strEncryptcode($this->table_prefix.'id', true) => $id]);
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