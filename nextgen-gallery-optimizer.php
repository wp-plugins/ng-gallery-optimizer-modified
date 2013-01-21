<?php
/*
Plugin Name: Ng Gallery Optimizer Modified
Description: Ng gallery optimizer modified is a modified version of nexrgen gallery optimizer and has added support for all the 10 shortcodes for ng gallery .It also includes and automatically integrates the fantastic Fancybox lightbox script, so now you can have gorgeous galleries AND a speedy site!
Author: Kiran Antony
Version: 1.0

Author URI: http://www.kiranantony.com

Copyright 2013 Kiran Antony | mail@kiranantony.com

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/
/*
Based off DevPress's Responsive Slider and using WooThemes Flexslider. 
 http://wordpress.org/extend/plugins/nextgen-gallery-optimizer/
*/
/**************************************************
* global variables and constants
**************************************************/

global $nggom_options;
global $nggom_nextgen_options;

$nggom_options = get_option('ngg_optimizer_modified_settings');
$nggom_nextgen_options = get_option('ngg_options');

define( 'NGGOM_VERSION', '1.1.2' );
define( 'NGGOM_FANCYBOX_VERSION', '1.3.4' );
define( 'NGGOM_JQUERY_VERSION', '1.8.3' );



/**************************************************
* includes
**************************************************/

include('nextgen-optimizer-functions.php'); // plugin functionality
include('nextgen-optimizer-options.php'); // the plugin options page HTML, linked CSS and save functions
include('nextgen-optimizer-scripts-and-styles.php'); // script and stylesheet include functions



/**************************************************
* add options page
**************************************************/

// call our stylesheet
function nggom_load_styles() {
	wp_enqueue_style('ngg_optimizer_modified_styles', plugin_dir_url( __FILE__ ) . 'css/nextgen-optimizer-options.css');
}

// attach the above wp_enqueue_style so our stylesheet only loads on the options page we're building
function nggom_add_options_page() {
	$nggom_options_page = add_submenu_page( 'nextgen-gallery','Ng Gallery Optimizer Modified', 'Ngg Optimizer Modified', 'manage_options', 'nggom_options', 'ngg_optimizer_modified_options_page');
	add_action('admin_print_styles-' . $nggom_options_page, 'nggom_load_styles');
}

// create options page complete with attached css file and link in admin menu. 
add_action('admin_menu', 'nggom_add_options_page');



/**************************************************
* save settings
**************************************************/

// create our settings in the options table
function nggom_register_settings() {
	register_setting('ngg_optimizer_modified_settings_group', 'ngg_optimizer_modified_settings');
}
add_action('admin_init', 'nggom_register_settings');



/**************************************************
* add settings & donate links on plugins page
**************************************************/

function nggom_settings_link($links, $file) {
	if ($file == plugin_basename(__FILE__)) {
		$links[] = '<a href="'.admin_url('admin.php?page=nggom_options').'">Settings</a>';
	}
	return $links;
}
add_filter('plugin_row_meta', 'nggom_settings_link', 10, 2);



/**********************************************************************
* define default option settings on first activation
**********************************************************************/

function nggom_add_default_values() {
	
	global $nggom_options;
    	
    if (!is_array($nggom_options)) {  // set defaults for new users only
		
		$nggom_default_values = array(
				"theme" => "Default Styles",
				"css" => "",
				"fancybox" => "1",
				"do_redirect" => "yes",
				"show_message" => "yes"
				);
				
		update_option('ngg_optimizer_modified_settings', $nggom_default_values);
		
	}
}
register_activation_hook(__FILE__, 'nggom_add_default_values');



/********************************************************************************
* define extra default options after update from earlier versions
********************************************************************************/

