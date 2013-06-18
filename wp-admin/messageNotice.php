<?php
   if(isset($_REQUEST['action']) && strcmp($_REQUEST['action'], "clear") == 0) {
      $mid = $_REQUEST['mid'];
      $clrMsg = "UPDATE wp_notices SET active=0, old=1 WHERE id = '$mid'";
      $wpdb->query($clrMsg);
   }

   $msgQuery = "Select * from wp_notices where user_id = '$user_id' and active = 1 ORDER BY timestamp DESC";
   $messages = $wpdb->get_results($msgQuery);
   $count = count($messages);
?>
<div id="messageNotice">
   <h3>You have <strong><?php echo "$count ";?></strong> new message<?php if($count != 1) echo "s";?>! <a href="inbox.php">Go to Inbox</a></h3>
   <ul>
      <?php
         $i = 1;
         foreach($messages as $notice) { 
            if($notice->active == 1) {?>
            <form action="landing.php" method="post">
               <input type="hidden" name="action" value="clear" />
               <input type="hidden" name="mid" value="<?php echo "$notice->id";?>" />
               <li><?php echo "$i) $notice->msg";?> <button type="submit">Clear</button></li>
            </form>
      <?php }
         $i++;
         } ?>
</div>
<div class="clear"></div>