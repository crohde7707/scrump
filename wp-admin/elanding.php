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
if(strcmp($uinfo-> site_role, "")==0) { 
    $qu = "UPDATE wp_users SET site_role='Developer' WHERE ID = '$user_id'";
    $wpdb->query($qu);
  //update wp_users with site role
}
/**************************************************************************/
  
$title = __(' Welcome, ' . $uinfo->user_login . '!');
$parent_file = 'index.php';

include (ABSPATH . 'wp-admin/admin-header.php');

$today = current_time('mysql', 1);

include (ABSPATH . 'wp-admin/menuBar.php'); 
?>


<div class="wrap">
<h2><?php echo esc_html( $title ); ?></h2>
<?php if($uinfo->locked) {?>
<h3>Your account is locked</h3>
<?php } else {
    if(strcmp($user_info-> rpr_type_of_account, "Manager") == 0) {
        include (ABSPATH . 'wp-admin/ownedProjects.php');
    }
    include (ABSPATH . 'wp-admin/extra.php');
?>


</div><!-- dashboard-widgets-wrap -->
</div><!-- wrap -->
<?php } require(ABSPATH . 'wp-admin/admin-footer.php'); ?>