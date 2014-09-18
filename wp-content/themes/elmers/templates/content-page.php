<?php while (have_posts()) : the_post(); ?>
<?php if (ct_get_option("posts_single_show_image", 1)): ?>
        <?php get_template_part('templates/post_single/content-featured-image'); ?>
<?php endif; ?>
<?php the_content(); ?>
<?php wp_link_pages(array('before' => '<nav class="pager">', 'after' => '</nav>')); ?>


    <?php comments_template('/templates/comments.php'); ?>

<?php endwhile; ?>