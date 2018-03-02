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
<div class="layout-content">
	<div class="layout-content-body">
		<div class="title-bar">
			<h1 class="title-bar-title">
				<?php if(isset($webtitle)) { echo $webtitle; } ?> 
				<?php 
				if(isset($stat)) { 
					if($stat == 0) {
						echo '<span class="badge badge-info">Waiting Approval</span> ';

						echo '<a href='.base_url().index_with().'approval/publish/'.$id.' class="btn btn-sm btn-labeled arrow-left arrow-success" href="#">
			                  Publish
			                  <span class="btn-label btn-label-right">
			                    <span class="icon icon-thumbs-up icon-lg icon-fw"></span>
			                  </span>
			                </a>';

						echo '<a data-toggle="modal" data-target=#reject'.$id.' class="btn btn-sm btn-labeled arrow-left arrow-danger" href="#">
			                  Reject
			                  <span class="btn-label btn-label-right">
			                    <span class="icon icon-thumbs-down icon-lg icon-fw"></span>
			                  </span>
			                </a>';
					} elseif($stat == 2) {
						echo '<span class="badge badge-danger">Rejected</span> ';

						echo '<a href='.base_url().index_with().'approval/edit/'.$id.' class="btn btn-sm btn-labeled arrow-left arrow-info" href="#">
			                  Edit
			                  <span class="btn-label btn-label-right">
			                    <span class="icon icon-pencil icon-lg icon-fw"></span>
			                  </span>
			                </a>';

						echo '<a href='.base_url().index_with().'approval/delete/'.$id.' class="btn btn-sm btn-labeled arrow-left arrow-warning" href="#">
			                  Delete
			                  <span class="btn-label btn-label-right">
			                    <span class="icon icon-trash icon-lg icon-fw"></span>
			                  </span>
			                </a>';
					} elseif($stat == 3) {
						echo '<span class="badge badge-primary">Blocked</span> ';
						
						echo '<a href='.base_url().index_with().'approval/delete/'.$id.' class="btn btn-sm btn-labeled arrow-left arrow-warning" href="#">
			                  Delete
			                  <span class="btn-label btn-label-right">
			                    <span class="icon icon-trash icon-lg icon-fw"></span>
			                  </span>
			                </a>';
					} elseif($stat == 6) {
						echo '<span class="badge badge-danger">Spam</span> ';
						
						echo '<a href='.base_url().index_with().'approval/edit/'.$id.' class="btn btn-sm btn-labeled arrow-left arrow-info" href="#">
			                  Edit
			                  <span class="btn-label btn-label-right">
			                    <span class="icon icon-pencil icon-lg icon-fw"></span>
			                  </span>
			                </a>';

						echo '<a href='.base_url().index_with().'approval/delete/'.$id.' class="btn btn-sm btn-labeled arrow-left arrow-warning" href="#">
			                  Delete
			                  <span class="btn-label btn-label-right">
			                    <span class="icon icon-trash icon-lg icon-fw"></span>
			                  </span>
			                </a>';
					}
					else {
						echo '<span class="badge badge-success">Publish</span> ';
						echo '<a href="'.base_url().index_with().'approval/delete/'.$id.'"><small><i class="icon icon-trash"></i> Delete</small></a>';
					}
				} 
				?>
			</h1>
			<p class="title-bar-description">
				<small>Created on : <?php if(isset($content_create)) { echo $content_create; } ?></small>
				<br>
				<small>Category : <?php if(isset($menu_sub)) { echo $menu_sub; } ?></small>
				<br>
				<h3 style="color: red"><?php if(isset($e)) { echo $e; }?></h3>
			</p>
		</div>
		<div class="card">
			<div class="card-body">
				<?php if(isset($kind)) { 
					if($kind == 2) {
						?>
						<video width="400" controls>
							<source src="<?php echo base_url().$video; ?>" type="video/mp4">
								Your browser does not support HTML5 video.
							</video>
							<?php
							echo "<h4>Description :</h4>".$contents;
						} else {
							echo nl2br($contents);
						}
					} ?>
				</div>
			</div>		
		</div>
	</div>