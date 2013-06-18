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

$user_id = get_current_user_id();
$user_info = get_userdata($user_id);

global $wpdb;

$query = "select * from wp_userchart where user_id = '$user_id'";
$name = $wpdb->get_row($query);
if(strcmp($name->first_name,"") == 0 && strcmp($name->ssn, "") == 0){?>
<script type="text/javascript"> 
        alert("Please proceed to updating your personal information");
        window.location.href = "personalInfo.php?action=edit&nav=disabled";
     </script>
<?php }
  
$user_title = (strcmp($user_info-> rpr_type_of_account, "Patient") != 0) ? $user_info-> rpr_type_of_account : $name-> first_name;
$lastname = (strcmp($user_info-> last_name, "") == 0) ? $name->last_name : $user_info-> last_name;
$title = __(' Welcome, ' . $user_title . ' ' . $lastname . '!');
$parent_file = 'index.php';

include (ABSPATH . 'wp-admin/admin-header.php');

$today = current_time('mysql', 1);
?>
<div class="wrap">
<?php include (ABSPATH . 'wp-admin/menuBar.php'); ?>
<h2><?php echo esc_html( $title ); ?></h2>
<?php 
if(strcmp($user_info-> rpr_type_of_account, "Manager") == 0) {
    include (ABSPATH . 'wp-admin/ownedProjects.php');
}
include (ABSPATH . 'wp-admin/currentProjects.php');
?>

</div><!-- dashboard-widgets-wrap -->
</div><!-- wrap -->
<?php require(ABSPATH . 'wp-admin/admin-footer.php'); ?>