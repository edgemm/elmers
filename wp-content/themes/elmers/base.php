<?php get_template_part('templates/header'); ?>
<?php $faqData = get_post() && ct_get_option('faq_index_page') == get_the_ID() ? 'data-spy="scroll" data-target="#faq1" data-offset="5"' : '';?>
<body <?php body_class((function_exists('icl_object_id') ? (ICL_LANGUAGE_CODE . ' ') : '') . (ct_use_boxed_layout() ? 'boxed ' : '') . ct_get_option('style_layout_background', 'pat1 ')); ?> <?php echo $faqData?>>

<?php if( is_home() || is_front_page() ) echo '<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=644654448887033";
  fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>'; ?>

<div id="boxedWrapper">

<?php get_template_part('templates/head-top-navbar');?>

<section id="content">
    <div class="container">
		<?php include roots_template_path(); ?>
	</div>
</section>

<?php get_template_part('templates/footer'); ?>

<!--footer-->
<?php wp_footer(); ?>

</div>
<!-- / boxedWrapper -->

<!-- end switcher -->

</body>
</html>
