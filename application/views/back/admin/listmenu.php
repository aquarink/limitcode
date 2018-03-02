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
				<div style="margin-bottom: 20px">
					<button class="btn btn-success btn-sm btn-labeled" type="button" data-toggle="modal" data-target="#successModalAlert">
						<span class="btn-label">
							<span class="icon icon-plus icon-lg icon-fw"></span>
						</span>
						Add Menu
					</button>

					<button class="btn btn-info btn-sm btn-labeled" type="button" " data-toggle="modal" data-target="#successModalAlert2">
						<span class="btn-label">
							<span class="icon icon-plus icon-lg icon-fw"></span>
						</span>
						Add Sub Menu
					</button>
				</div>


				<!-- Menu Modals -->
				<div id="successModalAlert" role="dialog" class="modal fade">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<div class="modal-header bg-success">
								<h4 class="modal-title">Create new menu</h4>
							</div>
							<div class="modal-body">
								<form action="menu/new" method="POST">
									<div class="form-group">
										<label class="control-label">New Menu Name</label>
										<input autofocus="" class="form-control" type="text" name="menuname">
									</div>
									<button name="submit" class="btn btn-success btn-block btn-next" type="submit" value="menu">Create Menu</button>
								</form>
							</div>
						</div>
					</div>
				</div>

				<!-- Sub Menu Modals -->
				<div id="successModalAlert2" role="dialog" class="modal fade">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<div class="modal-header bg-info">
								<h4 class="modal-title">Create new sub menu</h4>
							</div>
							<div class="modal-body">
								<form action="menu/new" method="POST">
									<div class="form-group">
										<label class="control-label">Parent Menu</label>
										<select class="form-control" name="menuname">
											<?php if(isset($menus)): ?>
												<?php foreach($menus as $menu): ?>
													<option value="<?php echo $menu->id_menu; ?>"><?php echo $menu->menu_name; ?></option>
												<?php endforeach; ?>
											<?php endif; ?>
										</select>
									</div>
									<div class="form-group">
										<label class="control-label">New Sub Menu Name</label>
										<input autofocus class="form-control" type="text" name="submenuname">
									</div>
									<button name="submit" class="btn btn-info btn-block btn-next" type="submit" value="submenu">Create Sub Menu</button>
								</form>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<table class="table table-hover table-bordered table-striped">
							<thead style="background-color: #242323;color: #fff;">
								<tr>
									<th class="text-left">Parent Menu</th>
								</tr>
							</thead>
							<tbody>

								<?php if(isset($menus)): ?>
									<?php foreach($menus as $sub): ?>
										<tr>
											<td class="text-left">
												<a data-toggle="modal" data-target="#menu<?php echo $sub->id_menu; ?>" href="#"><?php echo ucwords($sub->menu_name); ?></a>							
											</td>									
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>

							</tbody>
						</table>
					</div>

					<div class="col-md-6">
						<table class="table table-hover table-bordered table-striped">
							<thead style="background-color: #242323;color: #fff;">
								<tr>
									<th class="text-left">Parent Menu</th>
									<th class="text-left">Child Menu</th>
								</tr>
							</thead>
							<tbody>

								<?php if(isset($subs)): ?>
									<?php foreach($subs as $sub): ?>
										<tr>
											<td class="text-left"><?php echo ucwords($sub->menu_name); ?></td>
											<td class="text-left">
												<a data-toggle="modal" data-target="#sub<?php echo $sub->id_sub; ?>" href="#"><?php echo ucwords($sub->sub_name); ?></a>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php if(isset($menus)): ?>
		<?php foreach($menus as $sub): ?>
			<!-- Edit Menu Modals -->
			<div id="menu<?php echo $sub->id_menu; ?>" role="dialog" class="modal fade">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header bg-default">
							<h4 class="modal-title">Edit menu</h4>
						</div>
						<div class="modal-body">
							<form action="menu/edit" method="POST">
								<div class="form-group">
									<label class="control-label">Edit Menu Name</label>
									<input required class="form-control" type="text" name="menuname" value="<?php echo $sub->menu_name; ?>">
									<input type="hidden" name="menuid" value="<?php echo $sub->id_menu; ?>">
								</div>
								<button name="submit" class="btn btn-default" type="submit" value="editmenu">Update Menu</button>
								<a class="btn btn-warning" href="<?php echo base_url().index_with(); ?>menu/delmenu/<?php echo $sub->id_menu; ?>">Delete Menu</a>
							</form>
						</div>
					</div>
				</div>
			</div>	
		<?php endforeach; ?>
	<?php endif; ?>

	<?php if(isset($subs)): ?>
		<?php foreach($subs as $sub): ?>

			<!-- Edit Sub Menu Modals -->
			<div id="sub<?php echo $sub->id_sub; ?>" role="dialog" class="modal fade">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header bg-danger">
							<h4 class="modal-title">Edit sub</h4>
						</div>
						<div class="modal-body">
							<form action="menu/edit" method="POST">
								<div class="form-group">
									<label class="control-label">Parent Menu</label>
									<select class="form-control" name="menuname">
										<?php if(isset($menus)): ?>
											<?php foreach($menus as $menu): ?>
												<?php if($menu->id_menu == $sub->id_menu) { ?>
												<option selected value="<?php echo $menu->id_menu; ?>"><?php echo $menu->menu_name; ?></option>
												<?php } else { ?>
												<option value="<?php echo $menu->id_menu; ?>"><?php echo $menu->menu_name; ?></option>
												<?php } ?>
											<?php endforeach; ?>
										<?php endif; ?>
									</select>
								</div>
								<div class="form-group">
									<label class="control-label">Edit Sub Menu Name</label>
									<input required class="form-control" type="text" name="subname" value="<?php echo $sub->sub_name; ?>">
									<input type="hidden" name="subid" value="<?php echo $sub->id_sub; ?>">
								</div>
								<button name="submit" class="btn btn-default" type="submit" value="editsub">Update Sub Menu</button>
								<a class="btn btn-warning" href="<?php echo base_url().index_with(); ?>menu/delsub/<?php echo $sub->id_sub; ?>">Delete Sub Menu</a>
							</form>
						</div>
					</div>
				</div>
			</div>

		<?php endforeach; ?>
	<?php endif; ?>
</div>