<?php get_template_part('templates/page', 'head'); ?>
<?php $breadcrumbs = ct_show_index_post_breadcrumbs('post') ? true : false; ?>
<?php $pageTitle = ct_get_index_post_title('post'); ?>
<?php $pageSubtitle = ct_get_index_post_subtitle('post'); ?>
<?php $bookTable = ct_show_index_post_book('post') ? true : false; ?>

<?php
//The Query
global $wp_query;
$arrgs = $wp_query->query_vars;
$arrgs['posts_per_page'] = ct_get_option("posts_index_per_page", 3);
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$arrgs['paged'] = $paged;
$wp_query->query($arrgs);
?>



		<?php if($pageSubtitle):?>
			<?php echo do_shortcode('[title_row main="no"]' . $pageSubtitle . '[/title_row]');?>
		<?php endif; ?>
		<?php if($bookTable):?>
			<?php get_template_part('templates/content', 'book-table'); ?>
		<?php endif;?>

		<section id="blog">

			<?php get_template_part('templates/content', 'title'); ?>

			<?php if (have_posts()) : ?>
				<?php if (isset($wp_query) && $wp_query->max_num_pages > 1) : ?>

					<?php  $big = 999999999; // need an unlikely integer
					$pagerArgs = array(
						'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
						'format' => '?page=%#%',
						'total' => $wp_query->max_num_pages,
						'current' => $paged,
						'show_all' => false,
						'end_size' => 1,
						'mid_size' => 1,
						'prev_next' => false,
						'type' => 'array',
					);
					$links = paginate_links($pagerArgs);?>

					<div class="pagination pagination-right">
						<ul>
							<?php foreach ($links as $link): ?>
								<li<?php ?>><?php echo $link; ?></li>
							<?php endforeach;?>
							<?php if ($paged != 1): ?>
								<li class="prev"><a class="nav-btn" href="<?php echo get_previous_posts_page_link(); ?>"><i class="icon-angle-left"></i></a></li>
							<?php endif;?>
							<?php if ($paged != $wp_query->max_num_pages): ?>
								<li class="next"><a class="nav-btn" href="<?php echo get_next_posts_page_link() ?>"><i class="icon-angle-right"></i></a></li>
							<?php endif; ?>
						</ul>
					</div>
				<?php endif; ?>
			<?php endif;?>

			<div class="row-fluid"> <!-- blog -->
				<?php if (is_404()): ?><div class="span9"><?php else: ?><div class="<?php ct_blog_index_class() ?>"><?php endif;?>
					<?php if ( is_category( '7' ) ) {
						echo '<div class="donation-header">';
					} ?>
					<?php echo category_description(); ?>
					<?php if ( is_category( '7' ) ) {
						dynamic_sidebar( 'donations' );
						echo '</div>';
					} ?>
					<?php get_template_part('templates/content'); ?>
				</div>
				<?php if (ct_use_blog_index_sidebar()): ?>
					<div class="<?php roots_sidebar_class(); ?>">
						<?php get_template_part('templates/sidebar'); ?>
					</div>
				<?php endif;?>
			</div>
			<!-- //row -->

				<?php if (have_posts()) : ?>
					<?php if (isset($wp_query) && $wp_query->max_num_pages > 1) : ?>

						<div class="pagination pagination-right">
							<ul>
								<?php foreach ($links as $link): ?>
									<li<?php ?>><?php echo $link; ?></li>
								<?php endforeach;?>
								<?php if ($paged != 1): ?>
									<li class="prev"><a href="<?php echo get_previous_posts_page_link(); ?>"><i class="icon-angle-left"></i></a></li>
								<?php endif;?>
								<?php if ($paged != $wp_query->max_num_pages): ?>
									<li class="next"><a href="<?php echo get_next_posts_page_link() ?>"><i class="icon-angle-right"></i></a></li>
								<?php endif; ?>
							</ul>
						</div>
						<?php if (false): ?><?php posts_nav_link(); ?><?php endif; ?>
					<?php endif; ?>
				<?php endif;?>

		</section>