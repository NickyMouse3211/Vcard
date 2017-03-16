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
			<i class="fa fa-user font-green-sharp"></i>
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
						Link
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="<?php echo strtolower(str_replace(' ', '_', 'Link')); ?>" type="text" maxlength="100" id="link" class="required form-control link" placeholder="Link" />
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
						<span class="required" aria-required="true"> </span>
					</label>
					<div class="col-md-4">
						<input name="<?php echo strtolower(str_replace(' ', '_', 'Work')); ?>" maxlength="100" type="text" class=" form-control" placeholder="Work" />
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">
						DO Birth
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="<?php echo strtolower(str_replace(' ', '_', 'DO Birth')); ?>" maxlength="15" type="text" class="required form-control date-picker" placeholder="DO Birth" />
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
						<input name="<?php echo strtolower(str_replace(' ', '_', 'Email')) ?>" maxlength="100" type="email" class="required form-control email" placeholder="Email" />
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
						<span class="required" aria-required="true"> </span>
					</label>
					<div class="col-md-2">
						<input name="<?php echo strtolower(str_replace(' ', '_', 'country')); ?>" maxlength="3" type="text" id="code" class=" form-control number" placeholder="Kode" />
					</div>
					<div class="col-md-4">
						<input name="<?php echo strtolower(str_replace(' ', '_', 'Phone')); ?>" maxlength="15" type="text" class=" form-control number" placeholder="Phone" />
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">
						Website
						<span class="required" aria-required="true"> </span>
					</label>
					<div class="col-md-4">
						<input name="<?php echo strtolower(str_replace(' ', '_', 'Website')); ?>" maxlength="15" type="text" class=" form-control" placeholder="Website" />
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

				<div class="form-group">
					<label class="col-md-2 control-label">
						Role
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="<?php echo strtolower('role') ?>" type="text" id="ROLE" class="form-control" placeholder="Role" />
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">
						Photo
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-10">
						<div class="image-editor fileinput fileinput-new" data-provides="fileinput">
						  <div>
						  	<span class="btn default btn-file">
						  	<span class="fileinput-new">
						  	Select image </span>
						  	<span class="fileinput-exists">
						  	Change </span>
						  	<input type="file" class="upload cropit-image-input" name="pu_foto" onchange="$('#img-edit').hide();">
						  	<input type="text" name="filebase64" id='hidden_base64' readonly hidden>
						  	</span>
						  	<a href="javascript:;" class="btn blue rotate-cw">
						  	Rotate counterclockwise </a>
						  	<a href="javascript:;" class="btn blue rotate-ccw">
						  	Rotate clockwise </a>

						  </div>
						  <div class="cropit-preview">
						  	<img class="img-edit" id='img-edit' src="<?=base_url("../public/images")?>/anonim.png" alt="" style="width: 145px; height: 150px;">
						  </div>
						  <div class="image-size-label" >
						    Resize image
						  </div>
						  <input type="range" class="cropit-image-zoom-input col-md-2">
						</div>

						<span class="help-block">
							File Type: Jpg. Jpeg, Gif, Png. Max Size: 1024 KB 
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

		$('.image-editor').cropit({
		  exportZoom: 1,
		  imageBackground: true,
		  imageBackgroundBorderWidth: 20,
		  
		});

		$('.rotate-cw').click(function() {
		  $('.image-editor').cropit('rotateCW');
		});
		$('.rotate-ccw').click(function() {
		  $('.image-editor').cropit('rotateCCW');
		});
		// Fungsi Form Validasi
      	var rule = {
      		member_email: {
      			email : true,
      		},
      		re_password: {
				equalTo: "#password",
			}
      	};
       	var message = {};
       	var form = '.form-add';

       	var BANoption = { 
       						cropit: {
       							'class'  		: '.image-editor',
       							'action' 		: 'export',
       							'type'	 		: 'image/jpeg',
       							'quality'		: 0.33,
       							'originalSize' 	: true,
       							'hiddenForm'	: '#hidden_base64'
       						}, 
       					};
       	FormValidation.initDefault(form, rule, message, null, null, BANoption);
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

       	$('#code').select2({
       	    minimumInputLength: 0,
       	    ajax: {
       	        url: "<?=base_url('universal/get_phonecode')?>",
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
       	            $.ajax("<?=base_url('universal/get_phonecode')?>"+id, {
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
	    // if (file > maxsize)
	    // {
	    // 	$('.img-edit').attr('src','<?=base_url("../public/images")?>/anonim.png');
	    //     $(this).val('');
	    //     toastr.error('File size is too large !');
	    // }
		
		// img.onload  = function () {
		// 	width   = $(this)[0].width;
		// 	height  = $(this)[0].height;
		// 	if (height < width) {
		// 		$('.img-edit').attr('src','<?php // echo base_url("../public/images")?>/anonim.png');
		// 	    $(this).val('');
		// 	    toastr.error('file instead of portrait !');
		// 	    $('.file-remove').click();
		// 	}
  //       };
  //       img.src = _URL.createObjectURL($(this)[0].files[0]);	    
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