

<section class="ticker-news">



	<div class="container">

		<div class="ticker-news-box">

			<span class="breaking-news">OTHER CONTENT</span>

			<!-- <span class="new-news">New</span> -->

			<ul id="js-news">

				<?php foreach($contents as $content): ?>

					<li class="news-item">

						<span class="time-news"><?php echo $content->datearticle; ?></span> 

						<a href="<?php echo base_url().index_with(); if($content->kind == 1) { echo 'articles'; } else { echo 'videos'; } echo '/'; echo $content->link; ?>"><?php echo ucwords($content->title); ?></a>

					</li>

				<?php endforeach; ?>

			</ul>

		</div>

	</div>



</section>

<section class="block-wrapper">

	<div class="container">

		<div class="row">

			<div class="col-sm-8">



				<!-- block content -->

				<div class="block-content">



					<!-- single-post box -->

					<div class="single-post-box">



						<div class="title-post">

							<h1>

								<?php echo ucwords($detail->title); ?>

							</h1>

							<ul class="post-tags">

								<li><i class="fa fa-clock-o"></i><?php echo $detail->datearticle; ?></li>

								<li><i class="fa fa-user"></i>by <a href="#"><?php echo ucwords($detail->uname); ?></a></li>

								<li><a href="#"><i class="fa fa-comments-o"></i><span><?php echo count($comments); ?></span></a></li>

								<li><i class="fa fa-eye"></i><?php echo $detail->wtch; ?></li>

							</ul>

						</div>



						<div class="share-post-box">

							<div id="fb-root"></div>

							<ul class="share-box">

								<li><i class="fa fa-share-alt"></i><span>Share Post</span></li>

								<div class="fb-share-button" 

								    data-href="<?php echo base_url().index_with(); if($detail->kind == 1) { echo 'articles'; } else { echo 'videos'; } echo '/'; echo $detail->link; ?>" 

								    data-layout="button_count">

							  	</div>

							</ul>

						</div>



						<div class="post-content">

							<article style="text-align: justify;">

								<?php echo nl2br($detail->describ); ?>

							</article>

						</div>



						<div class="post-tags-box">

							<ul class="tags-box">

								<li><i class="fa fa-tags"></i><span>Tags:</span></li>

								<?php foreach($tag as $t): ?>

									<li><a href="<?php echo base_url().index_with(); ?>tag/<?php echo $t; ?>"><?php echo $t; ?></a></li>

								<?php endforeach; ?>

							</ul>

						</div>



						<div class="about-more-autor">

							<ul class="nav nav-tabs" id="myTab2">

								<li class="active">

									<a href="#about-autor" data-toggle="tab">About The Autor</a>

								</li>

								<li>

									<a href="#more-autor" data-toggle="tab">More From Autor</a>

								</li>

							</ul>



							<div class="tab-content">



								<div class="tab-pane active" id="about-autor">

									<div class="autor-box">

										<img src="<?php echo base_url().$authorPhoto; ?>" alt="">

										<div class="autor-content">

											<div class="autor-title">

												<h1><span><?php echo ucwords($authorName); ?></span><a href="<?php echo base_url().index_with().'user/'.$authorId; ?>"><?php echo $authorPost; ?> Posts</a></h1>

											</div>

											<p>Join since : <?php echo $authorRegDate; ?></p>

										</div>

									</div>

								</div>



								<div class="tab-pane" id="more-autor">

									<div class="more-autor-posts">



										<?php if(isset($author)) { ?>

										<?php foreach($author as $a) { ?>

										<div class="news-post image-post3">

											<img style="height: 101px" src="<?php echo base_url().$a->thumbnail; ?>" alt="<?php echo ucwords($a->title); ?>">

											<div class="hover-box">

												<h2><a href="<?php echo base_url().index_with(); if($a->kind == 1) { echo 'articles'; } else { echo 'videos'; } echo '/'; echo $a->link; ?>"><?php echo ucwords($a->title); ?></a></h2>

												<ul class="post-tags">

													<li><i class="fa fa-clock-o"></i><?php echo $a->datearticle; ?></li>

												</ul>

											</div>

										</div>

										<?php } } ?>

									</div>

								</div>



							</div>

						</div>



						<!-- carousel box -->

						<div class="carousel-box owl-wrapper">

							<div class="title-section">

								<h1><span>You may also like</span></h1>

							</div>

							<div class="owl-carousel" data-num="3">



								<?php if(isset($contentsLike)) { ?>

								<?php foreach($contentsLike as $cl) { ?>



								<?php if($cl->kind == 1) { ?>



									<div class="item news-post image-post3">

										<img style="width: 100%; height: 180px" src="<?php echo base_url().$cl->thumbnail; ?>" alt="<?php echo ucwords($cl->title); ?>">

										<div class="hover-box">

											<h2><a href="<?php echo base_url().index_with().'articles/'.$cl->link; ?>"><?php echo ucwords($cl->title); ?></a></h2>

											<ul class="post-tags">

												<li><i class="fa fa-clock-o"></i><?php echo $cl->datearticle; ?></li>

											</ul>

										</div>

									</div>



								<?php } else { ?>



									<div class="item news-post video-post">

										<img style="width: 100%; height: 180px" src="<?php echo base_url().$cl->thumbnail; ?>" alt="<?php echo ucwords($cl->title); ?>">

										<a href="<?php echo base_url().$cl->video; ?>" class="video-link"><i class="fa fa-play-circle-o"></i></a>

										<div class="hover-box">

											<h2><a href="<?php echo base_url().index_with().'videos/'.$cl->link; ?>"><?php echo ucwords($cl->title); ?></a></h2>

											<ul class="post-tags">

												<li><i class="fa fa-clock-o"></i><?php echo $cl->datearticle; ?></li>

											</ul>

										</div>

									</div>



								<?php } } } ?>



							</div>

						</div>

						<!-- End carousel box -->



						<!-- comment area box -->

						<div class="comment-area-box">

							<div class="title-section">

								<?php if(isset($comments)) { ?>

								<h1><span><?php echo count($comments); ?> Comments</span></h1>

								<?php } ?>

							</div>

							<ul class="comment-tree">



								<?php if(isset($comments)) { ?>

								<?php foreach($comments as $comment) {

									if(!empty($comment->photo)) {

										$pp = $comment->photo;

									} else {

										$pp = 'layout/img/NoAvatar.jpg';

									}

									?>

									<li>

										<div class="comment-box">

											<img alt="<?php echo ucwords($comment->nameuser); ?> Limit Code" src="<?php echo base_url().$pp; ?>">

											<div class="comment-content">

												<h4><?php echo ucwords($comment->nameuser); ?> <i class="fa fa-comment-o"></i></h4>

												<span><i class="fa fa-clock-o"></i> <?php echo $comment->timedate; ?></span>

												<p><?php echo $comment->comm; ?>. </p>

											</div>

										</div>

									</li>

									<?php } } ?>

								</ul>

							</div>

							<!-- End comment area box -->



							<?php if(!empty($sessionData['id_user'])) { ?>

							<!-- contact form box -->

							<div class="contact-form-box">

								<div class="title-section">

									<h1><span>Leave a Comment</span></h1>

								</div>

								<form id="comment-form" action="" method="POST">

									<label for="comment">Comment*</label>

									<textarea id="comment" name="comment"></textarea>

									<button type="submit" id="submit-contact" name="sendComment" value="sending">

										<i class="fa fa-comment"></i> Post Comment

									</button>

								</form>

							</div>

							<!-- End contact form box -->

							<?php } else {?>

							<a href="<?php echo base_url().index_with(); ?>signin" type="button" class="btn btn-default" id="submit-contact">

								<i class="fa fa-book"></i> Sign In

							</a>



							<a href="<?php echo base_url().index_with(); ?>signup" type="submit" class="btn btn-success" id="submit-contact">

								<i class="fa fa-plus"></i> Sign Up

							</a>



							<a type="submit" class="btn btn-info" id="submit-contact">

								<i class="fa fa-facebook"></i> Sign In By Facebook

							</a>

							<?php } ?>



						</div>

						<!-- End single-post box -->



					</div>

					<!-- End block content -->



				</div>



				<div class="col-sm-4">



					<!-- sidebar -->

					<div class="sidebar">

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



						<div class="widget social-widget">



							<!-- google addsense -->

						<div class="advertisement">

							<div class="desktop-advert">

								<span>Advertisement</span>

								<?php 

	                                if(isset($advert)) {

	                                  foreach($advert as $ad) {

	                                    if($ad->ad_postition == 7) {

	                                      ?>

	                                      <img src="<?php echo base_url().$ad->ad_path; ?>" alt="<?php echo $ad->advertiser.' - '.$ad->ad_title; ?>">

	                                      <?php

	                                    }

	                                  }

	                                }

	                                ?>

							</div>

							<div class="tablet-advert">

								<span>Advertisement</span>

								<?php 

	                                if(isset($advert)) {

	                                  foreach($advert as $ad) {

	                                    if($ad->ad_postition == 7) {

	                                      ?>

	                                      <img src="<?php echo base_url().$ad->ad_path; ?>" alt="<?php echo $ad->advertiser.' - '.$ad->ad_title; ?>">

	                                      <?php

	                                    }

	                                  }

	                                }

	                                ?>

							</div>

							<div class="mobile-advert">

								<span>Advertisement</span>

								<?php 

	                                if(isset($advert)) {

	                                  foreach($advert as $ad) {

	                                    if($ad->ad_postition == 7) {

	                                      ?>

	                                      <img src="<?php echo base_url().$ad->ad_path; ?>" alt="<?php echo $ad->advertiser.' - '.$ad->ad_title; ?>">

	                                      <?php

	                                    }

	                                  }

	                                }

	                                ?>

							</div>

						</div>

						<!-- End google addsense -->

						</div>



						<div class="widget subscribe-widget">



							<div class="title-section">

								<h1><span>Stay Connected</span></h1>

							</div>

							<ul class="social-share">

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

							</ul>



							<form id="formSubscrib" class="subscribe-form">
								<h1>Subscribe to Updated Content</h1>
								<input required="" type="text" id="subscribe" placeholder="Email"/>
								<button id="submitSubscribe" type="button">
									<i class="fa fa-arrow-circle-right"></i>
								</button>
								<p>Get all latest content delivered to your email.</p>
							</form>

						</div>



					</div>

					<!-- End sidebar -->



				</div>



			</div>



		</div>

	</section>

		<!-- End block-wrapper-section -->