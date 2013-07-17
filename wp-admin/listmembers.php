<?php
/**
 * Dashboard Administration Screen
 *
 * @internal This file should be parseable by PHP4.
 *
 * @package WordPress
 * @subpackage Administration
 */

/** Load WordPress Bootstrap */
require_once('./admin.php');
/** Load WordPress dashboard API */
session_start();
add_thickbox();

$user_id = get_current_user_id(); //user id
$user_info = get_userdata($user_id); //all info inside wp_usermeta table



global $wpdb;

/*************** checks if the user is a admin *****************************/
$query = "select * from wp_users where ID = '$user_id'";
$uinfo = $wpdb->get_row($query);

// if not a admin sends back to main site.
if(strcmp($uinfo-> site_role, "Admin") != 0 || $uinfo-> locked == 1) { 
echo '<script type="text/javascript">
<!--
window.location = "http://www.ehisys.org/"
//-->
</script>';
    die();
} 


$title = __('Manage Users');
$parent_file = 'index.php';

include (ABSPATH . 'wp-admin/admin-header.php');

$today = current_time('mysql', 1);

include (ABSPATH . 'wp-admin/menuBar.php'); 


?>
<head>
<div class="wrap">
<div>


<!-- add stuff here -->

</div><!-- dashboard-widgets-wrap -->
</div><!-- wrap -->
<?php  require(ABSPATH . 'wp-admin/admin-footer.php'); ?>