<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
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
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<script src="front/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
<link href="front/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<script src="front/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<link href="front/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />
<link href="front/view/theme/default/stylesheet/stylesheet.css" rel="stylesheet">
<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script src="front/view/javascript/common.js" type="text/javascript"></script>
<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<?php echo $google_analytics; ?>
</head>
<body>
<nav id="top">
  <div class="container">
    <?php echo $language; ?>
  </div>
</nav>

<!-- =========================
     PRE LOADER       
============================== -->
<div class="preloader">
  <div class="status">&nbsp;</div>
</div>
<div id="search" class="input-group">
  <input type="text" name="search" value="" placeholder="Search" class="input-lg">
  <span class="input-group-btn">
    <button type="button" class="btn btn-default btn-lg"><i class="fa fa-search"></i></button>
  </span>
</div>

<!-- =========================
     HEADER   
============================== -->
		<!-- STICKY NAVIGATION -->
		<div class="navbar-inverse menu">
			<div class="container">
				<div class="navbar-header">
					
					<!-- LOGO ON STICKY NAV BAR -->
					<a class="navbar-brand" href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" alt=""></a>
					
				</div>
				<!-- NAVIGATION LINKS -->
				<div class="navbar-collapse collapse" id="landx-navigation">
					<ul class="nav navbar-nav navbar-right main-navigation">
						<li><a href="#home">Home</a></li>
						 <?php foreach ($categories as $category) { ?>
						 <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
						 <?php } ?>

						<li><a href="#section8">Contact</a></li>
						<li></li>
					</ul>
				</div>
				
			</div>
			<!-- /END CONTAINER -->
			
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
