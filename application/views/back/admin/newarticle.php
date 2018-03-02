<!DOCTYPE html> 
<html lang="en"> 
<head> 
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php if(isset($webtitle)) { echo $webtitle; } ?></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="apple-touch-icon" href="<?php echo base_url(); ?>layout/elephant/apple-touch-icon.png">
	<link rel="icon" href="<?php echo base_url(); ?>layout/elephant/favicon.ico">
	<link rel="stylesheet" href="<?php echo base_url(); ?>layout/elephant/css/vendor.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>layout/elephant/css/elephant.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>layout/elephant/css/application.min.css">

	<!-- Include CSS for icons. -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> 
	<style> 

	div#editor {
		width: 81%;
		margin: auto;
		text-align: left;
	}
</style>

<script type="text/javascript">
	function doDate()
	{
		var str = "";

		var days = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
		var months = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

		var now = new Date();

		var minutes = '';

		var m = now.getMinutes().toString();

		if(m.length == 1) {
			minutes = '0'+now.getMinutes();
		} else {
			minutes = now.getMinutes(); 
		}

		str += days[now.getDay()] + ", " + now.getDate() + " " + months[now.getMonth()] + " " + now.getFullYear() + " " + now.getHours() +":" + minutes + ":" + now.getSeconds();
		document.getElementById("todaysDate").innerHTML = str;
	}

	setInterval(doDate, 1000);

	// $('#successModalAlert').data('bs.modal').$backdrop
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {

				console.log(e);
				$('#blah')
				.show()
				.attr('src', e.target.result)
				.width(200);
			};

			reader.readAsDataURL(input.files[0]);
		}
	}
