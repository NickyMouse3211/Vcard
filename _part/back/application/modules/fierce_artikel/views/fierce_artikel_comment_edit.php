<div class="modal-box portlet light">
	<div class="header btn default" style="width:100%;cursor:auto;">Editing Comment</div>
	<div class="body">
		<form subtext="<?=substr($item->fiercecomment_isi, 0, 200)?>" method="POST" action="<?=base_url($instance.'/edit_comment')?>" id='form-edit-comment-artikel' class="form-horizontal" role="form">
			<div class='col-sm-12'>
				<div class="form-group">
					<div class="col-sm-3" align="left">
						<label></label>
					</div>
					<div class="col-sm-12" align="left">
						<textarea name="fiercecomment_isi" id='fiercecomment_edit_isi' style='resize:none;' class="required form-control " placeholder="Add a comment . . " required><?=$item->fiercecomment_isi;?></textarea>
					</div>
				</div>
				<div class="form-group" align="right">
					<div class="col-md-offset-3 col-md-9">
						<input type="hidden" class="form-control" name="commentid" value="<?=$item->fiercecomment_id;?>" required>
						<button type="submit" class="btn btn-primary">Submit</button>
						<button type="button" class="btn btn-warning" onclick="$('#fiercecomment_edit_isi').val('');">Clear</button>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="footer btn blue-madison" style="width:100%;" onclick="Custombox.close();">
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
 		$("#form-edit-comment-artikel").submit(function(){
 			var url 		= $(this).attr('action');
 			var data 		= $(this).serializeArray();
 			  	$.post(url, data, function(res){
 			  	     msg = {
 			  	        success : 'Data successfully saved!',
 			  	        error : 'Data could not be saved!'
 			  	     };

 			  	     if (data == 0) {
 			  	        toastr.error(msg.error);
 			  	        Custombox.close();
 			  	     } else {
 			  	        toastr.success(msg.success);
 			  	        Custombox.close();
 			  	     } 	     
 			  	})
 		    return false; 
 		});
 } );
</script>