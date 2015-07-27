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
        <?php $class = 'col-sm-7'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
        <?php $class = 'col-sm-7'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-9'; ?>
        <?php } ?>
        <div class="<?php echo $class; ?>">
	      <?php if($display == 1) { ?>  
          <?php if ($thumb) { ?>
          <div class="post-image">
	          <ul class="thumbnail">
	            <?php if ($thumb) { ?>
	            <li><a class="thumbnail" href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></li>
	            <?php } ?>
	          </ul>
          </div>
          <?php } ?>
          
          <div class="row">
	          <div class="col-sm-2"><a href="<?php echo $uhref; ?>"><img class="author" src="<?php echo $user_image;?>"></a></div>
	          <div class="col-sm-5">
		        <h1 class="post_title"><?php echo $heading_title; ?></h1>
				<p><?php echo $text_by;?> <a href="<?php echo $uhref; ?>"><?php echo $user; ?></a></p>
					<?php if($categories) { ;?>
						<?php echo $text_categories; ?><?php foreach ($categories as $category) { ?>       
						<i class="fa fa-chevron-right fcat"></i> <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
						<?php } ?>
					<?php } ?>	
	          </div>
	          <div class="col-sm-5">
		            
            
            <!-- AddThis Button BEGIN -->
				<div class="addthis_sharing_toolbox">
					<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
				</div>
				<html xmlns:fb="http://ogp.me/ns/fb#"> 
				<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-55b3ef6c0813fbfc" async="async"></script>

            <!-- AddThis Button END -->

            
            </div>
          </div>        
          
          <div class="row">
            <div class="col-sm-12"><?php echo $description; ?></div>
 
          </div>
        </div>
<?php } else { ?>

<div class="row">
	 <div class="col-sm-7">
	 <h1 class="post_title"><?php echo $heading_title; ?></h1>
	 <?php if($categories) { ;?>
		<?php echo $text_categories; ?>
		<?php foreach ($categories as $category) { ?>       
			<i class="fa fa-chevron-right fcat"></i> <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
		<?php } ?>
	<?php } ?>	
	</div>
	 <div class="col-sm-5">
		<!-- AddThis Button BEGIN -->
		<div class="addthis_sharing_toolbox pull-right"></div>
        <!-- AddThis Button END --></div>
	</div>

<div class="row">

            <div class="col-sm-12"><?php echo $description; ?></div>


	          <div class="col-sm-2"><a href="<?php echo $uhref; ?>"><img class="author" src="<?php echo $user_image;?>"></a></div>
	          <div class="col-sm-5">
		        
				<p><?php echo $text_by;?> <a href="<?php echo $uhref; ?>"><?php echo $user; ?></a></p>
					<?php if($categories) { ;?>
						<?php echo $text_categories; ?><?php foreach ($categories as $category) { ?>       
						<i class="fa fa-chevron-right fcat"></i> <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
						<?php } ?>
					<?php } ?>	
	          </div>
	          <div class="col-sm-5">
		            
            
            <!-- AddThis Button BEGIN -->
				<div class="addthis_sharing_toolbox">
					<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
				</div>
				<html xmlns:fb="http://ogp.me/ns/fb#"> 
				<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-55b3ef6c0813fbfc" async="async"></script>

            <!-- AddThis Button END -->

            
            </div>
          </div>        
          
         
        </div>

	
<?php } ?>       
	        
		<?php if ($posts) { ?>
		<?php if ($column_left && $column_right) { ?>
        <?php $class = 'col-sm-5'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
        <?php $class = 'col-sm-5'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-3'; ?>
        <?php } ?>
		        <div class="<?php echo $class; ?> post-related">
		        	<?php $n = 0; ?>
					<h3><?php echo $text_related; ?></h3>
					<?php foreach ($posts as $post) { ?>
		                <div class="image"><a href="<?php echo $post['href']; ?>"><img src="<?php echo $post['thumb']; ?>" alt="<?php echo $post['name']; ?>" title="<?php echo $post['name']; ?>" class="img-responsive" /></a>
		                </div>
						<div class="caption">
							<h4><a href="<?php echo $post['href']; ?>"><?php echo $post['name']; ?></a></h4>
							<?php if($post_categories[$n]) { ?>
								<span class="fcat"><?php echo $text_categories; ?></span>
								<?php foreach ($post_categories[$n] as $post_category) { ?>       
									<i class="fa fa-chevron-right fcat"></i> <a href="<?php echo $post_category['href']; ?>"><?php echo $post_category['name']; ?></a>
								<?php } ?>
							<?php } ?>
							<p><?php echo $post['description']; ?></p>
							<p><i><?php echo $text_author;?> <a href="<?php echo $post['uhref']; ?>"><?php echo $post['user']; ?></a> <?php echo $text_on . ' ' . $post['date_added']; ?></i></p>
						</div>
						<?php $n++; ?>
					<?php } ?>
				</div>
				<?php } ?>
			
    </div>

      <?php if ($tags) { ?>
      <p><?php echo $text_tags; ?>
        <?php for ($i = 0; $i < count($tags); $i++) { ?>
        <?php if ($i < (count($tags) - 1)) { ?>
        <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>,
        <?php } else { ?>
        <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
        <?php } ?>
        <?php } ?>
      </p>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.thumbnail').magnificPopup({
		type:'image',
		delegate: 'a',
		gallery: {
			enabled:true
		}
	});
});
//--></script> 
<?php echo $footer; ?>
