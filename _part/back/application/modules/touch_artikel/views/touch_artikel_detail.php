<?php
	if ($jumlah_like == '') {
		$jumlah_like = array();
	}
	if ($jumlah_unlike == '') {
		$jumlah_unlike = array();
	}
?>
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
					</label>
					<div class="col-md-8 control-label-left control-label">
						<?=$records->touchartikel_judul?>
						<span class="help-block"></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-3 control-label control-label-bold">
						Content
					</label>
					<div class="col-md-8 control-label-left control-label">
						<?=$records->touchartikel_isi?>
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label control-label-bold">
						Link
					</label>
					<div class="col-md-8 control-label-left control-label">
						<?=$records->touchartikel_link?>
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label control-label-bold">
						Upload foto
					</label>
					<div class="col-md-8 control-label-left control-label">
						<div class="fileinput fileinput-new" data-provides="fileinput">
							<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
								<img class="img-edit" src="<?=base_url("../public/images/touch_artikel/".$records->touchartikel_pict)?>" alt="">
							</div>
							
						</div>
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label control-label-bold">
						Comment
					</label>
					<div class="col-md-8 control-label-left control-label">
						<span id='jumlah-comment'><?=$jumlah_comment;?></span> <a class='text-btn' onclick="$('#form-comment-artikel').toggle('blind' , 1500);$('#shows-comment-artikel').toggle('blind' , 1500);" data-toggle="tooltip" title="Click To Comment"><i class="fa fa-comment"></i></a> - 
						
						<span id='jumlah-like'><?=@count(@$jumlah_like);?></span> <a class='text-btn <?php if(in_array(@$this->session->userdata('user_data')->member_id, @$jumlah_like)){ echo "text-btn-active";} ?>' 
						<?php if(@$this->session->userdata('user_data')->member_id != '' && !in_array(@$this->session->userdata('user_data')->member_id, @$jumlah_like)){ ?> onclick="like();" <?php }
						elseif(@$this->session->userdata('user_data')->member_id != '' && in_array(@$this->session->userdata('user_data')->member_id, @$jumlah_like)){ ?> onclick="likedown();" <?php } ?> id="like-btn" data-toggle="tooltip" title="Like"> <i class="fa fa-thumbs-up" ></i></a> - 
						
						<span id='jumlah-unlike'><?=@count(@$jumlah_unlike);?></span><a class='text-btn <?php if(in_array(@$this->session->userdata('user_data')->member_id, @$jumlah_unlike)){ echo "text-btn-active";} ?>' 
						<?php if(@$this->session->userdata('user_data')->member_id != '' && !in_array(@$this->session->userdata('user_data')->member_id, @$jumlah_unlike)){ ?> onclick="unlike();" <?php }
						elseif(@$this->session->userdata('user_data')->member_id != '' && in_array(@$this->session->userdata('user_data')->member_id, @$jumlah_unlike)){ ?> onclick="unlikedown();" <?php } ?> id="unlike-btn" data-toggle="tooltip" title="Unlike"><i class="fa fa-thumbs-down"></i></a>
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
			<form method="POST" action="<?=base_url($instance.'/add_comment')?>" id='form-comment-artikel' class="form-horizontal form-comment" role="form" style="display:none;">
				<div class="form-body">
					<?php
						$img = base_url('../public/images/anonim.png');
						$name= 'Anonim';
						if($this->session->userdata('user_data') != '')
						{
							$img 	= base_url('../public/images/member/'.$this->session->userdata('user_data')->member_pict);
							$name 	= $this->session->userdata('user_data')->member_nick_name;
						}
					?>
					<div class="form-group">
						<div class="col-md-2"></div>
						<div class="col-md-8">
							<h3 style='font-style: bold;'><?=$name?></h3>
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-2" align="right">
							<img class="img-responsive comment-pict" width='80px' src="<?=$img?>">
							<span class="help-block"></span>
						</div>
						<div class="col-md-8">
							<textarea name="touchcomment_isi" id='touchcomment_isi' style='resize:none;' class="required form-control " placeholder="Add a comment . . " required></textarea>
							<span class="help-block"></span>
						</div>
					</div>
				</div>
				<div class="form-actions">
					<div class="row">
						<div class="col-md-offset-2 col-md-9">
							<input type="hidden" class="form-control" name="argaid" value="<?=$records->touchartikel_id;?>" required>
							<button type="submit" class="btn btn-primary">Submit</button>
							<button type="button" class="btn btn-warning" onclick="$('#touchcomment_isi').val('');">Clear</button>
						</div>
					</div>
				</div>
				<hr class="line_break">
			</form>
		</div>
	</div>
	<a href="<?=base_url($url)?>" class="ajaxify reload" style="display: none;"></a>
