<?php
/*
Plugin Name: Sky Login Redirect
Plugin URI: http://www.skyminds.net/wordpress-plugins/sky-login-redirect/
Description: Redirects users to the page they were reading just before logging in.
Version: 1.4.1
Author: Matt
Author URI: http://www.skyminds.net/
License: GPLv2 or later
*/

function sky_login_redirect() {

	$redirect_to  = $_REQUEST['redirect_to'];
	$sky_referrer = $_SERVER['HTTP_REFERER'];

	if( sky_is_login_page() ){
		/*
		If the login page calls itself in $redirect_to, avoid the loop and redirect to the homepage.
		This would happen when using password recovery and registration links.
		 */
		if ( preg_match( "/wp-login.php/", $redirect_to ) ){
			$redirect_to = home_url('/');
			return $redirect_to;
		}
		/* 
		$redirect_to is empty i.e. the login page was called directly.
		*/
		elseif ( !isset( $redirect_to ) || empty( $redirect_to ) ){
			/*
			Redirect to the referring page.
			*/
			return wp_get_referer();
		}
		/* for every other page, redirect to whatever $redirect_to was set to. */
		else{
			return $redirect_to;
		}
	}
}

function sky_login_url( $login_url ) {

	/* define our login URL, using standard login URL */	
	$login_url = site_url('wp-login.php');
	
	/* if $redirect_to is already set, we're good, nothing to do. */
	if( preg_match("/redirect_to=/", $login_url) ) {
		return $login_url;
	}
	/* otherwise, let's add the requested page as argument. */
	else {
		$login_url = add_query_arg( 'redirect_to', urlencode( (is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ), $login_url );
		return $login_url;
	}
}

function sky_is_login_page() {
	return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}

add_filter('login_redirect', 'sky_login_redirect');
add_filter('login_url', 'sky_login_url', 10, 2);
?>
