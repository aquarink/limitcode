<!doctype html>



<html lang="en" class="no-js">



<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">



  <title><?php if(isset($webtitle)) { echo $webtitle; } ?></title>



  <link href="<?php echo base_url(); ?>layout/img/favicon.ico" rel="icon" type="image/x-icon"/>



  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <meta name="msvalidate.01" content="D16BD4082E9AC7E420BF2C0E009F730D" />

  <meta name="copyright" content="Limit Code Developer Team" />

  <meta name="robots" content="index,follow" />


  <?php if(isset($meta))  { ?>

  <meta name="author" content="<?php echo $meta['author']; ?>" />

  <meta name="description" content="<?php echo strip_tags($meta['description']); ?>" />

  <meta name="keywords" content="<?php if(isset($webtitle)) { echo $webtitle; } ?><?php echo $meta['keywords']; ?>" />



  <meta property="article:author" content="<?php echo $meta['articleAuthor']; ?>" />

  <meta property="article:publisher" content="<?php echo $meta['articlePublisher']; ?>" />



  <meta property="og:type" content="<?php echo $meta['ogType']; ?>" />

  <meta property="og:url" content="<?php echo $meta['ogUrl']; ?>" />

  <meta property="og:title" content="<?php echo $meta['ogTitle']; ?>" />

  <meta property="og:description" content="<?php echo strip_tags($meta['description']); ?>" />



  <meta property="og:image" content="<?php echo $meta['ogImage']; ?>" />

  <meta property="og:image:secure_url" content="<?php echo $meta['ogImageSecureUrl']; ?>" />

  <meta property="og:image:type" content="image/jpeg" />

  <meta property="og:image:alt" content="<?php echo $meta['ogImageAlt']; ?>" />



  <?php } ?>





  <meta content="http://limitcode.xyz/" property="og:site_name"/>

  <meta content="570962756574024" property="fb:app_id"/>

  <meta content="id_ID" property="og:locale"/>

  <meta content="en_GB" property="og:locale:alternate"/>

  <meta content="id_ID" property="og:locale:alternate"/>



  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>layout/hotmagz/css/bootstrap.min.css" media="screen"> 



</head>

<body>

  <div class="row">

    <div class="col-md-12">

      <img style="width: 100%" src="<?php if(isset($contents)) { echo $contents; } ?>" class="img img-responsive" alt="Screen Capture Share Powered By Limit Code - <?php echo base_url(); ?>">

    </div>

  </div>

</body>

</html>