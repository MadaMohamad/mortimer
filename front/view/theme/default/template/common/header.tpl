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

<!-- =========================
     PRE LOADER       
============================== -->
<div class="preloader">
  <div class="status">&nbsp;</div>
</div>

<!-- =========================
     HEADER   
============================== -->
		
		
<div class="menu">
		
		<!-- STICKY NAVIGATION -->
		<div class="navigation">
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
