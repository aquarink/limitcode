<div class="layout-content">
	<div class="layout-content-body">
		<div class="title-bar">
			<h1 class="title-bar-title"><?php if(isset($webtitle)) { echo $webtitle; } ?></h1>
			<p class="title-bar-description">
				<small><div id="todaysDate"></div></small>
			</p>

			<canvas id="myChart"></canvas>

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