<?php
/**
 * Nivo Slider shortcode
 */
class ctNivoSliderShortcode extends ctShortcode {

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Nivo Slider';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'nivo_slider';
	}

	/**
	 * Add styles
	 */

	public function enqueueHeadScripts() {
		//wp_register_style('ct-nivo-slider-style', CT_THEME_ASSETS . '/css/nivo-slider.css');
		//wp_enqueue_style('ct-nivo-slider-style');
	}


	public function enqueueScripts() {
		wp_register_script('ct-nivo-slider', CT_THEME_ASSETS . '/libs/jquery.nivo.slider.pack.js');
		wp_enqueue_script('ct-nivo-slider');
	}

	/**
	 * Handles shortcode
	 * @param $atts
	 * @param null $content
	 * @return string
	 */

	public function handle($atts, $content = null) {
		$attributes = shortcode_atts($this->extractShortcodeAttributes($atts), $atts);
		extract($attributes);

		$id = rand(100, 1000);
		$this->addInlineJS($this->getInlineJS($attributes));
		return do_shortcode('<div class="nivoGallery">
		                          <div id="slider' . $id . '" class="nivoSlider">
		                                ' . $content . '
		                          </div>
		                      </div>');
	}

	/**
	 * returns JS
	 * @param $id
	 * @return string
	 */
	protected function getInlineJS($attributes) {
		extract($attributes);

		return 'jQuery(window).load(function() {
				    jQuery(".nivoSlider").nivoSlider({
				        effect: "' . $effect . '", // Specify sets like: "fold,fade,sliceDown"
                        slices: ' . $slices . ', // For slice animations
                        boxCols: ' . $boxcols . ', // For box animations
                        boxRows: ' . $boxrows . ', // For box animations
                        animSpeed: ' . $animspeed . ', // Slide transition speed
                        pauseTime: ' . $pause . ', // How long each slide will show
				        startSlide: 0, // Set starting Slide (0 index)
				        directionNav: true, // Next & Prev navigation
				        controlNav: false, // 1,2,3... navigation
				        controlNavThumbs: false, // Use thumbnails for Control Nav
				        pauseOnHover: false, // Stop animation while hovering
				        manualAdvance: false, // Force manual transitions
				        prevText: "Prev", // Prev directionNav text
				        nextText: "Next", // Next directionNav text
				        randomStart: false, // Start on a random slide
				        beforeChange: function(){}, // Triggers before a slide transition
				        afterChange: function(){}, // Triggers after a slide transition
				        slideshowEnd: function(){}, // Triggers after all slides have been shown
				        lastSlide: function(){}, // Triggers when last slide is shown
				        afterLoad: function(){} // Triggers when slider has loaded
				    });
				});';
	}

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
			'effect' => array('label' => __('effect', 'ct_theme'), 'default' => 'fade', 'type' => 'select', 'choices' => array("random" => "random", "sliceDown" => "sliceDown", "sliceDownLeft" => "sliceDownLeft", "sliceUp" => "sliceUp", "sliceUpLeft" => "sliceUpLeft", "sliceUpDown" => "sliceUpDown", "sliceUpDownLeft" => "sliceUpDownLeft", "fold" => "fold", "fade" => "fade", "slideInRight" => "slideInRight", "slideInLeft" => "slideInLeft", "boxRandom" => "boxRandom", "boxRain" => "boxRain", "boxRainReverse" => "boxRainReverse", "boxRainGrow" => "boxRainGrow", "boxRainGrowReverse" => "boxRainGrowReverse"), 'help' => __("Slider effect", 'ct_theme')),
			'pause' => array('label' => __('pause time', 'ct_theme'), 'default' => 3000, 'type' => 'input', 'help' => __('how long each slide will show in miliseconds (1 sec = 1000 milisec)', 'ct_theme')),
			'animspeed' => array('label' => __('animation speed', 'ct_theme'), 'default' => 500, 'type' => 'input', 'help' => __('slide transition speed in miliseconds (1 sec = 1000 milisec)', 'ct_theme')),
			'slices' => array('label' => __('slices', 'ct_theme'), 'default' => 15, 'type' => 'input', 'help' => __('number of slices for slice animations', 'ct_theme')),
			'boxcols' => array('label' => __('box columns', 'ct_theme'), 'default' => 8, 'type' => 'input', 'help' => __('number of columns for box animations', 'ct_theme')),
			'boxrows' => array('label' => __('box rows', 'ct_theme'), 'default' => 4, 'type' => 'input', 'help' => __('number of rows for box animations', 'ct_theme')),
		);
	}

	public function getChildShortcodeInfo() {
		return array('name' => 'nivo_slider_item', 'min' => 1, 'max' => 20, 'default_qty' => 3);
	}


}

new ctNivoSliderShortcode();