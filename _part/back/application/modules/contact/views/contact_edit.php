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
						<input name="<?php echo strtolower(str_replace(' ', '_', 'Type')); ?>" value="<?=@$records->contact_type?>" maxlength="100" type="text" id="contact_type" class="required form-control" placeholder="Type" />
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">
						Value
						<span class="required" aria-required="true"> </span>
					</label>
					<div class="col-md-4">
						<input name="<?php echo strtolower(str_replace(' ', '_', 'Value')); ?>" value="<?=@$records->contact_value?>" maxlength="100" type="text" class=" form-control" placeholder="Value" />
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

       

       	$('#contact_type').select2({
       	    minimumInputLength: 0,
       	    ajax: {
       	        url: "<?=base_url('universal/get_contact_type')?>",
       	        dataType: 'json',
       	        quietMillis: 250,
       	        data: function (term, page) {
       	            return {
       	                q: term,
       	            };
       	        },
       	        results: function (data, page) {
       	            return { results: data.item };
       	        },
       	        cache: true
       	    },
       	    initSelection: function(element, callback) {
       	        var id = $(element).val();
       	        if (id !== "") {
       	            $.ajax("<?=base_url('universal/get_contact_type')?>/"+id, {
       	                dataType: "json"
       	            }).done(function(data) { callback(data[0]); });
       	        }
       	    },
       	    formatResult: function (state) {
       	        return state.name;
       	    },
       	    formatSelection:  function (state) {
       	        return state.name;
       	    }
       	});
       	
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