<div class="layout-content">
	<div class="layout-content-body">
		<div class="title-bar">
			<h1 class="title-bar-title"><?php if(isset($webtitle)) { echo $webtitle; } ?></h1>
			<p class="title-bar-description">
				<small><div id="todaysDate"></div></small>
			</p>
		</div>

		<?php if(isset($videos)): ?>
			<?php foreach($videos as $id => $video): ?>				
				<div class="row gutter-xs">
					<div class="col-sm-6 col-md-3">
						<div class="card">
							<div class="card-content">
								<a class="overlay overlay-hover" href="<?php echo base_url().index_with(); ?>video/preview/<?php echo $id; ?>">
									<div class="overlay-image">
										<img style="height: 199px; width: 100%" class="card-img-top img-responsive" src="<?php if(empty($video['thumbnail'])) { echo base_url().'layout/img/no-thumbnail.jpg'; } else {echo base_url().$video['thumbnail'];} ?>" alt="Restaurant Magnifique" />
									</div>
									<div class="overlay-gradient"></div>
									<div class="overlay-content">
										<div class="overlay-content overlay-top">
											<h4 class="overlay-title"><?php echo ucwords($video['title']); ?></h4>
										</div>
										<div class="overlay-content overlay-bottom overlay-slide-up">
											<div class="media">
												<div class="media-left media-middle">
													<!-- <img class="media-object img-circle" width="32" height="32" src="img/0189082606.jpg" alt="Ella Davis"> -->
												</div>
												<div class="media-body media-middle">
													<em>status</em>
													<strong><?php if($video['stat'] == 0) { echo '<span style=color:#d9831f>Waiting Approval</span>'; } elseif($video['stat'] == 3) {echo "<span style=color:#ff0b0b>Blocked</span>";} elseif($video['stat'] == 2) {echo "<span style=color:#1fd0d9>Rejected</span>";} elseif($video['stat'] == 6) {echo "<span style=color:#b5790c>Spam</span>";}else {echo "<span style=color:#469408>Publish</span>";}  ?>
													</strong>
												</div>
											</div>
										</div>
									</div>
								</a>
							</div>
							<div class="card-footer">
								<small>
									<span class="icon icon-eye"></span>
									<?php echo ucwords($video['wtch']); ?>
									<br>
									<span class="icon icon-comment"></span>
									<?php echo ucwords($video['cmnt']); ?>
									<br>
									<span class="icon icon-bullhorn"></span>
									<?php echo substr(ucwords($video['describ']),0,35); ?>
								</small>
							</div>
						</div>
					</div>

				<?php endforeach; ?>
			<?php endif; ?>
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