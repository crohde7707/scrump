<?php
/**
 * Dashboard Administration Screen
 *
 * @internal This file should be parseable by PHP4.
 *
 * @package WordPress
 * @subpackage Administration
 */

/** Load WordPress Bootstrap */
require_once('./admin.php');
/** Load WordPress dashboard API */
session_start();
add_thickbox();

$user_id = get_current_user_id(); //user id
$user_info = get_userdata($user_id); //all info inside wp_usermeta table



global $wpdb;

/*************** checks if the user is a admin *****************************/
$query = "select * from wp_users where ID = '$user_id'";
$uinfo = $wpdb->get_row($query);

// if not a admin sends back to main site.
if(strcmp($uinfo-> site_role, "Admin") != 0 || $uinfo-> locked == 1) { 
echo '<script type="text/javascript">
<!--
window.location = "http://www.ehisys.org/"
//-->
</script>';
    die();
} 
/**************************************************************************/
  
$title = __('Manage Users');
$parent_file = 'index.php';

include (ABSPATH . 'wp-admin/admin-header.php');

$today = current_time('mysql', 1);

include (ABSPATH . 'wp-admin/menuBar.php'); 
?>
<head>
<div class="wrap">

<h2><?php echo esc_html( $title ); ?></h2>

  <script>
  jQuery(document).ready(function() {
    $( "#accordion" )
      .accordion({
        header: "> div > h3",
        collapsible: true,
        active: false,
        heightStyle: "content"
      })
      .sortable({
        axis: "y",
        handle: "h3",
        stop: function( event, ui ) {
          // IE doesn't register the blur when sorting
          // so trigger focusout handlers to remove .ui-state-focus
          ui.item.children( "h3" ).triggerHandler( "focusout" );
        }
      });
  });
 </script>
 
 <style>
  #accordion {
    padding: 10px;
    width: 500px;
    max-height: 700px;
  }
  </style>
</head>
<body>

<?php
require ('autocomplete-search.php');

/****Examples! do not pay any attention to*****/
/*$query = "select * from wp_users";
$uinfo = $wpdb->get_results($query);


$return_arr = array();
foreach ( $uinfo as $result ) 
{
    echo "<p>". $result->user_email ."</p>";
}
*/

/*querys for accordian*/
$query = "select * from wp_users where site_role = 'Manager'";
$managers = $wpdb->get_results($query);

$query = "select * from wp_users where site_role = 'Developer'";
$developers = $wpdb->get_results($query);


$query = "select * from wp_users where locked = '1'";
$locked = $wpdb->get_results($query);

$query = "select * from wp_users where locked = '0'";
$unlocked = $wpdb->get_results($query);

$query = "select * from wp_users";
$all = $wpdb->get_results($query);

?>

<!--accordian for admin info-->
<div id="accordion">
  <div class="group">
    <h3>Display All Accounts</h3>
    <div>
    <table>
    <?php
        foreach ( $all as $result ) 
        {  
         ?>   
            <form action="manageusers.php" method ="POST" >
            <tr>
              <td>  <? echo $result->user_email; ?> </td>
                <input id="emailsearch" name="email" type="hidden" value="<? echo $result->user_email; ?>"/> 
                <td> <input type="submit" name="go" value="EDIT"></td>
            </tr>
            
            </form>
        <?php 
        }
        ?>
        </table>
    </div>
  </div>
  <div class="group">
    <h3>Display All Managers</h3>
    <div>
    <table>
    <?php
        foreach ( $managers as $result ) 
        {  
         ?>   
            <form action="manageusers.php" method ="POST" >
            <tr>
                <td> <? echo $result->user_email; ?></td>
                <input id="emailsearch" name="email" type="hidden" value="<? echo $result->user_email; ?>"/> 
                <td> <input type="submit" name="go" value="EDIT"></td>
            </tr>
            </form>
        <?php 
        }
        ?>
        </table>
    </div>
  </div>
  <div class="group">
    <h3>Display All Developers</h3>
    <div>
    <table>
    <?php
        foreach ( $developers as $result ) 
        {  
         ?>   
         <form action="manageusers.php" method ="POST" >
         <tr>
            <td><? echo $result->user_email; ?></td>
            <input id="emailsearch" name="email" type="hidden" value="<? echo $result->user_email; ?>"/> 
            <td><input type="submit" name="go" value="EDIT"></td>
        </tr>
        </form> 
        <?php 
        }
        ?>  
        </table>
    </div>
  </div>
  <div class="group">
    <h3>Display All Unlocked Accounts</h3>
    <div>
    <table>
    <?php
        foreach ( $unlocked as $result ) 
        {  
         ?>
         <form action="manageusers.php" method ="POST" >
         <tr>
            <td><? echo $result->user_email; ?></td>
            <input id="emailsearch" name="email" type="hidden" value="<? echo $result->user_email; ?>"/> 
            <td><input type="submit" name="go" value="EDIT"></td>
        </tr>
        </form>

        <?php 
        }
        ?>
        </table>
    </div>
  </div>
  <div class="group">
    <h3>Display All Locked Accounts</h3>
    <div>
    <table>
    <?php
        foreach ( $locked as $result ) 
        {  
         ?>
         <form action="manageusers.php" method ="POST" >
         <tr>
            <td><? echo $result->user_email; ?></td>
            <input id="emailsearch" name="email" type="hidden" value="<? echo $result->user_email; ?>"/> 
            <td><input type="submit" name="go" value="EDIT"></td>
        </tr>
        </form>
        <?php 
        }
        ?>
        </table>
    </div>
  </div>  
</div>


</body>

</div><!-- dashboard-widgets-wrap -->
</div><!-- wrap -->
<?php  require(ABSPATH . 'wp-admin/admin-footer.php'); ?>