<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Errorr extends MX_Controller {

    private $prefix         = 'error';

	function __construct() {
        parent::__construct();
    }

    public function index()
    {
            header('HTTP/1.1 404 Not Found');
            $this->load->view('404');
    }

	public function error_404()
	{
        $data['pagetitle']  = 'Error';
        $data['instance']	= $this->prefix;
        $data['breadcrumb'] = ['Error' => $this->prefix.'/error_404'];
        $js['custom']       = [];
		
        $data['url']        = $this->input->post('url');
        $data['url1']       = $this->input->post('url1');

        $this->template->display($this->prefix.'_404', $data);
	}
}

