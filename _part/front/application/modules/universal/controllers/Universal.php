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
	
}

/* End of file universal.php */
/* Location: ./application/controllers/universal.php */