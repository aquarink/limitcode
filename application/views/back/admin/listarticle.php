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
						<?php if(isset($forderMap)) { ?>
						<?php foreach($forderMap as $file) {?>
							<tr>
								<td class="text-left">draf</td>
								<td class="text-left">draf</td>
								<td class="text-left"><?php echo ucwords(substr($file, 0,-4)); ?></td>
								<td class="text-left">draf</td>
								<td class="text-left">draf</td>
								<td class="text-left">draf</td>
								<td class="text-left">draf</td>
								<td class="text-left">draf</td>
								<td class="text-left">draf</td>
								<td class="text-center">
									<div class="dropdown">
										<button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" type="button">
											More
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu dropdown-menu-right">
											<li><a href="<?php echo base_url().index_with(); ?>article/new/<?php echo substr($file, 0,-4); ?>"><span class="icon icon-pencil"></span> Edit</a></li>
											<li role="separator" class="divider"></li>
											<li><a href="<?php echo base_url().index_with(); ?>article/deldraf/<?php echo substr($file, 0,-4); ?>"><span class="icon icon-trash"></span> Delete</a></li>
										</ul>
									</div>
								</td>
							</tr>
						<?php } } ?>

						<?php foreach($articles as $id => $article): ?>
							<tr>
								<td class="text-left"><?php echo ucwords($article['wtch']); ?></td>
								<td class="text-left"><?php echo ucwords($article['cmnt']); ?></td>
								<td class="text-left">
									<?php 
									if(strlen($article['title']) > 50) {
										$ttl = ucwords(substr($article['title'],0,50)).' ...';
									} else {
										$ttl = ucwords($article['title']);
									}

									if($article['stat'] == 1) {
										echo '<a target="__blank" href="'.$article['link'].'">'.$ttl.'</a>';
									} else {
										echo $ttl;
									}
									?>
										
									</td>
								<td class="text-left"><?php if($article['kind'] == 1) { echo '<b>Article</b>'; } else {echo "<b>Video</b>";}  ?></td>
								<td class="text-left"><?php echo ucwords($article['menu']); ?></td>
								<td class="text-left"><?php echo ucwords($article['sub']); ?></td>
								<td class="text-left"><?php echo ucwords($article['uname']); ?></td>
								<td class="text-left"><?php if($article['stat'] == 0) { echo '<span style=color:#d9831f>Waiting Approval</span>'; } elseif($article['stat'] == 3) {echo "<span style=color:#ff0b0b>Blocked</span>";} elseif($article['stat'] == 2) {echo "<span style=color:#1fd0d9>Rejected</span>";} else {echo "<span style=color:#469408>Publish</span>";}  ?></td>
								<td class="text-left"><?php echo ucwords($article['datearticle']); ?></td>
								<td class="text-center">
									<div class="dropdown">
										<button class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" type="button">
											More
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu dropdown-menu-right">
											<!-- <li class="disabled"><a href="#">Turn On</a></li> -->
											<?php if($article['stat'] == 2) { ?>
											<li><a href="<?php echo base_url().index_with(); ?>article/edit/<?php echo $id; ?>"><span class="icon icon-pencil"></span> Edit</a></li>
											<?php } ?>
											<li><a href="<?php echo base_url().index_with(); ?>article/preview/<?php echo $id; ?>"><span class="icon icon-eye"></span> Preview</a></li>
											<li role="separator" class="divider"></li>
											<li><a href="<?php echo base_url().index_with(); ?>article/delete/<?php echo $id; ?>"><span class="icon icon-trash"></span> Delete</a></li>
											
										</ul>
									</div>
								</td>
							</tr>
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