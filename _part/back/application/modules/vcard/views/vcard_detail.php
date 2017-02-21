<style type="text/css">
	.control-label-left{
		text-align: left !important;
	}
	.control-label-bold{
		font-weight: bold;
	}
</style>
<div class="portlet light">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-user font-green-sharp"></i>
			<span class="caption-subject font-green-sharp bold uppercase">Detail <?=$pagetitle?></span>
		</div>
	</div>
	<div class="portlet-body">
		<div class="form-body">
			<div class="form-horizontal">
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-md-4 control-label control-label-bold">
							Name :
						</label>
						<div class="col-md-8 control-label-left control-label">
							<?=@$records->member_nama?>
							<span class="help-block"></span>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-4 control-label control-label-bold">
							Email:
						</label>
						<div class="col-md-8 control-label-left control-label">
							<?=@$records->member_email?>
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label control-label-bold">
							Nick Name:
						</label>
						<div class="col-md-8 control-label-left control-label">
							<?=@$records->member_nick_name?>
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label control-label-bold">
							Sign :
						</label>
						<div class="col-md-8 control-label-left control-label">
							<?=@$records->member_sign?>
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label control-label-bold">
							Place of Birth :
						</label>
						<div class="col-md-8 control-label-left control-label">
							<?=@$records->member_tempat_lahir?>
							<span class="help-block"></span>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-4 control-label control-label-bold">
							Date of Birth :
						</label>
						<div class="col-md-8 control-label-left control-label">
							<?=tgl_format(strtotime(@$records->member_tanggal_lahir));?>
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label control-label-bold">
							Role :
						</label>
						<div class="col-md-8 control-label-left control-label">
							<?=role(@$records->member_role)?>
							<span class="help-block"></span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="col-md-4 control-label control-label-bold">
							Address :
						</label>
						<div class="col-md-8 control-label-left control-label">
							<?=@$records->member_alamat?>
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label control-label-bold">
							Phone :
						</label>
						<div class="col-md-8 control-label-left control-label">
							<?=@$records->member_telepon?>
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label control-label-bold">
							Guild Name :
						</label>
						<div class="col-md-8 control-label-left control-label">
							<?=@$records->member_guild_name?>
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label control-label-bold">
							Couple Name :
						</label>
						<div class="col-md-8 control-label-left control-label">
							<?=@$records->member_couple?>
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label control-label-bold">
							Upload foto :
						</label>
						<div class="col-md-8 control-label-left control-label">
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
									<img class="img-edit" src="<?php echo base_url('../public/images/member') . '/'. $records->member_pict; ?>" alt="">
								</div>
							</div>
							<span class="help-block"></span>
						</div>
					</div>
				</div>
			</div>
				
			<div class="form-actions">
				<div class="row">
					<div class="col-md-offset-11 col-md-12">
						<a href="<?=base_url($instance)?>" class="ajaxify">
							<button type="button" class="btn default">Back</button>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<a href="<?=base_url($url)?>" class="ajaxify reload" style="display: none;"></a>