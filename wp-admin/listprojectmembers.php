<!--Queries projects based on userid -->
<?php

   $allQuery = "SELECT * FROM wp_users u INNER JOIN wp_roles r ON u.ID = r.user_ID WHERE r.proj_ID = '$pid'";
   $currentProjects = $wpdb->get_results($allQuery);
   $count = count($currentProjects);
?>

<div id="currentMembers" class="membersWrapper"> <!-- id="currentProjects" -->
    <!-- Your choice on how you want to display the data, as a table with multiple columns or as an ordered list, table would probably be easier to spit out data for styling -->
    <!-- Have a look at inbox.php for an example of looping through a query object -->
    <h3>Current Members</h3>
    <table class="list-projects" cellspacing=0 cellpadding=0> 
        <thead>
            <td>Name</td>
            <td>Email</td>
            <td>Role</td>
            <td colspan="2"></td>
        </thead>
        <?php
         $i = 1;
         foreach($currentProjects as $proj) {
            if($i % 2 != 0) {?>
               <tr class="odd">
            <?php } else { ?>
               <tr class="even">
            <?php } ?>
               <td class="userName"><?php 
                    if($proj->user_firstName) {
                        echo $proj->user_firstName ." ". $proj->user_lastName ;
                    } else {
                        echo $proj->user_login;
                    } ?>
               </td>
               <td class="userEmail"><?php echo "$proj->user_email"; ?></td>
               <td class="userRole"><?php echo "$proj->role"; ?></td>
               <td><form action="listmembers.php?pid=<?php echo $proj->proj_ID;?>" method ="POST" >
                   <input id="emailsearch" name="email" type="hidden" value="<? echo $proj->user_email; ?>"/> 
                   <input type="submit" name="changeRole" value="CHANGE ROLE">
               </form></td>
               <td><form action="listmembers.php?pid=<?php echo $proj->proj_ID;?>" method ="POST" >
                   <input id="emailsearch" name="email" type="hidden" value="<? echo $proj->user_email; ?>"/> 
                   <input type="submit" name="remove" value="REMOVE">
               </form></td>
            <?php 
            $i++;
         }
         if($i == 1) { ?>
            <tr class="odd">
              <td colspan="3">There are currently no members</td>
            </tr>
         <?php } ?>
    </table>
    
</div>

<div class="clear"></div>




