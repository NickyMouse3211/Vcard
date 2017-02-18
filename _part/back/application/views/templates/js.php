<?php
	foreach ((array)@$custom as $key => $value) {
		echo '<script src="'.base_url('../public/back/admin/pages/scripts/'.$value.'.js').'" type="text/javascript"></script>';
	}
?>