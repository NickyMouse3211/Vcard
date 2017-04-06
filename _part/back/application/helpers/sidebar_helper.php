<?php
	function sidebar(){
		$CI =& get_instance();

		$dashboard 		= ['name' => 'Dashboar', 'link' => 'dashboard', 'icon' => 'home', 'controller' => 'dashboard'];
		$master_card 	= ['name' => 'Master Card'	, 'link' => 'vcard'	, 'icon' => 'credit-card'		, 'controller' => 'vcard'];

			$map  		= ['name' => 'My MAP'	, 'link' => 'map'	, 'icon' => 'location-pin'		, 'controller' => 'map'];
			$contact  	= ['name' => 'My Contact'	, 'link' => 'contact'	, 'icon' => 'call-end'		, 'controller' => 'contact'];

		$myContact    	= ['name' => 'Master Contact'	, 'link' => [$map,$contact]	, 'icon' => 'book-open'	, 'controller' => 'master'];

			$resume  	= ['name' => 'My Resume'	, 'link' => 'resume'	, 'icon' => 'notebook'		, 'controller' => 'resume'];
			$groupSkill	= ['name' => 'Group Skill'	, 'link' => 'group_skill'	, 'icon' => 'star'		, 'controller' => 'group_skill'];
			$skill		= ['name' => 'Skill'	, 'link' => 'skill'	, 'icon' => 'target'		, 'controller' => 'skill'];

		$myResume    = ['name' => 'Master Resume'	, 'link' => [$resume,$skill]	, 'icon' => 'graduation'	, 'controller' => 'master_resume'];


		
		$menu = [ 
			// $dashboard, 
			$master_card,
			$myResume,
			$myContact,
			// $vcard
		];
		

		return $menu;
	}
?>