function nggom_add_extra_default_options() {
	
	global $nggom_options;
	
	if (!isset($nggom_options['jquery'])) {
		$nggom_options['jquery'] = 'wordpress'; // insert field or update value in array
		update_option('ngg_optimizer_modified_settings', $nggom_options); // update option array
	}

	if (!isset($nggom_options['version'])) {
		$nggom_options['version'] = 'not_set'; // insert field or update value in array
		update_option('ngg_optimizer_modified_settings', $nggom_options); // update option array
	}

	if (!isset($nggom_options['original_nextgen_thumbEffect'])) {
		$nggom_options['original_nextgen_thumbEffect'] = 'none'; // insert field or update value in array
		update_option('ngg_optimizer_modified_settings', $nggom_options); // update option array
	}

	if (!isset($nggom_options['original_nextgen_thumbCode'])) {
		$nggom_options['original_nextgen_thumbCode'] = 'none'; // insert field or update value in array
		update_option('ngg_optimizer_modified_settings', $nggom_options); // update option array
	}

	if (!isset($nggom_options['auto_fancybox_install'])) {
		$nggom_options['auto_fancybox_install'] = 'uninstalled'; // insert field or update value in array
		update_option('ngg_optimizer_modified_settings', $nggom_options); // update option array
	}

}
add_action('admin_init', 'nggom_add_extra_default_options');



/**********************************************************************
* redirect users to settings page on first activation
**********************************************************************/

function nggom_redirect_to_settings() {

    global $nggom_options;
		
	if (isset($nggom_options['do_redirect']) && ($nggom_options['do_redirect'] == 'yes')) {
        	        	
        wp_redirect(admin_url('admin.php?page=nggom_options', __FILE__));
			
		// we only want to redirect to the settings page on first activation
		// so we'll update the value of "do_redirect" to "done"

		$nggom_options['do_redirect'] = 'done'; // amend value in array
		update_option('ngg_optimizer_modified_settings', $nggom_options); // update option array

	}		
}
add_action('admin_init', 'nggom_redirect_to_settings');



/**********************************************************************
* display thank you message on first activation
**********************************************************************/

function nggom_thanks_for_downloading() {
	
	if (isset($_GET['page']) && $_GET['page'] =='nggom_options') {
		
		global $nggom_options;

    	if (isset($nggom_options['show_message']) && ($nggom_options['show_message'] == 'yes')) {
        	        	
			echo '
			<div id="message" class="updated">
			<p>Thanks for downloading Ng Gallery Optimizer modified! Please disable Nextgen Gallery Optimizer if installed. Else it may cause problems </p>
			</div>
			';
			// we only want to show this message once on first activation
			// so we'll update the value of "show_message" to "done"

			$nggom_options['show_message'] = 'done'; // amend value in array
			update_option('ngg_optimizer_modified_settings', $nggom_options); // update option array
	
		}
	}		
}
add_action('admin_notices', 'nggom_thanks_for_downloading');



/********************************************************************************
* Fix for Fancybox on IE6 & IE8
* Microsoft.AlphaImageLoader CSS requires absolute file paths.
* We'll run a regex (on activation and update) to write in the correct urls.
********************************************************************************/

