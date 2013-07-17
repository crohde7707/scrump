<?php

/** Load WordPress Bootstrap */
require_once('./admin.php');

$user_id = get_current_user_id();
$user_info = get_userdata($user_id);  
  
$title = __('Personal Information');
$parent_file = 'patientSearch.php';

include (ABSPATH . 'wp-admin/admin-header.php');

$today = current_time('mysql', 1);

$item = $_GET['update'];
include (ABSPATH . 'wp-admin/menuBar.php'); 

?>
<div class="wrap">
<?php


//Wordpress database hook
global $wpdb;

// Build SQL Query  
$query = "select * from wp_users where ID = '$user_id'";
$uinfo = $wpdb->get_row($query);
$numrows=count($query);

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';
$type = $user_info-> rpr_type_of_account;
switch($action) {

case 'view':
// begin to show results set
?>
  <h2>Personal Information <input style="font-size:13px; padding:4px;"type="button" onclick=window.location.href='personalInfo.php?action=edit' value="Edit Info" /><?php if($item) { ?> <span style="color:green">Personal Information updated successfully!</span><?php } ?></h2>
  <div id="personalInfo">
     <ul class="patientInfo">
            <li><span class="iLabel">First Name:</span> <?php echo $uinfo->user_firstName;?></li>
            <li><span class="iLabel">Last Name:</span> <?php echo $uinfo->user_lastName;?></li>
            <li><span class="iLabel">Phone:</span> <?php echo $uinfo->user_phone;?></li>
            <li><span class="iLabel">Email:</span> <?php echo $uinfo->user_email;?></li>
         </ul>
  </div>
<?php 
break;

case 'edit': 

?>
  <h2>Editing Personal Information</h2>
  <div id="personalInfo">
     <form action="updat.php" method="post" id="pInfo">
           <input type="hidden" name="uid" value="<?php echo "$user_id";?>" />
           <input type="hidden" name="section" value="pInfo">
           <ul class="patientInfo">
              <li>First Name: <input name="first" type="text" value="<?php echo $uinfo->user_firstName;?>" /></li>
              <li>Last Name: <input name="last" type="text" value="<?php echo $uinfo->user_lastName;?>" /></li>
              <li>Phone: <input name="phone" type="text" value="<?php echo $uinfo->user_phone;?>" /></li>
              <li>Email: <input name="email" type="text" value="<?php echo $uinfo->user_email;?>" /></li>
            </ul>
          <button type="submit" form="pInfo">Save Changes</button>
        </form>
    </div>
    <?php 
break;

default:
;
}
 ?>

</div><!-- wrap -->
<?php require(ABSPATH . 'wp-admin/admin-footer.php'); ?>