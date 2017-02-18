<?php 
	// CSS
	function get_css($css){
		switch ($css) {
			case 'sweet-alert':
				echo "<link href='".base_url('../public/back/global/plugins/sweet-alert/sweet-alert.css')."' rel='stylesheet' type='text/css' />";
			break;

			case 'datatables':
				echo "<link href='".base_url('../public/back/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')."' rel='stylesheet' type='text/css' />";
			break;

			case 'select2':
				echo "<link href='".base_url('../public/back/global/plugins/select2/select2.css')."' rel='stylesheet' type='text/css' />";
			break;

			case 'daterangepicker':
				echo "<link href='".base_url('../public/back/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css')."' rel='stylesheet' type='text/css' />";
			break;

			case 'datepickers':
				echo "<link href='".base_url('../public/back/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')."' rel='stylesheet' type='text/css' />";
			break;

			case 'bootstrap-select':
				echo "<link href='".base_url('../public/back/global/plugins/bootstrap-select/bootstrap-select.min.css')."' rel='stylesheet' type='text/css' />";
			break;
			
			case 'custom':
				echo "<link href='".base_url('../public/back/admin/layout4/css/custom.css')."' rel='stylesheet' type='text/css' />";
			break;

			case 'file-input':
				echo "<link href='".base_url('../public/back/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')."' rel='stylesheet' type='text/css' />";
			break;

			case 'toastr':
				echo "<link href='".base_url('../public/back/global/plugins/bootstrap-toastr/toastr.css')."' rel='stylesheet' type='text/css' />";
			break;

			case 'profile':
				echo "<link href='".base_url('../public/back/admin/pages/css/profile.css')."' rel='stylesheet' type='text/css' />";
			break;

			case 'pagination':
				echo "<link href='".base_url('../public/css/jqpagination.css')."' rel='stylesheet' type='text/css' />";
			break;

			case 'custombox':
				echo "<link href='".base_url('../public/css/modal/custombox.css')."' rel='stylesheet' type='text/css' />";
			break;
		}
	}

	// JS
	function get_js($js){
		switch ($js) {
			case 'sweet-alert':
				echo '<script src="'.base_url('../public/back/global/plugins/sweet-alert/sweet-alert.min.js').'" type="text/javascript"></script>';
			break;

			case 'datatables':
				echo '<script src="'.base_url('../public/back/global/plugins/datatables/media/js/jquery.dataTables.min.js').'" type="text/javascript"></script>';
				echo '<script src="'.base_url('../public/back/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js').'" type="text/javascript"></script>';
				echo '<script src="'.base_url('../public/back/global/scripts/datatable.js').'" type="text/javascript"></script>';
			break;

			case 'select2':
				echo '<script src="'.base_url('../public/back/global/plugins/select2/select2.js').'" type="text/javascript"></script>';
			break;

			case 'daterangepicker':
				echo '<script src="'.base_url('../public/back/global/plugins/bootstrap-daterangepicker/moment.min.js').'" type="text/javascript"></script>';
				echo '<script src="'.base_url('../public/back/global/plugins/bootstrap-daterangepicker/daterangepicker.js').'" type="text/javascript"></script>';
			break;

			case 'datepickers':
				echo '<script src="'.base_url('../public/back/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js').'" type="text/javascript"></script>';
			break;

			case 'bootstrap-select':
				echo '<script src="'.base_url('../public/back/global/plugins/bootstrap-select/bootstrap-select.min.js').'" type="text/javascript"></script>';
			break;

			case 'toastr':
				echo '<script src="'.base_url('../public/back/global/plugins/bootstrap-toastr/toastr.js').'" type="text/javascript"></script>';
			break;

			case 'file-input':
				echo '<script src="'.base_url('../public/back/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js').'" type="text/javascript"></script>';
			break;

			case 'validation':
				echo '<script src="'.base_url('../public/back/global/plugins/jquery-validation/js/jquery.validate.min.js').'" type="text/javascript"></script>';
			break;

			case 'profile':
				echo '<script src="'.base_url('../public/back/admin/pages/scripts/profile.js').'" type="text/javascript"></script>';
			break;

			case 'pagination':
				echo '<script src="'.base_url('../public/js/jquery.jqpagination.js').'" type="text/javascript"></script>';
			break;

			case 'custombox':
				echo '<script src="'.base_url('../public/js/modal/custombox.js').'" type="text/javascript"></script>';
			break;
		}
	}
?>