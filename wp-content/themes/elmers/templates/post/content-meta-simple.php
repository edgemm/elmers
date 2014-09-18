<header>
<div class="row-fluid">
  <div class="span4">
	<?php $format = get_post_format();
        $format = $format ? $format : 'standard';
    ?>
	<?php if (ct_get_option("posts_index_show_title", 1) && $format != 'aside'): ?>
		<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
    <?php endif;?>
  </div>
  <!-- / span4 -->

  <div class="span8">
	  <ul class="icons-group flat">
	    <?php if (ct_get_option("posts_index_show_author", 1)): ?>
            <li>
                <h5><i class="icon-user"></i><?php _e('By', 'ct_theme'); ?></h5>

                <p><?php the_author_posts_link() ?></p>
            </li>
        <?php endif; ?>

        <?php $cats = get_the_terms(get_the_ID(), 'category'); ?>
        <?php if (ct_get_option("posts_index_show_categories", 1) && $cats): ?>
            <li>
                <h5><i class="icon-tag"></i><?php _e('Categories', 'ct_theme'); ?></h5>

                <p><?php the_category(' ', '', get_the_ID()) ?></p>
            </li>
        <?php endif; ?>

        <?php if (ct_get_option("posts_index_show_comments_link", 1)): ?>
            <li>
                <h5><i class="icon-comment"></i><?php _e('Comments', 'ct_theme'); ?></h5>

                <p><a href="<?php the_permalink()?>#comments"><?php echo wp_count_comments(get_the_ID())->approved?> <?php echo __("comments", "ct_theme");?></a></p>
            </li>
        <?php endif; ?>


    </ul>
   </div>
   <!-- / span8 -->
 </div>
 <!-- / row-fluid -->
</header>