<?php while (have_posts()) : the_post(); ?>
<?php the_content(); ?>
<?php wp_link_pages(array('before' => '<nav class="pager">', 'after' => '</nav>')); ?>


    <!-- testaroonie -->

<?php endwhile; ?>