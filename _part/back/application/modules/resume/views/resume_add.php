<div class="portlet light">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-phone font-green-sharp"></i>
			<span class="caption-subject font-green-sharp bold uppercase">Add <?=$pagetitle?></span>
		</div>
	</div>
	<div class="portlet-body">
		<form method="POST" action="<?=base_url($instance.'/action_add')?>" class="form-horizontal form-add" role="form" enctype="multipart/form-data">
			<input type="hidden" name="ex_csrf_token" value="<?= csrf_get_token(); ?>">
			<div class="alert alert-danger display-hide">
				<button class="close" data-close="alert"></button>
				<span>You have some form errors. Please check below.</span>
			</div>
			<div class="alert alert-warning display-hide">
				<button class="close" data-close="alert"></button>
				<span>Your form validation is successful!</span>
			</div>
			<div class="form-body">
				
				<div class="form-group">
					<label class="col-md-2 control-label">
						Type
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<select name="<?php echo strtolower(str_replace(' ', '_', 'Type')); ?>"  class="required form-control" placeholder="Type">
							<option value="employment">Employment</option>
							<option value="education">Education</option>
						</select>
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">
						Position
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="<?php echo strtolower(str_replace(' ', '_', 'Position')); ?>" maxlength="50" type="text" class="required form-control" placeholder="Position" />
						<span class="help-block"></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-2 control-label">
						Sub Position
						<span class="required" aria-required="true"> </span>
					</label>
					<div class="col-md-4">
						<input name="<?php echo strtolower(str_replace(' ', '_', 'Sub')); ?>" maxlength="50" type="text" class=" form-control" placeholder="Sub Position" />
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">
						Period
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="<?php echo strtolower(str_replace(' ', '_', 'Period')); ?>"  type="text" class="required form-control" placeholder="Period" />
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">
						Description
						<span class="required" aria-required="true"> </span>
					</label>
					<div class="col-md-4">
						<textarea name="<?php echo strtolower(str_replace(' ', '_', 'Description')); ?>" class=" form-control" placeholder="Description"></textarea>
						<span class="help-block"></span>
					</div>
				</div>

			</div>
			<div class="form-actions">
				<div class="row">
					<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn green submit">Submit</button>
						<a href="<?=base_url($instance)?>" class="ajaxify">
							<button type="button" class="btn default back">Back</button>
						</a>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<a href="<?=base_url($url)?>" class="ajaxify reload" style="display: none;"></a>
<script>
	jQuery(document).ready(function() {

		// Fungsi Form Validasi
      	var rule = {
      		
      	};
       	var message = {};
       	var form = '.form-add';

       	var BANoption = { 
       						
       					};
       	FormValidation.initDefault(form, rule, message, null, null, BANoption);
       	// FormValidation.init(form, rule, message);

	});

	function isNumber(evt) {
	    evt = (evt) ? evt : window.event;
	    var charCode = (evt.which) ? evt.which : evt.keyCode;
	    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
	        return false;
	    }
	    return true;
	}

	function formatResult(state){
	    var data = state.name;
	 
	    return data;
	}
</script>