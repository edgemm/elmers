  <footer id="footer" class="gradient-blue">
    <div class="container">
      <div class="row-fluid">
	<nav class="footer-nav footer-nav-bubble">
	  <ul class="footer-bubble-list">
	    <li class="footer-home-item"><a href="/" class="footer-bubble-link footer-social-home img-replace" target="_blank">Home</a></li>
	    <li><a href="http://www.youtube.com/ElmersRestaurant" class="footer-bubble-link footer-social-youtube img-replace" target="_blank">YouTube</a></li>
	    <li><a href="http://instagram.com/elmers_restaurants" class="footer-bubble-link footer-social-instagram img-replace" target="_blank">Instagram</a></li>
	    <li><a href="http://www.facebook.com/eatatelmers" class="footer-bubble-link footer-social-facebook img-replace" target="_blank">Facebook</a></li>
	  </ul>
	</nav>
	<nav class="footer-nav footer-nav-text">
	    <?php
	    // load both menus and hide
	    menuFooter();
	    menuFooterMobile();
	    ?>
	</nav>
	<p class="footer-slogan">25 Communities. 11 Local Owners. 1 BIG Family.</p>
	<p class="footer-copyright">
	      <?php echo strtr(ct_get_option('general_footer_text', ''), array('%year%' => date('Y'), '%name%' => get_bloginfo('name', 'display')))?>
	</p>
      </div>
    </div>
  </footer>