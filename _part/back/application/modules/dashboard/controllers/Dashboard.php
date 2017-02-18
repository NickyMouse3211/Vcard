<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MX_Controller {

    private $prefix         = 'dashboard';

	function __construct() {
        parent::__construct();
    }

	public function index()
	{
        $data['pagetitle']  = 'Dashboard';
        $data['instance']	= $this->prefix;
        $data['breadcrumb'] = ['Dashboard' => $this->prefix.'/i_index'];
        $js['custom']       = ['index', 'tasks'];
		
        $this->template->display($this->prefix, $data, $js);
	}

	function i_index()
	{
        $data['pagetitle']  = 'Dashboard';
        $data['instance']	= $this->prefix;
        $data['breadcrumb'] = ['Dashboard' => $this->prefix.'/i_index'];
        $js['custom']       = ['index', 'tasks'];

        $this->template->display($this->prefix, $data, $js);
	}
}

