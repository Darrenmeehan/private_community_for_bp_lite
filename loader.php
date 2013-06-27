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
Author URI: http://www.wordpress.com
*/

function private_community_for_bp_lite_init() {
	require( dirname( __FILE__ ) . '/private-community-for-bp-lite.php' );
}
add_action( 'bp_include', 'private_community_for_bp_lite_init' );
?>