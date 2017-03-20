<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Skill extends MX_Controller {

    private $prefix            = 'skill';
    private $table_db          = 'skill';
    private $table_prefix      = 'skill_';
    private $pagetitle         = 'Skill';
    
    private $table_db_role     = 'role';
    private $table_prefix_role = 'role_';
    private $rule_valid        = 'xss_clean|encode_php_tags';

	function __construct() {
        parent::__construct();

    }

    /* START skill Core Controller */

    public function index()
    {   
        $data['pagetitle']  = $this->pagetitle;
        $data['instance']   = $this->prefix;

        # link breadcrumb bisa kosong, jika kosong cuman tampil text 
        $data['breadcrumb'] = [str_replace('_', ' ','skill') => $this->prefix];

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
        $data['breadcrumb'] = [str_replace('_', ' ','skill') => $this->prefix, 'Add' => $this->prefix.'/show_add'];
        $js['custom']       = ['form-validation','custom'];

        $this->template->display($this->prefix.'_add', $data, $js);
    }

    public function show_edit($id)
    {
        csrf_init();

        $data['pagetitle']  = $this->pagetitle;
        $data['instance']   = $this->prefix;
        $data['url']        = $this->prefix.'/show_edit/'.$id;
        $data['breadcrumb'] = [str_replace('_', ' ','skill') => $this->prefix, 'Edit' => $this->prefix.'/show_edit/'.$id];
        $js['custom']       = ['form-validation','custom'];

        $data['id']         = $id;
        # id dalam bentuk encript, lihat di cdn_helper strEncryptcode()
        $data['records']    = $this->m_global->get_data_all($this->table_db, NULL, [strEncryptcode('skill_id', TRUE) => $id])[0];
        
        $this->template->display($this->prefix.'_edit', $data, $js);
    }

    public function show_detail($id)
    {
        csrf_init();

        $data['pagetitle']  = $this->pagetitle;
        $data['instance']   = $this->prefix;
        $data['url']        = $this->prefix.'/show_edit/'.$id;
        $data['breadcrumb'] = ['skill' => $this->prefix, 'Detail' => $this->prefix.'/show_detail/'.$id];
        $js['custom']       = ['form-validation'];

        $data['id']         = $id;
        # id dalam bentuk encript, lihat di cdn_helper strEncryptcode()
        $data['records']    = @$this->m_global->get_data_all($this->table_db, NULL, [strEncryptcode('skill_id', TRUE) => $id])[0];
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
            $this->form_validation->set_rules(strtolower(str_replace(' ', '_', 'Group')), 'Group', 'trim|xss_clean|required');
            $this->form_validation->set_rules(strtolower(str_replace(' ', '_', 'Name')), 'Name', 'trim|xss_clean|required');
            $this->form_validation->set_rules(strtolower(str_replace(' ', '_', 'Range')), 'Range', 'trim|xss_clean|required');
            
            if ( $this->form_validation->run($this) )
            {
                    $TID = TID($this->session->userdata('user_data')->vcard_id);
                    
                    $data[$this->table_prefix.'vcard_id']    = $TID->vcard_id;
                    $data[$this->table_prefix.'name']        = $this->input->post('name');
                    $group = $this->input->post('group');
                    if (!is_numeric($this->input->post('group'))) {
                        $cek = $this->m_global->count_data_all('group_skill', null, array('group_skill_name' => $this->input->post('group')));
                        if ($cek <= 0) {
                            $new_group['group_skill_name']          = $this->input->post('group');
                            $new_group['group_skill_insert_date']   = date('Y-m-d H:i:s');
                            $new_group['group_skill_insert_id']     = $TID->vcard_id;
                            $new_group['group_skill_status']        = '1';
                            $new_group = $this->m_global->insert('group_skill', $new_group);
                            $group = $this->db->insert_id();
                        }
                    }
                    $data[$this->table_prefix.'group_skill_id']    = $group;
                    $data[$this->table_prefix.'range']        = $this->input->post('range');

                    $data[$this->table_prefix.'insert_date'] = date('Y-m-d H:i:s');
                    $data[$this->table_prefix.'insert_id']   = $TID->vcard_id;
                    $data[$this->table_prefix.'status']      = '1';
                    // $data[$this->table_prefix.'skill_id']            = $this->skilldata->skill_id;

                    $result = $this->m_global->insert($this->table_db, $data);

                    if( $result['status'] )
                    {

                        $data['status'] = 1;
                        # sesuai in pesan message dengan aksi yang telah di proses, Nama atau variabel bisa di masukkin.
                        $data['message'] = 'Successfully add '.str_replace('_',' ','skill').' with Nama <strong>'.$this->input->post('skill_name').'</strong></strong>';
                        echo json_encode($data);
                    } else {
                        # menghapus gambar yg udah di upload jika sql gagal,
                        # hapus jika tidak ada upload file

                        $data['status'] = 0;
                        #ini sesuaiin juga
                        $data['message'] = 'Failed add '.str_replace('_',' ','skill').' with Nama <strong>'.$this->input->post('skill_name').'</strong></strong>';

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
            $this->form_validation->set_rules(strtolower(str_replace(' ', '_', 'Type')), 'Type', 'trim|xss_clean|required');
            $this->form_validation->set_rules(strtolower(str_replace(' ', '_', 'Position')), 'Position', 'trim|xss_clean|required');
            $this->form_validation->set_rules(strtolower(str_replace(' ', '_', 'Sub')), 'Sub', 'trim|xss_clean');
            $this->form_validation->set_rules(strtolower(str_replace(' ', '_', 'From')), 'From', 'trim|xss_clean|required');
            $this->form_validation->set_rules(strtolower(str_replace(' ', '_', 'To')), 'To', 'trim|xss_clean|required');
            $this->form_validation->set_rules(strtolower(str_replace(' ', '_', 'Description')), 'Description', 'trim|xss_clean');

            if ($this->form_validation->run($this))
            {
                $data[$this->table_prefix.'type']        = $this->input->post('type');
                $data[$this->table_prefix.'position']    = $this->input->post('position');
                $data[$this->table_prefix.'sub']         = $this->input->post('sub');
                $data[$this->table_prefix.'period']      = $this->input->post('from').' - '.$this->input->post('to');
                $data[$this->table_prefix.'description'] = $this->input->post('description');
                

                $data[$this->table_prefix.'status']        = '1';

                # jika kosong tidak dirubah
                
                $result = $this->m_global->update($this->table_db, $data, [strEncryptcode('skill_id', TRUE) => $id]);

                if( $result )
                {
                    
                    $data['status'] = 1;
                    $data['message'] = 'Successfully edit '.str_replace('_',' ','skill').' with Nama <strong>'.$this->input->post('skill_name').'</strong></strong>';

                    echo json_encode($data);

                } else {

                    $data['status'] = 0;
                    $data['message'] = 'Failed edit '.str_replace('_',' ','skill').' with Nama <strong>'.$this->input->post('skill_name').'</strong></strong>';
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
    // end validasi
    public function select()
    {   
        if(@$_REQUEST['customActionType'] == 'group_action'){
            $aChk = [0, 1, 99];
            if(in_array(@$_REQUEST['customActionType'], $aChk)){
                $this->change_status($_REQUEST['customActionType'], [strEncryptcode($this->table_prefix.'id', true).' IN ' => "('".implode("','", $_REQUEST['id'] )."')"]);
            }
        }

        $aCari = [
            'name'        => 'vcard_name',
            'group'       => 'group_skill_name',
            'skill_name'  => $this->table_prefix.'name',
            'range'       => $this->table_prefix.'range',
            'status'      => $this->table_prefix.'status',
            'update_date' => $this->table_prefix.'update_date'
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
                        $where_e = "DATE(skill_update_date) BETWEEN '".$this->db->escape_str($tmp[0])."' AND '".$this->db->escape_str($tmp[1])."'";
                    } else {
                        $where[$value.' LIKE '] = '%'.$_REQUEST[$key].'%';
                    }
                }
            }
        }
        if ($this->session->userdata('user_data')->vcard_role != 1) {
            $where[strEncryptcode('skill_vcard_id', TRUE,'skill_vcard_id')] = $this->session->userdata('user_data')->vcard_id;
        }
        $join = array(
                    array(
                            'table' => 'vcard',
                            'on'    => 'skill_vcard_id = vcard_id'
                        ),
                    array(
                            'table' => 'group_skill',
                            'on'    => 'skill_group_skill_id = group_skill_id'
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

        $select = 'skill_id, skill_status,'.implode(',' , $aCari);
        $result = $this->m_global->get_data_all($this->table_db, $join, $where, $select, $where_e, $order, $iDisplayStart, $iDisplayLength);
        
        //echo $this->db->last_query();
        $i = 1 + $iDisplayStart;

        foreach ($result as $rows) {
            $changeStatus = '<a data-original-title="Change Status skill" href="'.base_url( $this->prefix.'/change_status_by/'.strEncryptcode($rows->skill_id).'/'.($rows->skill_status == 1 ? '0' : '1' ) ).'" class="tooltips btn-icon-only btn btn-sm '.($rows->skill_status == 0 ? 'grey-cascade' : ($rows->skill_status == 99 ? 'red-sunglo' : 'green-meadow')). '" onClick="return f_status(1, this, event)"><i title="'.($rows->skill_status == 0 ? 'InActive' : ($rows->skill_status == 99 ? 'Deleted' : 'Active') ).'" class="fa fa'.($rows->skill_status == 0 ? '-eye-slash' : ($rows->skill_status == 99 ? '-trash-o' : '-eye') ).'"></i></a> ';
            $editData = '<a data-original-title="Edit skill Data" href="'.base_url( $this->prefix.'/show_edit/'.strEncryptcode($rows->skill_id) ).'" class="btn btn-icon-only btn-sm blue-madison ajaxify tooltips"><i class="fa fa-edit"></i></a> ';
            $detailData = '<a data-original-title="Detail skill Data" href="'.base_url( $this->prefix.'/show_detail/'.strEncryptcode($rows->skill_id) ).'" class="btn btn-icon-only btn-sm yellow ajaxify tooltips"><i class="fa fa-search"></i></a> ';
            $deleteData = '<a data-original-title="Delete skill Data" href="'.base_url( $this->prefix.'/change_status_by/'.strEncryptcode($rows->skill_id).'/99/'.($rows->skill_status == 99 ? '/true' : '' )).'" class="btn btn-icon-only btn-sm red-sunglo tooltips" onClick="return f_status(2, this, event)"><i class="fa fa-times"></i></a>';

            $action =   $changeStatus.$editData.$deleteData;
                            
            
            $records["data"][] = [
                '<input type="checkbox" name="id[]" value="'.strEncryptcode($rows->skill_id).'">',
                $i,

                $rows->vcard_name,
                $rows->group_skill_name,
                $rows->skill_name,
                $rows->skill_range,
                $rows->skill_status == 1 ? 'Active' :  ($rows->skill_status == 99 ? 'Deleted' : 'InActive'),
                $rows->skill_update_date == '' ? 'has not been updated' : tgl_format($rows->skill_update_date),
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