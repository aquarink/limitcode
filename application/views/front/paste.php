
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

		<div class="iso-call heading-news-box"> 
			


		</div>
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
							<script>

							  window.fbAsyncInit = function() {

							    FB.init({

							      appId            : '570962756574024',

							      autoLogAppEvents : true,

							      xfbml            : true,

							      version          : 'v2.12'

							    });

							  };



							  (function(d, s, id){

							     var js, fjs = d.getElementsByTagName(s)[0];

							     if (d.getElementById(id)) {return;}

							     js = d.createElement(s); js.id = id;

							     js.src = "https://connect.facebook.net/en_US/sdk.js";

							     fjs.parentNode.insertBefore(js, fjs);

							   }(document, 'script', 'facebook-jssdk'));

							</script>
							<h1><span class="world">Enter URL to short <div class="fb-share-button" data-href="<?php echo base_url().index_with(); ?>paste" data-layout="button_count"></span></h1>
						</div>

						<div class="row">

							<div class="col-sm-12" style="text-align: center; background-color: #dadada; height: 100px;">
								<div style="margin-top: 40px; vertical-align: middle;display: inline-block;line-height: normal;">
									<b id="titlePastes"></b> 

									<b id="titlePastesAfter">Your Image Url is <input id="valLink" type="text" name="valLink"> already copy to your clipboard. </b>	
								</div>
							</div>

							<div class="col-sm-12" style="margin-top: 20px">
								<img style="display: none; width: 100%" id="pasteImage" src="#" alt="" />
							</div>
						</div>									
					</div>

				</div>
				<!-- End block content -->

			</div>

			<div class="col-sm-4">

				<!-- sidebar -->
				<div class="sidebar">

					<div class="widget social-widget">
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
					</div>
				</div>
				<!-- End sidebar -->

			</div>

		</div>

	</div>
</section>