<style type="text/css">
	.image_universal{
		background-color: <?=$color?>;
	}
</style>
<div class="modal-box image_universal">
	<div class="header">Detail Picture</div>
	<div class="body form-horizontal image_universal">
		<div class='col-md-12 image_universal' align="center">
			<img alt="<?=$foto?>" class="img-responsive comment-pict" id='detailpict' width="500" src="<?=rawurldecode(str_replace('_'.md5('%').'-','%',$foto))?>">
		</div>
		
	</div>
	<div class="footer">
		<div style="color:white;">
			&#x24B8; Copyright NickyM, 2015-2016. All rights reserved. 	
		</div>
		<div style="color:white;" align="right">
			Press Esc to exit . . .
		</div>
	</div>
</div>
<script type="text/javascript">
 $(document).ready(function() {
 	// $("#detailpict").imageLens({ imageLenssSize: 150 , zindex:10003 });
 } );
</script>