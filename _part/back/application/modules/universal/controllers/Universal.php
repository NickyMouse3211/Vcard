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
	        	$where['role_id >='] = '3';
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

	public function get_country($id = '')
	{
	    if($id == ''){

	        $q = $_GET['q'];

	        $where['iso !='] = '';
	       
	        $whereE = "(name LIKE '%$q%')";
	        $result = $this->m_global->get_data_all('country', null, $where, 'iso,name', $whereE, ['name', 'asc'], null , '10','iso');

	        foreach ($result as $row){
	            $res[] = ['id' => $row->iso, 'name' => $row->name];
	        }

	        $data = ['item' => $res];
	        echo json_encode($data);
	    }else{
	        $where = [ 'iso' => $id, 'iso !=' => ''];

	        $result = $this->m_global->get_data_all('country', null, $where, 'iso,name', null, ['name', 'asc'] , null , '10','iso');
	        $res = [];
	        foreach ($result as $row){
	            $res[] = ['id' => $row->iso, 'name' => $row->name];
	        }
	        echo json_encode($res);
	    }
	}

	public function get_contact_type($id = '')
	{
	    if($id == ''){

	        $q = $_GET['q'];

	        $where[] = '';
	        
	        $whereE = "(contact_type LIKE '%$q%')";
	        $result = $this->m_global->get_data_all('contact', null, $where, 'contact_type', $whereE, ['contact_type', 'asc'], null , '10','contact_type');
	       
	        foreach ($result as $row){
	            $res[] = ['id' => $row->contact_type, 'name' => $row->contact_type];
	        }
	        if ($q != '' || $q != null) {
	        	$res[] = ['id' => $q, 'name' => $q];
	        }
	        
	        $data = ['item' => $res];
	        echo json_encode($data);
	    }else{
	        $where = [ 'contact_type' => $id];

	        $result = $this->m_global->get_data_all('contact', null, $where, 'contact_type', null, ['contact_type', 'asc'] , null , '10','contact_type');
	        $res = [];
	        foreach ($result as $row){
	            $res[] = ['id' => $row->contact_type, 'name' => $row->contact_type];
	        }
	        echo json_encode($res);
	    }
	}
	
}

/* End of file universal.php */
/* Location: ./application/controllers/universal.php */