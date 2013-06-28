<?php 
/*
Plugin Name: Private Community For BP Lite
Plugin URI: http://www.wordpress.com
Description: Makes BP pages private and only accessable to logged in users with the exception
of the pages you set in Dashboard/Settings/PrivateCommunityBP. 
Blocks RSS feeds as well.
Version: 3.0
Requires at least: WordPress 3.2.1 / BuddyPress 1.5.1
Tested up to: WordPress 3.6 beta3 / BuddyPress 1.8 beta1
License: GNU/GPL 2
Author: @bphelp
Author URI: http://bphelpblog.wordpress.com/
*/

function private_community_for_bp_lite_init() {
	require( dirname( __FILE__ ) . '/private-community-for-bp-lite.php' );
}
add_action( 'bp_include', 'private_community_for_bp_lite_init' );

/*** Make sure BuddyPress is loaded ********************************/
if ( !function_exists( 'bp_core_install' ) ) {
	require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
	if ( is_plugin_active( 'buddypress/bp-loader.php' ) ) {
		require_once ( WP_PLUGIN_DIR . '/buddypress/bp-loader.php' );
	} else {
		add_action( 'admin_notices', 'private_community_for_bp_lite_install_buddypress_notice' );
		return;
	}
}


function private_community_for_bp_lite_install_buddypress_notice() {
	echo '<div id="message" class="error fade"><p style="line-height: 150%">';
	_e('<strong>Private Community For BP Lite</strong></a> requires the BuddyPress plugin to work. Please <a href="http://buddypress.org/download">install BuddyPress</a> first, or <a href="plugins.php">deactivate Private Community For BP Lite</a>.');
	echo '</p></div>';
}
?>