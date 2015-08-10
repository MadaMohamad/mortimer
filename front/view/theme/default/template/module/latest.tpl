	<h3><?php echo $heading_title; ?></h3>
<div class="row">
  <?php $n = 0; ?>
  <?php foreach ($posts as $post) { ?>
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 platest">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><a href="<?php echo $post['href']; ?>"><img class="latest img-responsive" src="<?php echo $post['thumb']; ?>" alt="<?php echo $post['name']; ?>" title="<?php echo $post['name']; ?>" class="img-responsive" /></a></div>
	      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
		        <h4><a href="<?php echo $post['href']; ?>"><?php echo $post['name']; ?></a></h4>
		        <?php if (!empty($categories_info[$n]) ) { ?>
			        <span class="fcat"><?php echo $text_category; ?></span>
			        <?php foreach ($categories_info[$n] as $category_info) { ?>       
			        <i class="fa fa-chevron-right fcat"></i> <a href="<?php echo $category_info['href']; ?>"><?php echo $category_info['name']; ?></a>
			        <?php } ?>
		        <?php } ?>
		        <p><?php echo $post['description']; ?></p>
		        <p><i><?php echo $text_author;?> <a href="<?php echo $post['uhref']; ?>"><?php echo $post['user']; ?></a> <?php echo $text_on; ?> <a href="<?php echo $post['dhref']; ?>"><?php echo $post['date_added']; ?></a></i></p>
	      </div>
	</div>
  <?php $n++; ?>
  <?php } ?>
</div>
