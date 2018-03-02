<!doctype html>

<html lang="en" class="no-js">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">

  <title><?php if(isset($webtitle)) { echo $webtitle; } ?></title>

  <link href="<?php echo base_url(); ?>layout/img/favicon.ico" rel="icon" type="image/x-icon"/>

  <?php 
  $ml = "";
  ?>

  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <meta name="msvalidate.01" content="D16BD4082E9AC7E420BF2C0E009F730D" />

  <meta name="copyright" content="Limit Code Developer Team" />

  <meta name="robots" content="index,follow" />

  <meta property="og:type" content="article" />



  <?php if(isset($meta))  { ?>

  <meta name="author" content="<?php echo $meta['author']; ?>" />

  <meta name="description" content="<?php echo strip_tags($meta['description']); ?> <?php echo $ml; ?>" />

  <meta name="keywords" content="<?php if(isset($webtitle)) { echo $webtitle; } ?><?php echo $meta['keywords']; ?>,<?php echo $ml; ?>" />



  <meta property="article:author" content="<?php echo $meta['articleAuthor']; ?>" />

  <meta property="article:publisher" content="<?php echo $meta['articlePublisher']; ?>" />



  <meta property="og:type" content="<?php echo $meta['ogType']; ?>" />

  <meta property="og:url" content="<?php echo $meta['ogUrl']; ?>" />

  <meta property="og:title" content="<?php echo $meta['ogTitle']; ?> <?php echo $ml; ?>" />

  <meta property="og:description" content="<?php echo strip_tags($meta['description']); ?> <?php echo $ml; ?>" />



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



  <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,400italic' rel='stylesheet' type='text/css'>

  

  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>layout/hotmagz/css/bootstrap.min.css" media="screen"> 

  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>layout/hotmagz/css/jquery.bxslider.css" media="screen">

  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>layout/hotmagz/css/font-awesome.css" media="screen">

  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>layout/hotmagz/css/magnific-popup.css" media="screen">  

  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>layout/hotmagz/css/owl.carousel.css" media="screen">

  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>layout/hotmagz/css/owl.theme.css" media="screen">

  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>layout/hotmagz/css/ticker-style.css" media="screen">

  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>layout/hotmagz/css/style.css" media="screen">

  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>layout/hotmagz/css/font-awesome.css" media="screen">

<?php if(isset($imgResponsive)) { ?>
    var list = document.getElementsByTagName("img");

    for(var i=0;i<list.length;i++){
        var tags = document.getElementsByTagName("img")[i];         
        tags.setAttribute('class', 'img img-responsive');
    }
<?php } ?>

  </script>

</head>

<body class="boxed">



    <!-- Container -->

    <div id="container">



    <!-- Header

        ================================================== -->

        <header class="clearfix second-style">

            <!-- Bootstrap navbar -->

            <nav class="navbar navbar-default navbar-static-top" role="navigation">

                <!-- Logo & advertisement -->

                <div class="logo-advertisement">

                    <div class="container">



                        <!-- Brand and toggle get grouped for better mobile display -->

                        <div class="navbar-header">

                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">

                                <span class="sr-only">Toggle navigation</span>

                                <span class="icon-bar"></span>

                                <span class="icon-bar"></span>

                                <span class="icon-bar"></span>

                            </button>

                            <a class="navbar-brand" href="<?php echo base_url(); ?>" style="padding: 15px 15px"><img src="<?php echo base_url(); ?>layout/img/logo-lc-account.jpg" alt="Limit Code Logo"></a>

                        </div>



                        <div class="advertisement">

                            <div class="desktop-advert">

                                <!-- <span>Advertisement</span> -->

                                <ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-7268142918614748" data-ad-slot="2360260991"></ins>
                                <!-- <img src="<?php echo base_url(); ?>layout/hotmagz/upload/addsense/728x90-white.jpg" alt=""> -->

                            </div>

                            <div class="tablet-advert">

                                <span>Advertisement</span>

                                <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-7268142918614748" data-ad-slot="2306977029" data-ad-format="auto"></ins>
                                <!-- <img src="<?php echo base_url(); ?>layout/hotmagz/upload/addsense/468x60-white.jpg" alt=""> -->

                            </div>

                        </div>

                    </div>

                </div>

                <!-- End Logo & advertisement -->



                <!-- navbar list container -->

                <div class="nav-list-container">

                    <div class="container">

                        <!-- Collect the nav links, forms, and other content for toggling -->

                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                            <ul class="nav navbar-nav navbar-left">

                                <!-- style.css di baris 333 -->



                                <li class="drop"><a href="<?php echo base_url().index_with(); ?>home">Home</a></li>



                                <?php $class = array('world','travel','tech','fashion','video','food'); ?>

                                <?php if(isset($menus)): ?>

                                    <?php $i=0; foreach($menus as $menu => $sub) { if($i > 5) { $i = $i - 5; }?>



                                    <li class="drop"><a class="<?php echo $class[$i]; ?>" href="<?php echo base_url().index_with().'q/'.$sub['url'];?>"><?php echo $menu;?></a>

                                        <ul class="dropdown features-dropdown" style="z-index:1">

                                            <?php 

                                            foreach($sub as $k => $s) { 

                                                if($k != 'url') {

                                                    ?>

                                                    <li><a href="<?php echo base_url().index_with().'q/'.$sub['url'].'/'.$s['url'];?>"><?php echo $k;?></a></li>

                                                    <?php 

                                                } 

                                            } 

                                            ?>

                                        </ul>

                                    </li>



                                    <?php $i++; } ?>

                                <?php endif; ?>



                                <li class="drop"><a class="sport" href="#">Akun</a>

                                    

                                    <ul class="dropdown" style="z-index:1">

                                        <?php if(!empty($sessionData['id_user'])) { ?>
                                        <li><a href="<?php echo base_url().index_with().'dashboard';?>">Dashboard</a></li>
                                        <li><a href="<?php echo base_url().index_with().'signout';?>">Sign out</a></li>
                                        <?php } else { ?>
                                        <li><a href="<?php echo base_url().index_with().'signin';?>">Sign in</a></li>

                                        <li><a href="<?php echo base_url().index_with().'signup';?>">Sign up</a></li>
                                        <?php } ?>
                                        <li><a href="<?php echo base_url().index_with().'short';?>">Short URl</a></li>
                                    </ul>

                                </li>

                            </ul>

                            <!-- <form class="navbar-form navbar-right" role="search">

                                <input type="text" id="search" name="search" placeholder="Search here">

                                <button type="submit" id="search-submit"><i class="fa fa-search"></i></button>

                            </form> -->

                        </div>

                        <!-- /.navbar-collapse -->

                    </div>

                </div>

                <!-- End navbar list container -->



            </nav>

            <!-- End Bootstrap navbar -->



        </header>

        <!-- End Header -->