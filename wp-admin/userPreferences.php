<?php

/** Load WordPress Bootstrap */
require_once('./admin.php');

/** Load WordPress dashboard API */
require_once(ABSPATH . 'wp-admin/includes/dashboard.php');

wp_dashboard_setup();

wp_enqueue_script( 'dashboard' );
if ( current_user_can( 'edit_theme_options' ) )
	wp_enqueue_script( 'customize-loader' );
if ( current_user_can( 'install_plugins' ) )
	wp_enqueue_script( 'plugin-install' );
if ( current_user_can( 'upload_files' ) )
	wp_enqueue_script( 'media-upload' );
add_thickbox();

if ( wp_is_mobile() )
	wp_enqueue_script( 'jquery-touch-punch' );

  $user_id = get_current_user_id();
  $user_info = get_userdata($user_id);  
  
$title = __('Patient Chart');
$parent_file = 'landing.php';

include (ABSPATH . 'wp-admin/admin-header.php');

$today = current_time('mysql', 1);
$query = "select * from wp_userchart where user_id = '$user_id'";
$pref = $wpdb->get_row($query);

if(strcmp($_POST['action'], "update") == 0) {
   $contact = $_POST['contact'];
   $receipt = $_POST['receipt'];
   $uid = $_POST['uid'];
   $q = "UPDATE wp_userchart SET p_contact='$contact', p_receipt='$receipt' WHERE user_id = '$uid'";
   $wpdb->query($q);
}
?>

<div class="wrap">
<?php include (ABSPATH . 'wp-admin/menuBar.php'); ?>

<!------- Contact Form ------------>
<h2>Preferences</h2>
<form action="userPreferences.php" method="post" id="pInfo">
   <input type="hidden" name="uid" value="<?php echo "$user_id";?>" />
   <input type="hidden" name="action" value="update" />
   <label for="contact" ><?php _e('Contact:') ?>
      <input type="radio" name="contact" value="phone" <?php echo (($pref->p_contact == 'phone') ? "checked" : "");?> /> Phone  <input type="radio" name="contact" value="email" <?php echo (($pref->p_contact == 'email') ? "checked" : "");?> /> Email
   </label><br />
   <label for="receipt" ><?php _e('Receipt:') ?>
      <input type="radio" name="receipt" value="paper" <?php echo (($pref->p_receipt == 'paper') ? "checked" : "");?> /> Paper  <input type="radio" name="receipt" value="email" <?php echo (($pref->p_receipt == 'email') ? "checked" : "");?> /> Email
   </label><br />
   <button type="submit">Submit</button>
</form>

<!--------------------------------->


</div>

</div><!-- wrap -->
<?php require(ABSPATH . 'wp-admin/admin-footer.php'); ?>