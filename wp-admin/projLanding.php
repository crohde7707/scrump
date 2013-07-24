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

/*************** Add query to update user role in database ****************/
$pid = $_GET['pid'];

$pQuery = "SELECT * from wp_proj where ID = '$pid'";
$proj = $wpdb->get_row($pQuery);

$rQuery = "SELECT role FROM wp_roles where proj_ID = '$pid' AND user_ID = '$user_id'";
$role = $wpdb->get_var($rQuery);

$query = "select * from wp_users where ID = '$user_id'";
$uinfo = $wpdb->get_row($query);

$storyQuery = "SELECT * from wp_stories WHERE proj_ID = '$pid' ORDER BY priority DESC";
$stories = $wpdb->get_results($storyQuery);
$count = count($stories);

$cQuery = "SELECT * FROM wp_stories s INNER JOIN wp_sprint r ON r.ID = s.sprint_ID WHERE r.completed_date != '0000-00-00 00:00:00' AND r.completed_date < NOW() AND s.proj_ID = '$pid'";
$comp = $wpdb->get_results($cQuery);

/**************************************************************************/
  
$title = __(' Dashboard for: ' . $proj->name );

$parent_file = 'landing.php';

include (ABSPATH . 'wp-admin/admin-header.php');

$today = current_time('mysql', 1);

include (ABSPATH . 'wp-admin/menuBar.php'); 
?>


<div class="wrap">
    <h2><?php echo esc_html( $title ); ?> <input type="button" id="editProjButton" value="Edit Project" /></h2>
    <div id="editProject">
        <h3>Edit Project: <?php echo $proj->name; ?></h3> 
        <form method="POST" name="eProject" action="updat.php">
            <input type="hidden" name="section" value="editProject"/>
            <input type="text" size="40" name="projName" value="<?php echo $proj->name; ?>"/>
            <input type="text" size="40" name="projFinishDate" value="<?php echo $proj->finishDate; ?>"/>
            <textarea rows="30" cols="80" name="projDescription"><?php echo $proj->description; ?></textarea>
            <button type="submit">Save</button>
        </form>
    </div>
    <?php if($uinfo->locked) {?>
    <h3>Your account is locked asds</h3>
    <?php } else { ?>
    <h3 style="margin:0">Role: <?php echo $role; ?>  <a href="listmembers.php?pid=<?php echo $proj->ID;?>">List of Members</a></h3>
    <div class="working">
        <div class="swipeWrap"><?php
            include (ABSPATH . 'wp-admin/widget/icebox.php');
   
            include (ABSPATH . 'wp-admin/widget/backlog.php');
            
            include (ABSPATH . 'wp-admin/widget/sprint.php');
        ?>
        </div>
        <div class="story-input"></div>
    </div>
    <div class="completed">
        <?php
            include (ABSPATH . 'wp-admin/widget/completed.php');
        ?>
    </div>
<?php } ?>
<!--Delete button at the bottom of the page -->
<input type="button" id="deleteProjButton" value="Delete Project" />
    <div id="deleteProject">
        <h3>Are you sure you want to delete this project?</h3> 
        <form method="POST" name="dProject" action="updat.php">
            <input type="hidden" name="delete" value="deleteProject"/>
            <input type="button" id="deleteYes" value="Yes" />
            <input type="button" id="deleteNo" value="No" />
            <!--<button type="submit">Yes</button>-->
        </form>
    </div>

</div><!-- dashboard-widgets-wrap -->
</div><!-- wrap -->
<script type="text/javascript">
  //Jquery to delegate click event
  $(function() {
    $( ".story-input" ).dialog({
          width: 600,
          height: 500,
          modal : true,
          autoOpen: false
    });
    
    $(".list-stories").delegate('.story-row', 'click', function() {
        $(".story-input").dialog('open');
    });
  
    $( "#editProject" ).dialog({
          width: 600,
          height: 500,
          modal : true,
          autoOpen: false
    });
    
    $("#editProjButton").on('click', function() {
        $("#editProject").dialog('open');
    });
  
  //delete button
    $( "#deleteProject" ).dialog({
          width: 600,
          height: 500,
          modal : true,
          autoOpen: false
    });
    
    $("#deleteProjButton").on('click', function() {
        $("#deleteProject").dialog('open');
    });
    
    window.mySwipe = $('#mySwipe').Swipe().data('Swipe');
  });
</script>
<?php  require(ABSPATH . 'wp-admin/admin-footer.php'); ?>
