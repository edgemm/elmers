<?php checkMobile(); // set $isMobile if mobile ?>
<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title><?php wp_title('|', true, 'right'); /*bloginfo('name');*/ ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<?php if (have_posts()) : ?>
		<link rel="alternate" type="application/rss+xml" title="<?php echo get_bloginfo('name') ?> Feed" href="<?php echo home_url() ?>/feed/">
	<?php endif; ?>

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="<?php echo CT_THEME_ASSETS ?>/libs/html5shiv.js"></script>
    <![endif]-->

	<?php wp_head(); ?>
	
	<script type="text/javascript">
	function gaTrakEclub() {
		<?php if( !is_user_logged_in() ) { echo "_gaq.push(['_trackEvent', 'Form', 'Submit', 'eClub Sign Up']);"; } ?>
		window.location = "<?php echo site_url('/eclub-thank-you/'); ?>";
	}
	</script>

	<!--[if gte IE 8]>
		<link rel="stylesheet" type="text/css" href="<?php echo CT_THEME_ASSETS ?>/css/ie.css" />
	<![endif]-->
</head>
