<header id="top">
	
	<div class="navigation">
		<div class="container">
			<div class="row-fluid">
				<div class="span12">

					<div class="navbar">
						<div class="navbar-inner">
							<?php if ($logo = ct_get_option('general_logo')) { ?>
								<a class="brand" href="<?php echo home_url(); ?>"><img src="<?php echo esc_url($logo) ?>" alt="logo"/></a>
							<?php } elseif ($plain = ct_get_option('general_logo_html')) { ?>
								<?php echo $plain ?>
							<?php };?>

								<label for="nav-expand" class="nav-trigger"><i class="fa fa-bars"></i></label>
								<input type="radio" name="nav" id="nav-expand" class="nav-toggle" />
								<label for="nav-recant" class="nav-recant nav-toggle img-replace"></label>
								<input type="radio" name="nav" id="nav-recant" class="nav-toggle" />
		
							<div class="nav-collapse collapse" id="nav-main">
								<?php if (has_nav_menu('primary_navigation')) {
									wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_id' => 'nav', 'menu_class' => 'nav pull-right'));
								}?>
							</div>
						</div>
					</div>
					
					<div class="fb-like" data-href="https://www.facebook.com/eatatelmers" data-width="275px" data-height="38px" data-colorscheme="light" data-layout="standard" data-action="like" data-show-faces="false" data-send="false"></div>
					<div class="eclub gradient-blue">
						<?php //echo do_shortcode('[contact-form-7 id="28" title="eClub Signup"]'); ?>
						<div id="mc_embed_signup">
							<form action="http://eatatelmers.us6.list-manage.com/subscribe/post?u=fd04b74d05&amp;id=150d2acbe3" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
								<fieldset class="eclub-fields">
									<legend class="eclub-legend">eClub Sign-up</legend>
									<div class="mc-field-group eclub-row">
										<label for="mce-FNAME" class="eclub-label">First Name</label>
										<span class="eclub-input-wrap">
											<input type="text" value="" name="FNAME" class="eclub-input" id="mce-FNAME">
										</span>
									</div>
									<div class="mc-field-group eclub-row">
										<label for="mce-LNAME" class="eclub-label">Last Name</label>
										<span class="eclub-input-wrap">
											<input type="text" value="" name="LNAME" class="eclub-input" id="mce-LNAME">
										</span>
									</div>
									<div class="mc-field-group eclub-row">
										<label for="mce-EMAIL" class="eclub-label">Email</label>
										<span class="eclub-input-wrap">
											<input type="email" value="" name="EMAIL" class="required email eclub-input" id="mce-EMAIL">
										</span>
									</div>
									<div class="mc-field-group size1of2 eclub-row">
										<label for="mce-MMERGE3-month" class="eclub-label">Birthday</label>
										<div class="datefield eclub-input-wrap">
											<span class="subfield monthfield"><input class="eclub-input" type="text" pattern="[0-9]*" value="MM" size="2" maxlength="2" name="MMERGE3[month]" id="mce-MMERGE3-month"></span>
											<span class="subfield dayfield"><input class="eclub-input" type="text" pattern="[0-9]*" value="DD" size="2" maxlength="2" name="MMERGE3[day]" id="mce-MMERGE3-day"></span>
										<div class="fake-date"><input type="hidden" class=" date" id="MMERGE3-fake-date" value=""></div>
										</div>
									</div>
									<div id="mce-responses" class="clear eclub-row">
											<div class="response" id="mce-error-response" style="display:none"></div>
											<div class="response" id="mce-success-response" style="display:none"></div>
									</div>
									<div style="position: absolute; left: -5000px;"><input type="text" name="b_fd04b74d05_150d2acbe3" value=""></div>
									<div class="clear eclub-row eclub-row-submit"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
								</fieldset>
							</form>
							</div>
					</div>

				</div>
			</div>
			
		</div>
	</div>	

</header>