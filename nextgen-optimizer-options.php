<?php

function ngg_optimizer_modified_options_page() {

global $nggom_options;

ob_start();

?>
	
<div class="wrap">
<h2>Ng Gallery Optimizer Modified</h2>
<div class="nggom_support_info_box">
<h3>Supported Shortcodes</h3>
<div style="float:left; margin: 10px 20px 5px 0; font-weight:bold;">		
				1. [nggallery id=x]<br />
				2. [slideshow id=x]<br />
				3. [album id=x]<br />
				4. [thumb id=x]<br />
				5. [singlepic id=x]<br />	
			</div>	
            <div style="float:left; margin: 10px 0 5px 0; font-weight:bold;">			
				6. [imagebrowser id=x]<br />
				7. [nggtags gallery|album=mytag]<br />	
				8. [random max=x]<br />
				9. [recent max=x]<br />
				10. [tagcloud]
			</div>
          </div>
     <div class="clear"></div>
	<div class="nggom_box">	
		<form id="nggom_submit_options" method="post" action="options.php">
		<?php settings_fields('ngg_optimizer_modified_settings_group'); ?>
			
		<div class="nggom_inner">
		<h2><?php _e('Step 1:', 'ngg_optimizer_modified_domain'); ?></h2>
			
			<div class="nggom_select_style">
				<b>Select your NextGEN stylesheet:</b>
				<p>
					<?php $styles = array('','Black Minimalism Theme', 'Default Styles', 'Dkret3 Theme', 'Hovereffect Styles', 'K2 Theme', 'Shadow Effect', 'Shadow Effect with Description Text'); ?>
					<select name="ngg_optimizer_modified_settings[theme]" id="ngg_optimizer_modified_settings[theme]">
						<?php foreach($styles as $style) { ?>
							<?php if ($nggom_options['theme'] == $style) { $selected = 'selected="selected"'; } else { $selected = ''; } ?>
							<option value="<?php echo $style; ?>" <?php echo $selected; ?>><?php echo $style; ?></option>
						<?php } ?>
					</select>
				</p>
			</div>
			
			<div class="nggom_custom_style">
				<b>Or enter the path to a custom file:</b>
				<p><?php echo content_url() ?>/ <input id="ngg_optimizer_modified_settings[css]" name="ngg_optimizer_modified_settings[css]" type="text" size="35" value="<?php echo $nggom_options['css']; ?>"/></p>
			</div>
			
		</div>
			
	<div class="clear"></div>
			
		<div class="nggom_inner">
			<h2><?php _e('Step 2:', 'nggom_domain'); ?></h2>
			<input id="ngg_optimizer_modified_settings[fancybox]" name="ngg_optimizer_modified_settings[fancybox]" type="checkbox" value="1" <?php checked(1, $nggom_options['fancybox']); ?> />
			&nbsp;&nbsp;<b>Use <a href="http://fancybox.net" target="_blank">Fancybox</a> lightbox effect?</b>
		</div>

		<div class="nggo_inner">
			<h2><?php _e('Step 3:', 'nggop_domain'); ?></h2>
			<label>
				<input id="ngg_optimizer_modified_settings[jquery]" name="ngg_optimizer_modified_settings[jquery]" type="radio" value="wordpress" <?php checked(wordpress, $nggom_options['jquery']); ?> />
				&nbsp;&nbsp;<b>Use WordPress jQuery [greater compatibility]</b>&nbsp;&nbsp;&nbsp;&nbsp;
			</label>
			<label>
				<input id="ngg_optimizer_modified_settings[jquery]" name="ngg_optimizer_modified_settings[jquery]" type="radio" value="google" <?php checked(google, $nggom_options['jquery']); ?> />
				&nbsp;&nbsp;<b>Use Google-hosted jQuery [faster page loads]</b>
			</label>
		</div>

		<h2><?php _e('Step 4:', 'ngg_optimizer_modified_domain'); ?></h2>
		<input type="submit" class="button-primary" value="<?php _e('Save Options', 'ngg_optimizer_modified_domain'); ?>" />&nbsp;&nbsp;<b>Save your changes and enjoy!</b>&nbsp;
		Your gallery scripts and styles will now only load on posts with the nextgen gallery shortcodes shortcode.

</div><!-- end .nggom_box -->		


	<div class="nggom_box">
		<h2><?php _e('Tips:', 'nggom_domain'); ?></h2>
		1. If Fancybox isn't working as it should, try deactivating other Fancybox/lightbox plugins which may be causing a conflict, 
		and try removing any duplicate Fancybox scripts hard-coded into your theme.<br /><br />
		
		2. Lightbox scripts such as Fancybox aren't generally compatible with minification/caching/combining plugins. 
		If you're using a plugin such as WP-Minify, be sure to list the already minified <b><?php echo plugins_url( 'fancybox/jquery.fancybox-'.NGGO_FANCYBOX_VERSION.'.pack.js' , __FILE__); ?></b>
		in its file exclusion options and clear the cache.
	</div>

	<!-- hidden fields for persistent settings in options array -->
	<input id="ngg_optimizer_modified_settings[version]" name="ngg_optimizer_modified_settings[version]" type="hidden" value="<?php echo $nggom_options['version']; ?>"/>
	<input id="ngg_optimizer_modified_settings[auto_fancybox_install]" name="ngg_optimizer_modified_settings[auto_fancybox_install]" type="hidden" value="<?php echo $nggom_options['auto_fancybox_install']; ?>"/>	
	<input id="ngg_optimizer_modified_settings[original_nextgen_thumbEffect]" name="ngg_optimizer_modified_settings[original_nextgen_thumbEffect]" type="hidden" value="<?php echo $nggom_options['original_nextgen_thumbEffect']; ?>"/>
	<input id="ngg_optimizer_modified_settings[original_nextgen_thumbCode]" name="ngg_optimizer_modified_settings[original_nextgen_thumbCode]" type="hidden" value="<?php echo htmlspecialchars($nggom_options['original_nextgen_thumbCode']); ?>"/>
	
</form>


	<div class="nggom_box">
		<h2>Support:</h2>
		Any questions or suggestions?<br />
		Please <a href='mailto:mail@kiranantony.com'>send me an email</a>
	</div>
		
</div><!-- end wrap -->



<?php
	echo ob_get_clean();
}