<div class="portlet light">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-phone font-green-sharp"></i>
			<span class="caption-subject font-green-sharp bold uppercase">Edit <?=$pagetitle?></span>
		</div>
	</div>
	<div class="portlet-body">
		<form data-confirm="1" method="POST" action="<?=base_url($instance.'/action_edit/'.$id)?>" class="form-horizontal form-add" role="form">
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
						<select name="<?php echo strtolower(str_replace(' ', '_', 'Type')); ?>" class="required form-control" placeholder="Type">
							<option value="employment" <?=@$records->resume_type == 'employment' ? 'selected' : ''?>>Employment</option>
							<option value="education" <?=@$records->resume_type == 'education' ? 'selected' : ''?>>Education</option>
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
						<input name="<?php echo strtolower(str_replace(' ', '_', 'Position')); ?>" value="<?=@$records->resume_position?>" maxlength="50" type="text" class="required form-control" placeholder="Position" />
						<span class="help-block"></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-2 control-label">
						Sub Position
						<span class="required" aria-required="true"> </span>
					</label>
					<div class="col-md-4">
						<input name="<?php echo strtolower(str_replace(' ', '_', 'Sub')); ?>" value="<?=@$records->resume_sub?>" maxlength="50" type="text" class=" form-control" placeholder="Sub Position" />
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">
						Period
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="<?php echo strtolower(str_replace(' ', '_', 'From')); ?>" value="<?=explode(' - ',@$records->resume_period)[0]?>"  type="text" class="required form-control year-picker" placeholder="From" />
						<span class="help-block"></span>
					</div>
					<div class="col-md-4">
						<input name="<?php echo strtolower(str_replace(' ', '_', 'To')); ?>" value="<?=explode(' - ',@$records->resume_period)[1]?>"  type="text" class="required form-control year-picker" placeholder="To" />
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">
						Description
						<span class="required" aria-required="true"> </span>
					</label>
					<div class="col-md-4">
						<textarea name="<?php echo strtolower(str_replace(' ', '_', 'Description')); ?>" class=" form-control" placeholder="Description"><?=@$records->resume_description?></textarea>
						<span class="help-block"></span>
					</div>
				</div>
			</div>
			<div class="form-actions">
				<div class="row">
					<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn green">Submit</button>
						<a href="<?=base_url($instance)?>" class="ajaxify">
							<button type="button" class="btn default">Back</button>
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
		
      	var rule = {
      		
      	};
       	var message = {};
       	var form = '.form-add';
       	
       	var title = 'Are You Sure want to Confirm Data?';
       	var text = 'Your data will submit?';
       	var BANoption = { 
       					};
       	FormValidation.initDefault(form, rule, message, title, text, BANoption);

       	// Input mask, format nominal

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