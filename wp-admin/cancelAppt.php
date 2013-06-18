<?php

/** Load WordPress Bootstrap */
require_once('./admin.php');

$title = __('Cancel Appointment');
$parent_file = 'checkSchedule.php';

$today = current_time('mysql', 1);

global $wpdb;

$apptid = $_POST['appt_id'];
$docid = $_POST['doc_id'];

$queryAppt = "select * from wp_appt where doc_id = '$docid' and id = '$apptid'";
$appt = $wpdb->get_row($queryAppt);
$queryUser = "select email from wp_userchart where user_id = '$appt->user_id'";
$email = $wpdb->get_var($queryUser);
$hour = $appt->hour % 12;
if($appt->hour > 12) {
   $m = "pm";
} else {
   $m = "am";
}
$to = $email;
$from = "noreply@ehisys.org";
$subject = "[EHISYS] Appointment Cancellation Notice";
$message = "Your appointment for " . $appt->day . ", " . $appt->month . " " . $appt->date . ", " . $appt->year . " at " . $hour . ":" . $appt->minute . $m . " has been cancelled. Please log into the EHIS system to reschedule an appointment or contact us at 555-555-5555. We apologize for any inconvience.";
$headers = "From: $from";
mail($to,$subject,$message,$headers);
$curTime = date("Y-m-d H:i:s");
$queryNotice = "INSERT INTO wp_notices (user_id, msg, active, old, recycled, timestamp) VALUES ('$appt->user_id', '$message', 1, 0, 0, '$curTime')";
$wpdb->query($queryNotice);
$wpdb->query("DELETE FROM wp_appt WHERE id = $apptid AND doc_id = $docid");

header( 'Location: http://ehisys.org/wp-admin/checkSchedule.php?action=cancelled' ) ;

?>