</div>
<div class="portlet" id="shows-comment-artikel" style="background-color:#fff;display:none;">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-comment font-green-sharp"></i>
			<span class="caption-subject font-green-sharp bold uppercase">Comment <?=$pagetitle?></span>
		</div>
	</div>
	<div class="portlet-body">
		<div class="form-body">
			<div class="form-horizontal">
				<div id='comment-artikel'>
					
				</div>
				<div class="pagination">
					<a href="#" class="first" data-action="first" data-toggle="tooltip" title="First">&laquo;</a>
					<a href="#" class="previous" data-action="previous" data-toggle="tooltip" title="Previous">&lsaquo;</a>
					<input type="text" id='paged' readonly="readonly" data-max-page="<?=ceil($jumlah_comment/5) == 0 ? '1' : ceil($jumlah_comment/5)?>" />
					<a href="#" class="next" data-action="next" data-toggle="tooltip" title="Next">&rsaquo;</a>
					<a href="#" class="last" data-action="last" data-toggle="tooltip" title="Last">&raquo;</a>
				</div>
			</div>
		</div>
	</div>
	<!-- <a href="<?=base_url($url)?>" class="ajaxify reload" style="display: none;"></a> -->
</div>
<script type="text/javascript">
	var jenisarga   = '1';
	var idarga		= "<?=$records->touchartikel_id?>";
	var refreshartikel = function(){
		var urlcomment  = "<?=base_url($instance.'/show_comment/"+idarga+"')?>"+'/'+$('#paged').val().replace('Page ','').split(' of ')[0];
		var datacomment = [
							  {
							    name: "jenisarga",
							    value: jenisarga
							  },
							  {
							    name: "idarga",
							    value: idarga
							  }
						  ]
		$.post(urlcomment, datacomment, function(res){
			var view = JSON.parse(res)
		     $('#comment-artikel').html(view.view);
		     $('#jumlah-comment').html(view.jumlah_comment);
		     $('#jumlah-like').html(view.jumlah_like);
		     $('#jumlah-unlike').html(view.jumlah_unlike);
		     $(".pagination").jqPagination("option", {
		         max_page : ((Math.ceil(view.jumlah_comment/5) == '0') ? '1' : Math.ceil(view.jumlah_comment/5)),
		         trigger : false
		     });
		     // pagging(Math.ceil(view.jumlah_comment/5));

		     // alert(datacomment);
		})
		$('[data-toggle="tooltip"]').tooltip();
	};
	var intrefreshartikel = setInterval(refreshartikel, 10000);
	$(document).ready(function () {

		$('.pagination').jqPagination({
		    paged: function(page) {
		    	// alert();
		        refreshartikel();
		    }
		});

		$("#form-comment-artikel").submit(function(){
			var url 		= $(this).attr('action');
			var data 		= $(this).serializeArray();
			var message 	= 'Are you sure ?';
			var messagetext	= 'add a new comment?';
			var messagetype	= 'warning';	
			swal({
			  title: message,
			  text: messagetext,
			  type: messagetype,
			  showCancelButton: true,
			  confirmButtonClass: "btn-danger",
			  confirmButtonText: "Yes",
			  cancelButtonText: "No",
			  closeOnConfirm: true,
			  closeOnCancel: false
			},
			function(isConfirm) {
			  if (isConfirm) {
			  	$.post(url, data, function(res){
			  		var jumlahcoment=parseInt($('#jumlah-comment').html())+1;
			  	     msg = {
			  	        success : 'Data successfully saved!',
			  	        error : 'Data could not be saved!'
			  	     };

			  	     if (data == 0) {
			  	        toastr.error(msg.error);
			  	     } else {
			  	        toastr.success(msg.success);
			  	     }
			  	     $('#touchcomment_isi').val('');
			  	     $('#touchcomment_email').val('');
			  	     $('#jumlah-comment').html(jumlahcoment);
			  	     // $('#paged').val() = 'Page 1 of <?=ceil($jumlah_comment/5)?>'
			  	     $('#paged').attr('data-max-page',Math.ceil(jumlahcoment/5));
			  	     $('.pagination').jqPagination('option', 'max_page', Math.ceil(jumlahcoment/5));
			  	     refreshartikel();
			  	})
			  } else {
			    swal("Cancelled", "operation aborted :)", "error");
			  }
			});
		    return false; 
		})
		
		refreshartikel();
	});
	function like()
	{
		var idarga	 = "<?=$records->touchartikel_id?>";
		var urllike  = "<?=base_url($instance.'/like')?>";
		var datalike = [
							  {
							    name: "idarga",
							    value: idarga
							  }
						  ];
		$.post(urllike, datalike, function(res){
			var jumlahlike=parseInt($('#jumlah-like').html())+1;
	  		$('#jumlah-like').html(jumlahlike);
	  		$('#like-btn').attr('onclick', 'likedown();');
	  		$('#like-btn').attr('class', 'text-btn text-btn-active');
	  	})
	}

	function likedown()
	{
		var idarga	 = "<?=$records->touchartikel_id?>";
		var urllike  = "<?=base_url($instance.'/likedown')?>";
		var datalike = [
							  {
							    name: "idarga",
							    value: idarga
							  }
						  ];
		$.post(urllike, datalike, function(res){
			var jumlahlike=parseInt($('#jumlah-like').html())-1;
	  		$('#jumlah-like').html(jumlahlike);
	  		$('#like-btn').attr('onclick', 'like();');
	  		$('#like-btn').attr('class', 'text-btn');
	  	})
	}

	function unlike()
	{
		var idarga		= "<?=$records->touchartikel_id?>";
		var urlunlike  	= "<?=base_url($instance.'/unlike')?>";
		var dataunlike 	= [
							  {
							    name: "idarga",
							    value: idarga
							  }
						  ];
		$.post(urlunlike, dataunlike, function(res){
	  		var jumlahunlike=parseInt($('#jumlah-unlike').html())+1;
	  		$('#jumlah-unlike').html(jumlahunlike);
	  		$('#unlike-btn').attr('onclick', 'unlikedown();');
	  		$('#unlike-btn').attr('class', 'text-btn text-btn-active');
	  	})
	}

	function unlikedown()
	{
		var idarga	 = "<?=$records->touchartikel_id?>";
		var urllike  = "<?=base_url($instance.'/unlikedown')?>";
		var datalike = [
							  {
							    name: "idarga",
							    value: idarga
							  }
						  ];
		$.post(urllike, datalike, function(res){
			var jumlahunlike=parseInt($('#jumlah-unlike').html())-1;
	  		$('#jumlah-unlike').html(jumlahunlike);
	  		$('#unlike-btn').attr('onclick', 'unlike();');
	  		$('#unlike-btn').attr('class', 'text-btn');
	  	})
	}

	function pagging(page)
	{
		$('.pagination').jqPagination('option', 'max_page', page);
	}
</script>