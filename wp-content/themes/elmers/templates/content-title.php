<?php if (ct_get_option("posts_single_show_title", 1)): ?>
<div class="row-fluid title-wrapper">
	<div class="span12 title-container">
		<header class="title">
			<h2 class="title-heading"><span class="title-content"><?php single_cat_title( '', true ); ?></span></h2>
		</header>
	</div>
</div>
<?php endif;?>