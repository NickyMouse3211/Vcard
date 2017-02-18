<?php
  $link = 'touch/article/';
?>
<style type="text/css">
  .textarealabel {
      border: none;
      overflow: none;
      background: none;
      height: 100%;
      width:100%;

  }
</style>
<div class="col-sm-12">
    <?php
      $i = 0;
      if (count($item) != 0) {
        foreach ($item as $key) {
          $i++;
    ?>
    <!-- <form method="POST" action="<?=base_url($instance.'/add_comment')?>" id='comment-list' class="form-horizontal form-comment-list" role="form"> -->
      <div class="form-body col-sm-12">
        <?php
          $img = base_url('../public/images/anonim.png');
          $name= $key->touchcomment_email;
          if(@$key->member_nama != '')
          {
            $img  = base_url('../public/images/member/'.$key->member_pict);
            $name   = $key->member_nama.' ['.$key->member_nick_name.']';
          }
        ?>
        <div class='col-sm-1'>
          <img class="img-responsive comment-pict" height="70px" width="auto" src="<?=$img?>" alt="<?=$key->member_nama?>">
        </div>
        <div class='col-sm-11'>
          <div class='col-sm-12'>
            <div class='col-sm-10'>
              <label style='font-style: bold;'><?=$name?></label> 

              <?php
                if (@$key->member_nama != '') {
                  ?>
                  <a target="_blank" href="<?=base_url('user/show_detail/'.strEncrypt(@$key->member_id) )?>"><i class="fa fa-user text-btn detail-button" member='<?=$key->member_id?>' data-toggle="tooltip" title="Detail User"></i></a>
                  <a target="_blank"><i class="fa fa-envelope text-btn" data-toggle="tooltip" title="Message"></i></a>
                  <?php
                }
              ?>
            </div>
            <div class='col-sm-2' align="right">
              <?php
                if (@$key->member_nama != '' && @$this->session->userdata('user_data')->member_id == @$key->member_id) {
                  ?>
                  <i class="fa fa-pencil-square-o text-btn edit-button" coment='<?=$key->touchcomment_id?>' data-toggle="tooltip" title="Edit Comment"></i>
                  <i class="fa fa-trash-o text-btn delete-button" coment='<?=$key->touchcomment_id?>' data-toggle="tooltip" title="Delete Comment"></i>
                  <?php
                }
              ?>
            </div>
          </div>
          <div class='col-sm-12'>
            <div class='col-sm-9'>
              <textarea id='textarealabel<?=$i?>' class='textarealabel' desabled='desabled'><?=$key->touchcomment_isi?></textarea>
            </div>
            <div class='col-sm-3' align="right">
              on <?=$key->touchcomment_insert_date?>
            </div>
          </div>
        </div>
        <hr class="col-sm-12 line_break">
      </div>
    <!-- </form> -->
    <script type="text/javascript">
     $(document).ready(function() {
      var elmnt = document.getElementById("textarealabel<?=$i?>");
      var y = elmnt.scrollHeight/20;
      $('#textarealabel<?=$i?>').attr('rows',Math.floor(y));
     });
    </script>
    <?php }
    }else{
          echo 'Comment Not Found !!';
    } ?>
</div>
<script type="text/javascript">
 $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip();

      $('.edit-button').click(function () {
        var id      = $(this).attr('coment');
        var url     = "<?=base_url('touch_artikel/show_edit_comment')?>/";
        Custombox.open({
            target: url+'/'+id,
            effect: 'slip',
            width: '1000',
        });
      });

      $('.delete-button').click(function () {
        var id = $(this).attr('coment');
        swal({
          title: "Are you sure?",
          text: "You will not be able to recover this comment!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Yes, delete it!",
          cancelButtonText: "No, cancel plx!",
          closeOnConfirm: false,
          closeOnCancel: false
        },
        function(isConfirm){
          if (isConfirm) {
              var url     = "<?=base_url('touch_artikel/delete_comment')?>/";
              var data    = [
                              {
                                name: "id_comment",
                                value: id
                              }
                            ];
              $.post(url, data, function(res){
                swal("Deleted!", "Your comment has been deleted.", "success");
                // swal("Failed!", "deleting comment has been failed.", "error");
              });
          } else {
              swal("Cancelled", "Your comment is safe :)", "error");
          }
        });
        // Custombox.open({
        //     target: ,
        //     effect: 'slip',
        // });
            return false;
      });

 } );
</script>