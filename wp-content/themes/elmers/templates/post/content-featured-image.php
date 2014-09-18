<?php if (has_post_thumbnail(get_the_ID())): ?>
	<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'post_index'); ?>
	<?php $imageUrl = $image[0]; ?>
	<figure class="page-article-thmb">
		<a href="<?php echo get_permalink(get_the_ID())?>"><img src="<?php echo $imageUrl?>" alt=""></a>
	</figure>
<?php endif; ?>




