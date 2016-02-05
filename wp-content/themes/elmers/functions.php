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
	
	// fancybox
    wp_register_style( 'fancybox', get_stylesheet_directory_uri() . '/fancybox/jquery.fancybox.css', array(), '2.1.5', 'all');
    wp_enqueue_style( 'fancybox' );
	wp_enqueue_script( 'jquery-fancybox', get_stylesheet_directory_uri() . '/fancybox/jquery.fancybox.pack.js', array(), '2.1.5', true );
    
	wp_enqueue_script( 'jquery-cookie', get_stylesheet_directory_uri() . '/js/jquery.cookie.js', array(), '1.4.0', false );
	wp_enqueue_script( 'elmers-scripts', get_stylesheet_directory_uri() . '/js/scripts.js', array(), '1.0.0', true );

	// employment application
	wp_enqueue_script( 'jquery-employee-app', get_stylesheet_directory_uri() . '/js/employment-app.js', array(), '1.0', true );

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

// remove parent theme scripts
function remove_scripts() {
    if( is_page( 236 ) ) :
        wp_deregister_script( 'ct_bootstrap_select' );
        //wp_dequeue_script( 'ct_bootstrap_select' );
    endif;
}
add_action( 'wp_print_scripts', 'remove_scripts', 100 );

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

// get ID of YouTube video for specific post
function get_youtube_id( $p ) {
   $f_video_url = get_post_meta($p,'youtube_video_url',true);
   parse_str( parse_url( $f_video_url, PHP_URL_QUERY ), $f_video );
   
   return $f_video['v'];
}

/*------------------------------------*\
	Employement Application
\*------------------------------------*/

// Custom Date Field Validation (exclude forcing yyyy-mm-dd format)

// replace CF7 default validation
remove_filter( 'wpcf7_validate_date', 'wpcf7_date_validation_filter', 10 );
remove_filter( 'wpcf7_validate_date*', 'wpcf7_date_validation_filter', 10 );

add_filter( 'wpcf7_validate_date', 'elmers_wpcf7_date_validation_filter', 10, 2 );
add_filter( 'wpcf7_validate_date*', 'elmers_wpcf7_date_validation_filter', 10, 2 );

// custom date validation (CF7 plugin -> modules -> date.php -> ln 79)
function elmers_wpcf7_date_validation_filter( $result, $tag ) {
	$tag = new WPCF7_Shortcode( $tag );

	$name = $tag->name;

	$min = $tag->get_date_option( 'min' );
	$max = $tag->get_date_option( 'max' );

	$value = isset( $_POST[$name] )
		? trim( strtr( (string) $_POST[$name], "\n", " " ) )
		: '';

	if ( $tag->is_required() && '' == $value ) {
		$result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );
	} elseif ( '' != $value && ! empty( $min ) && $value < $min ) {
		$result->invalidate( $tag, wpcf7_get_message( 'date_too_early' ) );
	} elseif ( '' != $value && ! empty( $max ) && $max < $value ) {
		$result->invalidate( $tag, wpcf7_get_message( 'date_too_late' ) );
	}

	return $result;
}


