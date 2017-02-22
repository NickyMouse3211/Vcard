<div class="page-header md-shadow-z-1-i navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner">
		<!-- BEGIN LOGO -->
		<div class="page-logo">
			<a href="<?=base_url('dashboard');?>" style="margin-top:0px;padding-top:0px;">
				<img style="margin-top:3px;padding-top:3px;" src="<?=base_url('../public/images/logo/virtual-card.png');?>" height="60" alt="logo" class="logo-default"/>
			</a>
			<div class="menu-toggler sidebar-toggler">
				<!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
			</div>
		</div>
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<!-- BEGIN PAGE ACTIONS -->
		<!-- DOC: Remove "hide" class to enable the page header actions -->
		<!-- END PAGE ACTIONS -->
		<!-- BEGIN PAGE TOP -->
		<div class="page-top">
			<!-- BEGIN HEADER SEARCH BOX -->
			<!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->
			<form class="search-form" action="extra_search.html" method="GET">
				<div class="input-group">
					<input type="text" class="form-control input-sm" placeholder="Search..." name="query">
					<span class="input-group-btn">
					<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
					</span>
				</div>
			</form>
			<!-- END HEADER SEARCH BOX -->
			<!-- BEGIN TOP NAVIGATION MENU -->
			<div class="top-menu">
				<ul class="nav navbar-nav pull-right">
					<li class="separator hide">
					</li>
					<!-- BEGIN NOTIFICATION DROPDOWN -->
					<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
					
					<!-- END TODO DROPDOWN -->
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
					<li class="dropdown dropdown-user dropdown-dark">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<span class="username username-hide-on-mobile">
							<?php echo $this->session->userdata('user_data')->vcard_name;?>
						</span>
						<!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
						<img alt="" class="img-circle" src="<?php echo base_url('../public/images/member') . '/'.$this->session->userdata('user_data')->vcard_image;?>"/>
						</a>
						<ul class="dropdown-menu dropdown-menu-default">
							<li>
								<a data-target="#stack1" data-toggle="modal">
									<i class="icon-user"></i> My Profile 
								</a>
							</li>
							<li>
								<a href="<?=base_url('../'.$this->session->userdata('user_data')->vcard_link);?>" target="_blank"><i class="icon-puzzle"></i> View Card </a>
							</li>
							<li class="divider">
							</li>
							<li>
								<a href="extra_lock.html">
								<i class="icon-lock"></i> Lock Screen </a>
							</li>
							<li>
								<a href="javascript:;" onClick="return f_logout(this, event)"><i class="icon-arrow-down"></i> Log Out </a>
							</li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
			</div>
			<!-- END TOP NAVIGATION MENU -->
		</div>
		<!-- END PAGE TOP -->
	</div>
	<!-- END HEADER INNER -->
