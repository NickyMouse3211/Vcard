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
				<div class="form-group">
					<label class="col-md-3 control-label control-label-bold">
						Title
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-8 control-label-left control-label">
						<?=$records->fierce_judul?>
						<span class="help-block"></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-3 control-label control-label-bold">
						Content
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-8 control-label-left control-label">
						<?=$records->fierce_isi?>
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label control-label-bold">
						Link
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-8 control-label-left control-label">
						<?=$records->fierce_link?>
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label control-label-bold">
						Upload foto
						<span class="required" aria-required="true">* </span>
					</label>
					<div class="col-md-8 control-label-left control-label">
						<div class="fileinput fileinput-new" data-provides="fileinput">
							<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
								<img class="img-edit" src="<?=base_url("../public/images/fierce_fierce/".$records->fierce_pict)?>" alt="">
							</div>
							
						</div>
						<span class="help-block"></span>
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
</div>