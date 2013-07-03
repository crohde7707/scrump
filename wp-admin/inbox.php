<?php

/** Load WordPress Bootstrap */
require_once('./admin.php');

/** Load WordPress dashboard API */
require_once(ABSPATH . 'wp-admin/includes/dashboard.php');

add_thickbox();


$user_id = get_current_user_id(); //user id
$user_info = get_userdata($user_id); //all info inside wp_usermeta table
  
$title = __('Inbox');
$parent_file = 'landing.php';

global $wpdb;

$query = "select * from wp_users where ID = '$user_id'";
$uinfo = $wpdb->get_row($query);

include (ABSPATH . 'wp-admin/admin-header.php');

$today = current_time('mysql', 1);
?>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<style type="text/css">
  form { float:left; }
  .msg { width:73%; }
  .ui-tabs { padding: 0; }
  .ui-tabs-vertical { width: 90%; background: #cccccc url(images/ui-bg_highlight-soft_75_cccccc_1x100.png) 50% 0% repeat-x;}
  .ui-tabs-vertical .ui-tabs-nav { padding: 1%; float: left; width: 15%; border:none; background: #cccccc url(images/ui-bg_highlight-soft_75_cccccc_1x100.png) 50% 0% repeat-x;}
  .ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important; margin: 0 -1px .2em 0; border-radius:10px; }
  .ui-tabs-vertical .ui-tabs-nav li a { display:block; width:99%; padding:2% 0 2% 1%; text-align:center;}
  .ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active { border-right-width: 1px; border-right-width: 1px; cursor:pointer; margin: 0 -1px .2em 0; padding-right:25px;border:none;}
  .ui-tabs-vertical .ui-tabs-panel { padding: 1%; float: left; width: 81%; background-color:#FFF; min-height:150px;}
</style>
<?php include (ABSPATH . 'wp-admin/menuBar.php'); ?>
<div class="wrap">
<h2><?php echo esc_html( $title ); ?> <input style="font-size:13px; padding:4px;" type="button" onclick='TINY.box.show({url:"compose.php",animate:false,mask:false,boxid:"appt"})' value="Compose" /></h2>
<?php
global $wpdb;

   $msgQuery = "Select * from wp_notices where user_id = '$user_id' ORDER BY timestamp DESC";
   $messages = $wpdb->get_results($msgQuery);
   $count = count($messages);
?>
<script type="text/javascript">
$(function() {
    $( "#inboxWrap" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
    $( "#inboxWrap li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
  });
</script>
<div id="inboxWrap">
   <ul>
      <li><a href="#new">New</a></li>
      <li><a href="#old">Old</a></li>
      <li><a href="#recycled">Recycled</a></li>
   </ul>
   <div id="new">
      <h3>New Messages</h3>
      <table class="msgs">
         <tr>
            <td>#</td>
            <td>Sender</td>
            <td class="msg">Message</td>
            <td>Action</td>
         </tr>
      <?php
         $i = 1;
         foreach($messages as $msg) {
            if(strcmp($msg->active, 1) == 0) {
               if($i % 2 != 0) {?>
                <tr class="odd">
               <?php } else { ?>
                <tr class="even">
               <?php } ?>
                  <td><?php echo "$i";?></td>
                  <td class="sender"><?php echo "$msg->sender";?></td>
                  <td class="msg"><?php echo "$msg->msg";?></td>
                  <td><form action="updat.php" method="post">
                         <input type="hidden" name="action" value="old" />
                         <input type="hidden" name="section" value="moveMsg" />
                         <input type="hidden" name="mid" value="<?php echo "$msg->id";?>" />
                         <button type="submit">Mark as Old</button>
                      </form><form action="updat.php" method="post">
                         <input type="hidden" name="action" value="recycle" />
                         <input type="hidden" name="section" value="moveMsg" />
                         <input type="hidden" name="mid" value="<?php echo "$msg->id";?>" />
                         <button type="submit">Recycle</button>
                      </form>
                  </td>
               </tr>
            <?php 
            $i++;
            }
         }
         if ($i == 1) { ?>
            <tr>
               <td colspan=3>You have no new messages</td>
            </tr>
         <?php }
      ?>
      </table>
   </div>
   <div id="old">
      <h3>Old Messages</h3>
      <table class="msgs">
         <tr>
            <td>#</td>
            <td>Sender</td>
            <td class="msg">Message</td>
            <td>Action</td>
         </tr>
      <?php
         $i = 1;
         foreach($messages as $msg) {
            if(strcmp($msg->old, 1) == 0) { 
              if($i % 2 != 0) {?>
                <tr class="odd">
               <?php } else { ?>
                <tr class="even">
               <?php } ?>
                  <td><?php echo "$i";?></td>
                  <td class="sender"><?php echo "$msg->sender";?></td>
                  <td class="msg"><?php echo "$msg->msg";?></td>
                  <td><form action="updat.php" method="post">
                         <input type="hidden" name="action" value="new" />
                         <input type="hidden" name="section" value="moveMsg" />
                         <input type="hidden" name="mid" value="<?php echo "$msg->id";?>" />
                         <button type="submit">Mark as New</button>
                      </form><form action="updat.php" method="post">
                         <input type="hidden" name="action" value="recycle" />
                         <input type="hidden" name="section" value="moveMsg" />
                         <input type="hidden" name="mid" value="<?php echo "$msg->id";?>" />
                         <button type="submit">Recycle</button>
                      </form>
                  </td>
               </tr>
            <?php 
            $i++;
            }
         }
         if ($i == 1) { ?>
            <tr>
               <td colspan=3>You have no old messages</td>
            </tr>
         <?php }
      ?>
      </table>   
   </div>
   <div id="recycled">
      <h3>Recycled Messages</h3>
      <table class="msgs">
         <tr>
            <td>#</td>
            <td>Sender</td>
            <td class="msg">Message</td>
            <td>Action</td>
         </tr>
      <?php
         $i = 1;
         foreach($messages as $msg) {
            if(strcmp($msg->recycled, 1) == 0) { 
               if($i % 2 != 0) {?>
                <tr class="odd">
               <?php } else {?>
                <tr class="even">
               <?php } ?>
                  <td><?php echo "$i";?></td>
                  <td class="sender"><?php echo "$msg->sender";?></td>
                  <td class="msg"><?php echo "$msg->msg";?></td>
                  <td><form action="updat.php" method="post">
                         <input type="hidden" name="action" value="new" />
                         <input type="hidden" name="section" value="moveMsg" />
                         <input type="hidden" name="mid" value="<?php echo "$msg->id";?>" />
                         <button type="submit">Restore</button>
                      </form>
                  </td>
               </tr>
            <?php 
            $i++;
            }
         }
         if ($i == 1) { ?>
            <tr>
               <td colspan=3>You have no recycled messages</td>
            </tr>
         <?php }
      ?>
      </table>
   </div>
</div>

</div><!-- wrap -->
<script type="text/javascript" src="/wp-admin/js/tinybox.js"></script>
<?php require(ABSPATH . 'wp-admin/admin-footer.php'); ?>