</script>
</head>
<body class="layout">
	<div class="layout-header">
		<div class="navbar navbar-default">
			<div class="navbar-header">
				<a class="navbar-brand navbar-brand-center" href="#">Elephant Template</a>
				<button class="navbar-toggler collapsed visible-xs-block" type="button" data-toggle="collapse" data-target="#sidenav">
					<span class="sr-only">Toggle navigation</span>
					<span class="bars">
						<span class="bar-line bar-line-1 out"></span>
						<span class="bar-line bar-line-2 out"></span>
						<span class="bar-line bar-line-3 out"></span>
					</span>
					<span class="bars bars-x">
						<span class="bar-line bar-line-4"></span>
						<span class="bar-line bar-line-5"></span>
					</span>
				</button>
				<button class="navbar-toggler collapsed visible-xs-block" type="button" data-toggle="collapse" data-target="#navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="arrow-up"></span>
					<span class="ellipsis ellipsis-vertical"></span>
				</button>
			</div>
			<div class="navbar-toggleable">
				<nav id="navbar" class="navbar-collapse collapse">
					<button class="sidenav-toggler hidden-xs" title="Collapse sidenav ( [ )" type="button">
						<span class="sr-only">Toggle navigation</span>
						<span class="bars">
							<span class="bar-line bar-line-1 out"></span>
							<span class="bar-line bar-line-2 out"></span>
							<span class="bar-line bar-line-3 out"></span>
							<span class="bar-line bar-line-4 in"></span>
							<span class="bar-line bar-line-5 in"></span>
							<span class="bar-line bar-line-6 in"></span> 
						</span>
					</button>
					<ul class="nav navbar-nav navbar-right">
						<li class="visible-xs-block">
							<h4 class="navbar-text text-center"><?php echo $sess['name_user']; ?></h4>
						</li>
						<?php if(isset($search)): ?>
							<li class="hidden-xs hidden-sm">
								<form class="navbar-search navbar-search-collapsed" action="" method="GET">
									<div class="navbar-search-group">
										<input class="navbar-search-input" type="text" name="search" placeholder="Search what you want, and more…">
										<input type="hidden" name="menu" value="<?php if(isset($active)) { echo $active; } ?>">
										<input type="hidden" name="sub" value="<?php if(isset($sub)) { echo $sub; } ?>">
										<button class="navbar-search-toggler" title="Limit Code Search Engine" type="button">
											<span class="icon icon-search icon-lg"></span>
										</button>
										<button class="navbar-search-adv-btn btn" type="submit"><b>Search</b></button>
									</div>
								</form>
							</li>
						<?php endif; ?>


						<?php if(!empty($sess['user_status'])): ?>
							<?php if($sess['user_status'] == 1 || $sess['user_status'] == 2 || $sess['user_status'] == 3): ?>
								<li class="dropdown">
									<a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
										<?php
										if(isset($notifications)) {
											$notice = array();
											foreach($notifications as $not) {
												if($not->status_notif == 0) { $notice[] = $not->status_notif; }
											}
										} else {
											$notice = array();
										}
										?>
										<span class="icon-with-child hidden-xs">
											<span class="icon icon-bell-o icon-lg"></span>
											<span class="badge badge-danger badge-above right" id="notifcount">
												<?php echo count($notice); ?>

											</span>
										</span>

										<span class="visible-xs-block">
											<span class="icon icon-bell icon-lg icon-fw"></span>
											<span class="badge badge-danger pull-right"><?php echo count($notice); ?></span>
											Notifications
										</span>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg">
										<div class="dropdown-header">
											<a class="dropdown-link" href="#">Mark all as read</a>
											<h5 class="dropdown-heading">Recent Notifications</h5>
										</div>
										<div class="dropdown-body">
											<div class="custom-scrollable-area">
												<div class="list-group list-group-divided custom-scrollbar" >
													<?php
													if(isset($notifications)) {
														foreach($notifications as $not) {
															?>
															<a class="list-group-item" href="<?php echo base_url().index_with().$not->url_notif.'?see='.$not->id_notif; ?>">
																<div class="notification">
																	<div class="notification-media">
																		<?php 
																		if($not->status_notif == 0) {
																			echo '<span class="icon icon-bell bg-info rounded sq-40"></span>';
																		} else {
																			echo '<span class="icon icon-eye bg-info rounded sq-40"></span>';
																		}
																		?>

																	</div>
																	<div class="notification-content">
																		<small class="notification-timestamp"><?php echo $not->datetime_notif; ?></small>
																		<h5 class="notification-heading"><?php echo $not->kind_notif; ?></h5>
																		<p class="notification-text">
																			<small class="truncate">
																				<?php 
																				if($not->status_notif == 0) {
																					echo "Not yead read or see";
																				} else {
																					echo "Already read or see";
																				}
																				?>
																			</small>
																		</p>
																	</div>
																</div>
															</a>
															<?php } } ?>

														</div>

													</div>
												</div>
											</div>
										</li>
									<?php endif; ?>
								<?php endif; ?>
								<li><a href="<?php echo base_url().index_with(); ?>editprofile">Edit Profile</a></li>
								<li><a href="<?php echo base_url().index_with(); ?>signout">Sign out</a></li>

								<li class="dropdown hidden-xs">
									<button class="navbar-account-btn">
										<img class="rounded" width="36" height="36" src="<?php if(isset($ava)) { echo base_url().$ava; } ;?>" alt="<?php echo $sess['name_user']; ?>"> <?php echo $sess['name_user']; ?>
									</button>
								</li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
			<div class="layout-main">
				<div class="layout-sidebar">
					<div class="layout-sidebar-backdrop"></div>
					<div class="layout-sidebar-body">
						<nav id="sidenav" class="sidenav-collapse collapse">
							<ul class="sidenav">

								<?php if(!empty($sess['user_status'])): ?>
									<?php if($sess['user_status'] == 1 || $sess['user_status'] == 2 || $sess['user_status'] == 3): ?>
										<li class="sidenav-heading">User Menu</li>

										<li class="sidenav-item <?php if(isset($active)) { if($active == 'dashboard') { echo 'active'; }} ?>">
											<a href="<?php echo base_url().index_with(); ?>dashboard">
												<span class="sidenav-icon icon icon-dashboard"></span>
												<span class="sidenav-label">Dashboard</span>
											</a>
										</li>

										<li class="sidenav-item has-subnav <?php if(isset($active)) { if($active == 'article') { echo 'active open'; }} ?>">
											<a href="#" aria-haspopup="true" aria-expanded="false">
												<span class="sidenav-icon icon icon-book"></span>
												<span class="sidenav-label">Article</span>
											</a>
											<ul class="sidenav-subnav collapse" aria-expanded="false">
												<li class="sidenav-subheading">Article</li>
												<li <?php if(isset($sub)) { if($active == 'article' && $sub == 'new') { echo 'class=active'; }} ?>><a href="<?php echo base_url().index_with(); ?>article/new">Add Article</a></li>
												<li <?php if(isset($sub)) { if($active == 'article' && $sub == 'list') { echo 'class=active'; }} ?>><a href="<?php echo base_url().index_with(); ?>article/list">List of Articles</a></li>
											</ul>
										</li>

			            <!-- <li class="sidenav-item has-subnav <?php if(isset($active)) { if($active == 'gallery') { echo 'active open'; }} ?>">
			              <a href="#" aria-haspopup="true" aria-expanded="false">
			                <span class="sidenav-icon icon icon-camera"></span>
			                <span class="sidenav-label">Gallery</span>
			              </a>
			              <ul class="sidenav-subnav collapse" aria-expanded="false">
			                <li class="sidenav-subheading">Gallery</li>
			                <li <?php if(isset($sub)) { if($active == 'gallery' && $sub == 'new') { echo 'class=active'; }} ?>><a href="<?php echo base_url().index_with(); ?>gallery/new">Add Gallery</a></li>
			                <li <?php if(isset($sub)) { if($active == 'gallery' && $sub == 'newalbum') { echo 'class=active'; }} ?>><a href="<?php echo base_url().index_with(); ?>gallery/newalbum">Add Album</a></li>
			                <li <?php if(isset($sub)) { if($active == 'gallery' && $sub == 'list') { echo 'class=active'; }} ?>><a href="<?php echo base_url().index_with(); ?>gallery/list">List of Gallerys</a></li>
			              </ul>
			          </li> -->

			          <li class="sidenav-item has-subnav <?php if(isset($active)) { if($active == 'video') { echo 'active open'; }} ?>">
			          	<a href="#" aria-haspopup="true" aria-expanded="false">
			          		<span class="sidenav-icon icon icon-video-camera"></span>
			          		<span class="sidenav-label">Video</span>
			          	</a>
			          	<ul class="sidenav-subnav collapse" aria-expanded="false">
			          		<li class="sidenav-subheading">Video</li>
			          		<li <?php if(isset($sub)) { if($active == 'video' && $sub == 'new') { echo 'class=active'; }} ?>><a href="<?php echo base_url().index_with(); ?>video/new"></span>Add Video</a></li>
			          		<li <?php if(isset($sub)) { if($active == 'video' && $sub == 'list') { echo 'class=active'; }} ?>><a href="<?php echo base_url().index_with(); ?>video/list">List of Videos</a></li>
			          	</ul>
			          </li>

			      <?php endif; ?>

			      <?php if($sess['user_status'] == 2 || $sess['user_status'] == 3): ?>

			      	<li class="sidenav-heading">Moderator Menu</li>

			      	<li class="sidenav-item has-subnav <?php if(isset($active)) { if($active == 'approval') { echo 'active open'; }} ?>">
			      		<a href="#" aria-haspopup="true" aria-expanded="false">
			      			<span class="sidenav-icon icon icon-gavel"></span>
			      			<span class="sidenav-label">Approval</span>
			      		</a>
			      		<ul class="sidenav-subnav collapse" aria-expanded="false">
			      			<li class="sidenav-subheading">Menu</li>
			      			<li <?php if(isset($sub)) { if($active == 'approval' && $sub == 'waiting') { echo 'class=active'; }} ?>><a href="<?php echo base_url().index_with(); ?>approval/waiting"></span>Waiting Approval</a></li>
			      			<li <?php if(isset($sub)) { if($active == 'approval' && $sub == 'approved') { echo 'class=active'; }} ?>><a href="<?php echo base_url().index_with(); ?>approval/approved">Content Approved</a></li>
			      		</ul>
			      	</li>		
			      <?php endif; ?>	          		

			      <?php if($sess['user_status'] == 3): ?>

			      	<li class="sidenav-heading">Super Admin Menu</li>

			      	<li class="sidenav-item <?php if(isset($active)) { if($active == 'menu') { echo 'active'; }} ?>">
			      		<a href="<?php echo base_url().index_with(); ?>menu">
			      			<span class="sidenav-icon icon icon-bars"></span>
			      			<span class="sidenav-label">Menu</span>
			      		</a>
			      	</li>

			      	<li class="sidenav-item has-subnav <?php if(isset($active)) { if($active == 'banner') { echo 'active open'; }} ?>">
			      		<a href="#" aria-haspopup="true" aria-expanded="false">
			      			<span class="sidenav-icon icon icon-flag"></span>
			      			<span class="sidenav-label">Banner</span>
			      		</a>
			      		<ul class="sidenav-subnav collapse" aria-expanded="false">
			      			<li class="sidenav-subheading">Banner</li>
			      			<li <?php if(isset($sub)) { if($active == 'banner' && $sub == 'new') { echo 'class=active'; }} ?>><a href="<?php echo base_url().index_with(); ?>banner/new">Add Banner</a></li>
			      			<li <?php if(isset($sub)) { if($active == 'banner' && $sub == 'list') { echo 'class=active'; }} ?>><a href="<?php echo base_url().index_with(); ?>banner/list">List of Banners</a></li>
			      		</ul>
			      	</li>

			      	<li class="sidenav-item has-subnav <?php if(isset($active)) { if($active == 'admin') { echo 'active open'; }} ?>">
			      		<a href="#" aria-haspopup="true" aria-expanded="false">
			      			<span class="sidenav-icon icon icon-user-secret"></span>
			      			<span class="sidenav-label">Admin</span>
			      		</a>
			      		<ul class="sidenav-subnav collapse" aria-expanded="false">
			      			<li class="sidenav-subheading">Admin</li>
			      			<li <?php if(isset($sub)) { if($active == 'admin' && $sub == 'new') { echo 'class=active'; }} ?>><a href="<?php echo base_url().index_with(); ?>admin/new">Add Admin</a></li>
			      			<li <?php if(isset($sub)) { if($active == 'admin' && $sub == 'list') { echo 'class=active'; }} ?>><a href="<?php echo base_url().index_with(); ?>admin/list">List of Admins</a></li>
			      		</ul>
			      	</li>

			      	<li class="sidenav-item has-subnav <?php if(isset($active)) { if($active == 'contributor') { echo 'active open'; }} ?>">
			      		<a href="#" aria-haspopup="true" aria-expanded="false">
			      			<span class="sidenav-icon icon icon-flag"></span>
			      			<span class="sidenav-label">Contributor</span>
			      		</a>
			      		<ul class="sidenav-subnav collapse" aria-expanded="false"> 
			      			<li class="sidenav-subheading">Contributor</li>
			      			<li <?php if(isset($sub)) { if($active == 'contributor' && $sub == 'waiting') { echo 'class=active'; }} ?>><a href="<?php echo base_url().index_with(); ?>contributor/waiting">Waiting For Approval</a></li>
			      			<li <?php if(isset($sub)) { if($active == 'contributor' && $sub == 'approved') { echo 'class=active'; }} ?>><a href="<?php echo base_url().index_with(); ?>contributor/approved">List of Contributor</a></li>
			      		</ul>
			      	</li>
			      <?php endif; ?>
			  <?php endif; ?>
			</ul>
		</nav>
	</div>
