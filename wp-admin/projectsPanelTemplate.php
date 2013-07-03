<?php
   $projQuery = "Select * from wp_proj where owner_ID = '$user_id'"; //queries db for projects owned by logged in user
   $ownedProjects = $wpdb->get_results($projQuery); //executes query, ownedProjects now has all rows that are owned by logged in user
   $count = count($ownedProjects); //holds number of rows in ownedProjects
   
   //$ownedProjects->ID, $ownedProjects->owner_ID, $ownedProjects->name, $ownedProjects->description
?>

<div id="ownedProjects"> <!-- id="currentProjects" -->
    <!-- Your choice on how you want to display the data, as a table with multiple columns or as an ordered list, table would probably be easier to spit out data for styling -->
    <!-- Have a look at inbox.php for an example of looping through a query object -->
</div>

<div class="clear"></div>