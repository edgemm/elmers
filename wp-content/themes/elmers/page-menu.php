<?php /* Template Name: Menu */ ?>
<?php get_template_part('templates/page', 'head'); ?>
<?php $breadcrumbs = ct_show_single_post_breadcrumbs('page') ? true : false; ?>
<?php $pageTitle = ct_get_single_post_title('page'); ?>
<?php $pageSubtitle = ct_get_single_post_subtitle('page'); ?>
<?php $bookTable = ct_show_single_post_book('page') ? true : false; ?>



		<?php if($pageSubtitle):?>
			<?php echo do_shortcode('[title_row main="no"]' . $pageSubtitle . '[/title_row]');?>
		<?php endif; ?>
		<?php if($bookTable):?>
			<?php get_template_part('templates/content', 'book-table'); ?>
		<?php endif;?>

		<section class="menu">

			<?php if($pageTitle):?>
				<?php echo do_shortcode('[title_row]' . $pageTitle . '[/title_row]');?>
			<?php endif; ?>
			
			<div class="menu-sliders-container">
				<div class="menu-slider">
					<?php echo do_shortcode( '[nivo_slider effect="fade" pause="5000" ][nivo_slider_item imgsrc="/wp-content/uploads/2014/05/elmers_menu_german_pancake.jpg"][/nivo_slider_item][nivo_slider_item imgsrc="/wp-content/uploads/2014/05/elmers_menu_looking_for_sun_omelet.jpg"][/nivo_slider_item][nivo_slider_item imgsrc="/wp-content/uploads/2014/05/elmers_menu_yukon_french_toast.jpg"][/nivo_slider_item][/nivo_slider]' ); ?>
				</div>
			</div>

			<?php while (have_posts()) : the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; ?>

		</section>