</div>
<div class="layout-content">
	<div class="layout-content-body">
		<div class="title-bar">
			<h1 class="title-bar-title"><?php if(isset($webtitle)) { echo $webtitle; } ?></h1>
			<p class="title-bar-description">
				<small><div id="todaysDate"></div></small>
			</p>

			<div class="row gutter-xs">
				<div class="card">
					<div class="card-body">
						<form class="form form-horizontal" action="" method="POST" enctype="multipart/form-data">
							<?php if($fileexist == TRUE) { ?>
							<div class="form-group">
								<label class="col-sm-2 control-label">Message</label>
								<div class="col-sm-9">
									<a href="<?php echo base_url().index_with().'article/list'; ?>" class="form-control">
										You have a draft of unfinished writing
									</a>
								</div>
							</div>
							<?php } ?>

							<div class="form-group">
								<label class="col-sm-2 control-label">Title</label>
								<div class="col-sm-9">
									<input autofocus="" class="form-control custom-select custom-select-lg" type="text" name="titlearticle" placeholder="Type title for article">
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">Content</label>
								<div class="col-sm-9">
									<b style="color: green">Kami menggunakan auto save untuk menghindari kehilangan tulisan, setelah mengupload gambar pada tulisan, ketik spasi atau lanjutkan menulis agar tulisan anda tersimpan </b>
									<textarea id="article" name="article" style="width: 100%;height: 400px"><?php if(isset($draf)) { echo $draf; } ?></textarea>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-control-6">Category</label>
								<div class="col-sm-9">
									<select id="parentMenu" class="form-control custom-select custom-select-lg" name="parentmenu">
										<option value="0">-Choose-</option>
										<?php foreach($menu as $row):?>
											<option value="<?php echo $row->id_menu;?>"><?php echo ucfirst($row->menu_name);?></option>
										<?php endforeach;?>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-control-6">Sub Category</label>
								<div class="col-sm-9">
									<select class="form-control childmenu custom-select custom-select-lg" name="childmenu">
										<option value="0">-Choose-</option>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label">Tags (optional)</label>
								<div class="col-sm-9">
									<input class="form-control custom-select custom-select-lg" type="text" name="tagscontent" placeholder="Type tag sparated with comas exm : news,world,animal">
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label" for="form-control-9">Thumbnail</label>
								<div class="col-sm-9">
									<label class="btn btn-success file-upload-btn">
										Choose Thumbnail
										<input class="file-upload-input" type="file" onchange="readURL(this);" accept="image/*" name="thumbnailarticle">
									</label>
									<br>
									<br>
									<img style="display: none" id="blah" src="#" alt="Chose your thumbnil" />
									<p class="help-block">
										<small>1 image can be uploaded to this field. Allowed types: png gif jpg jpeg.</small>
									</p>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-2"> 
								</div>
								<div class="col-sm-9">
									<!-- <button name="submit" value="drafarticle" type="submit" class="btn btn-info"> Save as Draft</button> -->
									<input id="filenameId" type="hidden" name="filenameTxt" value="<?php echo $filename; ?>">
									<button id="createarticle" name="submit" value="createarticle" type="submit" class="btn btn-success"> Post Article</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> 

