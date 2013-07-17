<!--Queries projects based on userid -->
<?php
   $projQuery = "Select * from wp_proj where owner_ID = '$user_id'"; //queries db for projects owned by logged in user
   $ownedProjects = $wpdb->get_results($projQuery); //executes query, ownedProjects now has all rows that are owned by logged in user
   $count = count($ownedProjects); //holds number of rows in ownedProjects

?>
<div id="newProject">
    <form action="updat.php" method="post" id="newProject">
        <input type="hidden" name="uid" value="<?php echo "$user_id";?>" />
        <input type="hidden" name="section" value="newProject">
        <label for="projName" ><?php _e('Project Name:') ?><br />
            <input type="text" name="projName" id="projName" class="input" size="25" />
        </label><br />
        <label for="projDesc" ><?php _e('Project Description:') ?><br />
            <textarea name="projDesc" id="projDesc" class="input" rows="10" cols="50"></textarea>
        </label><br />
        <button type="submit">Create</button>
    </form>
</div>
<div id="ownedProjects" class="projectWrapper"> <!-- id="currentProjects" -->
    <!-- Your choice on how you want to display the data, as a table with multiple columns or as an ordered list, table would probably be easier to spit out data for styling -->
    <!-- Have a look at inbox.php for an example of looping through a query object -->
    <h3>Projects Owned</h3>
    <table class="list-projects" cellspacing=0 cellpadding=0> 
        <thead>
            <td>Project</td>
            <td>Owner</td>
            <td>Link</td>
        </thead>
        <?php
         $i = 1;
         foreach($ownedProjects as $proj) {
            if(strcmp($proj->owner_ID, $user_id) == 0) {
               if($i % 2 != 0) {?>
                <tr class="odd">
               <?php } else { ?>
                <tr class="even">
               <?php } ?>
               <td class="projName"><?php echo "$proj->name"; ?></td>
               <td class="projEmail"><?php echo "$user_info->user_email"; ?></td>
               <td class="projLink"><a href="projLanding.php?pid=<?php echo $proj->ID;?>">Go to Project</a></td>
            <?php 
            $i++;
            }
         }
         if($i == 1) { ?>
            <tr class="odd">
              <td colspan="3">You currently own 0 projects</td>
            </tr>
         <?php } ?>
    </table>
    
</div>

<div class="clear"></div>

<script type="text/javascript">
  $(function() {
    $( "#ownedProjects" ).accordion({
      collapsible: true,
      animated: false,
      heightStyle: "content"
    });
     
    $( "#newProject" ).dialog({
      autoOpen: false,
      height: 350,
      width: 450,
      modal: true,
      collapsible: true,
      animated: false,
      heightStyle: "content"
    });

    $('#createProject').on('click', function() {
       $("#newProject").dialog('open');
    });
  });
  
</script>




