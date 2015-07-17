<h3><?php echo $text_featured; ?></h3>
<div class="row">
  <?php $n = 0; ?>
  <?php foreach ($posts as $post) { ?>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="post-thumb transition">
      <div class="image"><a href="<?php echo $post['href']; ?>"><img class="featured" src="<?php echo $post['thumb']; ?>" alt="<?php echo $post['name']; ?>" title="<?php echo $post['name']; ?>" class="img-responsive" /></a></div>
      <div class="caption">
      <h4><a href="<?php echo $post['href']; ?>"><?php echo $post['name']; ?></a></h4>
        <?php if (!empty($categories_info[$n]) ) { ?>
	        <span class="fcat"><?php echo $text_category; ?></span>
	        <?php foreach ($categories_info[$n] as $category_info) { ?>       
	        <i class="fa fa-chevron-right fcat"></i> <a href="<?php echo $category_info['href']; ?>"><?php echo $category_info['name']; ?></a>
	        <?php } ?>
        <?php } ?>
        <p><?php echo $post['description']; ?></p>
        <p><i><?php echo $text_author;?> <a href="<?php echo $post['uhref']; ?>"><?php echo $post['user']; ?></a> <?php echo $text_on . ' ' . $post['date_added']; ?></i></p>
      </div>
    </div>
  </div>
  <?php $n++; ?>
  <?php } ?>
</div>
