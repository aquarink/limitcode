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
				<table class="table table-hover table-bordered table-striped">
					<thead style="background-color: #242323;color: #fff;">
						<tr>
							<th class="text-left">Title</th>
							<th class="text-left">Advertiser</th>
							<th class="text-left">Position</th>
							<th class="text-left">Width</th>
							<th class="text-left">Height</th>
							<th class="text-left">Image</th>
							<th class="text-left">Status</th>
							<th class="text-left">Create Date</th>
							<th class="text-center">Actions</th>
						</tr>
					</thead>
					<tbody>

						<?php if(isset($ads)): ?>
							<?php foreach($ads as $k => $v): ?>
								<tr>
									<td class="text-left"><?php echo $v->ad_title; ?></td>
									<td class="text-left"><?php echo $v->advertiser; ?></td>
									<td class="text-left"><?php echo $v->ad_postition; ?></td>
									<td class="text-left"><?php echo $v->ad_width; ?></td>
									<td class="text-left"><?php echo $v->ad_height; ?></td>								
									<td class="text-left">
										<a href="#" data-toggle="modal" data-target="#banners<?php echo $v->id_ad; ?>" data-backdrop="false"> Banner</a>

										<div class="modal fade" id="banners<?php echo $v->id_ad; ?>" role="dialog" aria-labelledby="<?php echo $v->ad_title; ?>" aria-hidden="true">
											<div class="modal-dialog" role="document">
												<div class="modal-content">
													<div class="modal-body">
														<center><img alt="<?php echo $v->ad_title; ?> with <?php echo $v->advertiser; ?>" class="img img-responsve" style="width: 465px" src="<?php echo base_url().$v->ad_path; ?>"></center>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
													</div>
												</div>
											</div>
										</div>
									</td>
									<td class="text-left">Active</td>
									<td class="text-left">2012-12-12</td>
									<td class="text-center">
										<div class="dropdown">
											<button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" type="button">
												More
												<span class="caret"></span>
											</button>
											<ul class="dropdown-menu dropdown-menu-right">
												<!-- <li class="disabled"><a href="#">Turn On</a></li> -->
												<li><a href="<?php echo base_url().index_with(); ?>banner/edit/1"><span class="icon icon-pencil"></span> Edit</a></li>
												<li role="separator" class="divider"></li>
												<li><a href="<?php echo base_url().index_with(); ?>banner/active/1"><span class="icon icon-eye"></span> Active</a></li>
												<li><a href="<?php echo base_url().index_with(); ?>banner/disable/1"><span class="icon icon-ban"></span> Disable</a></li>


											</ul>
										</div>
									</td>
								</tr>
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