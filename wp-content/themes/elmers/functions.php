<?php

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

add_action('init', 'create_post_types'); // Add Custom Post Type

function create_post_types() {

	// home sliders
	register_post_type( 'slide',
		array(
		'labels' => array(
			'name'			=> _x( 'Slides', 'slide' ),
			'singular_name'		=> _x( 'Slide', 'slide' ),
			'add_new'		=> _x( 'Add New Slide', 'slide' ),
			'add_new_item'		=> _x( 'Add New Slide', 'slide' ),
			'edit_item'		=> _x( 'Edit Slide', 'slide' ),
			'new_item'		=> _x( 'New Slide', 'slide' ),
			'view_item'		=> _x( 'View Slide', 'slide' ),
			'search_items'		=> _x( 'Search Slides', 'slide' ),
			'not_found'		=> _x( 'No slides found', 'slide' ),
			'not_found_in_trash'	=> _x( 'No slides found in Trash', 'slide' ),
			'parent_item_colon'	=> _x( 'Parent Slide:', 'slide' ),
			'menu_name'		=> _x( 'Slides', 'slide' ),
		),
		'hierarchical'		=> false,
		'supports'		=> array(
			'title',
			'editor',
			'thumbnail',
			'custom-fields'
		),
		'public'		=> true,
		'show_ui'		=> true,
		'menu_position'		=> 20,
		'menu_icon'		=> 'dashicons-images-alt',
		'show_in_nav_menus'	=> false,
		'publicly_queryable'	=> false,
		'exclude_from_search'	=> true,
		'has_archive'		=> false,
		'query_var'		=> true,
		'can_export'		=> true,
		'rewrite'		=> true,
		'capability_type'	=> 'post'
	));

}

/*------------------------------------*\
	Custom Taxonomies
\*------------------------------------*/

add_action('init', 'create_taxonomies'); // Add Custom Taxonomies

function create_taxonomies() {

	// slide categories
	register_taxonomy( 'slide_category', array( 'slide' ),
		array(
		'labels'		=> array(
			'name'				=> _x( 'Slide Categories', 'Taxonomy General Name', 'text_domain' ),
			'singular_name'			=> _x( 'Slide Category', 'Taxonomy Singular Name', 'text_domain' ),
			'menu_name'			=> __( 'Slide Categories', 'text_domain' ),
			'all_items'			=> __( 'All Slide Items', 'text_domain' ),
			'parent_item'			=> __( 'Parent Slide Category', 'text_domain' ),
			'parent_item_colon'		=> __( 'Parent Slide Category:', 'text_domain' ),
			'new_item_name'			=> __( 'New Slide Category', 'text_domain' ),
			'add_new_item'			=> __( 'Add New Slide Category', 'text_domain' ),
			'edit_item'			=> __( 'Edit Slide Category', 'text_domain' ),
			'update_item'			=> __( 'Update Slide Category', 'text_domain' ),
			'view_item'			=> __( 'View Slide Category', 'text_domain' ),
			'separate_items_with_commas'	=> __( 'Separate items with commas', 'text_domain' ),
			'add_or_remove_items'		=> __( 'Add or remove items', 'text_domain' ),
			'choose_from_most_used'		=> __( 'Choose from the most used', 'text_domain' ),
			'popular_items'			=> __( 'Popular Items', 'text_domain' ),
			'search_items'			=> __( 'Search Items', 'text_domain' ),
			'not_found'			=> __( 'Not Found', 'text_domain' )
		),
		'hierarchical'		=> true,
		'public'		=> true,
		'show_ui'		=> true,
		'show_admin_column'	=> true,
		'show_in_nav_menus'	=> true,
		'show_tagcloud'		=> true,
	));

}

/*------------------------------------*\
	Widgets
\*------------------------------------*/

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
	add_image_size('menu_slide', 940, 351, true );
}

function elmers_scripts() {
	wp_enqueue_script( 'jquery-cookie', get_stylesheet_directory_uri() . '/js/jquery.cookie.js', array(), '1.4.0', false );
	wp_enqueue_script( 'elmers-scripts', get_stylesheet_directory_uri() . '/js/scripts.js', array(), '1.0.0', true );

	// load GA scripts for search tracking
	if ( is_page( 3 ) ) wp_enqueue_script( 'location-scripts', get_stylesheet_directory_uri() . '/js/elmers-locations.js', array(), '1.0.0', true );
	
	// load masonry onto menu page
	if ( is_page_template( 'page-menu.php' ) ) {
		wp_enqueue_script( 'jquery-masonry', get_stylesheet_directory_uri() . '/js/jquery.masonry.min.js', array(), '3.1.5', true );
		wp_enqueue_script( 'jquery-nivo-slider', get_template_directory_uri() . '/assets/libs/jquery.nivo.slider.pack.js', array(), '3.9', true );
		wp_enqueue_script( 'elmers-menu', get_stylesheet_directory_uri() . '/js/elmers-menu.js', array(), '1.0.0', true );
	}
}
add_action( 'wp_enqueue_scripts', 'elmers_scripts' );

// for closing HTML on generated post excerpts
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

// load menu sliders
add_action('wp_ajax_get_menu_slider', 'get_menu_slider');
add_action('wp_ajax_nopriv_get_menu_slider', 'get_menu_slider');

function get_menu_slider( $s ) {
	$slider_id = ( !empty( $s ) ) ? $s : $_POST['slider_id'];
	$slides = ""; // string to hold slider shortcodes
	
	$menu_slider_args = array(
		'post_type'		=> 'slide',
		'post_status'		=> 'publish',
		'posts_per_page'	=> -1,
		'tax_query'		=> array(
			array(
				'taxonomy'	=> 'slide_category',
				'field'		=> 'slug',
				'terms'		=> $slider_id
			)
		),
		'meta_key'		=> 'slide_order',
		'orderby'		=> 'meta_value_num',
		'order'			=> 'ASC'
	);
	
	$menu_slider_query = new WP_Query( $menu_slider_args );
	
	if( $menu_slider_query->have_posts() ) :
	
		while( $menu_slider_query->have_posts() ) :
		
			$menu_slider_query->the_post();

			$slide_thmb_url = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), "menu_slide" );
			$site_url = get_site_url();
			$slide_thmb_src = str_replace( $site_url, "", $slide_thmb_url['0'] );

			$slides .= '[nivo_slider_item imgsrc="' . $slide_thmb_src . '"][/nivo_slider_item]';
	
		endwhile;
	
	endif;

	if( !empty( $slides ) ) {
		$result = '[nivo_slider effect="fade" pause="5000" ]';
		$result .= $slides;
		$result .= '[/nivo_slider]';

		echo do_shortcode( $result );
	} else {
		$result = $slider_id;
		echo "<!-- the result is: " . $result . " -->";
	}
	
	wp_reset_postdata();
   
	if( empty( $s ) ) die();
}

//add_action( 'admin_init', 'edge_allow_updates' );
//function edge_allow_updates() {
//
//	// get current user
//	$user = wp_get_current_user();
//
//	// allow adding/updating plugins if users with correct permissions
//	if( $user && isset( $user->user_login) && 'gavin@edgemm.com' == $user->user_login ) :
//
//		define( 'DISALLOW_FILE_MODS', FALSE );
//
//	endif;
//
//}

?>