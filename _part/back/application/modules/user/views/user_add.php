<div class="portlet light">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-user font-green-sharp"></i>
			<span class="caption-subject font-green-sharp bold uppercase">Add <?=$pagetitle?></span>
		</div>
	</div>
	<div class="portlet-body">
		<form method="POST" action="<?=base_url($instance.'/action_add')?>" class="form-horizontal form-add" role="form" >
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
						Name
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="member_nama" type="text" maxlength="50" class="required form-control" placeholder="User Name" />
						<span class="help-block"></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-2 control-label">
						Email
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="member_email" maxlength="100" type="text" class="required form-control" placeholder="User Email" />
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">
						Password
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="member_password" id='member_password' maxlength="255" type="password" class="required form-control" placeholder="Password User" />
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">
						Re-Password
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="re_password" maxlength="255" type="password" class="required form-control" placeholder="Password User" />
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">
						Role
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="member_role" type="text" id="ROLE" class="form-control" placeholder="Role" />
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
      		member_email: {
      			email : true,
      		},
      		re_password: {
			equalTo: "#member_password",
			}
      	};
       	var message = {};
       	var form = '.form-add';
       	FormValidation.initDefault(form, rule, message);
       	// FormValidation.init(form, rule, message);
       	$('#ROLE').select2({
       	    minimumInputLength: 0,
       	    ajax: {
       	        url: "<?=base_url('universal/get_role')?>",
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
       	            $.ajax("<?=base_url('universal/get_role')?>"+id, {
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