function wpcf7_add_references( $WPCF7_ContactForm ) {

	// get field values for each reference
	$submission = WPCF7_Submission::get_instance();
	
	$id = $WPCF7_ContactForm->id();
		$mail = $WPCF7_ContactForm->prop( 'mail' );
	
	if( $submission && $id == '1125' ) :

		$data = $submission->get_posted_data();

		// loop through references until empty
		$i = 1;
		
		while( $i > 0 ) :

			if( !empty( $data[ 'neverEmployed' ][0] ) ) :

				$mail[ 'body' ] .= '<table class="app-2col col-container" width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="col-subsection" width="100%" align="center" colspan="2" valign="top" style="padding-top: 8px;padding-right: 15px;padding-left: 15px;">
						 <table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td>
									<p class="value" style="margin-top: 0px;margin-right: 0px;margin-left: 0px;margin-bottom: 9px;padding-top: 10px;font-size: 14px;line-height: 1.28571429em;color: #777775 !important;">I have not worked in the past</p>
								</td>
							</tr>
						 </table>
					</td>
				</tr>';

				$i = 0; // end search if never worked in the past

				break;

			elseif( !empty( $data[ 'refEnabled' . $i ] ) ) :

				// contacting reference permission needs to be array for first, string for others
				$refPermission = ( $i > 1 ) ? $data[ "refPermission" . $i ] : $data[ "refPermission" . $i ][0];
			
				$mail[ 'body' ] .= '<table class="app-2col col-container" width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="col-subsection" width="100%" align="center" colspan="2" valign="top" style="padding-top: 8px;padding-right: 15px;padding-left: 15px;">
						 <table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td>
									<span class="subsection-headline" style="font-size: 1.25em;font-weight: bold;">Reference # ' . $i . ' Info:</span>
								</td>
							</tr>
						 </table>
					</td>
				</tr>
				<tr>
					<td class="col-2col col-alpha col-content" width="50%" align="center" valign="top" style="padding-top: 15px;padding-right: 15px;padding-bottom: 15px;padding-left: 15px;">
						 <table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td>
									<span class="label" style="font-weight: bold;">Company:</span>
									<p class="value" style="margin-top: 0px;margin-right: 0px;margin-left: 0px;margin-bottom: 9px;padding-top: 10px;font-size: 14px;line-height: 1.28571429em;color: #777775 !important;">' . $data[ "refCompany" . $i ] . '</p>
								</td>
							</tr>
						 </table>
					</td>
					<td class="col-2col col-alpha col-content" width="50%" align="center" valign="top" style="padding-top: 15px;padding-right: 15px;padding-bottom: 15px;padding-left: 15px;">
						 <table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td>
									<span class="label" style="font-weight: bold;">Telephone:</span>
									<p class="value" style="margin-top: 0px;margin-right: 0px;margin-left: 0px;margin-bottom: 9px;padding-top: 10px;font-size: 14px;line-height: 1.28571429em;color: #777775 !important;">' . $data[ "refPhone" . $i ] . '</p>
								</td>
							</tr>
						 </table>
					</td>
				</tr>
			</table>';
			$mail[ 'body' ] .= '<table class="col-container" width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="col-content" width="100%" align="center" valign="top" style="padding-top: 15px;padding-right: 15px;padding-bottom: 15px;padding-left: 15px;">
						 <table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td>
									<span class="label" style="font-weight: bold;">Address</span>
									<p class="value" style="margin-top: 0px;margin-right: 0px;margin-left: 0px;margin-bottom: 9px;padding-top: 10px;font-size: 14px;line-height: 1.28571429em;color: #777775 !important;">' . $data[ "refAddr" . $i ] . '</p>
								</td>
							</tr>
						 </table>
					</td>
				</tr>
			</table>';
			$mail[ 'body' ] .= '<table class="app-3col col-container" width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="col-3col col-alpha col-content" width="33%" align="center" valign="top" style="padding-top: 15px;padding-right: 15px;padding-bottom: 15px;padding-left: 15px;">
						 <table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td class="col-3col-content">
									<span class="label" style="font-weight: bold;">City:</span>
									<p class="value" style="margin-top: 0px;margin-right: 0px;margin-left: 0px;margin-bottom: 9px;padding-top: 10px;font-size: 14px;line-height: 1.28571429em;color: #777775 !important;">' . $data[ "refCity" . $i ] . '</p>
								</td>
							</tr>
						 </table>
					</td>
					<td class="col-3col col-alpha col-content" width="33%" align="center" valign="top" style="padding-top: 15px;padding-right: 15px;padding-bottom: 15px;padding-left: 15px;">
						 <table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td class="col-3col-content">
									<span class="label" style="font-weight: bold;">State:</span>
									<p class="value" style="margin-top: 0px;margin-right: 0px;margin-left: 0px;margin-bottom: 9px;padding-top: 10px;font-size: 14px;line-height: 1.28571429em;color: #777775 !important;">' . $data[ "refState" . $i ] . '</p>
								</td>
							</tr>
						 </table>
					</td>
					<td class="col-2col col-omega col-content" width="33%" align="center" valign="top" style="padding-top: 15px;padding-right: 15px;padding-bottom: 15px;padding-left: 15px;">
						 <table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td class="col-3col-content">
									<span class="label" style="font-weight: bold;">Zip Code:</span>
									<p class="value" style="margin-top: 0px;margin-right: 0px;margin-left: 0px;margin-bottom: 9px;padding-top: 10px;font-size: 14px;line-height: 1.28571429em;color: #777775 !important;">' . $data[ "refZip" . $i ] . '</p>
								</td>
							</tr>
						 </table>
					</td>
				</tr>
			</table>';
			$mail[ 'body' ] .= '<table class="app-2col col-container" width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="col-2col col-alpha col-content" width="50%" align="center" valign="top" style="padding-top: 15px;padding-right: 15px;padding-bottom: 15px;padding-left: 15px;">
						 <table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td>
									<span class="label" style="font-weight: bold;">Start Date:</span>
									<p class="value" style="margin-top: 0px;margin-right: 0px;margin-left: 0px;margin-bottom: 9px;padding-top: 10px;font-size: 14px;line-height: 1.28571429em;color: #777775 !important;">' . $data[ "refDateStart" . $i ] . '</p>
								</td>
							</tr>
						 </table>
					</td>
					<td class="col-2col col-alpha col-content" width="50%" align="center" valign="top" style="padding-top: 15px;padding-right: 15px;padding-bottom: 15px;padding-left: 15px;">
						 <table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td>
									<span class="label" style="font-weight: bold;">End Date:</span>
									<p class="value" style="margin-top: 0px;margin-right: 0px;margin-left: 0px;margin-bottom: 9px;padding-top: 10px;font-size: 14px;line-height: 1.28571429em;color: #777775 !important;">' . $data[ "refDateEnd" . $i ] . '</p>
								</td>
							</tr>
						 </table>
					</td>
				</tr>
			</table>';
			$mail[ 'body' ] .= '<table class="app-2col col-container" width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="col-2col col-alpha col-content" width="50%" align="center" valign="top" style="padding-top: 15px;padding-right: 15px;padding-bottom: 15px;padding-left: 15px;">
						 <table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td>
									<span class="label" style="font-weight: bold;">Starting Wage:</span>
									<p class="value" style="margin-top: 0px;margin-right: 0px;margin-left: 0px;margin-bottom: 9px;padding-top: 10px;font-size: 14px;line-height: 1.28571429em;color: #777775 !important;">' . $data[ "refWageStart" . $i ] . '</p>
								</td>
							</tr>
						 </table>
					</td>
					<td class="col-2col col-alpha col-content" width="50%" align="center" valign="top" style="padding-top: 15px;padding-right: 15px;padding-bottom: 15px;padding-left: 15px;">
						 <table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td>
									<span class="label" style="font-weight: bold;">Ending Wage:</span>
									<p class="value" style="margin-top: 0px;margin-right: 0px;margin-left: 0px;margin-bottom: 9px;padding-top: 10px;font-size: 14px;line-height: 1.28571429em;color: #777775 !important;">' . $data[ "refWageEnd" . $i ] . '</p>
								</td>
							</tr>
						 </table>
					</td>
				</tr>
			</table>';
			$mail[ 'body' ] .= '<table class="col-container" width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="col-content" width="100%" align="center" valign="top" style="padding-top: 15px;padding-right: 15px;padding-bottom: 15px;padding-left: 15px;">
						 <table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td>
									<span class="label" style="font-weight: bold;">Title/Responsibilities</span>
									<p class="value" style="margin-top: 0px;margin-right: 0px;margin-left: 0px;margin-bottom: 9px;padding-top: 10px;font-size: 14px;line-height: 1.28571429em;color: #777775 !important;">' . $data[ "refTitle" . $i ] . '</p>
								</td>
							</tr>
						 </table>
					</td>
				</tr>
			</table>';
			$mail[ 'body' ] .= '<table class="col-container" width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="col-content" width="100%" align="center" valign="top" style="padding-top: 15px;padding-right: 15px;padding-bottom: 15px;padding-left: 15px;">
						 <table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td>
									<span class="label" style="font-weight: bold;">Reason for leaving</span>
									<p class="value" style="margin-top: 0px;margin-right: 0px;margin-left: 0px;margin-bottom: 9px;padding-top: 10px;font-size: 14px;line-height: 1.28571429em;color: #777775 !important;">' . $data[ "refReason" . $i ] . '</p>
								</td>
							</tr>
						 </table>
					</td>
				</tr>
			</table>';
			$mail[ 'body' ] .= '<table class="app-2col col-container" width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="col-2col col-alpha col-content" width="50%" align="center" valign="top" style="padding-top: 15px;padding-right: 15px;padding-bottom: 15px;padding-left: 15px;">
						 <table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td>
									<span class="label" style="font-weight: bold;">Direct Supervisor\'s Name:</span>
									<p class="value" style="margin-top: 0px;margin-right: 0px;margin-left: 0px;margin-bottom: 9px;padding-top: 10px;font-size: 14px;line-height: 1.28571429em;color: #777775 !important;">' . $data[ "refSupervisorName" . $i ] . '</p>
								</td>
							</tr>
						 </table>
					</td>
					<td class="col-2col col-alpha col-content" width="50%" align="center" valign="top" style="padding-top: 15px;padding-right: 15px;padding-bottom: 15px;padding-left: 15px;">
						 <table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td>
									<span class="label" style="font-weight: bold;">Direct Supervisor\'s Title:</span>
									<p class="value" style="margin-top: 0px;margin-right: 0px;margin-left: 0px;margin-bottom: 9px;padding-top: 10px;font-size: 14px;line-height: 1.28571429em;color: #777775 !important;">' . $data[ "refSupervisorTitle" . $i ] . '</p>
								</td>
							</tr>
						 </table>
					</td>
				</tr>
			</table>';
			$mail[ 'body' ] .= '<table class="col-container" width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="col-content" width="100%" align="center" valign="top" style="padding-top: 15px;padding-right: 15px;padding-bottom: 15px;padding-left: 15px;">
						 <table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td>
									<span class="label" style="font-weight: bold;">May we contact this reference?</span>
									<p class="value" style="margin-top: 0px;margin-right: 0px;margin-left: 0px;margin-bottom: 9px;padding-top: 10px;font-size: 14px;line-height: 1.28571429em;color: #777775 !important;">' . $refPermission . '</p>
								</td>
							</tr>
						 </table>
					</td>
				</tr>
			</table>';

			$i++;
			
			else:

				$i = 0; // end search if title is empty

				break;
			
			endif;

		endwhile;

	endif;

	$mail[ 'body' ] .= '</td></tr></table></div>'; // final closing tags to be used after all, if any, references

	$WPCF7_ContactForm->set_properties( array( 'mail' => $mail) );

}
add_action( "wpcf7_before_send_mail", "wpcf7_add_references" );

?>