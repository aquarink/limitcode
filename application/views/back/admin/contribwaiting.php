<div class="layout-content">
	<div class="layout-content-body">
		<div class="title-bar">
			<h1 class="title-bar-title"><?php if(isset($webtitle)) { echo $webtitle; } ?></h1>
			<p class="title-bar-description">
				<small><div id="todaysDate"></div></small>
			</p>
		</div>

		<div class="row gutter-xs">
			<div class="card-body" data-toggle="match-height">
				<h5 style="color: red"><?php if(isset($e)) { echo $e; }?></h5>
				<table class="table table-hover table-bordered table-striped">
					<thead style="background-color: #242323;color: #fff;">
						<tr>
							<th class="text-left">User Name</th>
							<th class="text-left">Email Register</th>
							<th class="text-left">Gender</th>
							<th class="text-left">Registered By</th>
							<th class="text-left">Register Date</th>
							<th class="text-left">Email Verified</th>
							<th class="text-left">User Status</th>
							<th class="text-center">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php if(isset($userdata)): ?>
						<?php foreach($userdata as $key => $user): ?>
							<tr>
								<td class="text-left"><?php echo ucwords($user->name_user); ?></td>
								<td class="text-left"><?php echo ucwords($user->email_user); ?></td>
								<td class="text-left"><?php echo ucwords($user->gender_user); ?></td>
								<td class="text-left"><?php echo ucwords($user->auth_by); ?></td>
								<td class="text-left"><?php echo ucwords($user->register_date); ?></td>
								<td class="text-left">
									<?php 
									if($user->verify == 0) { 
										echo '<span style=color:#d9831f>Not Yet Verified</span>'; 
									} else {
										echo "<span style=color:#469408>Verified</span>";
									}  
									?>										
								</td>
								<td class="text-left">
									<?php 
									if($user->user_status == 0) { 
										echo '<span style=color:#84815e>Not Yet Verified By Admin</span>';
									} elseif($user->user_status == 1) { 
										echo '<span style=color:#358869>Contributor</span>'; 
									} elseif($user->user_status == 2) { 
										echo '<span style=color:#d9831f>Moderator</span>'; 
									} else {
										echo "<span style=color:#ff0000>Super Admin</span>";
									}  
									?>										
								</td>

								<td class="text-center">
									<?php 
									if($user->verify != 0): ?>
									<div class="dropdown">
										<button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" type="button">
											More
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu dropdown-menu-right">
											<!-- <li class="disabled"><a href="#">Turn On</a></li> -->
											<li><a href="<?php echo base_url().index_with(); ?>contributor/approve/<?php echo $user->id_user; ?>"><span class="icon icon-thumbs-up"></span> Approve</a></li>

											<li role="separator" class="divider"></li>

											<li><a data-toggle="modal" data-target="#adminreject<?php echo  $user->id_user; ?>" href="#"><span class="icon icon-thumbs-down"></span> Reject</a></li>
										</ul>
									</div>
								<?php endif; ?>
								</td>
							</tr>

							<div id="adminreject<?php echo $user->id_user; ?>" role="dialog" class="modal fade">
								<div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header bg-default">
											<h4 class="modal-title">Reject Message</h4>
										</div>
										<div class="modal-body">
											<form action="<?php echo base_url().index_with(); ?>contributor/reject" method="POST">
												<div class="form-group">
													<label class="control-label">Reason</label>
													<textarea required class="form-control" name="reason" placeholder="Type reject reason message for reject this user"></textarea>
													<input type="hidden" name="userid" value="<?php echo $user->id_user; ?>">
												</div>
												<button name="submit" class="btn btn-default" type="submit" value="sendreject">Send Reject Reason</button>
											</form>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
					</tbody>
				</table>
			</div>
			<div class="card-body" data-toggle="match-height">
				<div class="pagination">
					<?php if (isset($pagination)) { ?>
					<?php echo $pagination ?>
					<?php } ?>
					<li class="paginate_button"><a><strong><?php if (isset($show)) { echo $show; } ?></strong></a></li>
				</div>
			</div>
		</div>
	</div>
</div>