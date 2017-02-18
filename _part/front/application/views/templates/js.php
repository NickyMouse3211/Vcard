<?php
	foreach ((array)@$custom as $key => $value) {
		echo '<script src="'.base_url('../assets/admin/pages/scripts/'.$value.'.js').'" type="text/javascript"></script>';
	}
?>