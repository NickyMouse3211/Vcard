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
						Title
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="touchgallery_judul" type="text" maxlength="150" class="required form-control" placeholder="Title" />
						<span class="help-block"></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-2 control-label">
						Content
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<textarea name="touchgallery_isi" class="form-control" placeholder="Content"></textarea>
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">
						Link
					</label>
					<div class="col-md-4">
						<input name="touchgallery_link" type="text" maxlength="255" class="form-control" placeholder="Link" />
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">
						Upload foto
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
								<input type="file" class="upload" name="pu_foto" required>
								</span>
								<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">
								Remove </a>
							</div>
						</div>
						<span class="help-block">File Type: Jpg. Jpeg, Gif, Png. Max Size: 1024 KB</span>
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
       	FormValidation.initDefault(form, rule, message);
       	// FormValidation.init(form, rule, message);
		
		$('.upload').change(function(){
		    var nil     = $(this).val().split('.');
		    nil         = nil[nil.length - 1].toLowerCase();
		    var file    = $(this)[0].files[0].size;
		    var arr     = ['gif','jpg','png','jpeg'];
		    var maxsize = 1024000;
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
		});
	});	

	function formatResult(state){
	    var data = state.name;
	 
	    return data;
	}
</script>