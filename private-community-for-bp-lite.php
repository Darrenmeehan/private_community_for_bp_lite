<?php
// Begin plugin function
function bphelp_private_community(){
 global $bp_unfiltered_uri;
 
 
 // Unblocked public pages. 
 $bphelp_my_unblocked_page_1  = get_option( 'bphelp-setting-one'   ); 
 $bphelp_my_unblocked_page_2  = get_option( 'bphelp-setting-two'   );  
  
  
 //IMPORTANT: Do not alter the following line. 
 $bphelp_if_I_changed_my_register_slug = 'register';
 
 
 
 
 // DO NOT ALTER THE CODE BELOW THIS LINE UNLESS YOU KNOW WHAT YOU ARE DOING 
 if ( !is_user_logged_in() && !bp_is_register_page() && !bp_is_activation_page() 
	&& ( $bp_unfiltered_uri[0] != $bphelp_my_unblocked_page_1 ) 
	&& ( $bp_unfiltered_uri[0] != $bphelp_my_unblocked_page_2 ) )
	
  // Prevent logged out users from accessing bp pages 
  bp_core_redirect( get_option('home') . '/' .  $bphelp_if_I_changed_my_register_slug );

}

add_action( 'wp', 'bphelp_private_community', 3 );
  //End Prevent logged out users from accessing bp pages 
  
  
  
  
/* Prevent RSS Feeds */
function cut_nonreg_visitor_rss_feed() {
	remove_action( 'bp_actions', 'bp_activity_action_sitewide_feed', 3 );
	remove_action( 'bp_actions', 'bp_activity_action_personal_feed', 3 );
	remove_action( 'bp_actions', 'bp_activity_action_friends_feed', 3 );
	remove_action( 'bp_actions', 'bp_activity_action_my_groups_feed', 3 );
	remove_action( 'bp_actions', 'bp_activity_action_mentions_feed', 3 );
	remove_action( 'bp_actions', 'bp_activity_action_favorites_feed', 3 );
	remove_action( 'groups_action_group_feed', 'groups_action_group_feed', 3 );
}
add_action('init', 'cut_nonreg_visitor_rss_feed'); 
/* End Prevent RSS Feeds */

/////////////////////////////// Dashboard Settings //////////////////////////////////
/*
 * bphelp_pcfbp_add_admin_menu()
 */
function bphelp_pcfbp_add_admin_menu() {
	global $bp;

	if ( !is_super_admin() )
		return false;

	add_options_page( __( 'PrivateCommunityBP', 'bphelp_pcfbp' ), __( 'PrivateCommunityBP', 'bphelp_pcfbp' ), 'manage_options', 'bphelp-pcfbp-settings', 'bphelp_pcfbp_admin' );
}

add_action( bp_core_admin_hook(), 'bphelp_pcfbp_add_admin_menu' );

/**
 * bp_bphelp_pcfbp_admin()
 *
 * Checks for form submission, saves component settings and outputs admin screen HTML.
 */
function bphelp_pcfbp_admin() {
	global $bp;

	/* If the form has been submitted and the admin referrer checks out, save the settings */
	if ( isset( $_POST['submit'] ) && check_admin_referer('bphelp-settings') ) {
		update_option( 'bphelp-setting-one'  , $_POST['bphelp-setting-one'] );
		update_option( 'bphelp-setting-two'  , $_POST['bphelp-setting-two'] );

		$updated = true;
	}

	$bphelp_my_unblocked_page_1  = get_option( 'bphelp-setting-one' );
	$bphelp_my_unblocked_page_2  = get_option( 'bphelp-setting-two' );
?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php _e( 'Private Community For BP Lite Settings', 'bphelp_pcfbp' ) ?></h2>
		<br />
		<p>
		<?php _e( 'Enter the slug of the pages you would like to unblock in the options below.<br /> <b>Example:</b> enter "activity" without quotes to unblock the activity page.<br /> <b>Limit for Lite version is 2 unblocked pages</b>', 'bphelp_pcfbp' ) ?>
		</p>
		<br />

		<?php if ( isset($updated) ) : ?><?php echo "<div id='message' class='updated fade'><p>" . __( 'Settings Updated.', 'bphelp_pcfbp' ) . "</p></div>" ?><?php endif; ?>

		<form action="<?php echo site_url() . '/wp-admin/admin.php?page=bphelp-pcfbp-settings' ?>" name="bphelp-settings-form" id="bphelp-settings-form" method="post">

			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="target_uri"><?php _e( '<b>Option One:</b>', 'bphelp_pcfbp' ) ?></label></th>
					<td>
						<input name="bphelp-setting-one" type="text" id="bphelp-setting-one" value="<?php echo esc_attr( $bphelp_my_unblocked_page_1 ); ?>" size="60" />
					</td>
				</tr>
					<th scope="row"><label for="target_uri"><?php _e( '<b>Option Two:</b>', 'bphelp_pcfbp' ) ?></label></th>
					<td>
						<input name="bphelp-setting-two" type="text" id="bphelp-setting-two" value="<?php echo esc_attr( $bphelp_my_unblocked_page_2 ); ?>" size="60" />
					</td>
				</tr>
			</table>
			<p class="submit">
				<input type="submit" name="submit" value="<?php _e( 'Save Settings', 'bphelp_pcfbp' ) ?>"/>
			</p>

			<?php
			/* Make sure this is filled in */
			wp_nonce_field( 'bphelp-settings' );
			?>
		</form>
	</div>
<?php
}
///Enjoy!
?>