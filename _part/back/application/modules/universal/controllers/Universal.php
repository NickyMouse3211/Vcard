<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Universal extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function detail_pict($location)
	{
		$location = rawurldecode(str_replace('_'.md5('%').'-','%',$location));
		
	    $data = array(
	                    'foto'      => $location,
	                    'color'		=> getcolor(str_replace(base_url(),'',$location)),
	                );
	    $this->load->view(strtolower(__CLASS__).'_detail_pict',$data);
	}

	public function get_role($id = '')
	{
	    if($id == ''){

	        $q = $_GET['q'];

	        $where[] = '';
	        if ($this->session->userdata('user_data')->vcard_role == '2' ) {
	        	$where['role_id <>'] = '1';
	        }elseif ($this->session->userdata('user_data')->vcard_role >= '3' ) {
	        	$where['role_id >'] = '3';
	        }
	        $whereE = "(role_nama LIKE '%$q%')";
	        $result = $this->m_global->get_data_all('role', null, $where, 'role_id, role_nama', $whereE, ['role_nama', 'asc'], null , '10');

	        foreach ($result as $row){
	            $res[] = ['id' => $row->role_id, 'name' => $row->role_nama];
	        }

	        $data = ['item' => $res];
	        echo json_encode($data);
	    }else{
	        $where = [ 'role_id' => $id];

	        $result = $this->m_global->get_data_all('role', null, $where, 'role_id, role_nama', null, ['role_nama', 'asc'] , null , '10');
	        $res = [];
	        foreach ($result as $row){
	            $res[] = ['id' => $row->role_id, 'name' => $row->role_nama];
	        }
	        echo json_encode($res);
	    }
	}

	public function get_phonecode($id = '')
	{
	    if($id == ''){

	        $q = $_GET['q'];

	        $where['phonecode !='] = '';
	       
	        $whereE = "(phonecode LIKE '%$q%')";
	        $result = $this->m_global->get_data_all('country', null, $where, 'phonecode', $whereE, ['phonecode', 'asc'], null , '10','phonecode');

	        foreach ($result as $row){
	            $res[] = ['id' => $row->phonecode, 'name' => '(+'.$row->phonecode.')'];
	        }

	        $data = ['item' => $res];
	        echo json_encode($data);
	    }else{
	        $where = [ 'phonecode' => $id, 'phonecode !=' => ''];

	        $result = $this->m_global->get_data_all('country', null, $where, 'phonecode', null, ['phonecode', 'asc'] , null , '10','phonecode');
	        $res = [];
	        foreach ($result as $row){
	            $res[] = ['id' => $row->phonecode, 'name' => '(+'.$row->phonecode.')'];
	        }
	        echo json_encode($res);
	    }
	}
	
}

/* End of file universal.php */
/* Location: ./application/controllers/universal.php */