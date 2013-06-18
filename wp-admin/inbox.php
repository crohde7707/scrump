<?php

/** Load WordPress Bootstrap */
require_once('./admin.php');

/** Load WordPress dashboard API */
require_once(ABSPATH . 'wp-admin/includes/dashboard.php');

wp_dashboard_setup();

wp_enqueue_script( 'dashboard' );
if ( current_user_can( 'edit_theme_options' ) )
	wp_enqueue_script( 'customize-loader' );
if ( current_user_can( 'install_plugins' ) )
	wp_enqueue_script( 'plugin-install' );
if ( current_user_can( 'upload_files' ) )
	wp_enqueue_script( 'media-upload' );
add_thickbox();

if ( wp_is_mobile() )
	wp_enqueue_script( 'jquery-touch-punch' );

  $user_id = get_current_user_id();
  $user_info = get_userdata($user_id);  
  
$title = __('Inbox');
$parent_file = 'landing.php';



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
  .msg { width:75%; }
  .ui-tabs { padding: 0; }
  .ui-tabs-vertical { width: 90%; }
  .ui-tabs-vertical .ui-tabs-nav { padding: .2em .1em .2em .2em; float: left; width: 16%; }
  .ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important; margin: 0 -1px .2em 0; }
  .ui-tabs-vertical .ui-tabs-nav li a { display:block; width:83%; }
  .ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active { padding-bottom: 0; padding-right: .1em; border-right-width: 1px; border-right-width: 1px; }
  .ui-tabs-vertical .ui-tabs-panel { padding: 1em; float: left; width: 80%;}
</style>
<div class="wrap">
<?php include (ABSPATH . 'wp-admin/menuBar.php'); ?>
<h2><?php echo esc_html( $title ); ?> <?php if(strcmp($user_info->rpr_type_of_account, "Patient") != 0) {?><input style="font-size:13px; padding:4px;" type="button" onclick='TINY.box.show({url:"compose.php",animate:false,mask:false,boxid:"appt"})' value="Compose" /><?php } ?></h2>
<?php
global $wpdb;

if(isset($_POST['action'])) {
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
}

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
            <td class="msg">Message</td>
            <td>Action</td>
         </tr>
      <?php
         $i = 1;
         foreach($messages as $msg) {
            if(strcmp($msg->active, 1) == 0) { ?>
               <tr>
                  <td><?php echo "$i";?></td>
                  <td class="msg"><?php echo "$msg->msg";?></td>
                  <td><form action="inbox.php" method="post">
                         <input type="hidden" name="action" value="old" />
                         <input type="hidden" name="mid" value="<?php echo "$msg->id";?>" />
                         <button type="submit">Mark as Old</button>
                      </form><form action="inbox.php" method="post">
                         <input type="hidden" name="action" value="recycle" />
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
            <td class="msg">Message</td>
            <td>Action</td>
         </tr>
      <?php
         $i = 1;
         foreach($messages as $msg) {
            if(strcmp($msg->old, 1) == 0) { ?>
               <tr>
                  <td><?php echo "$i";?></td>
                  <td class="msg"><?php echo "$msg->msg";?></td>
                  <td><form action="inbox.php" method="post">
                         <input type="hidden" name="action" value="new" />
                         <input type="hidden" name="mid" value="<?php echo "$msg->id";?>" />
                         <button type="submit">Mark as New</button>
                      </form><form action="inbox.php" method="post">
                         <input type="hidden" name="action" value="recycle" />
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
            <td class="msg">Message</td>
            <td>Action</td>
         </tr>
      <?php
         $i = 1;
         foreach($messages as $msg) {
            if(strcmp($msg->recycled, 1) == 0) { ?>
               <tr>
                  <td><?php echo "$i";?></td>
                  <td class="msg"><?php echo "$msg->msg";?></td>
                  <td><form action="inbox.php" method="post">
                         <input type="hidden" name="action" value="new" />
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