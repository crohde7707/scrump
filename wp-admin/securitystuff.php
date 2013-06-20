<?php if(strcmp($user_info-> rpr_type_of_account, "Admin") != 0 && strcmp($user_info-> rpr_type_of_account, "Manager") != 0 && strcmp($user_info-> rpr_type_of_account, "Developer") != 0) {?>
   <h1>YOU DO NOT HAVE ACCESS TO THIS SYSTEM, AND HAVE BEEN TRACKED</h1>
   <script type="text/javascript">
      var secRedirect = function () {
         alert("You do not have access to this system");
         window.location = "http://ehisys.org/wp-login.php?loggedout=TRUE";
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