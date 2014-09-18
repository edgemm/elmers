<div class="sidebar">
<?php // Determines Sub-Navigation for the General Sidebar
if (in_array("about-us", explode("/", $_SERVER["REQUEST_URI"]))) { ?>
	<section id="widget-submenu" class="widget widget_nav_menu">
		<div class="widget-inner">
			<h3>Related</h3>
			<?php wp_nav_menu( array('menu' => 'Sub-About Us' )); ?>
		</div>
	</section>
<? } ?>
	
	<?php if (in_array("northwest-vendors", explode("/", $_SERVER["REQUEST_URI"]))) { ?>
		<ul class="sidebar-widgets">
		<?php dynamic_sidebar( 'nwvendors' ); ?>
		</ul>
	<?php } else {
		ct_dynamic_sidebar();
	}?>
</div>
