<?php // Template Name: Careers ?>

		<section>

			<?php if($pageTitle):?>
				<?php echo do_shortcode('[title_row]' . $pageTitle . '[/title_row]');?>
			<?php endif; ?>

			<?php get_template_part('templates/content', 'title'); ?>

			<?php if (have_posts()): while (have_posts()) : the_post(); ?>

				<div class="row-fluid">

					<article id="post-<?php the_ID(); ?>" <?php post_class( array( 'sixteen', 'columns', 'inner' ) ); ?>>
		
						<?php echo do_shortcode( '[contact-form-7 id="1129" title="Employee Application"]' ); ?>
		
					</article>

				</div>
	
			<?php endwhile; ?>
	
			<?php endif; ?>

		</section>
