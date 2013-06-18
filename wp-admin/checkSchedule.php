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
  
$title = __('Check Schedule');
$parent_file = 'landing.php';



include (ABSPATH . 'wp-admin/admin-header.php');

$today = current_time('mysql', 1);
?>

<div class="wrap">
<?php include (ABSPATH . 'wp-admin/menuBar.php'); ?>
<h2><?php echo esc_html( $title ); ?></h2>

<?php
global $wpdb;

// Build SQL Query  
$queryAppt = "select * from wp_appt where doc_id = '$user_id' order by hour, minute DESC ";
$appts = $wpdb->get_results($queryAppt);
$num = count($appts);
?>
<div id="apptWrap">
   <h4>You have <?php echo "$num";?> appointment<?php if($num != 1) echo "s";?> this week</h4>
<?php 
   if($num) { 
      foreach($appts as $appt) { 
         $t = $appt->hour % 12;
         $time = "$t:$appt->minute"; ?>
         <div class="apptBox">
            <div class="date">
               <?php echo "$appt->day, $appt->month $appt->date, $appt->year";?>
            </div>
            <div class="time">
               <?php echo "$time"; if($appt->hour > 12) echo "pm"; else echo "am"; ?>
            </div>
            <div class="name">
               Name: <?php echo "$appt->last_name, $appt->first_name";?>
            </div>
            <div class="reason">
               Reason: <?php echo "$appt->reason";?>
            </div>
            <div class="cancel">
               <form action="cancelAppt.php" method="post">
                  <input type="hidden" name="appt_id" value="<?php echo "$appt->id";?>" />
                  <input type="hidden" name="doc_id" value="<?php echo "$appt->doc_id";?>" />
                  <button type="submit">Cancel Appointment</button>
               </form>
            </div>
         </div>
<?php }
   } 
?>
<?php //wp_dashboard(); ?>

</div><!-- wrap -->
<?php require(ABSPATH . 'wp-admin/admin-footer.php'); ?>