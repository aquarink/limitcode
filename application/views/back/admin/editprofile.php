<div class="layout-content">
	<div class="layout-content-body">
		<div class="title-bar">
			<h1 class="title-bar-title"><?php if(isset($webtitle)) { echo $webtitle.' of '.$sess['name_user']; } ?></h1
				<p class="title-bar-description">
					<small><div id="todaysDate"></div></small>
				</p>

				<div class="row gutter-xs">
					<div class="card">
						<div class="card-body">
							<form class="form form-horizontal" action="" method="POST" enctype="multipart/form-data">
								<div class="form-group">
									<label class="col-sm-2 control-label">Email</label>
									<div class="col-sm-9">
										<input disabled class="form-control custom-select custom-select-lg" type="email" value="<?php echo $sess['email_user']; ?> : email can not change">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label">Name</label>
									<div class="col-sm-9">
										<input class="form-control custom-select custom-select-lg" type="text" name="nameuser" placeholder="Type your full name" required="" value="<?php echo $sess['name_user']; ?>">
										<input name="iduser" type="hidden" required="" value="<?php echo $sess['id_user']; ?>">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-control-9">Avatar</label>
									<div class="col-sm-9">
										<label class="btn btn-success file-upload-btn">
											Choose Avatar
											<input class="file-upload-input" type="file" onchange="readImageThumPop(this);" accept="image/*" name="avatar">
										</label>
										<br>
										<br>
										<img style="" id="blah" src="<?php echo base_url().$ava;?>" alt="Choose Avatar" />
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

										<button name="submit" value="updateprofile" type="submit" class="btn btn-info"> Update Profile</button>
									</div>
								</div>
							</form>
						</div>
					</div>

					<div class="card">
						<div class="card-body">
							<h4>Verify Your Self</h4>
							<form class="form form-horizontal" action="" method="POST" enctype="multipart/form-data">
								<div class="form-group">
									<label class="col-sm-2 control-label" for="form-control-9">Image of ID Card</label>
									<div class="col-sm-9">
										<label class="btn btn-success file-upload-btn">
											Choose Image
											<input required="" class="file-upload-input" type="file" onchange="readImageThumPopKtp(this);" accept="image/*" name="ktpImage">
										</label>
										<br>
										<br>
										<img style="" id="blahKtp" src="<?php echo base_url().$ktp;?>" alt="Choose Image" />
										<p class="help-block">
											<small>1 image can be uploaded to this field. Allowed types: png gif jpg jpeg.</small>
										</p>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-2"> 
									</div>
									<div class="col-sm-9">
										<button id="ktp" name="submit" value="ktp" type="submit" class="btn btn-success"> Send Verify</button>
									</div>
								</div>
							</form>
						</div>
					</div>

					<div class="card">
						<div class="card-body">
							<h4>Change Password</h4>
							<form class="form form-horizontal" action="" method="POST" enctype="multipart/form-data">
								<div class="form-group">
									<label class="col-sm-2 control-label">Password</label>
									<div class="col-sm-9">
										<input class="form-control custom-select custom-select-lg" type="password" name="passworduser" minlength="6" placeholder="Type your passworde" required="" id="pass">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label">Re-Password</label>
									<div class="col-sm-9">
										<input class="form-control custom-select custom-select-lg" type="password" name="repassworduser" minlength="6" placeholder="Type again your password" required="" id="repass">
										<input name="iduser" type="hidden" required="" value="<?php echo $sess['id_user']; ?>">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-2"> 
									</div>
									<div class="col-sm-9">
										<button id="changepassbtn" disabled name="submit" value="changepassword" type="submit" class="btn btn-warning"> Change Password</button>
									</div>
								</div>
							</form>
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
							<h3 class="text-success">Success Update Your Profile</h3>
							<p>Name or your avatar has been updated.</p>
							<div class="m-t-lg">
								<a href="<?php echo base_url().index_with(); ?>editprofile" class="btn btn-default">Close</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>

		<?php if(!empty($errors)) { ?>
		<div id="successModalAlert" tabindex="-1" role="dialog" class="modal fade in" style="display: block; padding-right: 17px;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body">
						<div class="text-center">
							<span class="text-danger icon icon-check icon-5x"></span>
							<h3 class="text-danger">Failed Update Your Profile</h3>
							<p><?php echo $errors; ?>.</p>
							<div class="m-t-lg">
								<a href="<?php echo base_url().index_with(); ?>editprofile" class="btn btn-default">Close</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>

	</div>