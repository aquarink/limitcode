<div class="layout-content">
	<div class="layout-content-body">
		<div class="title-bar">
			<h1 class="title-bar-title">
				<?php if(isset($webtitle)) { echo $webtitle; } ?>
				<?php 
				if($stat == 0) {
					echo '<span class="badge badge-info">Waiting Approval</span> ';

					echo '<a href='.base_url().index_with().'video/delete/'.$id.' class="btn btn-sm btn-labeled arrow-left arrow-warning" href="#">
		                  Delete
		                  <span class="btn-label btn-label-right">
		                    <span class="icon icon-trash icon-lg icon-fw"></span>
		                  </span>
		                </a>';
				} elseif($stat == 2) {
					echo '<span class="badge badge-danger">Rejected</span> ';

					echo '<a href='.base_url().index_with().'video/edit/'.$id.' class="btn btn-sm btn-labeled arrow-left arrow-info" href="#">
		                  Edit
		                  <span class="btn-label btn-label-right">
		                    <span class="icon icon-pencil icon-lg icon-fw"></span>
		                  </span>
		                </a>';

					echo '<a href='.base_url().index_with().'video/delete/'.$id.' class="btn btn-sm btn-labeled arrow-left arrow-warning" href="#">
		                  Delete
		                  <span class="btn-label btn-label-right">
		                    <span class="icon icon-trash icon-lg icon-fw"></span>
		                  </span>
		                </a>';
				} elseif($stat == 3) {
					echo '<span class="badge badge-primary">Blocked</span> ';
					
					echo '<a href='.base_url().index_with().'video/delete/'.$id.' class="btn btn-sm btn-labeled arrow-left arrow-warning" href="#">
		                  Delete
		                  <span class="btn-label btn-label-right">
		                    <span class="icon icon-trash icon-lg icon-fw"></span>
		                  </span>
		                </a>';
				} elseif($stat == 6) {
					echo '<span class="badge badge-danger">Spam</span> ';
					
					echo '<a href='.base_url().index_with().'video/edit/'.$id.' class="btn btn-sm btn-labeled arrow-left arrow-info" href="#">
		                  Edit
		                  <span class="btn-label btn-label-right">
		                    <span class="icon icon-pencil icon-lg icon-fw"></span>
		                  </span>
		                </a>';

					echo '<a href='.base_url().index_with().'video/delete/'.$id.' class="btn btn-sm btn-labeled arrow-left arrow-warning" href="#">
		                  Delete
		                  <span class="btn-label btn-label-right">
		                    <span class="icon icon-trash icon-lg icon-fw"></span>
		                  </span>
		                </a>';
				}
				else {
					echo '<span class="badge badge-success">Publish</span> ';
					echo '<a href="'.base_url().index_with().'video/delete/'.$id.'"><small><i class="icon icon-trash"></i> Delete</small></a>';
				}
				?>
			</h1>
			<p class="title-bar-description">
				<small>Created on : <?php if(isset($content_create)) { echo $content_create; } ?></small>
				<br>
				<small>Category : <?php if(isset($menu_sub)) { echo $menu_sub; } ?></small>
			</p>
		</div>

		<div class="card">
			<div class="card-body">
				<?php if(isset($kind)) { 
					if($kind == 2) {
						?>
						<div class="col-sm-3 col-md-3"></div>
						<div class="col-sm-6 col-md-6">
							<video width="400" controls>
								<source src="<?php echo base_url().$video; ?>" type="video/mp4">
									Your browser does not support HTML5 video.
								</video>
							</div>
							<div class="col-sm-3 col-md-3"></div>
							<?php
							echo "<div class='col-sm-12 col-md-12'><h4>Description :</h4>$contents</div>";
						} else {
							echo nl2br($contents);
						}
					} ?>

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
														<input type="hidden" name="iduser" value="<?php echo 1; ?>">
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
		</div>
	</div>