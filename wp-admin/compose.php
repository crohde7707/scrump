<?php
require_once('./admin.php');
global $wpdb;
require_once("includes/config.php"); 
$uid = $_GET['uid'];?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php echo "Compose Message"; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="images/cal.css" rel="stylesheet" type="text/css">
</head>

<body>
  <div id="composeMsg">
   <h4>Compose Message</h4>
   <form action="updat.php" method="post">
      <input type="hidden" name="user_id" value="<?php echo $uid; ?>" />
      <input type="hidden" name="section" value="sendMsg" />
      First and Last Name:<br />
      <input type="text" name="recepient" /> <input type="radio" name="type" value="internal" checked /> Internal  <input type="radio" name="type" value="external" /> External<br />
      Message:</br />
      <textarea rows="4" cols="50" name="msg"></textarea><br ?>
      <button type="submit">Send Message</button>
   </form>
  </div>
</body>
</html>