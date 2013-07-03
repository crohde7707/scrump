<?php
require_once('./admin.php');
global $wpdb;
require_once("includes/config.php"); 
$user_id = get_current_user_id(); //user id
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php echo "Compose Message"; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="images/cal.css" rel="stylesheet" type="text/css">
</head>

<body>
  <script type="text/javascript">
     console.log("<?php echo '$uid\n$user_id';?>");
  </script>
  <div id="composeMsg">
   <h4>Compose Message</h4>
   <form action="updat.php" method="post">
      <input type="hidden" name="user_id" value="<?php echo "$user_id"; ?>" />
      <input type="hidden" name="section" value="sendMsg" />
      Email:<br />
      <input type="text" name="recepient" /> <input type="radio" name="type" value="internal" checked /> Internal  <input type="radio" name="type" value="external" /> External<br />
      Message:</br />
      <textarea rows="4" cols="50" name="msg"></textarea><br ?>
      <button type="submit">Send Message</button>
   </form>
  </div>
</body>
</html>