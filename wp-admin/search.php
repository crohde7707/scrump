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





global $wpdb;


if ( !isset($_REQUEST['term']) )
    exit;
    
$search = $_REQUEST['term'];




$search = $search."%";
/*************** Add query to update user role in database ****************/
$query = "select * from wp_users where user_email like '$search'";
$uinfo = $wpdb->get_results($query);
/**************************************************************************/

$return_arr = array();

foreach ( $uinfo as $result ) 
{
    $return_arr[] = $result->user_email;
}


echo json_encode($return_arr);
?>