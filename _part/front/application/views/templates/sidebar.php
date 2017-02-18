<div class="page-sidebar-wrapper">
	<div class="page-sidebar navbar-collapse collapse">
		<ul class="page-sidebar-menu page-sidebar-menu-hover-submenu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
			<?
				$menu = menu();
				$url = $this->uri->segment(1) == '' ? 'dashboard' : $this->uri->segment(1);
				$sub_url = $this->uri->segment(2);
				foreach ($menu as $key => $value) {
					echo '<li '.((is_array($value['controller']) && in_array($url, $value['controller'])) || $value['controller'] == $url? 'class ="start active"' : '').'>
						<a '.(is_array($value['link']) ? 'href="javascript:;"' : 'class="ajaxify" href="'.base_url($value['link']).'"').'">
						<i class="icon-'.$value['icon'].'"></i>
						<span class="title">'.$value['name'].'</span>
						'.($key == 0 ? '<span class="selected"></span>' : '').
						(is_array($value['link']) ? '<span class="arrow "></span>' : '').'
						</a>';
						if(is_array($value['link'])){
							echo '<ul class="sub-menu">';
							foreach ($value['link'] as $kSub => $kValue) {
								echo '<li '.($kValue['controller'] == $sub_url && $value['controller'] == $url ? 'class="active"' : '').'>
									<a href="'.base_url($kValue['link']).'" class="ajaxify">
									<i class="'.$kValue['icon'].'"></i>
									'.$kValue['name'].'
									</a>
								</li>';
							}
							echo '</ul>';
						}
					echo '</li>';
				}
			?>
		</ul>
		<!-- END SIDEBAR MENU -->
	</div>
</div>