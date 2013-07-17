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

/*************** Add query to update user role in database ****************/
$query = "select * from wp_users where ID = '$user_id'";
$uinfo = $wpdb->get_row($query);
/**************************************************************************/
  
if($uinfo->user_firstName) {
    $title = __(' Welcome, ' . $uinfo->user_firstName . ' ' . $uinfo->user_lastName . '!');
} else {
    $title = __(' Welcome, ' . $uinfo->user_login . '!');
}
$parent_file = 'index.php';

include (ABSPATH . 'wp-admin/admin-header.php');

$today = current_time('mysql', 1);

include (ABSPATH . 'wp-admin/menuBar.php'); 
?>


<div class="wrap">
<h2><?php echo esc_html( $title ); ?><?php if(strcmp($uinfo-> site_role, "Developer") != 0) {?> <input type="button" id="createProject" value="Create Project" /><?php } ?></h2>
<?php if($uinfo->locked) {?>
<h3>Your account is locked</h3>
<?php } else {
    if(strcmp($uinfo-> site_role, "Developer") != 0) {
        include (ABSPATH . 'wp-admin/ownedProjects.php');
    }
    include (ABSPATH . 'wp-admin/currentProjects.php');
?>


</div><!-- dashboard-widgets-wrap -->
</div><!-- wrap -->
<?php } require(ABSPATH . 'wp-admin/admin-footer.php'); ?>