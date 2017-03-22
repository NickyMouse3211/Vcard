<!DOCTYPE html>
<html class="no-js" lang="en">
	<head>

		<title>Personal vCard</title>
	    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	    <link rel="stylesheet" type="text/css" href="<?=base_url('public/css/reset.css');?>"/> 
	    <link rel="stylesheet" type="text/css" href="<?=base_url('public/css/style.css');?>"/>
	    <link rel="stylesheet" type="text/css" href="<?=base_url('public/css/fancybox.css');?>"/>
	    <link rel="stylesheet" type="text/css" href="<?=base_url('public/back/global/plugins/bootstrap-toastr/toastr.min.css');?>"/>
		<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,300,800,700,400italic|PT+Serif:400,400italic"/>
		<meta name="description" content="Vcard Bayu Ady Nugraha Berisi Biodata dari Bayu Ady nugraha">
		<meta name="keywords" content="Vcard,Bayu Ady Nugraha,Berisi,Biodata,dari Bayu Ady nugraha">
			<meta content="Bayu Ady Nugraha" name="author"/>
		<!-- Meta Tags Created With: STW Meta Tag Builder http://www.scrubtheweb.com/ -->
		<!-- Facebook -->
		<meta property="og:type"               	content="article" />
		<meta property="og:title"              	content="Vcard" />
		<meta property="og:description"        	content="Vcard,Bayu Ady Nugraha,Berisi,Biodata,dari Bayu Ady nugraha" />
	    
	    <script type="text/javascript" src="<?=base_url('public/js/jquery.js');?>"></script>
	    <script type="text/javascript" src="<?=base_url('public/js/jquery.easytabs.min.js');?>"></script>
	    <script type="text/javascript" src="<?=base_url('public/js/respond.min.js');?>"></script>
	    <script type="text/javascript" src="<?=base_url('public/js/jquery.easytabs.min.js');?>"></script>   
		<script type="text/javascript" src="<?=base_url('public/js/jquery.adipoli.min.js');?>"></script>
	    <script type="text/javascript" src="<?=base_url('public/js/jquery.fancybox.js');?>"></script>
	    <script type="text/javascript" src="<?=base_url('public/js/isotope.pkgd.js');?>"></script>
	    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	    <script type="text/javascript" src="<?=base_url('public/js/jquery.gmap.min.js');?>"></script>
	    <script type="text/javascript" src="<?=base_url('public/back/global/plugins/bootstrap-toastr/toastr.min.js');?>"></script>
	    <script type="text/javascript" src="<?=base_url('public/js/custom.js');?>"></script>

		
	</head>
	<body id='test' class='current-body'>
		<?php
			$menustyle   = @$profile->vcard_name != '' || @$profile->vcard_name != null ? '' : 'display:none';

			$name        = @$profile->vcard_name != '' || @$profile->vcard_name != null ? $profile->vcard_name : ' -';
			$work        = @$profile->vcard_work != '' || @$profile->vcard_work != null ? $profile->vcard_work : ' -';
		?>
		<!-- Container -->
        <div id="container">
        
            <!-- Top -->
			<div class="top"> 
            	<!-- Logo -->
            	<div id="logo">
                	<h2><?php echo $name;?></h2>
                    <h4><?php echo $work;?></h4>
                </div>
                <!-- /Logo -->
                
                <!-- Social Icons -->
                
                <!-- /Social Icons -->
            </div>
            <!-- /Top -->
            
            <!-- Content -->
            <div id="content">
                <?= @$_content; ?> 
            </div>
            <!-- /Content -->
            
            <!-- Footer -->
			<div class="footer">
            	<div class="copyright">Copyright © 2017 Bayu Ady Nugraha</div>
            </div>
            <ul class="socialicons" style="<?php echo $menustyle; ?>">
            	<li><a href="#" class="social-facebook"></a></li>
                <li><a href="#" class="social-twitter"></a></li>
                <li><a href="#" class="social-in"></a></li>
                <li><a href="#" class="social-googleplus"></a></li>
            </ul>
            <!-- /Footer --> 
            
        </div>
		
	</body>
	
</html>

<!-- <script type="text/javascript">
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
		$('#login').on('click', function ( e ) {
		    Custombox.open({
		        target: '#form-login',
		        effect: 'slip',
		    });
		    e.preventDefault();
		    // $('#form-login').show();
		});
		$('#login2').on('click', function ( e ) {
		    Custombox.open({
		        target: '#form-login',
		        effect: 'slip',
		    });
		    e.preventDefault();
		    // $('#form-login').show();
		});
		$('#logout').click(function () {
		      $.ajax({
		        type:"POST",
		        cache:false,
		        url:"<?=base_url('sign/sign_out')?>",
		        data: { out : 'true'} ,    // multiple data sent using ajax
		        success: function (html) {
		          	timedRefresh(0);
		        }
		      });
		      return false;
		});
		$('#logout2').click(function () {
		      $.ajax({
		        type:"POST",
		        cache:false,
		        url:"<?=base_url('sign/sign_out')?>",
		        data: { out : 'true'} ,    // multiple data sent using ajax
		        success: function (html) {
		          	timedRefresh(0);
		        }
		      });
		      return false;
		});
	});
	
</script> -->