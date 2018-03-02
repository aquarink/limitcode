

<section class="block-wrapper">

	<div class="container">



		<!-- block content -->

		<div class="block-content non-sidebar">



			<!-- grid box -->

			<div class="grid-box">

				<div class="title-section">

					<h1><span class="world"><?php if(isset($detailtitle)) { echo $detailtitle; } ?></span></h1>

				</div>



				<div class="row">



					<?php if(isset($contents)) { ?>

					<?php foreach($contents as $content) { ?>

					<?php if($content->kind == 1) { ?>

					<div class="col-md-3">

						<a href="<?php echo base_url().index_with(); if($content->kind == 1) { echo 'articles'; } else { echo 'videos'; } echo '/'; echo $content->link; ?>">

							<div class="news-post standard-post2">

								<div class="post-gallery">

									<img style="width: 262px; height: 206px" src="<?php echo base_url().$content->thumbnail; ?>" alt="<?php $content->title; ?>">

									<a class="category-post world"><?php echo ucwords($content->sub); ?></a>

								</div>

								<div class="post-title">

									<h2><?php echo ucwords($content->title); ?>.</h2>

									<ul class="post-tags">

										<li><i class="fa fa-clock-o"></i><?php echo $content->datearticle; ?></li>

										<li><i class="fa fa-user"></i>by <a href="#"><?php echo ucwords($content->uname); ?></a></li>

										<!-- <li><a href="#"><i class="fa fa-comments-o"></i><span>23</span></a></li> -->

										<li><i class="fa fa-eye"></i><?php echo $content->wtch; ?></li>

									</ul>

								</div>

							</div>

						</a>

					</div>

					<?php } } } ?>

					

				</div>



			</div>

			<!-- End grid box -->



			<!-- google addsense -->
			<div class="advertisement">
				<div class="desktop-advert">
					<span>Advertisement</span>
					<ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-7268142918614748" data-ad-slot="2360260991"></ins>
				</div>
				<div class="tablet-advert">
					<span>Advertisement</span>
					<ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-7268142918614748" data-ad-slot="2306977029" data-ad-format="auto"></ins>
				</div>
				<div class="mobile-advert">
					<span>Advertisement</span>
					<ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-7268142918614748" data-ad-slot="2306977029" data-ad-format="auto"></ins>
				</div>
			</div>
			<!-- End google addsense -->



			<!-- grid box -->

			<div class="grid-box">



				<div class="row">

					

					<?php if(isset($contents)) { ?>

					<?php foreach($contents as $content) { ?>

					<?php if($content->kind == 2) { ?>

					<div class="col-md-3">

						<a href="<?php echo base_url().index_with(); if($content->kind == 1) { echo 'articles'; } else { echo 'videos'; } echo '/'; echo $content->link; ?>">

							<div class="news-post standard-post2">

								<div class="post-gallery">

									<img style="width: 262px; height: 206px" src="<?php echo base_url().$content->thumbnail; ?>" alt="<?php $content->title; ?>">

									<a class="category-post world"><?php echo ucwords($content->sub); ?></a>

								</div>

								<div class="post-title">

									<h2><?php echo ucwords($content->title); ?>.</h2>

									<ul class="post-tags">

										<li><i class="fa fa-clock-o"></i><?php echo $content->datearticle; ?></li>

										<li><i class="fa fa-user"></i>by <a href="#"><?php echo ucwords($content->uname); ?></a></li>

										<!-- <li><a href="#"><i class="fa fa-comments-o"></i><span>23</span></a></li> -->

										<li><i class="fa fa-eye"></i><?php echo $content->wtch; ?></li>

									</ul>

								</div>

							</div>

						</a>

					</div>

					<?php } } } ?>

				</div>



			</div>

			<!-- End grid box -->



			<!-- pagination box -->

			<div class="pagination-box">

				<ul class="pagination-list">

					<?php echo $pagination; ?>

				</ul>

				<p><?php if(isset($showing)) { echo $showing; } ?></p>

			</div>

			<!-- End Pagination box -->



		</div>

		<!-- End block content -->

	</div>

</section>

		<!-- End block-wrapper-section -->