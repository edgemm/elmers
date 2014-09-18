<?php while (have_posts()) : the_post(); ?>
	<?php $format = get_post_format();
	$format = $format ? $format : 'standard';
	$class = $format == 'link' ? 'blog-post blogItem format-link' : 'blog-post blogItem';
	?>

	<?php //$prev = get_previous_post();?>
	<?php //$next = get_next_post();?>

	<?php if($next || $prev):?>
		<div class="row-fluid">
			<div class="span12">
				<div class="blog-comments">
					<div>
						<ul class="pager">
							<?php if($next):?>
							<li class="previous">
								<a class="nav-btn" href="<?php echo get_permalink($next->ID);?>"><i class="icon-angle-left"></i> <?php _e('Previous Post', 'ct_theme')?></a>
							</li>
							<?php endif;?>
							<?php if($prev):?>
							<li class="next">
								<a class="nav-btn" href="<?php echo get_permalink($prev->ID);?>"><?php _e('Next Post', 'ct_theme')?> <i class="icon-angle-right"></i></a>
							</li>
							<?php endif;?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	<?php endif;?>

	<article class="<?php echo $class; ?>">
		<?php get_template_part('templates/post_single/content-' . $format);?>
	</article>

	<?php // comments_template('/templates/comments.php'); ?>

	<?php if($next || $prev):?>
		<div class="row-fluid">
			<div class="span9 offset3">
				<div class="blog-comments">
					<div>
						<ul class="pager">
							<?php if($next):?>
							<li class="previous">
								<a href="<?php echo get_permalink($next->ID);?>"><i class="icon-angle-left"></i> <?php _e('Previous Post', 'ct_theme')?></a>
							</li>
							<?php endif;?>
							<?php if($prev):?>
							<li class="next">
								<a href="<?php echo get_permalink($prev->ID);?>"><?php _e('Next Post', 'ct_theme')?> <i class="icon-angle-right"></i></a>
							</li>
							<?php endif;?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	<?php endif;?>

<?php endwhile; ?>