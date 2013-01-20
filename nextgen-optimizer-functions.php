<?php

/**********************************************************************
* remove nextgen gallery scripts [works on nextgen 1.6.2 and above]
**********************************************************************/

function nggom_remove_nextgen_js() {
	if (!is_admin()) {
		if (!defined('NGG_SKIP_LOAD_SCRIPTS')) {
			define('NGG_SKIP_LOAD_SCRIPTS', true);
		}
	}
}
add_action('init', 'nggom_remove_nextgen_js');



/**********************************************************************
* remove nextgen gallery styles
**********************************************************************/

function nggom_remove_nextgen_css() {
	if (!is_admin()) {
		wp_deregister_style('NextGEN');
		wp_deregister_style('shutter');
		wp_deregister_style('thickbox');
	}
}
add_action('wp_print_styles', 'nggom_remove_nextgen_css', 100);


function nggom_load_nggallery_effects(){
	global $post;
    global $nggom_options;
	global $nggom_nextgen_options;
	if (isset($nggom_options['fancybox']) && ($nggom_options['fancybox'] == true)) {
		
						// see scripts-and-styles.php for functions
						add_action('wp_enqueue_scripts', 'nggom_load_jquery', 1000);
						add_action('wp_enqueue_scripts', 'nggom_load_fancybox_scripts', 1000);
						add_action('wp_print_styles', 'nggom_load_fancybox_styles', 1000);
						add_action('wp_head','nggom_fancybox_inline_js', 1000);
	
					}
					
					if (isset($nggom_nextgen_options['thumbEffect']) && ($nggom_nextgen_options['thumbEffect'] == 'shutter')) {
					
						// see scripts-and-styles.php for functions
						add_action('wp_enqueue_scripts', 'nggom_load_shutter_scripts', 1000);
						add_action('wp_print_styles', 'nggom_load_shutter_styles', 1000);
						add_action('wp_head','nggom_shutter_inline_js', 1000);
						
					}

					if (isset($nggom_nextgen_options['thumbEffect']) && ($nggom_nextgen_options['thumbEffect'] == 'thickbox')) {
					
						if (isset($nggom_options['jquery']) && ($nggom_options['jquery'] == 'google')) {
							add_action('wp_head','nggo_jquery_no_conflict_inline_js', 1000);
						}
						
						// see scripts-and-styles.php for functions
						add_action('wp_enqueue_scripts', 'nggom_load_jquery', 1000);
						add_action('wp_enqueue_scripts', 'nggom_load_thickbox_scripts', 1000);
						add_action('wp_print_styles', 'nggom_load_thickbox_styles', 1000);
						
					}
}
	

/**********************************************************************
* check if post contains the [nggallery id=x] shortcode
* if so, load the appropriate scripts and styles
**********************************************************************/
function nggom_check_nggallery_shortcode() {

    global $post;
    global $nggom_options;
	global $nggom_nextgen_options;

 	if (!is_admin()) {
		
		if (have_posts()) {
			while (have_posts()) { 
				the_post();

    			$pattern = get_shortcode_regex();

    			if (preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches )
    			&& array_key_exists( 2, $matches )
    			&& in_array( 'nggallery', $matches[2] ) ) {
					nggom_load_nggallery_effects();
					add_action('wp_print_styles', 'nggom_load_nextgen_styles', 1000); // see scripts-and-styles.php for function

				}
			}
		}
	}
}
add_action( 'wp', 'nggom_check_nggallery_shortcode' );

/**********************************************************************
* This is where the free version of nggallery optimizer and the ng gallery optimizer modified differs
* This avoid you from any kind of notifcation that caused by unsupported codes
* This inclueds the support for other shortcodes in nextgenration gallery
**********************************************************************/

