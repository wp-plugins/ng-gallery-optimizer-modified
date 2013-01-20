<?php

/**********************************************************************
* fancybox inline js
**********************************************************************/

function nggom_fancybox_inline_js() { ?>
<!-- [nextgen gallery optimizer v<?php echo NGGOM_VERSION; ?>] This page must contain a nextgen shortcode...else we wouldn't be serving its scripts and styles -->
<script type='text/javascript'>jQuery.noConflict(); jQuery(document).ready(function() { jQuery('a.myfancybox').fancybox({ 'zoomSpeedIn':500, 'zoomSpeedOut':500, 'overlayShow':true, 'overlayOpacity':0.3 }); });</script>
<?php
}



/**********************************************************************
* load fancybox scripts
**********************************************************************/

function nggom_load_fancybox_scripts() {
	
		wp_deregister_script('fancybox');
		wp_deregister_script('jquery.fancybox');
		wp_deregister_script('jquery-fancybox');
		wp_register_script('jquery.fancybox', plugins_url('fancybox/jquery.fancybox-'.NGGOM_FANCYBOX_VERSION.'.pack.js', __FILE__), array('jquery'), NGGOM_FANCYBOX_VERSION);
		wp_enqueue_script('jquery.fancybox');
	
}



/**********************************************************************
* load fancybox styles
**********************************************************************/

function nggom_load_fancybox_styles() {
	
		wp_register_style('nggo_fancybox.css', plugins_url('css/jquery.fancybox-'.NGGOM_FANCYBOX_VERSION.'.css', __FILE__), false, NGGOM_FANCYBOX_VERSION, 'screen');
		wp_enqueue_style('nggo_fancybox.css');

}



/**********************************************************************
* load jquery...native or google-hosted (as selected on optimizer's settings page)
**********************************************************************/

function nggom_load_jquery() {
	global $nggom_options;

	if (isset($nggom_options['jquery']) && ($nggom_options['jquery'] == 'wordpress')) {
		wp_enqueue_script('jquery');
	}

	if (isset($nggom_options['jquery']) && ($nggom_options['jquery'] == 'google')) {
		wp_deregister_script('jquery');
		wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/'.NGGOM_JQUERY_VERSION.'/jquery.min.js', false, NGGOM_JQUERY_VERSION);
		wp_enqueue_script('jquery');
	}

}



/**********************************************************************
* jquery no conflict inline js
**********************************************************************/

function nggom_jquery_no_conflict_inline_js() {
global $nggom_options;

if (isset($nggom_options['jquery']) && ($nggom_options['jquery'] == 'google')) { ?>
<script type='text/javascript'>jQuery.noConflict();</script>
<?php
}
}



/**********************************************************************
* load nextgen gallery's styles (as selected on optimizer's settings page)
**********************************************************************/

function nggom_load_nextgen_styles() {
	
	global $nggom_options;
	$nggom_theme = $nggom_options['theme'];
	$nggom_nextgen_options = get_option('ngg_options');
	
	if($nggom_theme == "") { }
	if($nggom_theme == "Black Minimalism Theme") { define( 'NGGOM_NEXTGEN_CSS', 'Black_Minimalism.css' ); }
	if($nggom_theme == "Default Styles") { define( 'NGGOM_NEXTGEN_CSS', 'nggallery.css' ); }
	if($nggom_theme == "Dkret3 Theme") { define( 'NGGOM_NEXTGEN_CSS', 'ngg_dkret3.css' ); }
	if($nggom_theme == "Hovereffect Styles") { define( 'NGGOM_NEXTGEN_CSS', 'hovereffect.css' ); }
	if($nggom_theme == "K2 Theme") { define( 'NGGOM_NEXTGEN_CSS', 'ngg_k2.css' ); }
	if($nggom_theme == "Shadow Effect") { define( 'NGGOM_NEXTGEN_CSS', 'ngg_shadow.css' ); }
	if($nggom_theme == "Shadow Effect with Description Text") { define( 'NGGOM_NEXTGEN_CSS', 'ngg_shadow2.css' ); }


	if($nggom_options['css'] != "") {
		wp_register_style('custom.css', content_url($nggom_options['css'], dirname(__FILE__)), false, null, 'screen');
		wp_enqueue_style('custom.css');
	
	} else {

		if ($nggom_options['theme'] != "") {
			wp_register_style('nextgen.css', plugins_url( 'nextgen-gallery/css/'.NGGOM_NEXTGEN_CSS.'' , dirname(__FILE__)), false, null, 'screen');
			wp_enqueue_style('nextgen.css');
		}
	
	}

}



/**********************************************************************
* shutter inline js
**********************************************************************/

function nggom_shutter_inline_js() { ?>
<script type='text/javascript'>
/* <![CDATA[ */
var shutterSettings = {"msgLoading":"L O A D I N G","msgClose":"Click to Close","imageCount":"1"};
/* ]]> */
</script>
<?php
}



/**********************************************************************
* load shutter scripts
**********************************************************************/

function nggom_load_shutter_scripts() {

	wp_register_script('ngg.shutter-reloaded.js', plugins_url( 'nextgen-gallery/shutter/shutter-reloaded.js', dirname(__FILE__)), false, null);
	wp_enqueue_script('ngg.shutter-reloaded.js');

	}



/**********************************************************************
* load shutter styles
**********************************************************************/

function nggom_load_shutter_styles() {
		
		wp_register_style('shutter.css', plugins_url( 'nextgen-gallery/shutter/shutter-reloaded.css' , dirname(__FILE__)), false, null, 'screen');
		wp_enqueue_style('shutter.css');

}



/**********************************************************************
* load thickbox scripts
**********************************************************************/

function nggom_load_thickbox_scripts() { 
			wp_enqueue_script('thickbox');
}



/**********************************************************************
* load thickbox styles
**********************************************************************/

function nggom_load_thickbox_styles() {
			wp_register_style('thickbox', includes_url( '/js/thickbox/thickbox.css' , dirname(__FILE__)), false, null, 'screen');
			wp_enqueue_style( 'thickbox');
}
function nggom_load_wp_cycle_scripts()
{
	wp_register_script('ngg.wp-cycle.js', plugins_url( 'nextgen-gallery/js/jquery.cycle.all.min.js', dirname(__FILE__)), false, null);
	wp_enqueue_script('ngg.wp-cycle.js');
}
function nggom_load_nggslideshow_scripts()
{
	wp_register_script('ngg.slideshow.min.js', plugins_url( 'nextgen-gallery/js/ngg.slideshow.min.js', dirname(__FILE__)), false, null);
	wp_enqueue_script('ngg.slideshow.min.js');
}
