<?php

/** Load WordPress Bootstrap */
require_once('./admin.php');

  $user_id = get_current_user_id();
  $user_info = get_userdata($user_id);  
  


//include (ABSPATH . 'wp-admin/admin-header.php');

$today = current_time('mysql', 1);

global $wpdb;

//-------- Vars ---------
$pid = $_POST['pid'];
$uid = (isset($_POST['uid'])) ? $_POST['uid'] : $user_id;
//--------- Query -------

$queryA = "select * from wp_users where user_id = '$uid'";
$uinfo = $wpdb->get_row($queryA);
$count=count($chart2);

$section = $_POST['section'];

switch($section) {

case 'pInfo':

$i = 0;
$first = $_POST['first'];
$last = $_POST['last'];
$email = $_POST['email'];
$phone = $_POST['phone'];
       
if(strcmp($first, $uinfo->user_firstName) != 0) {
   $pArray[] = "user_firstName='$first'";
}
if(strcmp($last, $uinfo->user_lastName) != 0) {
   $pArray[] = "user_lastName='$last'";
}
if(strcmp($email, $uinfo->user_email) != 0) {
   $pArray[] = "user_email='$email'";
}
if(strcmp($phone, $uinfo->user_phone) != 0) {
   $pArray[] = "user_phone='$phone'";
}

$first = 1;
  if($pArray) {
   $queryUp = "UPDATE wp_users SET ";
   foreach($pArray as $i) {
      if($first < 1) {
         $queryUp .= ", " . $i;   
      } else {
         $queryUp .= $i;
         $first = 0;
      }
   }
   $queryUp .= " WHERE ID = '$uid'";
   $wpdb->query($queryUp);
  }

?>
<script type="text/javascript">
window.location.href='http://ehisys.org/wp-admin/personalInfo.php?&update=success';
</script>
<?php 
break;

case 'enterT': //remove
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

case 'enterDiag': //remove
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

case 'enterCond': //remove
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

case 'sendT': //remove
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

case 'sendReceipt': //remove
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

case 'sendPersc': //remove
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

case 'transmitIns': //remove
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

case 'newProject':
$uid = $_POST['uid'];
$projName = $_POST['projName'];
$projDesc = $_POST['projDesc'];

$nQuery = "INSERT INTO wp_proj (owner_ID, name, description) VALUES ('$uid', '$projName', '$projDesc')";
$wpdb->query($nQuery);

$pQuery = "SELECT ID from wp_proj WHERE name = '$projName'";
$projID = $wpdb->get_var($pQuery);

$rQuery = "INSERT INTO wp_roles (proj_ID, user_ID, role) VALUES ('$projID', '$uid', 'Project Owner')";
$wpdb->query($rQuery);

?>
<script type="text/javascript">
   window.location.href='http://ehisys.org/wp-admin/landing.php?action=success';
</script>
<?php

break;

case 'sendMsg':
$uid = $_POST['user_id'];
$msg = $_POST['msg'];
$type = $_POST['type'];
$recepient = $_POST['recepient'];

$pQuery = "select * from wp_users where user_email like '$recepient'";
$user = $wpdb->get_row($pQuery);

$eQuery = "select user_email from wp_users where ID = '$uid'";
$sender = $wpdb->get_var($eQuery);

$error = 0;
if($user->ID) {
   if(strcmp($type, "internal") == 0) {
      $curTime = date("Y-m-d H:i:s");
      $message = "INSERT INTO wp_notices (user_id, sender, msg, active, old, recycled, timestamp) VALUES ('$user->ID', '$sender', '$msg', 1, 0, 0, '$curTime')";
      $wpdb->query($message);
   } else if ( strcmp($type, "external") == 0) {
      $to = $user->email;
      $subject = "[SCRUMP] Message";
      $headers = 'From: [SCRUMP] <internal@ehisys.org>' . "\r\n";
      mail($to,$subject,$msg,$headers);
   } else {
      $error = 1;
      $errmsg = "Type of message not specified";
   }
} else {
      $error = 1;
      $errmsg = 'Recepient not found '. $recepient;
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

case 'moveMsg':
   $action = $_POST['action'];
   $mid = $_POST['mid'];
   switch($action) {
      case "recycle":
         $qMsg = "UPDATE wp_notices SET active=0, old=0, recycled=1 WHERE id = '$mid'";
         break;
      case "old":
         $qMsg = "UPDATE wp_notices SET active=0, old=1, recycled=0 WHERE id = '$mid'";
         break;
      case "new":
         $qMsg = "UPDATE wp_notices SET active=1, old=0, recycled=0 WHERE id = '$mid'";
         break;
      default:
      ;
   }
   $wpdb->query($qMsg);
?>
<script type="text/javascript">
<?php if(!$error) {?>
   window.location.href='http://ehisys.org/wp-admin/inbox.php';
<?php } else { ?>
   window.location.href='http://ehisys.org/wp-admin/inbox.php?action=fail&err=<?php echo "$errmsg";?>';
<?php } ?>
</script>
<?php
break;

case 'editProject':
    break;

case 'deleteProject':
    break;

default:
echo "default";
;
}
//wp_dashboard(); ?>

</div><!-- wrap -->
<?php require(ABSPATH . 'wp-admin/admin-footer.php'); ?>