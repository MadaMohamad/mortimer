<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<!--<![endif]-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">

<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<script src="front/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>

<link href="front/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<script src="front/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<link href="front/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />
<link href="front/view/theme/default/stylesheet/stylesheet.css" rel="stylesheet">
<script src="front/view/javascript/common.js" type="text/javascript"></script>

<script src="front/view/javascript/jquery/owl-carousel/owl.carousel.min.js" type="text/javascript"></script>
<link href="front/view/javascript/jquery/owl-carousel/owl.carousel.css" type="text/css" rel="stylesheet" media="screen">
<?php echo $google_analytics; ?>



<!-- =========================
      FAV AND TOUCH ICONS  
============================== -->
<link rel="icon" href="images/favicon.ico">
<link rel="apple-touch-icon" href="images/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">

</head>
<body>
<!-- =========================
     PRE LOADER       
============================== -->
<div class="preloader">
  <div class="status">&nbsp;</div>
</div>

<!-- =========================
     HEADER   
============================== -->
<header id="home">
<!-- COLOR OVER IMAGE -->
<div class="color-overlay">
	
	<div class="navigation-header">
		
		<!-- STICKY NAVIGATION -->
		<div class="navigation navbar-fixed-top sticky-navigation">
			<div class="container">
				<div class="navbar-header">
					
					<!-- LOGO ON STICKY NAV BAR -->
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" alt=""></a>
					
				</div>
				
				<!-- NAVIGATION LINKS -->
				<div class="navbar-collapse collapse" id="navigation">
					<ul class="nav navbar-nav navbar-right main-navigation">
						<li><a href="<?php echo $home; ?>"><i class="fa fa-home"></i> <?php echo $text_home; ?></a></li>
						 <?php foreach ($categories as $category) { ?>
							 <li>
								<a href="<?php echo $category['href']; ?>">
								<?php if ($category['icon']) { ?><i class="fa <?php echo $category['icon']; ?>"></i><?php } ?>	
								<?php echo $category['name']; ?></a>
							 </li>
						 <?php } ?>
						<li><a href="<?php echo $contact; ?>"><i class="fa fa-envelope"></i> <?php echo $text_contact; ?></a></li>
						<li><?php echo $language; ?></li>
						<li><div id="search" class="input-group">
						<input type="text" name="search" value="" placeholder="<?php echo $text_search; ?>" class="input-lg">
						<span class="input-group-btn">
							<button type="button" class="btn-lg"><i class="fa fa-search"></i></button>
						</span>
					</div></li>
					</ul>
				</div>
				
			</div>
			<!-- /END CONTAINER -->
			
		</div>
		
		<!-- /END STICKY NAVIGATION -->
		
		<!-- ONLY LOGO ON HEADER -->
		<div class="navbar non-sticky">
			
			<div class="container">
				
				<div class="navbar-header">
					<img src="<?php echo $logo; ?>" alt="">
				</div>
				
				<ul class="nav navbar-nav navbar-right social-navigation hidden-xs">
					<li><a href="#"><i class="fa fa-facebook-square"></i></a></li>
					<li><a href="#"><i class="fa fa-twitter-square"></i></a></li>
					<li><a href="#"><i class="fa fa-instagram"></i></a></li>
					<li><a href="#"><i class="fa fa-deviantart"></i></a></li>
					<li><a href="#"><i class="fa fa-linkedin-square"></i></a></li>
					<li><a href="#"><i class="fa fa-github-square"></i></a></li>
				</ul>
				
			</div>
			<!-- /END CONTAINER -->
			
		</div>
		<!-- /END ONLY LOGO ON HEADER -->
		
	</div>
	
	<!-- HEADING, FEATURES AND REGISTRATION FORM CONTAINER -->
	<div class="container">
		
		<div class="row">
			
			<!-- LEFT - HEADING AND TEXTS -->
			<div class="col-md-10 col-md-offset-1 intro-section">
				
				<h1 class="intro">
				Get the Best <span class="strong colored-text">Solution</span> for Your <strong>Business</strong>
				</h1>
				
				<p class="sub-heading">
				    Accelerator photo sharing business school drop out ramen hustle crush it revenue traction platforms. Coworking viral landing page user base.
				</p>
				<br/>
				
			</div>
			
		</div>
		
				
	</div>
	<!-- /END HEADING, FEATURES AND REGISTRATION FORM CONTAINER -->
	
</div>

</header>
 <div class="container">
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?><?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>

<script>
/* =================================
   LOADER                     
=================================== */
// makes sure the whole site is loaded
jQuery(window).load(function() {
	"use strict";
        // will first fade out the loading animation
	jQuery(".status").fadeOut();
        // will fade out the whole DIV that covers the website.
	jQuery(".preloader").delay(1000).fadeOut("slow");
})

</script>
<?php echo $footer; ?>