function nggom_fancybox_stylesheet_regex() {
	
	global $nggom_options;
	global $nggom_fancybox_css_path;
	
	if (is_admin()) {
	
		if (!isset($nggom_options['version']) ||
		isset($nggom_options['version']) && $nggom_options['version'] != NGGO_VERSION) {

			$nggom_fancybox_css_path = WP_PLUGIN_DIR."/ng-gallery-optimizer-modified/css/jquery.fancybox-1.3.4.css";
			$nggom_fancybox_img_path = plugins_url( 'fancybox/' , __FILE__);
			$nggom_data = file_get_contents($nggom_fancybox_css_path);

			// the regex
			$nggom_patterns = array();
			$nggom_patterns[0] = '/\(src=\'(.*?)fancybox\//';
			$nggom_patterns[1] = '/url\(\'(.*?)fancybox\//';
			$nggom_replacements = array();
			$nggom_replacements[0] = '(src=\'' . $nggom_fancybox_img_path; 
			$nggom_replacements[1] = 'url(\'' . $nggom_fancybox_img_path;
			$nggom_update_css = preg_replace($nggom_patterns, $nggom_replacements, $nggom_data);

			// update css
			if (is_writable($nggom_fancybox_css_path)) {

				if (!$handle = fopen($nggom_fancybox_css_path, 'w+')) {
				add_action( 'admin_notices', 'nggom_file_not_writable_error' );
				exit;
    			}

    			if (fwrite($handle, $nggom_update_css) === FALSE) {
    			add_action( 'admin_notices', 'nggom_file_not_writable_error' );
				exit;
				}

			// we only want to run this regex on first activation or after auto-update
			// so we'll insert a "version" option to check against
			
			$nggom_options['version'] = NGGOM_VERSION; // insert field or update value in array
			update_option('ngg_optimizer_modified_settings', $nggom_options); // update option array

			fclose($handle);


			} else {
	
				add_action( 'admin_notices', 'nggom_file_not_writable_error' );
			
			}
		}
	}
}
add_action('admin_init', 'nggom_fancybox_stylesheet_regex');


function nggom_file_not_writable_error() {
	
	global $pagenow;
	global $nggom_fancybox_css_path;
	
	// admin error message	
	
	if ($pagenow == 'plugins.php' || isset($_GET['page']) && $_GET['page'] =='nggom_options') {
		
		$nggom_css_not_writable_message = '<div class="error"><p>';
		$nggom_css_not_writable_message.= '<b>Ngg Optimizer Modified Error Notification:</b><br />';
		$nggom_css_not_writable_message.= 'Optimizer automatically customizes Fancybox\'s css to ensure the lightbox displays correctly across all browsers. However...<br /><br />';
		$nggom_css_not_writable_message.= '<b>The stylesheet is not writable!</b><br />';
		$nggom_css_not_writable_message.= 'Please change permissions to <b>766</b> on the following file:&nbsp;&nbsp;<b>' . $nggom_fancybox_css_path . '</b><br /><br />';
		$nggom_css_not_writable_message.= 'There are several ways to do this...<br />';
		$nggom_css_not_writable_message.= '1. Right-click the file in your FTP client and select "Properties" or "Get Info".<br />';
		$nggom_css_not_writable_message.= '2. If using shared-hosting, select the file in your web-based file manager and look for a "Change Permissions" link.<br />';
		$nggom_css_not_writable_message.= '3. If you have SSH access, simply enter <b><i>sudo chmod 766 ' . $nggom_fancybox_css_path . ' </i></b>in your terminal.<br />';
		$nggom_css_not_writable_message.= '4. If you uploaded Optimizer via FTP, it may help to delete & reinstall the plugin through your WordPress admin at ';
		$nggom_css_not_writable_message.= '<a href="' . get_admin_url('', 'plugin-install.php?tab=upload') . '">Plugins --> Add New --> Upload</a>.';
		$nggom_css_not_writable_message.= '</p></div>';
		
		echo $nggom_css_not_writable_message;
		
	}

}



/********************************************************************************
* automatic fancybox installation
* saves original values on Gallery --> Options --> Effects page
* updates ngg_options with **class="myfancybox" rel="%GALLERY_NAME%"**
* reverts to previous values on deactivation
********************************************************************************/

