<?php

/** Load WordPress Bootstrap */
require_once('./admin.php');

/** Load WordPress dashboard API */
require_once(ABSPATH . 'wp-admin/includes/dashboard.php');

wp_dashboard_setup();

$user_id = get_current_user_id();
$user_info = get_userdata($user_id);  
  
$title = __('Patient Chart');
$parent_file = 'patientSearch.php';

include (ABSPATH . 'wp-admin/admin-header.php');

$today = current_time('mysql', 1);

$item = $_GET['update'];
?>
<div class="wrap">
hello
<?php
$action = $_GET['action'];
if(strcmp($action, "success") == 0) { ?>
     <div class="msgSuccess">
        <h4>Appointment created successfully</h4>
     </div>
  <?php } elseif (strcmp($action, "fail") == 0) {
     $emsg = $_GET['emsg'];?>
     <div class="msgFail">
        <h4>Appointment not created<br /> - <?php echo "$emsg";?></h4>
     </div>
  <?php }
include (ABSPATH . 'wp-admin/menuBar.php'); 

//Wordpress database hook
global $wpdb;

// Build SQL Query  
$query = "select * from wp_userchart where user_id = '$user_id'";

   $chart = $wpdb->get_row($query);
   $numrows=count($query);

$queryD = "select user_id from wp_usermeta where meta_value = 'Doctor'";
   $ids = $wpdb->get_var($queryD);
$qds = "select * from wp_userchart where user_id in ($ids)";
   $docs = $wpdb->get_results($qds);
?>
  <?php if(strcmp($user_info->rpr_type_of_account, "Doctor") == 0) {
     $hidden = 'style="display:none"';
     $head = "Your Calendar";
  } else {
     $hidden = "";
     $head = "Make Appointment";
  } ?>
  <h2><?php echo $head;?></h2>
  <form <?php echo $hidden;?> action="makeAppt.php" name="chDoc" method="post">
     <?php
     $docid = (isset($_GET['docid'])) ? $_GET['docid'] : $_POST['docid'];
     if($docid){
	$select = "selected";
     } else {
        $select = "";
     }
     ?>	
     <select name="docid">
        <option value=""></option>
        <?php
           foreach($docs as $doc) { ?>
        <option value="<?php echo "$doc->user_id";?>" <?php echo "$select";?>>Dr. <?php echo "$doc->last_name";?></option>
        <?php } ?>
     </select>
     <button type="submit">Update</button>
  </form>
  <div class="cal"><?php
  if($docid) {
?>
</div><br />
<div class="apptForm">
  <form action="updat.php" name="makeAppt" method="post">
    <?php
       if(strcmp($user_info->rpr_type_of_account, "Patient") == 0) {?>
          <input type="hidden" name="pid" value="<?php echo "$user_id";?>" />
      <?php } else { ?>
          Patient's Name: <input type="text" name="patient" /> (First and last name)<br />
      <?php } ?>
    <input type="hidden" name="section" value="makeAppt" />
    <input type="hidden" name="did" value="<?php echo "$docid";?>" />
    Appointment Type: <select name="apptType">
      <option value="">Select Appointment Type</option>
      <option value="regular">Regular Appointment</option>
      <option value="followup">follow-ups of medical tests</option>
      <option value="physical">Annual Physical Exam</option>
    </select><br />
    Month: <select name="month">
      <option value="1">Jan</option>
      <option value="2">Feb</option>
      <option value="3">Mar</option>
      <option value="4">Apr</option>
      <option value="5">May</option>
      <option value="6">Jun</option>
      <option value="7">Jul</option>
      <option value="8">Aug</option>
      <option value="9">Sep</option>
      <option value="10">Oct</option>
      <option value="11">Nov</option>
      <option value="12">Dec</option>
    </select>
    Day: <select name="date">
       <?php
          for($i=1; $i <= 31; $i++) { ?>
             <option value="<?php echo "$i";?>"><?php echo "$i";?></option>
          <?php } ?>
    </select>
    Year: <select name="year">
      <?php
         $curYear = Date("Y");
         for($i=0; $i < 2; $i++) { 
            $curYear += $i?>
            <option value="<?php echo "$curYear";?>"><?php echo "$curYear";?></option>
         <?php }
      ?>
    </select><br />
    Time: <select name="hour">
      <option value="8">08</option>
      <option value="9">09</option>
      <option value="10">10</option>
      <option value="11">11</option>
      <option value="12">12</option>
      <option value="13">01</option>
      <option value="14">02</option>
      <option value="15">03</option>
      <option value="16">04</option>
      <option value="17">05</option>
    </select> : <select name="min">
      <option value="00">00</option>
      <option value="15">15</option>
      <option value="30">30</option>
      <option value="45">45</option>
    </select><br />
    Reason:<br />
    <textarea rows="5" cols="80" name="reason"></textarea><br />
    <button type="submit">Make Appointment</button>
  </form>
</div><br /><br />
<?php 
include (ABSPATH . 'wp-admin/phpcal.php');
}
?>
</div><!-- wrap -->
<script type="text/javascript" src="/wp-admin/js/tinybox.js"></script>
<?php require(ABSPATH . 'wp-admin/admin-footer.php'); ?>