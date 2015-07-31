<?php /* Template Name: Home */ ?>
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

		<section>

			<?php if($pageTitle):?>
				<?php echo do_shortcode('[title_row]' . $pageTitle . '[/title_row]');?>
			<?php endif; ?>

			<?php while (have_posts()) : the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; ?>

			<?php
			// display menu only if mobile
			if ( $isMobile ) mobileMenu();
			?>
			
			<div class="row-fluid home-album">
				<div class="span12">
					<header>
						<h3 class="home-heading"><a class="sm-link" href="http://instagram.com/elmers_restaurants" target="_blank">Family Photo Album</a></h3>
						<p class="album-instagram">
							<a class="album-instagram-link img-replace" href="http://instagram.com/elmers_restaurants" target="_blank">View on Instagram</a>
						</p>
					</header>
					<?php echo do_shortcode("[metaslider id=97]"); ?>
				</div>
			</div>

			<div class="row-fluid home-donations">
				<div class="span12">
					<p class="donations-content home-heading">
						<a class="donations-link" href="/category/in-the-community/" title="">hand in hand, making a difference in our communities</a>
					</p>
					<?php dynamic_sidebar( 'donations' ); ?>
				</div>
			</div>

			<div class="row-fluid home-stories equal-height">
				<div class="span8">
					<div class="homePost-container">
					<?php
						wp_reset_query();
						
						$wpQuery = new WP_Query('cat=3&order=DESC&showposts=5');
						if ($wpQuery->have_posts()) {
							while ($wpQuery->have_posts()) {
								$wpQuery->the_post();
								
								// getting info for post
								$thmb_id = get_post_thumbnail_id($post->ID);
								$thmb = wp_get_attachment_image_src($thmb_id);
								$thmb_alt = get_post_meta($thmb_id , '_wp_attachment_image_alt', true);
				
								$content = get_the_content();
								$content = ( strlen( $content ) > 580 ) ? substr($content, 0, 580) . '... <a class="homePost-readmore" href="' . get_permalink() . '" title="Continue reading">read more</a>' : $content;
								$content = closeTags( $content );
								
							?>
							<article class="homePost homePost-<?php echo get_the_id(); ?>">						
								<header class="homePost-header"><h1 class="homePost-title home-heading"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h1></header>
								<div class="homePost-content">
									<figure class="homePost-thmb">
										<a href="<?php echo get_permalink(); ?>"><img class="homePost-thmb-img" src="<?php echo($thmb[0]); ?>" alt="<?php echo $thmb_alt; ?>" title="<?php the_title(); ?>" /></a>
									</figure>
									<div class="homePost-entry">
										<?php echo $content; ?>
									</div>
								</div>
							</article>
							<?php }
						}

						wp_reset_query();
					?>
					</div>
					<a class="homePost-navUp" href="javascript:void(0)"><i class="icon-angle-up"></i></a>
					<a class="homePost-navDown" href="javascript:void(0)"><i class="icon-angle-down"></i></a>
				</div>
				<div class="span4">
					<div class="latest-videos">
						<h3 class="home-heading"><a class="sm-link" href="https://www.youtube.com/user/ElmersRestaurant" target="_blank">Latest Videos</a></h3>
						<?php if( get_field( "youtube_video_url" ) ) : ?>
						<div class="video-container">
							<iframe width="634" height="357" src="https://www.youtube.com/embed/<?php echo get_youtube_id( get_the_ID() ); ?>?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
						</div>
						<?php else: ?>
						<p>Check our <a href="https://www.youtube.com/user/ElmersRestaurant/" target="_blank">YouTube channel</a> for our latest videos</p>
						<?php endif; ?>
					</div>
				</div>
			</div>

		</section>