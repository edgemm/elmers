<?php

// allow shortcodes in widgets
add_filter('widget_text', 'do_shortcode');

// add extra widget areas
add_action( 'after_setup_theme', 'elmers_setup_theme' );
if ( ! function_exists( 'elmers_setup_theme' ) ){
	function elmers_setup_theme(){
		register_sidebar( array(
			'name' => 'Home Top Right',
			'id' => 'hometopright',
			'before_title'  => '<h3 class="widgettitle"><a class="sm-link" href="https://www.youtube.com/user/ElmersRestaurant" target="_blank">',
			'after_title'   => '</a></h3>'
		));
		register_sidebar( array(
			'name' => 'NW Vendors',
			'id' => 'nwvendors',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
		));
		register_sidebar( array(
			'name' => 'Donations Raised',
			'id' => 'donations',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
		));
	}
}

add_action( 'after_setup_theme', 'set_thumbnail' );
function set_thumbnail() {
	add_image_size('post_elmers', 700, 158, true );
}

function elmers_scripts() {
	wp_enqueue_script( 'jquery-cookie', get_stylesheet_directory_uri() . '/js/jquery.cookie.js', array(), '1.4.0', false );
	wp_enqueue_script( 'elmers-scripts', get_stylesheet_directory_uri() . '/js/scripts.js', array(), '1.0.0', true );

	// load GA scripts for search tracking - gfh
	if ( is_page( 3 ) ) wp_enqueue_script( 'location-scripts', get_stylesheet_directory_uri() . '/js/elmers-locations.js', array(), '1.0.0', true );
	
	// load masonry onto menu page - gfh
	if ( is_page_template( 'page-menu.php' ) ) {
		wp_enqueue_script( 'jquery-masonry', get_stylesheet_directory_uri() . '/js/jquery.masonry.min.js', array(), '3.1.5', true );
		wp_enqueue_script( 'jquery-nivo-slider', get_template_directory_uri() . '/assets/libs/jquery.nivo.slider.pack.js', array(), '3.9', true );
		wp_enqueue_script( 'elmers-menu', get_stylesheet_directory_uri() . '/js/elmers-menu.js', array(), '1.0.0', true );
	}
}
add_action( 'wp_enqueue_scripts', 'elmers_scripts' );

// for closing HTML on generated post excerpts - gfh
function closeTags($html) {
	preg_match_all('#<(?!meta|img|br|hr|input\b)\b([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
	$openedtags = $result[1];
	preg_match_all('#</([a-z]+)>#iU', $html, $result);
	$closedtags = $result[1];
	$len_opened = count($openedtags);
	if (count($closedtags) == $len_opened) {
		return $html;
	}
	$openedtags = array_reverse($openedtags);
	for ($i=0; $i < $len_opened; $i++) {
		if (!in_array($openedtags[$i], $closedtags)) {
			$html .= '</'.$openedtags[$i].'>';
		} else {
			unset($closedtags[array_search($openedtags[$i], $closedtags)]);
		}
	}
	return $html;
}

// check for mobile and display menu if true
function checkMobile() {
	global $isMobile;
	//global $isItMobile = "it is not mobile";

	$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino|android|ipad|playbook|silk/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
	$isMobile = true;
	
	return $isMobile;
} 

}

function mobileMenu() {
	$args = array(
		'menu'            => 'mobile-menu',
		'container'       => 'div',
		'container_class' => 'menu-mobile-container',
		'container_id'    => 'menu-mobile',
		'menu_class'      => 'menu-mobile',
		'menu_id'         => 'menu-mobile-menu',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
	);
	
	return wp_nav_menu( $args );
}

function menuFooter() {
	$args = array(
		'menu'            => 'footer-menu',
		'container'       => 'div',
		'container_class' => '',
		'container_id'    => '',
		'menu_class'      => 'footer-nav-list',
		'menu_id'         => 'footer-menu',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
	);

	return wp_nav_menu( $args );
}

function menuFooterMobile() {
	$args = array(
		'menu'            => 'mobile-footer',
		'container'       => 'div',
		'container_class' => '',
		'container_id'    => '',
		'menu_class'      => 'footer-nav-list',
		'menu_id'         => 'footer-menu-mobile',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
	);

	return wp_nav_menu( $args );
}

// load menu sliders - gfh
add_action('wp_ajax_get_menu_slider', 'get_menu_slider');
add_action('wp_ajax_nopriv_get_menu_slider', 'get_menu_slider');

function get_menu_slider() {
	$slider_id = $_POST['slider_id'];
	
	switch( $slider_id ) {
		case "breakfast":
			$slides = '[nivo_slider_item imgsrc="/wp-content/uploads/2014/05/elmers_menu_german_pancake.jpg"][/nivo_slider_item][nivo_slider_item imgsrc="/wp-content/uploads/2014/05/elmers_menu_looking_for_sun_omelet.jpg"][/nivo_slider_item][nivo_slider_item imgsrc="/wp-content/uploads/2014/05/elmers_menu_yukon_french_toast.jpg"][/nivo_slider_item]';
			break;
		case "lunch":
			$slides = '[nivo_slider_item imgsrc="/wp-content/uploads/2014/05/elmers_menu_prime_rib.jpg"][/nivo_slider_item][nivo_slider_item imgsrc="/wp-content/uploads/2014/05/elmers_menu_crab_blt.jpg"][/nivo_slider_item][nivo_slider_item imgsrc="/wp-content/uploads/2014/05/elmers_menu_fish_chips.jpg"][/nivo_slider_item]';
			break;
		case "kids":
			$slides = '[nivo_slider_item imgsrc="/wp-content/uploads/2014/05/elmers_menu_cub_cake.jpg"][/nivo_slider_item][nivo_slider_item imgsrc="/wp-content/uploads/2014/05/elmers_menu_bigfoot_breakfast.jpg"][/nivo_slider_item][nivo_slider_item imgsrc="/wp-content/uploads/2014/05/elmers_menu_cheeseburger_sliders.jpg"][/nivo_slider_item]';
			break;
		case "seasonal":
			//$slides = '[nivo_slider_item imgsrc="http://eatatelmers.com/wp-content/uploads/2014/04/front_img01.jpg"][/nivo_slider_item][nivo_slider_item imgsrc="http://eatatelmers.com/wp-content/uploads/2014/04/front_img02.jpg"][/nivo_slider_item][nivo_slider_item imgsrc="http://eatatelmers.com/wp-content/uploads/2014/04/front_img03.jpg"][/nivo_slider_item]';
			$slides = '[nivo_slider_item imgsrc="http://eatatelmers.com/wp-content/uploads/2015/06/FP3-2015_MenuFeatures-BlueberryBananaCrepes.jpg"][/nivo_slider_item][nivo_slider_item imgsrc="http://eatatelmers.com/wp-content/uploads/2015/06/FP3-2015_MenuFeatures-ClubhouseOmelet.jpg"][/nivo_slider_item][nivo_slider_item imgsrc="http://eatatelmers.com/wp-content/uploads/2015/06/FP3-2015_MenuFeatures-ClamstripBasket.jpg"][/nivo_slider_item]';
			break;
		case "beverages":
			$slides = '[nivo_slider_item imgsrc="/wp-content/uploads/2014/05/elmers_menu_coffee.jpg"][/nivo_slider_item]';
			break;
		default:
			$slides = "";
	}

	if( !empty( $slides ) ) {
		$result = '[nivo_slider effect="fade" pause="5000" ]';
		$result .= $slides;
		$result .= '[/nivo_slider]';

		echo do_shortcode( $result );
	} else {
		$result = "nada";
		echo $result;
	}
   
   die();
}

?>