<?php
/*
Template Name: Right Sidebar Template
*/
?>

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

		<section id="blog">

			<?php if($pageTitle):?>
				<?php echo do_shortcode('[title_row]' . $pageTitle . '[/title_row]');?>
			<?php endif; ?>

			<?php get_template_part('templates/content', 'title'); ?>

			<div class="row-fluid content-bg">
				<div class="span9">
					<?php get_template_part('templates/content', 'page-custom'); ?>
				</div>
				<div class="span3">
					<?php get_template_part('templates/sidebar'); ?>
				</div>
			</div>

		</section>

