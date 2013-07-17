<!--Queries projects based on userid -->
<?php
   $storyQuery = "SELECT * from wp_stories WHERE proj_ID = '$pid'";
   $stories = $wpdb->get_results($storyQuery);
   $count = count($stories);
?>

<div id="iceboxWidget" class="projectPageWidget"> <!-- id="currentProjects" -->
    <h3>Icebox <input type="button" class="addStory" value="Add Story" /></h3>
    <table class="list-stories" cellspacing=0 cellpadding=0> 
        <?php
         foreach($stories as $story) { ?>
            <tr id="story<?php echo $story->ID; ?>" class="story-row <?php echo $story->priority; ?>">
               <td class="story-img"><img src="story-image-sprite.png" /></td>
               <td class="story-name"><?php echo $story->name; ?></td>
               <td class="story-points"><?php echo $story->points; ?></td>
            </tr>
            <?php 
         }?>
    </table>
    
</div>

<div class="clear"></div>

<script type="text/javascript">
  //Jquery to delegate click event
  $(function() {
    $(".list-stories").delegate('tr', 'click', function() {
        console.log(this);
    });
    /*$( "#currentProjects" ).accordion({
      collapsible: true,
      animated: false,
      heightStyle: "content"
    });*/
  });
</script>




