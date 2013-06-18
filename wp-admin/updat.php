<?php

/** Load WordPress Bootstrap */
require_once('./admin.php');

  $user_id = get_current_user_id();
  $user_info = get_userdata($user_id);  
  


include (ABSPATH . 'wp-admin/admin-header.php');

$today = current_time('mysql', 1);

global $wpdb;

//-------- Vars ---------
$pid = $_POST['pid'];
$uid = (isset($_POST['uid'])) ? $_POST['uid'] : $user_id;
//--------- Query -------

$query = "select * from wp_userchart where user_id = '$pid'";
$chart = $wpdb->get_row($query);
$numrows=count($query);

$queryA = "select * from wp_userchart where user_id = '$uid'";
$chart2 = $wpdb->get_row($queryA);
$numrows2=count($chart2);

$userQ = "select * from wp_userchart where user_id = '$user_id'";
$user = $wpdb->get_row($userQ);

$section = $_POST['section'];

switch($section) {

case 'pInfo':

$i = 0;
$first = $_POST['first'];
$middle = $_POST['middle'];
$last = $_POST['last'];
$dob = (isset($_POST['dob'])) ? $_POST['dob'] : " ";
$sex = $_POST['sex'];
$ssn = $_POST['ssn'];
$marital = $_POST['marital'];
$address1 = $_POST['address1'];
$address2 = $_POST['address2'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$pphone = $_POST['pphone'];
$sphone = $_POST['sphone'];
$email = $_POST['email'];
$ename = explode(" ", $_POST['ename']);
$efname = $ename[0];
$elname = $ename[1];
$ephone = $_POST['ephone'];
$eemail = $_POST['eemail'];
$occupation = $_POST['occupation'];
$ssnreg = '/^[0-9]{3}-?[0-9]{2}-?[0-9]{4}$/';
       
if($numrows2 != 0) {
  if(strcmp($first, $chart->first_name) != 0) {
   $pArray[] = "first_name='$first'";
  }
  if(strcmp($middle, $chart->middle_i) != 0) {
   $pArray[] = "middle_i='$middle'";
  }
  if(strcmp($last, $chart->last_name) != 0) {
   $pArray[] = "last_name='$last'";
  }
  if(strcmp($sex, $chart->sex) != 0) {
   $pArray[] = "sex='$sex'";
  }
  if(strcmp($ssn, $chart->ssn) != 0) {
   if(preg_match($ssnreg, $ssn)) {
      $pArray[] = "ssn='$ssn'";
   }
  }
  if(strcmp($address1, $chart->address1) != 0) {
   $pArray[] = "address1='$address1'";
  }
  if(strcmp($dob, $chart->dob) != 0) {
   $pArray[] = "dob='$dob'";
  }
  if(strcmp($address2, $chart->address2) != 0) {
   $pArray[] = "address2='$address2'";
  }
  if(strcmp($city, $chart->city) != 0) {
   $pArray[] = "city='$city'";
  }
  if(strcmp($state, $chart->state) != 0) {
   $pArray[] = "state='$state'";
  }
  if(strcmp($zip, $chart->zip) != 0) {
   $pArray[] = "zip='$zip'";
  }
  if(strcmp($pphone, $chart->primary_phone) != 0) {
   $pArray[] = "primary_phone='$pphone'";
  }
  if(strcmp($sphone, $chart->secondary_phone) != 0) {
   $pArray[] = "secondary_phone='$sphone'";
  }
  if(strcmp($email, $chart->email) != 0) {
   $pArray[] = "email='$email'";
  }
  if(strcmp($efname, $chart->e_first_name) != 0) {
   $pArray[] = "e_first_name='$efname'";
  }
  if(strcmp($elname, $chart->e_last_name) != 0) {
   $pArray[] = "e_last_name='$elname'";
  }
  if(strcmp($ephone, $chart->e_phone) != 0) {
   $pArray[] = "e_phone='$ephone'";
  }
  if(strcmp($eemail, $chart->e_email) != 0) {
   $pArray[] = "e_email='$eemail'";
  }
  if(strcmp($occupation, $chart->occupation) != 0) {
   $pArray[] = "occupation='$occupation'";
  }
  if(strcmp($marital, $chart->marital) != 0) {
   $pArray[] = "marital='$marital'";
  }

  $first = 1;
  if($pArray) {
   $queryUp = "UPDATE wp_userchart SET ";
   foreach($pArray as $i) {
      if($first < 1) {
         $queryUp .= ", " . $i;   
      } else {
         $queryUp .= $i;
         $first = 0;
      }
   }
   $queryUp .= " WHERE user_id = '$uid'";
   $wpdb->query($queryUp);
  }
} else {
   $queryIn = "INSERT INTO wp_userchart (user_id, first_name, middle_i, last_name, dob, sex, ssn, marital, address1, address2, city, state, zip, primary_phone, secondary_phone, email, occupation, e_first_name, e_last_name, e_phone, e_email) VALUES ('$user_id', '$first', '$middle', '$last', '$dob', '$sex', '$ssn', '$marital', '$address1', '$address2', '$city', '$state', '$zip', '$pphone', '$sphone', '$email', '$occupation', '$efname', '$elname', '$ephone', '$eemail')";
   $wpdb->query($queryIn);
}
if(isset($_POST['initial'])) {?>
<script type="text/javascript">
alert("<?php echo "$user_id: $numrows2";?>");
window.location.href='http://ehisys.org/wp-admin/landing.php';
</script><?php
} else {?>
<script type="text/javascript">
window.location.href='http://ehisys.org/wp-admin/chart.php?uid=<?php echo "$uid";?>&update=pInfo';
</script><?php }
break;


case 'mInfo':
$uid = $_POST['uid'];
$heightF = $_POST['heightF'];
$heightI = $_POST['heightI'];
$curHeight = explode(",", $chart->height);
$height = $heightF.",".$heightI;
$weight = $_POST['weight'];
$ail = $_POST['ail'];
$ails = implode(",", $ail);

if( (strcmp($heightF, $curHeight[0]) != 0 ) || (strcmp($heightI, $curHeight[1]) != 0) ) {
   $mArray[] = "height='$height'";
}
if(strcmp($weight, $chart->weight) != 0) {
   $mArray[] = "weight='$weight'";
}
if(strcmp($ails, $chart->ails) != 0) {
   $mArray[] = "ails='$ails'";
}

$first = 1;
if($mArray) {
   $queryUp = "UPDATE wp_userchart SET ";
   foreach($mArray as $i) {
      if($first < 1) {
         $queryUp .= ", " . $i;   
      } else {
         $queryUp .= $i;
         $first = 0;
      }
   }
   $queryUp .= " WHERE user_id = '$uid'";
   $wpdb->query($queryUp);
}
?><script type="text/javascript">
window.location.href='http://ehisys.org/wp-admin/chart.php?uid=<?php echo "$uid";?>&update=mInfo';
</script><?php
break;


case 'iInfo': 
$uid = $_POST['uid'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$phname = $_POST['phname'];
$number = $_POST['number'];
$gnumber = $_POST['gnumber'];
$phdob = $_POST['phdob'];
$phphone = $_POST['phphone'];

  if(strcmp($name, $chart->ins_company) != 0) {
   $pArray[] = "ins_company='$name'";
  }
  if(strcmp($phone, $chart->ins_phone) != 0) {
   $pArray[] = "ins_phone='$phone'";
  }
  if(strcmp($address, $chart->ins_address) != 0) {
   $pArray[] = "ins_address='$address'";
  }
  if(strcmp($city, $chart->ins_city) != 0) {
   $pArray[] = "ins_city='$city'";
  }
  if(strcmp($state, $chart->ins_state) != 0) {
   $pArray[] = "ins_state='$state'";
  }
  if(strcmp($zip, $chart->ins_zip) != 0) {
   $pArray[] = "ins_zip='$zip'";
  }
  if(strcmp($phname, $chart->ins_phname) != 0) {
   $pArray[] = "ins_phname='$phname'";
  }
  if(strcmp($number, $chart->ins_number) != 0) {
   $pArray[] = "ins_number='$number'";
  }
  if(strcmp($gnumber, $chart->ins_gnumber) != 0) {
   $pArray[] = "ins_gnumber='$gnumber'";
  }
  if(strcmp($phdob, $chart->ins_phdob) != 0) {
   $pArray[] = "ins_phdob='$phdob'";
  }
  if(strcmp($phphone, $chart->ins_phphone) != 0) {
   $pArray[] = "ins_phphone='$phphone'";
  }

  $first = 1;
  if($pArray) {
   $queryUp = "UPDATE wp_userchart SET ";
   foreach($pArray as $i) {
      if($first < 1) {
         $queryUp .= ", " . $i;   
      } else {
         $queryUp .= $i;
         $first = 0;
      }
   }
   $queryUp .= " WHERE user_id = '$uid'";
   $wpdb->query($queryUp);
  }?>
<script type="text/javascript">
   window.location.href='http://ehisys.org/wp-admin/chart.php?uid=<?php echo "$uid";?>&update=iInfo';
</script>
<?php
break;


case 'enterT':
$tname = $_POST['test_name'];
$tdesc = $_POST['test_description'];
$uid = $_POST['uid'];
$queryEnterTest = "INSERT INTO wp_tests (user_id, test_name, test_description) VALUES ('$uid', '$tname', '$tdesc')";
$wpdb->query($queryEnterTest);?>
<script type="text/javascript">
   window.location.href='http://ehisys.org/wp-admin/chart.php?uid=<?php echo "$uid";?>&test=entered';
</script>
<?php
break;

case 'enterDiag':
$uid = $_POST['uid'];
$diag = $_POST['diag'];
$curTime = date("Y-m-d H:i:s");
$queryEDiag = "INSERT INTO wp_diag (user_id, diagnosis, timestamp) VALUES ('$uid', '$diag', '$curTime')";
$wpdb->query($queryEDiag);
?>
<script type="text/javascript">
   window.location.href='http://ehisys.org/wp-admin/chart.php?uid=<?php echo "$uid";?>&diag=entered';
</script>
<?php
break;

case 'enterCond':
$uid = $_POST['uid'];
$cond = $_POST['cond'];
$curTime = date("Y-m-d H:i:s");
$queryCDiag = "INSERT INTO wp_cond (user_id, condition, timestamp) VALUES ('$uid', '$cond', '$curTime')";
$wpdb->query($queryCDiag);
?>
<script type="text/javascript">
   window.location.href='http://ehisys.org/wp-admin/chart.php?uid=<?php echo "$uid";?>&cond=entered';
</script>
<?php
break;

case 'sendT':
$uid = $_POST['uid'];
$tid = $_POST['test'];
$email = "lab@ehisys.org";
$queryTest = "Select * from wp_tests where id = '$tid'";
$test = $wpdb->get_row($queryTest);

$to = $email;
$subject = "[EHISYS] Test Order #" . $tid;
$message = $user_info-> rpr_type_of_account . " " . $user-> last_name . " has requested the following test to be done:" . "\n\n" . "Test Name: " . $test->test_name . "\n" . "Test Description: " . $test->test_description;
$headers = 'From: ' . $user_info-> rpr_type_of_account . " " . $user-> last_name . ' <noreply@ehisys.org>' . "\r\n";
mail($to,$subject,$message,$headers);

$queryUp = "UPDATE wp_tests SET sent='true' WHERE id = '$tid'";
$wpdb->query($queryUp);
?><script type="text/javascript">
window.location.href='http://ehisys.org/wp-admin/chart.php?uid=<?php echo "$uid";?>&test=sent';
</script>
<?php
break;

case 'sendReceipt':
$uid = $_POST['uid'];
$rc = $_POST['rc'];

$rQuery = "SELECT * from wp_rc where id = '$rc'";
$rec = $wpdb->get_row($rQuery);
$pQuery = "SELECT email from wp_userchart where user_id = '$uid'";
$email = $wpdb->get_var($pQuery);

$to = $email;
$subject = "[EHISYS] Receipt for your visit";
$message = "Attached is a copy of your receipt";
$headers = 'From: EHIS <noreply@ehisys.org>' . "\r\n";
mail($to,$subject,$message,$headers);

$rUpdate = "UPDATE wp_rc SET sent='true' where id = '$rc'";
$wpdb->query($rUpdate);
?><script type="text/javascript">
window.location.href='http://ehisys.org/wp-admin/chart.php?uid=<?php echo "$uid";?>&rc=sent';
</script>
<?php
break;

case 'sendPersc':
$uid = $_POST['uid'];
$perc = $_POST['perc'];

$pQuery = "SELECT * from wp_percs where id = '$perc'";
$perscription = $wpdb->get_row($pQuery);

$email = "pharmacy@ehisys.org";
$to = $email;
$subject = "[EHISYS] Perscription Request";
$message = $user_info-> rpr_type_of_account . " " . $user-> last_name . " has requested the following attached perscription to be filled" . "\n";
$headers = 'From: ' . $user_info-> rpr_type_of_account . " " . $user-> last_name . ' <noreply@ehisys.org>' . "\r\n";
mail($to,$subject,$message,$headers);

$pUpdate = "UPDATE wp_percs SET sent='true' where id = '$perc'";
$wpdb->query($pUpdate);
?><script type="text/javascript">
window.location.href='http://ehisys.org/wp-admin/chart.php?uid=<?php echo "$uid";?>&perc=sent';
</script>
<?php
break;

case 'transmitIns':
$useremail = $user->email;
$email = "insurance@ehisys.org";
$to = $email;
$subject = "[EHISYS] Verify Insurance Information";
$message = $user_info-> rpr_type_of_account . " " . $user-> last_name . " has requested the following information to be verified:" . "\n\n" . "Patient Name: " . $chart->first_name . " " . $chart->middle_i . ". " . $chart->last_name . "\n" . "Policy Holder: " . $chart->ins_phname . "\n" . "Policy Number: " . $chart->ins_number . "\n" . "Policy Group Number: " . $chart->ins_gnumber . "\n" . "Policy Holder's DOB: " . $chart->ins_phdob . "\n" . "Policy Holder's Phone: " . $chart->ins_phphone . "\n";
$headers = 'From: ' . $user_info-> rpr_type_of_account . " " . $user-> last_name . ' <' . $useremail . '>' . "\r\n";
mail($to,$subject,$message,$headers);

$to = $useremail;
$subject = $chart->ins_company . ": Account Verification Notice";
$message = "The policy information for " . $chart->first_name . " " . $chart->middle_i . ". " . $chart->last_name . " has been verified.";
$headers = 'From: ' . $chart->ins_company . ' <insurance@ehisys.org>' . "\r\n";
mail($to,$subject,$message,$headers);
?><script type="text/javascript">
window.location.href='http://ehisys.org/wp-admin/chart.php?uid=<?php echo "$chart->user_id";?>&transmit=sent';
</script>
<?php
break;

case 'fileUpload':
$uid = $_POST['uid'];
   $pdfDirectory = "http://ehisys.org/wp-admin/includes/files/tests/";
   $filename = $pdfDirectory . basename($_FILES['userfile']['name']);
   if (is_uploaded_file($_FILES['file']['tmp_name'])) {
         if ($_FILES['file']['type'] != "application/pdf") {
            $error .= "File is not a pdf, ";
         } else {
            //$filename = preg_replace("/[^A-Za-z0-9_-]/", "", $filename).".pdf";
            $result = move_uploaded_file($_FILES['userfile']['tmp_name'], $filename);
            ?><script type="text/javascript">
            <?php if ($result == 1) { ?>
               window.location.href='http://ehisys.org/wp-admin/chart.php?uid=<?php echo "$uid";?>&upload=success';
            <?php } else { 
               $error .= "File did not upload";?>
               window.location.href='http://ehisys.org/wp-admin/chart.php?uid=<?php echo "$uid";?>&upload=fail&err=<?php echo $error;?>';
            <?php } ?>
            </script>
            <?php
         }
   }

break;

case 'makeAppt':
   $uid = $_POST['pid'];
   if(!$uid) {
      $name = explode(" ", $_POST['patient']);
      $queryPat = "SELECT user_id FROM wp_userchart where first_name = '$name[0]' AND last_name = '$name[1]'";
      $uid = $wpdb->get_var($queryPat);
      if(!$uid) {
         $error = 1;
         $emsg .= "Patient does not exist, ";
      }
   } else {
      $queryPat = "SELECT * FROM wp_userchart where user_id = '$uid'";
      $usr = $wpdb->get_row($queryPat);
      $name = array($usr->first_name, $usr->last_name);
   }
   $docid = $_POST['did'];
   $apptType = $_POST['apptType'];
   if(!$apptType) {
      $error = 1;
      $emsg .= "You must pick an appointment type, ";
   }
   $year = $_POST['year'];
   $month = $_POST['month'];
   $date = $_POST['date'];
   $hour = $_POST['hour'];
   $min = $_POST['min'];
   $stime = "$year-$month-$date $hour:$min:00";
   $day = date("l", strtotime($stime));
   if($day == "Saturday" || $day == "Sunday") {
      $error = 1;
      $emsg .= "Appointments are not available on weekends, ";
   }
   $reason = (isset($_POST['reason'])) ? $_POST['reason'] : $apptType;
   switch($apptType) {
      case "regular":
         $add = 20;
         break;

      case "followup":
         $add = 30; 
         break;

      case "physical":
         $add = 40;
         break;

      default:
      ;
   }
   $etime = date("Y-m-d H:i:s", strtotime("+ $add minute", strtotime($stime)));
   $ntime = date("Y-m-d H:i:s", strtotime("-1 day", strtotime($stime)));
   $starts_at = date("Y-m-d H:i:s", strtotime($stime));
   $ends_at = date("Y-m-d H:i:s", strtotime($etime));
   $notify = date("Y-m-d H:i:s", strtotime($ntime));
   $curTime = date("Y-m-d H:i:s");
   
   if($starts_at > $curTime) {
      $nAppt = "INSERT INTO wp_appt (user_id, doc_id, starts_at, ends_at, notify, day, month, date, year, hour, minute, first_name, last_name, type, reason) VALUES ('$uid', '$docid', '$starts_at', '$ends_at', '$notify', '$day', '$month', '$date', '$year', '$hour', '$min', '$name[0]', '$name[1]', '$apptType', '$reason')";
   } else {
      $error = 1;
      $emsg .= "You can not make an appointment in the past";
   }

   if(!$error) {
      $wpdb->query($nAppt);
      $m = "New Appointment: $name[0] $name[1]";
      $notice = "INSERT INTO wp_notices (user_id, msg, active, old, recycled, timestamp) VALUES ('$docid', '$m', 1, 0, 0, '$curTime')";
      $wpdb->query($notice);
   }
?>
<script type="text/javascript">
   <?php if (!$error) { ?>
       window.location.href='http://ehisys.org/wp-admin/makeAppt.php?docid=<?php echo "$docid";?>&action=success';
   <?php } else { ?>
       window.location.href='http://ehisys.org/wp-admin/makeAppt.php?docid=<?php echo "$docid";?>&emsg=<?php echo "$emsg";?>&action=fail';
   <?php } ?>
</script>
<?php
break;

case 'sendMsg':
$uid = $_POST['uid'];
$msg = $_POST['msg'];
$type = $_POST['type'];
$recepient = explode(" ", $_POST['recepient']);
$pQuery = "SELECT * FROM wp_userchart WHERE first_name = '$recepient[0]' AND last_name = '$recepient[1]'";
$user = $wpdb->get_row($pQuery);
$error = 0;
if($user->user_id) {
   if(strcmp($type, "internal") == 0) {
      $curTime = date("Y-m-d H:i:s");
      $message = "INSERT INTO wp_notices (user_id, msg, active, old, recycled, timestamp) VALUES ('$user->user_id', '$msg', 1, 0, 0, '$curTime')";
      $wpdb->query($message);
   } else if ( strcmp($type, "external") == 0) {
      $to = $user->email;
      $subject = "[EHIS] Message";
      $headers = 'From: [EHIS] <internal@ehisys.org>' . "\r\n";
      mail($to,$subject,$msg,$headers);
   } else {
      $error = 1;
      $errmsg = "Type of message not specified";
   }
} else {
      $error = 1;
      $errmsg = "Recepient not found";
}?>
<script type="text/javascript">
<?php if(!$error) {?>
   window.location.href='http://ehisys.org/wp-admin/inbox.php?action=success';
<?php } else { ?>
   window.location.href='http://ehisys.org/wp-admin/inbox.php?action=fail&err=<?php echo "$errmsg";?>';
<?php } ?>
</script>
<?php
break;

default:
echo "default";
;
}
//wp_dashboard(); ?>

</div><!-- wrap -->
<?php require(ABSPATH . 'wp-admin/admin-footer.php'); ?>