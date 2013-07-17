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
$pid = $_GET['pid'];

$pQuery = "SELECT * from wp_proj where ID = '$pid'";
$proj = $wpdb->get_row($pQuery);

$rQuery = "SELECT role FROM wp_roles where proj_ID = '$pid' AND user_ID = '$user_id'";
$role = $wpdb->get_var($rQuery);

$query = "select * from wp_users where ID = '$user_id'";
$uinfo = $wpdb->get_row($query);
/**************************************************************************/
  
$title = __(' Dashboard for: ' . $proj->name );

$parent_file = 'landing.php';

include (ABSPATH . 'wp-admin/admin-header.php');

$today = current_time('mysql', 1);

include (ABSPATH . 'wp-admin/menuBar.php'); 
?>


<div class="wrap">
    <h2><?php echo esc_html( $title ); ?></h2>
    <?php if($uinfo->locked) {?>
    <h3>Your account is locked</h3>
    <?php } else { ?>
    <h3 style="margin:0">Role: <?php echo $role; ?>  <a href="listmembers.php?pid=<?php echo $proj->ID;?>">List of Members</a></h3>
    <div class="working">
        <?php
            include (ABSPATH . 'wp-admin/widget/icebox.php');
   
            //include backlog
   
            //include sprint
        ?>
    </div>
    <div class="completed">
        <?php
            //include completed
        ?>
    </div>
<?php } ?>


</div><!-- dashboard-widgets-wrap -->
</div><!-- wrap -->
<?php  require(ABSPATH . 'wp-admin/admin-footer.php'); ?>
