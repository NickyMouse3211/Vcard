<div class="portlet light">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-user font-green-sharp"></i>
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
						Name
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="member_nama" type="text" value="<?=$records->member_nama?>" maxlength="50" class="required form-control" placeholder="User Name" required/>
						<span class="help-block"></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-2 control-label">
						Email
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="member_email" maxlength="100" value="<?=$records->member_email?>" type="text" class="required form-control" placeholder="User Email" required/>
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">
						Nick Name
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="member_nick_name" type="text" value="<?=$records->member_nick_name?>" maxlength="15" class=" form-control" placeholder="Nick Name" required/>
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">
						Sign
					</label>
					<div class="col-md-4">
						<textarea name="member_sign" class="form-control" placeholder="Sign"><?=$records->member_sign?></textarea>
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">
						Place of Birth
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="member_tempat_lahir" type="text" value="<?=$records->member_tempat_lahir?>" maxlength="50" class=" form-control" placeholder="Place of Birth" required/>
						<span class="help-block"></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-2 control-label">
						Date of Birth
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="member_tanggal_lahir" type="text" value="<?=date('Y-m-d', strtotime(@$records->member_tanggal_lahir));?>" class="form-control datepicker" placeholder="Date of Birth" required/>
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">
						Address
					</label>
					<div class="col-md-4">
						<textarea name="member_alamat" class="form-control" placeholder="Address"><?=$records->member_alamat?></textarea>
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">
						Phone
					</label>
					<div class="col-md-4">
						<input name="member_telepon" maxlength="20" type="text" value="<?=$records->member_telepon?>" onkeypress="return isNumber(event)" class="form-control" placeholder="User Phone" />
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">
						Guild Name
					</label>
					<div class="col-md-4">
						<input name="member_guild_name" maxlength="20" type="text" value="<?=$records->member_guild_name?>"  class="form-control" placeholder="Guild Name" />
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">
						Couple Name
					</label>
					<div class="col-md-4">
						<input name="member_couple" maxlength="20" type="text" value="<?=$records->member_couple?>"  class="form-control" placeholder="Couple Nick Name" />
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
								<img class="img-edit" src="<?php echo base_url('../public/images/member') . '/'. $records->member_pict; ?>" alt="">
							</div>
							<div>
								<span class="btn default btn-file">
								<span class="fileinput-new">
								Select image </span>
								<span class="fileinput-exists">
								Change </span>
								<input type="file" class="upload" name="pu_foto">
								</span>
								<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">
								Remove </a>
							</div>
						</div>
						<span class="help-block">File Type: Jpg. Jpeg, Gif, Png. Max Size: 1024 KB</span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">
						Password
						<!-- <span class="required" aria-required="true">* </span> -->
					</label>
					<div class="col-md-4">
						<input name="member_password" id='member_password' maxlength="255" type="password" class="form-control" placeholder="Password User" />
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">
						Re-Password
						<!-- <span class="required" aria-required="true">* </span> -->
					</label>
					<div class="col-md-4">
						<input name="re_password" maxlength="255" type="password" class="form-control" placeholder="Password User" />
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label">
						Role
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-4">
						<input name="member_role" id="ROLE" type="text" value="<?=$records->member_role?>"  class="form-control" placeholder="Role" required/>
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
      		member_phone: {
      		  numeric: true,
      		},
      		member_email: {
      			email : true,
      		},
      		re_password: {
			equalTo: "#member_password",
			}
      	};
       	var message = {};
       	var form = '.form-add';
       	
       	var title = 'Are You Sure want to Confirm Data?';
       	var text = 'Your data will submit?';

       	FormValidation.initDefault(form, rule, message, title, text);

       	// Input mask, format nominal

       	$('.datepicker').datepicker({
       	    rtl: Metronic.isRTL(),
       	    orientation: "left",
       	    dateFormat: 'yy-mm-dd',
       	    autoclose: true
       	});

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
       	            $.ajax("<?=base_url('universal/get_role')?>/"+id, {
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