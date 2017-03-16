<style type="text/css">
	.control-label-left{
		text-align: left !important;
	}
	.control-label-bold{
		font-weight: bold;
	}
	.detailimg{
		border-radius: 10px;
		width: 250px;
		height:auto;
		border: solid 1px #CCC;
		-moz-box-shadow: 3px 4px 0px #999;
		    -webkit-box-shadow: 3px 4px 0px #999;
		        box-shadow: 3px 4px 0px #999;
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

				<?php
					if ($records->vcard_image != null || $records->vcard_image != '') {
						?>
							<div class="form-group col-md-12" >
								<center>
									<img src="<?php echo base_url('../public/images/vcard').'/'.$records->vcard_image;?>" alt="<?php echo $records->vcard_image;?>" class="detailimg">
								</center>
							</div>
						<?php
					} 
					$notshow = array('vcard_id','vcard_update_date','vcard_status','vcard_update_id','vcard_insert_date','vcard_role','vcard_password','vcard_image');
					foreach ($records as $key => $value) {
						if (!in_array($key, $notshow)) {
							?>
								<div class="form-group col-md-6">
									<label class="col-md-4 control-label control-label-bold">
										<?php echo ucwords(str_replace('_',' ',str_replace('vcard_', '', $key)));?> :
									</label>
									<div class="col-md-8 control-label-left control-label">
										<?=@$value != null || $value != '' ? $value : '-'?>
										<span class="help-block"></span>
									</div>
								</div>
							<?php
						}
					}
				?>
					
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