function nggom_fancybox_auto_install() {
	
	global $nggom_options;
	global $nggom_nextgen_options;
	
	if (is_admin()) {

		if (is_array($nggom_nextgen_options)) {

			// capture nextgen's original effects values
			// save the thumbEffect and thumbCode settings for later restoration

			if (isset($nggom_options['fancybox']) && ($nggom_options['fancybox'] == true)) {	
				if (!isset($nggom_options['original_nextgen_thumbEffect']) || ($nggom_options['original_nextgen_thumbEffect'] == 'none')) {
						
					$nggom_options['original_nextgen_thumbEffect'] = $nggom_nextgen_options['thumbEffect'];
					$nggom_options['original_nextgen_thumbCode'] = $nggom_nextgen_options['thumbCode'];
					update_option('ngg_optimizer_modified_settings', $nggom_options);
				
				}
			}


			// if the fancybox option is selected
			// install and update nextgen's effects settings
				
			if (isset($nggom_options['fancybox']) && ($nggom_options['fancybox'] == true)) {
				if (!isset($nggom_options['auto_fancybox_install']) || ($nggom_options['auto_fancybox_install'] != 'installed')) {
					
					// update nextgen for fancybox integration
					$nggom_nextgen_options['thumbEffect'] = 'custom';
					$nggom_nextgen_options['thumbCode'] = 'class=\"myfancybox\" rel=\"%GALLERY_NAME%\"';
					update_option('ngg_options', $nggom_nextgen_options);
				
					// set an option so we only run the install once
					$nggom_options['auto_fancybox_install'] = 'installed';
					update_option('ngg_optimizer_modified_settings', $nggom_options);
				
				}
			}


			// if the fancybox option is deselected, uninstall and return nextgen effects to previous values
			// only runs if fancybox's thumbcode is set in nextgen, and previous values are present in optimizer

			if (!isset($nggom_options['fancybox']) || ($nggom_options['fancybox'] == "")) {

				// prevents overwriting manually edited nextgen effects on upgrade		
				if (($nggom_nextgen_options['thumbEffect'] == 'custom') &&
				($nggom_nextgen_options['thumbCode'] == 'class=\"myfancybox\" rel=\"%GALLERY_NAME%\"')) {	
			
					if (isset($nggom_options['original_nextgen_thumbEffect']) &&
					($nggom_options['original_nextgen_thumbEffect'] != 'none') &&
					isset($nggom_options['original_nextgen_thumbCode']) &&
					($nggom_options['original_nextgen_thumbCode'] != 'none')) {

						// switch nextgen back to original values when fancybox is deselected
						$nggom_nextgen_options['thumbEffect'] = $nggom_options['original_nextgen_thumbEffect'];
						$nggom_nextgen_options['thumbCode'] = $nggom_options['original_nextgen_thumbCode'];
						update_option('ngg_options', $nggom_nextgen_options);
	
						// empty our settings so we can run again if fancybox is enabled
						$nggom_options['original_nextgen_thumbEffect'] = 'none';
						$nggom_options['original_nextgen_thumbCode'] = 'none';
						$nggom_options['auto_fancybox_install'] = 'uninstalled';
						update_option('ngg_optimizer_modified_settings', $nggom_options);
				
					}
				}
			}


			// if nextgen's effects settings are accidentally changed while optimizer is activated and fancybox checked
			// update fancybox integration and show notification message
				
			if (isset($nggom_options['fancybox']) && ($nggom_options['fancybox'] == true)) {	
				
				if (($nggom_nextgen_options['thumbEffect'] != 'custom') ||
				($nggom_nextgen_options['thumbCode'] != 'class=\"myfancybox\" rel=\"%GALLERY_NAME%\"')) {	
	
					$nggom_nextgen_options['thumbEffect'] = 'custom'; // insert field or update value in array
					$nggom_nextgen_options['thumbCode'] = 'class=\"myfancybox\" rel=\"%GALLERY_NAME%\"';
					update_option('ngg_options', $nggom_nextgen_options);
				
					add_action('admin_notices', 'nggom_please_uncheck_fancybox');
					
				}
			}

		}
		
		// check if nextgen has been deleted
		// empty our settings so we can run again if nextgen is re-installed

		if (!is_array($nggom_nextgen_options) &&
		isset($nggom_options['auto_fancybox_install']) &&
		$nggom_options['auto_fancybox_install'] == 'installed') {
				
			$nggom_options['original_nextgen_thumbEffect'] = 'none';
			$nggom_options['original_nextgen_thumbCode'] = 'none';
			$nggom_options['auto_fancybox_install'] = 'uninstalled';
			update_option('ngg_optimizer_modified_settings', $nggom_options);

		}
		
	}
}
add_action('admin_init', 'nggom_fancybox_auto_install');