</div>
<div id="stack1" class="modal fade bs-modal-lg" tabindex="-1">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Tab Data Akun</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="profile-sidebar" style="width: 250px;">
							<div class="portlet light profile-sidebar-portlet">
								<!-- SIDEBAR USERPIC -->
								<div class="profile-userpic">
									<img src="<?php echo base_url('../public/images/member') . '/'. $this->session->userdata('user_data')->vcard_image; ?>" class="img-responsive" alt="">
								</div>
								<!-- END SIDEBAR USERPIC -->
								<!-- SIDEBAR USER TITLE -->
								<div class="profile-usertitle">
									<div class="profile-usertitle-name">
										 <?= $this->session->userdata('user_data')->vcard_name; ?>
									</div>
									<div class="profile-usertitle-job">
										 <?= $this->session->userdata('user_data')->vcard_name.' - '. $this->session->userdata('user_data')->vcard_work; ?>
									</div>
								</div>
								<!-- END SIDEBAR USER TITLE -->
							
								<!-- SIDEBAR MENU -->
								<div class="profile-usermenu">
									<ul class="nav">
										<li class="active">
											<a href="#overview" data-toggle="tab">
												<i class="icon-home"></i> Data Akun 
											</a>
										</li>
										<li>
											<a href="#edit" data-toggle="tab">
												<i class="icon-settings"></i>Perbaharui akun 
											</a>
										</li>
										<li>
											<a data-dismiss="modal">
												<i class="icon-arrow-down"></i>Keluar 
											</a>
										</li>
									</ul>
								</div>
								<!-- END MENU -->
							</div>
						</div>

						<div class="profile-content">
							<div class="row">
								<div class="col-md-12">
									<div class="tab-content">

										<div id="overview" class="tab-pane active">
											<div id="accordion1" class="panel-group">
												<div class="panel panel-success">
													<div class="panel-heading">
														<h4 class="panel-title">
															<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#accordion1_1">
																Data Akun 
															</a>
														</h4>
													</div>
													<div id="accordion1_1" class="panel-collapse collapse in">
														<div class="panel-body">
															<form class="form-horizontal" role="form">
																<div class="form-body">
																	<h3 class="form-section">Info Pribadi</h3>
																	<div class="row">
																		<div class="col-md-11">
																			<div class="form-group">
																				<label class="control-label col-md-3">Nama Lenkap :</label>
																				<div class="col-md-9">
																					<p class="form-control-static">
																						<?= $this->session->userdata('user_data')->vcard_name; ?>
																					</p>
																				</div>
																			</div>

																			<div class="form-group">
																				<label class="control-label col-md-3">Email :</label>
																				<div class="col-md-9">
																					<p class="form-control-static">
																						<?= $this->session->userdata('user_data')->vcard_email; ?>
																					</p>
																				</div>
																			</div>

																			<div class="form-group">
																				<label class="control-label col-md-3">Alamat :</label>
																				<div class="col-md-9">
																					<p class="form-control-static">
																						<?= $this->session->userdata('user_data')->vcard_address; ?>
																					</p>
																				</div>
																			</div>

																			<div class="form-group">
																				<label class="control-label col-md-3">No Handphone :</label>
																				<div class="col-md-9">
																					<p class="form-control-static">
																						<?= $this->session->userdata('user_data')->vcard_phone; ?>
																					</p>
																				</div>
																			</div>

																		</div>
																	</div>
																</div>
															</form>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div id="edit" class="tab-pane">
											<div id="accordion2" class="panel-group">
												<div class="panel panel-info">
													<div class="panel-heading">
														<h4 class="panel-title">
															<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_1">
																Perbaharui Akun 
															</a>
														</h4>
													</div>
													<div id="accordion2_1" class="panel-collapse collapse in">
														<div class="panel-body">
															
															<form class="form-horizontal" action="javascript:void(0);">
																<div class="form-body">
																	<div class="form-group">
																		<label class="col-md-3 control-label">Nama Lengkap</label>
																		<div class="col-md-6">
																			<div class="input-icon">
																				<i class="fa fa-font"></i>
																				<input value="<?= $this->session->userdata('user_data')->vcard_name; ?>" type="text" class="form-control input-circle" placeholder="Masukan nama">
																			</div>
																		</div>
																	</div>

																	<div class="form-group">
																		<label class="col-md-3 control-label">Email</label>
																		<div class="col-md-6">
																			<div class="input-icon">
																				<i class="fa fa-envelope"></i>
																				<input value="<?= $this->session->userdata('user_data')->vcard_email; ?>" type="text" class="form-control input-circle" placeholder="Masukan email">
																			</div>
																		</div>
																	</div>

																	<div class="form-group">
																		<label class="col-md-3 control-label">Alamat</label>
																		<div class="col-md-6">
																			<div class="input-icon">
																				<i class="fa taxi"></i>
																				<textarea class="form-control input-circle" placeholder="Masukan alamat"><?= $this->session->userdata('user_data')->vcard_address; ?></textarea>
																			</div>
																		</div>
																	</div>

																	<div class="form-group">
																		<label class="col-md-3 control-label">No Handphone</label>
																		<div class="col-md-6">
																			<div class="input-icon">
																				<i class="fa fa-phone"></i>
																				<input value="<?= $this->session->userdata('user_data')->vcard_phone; ?>" type="text" class="form-control input-circle" placeholder="Masukan no handphone">
																			</div>
																		</div>
																	</div>

																	<div class="form-group ">
																		<label class="control-label col-md-3">Upload foto</label>
																		<div class="col-md-9">
																			<div class="fileinput fileinput-new" data-provides="fileinput">
																				<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
																					<img src="<?php echo base_url('../public/images/member') . '/'. $this->session->userdata('user_data')->vcard_image; ?>" alt="">
																				</div>
																				<div>
																					<span class="btn default btn-file">
																					<span class="fileinput-new">
																					Select image </span>
																					<span class="fileinput-exists">
																					Change </span>
																					<input type="file" name="pu_foto">
																					</span>
																					<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">
																					Remove </a>
																				</div>
																			</div>
																		</div>
																	</div>

																</div>
																<div class="portlet-body form">
																	<div class="form-actions">
																		<div class="row">
																			<div class="col-md-offset-3 col-md-9">
																				<button type="submit" class="btn btn-circle blue">Submit</button>
																				<button type="button" class="btn btn-circle default">Cancel</button>
																			</div>
																		</div>
																	</div>
																</div>
															</form>
														</div>
													</div>
												</div>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- <a class="btn green" data-toggle="modal" href="#stack2">
				Launch modal </a> -->
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn red">Ok</button>
			</div>
		</div>
	</div>
</div>