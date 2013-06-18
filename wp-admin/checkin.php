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
  
$title = __('CheckIn');
$parent_file = 'landing.php';

$id = $_POST['apptid'];
$uid = $_POST['uid'];
$queryAppt = "UPDATE wp_appt SET checked_in = 1 WHERE id = '$id'";
$wpdb->query($queryAppt);

?>
  <script type="text/javascript">
    window.location.href='http://ehisys.org/wp-admin/chart.php?uid=<?php echo "$uid";?>';
  </script>
<?php

?>