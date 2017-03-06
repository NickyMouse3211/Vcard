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
						Link
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="<?php echo strtolower(str_replace(' ', '_', 'Link')); ?>" type="text" maxlength="100" class="required form-control" placeholder="Link" />
						<span class="help-block"></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-2 control-label">
						Name
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="<?php echo strtolower(str_replace(' ', '_', 'Name')); ?>" maxlength="50" type="text" class="required form-control" placeholder="Name" />
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">
						Work
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="<?php echo strtolower(str_replace(' ', '_', 'Work')); ?>" maxlength="100" type="text" class="required form-control" placeholder="Work" />
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">
						DO Birth
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="<?php echo strtolower(str_replace(' ', '_', 'DO Birth')); ?>" maxlength="15" type="text" class="required form-control" placeholder="DO Birth" />
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">
						Address
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<textarea name="<?php echo strtolower(str_replace(' ', '_', 'Address')); ?>" class="required form-control" placeholder="Address"></textarea>
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">
						Email
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="<?php echo strtolower(str_replace(' ', '_', 'Email')) ?>" maxlength="100" type="email" class="required form-control" placeholder="Email" />
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">
						Password
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="password" id='password' maxlength="255" type="password" class="required form-control" placeholder="Password" />
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">
						Re-Password
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="re_password" maxlength="255" type="password" class="required form-control" placeholder="Password" />
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">
						Phone
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="<?php echo strtolower(str_replace(' ', '_', 'Phone')); ?>" maxlength="15" type="text" class="required form-control" placeholder="Phone" />
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">
						Website
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="<?php echo strtolower(str_replace(' ', '_', 'Website')); ?>" maxlength="15" type="text" class="required form-control" placeholder="Website" />
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">
						Description
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<textarea name="<?php echo strtolower(str_replace(' ', '_', 'Description')); ?>" class="required form-control" placeholder="Description"></textarea>
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">
						Role
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="<?php echo strtolower('Link') ?>" type="text" id="ROLE" class="form-control" placeholder="Role" />
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">
						Photo
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<div class="fileinput fileinput-new" data-provides="fileinput">
							<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
								<img class="img-edit" src="<?=base_url("../public/images")?>/anonim.png" alt="">
							</div>
							<div>
								<span class="btn default btn-file">
								<span class="fileinput-new">
								Select image </span>
								<span class="fileinput-exists">
								Change </span>
								<input type="file" class="upload" name="pu_foto">
								</span>
								<a href="javascript:;" class="btn red fileinput-exists file-remove" data-dismiss="fileinput">
								Remove </a>
							</div>
						</div>
						<span class="help-block">
							File Type: Jpg. Jpeg, Gif, Png. Max Size: 1024 KB , Potrait , max size 1024 KB
						</span>
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

	$('.upload').change(function(){
		var _URL    = window.URL || window.webkitURL;
		var nil     = $(this).val().split('.');
		nil         = nil[nil.length - 1].toLowerCase();
		var file    = $(this)[0].files[0].size;
		var arr     = ['gif','jpg','png','jpeg'];
		var width   = null;
		var height  = null;
		var maxsize = 1024000;
		var img     = new Image();

	    if (arr.indexOf(nil) < 0)
	    {
	    	$('.img-edit').attr('src','<?=base_url("../public/images")?>/anonim.png');
	        $(this).val('');
	        toastr.error('File type does not fit !');
	    }
	    if (file > maxsize)
	    {
	    	$('.img-edit').attr('src','<?=base_url("../public/images")?>/anonim.png');
	        $(this).val('');
	        toastr.error('File size is too large !');
	    }
		
		img.onload  = function () {
			width   = $(this)[0].width;
			height  = $(this)[0].height;
			if (height < width) {
				$('.img-edit').attr('src','<?=base_url("../public/images")?>/anonim.png');
			    $(this).val('');
			    toastr.error('file instead of portrait !');
			    $('.file-remove').click();
			}
        };
        img.src = _URL.createObjectURL($(this)[0].files[0]);	    
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