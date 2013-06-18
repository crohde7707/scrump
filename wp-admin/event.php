<?
require_once('./admin.php');
global $wpdb;
require_once("includes/config.php");

$query = "SELECT * FROM wp_appt WHERE id='$_GET[id]' LIMIT 1";
$query_result = $wpdb->get_results($query);
foreach($query_result as $info) {
    $date = date ("l, jS F Y", mktime(0,0,0,$info->month,$info->date,$info->year));
    $time = date("g:i a", strtotime($info->starts_at)) . " - " . date("g:i a", strtotime($info->ends_at));


$dquery = "SELECT last_name FROM wp_userchart WHERE user_id = '$info->doc_id'";
$lname = $wpdb->get_var($dquery);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php echo "$info->type for $info->first_name $info->last_name"; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="images/cal.css" rel="stylesheet" type="text/css">
</head>

<body>
   <div class="apptBox">
      <div class="date">
         <?php echo "$date";?>
      </div>
      <div class="time">
         <?php echo "$time";?>
      </div>
      <div class="name">
         Doctor: <?php echo "Dr. $lname";?><br />
         Patient: <?php echo "$info->first_name $info->last_name";?>
      </div>
      <div class="reason">
         <strong>Type of Appointment:</strong> <?php echo "$info->type";?><br />
         <strong>Reason:</strong> <?php echo "$info->reason";?>
      </div>
      <div class="cancel">
          <form action="cancelAppt.php" method="post">
             <input type="hidden" name="appt_id" value="<?php echo "$info->id";?>" />
             <input type="hidden" name="doc_id" value="<?php echo "$info->doc_id";?>" />
             <button type="submit">Cancel Appointment</button>
          </form>
      </div>
   </div>
</body>
</html>
<? } ?>