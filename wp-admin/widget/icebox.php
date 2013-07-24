<div id="iceboxWidget" class="projectPageWidget">
    <table class="list-stories" cellspacing=0 cellpadding=0> 
        <thead>
            <td colspan=3><h3>Icebox <input type="button" class="addStory" value="Add Story" /></h3></td>
        </thead>
        <?php
         foreach($stories as $story) { 
            if($story->container_ID == 1) {?>
               <tr id="story<?php echo $story->ID; ?>" class="story-row <?php echo $story->priority_class; ?>">
                  <td class="story-img <?php echo strtolower($story->type); ?>"></td>
                  <td class="story-name"><?php echo $story->name; ?></td>
                  <td class="story-points"><?php echo $story->points; ?></td>
               </tr>
            <?php } 
         }?>
    </table>
</div>




