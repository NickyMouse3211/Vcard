<style>
  .cropit-preview {
    background-color: #f8f8f8;
    background-size: cover;
    border: 5px solid #ccc;
    border-radius: 3px;
    margin-top: 7px;
    width: 153px;
    height: 186px;
  }

  .cropit-preview-image-container {
    cursor: move;
  }

  .cropit-preview-background {
    opacity: .2;
    cursor: auto;
  }

  .image-size-label {
    margin-top: 10px;
  }

  input, .export {
    /* Use relative position to prevent from being covered by image background */
    position: relative;
    z-index: 10;
    display: block;
  }

  button {
    margin-top: 10px;
  }
</style>
<div class="portlet light">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-map-marker font-green-sharp"></i>
			<span class="caption-subject font-green-sharp bold uppercase">Edit <?=$pagetitle?></span>
		</div>
	</div>
	<div class="portlet-body">
		<form data-confirm="1" method="POST" action="<?=base_url($instance.'/action_edit/')?>" class="form-horizontal form-add" role="form">
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
						Role
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="<?php echo strtolower('negara_id') ?>" value="<?=@$records->map_negara_id?>" type="text" id="country" class="form-control" placeholder="Role" />
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">
						Address
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<textarea name="<?php echo strtolower(str_replace(' ', '_', 'full')); ?>" class="required form-control" placeholder="Address"><?=@$records->map_full?></textarea>
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
		
		// Fungsi Form Validasi
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

       	$('#country').select2({
       	    minimumInputLength: 0,
       	    ajax: {
       	        url: "<?=base_url('universal/get_country')?>",
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
       	            $.ajax("<?=base_url('universal/get_country')?>/"+id, {
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