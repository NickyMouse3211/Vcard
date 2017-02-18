<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.4
Version: 4.0.1
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Vcard Admin </title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport"/>
<meta name="description" content="Vcard Bayu Ady Nugraha Berisi Biodata dari Bayu Ady nugraha">
<meta name="keywords" content="Vcard,Bayu Ady Nugraha,Berisi,Biodata,dari Bayu Ady nugraha">
<meta content="Bayu Ady Nugraha" name="author"/>
<!-- Facebook -->
<!-- <meta property="fb:admins" 				content="100010683332041" /> -->
<!-- <meta property="fb:app_id" 				content="1533478166969359" /> -->
<meta property="og:url"                	content="http://www.fierce.hol.es" />
<meta property="og:type"               	content="article" />
<meta property="og:title"              	content="Vcard" />
<meta property="og:description"        	content="Vcard , dengan informasi seputar Touch dan keseharian member fierce" />
<!-- <meta property="og:image"              	content="http://fierce.hol.es/public/images/logo/NDLoogo.png" /> -->
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="<?=base_url('../public/back/global/css/googleapis.css');?>" rel="stylesheet" type="text/css"/>
<link href="<?=base_url('../public/back/global/plugins/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css"/>
<link href="<?=base_url('../public/back/global/plugins/simple-line-icons/simple-line-icons.min.css');?>" rel="stylesheet" type="text/css"/>
<link href="<?=base_url('../public/back/global/plugins/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css"/>
<link href="<?=base_url('../public/back/global/plugins/uniform/css/uniform.default.css');?>" rel="stylesheet" type="text/css"/>
<link href="<?=base_url('../public/back/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css');?>" rel="stylesheet" type="text/css"/>
<!-- <script src="<?=base_url('../public/back/global/plugins/gmapapi.js');?>" type="text/javascript"></script>
<script src="<?=base_url('../public/back/global/plugins/gmaps.js');?>" type="text/javascript"></script> -->
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<!-- END PAGE LEVEL PLUGIN STYLES -->
<!-- BEGIN PAGE STYLES -->
<link href="<?=base_url('../public/back/admin/pages/css/tasks.css');?>" rel="stylesheet" type="text/css"/>
<!-- END PAGE STYLES -->
<!-- BEGIN THEME STYLES -->
<!-- DOC: To use 'rounded corners' style just load 'components-rounded.css' stylesheet instead of 'components.css' in the below style tag -->
<link href="<?=base_url('../public/back/global/css/components-md.css');?>" id="style_components" rel="stylesheet" type="text/css"/>
<link href="<?=base_url('../public/back/global/css/plugins-md.css');?>" rel="stylesheet" type="text/css"/>
<link href="<?=base_url('../public/back/admin/layout/css/layout.css');?>" rel="stylesheet" type="text/css"/>
<!-- <link href="<?=base_url('../public/back/admin/layout/css/themes/light.css');?>" rel="stylesheet" type="text/css" id="style_color"/> -->
<link href="<?=base_url('../public/back/admin/layout/css/themes/default.css');?>" rel="stylesheet" type="text/css" id="style_color"/>
<link href="<?=base_url('../public/back/admin/layout/css/custom.css');?>" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="<?=base_url('../public/images/music.ico');?>"/>
<?php 
	foreach ($this->config->item('plugin') as $key => $value):
		echo get_css($value)."\n";
	endforeach; 
?>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
<script src="<?=base_url('../public/back/global/plugins/jquery.min.js');?>" type="text/javascript"></script>
<script>
	jQuery(document).ready(function() {    
	   	Metronic.init(); // init metronic core componets
	   	Layout.init(); // init layout
	   	Demo.init(); // init demo features\
	   	Profile.init();
	   	// UIExtendedModals.init();
	   	// QuickSidebar.init(); // init quick sidebar
	    // Index.init(); // init index page
	 	// Tasks.initDashboardWidget(); // init tash dashboard widget  
	 	$('.bs-select').selectpicker({
            iconBase: 'fa',
            tickIcon: 'fa-check'
        });
	});
	var base_url = "<?=base_url()?>";
