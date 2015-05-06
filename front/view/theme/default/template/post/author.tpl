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
      <div class="row">
        <?php if ($column_left && $column_right) { ?>
        <?php $class = 'col-sm-6'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
        <?php $class = 'col-sm-6'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-4'; ?>
		<?php } ?>
        <div class="<?php echo $class; ?>">
          
            <div class="tab-content">
            <ul class="author-image">
            <?php if ($thumb) { ?>
            <li><a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>"><img class="featured" src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></li>
            <?php } ?>
          </ul>

          </div>
          
        </div>
        <?php if ($column_left && $column_right) { ?>
		<?php $class = 'col-sm-6'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
        <?php $class = 'col-sm-6'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-8'; ?>

        <?php } ?>
        <div class="<?php echo $class; ?>">
          <h1><?php echo $heading_title; ?></h1>
    
          <div id="post">
			<h3><?php echo $text_name; ?></h3> <?php echo $name; ?>
			<h3><?php echo $text_bio; ?></h3> <?php echo $bio; ?>

            </div>
          </div>
      </div>
      <?php if ($posts) { ?>
      <h3><?php echo $text_posts; ?></h3>
      <div class="row">
      <?php $n = 0; ?>
        <?php foreach ($posts as $post) { ?>
        
         <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 latest">
  	
    
    <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5 image"><a href="<?php echo $post['href']; ?>"><img class="latest" src="<?php echo $post['thumb']; ?>" alt="<?php echo $post['name']; ?>" title="<?php echo $post['name']; ?>" class="img-responsive" /></a></div>
	      <div class="col-lg-8 col-md-8 col-sm-7 col-xs-7">
		        <h4 class="ltittle"><a href="<?php echo $post['href']; ?>"><?php echo $post['name']; ?></a></h4>
		        <?php if (!empty($categories_info[$n]) ) { ?>
			        <span class="fcat"><?php echo $text_category; ?></span>
			        <?php foreach ($categories_info[$n] as $category_info) { ?>       
			        <i class="fa fa-chevron-right fcat"></i> <a href="<?php echo $category_info['href']; ?>"><?php echo $category_info['name']; ?></a>
			        <?php } ?>
		        <?php } ?>
		        <p><?php echo $post['description']; ?></p>
	      </div>
	</div>
  <?php $n++; ?>

        
        <?php } ?>
      </div>
      <?php } ?>

      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>

<script type="text/javascript"><!--
$(document).ready(function() {
	$('.author-image').magnificPopup({
		type:'image',
		delegate: 'a',
		gallery: {
			enabled:true
		}
	});
});
//--></script> 
<?php echo $footer; ?>