<?php
	function sidebar(){
		$CI =& get_instance();

		$dashboard = ['name' => 'Dashboar', 'link' => 'dashboard', 'icon' => 'home', 'controller' => 'dashboard'];

			$user  = ['name' => 'Member'		, 'link' => 'user'	, 'icon' => 'user'		, 'controller' => 'user'];
		$master    = ['name' => 'Master Data'	, 'link' => [$user]	, 'icon' => 'settings'	, 'controller' => 'master'];

			$touchtouch  	= ['name' => 'Touch'		, 'link' => 'touch'			, 'icon' => 'book-open'	, 'controller' => 'touch'];
			$touchartikel  	= ['name' => 'Article'		, 'link' => 'touch/article'	, 'icon' => 'book-open'	, 'controller' => 'touch_artikel'];
			$touchgallery  	= ['name' => 'Gallery'		, 'link' => 'touch/gallery'	, 'icon' => 'picture'	, 'controller' => 'touch_gallery'];
		$touch     			= ['name' => 'Touch Data'	, 'link' => [$touchtouch,$touchartikel,$touchgallery], 'icon' => 'arrow-right', 'controller' => 'touch'];

			$fiercefierce  	= ['name' => 'Fierce'		, 'link' => 'fierce'			, 'icon' => 'book-open'	, 'controller' => 'fierce'];
			$fierceartikel  = ['name' => 'Article'		, 'link' => 'fierce/article'	, 'icon' => 'book-open'	, 'controller' => 'fierce_artikel'];
			$fiercegallery  = ['name' => 'Gallery'		, 'link' => 'fierce/gallery'	, 'icon' => 'picture'	, 'controller' => 'fierce_gallery'];
		$fierce     		= ['name' => 'Fierce Data'	, 'link' => [$fiercefierce,$fierceartikel,$fiercegallery], 'icon' => 'social-facebook', 'controller' => 'fierce'];

		$developer     		= ['name' => 'Developer'	, 'link' => 'developer'	, 'icon' => 'ghost'		, 'controller' => 'developer'];
		$report     		= ['name' => 'Report'		, 'link' => 'report'	, 'icon' => 'notebook'	, 'controller' => 'report'];

		if ($CI->session->userdata('user_data')->member_role == '1') {
			$menu = [ 
				$dashboard, 
				$master,
				$touch,
				$fierce,
				$developer,
				$report
			];
		}elseif ($CI->session->userdata('user_data')->member_role == '2' || $CI->session->userdata('user_data')->member_role == '3') {
			$menu = [ 
				$dashboard, 
				$master,
				$touch,
				$fierce
			];
		}else{
			$menu = [ 
				$dashboard, 
				$master,
				$fierce
			];
		}
		

		return $menu;
	}
?>