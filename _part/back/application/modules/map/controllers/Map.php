<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Map extends MX_Controller {

    private $prefix            = 'map';
    private $table_db          = 'map';
    private $table_prefix      = 'map_';
    private $pagetitle         = 'Map';
    
    private $table_db_role     = 'role';
    private $table_prefix_role = 'role_';
    private $rule_valid        = 'xss_clean|encode_php_tags';

	function __construct() {
        parent::__construct();

    }

    /* START map Core Controller */

    public function index()
    {   
        $data['pagetitle']  = $this->pagetitle;
        $data['instance']   = $this->prefix;

        # link breadcrumb bisa kosong, jika kosong cuman tampil text 
        $data['breadcrumb'] = ['map' => $this->prefix];
        $data['url']        = $this->prefix;
        # kalo js emang ga kepake, hapus ya. folder: \assets\admin\pages\scripts
        $js['custom']       = ['form-validation','custom'];
        $TID = TID($this->session->userdata('user_data')->vcard_id);
        $data['records']    = @$this->m_global->get_data_all($this->table_db, NULL, ['map_vcard_id' => $TID->vcard_id])[0];
        
        if ($data['records'] != null || $data['records'] != '') {
            $this->template->display($this->prefix.'_edit', $data, $js);
        }else{
            $this->template->display($this->prefix.'_add', $data, $js);
        }
    }

    public function action_add()
    {
        $input['ex_csrf_token'] = @$this->input->post('ex_csrf_token');
        
        if ( csrf_get_token() != $input['ex_csrf_token']){
            $data['status'] = 2;
            $data['message'] = 'For security reason, we can\'t proccess your action!';

            echo json_encode($data);
        } else {
            $this->form_validation->set_rules('negara_id', 'Negara', 'trim|xss_clean|required');
            $this->form_validation->set_rules('full', 'Address', 'trim|xss_clean|required');
            if ( $this->form_validation->run($this) )
            {

                    $TID = TID($this->session->userdata('user_data')->vcard_id);
                    $data[$this->table_prefix.'vcard_id']    = $TID->vcard_id;
                    $data[$this->table_prefix.'negara_id']   = $this->input->post('negara_id');
                    $data[$this->table_prefix.'full']        = $this->input->post('full');
                    $data[$this->table_prefix.'status']      = '1';
                    $data[$this->table_prefix.'insert_date'] = date('Y-m-d H:i:s');
                    // $data[$this->table_prefix.'map_id']            = $this->mapdata->map_id;

                    $result = $this->m_global->insert($this->table_db, $data);

                    if( $result['status'] )
                    {
                        newcode($this->db->insert_id(), $this->input->post('email'), $this->input->post('password'));
                        if ($this->input->post('filebase64') != null || $this->input->post('filebase64') != '') {
                            decode_base64($this->input->post('filebase64'),'map',$this->input->post('link'));
                        }

                        $data['status'] = 1;
                        # sesuai in pesan message dengan aksi yang telah di proses, Nama atau variabel bisa di masukkin.
                        $data['message'] = 'Successfully add map with Nama <strong>'.$this->input->post('map_name').'</strong></strong>';
                        echo json_encode($data);
                    } else {
                        # menghapus gambar yg udah di upload jika sql gagal,
                        # hapus jika tidak ada upload file

                        $data['status'] = 0;
                        #ini sesuaiin juga
                        $data['message'] = 'Failed add map with Nama <strong>'.$this->input->post('map_name').'</strong></strong>';

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

    public function action_edit()
    {
        $input['ex_csrf_token'] = @$this->input->post('ex_csrf_token');

        if (csrf_get_token() != $input['ex_csrf_token']){
            $data['status'] = 2;
            $data['message'] = 'For security reason, we can\'t proccess your action!';

            echo json_encode($data);
        } else {
            $this->form_validation->set_rules('negara_id', 'Negara', 'trim|xss_clean|required');
            $this->form_validation->set_rules('full', 'Address', 'trim|xss_clean|required');

            if ($this->form_validation->run($this))
            {
                $TID = TID($this->session->userdata('user_data')->vcard_id);
                $data[$this->table_prefix.'negara_id'] = $this->input->post('negara_id');
                $data[$this->table_prefix.'full']      = $this->input->post('full');
                $data[$this->table_prefix.'status']    = '1';
                $data[$this->table_prefix.'update_id'] = $TID->vcard_id;

                $result = $this->m_global->update($this->table_db, $data, ['map_vcard_id' => $TID->vcard_id]);

                if( $result )
                {
                   
                    $data['status'] = 1;
                    $data['message'] = 'Successfully edit map with Nama <strong>'.$this->input->post('map_name').'</strong></strong>';

                    echo json_encode($data);

                } else {

                    $data['status'] = 0;
                    $data['message'] = 'Failed edit map with Nama <strong>'.$this->input->post('map_name').'</strong></strong>';
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

}

/* End of file config.php */
/* Location: ./application/modules/config/controllers/config.php */