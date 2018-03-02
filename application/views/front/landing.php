<section class="heading-news2">

	<div class="container">

		<div class="ticker-news-box">
			<span class="breaking-news">OTHER CONTENT</span>
			<ul id="js-news">
				<?php foreach($contents as $content): ?> 
					<li class="news-item">
						<span class="time-news"><?php echo $content->datearticle; ?></span> 
						<a href="<?php echo base_url().index_with(); if($content->kind == 1) { echo 'articles'; } else { echo 'videos'; } echo '/'; echo $content->link; ?>"><?php echo ucwords($content->title); ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<!-- <div class="iso-call heading-news-box">
			<div class="image-slider snd-size">
				<span class="top-stories">TOP STORIES</span>
				<ul class="bxslider">

					<?php if(isset($popularContent)) { ?>
					<?php foreach($popularContent as $pc) { ?>
					<li>
						<div class="news-post image-post">
							<img style="width: 100%; height: 470px" src="<?php echo base_url().$pc->thumbnail; ?>" alt="">
							<div class="hover-box">
								<div class="inner-hover">
									<a class="category-post sport"><?php echo $pc->sub; ?></a>
									<h2>
										<a href="<?php echo base_url().index_with(); if($pc->kind == 1) { echo 'articles'; } else { echo 'videos'; } echo '/'; echo $pc->link; ?>">
											<?php
											if(strlen($pc->title) > 60) {
												echo substr($pc->title, 0,60);
											} else {
												echo $pc->title;
											}
											?>
										</a>
									</h2>
									<ul class="post-tags">
										<li><i class="fa fa-clock-o"></i><?php echo $pc->datearticle; ?></li>
										<li><i class="fa fa-user"></i>by <a href="#"><?php echo ucfirst($pc->uname); ?></a></li>
										<li><a href="#"><i class="fa fa-comments-o"></i><span>0</span></a></li>
										<li><i class="fa fa-eye"></i><?php echo $pc->wtch; ?></li>
									</ul>
								</div>
							</div>
						</div>
					</li>
					<?php } } ?>

				</ul>
			</div>

			<?php if(isset($recentContentBig)) { ?>
			<?php $cls = array('world','travel','tech','fashion','video','food'); ?>
			<?php $j=0; foreach($recentContentBig as $rc) { if($j > 4) { $j = $j - 4; } ?>

			<div class="news-post image-post default-size">
				<img style="width: 100%; height: 232px" src="<?php echo base_url().$rc->thumbnail; ?>" alt="<?php echo ucfirst($rc->title); ?>">
				<div class="hover-box">
					<div class="inner-hover">
						<a class="category-post <?php echo $cls[$j]; ?>" href="<?php echo base_url().index_with(); if($rc->kind == 1) { echo 'articles'; } else { echo 'videos'; } echo '/'; echo $rc->link; ?>"><?php echo ucfirst($rc->sub); ?>
						</a>
						<h2>
							<a href="<?php echo base_url().index_with(); if($rc->kind == 1) { echo 'articles'; } else { echo 'videos'; } echo '/'; echo $rc->link; ?>">
								<?php if (strlen($rc->title) >= 20) {
									echo substr($rc->title,0,20).'...';
								} else{
									echo $rc->title;
								}
								?>
							</a>
						</h2>
						<ul class="post-tags">
							<li><i class="fa fa-clock-o"></i><span><?php echo $rc->datearticle; ?></span></li>
							<li><a href="#"><i class="fa fa-comments-o"></i><span>0</span></a></li>
							<li><a href="#"><i class="fa fa-eye"></i><span><?php echo $rc->wtch; ?></span></a></li>
						</ul>
					</div>
				</div>
			</div>

			<?php $j++; } } ?>
		</div> -->

	</div>

</section>
<!-- End heading-news-section -->

