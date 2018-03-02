<div class="layout-content">
	<div class="layout-content-body">
		<div class="title-bar">
			<input type="hidden" id="todaysDate">
			<h1 class="title-bar-title"> 
				<?php if(isset($webtitle)) { echo $webtitle; } ?>
				<?php 
				if(isset($stat)) { 
					if($stat == 0) {
						echo '<span class="badge badge-info">Waiting Approval</span> ';

						echo '<a href='.base_url().index_with().'article/delete/'.$id.' class="btn btn-sm btn-labeled arrow-left arrow-warning" href="#">
			                  Delete
			                  <span class="btn-label btn-label-right">
			                    <span class="icon icon-trash icon-lg icon-fw"></span>
			                  </span>
			                </a>';
					} elseif($stat == 2) {
						echo '<span class="badge badge-danger">Rejected</span> ';

						echo '<a href='.base_url().index_with().'article/edit/'.$id.' class="btn btn-sm btn-labeled arrow-left arrow-info" href="#">
			                  Edit
			                  <span class="btn-label btn-label-right">
			                    <span class="icon icon-pencil icon-lg icon-fw"></span>
			                  </span>
			                </a>';
						
						echo '<a href='.base_url().index_with().'article/delete/'.$id.' class="btn btn-sm btn-labeled arrow-left arrow-warning" href="#">
			                  Delete
			                  <span class="btn-label btn-label-right">
			                    <span class="icon icon-trash icon-lg icon-fw"></span>
			                  </span>
			                </a>';
					} elseif($stat == 3) {
						echo '<span class="badge badge-primary">Blocked</span> ';
						
						echo '<a href='.base_url().index_with().'article/delete/'.$id.' class="btn btn-sm btn-labeled arrow-left arrow-warning" href="#">
			                  Delete
			                  <span class="btn-label btn-label-right">
			                    <span class="icon icon-trash icon-lg icon-fw"></span>
			                  </span>
			                </a>';
					} elseif($stat == 6) {
						echo '<span class="badge badge-warning">Spam</span> ';
						
						echo '<a href='.base_url().index_with().'article/edit/'.$id.' class="btn btn-sm btn-labeled arrow-left arrow-info" href="#">
			                  Edit
			                  <span class="btn-label btn-label-right">
			                    <span class="icon icon-pencil icon-lg icon-fw"></span>
			                  </span>
			                </a>';

						echo '<a href='.base_url().index_with().'article/delete/'.$id.' class="btn btn-sm btn-labeled arrow-left arrow-warning" href="#">
			                  Delete
			                  <span class="btn-label btn-label-right">
			                    <span class="icon icon-trash icon-lg icon-fw"></span>
			                  </span>
			                </a>';
					}
					else {
						echo '<span class="badge badge-success">Publish</span> ';

						echo '<a href='.base_url().index_with().'article/delete/'.$id.' class="btn btn-sm btn-labeled arrow-left arrow-warning" href="#">
			                  Delete
			                  <span class="btn-label btn-label-right">
			                    <span class="icon icon-trash icon-lg icon-fw"></span>
			                  </span>
			                </a>';
					}
				} 
				?>
			</h1>
			<p class="title-bar-description">
				<small>Created on : <?php if(isset($content_create)) { echo $content_create; } ?></small>
				<br>
				<small>Category : <?php if(isset($menu_sub)) { echo $menu_sub; } ?></small>
			</p>
			<br>
			<?php if(isset($reject)): ?>
				<?php foreach($reject as $r): ?>				
					<?php if(!empty($r->id_reject)): ?>
						<?php if($r->status_reject == 1): ?>
							<span style="margin-bottom: 10px" class="label label-outline-danger">
								You content rejected with reason : <?php echo $r->reason_rejected; ?>
							</span>
						<?php endif; ?>			
					<?php endif; ?>			
				<?php endforeach; ?>
			<?php endif; ?>
		</div>

		<div class="card">
			<div class="card-body">
				<?php if(isset($contents)) { echo nl2br($contents); } ?>
			</div>
		</div>		

		<?php if(isset($stat)): ?>
			<?php if($stat == 1): ?>
				<div class='col-sm-12 col-md-12'><h4>Comments : <?php if(isset($errors)) { echo $errors;} ?></h4></div>

				<?php if(isset($comments)): ?>
					<?php foreach($comments as $comment): ?>
						<div class='col-sm-12 col-md-12'>
							<div class="media">
								<div class="media-left">
									<img class="img-circle" width="32" height="32" src="http://demo.madebytilde.com/elephant-v1.4.0/theme-7/img/0180441436.jpg" alt="<?php echo $comment->nameuser; ?>">
								</div>
								<div class="media-body">
									<h5 class="m-y-0"><?php echo $comment->nameuser; ?> <small><?php echo $comment->timedate; ?></small></h5>
									<p>
										<?php echo $comment->comm; ?>
									</p>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
					<form action="" method="POST">
						<div class="col-sm-9">
							<div class="input-group">
								<input class="form-control" type="text" name="reply" placeholder="Reply comment">
								<span class="input-group-btn">
									<label class="btn btn-success file-upload-btn">
										<input id="form-control-22" class="file-upload-input" type="submit" name="submit" value="replybtn">
										<span class="icon icon-send icon-lg"></span>
									</label>
								</span>
							</div>
						</div>
					</form>
				<?php endif; ?>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</div>