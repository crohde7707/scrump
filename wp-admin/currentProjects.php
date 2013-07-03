<!--Queries projects based on userid -->
<?php
   $allQuery = "SELECT * FROM wp_proj p LEFT JOIN wp_roles r ON p.ID = r.proj_ID WHERE r.user_ID = '$user_id'";
   //$roleQuery = "Select projIDs from wp_roles where user_ID = '$user_id'";
   $currentProjects = $wpdb->get_results($allQuery);
   $count = count($currentProjects);
?>

<div id="currentProjects" class="projectWrapper"> <!-- id="currentProjects" -->
    <!-- Your choice on how you want to display the data, as a table with multiple columns or as an ordered list, table would probably be easier to spit out data for styling -->
    <!-- Have a look at inbox.php for an example of looping through a query object -->
    <h3>Current Projects</h3>
    <table class="list-projects" cellspacing=0 cellpadding=0> 
        <thead>
            <td>Project</td>
            <td>Owner</td>
            <td>Link</td>
        </thead>
        <?php
         $i = 1;
         foreach($currentProjects as $proj) {
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
         }?>
    </table>
    
</div>

<div class="clear"></div>

<script type="text/javascript">
  $(function() {
    $( "#currentProjects" ).accordion({
      collapsible: true,
      animated: false,
      heightStyle: "content"
    });
  });
</script>