function nggom_please_uncheck_fancybox() {
    	
	echo '
	<div id="message" class="updated">
	<p>
	To use a different gallery effect, please deactivate Fancybox on the 
	<a href="' . admin_url('admin.php?page=nggom_options', __FILE__) . '" target="_blank">
	NextGEN Optimizer settings page</a> and return to 
	<a href="' . admin_url( 'admin.php?page=nggallery-options#effects' , __FILE__) . '" target="_blank">
	Gallery --> Options --> Effects</a> to make your changes.
	</p>
	</div>
	';
	
}


function nggom_fancybox_auto_uninstall() {
	
	global $nggom_options;
	global $nggom_nextgen_options;
	
	if (is_admin()) {

		if (is_array($nggom_nextgen_options)) {
	
			if (isset($nggom_options['fancybox']) && ($nggom_options['fancybox'] == true)) {
			
				if (isset($nggom_options['original_nextgen_thumbEffect']) && isset($nggom_options['original_nextgen_thumbCode'])) {
	
					// switch nextgen back to original values on deactivation
					$nggom_nextgen_options['thumbEffect'] = $nggom_options['original_nextgen_thumbEffect'];
					$nggom_nextgen_options['thumbCode'] = $nggom_options['original_nextgen_thumbCode'];
					update_option('ngg_options', $nggom_nextgen_options);
							
				}
			}
		
			// empty our settings so we can run again on reactivation
			$nggom_options['original_nextgen_thumbEffect'] = 'none';
			$nggom_options['original_nextgen_thumbCode'] = 'none';
			$nggom_options['auto_fancybox_install'] = 'uninstalled';
			update_option('ngg_optimizer_modified_settings', $nggom_options); // update option array

		}
	}
}
register_deactivation_hook(__FILE__, 'nggom_fancybox_auto_uninstall');



/********************************************************************************
* Check to make sure jQuery isn't deregistered.
* We'll run a regex on the functions.php files for "wp_deregister_script('jquery');"
* If detected (and not re-registered with a CDN version), we'll alert the user via an admin message.
********************************************************************************/

function nggom_check_for_deregister_jquery_regex() {

	global $nggom_child_functions_path;
	global $nggom_parent_functions_path;
	global $pagenow;
	
	if ($pagenow == 'plugins.php' || isset($_GET['page']) && $_GET['page'] =='nggom_options') {
	
		$nggom_child_functions_path = get_stylesheet_directory() . '/functions.php'; // looks for a child theme first, and if not in use, returns path to parent theme.		
		$nggom_parent_functions_path = get_template_directory() . '/functions.php'; // gets file path to parent theme
		
		$nggom_functions_pattern = '/wp\_(deregister|register|enqueue)\_script\s*\(\s*(\'|"|\s*)jquery(\'|"|\s*)/';

		
		// check the child theme's functions.php (if in use and if file exists)
		// if no child theme is in use, checks the parent theme's functions.php instead
		
		if (file_exists($nggom_child_functions_path)) {
			$nggom_functions_file = file_get_contents($nggom_child_functions_path);
		
			if (preg_match_all($nggom_functions_pattern, $nggom_functions_file, $nggom_functions_matches)
			&& array_key_exists(1, $nggom_functions_matches)
			&& !in_array('register', $nggom_functions_matches[1])
			&& !in_array('enqueue', $nggom_functions_matches[1])) {
				
				add_action( 'admin_notices', 'nggom_check_for_deregister_jquery_child_message' );
	
			}
		}
		
		// check the parent theme's functions.php
		// only runs if get_stylesheet_directory() did not return the parent theme's path above
		
		if (file_exists($nggom_parent_functions_path) && ($nggom_parent_functions_path != $nggom_child_functions_path)) {
			$nggom_functions_file = file_get_contents($nggom_parent_functions_path);
							
			if (preg_match_all($nggom_functions_pattern, $nggom_functions_file, $nggom_functions_matches)
			&& array_key_exists(1, $nggom_functions_matches)
			&& !in_array('register', $nggom_functions_matches[1])
			&& !in_array('enqueue', $nggom_functions_matches[1])) {
				
				add_action( 'admin_notices', 'nggom_check_for_deregister_jquery_parent_message' );
	
			}
		}
	}
}
add_action('admin_init', 'nggom_check_for_deregister_jquery_regex');