function nggom_check_extra_shortcodes() {

      global $post;
    global $nggom_options;
	global $nggom_nextgen_options;

 	if (!is_admin()) {
 		if (is_single() || is_page()) {
 			if (current_user_can( 'activate_plugins' )) { // since WP 2.0

				if (have_posts()) {
					while (have_posts()) { 
						the_post();
		
						$pattern = get_shortcode_regex();
		
						if (preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches )
						&& array_key_exists( 2, $matches )) {
		
							if (in_array( 'slideshow', $matches[2])) {
							//new code by nggo
								add_action('wp_print_styles', 'nggom_load_nextgen_styles', 1000);
								add_action('wp_enqueue_scripts', 'nggom_load_jquery', 1000);
								add_action('wp_enqueue_scripts', 'nggom_load_wp_cycle_scripts', 1000);
								add_action('wp_enqueue_scripts', 'nggom_load_nggslideshow_scripts', 1000);
							}
		
							if (in_array( 'album', $matches[2]) && !in_array( 'nggallery', $matches[2])) {
							//new code by nggo
								add_action('wp_print_styles', 'nggom_load_nextgen_styles', 1000);
								if(isset($_GET['gallery']) && $_GET['gallery']!=NULL)
								{
									nggom_load_nggallery_effects();
								}
							}
		
							if (in_array( 'thumb', $matches[2]) && !in_array( 'nggallery', $matches[2])) {
							//new code by nggo
								add_action('wp_print_styles', 'nggom_load_nextgen_styles', 1000);
								nggom_load_nggallery_effects();
							}
		
							if (in_array( 'singlepic', $matches[2]) && !in_array( 'nggallery', $matches[2])) {
								
							//new code by nggo
								add_action('wp_print_styles', 'nggom_load_nextgen_styles', 1000);
								nggom_load_nggallery_effects();
								add_action('wp_print_styles', 'nggom_load_nextgen_styles', 1000);
							}
		
							if (in_array( 'imagebrowser', $matches[2]) && !in_array( 'nggallery', $matches[2])) {
							//new code by nggo
								add_action('wp_print_styles', 'nggom_load_nextgen_styles', 1000);
								nggom_load_nggallery_effects();
							}
		
							if (in_array( 'nggtags', $matches[2]) && !in_array( 'nggallery', $matches[2])) {
								
								if(isset($matches[0])) {
									foreach($matches[0] as $match) {
								
										if (strpos($match,'nggtags album') !== false) {
										//new code by nggo
											add_action('wp_print_styles', 'nggom_load_nextgen_styles', 1000);
											if(isset($_GET['gallerytag']) && $_GET['gallerytag']!=NULL)
											{
												nggom_load_nggallery_effects();
											}
										}
										if (strpos($match,'nggtags gallery') !== false) {
											//new code by nggo
											add_action('wp_print_styles', 'nggom_load_nextgen_styles', 1000);
											nggom_load_nggallery_effects();
										}
		
									}
								}
							}
		
							if (in_array( 'random', $matches[2]) && !in_array( 'nggallery', $matches[2])) {	
							//new code by nggo
											add_action('wp_print_styles', 'nggom_load_nextgen_styles', 1000);
											nggom_load_nggallery_effects();
							}
		
							if (in_array( 'recent', $matches[2]) && !in_array( 'nggallery', $matches[2])) {
							//new code by nggo
											add_action('wp_print_styles', 'nggom_load_nextgen_styles', 1000);
											nggom_load_nggallery_effects();

							}
		
							if (in_array( 'tagcloud', $matches[2]) && !in_array( 'nggallery', $matches[2])) {
							//new code by nggo
											add_action('wp_print_styles', 'nggom_load_nextgen_styles', 1000);
											if(isset($_GET['gallerytag']) && $_GET['gallerytag']!=NULL)
											{
												nggom_load_nggallery_effects();
											}
							}
		
							if (isset($_GET['show']) && $_GET['show'] == 'slide') {
							//new code by nggo
							//add_action('wp_print_styles', 'nggom_load_nextgen_styles', 1000);
								add_action('wp_enqueue_scripts', 'nggom_load_jquery', 1000);
								add_action('wp_enqueue_scripts', 'nggom_load_wp_cycle_scripts', 1000);
								add_action('wp_enqueue_scripts', 'nggom_load_nggslideshow_scripts', 1000);
							}
					
						}
					}
				}			
			}
		}
	}
}
add_action( 'wp', 'nggom_check_extra_shortcodes' );
