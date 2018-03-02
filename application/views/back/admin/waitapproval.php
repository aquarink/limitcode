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
							<th class="text-left">Read</th>
							<th class="text-left">Comment</th>
							<th class="text-left">Title</th>
							<th class="text-left">Kind</th>
							<th class="text-left">Category</th>
							<th class="text-left">Sub Category</th>
							<th class="text-left">Writer</th>
							<th class="text-left">Status</th>
							<th class="text-left">Publish Date</th>
							<th class="text-center">Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($contents as $id => $content): ?>
							<tr>
								<td class="text-left"><?php echo ucwords($content['wtch']); ?></td>
								<td class="text-left"><?php echo ucwords($content['cmnt']); ?></td>
								<td class="text-left">
									<?php 
									if(strlen($content['title']) > 25) {
										echo ucwords(substr($content['title'],0,25)).' ...';
									} else {
										echo ucwords($content['title']);
									}
									?>
										
									</td>
								<td class="text-left"><?php if($content['kind'] == 1) { echo '<b>Article</b>'; } else {echo "<b>Video</b>";}  ?></td>
								<td class="text-left"><?php echo ucwords($content['menu']); ?></td>
								<td class="text-left"><?php echo ucwords($content['sub']); ?></td>
								<td class="text-left"><?php echo ucwords($content['uname']); ?></td>
								<td class="text-left"><?php if($content['stat'] == 0) { echo '<span style=color:#d9831f>Waiting Approval</span>'; } else {echo "<span style=color:#469408>Publish</span>";}  ?></td>
								<td class="text-left"><?php echo ucwords($content['datearticle']); ?></td>
								<td class="text-center">
									<div class="dropdown">
										<button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" type="button">
											More
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu dropdown-menu-right">
											<!-- <li class="disabled"><a href="#">Turn On</a></li> -->
											<li><a href="<?php echo base_url().index_with(); ?>approval/publish/<?php echo $id; ?>"><span class="icon icon-thumbs-up"></span> Publish</a></li>
											<li><a data-toggle="modal" data-target="#reject<?php echo  $id; ?>" href="#"><span class="icon icon-thumbs-down"></span> Reject</a></li>
											<li role="separator" class="divider"></li>
											<li><a href="<?php echo base_url().index_with(); ?>approval/preview/<?php echo $id; ?>"><span class="icon icon-eye"></span> Preview</a></li>

										</ul>
									</div>
								</td>
							</tr>

							<div id="reject<?php echo $id; ?>" role="dialog" class="modal fade">
								<div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header bg-default">
											<h4 class="modal-title">Reject Message</h4>
										</div>
										<div class="modal-body">
											<form action="<?php echo base_url().index_with(); ?>approval/reject" method="POST">
												<div class="form-group">
													<label class="control-label">Reason</label>
													<textarea required class="form-control" name="reason" placeholder="Type reject reason message for user posted article or video"></textarea>
													<input type="hidden" name="reasonid" value="<?php echo $id; ?>">
													<input type="hidden" name="from" value="<?php echo $from; ?>">
												</div>
												<button name="submit" class="btn btn-default" type="submit" value="sendreject">Send Reject Reason</button>
											</form>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
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