</script>
<body class="page-md page-header-fixed page-sidebar-closed-hide-logo page-sidebar-closed-hide-logo">
<!-- BEGIN HEADER -->
<?= @$_header; ?>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
	<!-- BEGIN SIDEBAR -->
	<?= @$_menu; ?>
	<!-- END SIDEBAR -->
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEAD -->
			<?= @$_page_header; ?>
			<!-- BEGIN PAGE CONTENT INNER -->
			<div class="page-content-body">
				<?= @$_fullcontent; ?>
			</div>
			<!-- END PAGE CONTENT INNER -->
		</div>

		<!-- BEGIN QUICK SIDEBAR -->
		<?= @$_chating; ?>
		<!-- END QUICK SIDEBAR -->
	</div>
	<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<?= @$_footer; ?>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="../../assets/global/plugins/respond.min.js"></script>
<script src="../../assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->

<script src="<?=base_url('../public/back/global/plugins/jquery-migrate.min.js');?>" type="text/javascript"></script>
<script src="<?=base_url('../public/back/global/plugins/jquery-ui/jquery-ui.min.js');?>" type="text/javascript"></script>
<?php 
	foreach ($this->config->item('plugin') as $key => $value):
		echo get_js($value)."\n";
	endforeach; 
?>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?=base_url('../public/back/global/plugins/bootstrap/js/bootstrap.min.js');?>" type="text/javascript"></script>
<script src="<?=base_url('../public/back/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js');?>" type="text/javascript"></script>
<script src="<?=base_url('../public/back/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js');?>" type="text/javascript"></script>
<script src="<?=base_url('../public/back/global/plugins/jquery.blockui.min.js');?>" type="text/javascript"></script>
<script src="<?=base_url('../public/back/global/plugins/jquery.cokie.min.js');?>" type="text/javascript"></script>
<script src="<?=base_url('../public/back/global/plugins/uniform/jquery.uniform.min.js');?>" type="text/javascript"></script>
<script src="<?=base_url('../public/back/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js');?>" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<!-- <script src="<?=base_url('../public/back/global/plugins/jqvmap/jqvmap/jquery.vmap.js');?>" type="text/javascript"></script>
<script src="<?=base_url('../public/back/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js');?>" type="text/javascript"></script>
<script src="<?=base_url('../public/back/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js');?>" type="text/javascript"></script>
<script src="<?=base_url('../public/back/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js');?>" type="text/javascript"></script>
<script src="<?=base_url('../public/back/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js');?>" type="text/javascript"></script>
<script src="<?=base_url('../public/back/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js');?>" type="text/javascript"></script>
<script src="<?=base_url('../public/back/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js');?>" type="text/javascript"></script> -->
<!-- IMPORTANT! fullcalendar depends on jquery-ui.min.js for drag & drop support -->

<!--script src="<?=base_url('../public/back/global/plugins/morris/raphael-min.js');?>" type="text/javascript"></script-->
<script src="<?=base_url('../public/back/global/plugins/jquery.sparkline.min.js');?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?=base_url('../public/back/global/scripts/metronic.js');?>" type="text/javascript"></script>
<script src="<?=base_url('../public/back/admin/layout/scripts/layout.js');?>" type="text/javascript"></script>
<script src="<?=base_url('../public/back/admin/layout/scripts/quick-sidebar.js');?>" type="text/javascript"></script>
<script src="<?=base_url('../public/back/admin/layout/scripts/demo.js');?>" type="text/javascript"></script>
<!--script src="<?=base_url('../public/back/admin/pages/scripts/index3.js');?>" type="text/javascript"></script-->
<script src="<?=base_url('../public/back/admin/pages/scripts/tasks.js');?>" type="text/javascript"></script>
<script src="<?=base_url('../public/back/global/plugins/jquery.form.min.js');?>" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
<script type="text/javascript">
	var intrefreshartikel = '';
</script>