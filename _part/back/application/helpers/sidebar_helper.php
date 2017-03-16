<?php
	function sidebar(){
		$CI =& get_instance();

		$dashboard = ['name' => 'Dashboar', 'link' => 'dashboard', 'icon' => 'home', 'controller' => 'dashboard'];

			$user  = ['name' => 'User Vcard'	, 'link' => 'vcard'	, 'icon' => 'user'		, 'controller' => 'vcard'];
			$map  = ['name' => 'User MAP'	, 'link' => 'map'	, 'icon' => 'location-pin'		, 'controller' => 'map'];
		$master    = ['name' => 'Master User'	, 'link' => [$user,$map]	, 'icon' => 'settings'	, 'controller' => 'master'];

			$touchtouch  	= ['name' => 'Touch'		, 'link' => 'touch'			, 'icon' => 'book-open'	, 'controller' => 'touch'];
			$touchartikel  	= ['name' => 'Article'		, 'link' => 'touch/article'	, 'icon' => 'book-open'	, 'controller' => 'touch_artikel'];
			$touchgallery  	= ['name' => 'Gallery'		, 'link' => 'touch/gallery'	, 'icon' => 'picture'	, 'controller' => 'touch_gallery'];
		$touch     			= ['name' => 'Touch Data'	, 'link' => [$touchtouch,$touchartikel,$touchgallery], 'icon' => 'arrow-right', 'controller' => 'touch'];

			$vcardvcard  	= ['name' => 'vcard'		, 'link' => 'vcard'			, 'icon' => 'book-open'	, 'controller' => 'vcard'];
			$vcardartikel  = ['name' => 'Article'		, 'link' => 'vcard/article'	, 'icon' => 'book-open'	, 'controller' => 'vcard_artikel'];
			$vcardgallery  = ['name' => 'Gallery'		, 'link' => 'vcard/gallery'	, 'icon' => 'picture'	, 'controller' => 'vcard_gallery'];
		$vcard     		= ['name' => 'vcard Data'	, 'link' => [$vcardvcard,$vcardartikel,$vcardgallery], 'icon' => 'social-facebook', 'controller' => 'vcard'];

		$developer     		= ['name' => 'Developer'	, 'link' => 'developer'	, 'icon' => 'ghost'		, 'controller' => 'developer'];
		$report     		= ['name' => 'Report'		, 'link' => 'report'	, 'icon' => 'notebook'	, 'controller' => 'report'];

		
		$menu = [ 
			// $dashboard, 
			$master,
			// $vcard
		];
		

		return $menu;
	}
?>