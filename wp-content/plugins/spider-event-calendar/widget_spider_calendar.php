<?php


	


	class spider_calendar extends WP_Widget {

	// Constructor //

		function spider_calendar() {
			$widget_ops = array( 'classname' => 'spider_calendar', 'description' => 'Spider Calendar is a highly configurable product which allows you to have multiple organized events' ); // Widget Settings
			$control_ops = array( 'id_base' => 'spider_calendar' ); // Widget Control Settings
			$this->WP_Widget( 'spider_calendar', 'Spider Calendar', $widget_ops, $control_ops ); // Create the widget
		}

	// Extract Args //

		function widget($args, $instance) {
			extract( $args );
			$title=$instance['title'];
			$id=$instance['calendar'];
			$theme=$instance['theme'];
	// Before widget //
	echo $before_widget;

			
	// Title of widget //

			if ( $title ) { echo $before_title . $title . $after_title; }

	// Widget output //
	if($id)
	{
		$wiidget=1;
echo Spider_calendar_big_front_end($id,$theme,$wiidget);
	}
	// After widget //

			echo $after_widget;
		}






	// Update Settings //
	
	
	
	
	

		function update($new_instance, $old_instance) {
			$instance['title']					 = strip_tags($new_instance['title']);   // title
			$instance['calendar']				 = $new_instance['calendar']; /// Post quantity
			$instance['theme']					 = $new_instance['theme']; /// Post quantity

			return $instance;  /// return new value of parametrs
		}
		
		
		
		

	// Widget Control Panel //

		function form($instance) {
			global $wpdb;
		$defaults = array( 'title' => '', calendar => '0', theme => '3');
		$instance = wp_parse_args( (array) $instance, $defaults );
		$all_clendars=$wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'spidercalendar_calendar');
		$all_themes=$wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'spidercalendar_widget_theme');
		 ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>'" type="text" value="<?php echo $instance['title']; ?>" />
		</p>
       <table width="100%" class="paramlist admintable" cellspacing="1">
<tbody>

<tr>
<td style="width:120px" class="paramlist_key"><span class="editlinktip"><label style="font-size:10px" id="paramsstandcatid-lbl" for="Category" class="hasTip">Select Calendar</label></span></td>
<td class="paramlist_value">
<select name="<?php echo $this->get_field_name('calendar'); ?>" id="<?php echo $this->get_field_id('calendar') ?>" style="font-size:10px" class="inputbox">
<option value="0">Select Calendar</option>

<?php 

$sp_calendar=count($all_clendars);
for($i=0;$i<$sp_calendar;$i++)
{
?>


<option value="<?php echo $all_clendars[$i]->id?>" <?php if($instance['calendar']==$all_clendars[$i]->id) echo  'selected="selected"'; ?>><?php echo $all_clendars[$i]->title ?></option>

<?php
}
 ?>
</select>

</td>
</tr>
<tr>
<tr><td><br /></td></tr>

</tbody></table>
         <?php }
		

}

// End class spider_random_article

add_action('widgets_init', create_function('', 'return register_widget("spider_calendar");'));
?>