function nggom_check_for_deregister_jquery_child_message() {
	
	global $nggom_child_functions_path;
	global $pagenow;
	
	if ($pagenow == 'plugins.php' || isset($_GET['page']) && $_GET['page'] =='nggom_options') {
		
		echo '<div class="error"><p>ngg Optimizer modified:<br />Your theme appears to be deregistering jQuery, which may prevent the Fancybox lightbox from functioning.<br />To resolve this issue, please remove <b>wp_deregister_script(\'jquery\');</b> from <i>' . $nggom_child_functions_path . '</i>.</p></div>';

	}
}


function nggom_check_for_deregister_jquery_parent_message() {
	
	global $nggom_parent_functions_path;
	global $pagenow;
	
	if ($pagenow == 'plugins.php' || isset($_GET['page']) && $_GET['page'] =='nggom_options') {
		
		echo '<div class="error"><p>ngg Optimizer modified:<br />Your theme appears to be deregistering jQuery, which may prevent the Fancybox lightbox from functioning.<br />To resolve this issue, please remove <b>wp_deregister_script(\'jquery\');</b> from <i>' . $nggom_parent_functions_path . '</i>.</p></div>';

	}
}



/********************************************************************************
* Check to make sure NextGEN Gallery is installed and activated.
* If not, show an admin notification to assist with the installation/activation process.
********************************************************************************/

function nggom_nextgen_installed_and_activated_check() {

	global $pagenow;

	if ($pagenow == 'plugins.php' || isset($_GET['page']) && $_GET['page'] =='nggom_options') {
        
		// check if nextgen gallery is installed
		
		if (!get_plugins('/nextgen-gallery')) {

			$nggom_nextgen_check = '<div class="error"><p>';
			$nggom_nextgen_check.= '<b>Ngg Optimizer Modified Error Notification:</b><br />';
			$nggom_nextgen_check.= 'Optimizer is an add-on for the NextGEN Gallery WordPress plugin, but it appears...<b>NextGEN Gallery is not <i>installed</i>.</b><br />';
			$nggom_nextgen_check.= 'Please <a href="' . get_admin_url('', 'plugin-install.php?tab=search&s=NextGEN+Gallery') . '">download it here automatically</a> ';
			$nggom_nextgen_check.= 'or <a href="http://wordpress.org/extend/plugins/nextgen-gallery">manually from the WordPress repository</a>.';
			$nggom_nextgen_check.= '</p></div>';
			
			echo $nggom_nextgen_check;

		}

		// check if nextgen gallery is installed and activated
		
		if (get_plugins('/nextgen-gallery') && !is_plugin_active('nextgen-gallery/nggallery.php')) { // since WP 2.5

			$nggom_nextgen_check = '<div class="error"><p>';
			$nggom_nextgen_check.= '<b>ngg Optimizer modified modified Error Notification:</b><br />';
			$nggom_nextgen_check.= 'Optimizer is an add-on for the NextGEN Gallery WordPress plugin, but it appears...<b>NextGEN Gallery is not <i>activated</i>.</b><br />';
			$nggom_nextgen_check.= 'Please click the "Activate" link under the "NextGEN Gallery" item on <a href="' . get_admin_url('', 'plugins.php') . '">your plugins page</a>.';
			$nggom_nextgen_check.= '</p></div>';
			
			echo $nggom_nextgen_check;

		}

	}		
}
add_action('admin_notices', 'nggom_nextgen_installed_and_activated_check');