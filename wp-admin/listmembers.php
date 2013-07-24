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
$pid = $_GET['pid'];
/*************** checks if the user is a admin *****************************/
$user_id = get_current_user_id(); //user id
        
$query = "SELECT * FROM wp_roles WHERE user_ID = '$user_id' AND  proj_ID ='$pid'" ;
$uinfo = $wpdb->get_row($query);

// if not a admin sends back to main site.
if(strcmp($uinfo-> role, "Project Owner") != 0 ) { 
echo '<script type="text/javascript">
<!--
window.location = "http://www.ehisys.org/"
//-->
</script>';
    die();
} 
/**************************************************************************/

global $wpdb;
wp_enqueue_script('jquery-ui-autocomplete', '', array('jquery-ui-widget', 'jquery-ui-position'), '1.8.6');


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


$title = __('List of Members');
$parent_file = 'index.php';

include (ABSPATH . 'wp-admin/admin-header.php');

$today = current_time('mysql', 1);

include (ABSPATH . 'wp-admin/menuBar.php'); 


?>
<div class="wrap">
    <head>
    <script>
            jQuery(document).ready(function(){
        		$('#emailsearch').autocomplete({source:'search.php', minLength:1});
    		});
    
    </script>
    
        <h2><?php echo esc_html( $title ); ?></h2>
    </head>
    <div>
        <body>
            <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/vader/jquery-ui.css" type="text/css" rel="stylesheet" />
            <?php require ('listmembersform.php'); ?>
            <?php require('listprojectmembers.php'); ?>
        </body>
    <!-- add stuff here -->
    </div><!-- dashboard-widgets-wrap -->
</div><!-- wrap -->
<?php  require(ABSPATH . 'wp-admin/admin-footer.php'); ?>