<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	$CI = &get_instance();
	$CI->load->library('session');

	$ex 			= array('login');

	$user_data 		= $CI->session->userdata('user_data');

    $status_link    = @$CI->input->post('status_link');

	if ( !empty( $user_data ) 
		AND 
		( 
			( in_array( $this->uri->segment(1), $ex ) 
			AND 
			$this->uri->segment(2) != "out" )  
		OR 
		$this->uri->segment(1) == "") 
		)
	{
		redirect(base_url('dashboard'));
	}
		else if ( empty($user_data) AND !in_array($this->uri->segment(1), $ex) ) 
	{
		if ( $status_link == 'ajax' )
		{
			echo 'out';
			die();
		}
			else
		{
			redirect( base_url('login') );
		}
	}