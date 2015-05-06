<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <div class="row">
        <?php foreach ($authors as $author) { ?>
        
        <div class="col-lg-12 latest">
		    <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 image">
		    	<a href="<?php echo $author['href']; ?>"><img class="latest" src="<?php echo $author['thumb']; ?>" alt="<?php echo $author['name']; ?>" title="<?php echo $author['name']; ?>" class="img-responsive" /></a>
		    </div>		
			<div class="col-lg-8 col-md-8 col-sm-7 col-xs-7">
				<h3><a href="<?php echo $author['href']; ?>"><?php echo $author['username']; ?></a></h3>
			    <h4 class="ltittle"><a href="<?php echo $author['href']; ?>"><?php echo $author['name']; ?></a></h4>
				<p><?php echo $author['bio']; ?></p>
			</div>
		</div>

        
        <?php } ?>
      </div>

      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>