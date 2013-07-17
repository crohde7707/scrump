<?php
   $msgQuery = "Select * from wp_notices where user_id = '$user_id' AND active = 1 ORDER BY timestamp DESC";
   $messages = $wpdb->get_results($msgQuery);
   $count = count($messages);
?>

<div id="topMenu">
   <ul>
      <li><a href="/wp-admin/landing.php">Home</a></li>
      <li><a href="/wp-admin/inbox.php">Inbox</a> <?php if($count) { ?><span class="haveMessages"><?php echo $count; ?></span><?php } else { ?><span class="noMessages"><?php echo $count; ?></span><?php } ?></li>
      <li><a href="/wp-admin/personalInfo.php">Profile</a></li>
      <?php if(strcmp($uinfo-> site_role, "Admin")==0) { 
          /*Display Only If User in an admin*/
          echo '<li><a href="/wp-admin/manageusers.php">Manage Users</a></li>'; 
      } 
      ?>
      <li><a href="http://ehisys.org/wp-login.php?action=logout">Logout</a></li>
   </ul>   
</div>

<div class="clear"></div>
</div><!-- dashboard-widgets-wrap -->
</div><!-- headerWrap -->