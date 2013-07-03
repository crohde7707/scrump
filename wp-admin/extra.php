<!--Queries projects based on userid -->
<?php
   $projQuery = "Select * from wp_proj where owner_ID = '$user_id'"; //queries db for projects owned by logged in user
   $ownedProjects = $wpdb->get_results($projQuery); //executes query, ownedProjects now has all rows that are owned by logged in user
   $count = count($ownedProjects); //holds number of rows in ownedProjects
   
   //attributes of ownedProjects
   //$ownedProjects->ID, $ownedProjects->owner_ID, $ownedProjects->name, $ownedProjects->description
?>

<div id="ownedProjects"> <!-- id="currentProjects" -->
    <!-- Your choice on how you want to display the data, as a table with multiple columns or as an ordered list, table would probably be easier to spit out data for styling -->
    <!-- Have a look at inbox.php for an example of looping through a query object -->
    <h3>Test Header<h3>
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
               <td class="projLink"><a href="projLanding.php?pid=2">Go to Project</a></td>
            <?php 
            $i++;
            }
         }?>
    </table>
    
</div>

<div class="clear"></div>