<?php if($modals == 'true') { ?>
<div id="successModalAlert" tabindex="-1" role="dialog" class="modal fade in" style="display: block; padding-right: 17px;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="text-center">
					<span class="text-success icon icon-check icon-5x"></span>
					<h3 class="text-success">Success Create New Article</h3>
					<p>Wait admin approval for publish your article.</p>
					<div class="m-t-lg">
						<a href="<?php echo base_url().index_with(); ?>article/list" class="btn btn-success">List Articles</a>
						<a href="<?php echo base_url().index_with(); ?>article/new" class="btn btn-default">Create Again</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<!-- </div> -->


<div class="layout-footer">
	<div class="layout-footer-body">
		<small>All right reserved <a target="__blank" href="http://mobiwin.co.id">Mobiwin</a>.</small>
	</div>
</div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>layout/elephant/js/vendor.min.js"></script>
<script src="<?php echo base_url(); ?>layout/elephant/js/elephant.min.js"></script>
<script src="<?php echo base_url(); ?>layout/elephant/js/application.min.js"></script>

<script type="text/javascript">
	var baseurl = "<?php echo base_url(); ?>";
	var withindex = "<?php echo base_url().index_with(); ?>";
</script>

<!-- Include Editor JS files. -->
<script src="<?php echo base_url(); ?>layout/nicEdit/nicEdit.js"></script>
<script type="text/javascript">
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
	var userId = '<?php echo $sess['id_user']; ?>';
</script>

<!-- <script src="<?php echo base_url(); ?>layout/froala/js/plugins/image.min.js"></script>
	<script src="<?php echo base_url(); ?>layout/froala/js/plugins/link.min.js"></script> -->
	<!-- <script src="<?php echo base_url(); ?>layout/froala/js/plugins/link.js"></script> -->
	<!-- Initialize the editor. -->

	<script type="text/javascript">
		$(document).ready(function(){
			<?php if($filename != '.txt') { ?>
				var randpageid = '<?php echo substr($filename, 0,-4); ?>';
			<?php } else { ?>
				var randpageid = '<?php if(isset($randompageid)) { echo $randompageid; } ?>';
			<?php } ?>
			
			$('#filenameId').val(randpageid);

			$("#successModalAlert").modal({
				backdrop: false
			});

			$('#blah').hide();

			$('#parentMenu').change(function(){
				var id=$(this).val();

				if(id == 0) {
					html += '<option value="0">-Choose-</option>';
					$('.childmenu').html(html);
				} else {
					var html = '';
					$.ajax({
						url : "<?php echo base_url().index_with(); ?>article/submenu",
						method : "POST",
						data : {id: id,vals: 'getsubmenu'},
						async : false,
						dataType : 'json',
						success: function(data){

							var i;
							for(i=0; i<data.length; i++){
								html += '<option value='+data[i].id_sub+'>'+data[i].sub_name+'</option>';
							}
							$('.childmenu').html(html);

						}
					});
				}
			});

			var delay = (function(){
			  	var timer = 0;
			  	return function(callback, ms){
			    	clearTimeout (timer);
			    	timer = setTimeout(callback, ms);
			  	};
			})();

			nicEditors.allTextAreas();
		    $("div.nicEdit-main").keyup(function () {

		        if ($(this).text().length > 10) {

		        	var kontent = $(this).html();

		        	delay(function(){
			            $.ajax({
							url : "<?php echo base_url().index_with(); ?>article/autosave",
							method : "POST",
							data : {id: userId,rand: randpageid,vals: kontent},
							async : false,
							dataType : 'json',
							success: function(data){

							}
						});
					}, 5000);
		        }
		    });
		});
	</script>
</body>
</html>