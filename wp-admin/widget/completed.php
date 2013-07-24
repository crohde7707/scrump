<div id="completedWidget" class="projectPageCompletedWidget">
    <table class="list-stories" cellspacing=0 cellpadding=0> 
        <thead>
            <td colspan=3><h3>Completed Sprints</h3></td>
        </thead>
        <tbody id="compList"><?php
         foreach($comp as $item) { ?>
               <!--<h3>Sprint <?php echo ($item->sprint_ID)-1; ?> <span style="float:right"><?php echo $item->completed_date; ?></span></h3>-->
               <!--<div>Stories Go here</div>-->
            <?php 
         }?>
         </tbody>
    </table>
    </div>


<!--<tr id="sprint<?php echo $item->sprint_ID; ?>" class="sprint-row">-->
                  <!--<td class="sprint-name">Sprint <?php echo ($item->sprint_ID)-1; ?></td>-->
                  <!--<td class="sprint-date"><?php echo $item->completed_date; ?></td>-->
                  <!--<td class="story-points"><?php echo $story->points; ?></td>-->
               <!--</tr>-->