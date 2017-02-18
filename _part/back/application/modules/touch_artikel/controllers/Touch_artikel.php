<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Touch_artikel extends MX_Controller {

    private $prefix               = 'touch_artikel';
    private $table_db             = 'touch_artikel';
    private $table_prefix         = 'touchartikel_';
    private $pagetitle            = 'Touch Artikel';
    
    private $table_db_role        = 'role';
    private $table_prefix_role    = 'role_';
    private $rule_valid           = 'xss_clean|encode_php_tags';
    
    private $table_db_comment     = 'touch_comment';
    private $table_prefix_comment = 'touch_comment.';
    private $pref_comment         = 'touchcomment_';
    
    private $table_db_like        = 'touch_like';
    private $table_prefix_like    = 'touch_like.';
    private $pref_like            = 'touchlike_';

    private $table_db_member      = 'member';
    private $table_prefix_member  = 'member.';
    private $pref_member          = 'member_';

	function __construct() {
        parent::__construct();
        $this->load->model('m_touch_artikel');
        require_once(BASEPATH.'../../public/back/global/plugins/Facebook/autoload.php');
    }

    /* START fierce Core Controller */

    public function index()
    {   
        $data['pagetitle']  = $this->pagetitle;
        $data['instance']   = $this->prefix;

        # link breadcrumb bisa kosong, jika kosong cuman tampil text 
        $data['breadcrumb'] = ['Touch Artikel' => $this->prefix];

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
        $data['breadcrumb'] = ['Touch Artikel' => $this->prefix, 'Add' => $this->prefix.'/show_add'];
        $js['custom']       = ['form-validation'];

        $this->template->display($this->prefix.'_add', $data, $js);
    }

    public function show_edit($id)
    {
        csrf_init();

        $data['pagetitle']  = $this->pagetitle;
        $data['instance']   = $this->prefix;
        $data['url']        = $this->prefix.'/show_edit/'.$id;
        $data['breadcrumb'] = ['Touch Artikel' => $this->prefix, 'Edit' => $this->prefix.'/show_edit/'.$id];
        $js['custom']       = ['form-validation'];

        $data['id']         = $id;
        # id dalam bentuk encript, lihat di cdn_helper strEncrypt()
        $data['records']    = $this->m_global->get_data_all($this->table_db, NULL, [strEncrypt('touchartikel_id', TRUE) => $id])[0];
        $this->template->display($this->prefix.'_edit', $data, $js);
    }

    public function show_detail($id)
    {
        csrf_init();

        $data['pagetitle']          = $this->pagetitle;
        $data['instance']           = $this->prefix;
        $data['url']                = $this->prefix.'/show_edit/'.$id;
        $data['breadcrumb']         = ['Touch Artikel' => $this->prefix, 'Detail' => $this->prefix.'/show_detail/'.$id];
        $js['custom']               = ['form-validation'];

        $data['id']                 = $id;
        # id dalam bentuk e         cript, lihat di cdn_helper strEncrypt()
        $data['records']            = $this->m_global->get_data_all($this->table_db, NULL, [strEncrypt('touchartikel_id', TRUE) => $id])[0];
        
        $wherecomment               = [
                                            $this->table_prefix_comment.$this->pref_comment.'type'      => '1',
                                            $this->table_prefix_comment.$this->pref_comment.'arga_id'   => $id
                                      ];
        $join_comment               = [
                                            ["table" => $this->table_db_member ,'on'=> $this->table_prefix_comment.$this->pref_comment.'insert_member = '.$this->table_prefix_member.$this->pref_member.'id' ,'join' => 'left' ],
                                      ];
        $where_like_up              = [
                                            $this->table_prefix_like.$this->pref_like.'like'      => '1',
                                            $this->table_prefix_like.$this->pref_like.'type'      => '1',
                                            $this->table_prefix_like.$this->pref_like.'is_active' => '1',
                                            $this->table_prefix_like.$this->pref_like.'arga_id'   => $id
                                      ];
        $where_like_down            = [
                                            $this->table_prefix_like.$this->pref_like.'like'      => '2',
                                            $this->table_prefix_like.$this->pref_like.'type'      => '1',
                                            $this->table_prefix_like.$this->pref_like.'is_active' => '1',
                                            $this->table_prefix_like.$this->pref_like.'arga_id'   => $id
                                      ];
        $join_like                  = [
                                            ["table" => $this->table_db_member ,'on'=> $this->table_prefix_like.$this->pref_like.'insert_member = '.$this->table_prefix_member.$this->pref_member.'id' ],
                                      ];
        $jumlah_comment             = $this->m_global->count_data_all($this->table_db_comment , $join_comment , $wherecomment);
        $jumlah_like_user           = $this->m_global->get_data_all($this->table_db_like , $join_like , $where_like_up,$this->table_prefix_like.$this->pref_like.'insert_member');
        $jumlah_unlike_user         = $this->m_global->get_data_all($this->table_db_like , $join_like , $where_like_down,$this->table_prefix_like.$this->pref_like.'insert_member');
        // echo $jumlah_like_user;
        // echo $this->db->last_query();exit();
        $data['jumlah_comment']     = $jumlah_comment;
        $data['jumlah_like']        = $this->objact($jumlah_like_user);
        $data['jumlah_unlike']      = $this->objact($jumlah_unlike_user);

        $this->template->display($this->prefix.'_detail', $data, $js);
    }

    public function objact($arrays)
    {
        $array = '';
        foreach ($arrays as $key => $value) {
            $array[] = $value->touchlike_insert_member;
        }
        return $array;
    }

    public function action_add()
    {
        // require Facebook PHP SDK
        // see: https://developers.facebook.com/docs/php/gettingstarted/
        // initialize Facebook class using your own Facebook App credentials
        // see: https://developers.facebook.com/docs/php/gettingstarted/#install

        $input['ex_csrf_token'] = @$this->input->post('ex_csrf_token');

        # ini jika ada upload file di form add, kalo ga ada, hapus coy
        $config['upload_path']   = '../public/images/touch_artikel/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = '1024';

        #ini juga ni
        $this->load->library('upload', $config);

        if ( csrf_get_token() != $input['ex_csrf_token']){
            $data['status'] = 2;
            $data['message'] = 'For security reason, we can\'t proccess your action!';

            echo json_encode($data);
        } else {

            $this->form_validation->set_rules('touchartikel_isi'   , 'isi'     , 'trim|xss_clean|required');
            $this->form_validation->set_rules('touchartikel_judul' , 'Name'    , 'trim|xss_clean|required');
            $this->form_validation->set_rules('touchartikel_link'  , 'Link'    , 'trim|xss_clean|required');
            $this->form_validation->set_rules('pu_foto'      , 'Picture'  , 'trim|xss_clean');

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

                    $link = $this->input->post('touchartikel_link');
                    if($link != ''){
                        if (!is_numeric(strpos(strtolower($this->input->post('touchartikel_link')),'http://'))) {
                            if(!is_numeric(strpos(strtolower($this->input->post('touchartikel_link')),'https://')))
                            {
                               $link = 'http://'.$this->input->post('touchartikel_link');
                            }
                        }
                    }

                    $data[$this->table_prefix.'judul']         = $this->input->post('touchartikel_judul');
                    $data[$this->table_prefix.'isi']           = $this->input->post('touchartikel_isi');
                    $data[$this->table_prefix.'link']          = $link;
                    $data[$this->table_prefix.'is_active']     = '1';
                    $data[$this->table_prefix.'insert_date']   = date('Y-m-d H:i:s');
                    $data[$this->table_prefix.'insert_member'] = $this->session->userdata('user_data')->member_id;
                    // $data[$this->table_prefix.'touchartikel_id']            = $this->fiercedata->touchartikel_id;

                    $result = $this->m_global->insert($this->table_db, $data);
                    $last_id = $this->db->insert_id();

                    if( $result['status'] )
                    {

                        $fb = new Facebook\Facebook([
                          'app_id' => '1533478166969359',
                          'app_secret' => '4c35807324a7a9f7722aa1ce636035cb',
                          'default_graph_version' => 'v2.2',
                          ]);

                        $linkData = [
                          'link' => base_url('touch/index/'.strEncrypt($last_id)),
                          'message' => $this->input->post('touchartikel_isi'),
                          ];

                        try {
                          // Returns a `Facebook\FacebookResponse` object
                          $response = $fb->post('/146123695753741/feed', $linkData, '1533478166969359|r5nC2EHOKLZrjsCrOj8daBAiAac');
                        } catch(Facebook\Exceptions\FacebookResponseException $e) {
                          echo 'Graph returned an error: ' . $e->getMessage();
                          exit;
                        } catch(Facebook\Exceptions\FacebookSDKException $e) {
                          echo 'Facebook SDK returned an error: ' . $e->getMessage();
                          exit;
                        }

                        $data['status'] = 1;
                        # sesuai in pesan message dengan aksi yang telah di proses, judul atau variabel bisa di masukkin.
                        $data['message'] = 'Successfully add fierce with Title <strong>'.$this->input->post('touchartikel_judul').'</strong></strong>';
                        echo json_encode($data);
                    } else {
                        # menghapus gambar yg udah di upload jika sql gagal,
                        # hapus jika tidak ada upload file

                        $data['status'] = 0;
                        #ini sesuaiin juga
                        $data['message'] = 'Failed add fierce with Title <strong>'.$this->input->post('touchartikel_judul').'</strong></strong>';

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
            $this->form_validation->set_rules('touchartikel_isi'   , 'isi'     , 'trim|xss_clean|required');
            $this->form_validation->set_rules('touchartikel_judul' , 'Name'    , 'trim|xss_clean|required');
            $this->form_validation->set_rules('touchartikel_link'  , 'Link'    , 'trim|xss_clean|required');
            $this->form_validation->set_rules('pu_foto'     , 'Picture' , 'trim|xss_clean');

            if ($this->form_validation->run($this))
            {
                // # Jika ada file yang diupload
                if(!empty($_FILES)){
                    $config['upload_path']   = '../public/images/touch_artikel/';
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
                $link = $this->input->post('touchartikel_link');
                if (!is_numeric(strpos(strtolower($this->input->post('touchartikel_link')),'http://'))) {
                    if(!is_numeric(strpos(strtolower($this->input->post('touchartikel_link')),'https://')))
                    {
                       $link = 'http://'.$this->input->post('touchartikel_link');
                    }
                }

                $data[$this->table_prefix.'judul']         = $this->input->post('touchartikel_judul');
                $data[$this->table_prefix.'isi']           = $this->input->post('touchartikel_isi');
                $data[$this->table_prefix.'link']          = $link;
                $data[$this->table_prefix.'update_date']   = date('Y-m-d H:i:s');
                $data[$this->table_prefix.'update_member']     = $this->session->userdata('user_data')->member_id;
                # jika kosong tidak dirubah
               

                $result = $this->m_global->update($this->table_db, $data, [strEncrypt('touchartikel_id', TRUE) => $id]);

                if( $result )
                {
                    if(isset($re->touchartikel_pict)){
                        unlink('../public/images/touch_artikel/'.$re->touchartikel_pict);
                    }
                    $data['status'] = 1;
                    $data['message'] = 'Successfully edit fierce with Title <strong>'.$this->input->post('touchartikel_judul').'</strong></strong>';

                    echo json_encode($data);

                } else {
                    if(!empty($_FILES))
                    {
                        unlink('../public/images/touch_artikel/'.$upload['file_name']);
                    }

                    $data['status'] = 0;
                    $data['message'] = 'Failed edit fierce with Title <strong>'.$this->input->post('touchartikel_judul').'</strong></strong>';
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
                        $where_e = "DATE(touchartikel_update_date) BETWEEN '".$this->db->escape_str($tmp[0])."' AND '".$this->db->escape_str($tmp[1])."'";
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

        $select = 'touchartikel_id, touchartikel_insert_member, touchartikel_is_active,'.implode(',' , $aCari);
        $result = $this->m_global->get_data_all($this->table_db, NULL, $where, $select, $where_e, $order, $iDisplayStart, $iDisplayLength);
        
        //echo $this->db->last_query();
        $i = 1 + $iDisplayStart;
        foreach ($result as $rows) {
            if ($this->session->userdata('user_data')->member_role == '1') {
                $action =   '<a data-original-title="Change Status fierce" href="'.base_url( $this->prefix.'/change_status_by/'.strEncrypt($rows->touchartikel_id).'/'.($rows->touchartikel_is_active == 1 ? '0' : '1' ) ).'" class="tooltips btn-icon-only btn btn-sm '.($rows->touchartikel_is_active == 0 ? 'grey-cascade' : ($rows->touchartikel_is_active == 99 ? 'red-sunglo' : 'green-meadow')). '" onClick="return f_status(1, this, event)"><i title="'.($rows->touchartikel_is_active == 0 ? 'InActive' : ($rows->touchartikel_is_active == 99 ? 'Deleted' : 'Active') ).'" class="fa fa'.($rows->touchartikel_is_active == 0 ? '-eye-slash' : ($rows->touchartikel_is_active == 99 ? '-trash-o' : '-eye') ).'"></i></a> '.
                            '<a data-original-title="Edit fierce Data" href="'.base_url( $this->prefix.'/show_edit/'.strEncrypt($rows->touchartikel_id) ).'" class="btn btn-icon-only btn-sm blue-madison ajaxify tooltips"><i class="fa fa-edit"></i></a> '.
                            '<a data-original-title="Detail fierce Data" href="'.base_url( $this->prefix.'/show_detail/'.strEncrypt($rows->touchartikel_id) ).'" class="btn btn-icon-only btn-sm yellow ajaxify tooltips"><i class="fa fa-search"></i></a> '.
                            '<a data-original-title="Delete fierce Data" href="'.base_url( $this->prefix.'/change_status_by/'.strEncrypt($rows->touchartikel_id).'/99/'.($rows->touchartikel_is_active == 99 ? 'true' : '' )).'" class="btn btn-icon-only btn-sm red-sunglo tooltips" onClick="return f_status(2, this, event)"><i class="fa fa-times"></i></a>';
            }elseif ($this->session->userdata('user_data')->member_role != '1') {
                if ($this->session->userdata('user_data')->member_id == $rows->touchartikel_insert_member) {
                    $action =   '<a data-original-title="Change Status fierce" href="'.base_url( $this->prefix.'/change_status_by/'.strEncrypt($rows->touchartikel_id).'/'.($rows->touchartikel_is_active == 1 ? '0' : '1' ) ).'" class="tooltips btn-icon-only btn btn-sm '.($rows->touchartikel_is_active == 0 ? 'grey-cascade' : ($rows->touchartikel_is_active == 99 ? 'red-sunglo' : 'green-meadow')). '" onClick="return f_status(1, this, event)"><i title="'.($rows->touchartikel_is_active == 0 ? 'InActive' : ($rows->touchartikel_is_active == 99 ? 'Deleted' : 'Active') ).'" class="fa fa'.($rows->touchartikel_is_active == 0 ? '-eye-slash' : ($rows->touchartikel_is_active == 99 ? '-trash-o' : '-eye') ).'"></i></a> '.
                                '<a data-original-title="Edit fierce Data" href="'.base_url( $this->prefix.'/show_edit/'.strEncrypt($rows->touchartikel_id) ).'" class="btn btn-icon-only btn-sm blue-madison ajaxify tooltips"><i class="fa fa-edit"></i></a> '.
                                '<a data-original-title="Detail fierce Data" href="'.base_url( $this->prefix.'/show_detail/'.strEncrypt($rows->touchartikel_id) ).'" class="btn btn-icon-only btn-sm yellow ajaxify tooltips"><i class="fa fa-search"></i></a> '.
                                '<a data-original-title="Delete fierce Data" href="'.base_url( $this->prefix.'/change_status_by/'.strEncrypt($rows->touchartikel_id).'/99/'.($rows->touchartikel_is_active == 99 ? 'true' : '' )).'" class="btn btn-icon-only btn-sm red-sunglo tooltips" onClick="return f_status(2, this, event)"><i class="fa fa-times"></i></a>';
                }else{
                    $action =   '<a data-original-title="Detail fierce Data" href="'.base_url( $this->prefix.'/show_detail/'.strEncrypt($rows->touchartikel_id) ).'" class="btn btn-icon-only btn-sm yellow ajaxify tooltips"><i class="fa fa-search"></i></a> ';
                }
            }
            $records["data"][] = [
                '<input type="checkbox" name="id[]" value="'.strEncrypt($rows->touchartikel_id).'">',
                $i,

                $rows->touchartikel_judul,
                substr($rows->touchartikel_isi,0,50).' ...',
                '<a data-original-title="fierce Link" href="'.$rows->touchartikel_link.'" class="tooltips" target="_blank">'.substr($rows->touchartikel_link,0,30).'...'.'</i></a> ',
                $rows->touchartikel_is_active == 1 ? 'Active' :  ($rows->touchartikel_is_active == 99 ? 'Deleted' : 'InActive'),
                $rows->touchartikel_update_date == '' ? 'has not been updated' : tgl_format($rows->touchartikel_update_date),
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
                unlink('../public/images/touch_artikel/'.$re->touchartikel_pict);
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

    public function like(){
        $this->db->trans_begin();
        
        $data[$this->table_prefix_like.$this->pref_like.'type']         = '1';
        $data[$this->table_prefix_like.$this->pref_like.'like']         = '1';
        $data[$this->table_prefix_like.$this->pref_like.'arga_id']      = $this->input->post('idarga');
        $data[$this->table_prefix_like.$this->pref_like.'insert_member']= $this->session->userdata('user_data')->member_id;
        $data[$this->table_prefix_like.$this->pref_like.'insert_date']  = date('Y-m-d H:i:s');

        $valid  = $this->m_global->count_data_all($this->table_db_like , NULL , [$this->table_prefix_like.$this->pref_like.'arga_id' => $this->input->post('idarga'),
                                                                                $this->table_prefix_like.$this->pref_like.'insert_member' => $this->session->userdata('user_data')->member_id,
                                                                                $this->table_prefix_like.$this->pref_like.'like' => '1']);
        if ($valid <= 0) {
            $result = $this->m_global->insert($this->table_db_like, $data);
        }

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        }else{
            $this->db->trans_commit();
            // $this->session->set_flashdata('message', 'Berhasil');
            // redirect(base_url('#index.php/efill/lhkpn/entry/'.$this->input->post('ID_LHKPN', TRUE)), 'refresh');
        }
        echo intval($this->db->trans_status());
    }

    public function likedown(){
        $this->db->trans_begin();
        
        $data[$this->table_prefix_like.$this->pref_like.'type']         = '1';
        $data[$this->table_prefix_like.$this->pref_like.'like']         = '1';
        $data[$this->table_prefix_like.$this->pref_like.'arga_id']      = $this->input->post('idarga');
        $data[$this->table_prefix_like.$this->pref_like.'insert_member']= $this->session->userdata('user_data')->member_id;
        
        $valid  = $this->m_global->count_data_all($this->table_db_like , NULL , [$this->table_prefix_like.$this->pref_like.'arga_id' => $this->input->post('idarga'),
                                                                                $this->table_prefix_like.$this->pref_like.'insert_member' => $this->session->userdata('user_data')->member_id,
                                                                                $this->table_prefix_like.$this->pref_like.'like' => '1']);
        if ($valid > 0) {
            $result = $this->m_global->delete($this->table_db_like, $data);
        }
        

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        }else{
            $this->db->trans_commit();
            // $this->session->set_flashdata('message', 'Berhasil');
            // redirect(base_url('#index.php/efill/lhkpn/entry/'.$this->input->post('ID_LHKPN', TRUE)), 'refresh');
        }
        echo intval($this->db->trans_status());
    }

    public function unlike(){
        $this->db->trans_begin();
        
        $data[$this->table_prefix_like.$this->pref_like.'type']         = '1';
        $data[$this->table_prefix_like.$this->pref_like.'like']         = '2';
        $data[$this->table_prefix_like.$this->pref_like.'arga_id']      = $this->input->post('idarga');
        $data[$this->table_prefix_like.$this->pref_like.'insert_member']= $this->session->userdata('user_data')->member_id;
        $data[$this->table_prefix_like.$this->pref_like.'insert_date']  = date('Y-m-d H:i:s');

        $valid  = $this->m_global->count_data_all($this->table_db_like , NULL , [$this->table_prefix_like.$this->pref_like.'arga_id' => $this->input->post('idarga'),
                                                                                $this->table_prefix_like.$this->pref_like.'insert_member' => $this->session->userdata('user_data')->member_id,
                                                                                $this->table_prefix_like.$this->pref_like.'like' => '2']);
        if ($valid <= 0) {
            $result = $this->m_global->insert($this->table_db_like, $data);
        }

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        }else{
            $this->db->trans_commit();
            // $this->session->set_flashdata('message', 'Berhasil');
            // redirect(base_url('#index.php/efill/lhkpn/entry/'.$this->input->post('ID_LHKPN', TRUE)), 'refresh');
        }
        echo intval($this->db->trans_status());
    }

    public function unlikedown(){
        $this->db->trans_begin();
        
        $data[$this->table_prefix_like.$this->pref_like.'type']         = '1';
        $data[$this->table_prefix_like.$this->pref_like.'like']         = '2';
        $data[$this->table_prefix_like.$this->pref_like.'arga_id']      = $this->input->post('idarga');
        $data[$this->table_prefix_like.$this->pref_like.'insert_member']= $this->session->userdata('user_data')->member_id;
        
        $valid  = $this->m_global->count_data_all($this->table_db_like , NULL , [$this->table_prefix_like.$this->pref_like.'arga_id' => $this->input->post('idarga'),
                                                                                $this->table_prefix_like.$this->pref_like.'insert_member' => $this->session->userdata('user_data')->member_id,
                                                                                $this->table_prefix_like.$this->pref_like.'like' => '2']);
        if ($valid > 0) {
            $result = $this->m_global->delete($this->table_db_like, $data);
        }

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        }else{
            $this->db->trans_commit();
            // $this->session->set_flashdata('message', 'Berhasil');
            // redirect(base_url('#index.php/efill/lhkpn/entry/'.$this->input->post('ID_LHKPN', TRUE)), 'refresh');
        }
        echo intval($this->db->trans_status());
    }

    public function show_comment($id,$page)
    {
        $where= [$this->table_prefix.'id' => $id];
        $data['touch']              = $this->m_global->get_data_all($this->table_db , NULL , $where , '*' , NULL , [ $this->table_prefix.'insert_date' , 'DESC' ])[0];
        $wherecomment               = [
                                            $this->table_prefix_comment.$this->pref_comment.'type'      => '1',
                                            $this->table_prefix_comment.$this->pref_comment.'arga_id'   => $data['touch']->touchartikel_id
                                      ];
        $join                       = [
                                            ["table" => $this->table_db_member ,'on'=> $this->table_prefix_comment.$this->pref_comment.'insert_member = '.$this->table_prefix_member.$this->pref_member.'id' ,'join' => 'left' ],
                                      ];
        $where_like_up              = [
                                            $this->table_prefix_like.$this->pref_like.'like'      => '1',
                                            $this->table_prefix_like.$this->pref_like.'type'      => '1',
                                            $this->table_prefix_like.$this->pref_like.'is_active' => '1',
                                            $this->table_prefix_like.$this->pref_like.'arga_id'   => $data['touch']->touchartikel_id
                                      ];
        $where_like_down            = [
                                            $this->table_prefix_like.$this->pref_like.'like'      => '2',
                                            $this->table_prefix_like.$this->pref_like.'type'      => '1',
                                            $this->table_prefix_like.$this->pref_like.'is_active' => '1',
                                            $this->table_prefix_like.$this->pref_like.'arga_id'   => $data['touch']->touchartikel_id
                                      ];
        $join_like                  = [
                                            ["table" => $this->table_db_member ,'on'=> $this->table_prefix_like.$this->pref_like.'insert_member = '.$this->table_prefix_member.$this->pref_member.'id' ],
                                      ];
        if ($page == 1) {
            $halaman                    = $page-1;
        }
        else
        {
            $halaman                    = ($page*5)-5;
        }
        $select                     = $this->pref_comment.'id,'.$this->pref_comment.'insert_date,'.$this->pref_comment.'isi,'.$this->pref_comment.'email,'.$this->pref_member.'nama,'.$this->pref_member.'nick_name,'.$this->pref_member.'pict,'.$this->pref_member.'id';
        $jumlah_comment             = $this->m_global->get_data_all($this->table_db_comment , $join , $wherecomment, $select,Null,[ $this->pref_comment.'insert_date' , 'DESC' ],$halaman,5);
        $jumlah_like                = $this->m_global->count_data_all($this->table_db_like , $join_like , $where_like_up);
        $jumlah_unlike              = $this->m_global->count_data_all($this->table_db_like , $join_like , $where_like_down);
        $data = array(
                        // 'jumlah_comment'    => count($jumlah_comment),
                        'item'              => $jumlah_comment,
                        'instance'          => $this->table_db,
                    );
        $show = array(
                        'jumlah_like'       => $jumlah_like,
                        'jumlah_unlike'     => $jumlah_unlike,
                        'view'              => $this->load->view(strtolower(__CLASS__).'_comment', $data,true),
                        'jumlah_comment'    => $this->m_global->count_data_all($this->table_db_comment , $join , $wherecomment)
                    );
        echo json_encode($show);
    }

    public function delete_comment()
    {
        $this->db->trans_begin();
        $id     = $this->input->post('id_comment');
        $where  = [
                        $this->table_prefix_comment.$this->pref_comment.'id'   => $id
                  ];
        $data   = $this->m_global->delete($this->table_db_comment , $where);
        // $return = array_merge($data);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        }else{
            $this->db->trans_commit();
        }
        echo json_encode($data); 
        exit;
    }

    public function add_comment(){
        $this->db->trans_begin();
        if (@$this->session->userdata('user_data')->member_email != '') {
            $data[$this->table_prefix_comment.$this->pref_comment.'email']  = $this->session->userdata('user_data')->member_email;
        }
        else
        {
            $data[$this->table_prefix_comment.$this->pref_comment.'email']  = $this->input->post('email');
        }
        $data[$this->table_prefix_comment.$this->pref_comment.'type']       = '1';
        $data[$this->table_prefix_comment.$this->pref_comment.'isi']        = $this->input->post('touchcomment_isi');
        $data[$this->table_prefix_comment.$this->pref_comment.'arga_id']    = $this->input->post('argaid');
        $data[$this->table_prefix_comment.$this->pref_comment.'insert_date']= date('Y-m-d H:i:s');
        if (@$this->session->userdata('user_data')->member_id != '') {
            $data[$this->table_prefix_comment.$this->pref_comment.'insert_member']= $this->session->userdata('user_data')->member_id;
        }
        $result = $this->m_global->insert($this->table_db_comment, $data);

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        }else{
            $this->db->trans_commit();
            // $this->session->set_flashdata('message', 'Berhasil');
            // redirect(base_url('#index.php/efill/lhkpn/entry/'.$this->input->post('ID_LHKPN', TRUE)), 'refresh');
        }
        echo intval($this->db->trans_status());
    }

    public function edit_comment(){
        $this->db->trans_begin();
        $where  = [
                        $this->table_prefix_comment.$this->pref_comment.'id'    => $this->input->post('commentid'),
                  ];
        $data[$this->table_prefix_comment.$this->pref_comment.'isi']            = $this->input->post('touchcomment_isi');
        $data[$this->table_prefix_comment.$this->pref_comment.'update_date']    = date('Y-m-d H:i:s');
        $data[$this->table_prefix_comment.$this->pref_comment.'update_member']  = $this->session->userdata('user_data')->member_id;
        $result = $this->m_global->update($this->table_db_comment, $data, $where);

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        }else{
            $this->db->trans_commit();
            // $this->session->set_flashdata('message', 'Berhasil');
            // redirect(base_url('#index.php/efill/lhkpn/entry/'.$this->input->post('ID_LHKPN', TRUE)), 'refresh');
        }
        echo intval($this->db->trans_status());
    }

    public function show_edit_comment($id)
    {
        $where                      = [$this->pref_comment.'id' => $id];
        $select                     = $this->pref_comment.'isi,'.$this->pref_comment.'id';
        $comment                    = $this->m_global->get_data_all($this->table_db_comment , NULL , $where, $select)[0];
        $data = array(
                        'item'      => $comment,
                        'instance'  => $this->table_db,
                    );
        $this->load->view(strtolower(__CLASS__).'_comment_edit',$data);
    }

}

/* End of file config.php */
/* Location: ./application/modules/config/controllers/config.php */