<section class="block-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-sm-8">

				<!-- block content -->
				<div class="block-content">

					<!-- grid-box -->
					<div class="grid-box">

						<div class="title-section">
							<h1><span class="world">LATEST  VIDEOS</span></h1>
						</div>

						<div class="row">

							<?php if(isset($lastVideos)) { ?>
							<?php foreach($lastVideos as $lv) { ?>
							<div class="col-md-4">
								<div class="news-post video-post">
									<img style="width: 100%; height: 170px" alt="<?php echo ucfirst($lv->title); ?>" src="<?php echo base_url().$lv->thumbnail; ?>">
									<a href="<?php base_url().$lv->video; ?>" class="video-link"><i class="fa fa-play-circle-o"></i></a>
									<div class="hover-box">
										<h2><a href="<?php echo base_url().index_with(); if($lv->kind == 1) { echo 'articles'; } else { echo 'videos'; } echo '/'; echo $lv->link; ?>"><?php echo ucfirst($lv->title); ?>.</a></h2>
										<ul class="post-tags">
											<li><i class="fa fa-clock-o"></i><?php echo $lv->datearticle; ?></li>
										</ul>
									</div>
								</div>
							</div>
							<?php } } ?>

						</div>									
					</div>
					<!-- End grid-box -->

					<!-- google addsense -->
					<div class="advertisement">
						<div class="desktop-advert">
							<span>Advertisement</span>
							<ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-7268142918614748" data-ad-slot="4299070764"></ins>
							<!-- <img src="<?php echo base_url(); ?>layout/hotmagz/upload/addsense/728x90-white.jpg" alt=""> -->
						</div>
						<div class="tablet-advert">
							<span>Advertisement</span>
							<ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-7268142918614748" data-ad-slot="2456340203" data-ad-format="auto"></ins>
						</div>
						<div class="mobile-advert">
							<span>Advertisement</span>
							<ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-7268142918614748" data-ad-slot="2320199712" data-ad-format="auto"></ins>
						</div>
					</div>
					<!-- End google addsense -->

					<!-- article box -->
					<div class="article-box">

						<div class="title-section">
							<h1><span>Latest Articles</span></h1>
						</div>

						<?php if(isset($lastArticles)) { ?>
						<?php foreach($lastArticles as $la) { ?>
						<div class="col-md-6">
							<ul class="list-posts">
								<a href="<?php echo base_url().index_with(); if($la->kind == 1) { echo 'articles'; } else { echo 'videos'; } echo '/'; echo $la->link; ?>">
									<li>
										<img style="width: 100px; height: 80px" alt="<?php echo ucwords($la->title); ?>" src="<?php echo base_url().$la->thumbnail; ?>" />
										<div class="post-content">
											<a><?php echo ucwords($la->sub); ?></a>
											<h2><a href="<?php echo base_url().index_with(); if($la->kind == 1) { echo 'articles'; } else { echo 'videos'; } echo '/'; echo $la->link; ?>"><?php echo ucwords($la->title); ?></a></h2></h2>
											<ul class="post-tags">
												<li><i class="fa fa-clock-o"></i><?php echo $la->datearticle; ?></li>
											</ul>
										</div>
									</li>
								</a>
							</ul>
						</div>
						<?php } } ?>

						

					</div>
					<!-- End article box -->

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

				</div>
				<!-- End block content -->

			</div>

			<div class="col-sm-4">

				<!-- sidebar -->
				<div class="sidebar">

					<div class="widget social-widget">
						<div class="title-section">
							<h1><span>Trends</span></h1>
						</div>
						<iframe class="social-share" scrolling="no" style="border:none;" width="100%" height="450px" src="https://trends.google.co.id/trends/hottrends/widget?pn=p19&amp;tn=10&amp;h=413"></iframe>
						<!-- <ul class="social-share">
							<li>
								<a href="#" class="rss"><i class="fa fa-rss"></i></a>
								<span class="number">9,455</span>
								<span>Subscribers</span>
							</li>
							<li>
								<a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
								<span class="number">56,743</span>
								<span>Fans</span>
							</li>
							<li>
								<a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
								<span class="number">43,501</span>
								<span>Followers</span>
							</li>
							<li>
								<a href="#" class="google"><i class="fa fa-google-plus"></i></a>
								<span class="number">35,003</span>
								<span>Followers</span>
							</li>
						</ul> -->
					</div>

					<div class="widget tab-posts-widget">

						<ul class="nav nav-tabs" id="myTab">
							<li class="active">
								<a href="#option1" data-toggle="tab">Popular</a>
							</li>
							<li>
								<a href="#option2" data-toggle="tab">Recent</a>
							</li>
							<li>
								<a href="#option3" data-toggle="tab">Top Reviews</a>
							</li>
						</ul>

						<div class="tab-content">

							<div class="tab-pane active" id="option1">

								<ul class="list-posts">

									<?php if(isset($popularContent)) { ?>

									<?php foreach($popularContent as $rc) { ?>

									<li>

										<img style="width: 75px;height: 65px" src="<?php echo base_url().$rc->thumbnail; ?>" alt="<?php echo ucwords($rc->title); ?> Limit Code">

										<div class="post-content">

											<h2><a href="<?php echo base_url().index_with(); if($rc->kind == 1) { echo 'articles'; } else { echo 'videos'; } echo '/'; echo $rc->link; ?>"><?php echo ucwords($rc->title); ?></a></h2>

											<ul class="post-tags">

												<li><i class="fa fa-clock-o"></i><?php echo $rc->datearticle; ?></li>

											</ul>

										</div>

									</li>

									<?php } } ?>

								</ul>

							</div>



							<div class="tab-pane" id="option2">

								<ul class="list-posts">



									<?php if(isset($recentContent)) { ?>

									<?php foreach($recentContent as $rc) { ?>

									<li>

										<img style="width: 75px;height: 65px" src="<?php echo base_url().$rc->thumbnail; ?>" alt="<?php echo ucwords($rc->title); ?> Limit Code">

										<div class="post-content">

											<h2><a href="<?php echo base_url().index_with(); if($rc->kind == 1) { echo 'articles'; } else { echo 'videos'; } echo '/'; echo $rc->link; ?>"><?php echo ucwords($rc->title); ?></a></h2>

											<ul class="post-tags">

												<li><i class="fa fa-clock-o"></i><?php echo $rc->datearticle; ?></li>

											</ul>

										</div>

									</li>

									<?php } } ?>

								</ul>										

							</div>

							<div class="tab-pane" id="option3">

								<ul class="list-posts">

									<?php if(isset($reviewContent)) { ?>

									<?php foreach($reviewContent as $rc) { ?>

									<li>

										<img style="width: 75px;height: 65px" src="<?php echo base_url().$rc->thumbnail; ?>" alt="<?php echo ucwords($rc->title); ?> Limit Code">

										<div class="post-content">

											<h2><a href="<?php echo base_url().index_with(); if($rc->kind == 1) { echo 'articles'; } else { echo 'videos'; } echo '/'; echo $rc->link; ?>"><?php echo ucwords($rc->title); ?></a></h2>

											<ul class="post-tags">

												<li><i class="fa fa-clock-o"></i><?php echo $rc->datearticle; ?></li>

											</ul>

										</div>

									</li>

									<?php } } ?>										

								</ul>										

							</div>

						</div>
					</div>							

					

					<div class="widget subscribe-widget">
						<form id="formSubscrib" class="subscribe-form">
							<h1>Subscribe to Updated Content</h1>
							<input required="" type="text" id="subscribe" placeholder="Email"/>
							<button id="submitSubscribe" type="button">
								<i class="fa fa-arrow-circle-right"></i>
							</button>
							<p>Get all latest content delivered to your email.</p>
						</form>
					</div>							

					<div class="advertisement">
						<div class="desktop-advert">
							<span>Advertisement</span>
							<ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-7268142918614748" data-ad-slot="2306977029" data-ad-format="auto"></ins>
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

				</div>
				<!-- End sidebar -->

			</div>

		</div>

	</div>
</section>