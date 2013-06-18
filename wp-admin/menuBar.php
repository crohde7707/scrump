<div id="topMenu">
   <ul>
      <li><a href="/wp-admin/landing.php">Home</a></li>
      <li><a href="/wp-admin/inbox.php">Inbox</a></li>
      <li><a href="http://ehisys.org/wp-login.php?action=logout">Logout</a></li>
   </ul>   
</div>
<div id="sideMenu">
<?php if(strcmp($user_info-> rpr_type_of_account, "Doctor") == 0) {?>
    <h4>Menu</h4>
    <ul>
       <li><a href="patientSearch.php">Look Up Patient</a></li>
       <li><a href="makeAppt.php?docid=<?php echo "$user_id";?>">Check Calendar</a></li>
    </ul>
<?php } elseif(strcmp($user_info-> rpr_type_of_account, "Nurse")== 0) {?>
    <h4>Menu</h4>
    <ul>
       <li><a href="patientSearch.php">Look Up Patient</a></li>
    </ul>
<?php } elseif(strcmp($user_info-> rpr_type_of_account, "Receptionist")== 0) {?>
    <h4>Menu</h4>
    <ul>
       <li><a href="patientSearch.php">Look Up Patient</a></li>
       <li><a href="makeAppt.php">Make Appointment</a></li>
    </ul>
<?php } elseif(strcmp($user_info-> rpr_type_of_account, "Patient")== 0) {?>
    <h4>Menu</h4>
    <ul>
       <li><a href="chart.php?uid=<?php echo "$user_id";?>">Personal Info</a></li>
       <li><a href="makeAppt.php">Make Appointment</a></li>
       <li><a href="userPreferences.php">Preferences</a></li>
       <li><a href="contact.php">Contact Us</a></li>
    </ul>
<?php } elseif(strcmp($user_info-> rpr_type_of_account, "Admin")== 0) {?>
     
<?php } else {?>
   <h1>YOU DO NOT HAVE ACCESS TO THIS SYSTEM, AND HAVE BEEN TRACKED</h1>
   <script type="text/javascript">
      var secRedirect = function () {
         alert("You do not have access to this system");
         window.location = "http://ehisys.org/wp-login.php?loggedout=TRUE;
      }();
   </script>
<?php 
$ip = $_SERVER['REMOTE_ADDR'];
$hostaddress = gethostbyaddr($ip);
$browser = $_SERVER['HTTP_USER_AGENT'];

$to = "crohde7707@gmail.com";
$subject = "[EHISYS] User breached past login page without being in the system";
$message = "System Breach-> IP:" . $ip . "; Host Address: " . $hostaddress . "; Browser: " . $browser . ";";
$from = "security@ehisys.org";
$headers = "From:" . $from;
mail($to,$subject,$message,$headers);
 }?>
<div class="clear"></div>
</div><!-- dashboard-widgets-wrap -->