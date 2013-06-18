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
$parent_file = 'patientSearch.php';

$q = "SELECT * from wp_userchart where user_id = '$user_id'";
$usr = $wpdb->get_row($q);

if ( is_user_admin() )
	add_screen_option('layout_columns', array('max' => 4, 'default' => 1) );
else
	add_screen_option('layout_columns', array('max' => 4, 'default' => 1) );

// Not using chaining here, so as to be parseable by PHP4.
$screen = get_current_screen();


$screen->set_help_sidebar(
	'<p><strong>' . __( 'For more information:' ) . '</strong></p>' .
	'<p>' . __( '<a href="http://codex.wordpress.org/Dashboard_Screen" target="_blank">Documentation on Dashboard</a>' ) . '</p>' .
	'<p>' . __( '<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>' ) . '</p>'
);

include (ABSPATH . 'wp-admin/admin-header.php');

$today = current_time('mysql', 1);
?>

<div class="wrap">
<?php
$action = $_POST['action'];
if($action) { ?>
     <div class="successMsg">
        <h4>Message sent successfully</h4>
     </div>
  <?php }
include (ABSPATH . 'wp-admin/menuBar.php'); 

if(isset($_POST['name']) && isset($_POST['subject']) && isset($_POST['message'])) {
  $query = "SELECT email from wp_userchart where user_id = '$user_id'";
  $userEmail = $wpdb->get_var($query);

  $email = "info@ehisys.org";
  $to = $email;
  $from = $userEmail;
  $subject = "[EHISYS] Contact Form: " . $_POST['subject'];
  $message = $_POST['message'];
  $headers = "From: $from";
  mail($to,$subject,$message,$headers);
}
?>

<!------- Contact Form ------------>
<h2>Contact Us</h2>
<form action="contact.php" method="post" id="contact">
   <input type="hidden" name="action" value="sent" />
   <label for="name" ><?php _e('Name:') ?><br />
      <input type="text" name="name" id="name" class="input" size="35" value="<?php echo "$usr->first_name $usr->last_name";?>" disabled/>
   </label><br />
   <label for="subject" ><?php _e('Subject:') ?><br />
      <input type="text" name="subject" id="subject" class="input" size="35" />
   </label><br />
   <label for="message" ><?php _e('Message:') ?><br />
   <textarea name="message" id="message" class="input" rows="10" cols="75"></textarea
   </label><br />
   <button type="submit">Submit</button>
</form>

<!--------------------------------->


</div>

</div><!-- wrap -->
<?php require(ABSPATH . 'wp-admin/admin-footer.php'); ?>