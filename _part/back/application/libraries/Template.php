<?php 
	class Template{
		
		protected $_ci;

		function __construct()
		{
			$this->_ci = &get_instance();
		}

		function display($tempBack, $data = NULL, $js = NULL, $css = NULL){
			$status_link = @$this->_ci->input->post('status_link');
			if($status_link == 'ajax'){
	            $data['_content']       = $this->_ci->load->view($tempBack, $data, TRUE);
	            $data['_js']            = $this->_ci->load->view('templates/js', $js, TRUE);
	            $data['_fullcontent']   = $this->_ci->load->view('templates/content', $data);
			}else{
				$data['_header']		 = $this->_ci->load->view('templates/header', $data, TRUE);
				$data['_content']		 = $this->_ci->load->view($tempBack, $data, TRUE);
				$data['_js']             = $this->_ci->load->view('templates/js', $js, TRUE);
				$data['_fullcontent']    = $this->_ci->load->view('templates/content', $data, TRUE);
				$data['_menu']		 	 = $this->_ci->load->view('templates/menu', $data, TRUE);
				$data['_footer']		 = $this->_ci->load->view('templates/footer', $data, TRUE);
				$data['_base']           = $this->_ci->load->view('templates/template.php', $data);
			}
		}

		// function display( $template, $data = NULL, $js = NULL, $css = NULL ) 
	 //    {
	 //        $status_link    = @$this->_ci->input->post('status_link');

	 //        if ( $status_link == 'ajax' )
	 //        {
	 //            if(@$data['manage']){
	 //                $data['_content']       = $this->_ci->load->view('project_manage_detail', $data, TRUE);
	 //            }
	 //            $data['_content']       = $this->_ci->load->view($template, $data, TRUE);
	 //            $data['_js']            = $this->_ci->load->view('templates/js', $js, TRUE);
	 //            $data['_fullcontent']   = $this->_ci->load->view('templates/content', $data);
	 //        }
	 //        else
	 //        {
	 //            $data['_page_header']   = $this->_ci->load->view('templates/page_header', $data, TRUE);
	 //            $data['_content']       = $this->_ci->load->view($template, $data, TRUE);
	 //            $data['_js']            = $this->_ci->load->view('templates/js', $js, TRUE);
	 //            $data['_fullcontent']   = $this->_ci->load->view('templates/content', $data, TRUE);
	 //            $data['_header']        = $this->_ci->load->view('templates/header', $data, TRUE);
	 //            $data['_sidebar']       = $this->_ci->load->view('templates/sidebar', $data, TRUE);
	 //            $data['_footer']        = $this->_ci->load->view('templates/footer', $data, TRUE);
	 //            $data['_base']          = $this->_ci->load->view('templates/template.php', $data);
	 //        }
	 //    }
	}
?>