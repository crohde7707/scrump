<?php
   if(isset($_REQUEST['action']) && strcmp($_REQUEST['action'], "clear") == 0) {
      $mid = $_REQUEST['mid'];
      $clrMsg = "UPDATE wp_notices SET active=0 WHERE id = '$mid'";
      $wpdb->query($clrMsg);
   }
   if(strcmp($user_info->rpr_type_of_account, "Doctor") == 0) { 
      $apptQuery = "Select * from wp_appt where doc_id = '$user_id' and DATEDIFF(starts_at, NOW()) = 0 ORDER BY starts_at ASC";
   } elseif(strcmp($user_info->rpr_type_of_account, "Patient") == 0) {
      $apptQuery = "Select * from wp_appt where user_id = '$user_id' and DATEDIFF(starts_at, NOW()) >= 0 ORDER BY starts_at ASC";
   }
   date_default_timezone_set('America/Cancun');
   $curTime = date("Y-m-d H:i:s");
   $appts = $wpdb->get_results($apptQuery);
   $count = count($appts);
?>
<div id="appointments">
<?php if(strcmp($user_info->rpr_type_of_account, "Doctor") == 0) { ?>
   <h3>Today's Appointments</h3>
<?php } elseif(strcmp($user_info->rpr_type_of_account, "Patient") == 0) { ?>
   <h3>Your Appointments</h3>
<?php } ?>
   <ul>
      <?php
         $i = 1;
         foreach($appts as $appt) { 
            $date = date ("l, jS F Y", mktime(0,0,0,$appt->month,$appt->date,$appt->year));
            $time = date("g:i a", strtotime($appt->starts_at)) . " - " . date("g:i a", strtotime($appt->ends_at));?>
            <div class="apptBox">
               <div class="date">
                  <?php echo "$date";?>
               </div>
               <div class="time">
                  <?php echo "$time";?>
               </div>
               <div class="name">
                  Doctor: <?php echo "Dr. $lname";?><br />
                  Patient: <?php echo "$appt->first_name $appt->last_name";?>
               </div>
               <div class="reason">
                  <strong>Type of Appointment:</strong> <?php echo "$appt->type";?><br />
                  <strong>Reason:</strong> <?php echo "$appt->reason";?>
               </div>
               <div class="cancel">
                   <form action="cancelAppt.php" method="post">
                      <input type="hidden" name="appt_id" value="<?php echo "$appt->id";?>" />
                      <input type="hidden" name="doc_id" value="<?php echo "$appt->doc_id";?>" />
                      <button type="submit">Cancel Appointment</button>
                   </form>
               </div>
            </div>
      <?php 
         $i++;
         } ?>
</div>
<div class="clear"></div>