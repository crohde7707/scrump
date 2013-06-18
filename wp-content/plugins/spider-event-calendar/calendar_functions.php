<?php 

if(!current_user_can('manage_options')) {
	die('Access Denied');
}	

function add_spider_calendar(){
html_add_spider_calendar();
}

function show_spider_calendar(){
		global $wpdb;
	$sort["default_style"]="manage-column column-autor sortable desc";
	if(isset($_POST['page_number']))
	{
			
			if($_POST['asc_or_desc'])
			{
				$sort["sortid_by"]=$_POST['order_by'];
				if($_POST['asc_or_desc']==1)
				{
					$sort["custom_style"]="manage-column column-title sorted asc";
					$sort["1_or_2"]="2";
					$order="ORDER BY ".$sort["sortid_by"]." ASC";
				}
				else
				{
					$sort["custom_style"]="manage-column column-title sorted desc";
					$sort["1_or_2"]="1";
					$order="ORDER BY ".$sort["sortid_by"]." DESC";
				}
			}
			
	if($_POST['page_number'])
		{
			$limit=($_POST['page_number']-1)*20; 
		}
		else
		{
			$limit=0;
		}
	}
	else
		{
			$limit=0;
		}
	if(isset($_POST['search_events_by_title'])){
		$search_tag=$_POST['search_events_by_title'];
		}
		
		else
		{
		$search_tag="";
		}
	if ( $search_tag ) {
		$where= ' WHERE title LIKE "%'.$search_tag.'%"';
	}	
	else
	{
		$where=' ';
	}
	
	// get the total number of records
	$query = "SELECT COUNT(*) FROM ".$wpdb->prefix."spidercalendar_calendar". $where;
	$total = $wpdb->get_var($query);
	$pageNav['total'] =$total;
	$pageNav['limit'] =	 $limit/20+1;
	
	$query = "SELECT * FROM ".$wpdb->prefix."spidercalendar_calendar".$where." ". $order." "." LIMIT ".$limit.",20";
	$rows = $wpdb->get_results($query);
	
    // display function
	html_show_spider_calendar($rows, $pageNav,$sort);
}



function edit_spider_calendar($id){
	
	global $wpdb;
	$row =$wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'spidercalendar_calendar WHERE id=\''.$id.'\'');
	
	html_edit_spider_calendar($row);




}




function save_spider_calendar(){
	global $wpdb;
	
	$save_or_no= $wpdb->insert($wpdb->prefix.'spidercalendar_calendar', array(
		'id'	=> NULL,
        'title'     => stripslashes($_POST["title"]),
        'gid'    => $_POST["user_type"],
		'start_month' => $_POST["start_month"],
        'time_format'  =>$_POST["time_format"],
        'allow_publish'   => $_POST["allow_publish"],
		'published'=>$_POST["published"],
                ),
				array(
				'%d',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',	
				'%d'					
				)
                );
					if(!$save_or_no)
	{
		?>
	<div class="updated"><p><strong><?php _e('Error. Please install plugin again'); ?></strong></p></div>
	<?php
		return false;
	}
	?>
	<div class="updated"><p><strong><?php _e('Item Saved'); ?></strong></p></div>
	<?php
	
    return true;
	
	
	
	
	
	
	
	
	}


function remove_spider_calendar($id){
  global $wpdb;

  // If any item selected
  
    // Prepare sql statement, if cid array more than one, 
    // will be "cid1, cid2, ..."
    // Create sql statement
	 $sql_remov_vid="DELETE FROM ".$wpdb->prefix."spidercalendar_calendar WHERE id='".$id."'";
	 $sql_remov_eve="DELETE FROM ".$wpdb->prefix."spidercalendar_event WHERE calendar='".$id."'";
 if(!$wpdb->query($sql_remov_vid))
 {
	  ?>
	  <div id="message" class="error"><p>Calendar Not Deleted</p></div>
      <?php
	 
 }
 else{
	 
 ?>
 <div class="updated"><p><strong><?php _e('Calendar Deleted.' ); ?></strong></p></div>
 <?php
 $count_eve=$wpdb->get_var('SELECT COUNT(*) FROM '.$wpdb->prefix.'spidercalendar_event WHERE calendar='.$id);
	if($count_eve){
 	if(!$wpdb->query($sql_remov_eve))
	 {
	  ?>
	  <div id="message" class="error"><p>Events Not Deleted</p></div>
      <?php
	 
 	 }
 }
 }

}

















function apply_spider_calendar($id)
{
if(!$id)
{
	echo '<h1 style="color:#00C">error valu id=0 please reinstal plugin</h1>';
	exit;
}

global $wpdb;
$save_or_no= $wpdb->update($wpdb->prefix.'spidercalendar_calendar', array(
	 
	   'title'     => stripslashes($_POST["title"]),
        'gid'    => $_POST["user_type"],
        'time_format'  =>$_POST["time_format"],
		'start_month' => $_POST["start_month"],
        'allow_publish'   => $_POST["allow_publish"],
		'published'=>$_POST["published"],
                ),
				array('id'=>$id),
				array(
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',	
				'%d'					
				)
                );
				?>
				<div class="updated"><p><strong><?php _e('Item Saved'); ?></strong></p></div>

	<?php

}
 
 function spider_calendar_published($id)
 {
	 		 global $wpdb;
			 $yes_or_no=$wpdb->get_var('SELECT published FROM '.$wpdb->prefix.'spidercalendar_calendar WHERE `id`='.$id);
			 if( $yes_or_no)
			 $yes_or_no=0;
			 else
			 $yes_or_no=1;
		 $save_or_no= $wpdb->update($wpdb->prefix.'spidercalendar_calendar', array(
        'published'  => $yes_or_no,
        
                ),
				array('id'=>$id),
				array(
				'%d',				
				)
                );
				?>
				<div class="updated"><p><strong><?php _e('Item Saved'); ?></strong></p></div>
                <?php
	 
 }




















////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////   event
////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////





function show_spider_event($calendar_id){
	
	
		global $wpdb;
	$sort["default_style"]="manage-column column-autor sortable desc";
	if(isset($_POST['page_number']))
	{
			
			if($_POST['asc_or_desc'])
			{
				$sort["sortid_by"]=$_POST['order_by'];
				if($_POST['asc_or_desc']==1)
				{
					$sort["custom_style"]="manage-column column-title sorted asc";
					$sort["1_or_2"]="2";
					$order="ORDER BY ".$sort["sortid_by"]." ASC";
				}
				else
				{
					$sort["custom_style"]="manage-column column-title sorted desc";
					$sort["1_or_2"]="1";
					$order="ORDER BY ".$sort["sortid_by"]." DESC";
				}
			}
			
	if($_POST['page_number'])
		{
			$limit=($_POST['page_number']-1)*20; 
		}
		else
		{
			$limit=0;
		}
	}
	else
		{
			$limit=0;
		}
	if(isset($_POST['search_events_by_title'])){
		$search_tag=$_POST['search_events_by_title'];
		}
		
		else
		{
		$search_tag="";
		}
	if ( $search_tag ) {
		$where= ' AND title LIKE "%'.$search_tag.'%"';
	}	
	if(isset($_POST['startdate'])){
		if($_POST['startdate'])
		$where.=' AND date > \''.$_POST['startdate'].'\' ';
	}
	if(isset($_POST['enddate'])){
		if($_POST['enddate'])
		$where.=' AND date < \''.$_POST['enddate'].'\' ';
	}
	
	// get the total number of records
	$query = "SELECT COUNT(*) FROM ".$wpdb->prefix."spidercalendar_event WHERE calendar=".$calendar_id." ".$where." ";
	$total = $wpdb->get_var($query);
	$pageNav['total'] =$total;
	$pageNav['limit'] =	 $limit/20+1;
	
	$query = "SELECT * FROM ".$wpdb->prefix."spidercalendar_event WHERE calendar=".$calendar_id." ".$where." ". $order." "." LIMIT ".$limit.",20";
	$rows = $wpdb->get_results($query);
	$cal_name=$wpdb->get_var('SELECT title'.' FROM '.$wpdb->prefix.'spidercalendar_calendar WHERE id='. $calendar_id);
	
    // display function
	html_show_spider_event($rows, $pageNav,$sort,$calendar_id,$cal_name);





}



function add_spider_event($calendar_id){
	
	global $wpdb;
	$cal_name=$wpdb->get_var('SELECT title'.' FROM '.$wpdb->prefix.'spidercalendar_calendar WHERE id='. $calendar_id);
	html_add_spider_event($calendar_id,$cal_name);
	
	
	
	
}


function edit_spider_event($calendar_id,$id){
	global $wpdb;

	$row =$wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'spidercalendar_event WHERE id=\''.$id.'\'');


	
	
	$calendar=$row->calendar;
	$query = 'SELECT title'.' FROM '.$wpdb->prefix.'spidercalendar_calendar WHERE id='. $calendar	;
	$calendar_name = $wpdb->get_var($query);
	$cal_name=$wpdb->get_var('SELECT title'.' FROM '.$wpdb->prefix.'spidercalendar_calendar WHERE id='. $calendar_id);
	html_edit_spider_event($row,$calendar_id,$id,$cal_name);
}

function save_spider_event($calendar_id){
	
	
	global $wpdb;
	
		$date=$_POST['date'];
	$date_end=$_POST['date_end'];
	$select_from=$_POST['select_from'];
	$select_to=$_POST[ 'select_to'];
	
	
	
	if(isset($_POST['selhour_from']))
		$selhour_from=$_POST['selhour_from'];
	else
		$selhour_from="";
	if(isset($_POST['selhour_to']))
		$selhour_to=$_POST['selhour_to'];
	else
		$selhour_to="";
	
	
	if($selhour_from)
	{
	if($selhour_to)
		$time = $selhour_from.':'.$_POST['selminute_from'].''.$select_from.' -'.$_POST[ 'selhour_to'].':'.$_POST[ 'selminute_to'].' '.$select_to;
	else
		$time = $selhour_from.':'.$_POST['selminute_from'].' '.$select_from;
	}
	else
	$time ="";
	
	
	
	
	
if(!$_POST["date_end"]){
	$date_end = $_POST["date"];
}
else $date_end = $_POST["date_end"];
	
	$save_or_no= $wpdb->insert($wpdb->prefix.'spidercalendar_event', array(
		'id'				=> NULL,
        'title'    			=> stripslashes($_POST["title"]),
		'time'	   		    => $time,
		'calendar'    		=> $calendar_id,
		'date'     			=> $_POST["date"],
		'text_for_date'     => stripslashes($_POST["text_for_date"]),
		'published'    	 	=> $_POST["published"],
		'repeat'     		=> $_POST["repeat"],
		'week'     			=> $_POST["week"],
		'date_end'     		=> $date_end,
		'month'     		=> $_POST["month"],
		'monthly_list'    	=> $_POST["monthly_list"],
		'month_week'     	=> $_POST["month_week"],
		'month_type'     	=> $_POST["month_type"],
		'year_month'     	=> $_POST["year_month"],
		'repeat_method'     	=> $_POST["repeat_method"],
		'userID'			=> ''

                ),
				array(
				'%d',
				'%s',
				'%s',
				'%d',
				'%s',	
				'%s',
				'%d',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',	
				'%s',
				'%s',
				'%s',	
				'%s',
				'%s'				
				)
                );
					if(!$save_or_no)
	{
		?>
	<div class="updated"><p><strong><?php _e('Error. Please install plugin again'); ?></strong></p></div>
	<?php
		return false;
	}
	?>
	<div class="updated"><p><strong><?php _e('Item Saved'); ?></strong></p></div>
	<?php
	
    return true;
	
	
	
	
	
}
function apply_spider_event($calendar_id,$id){
	

	global $wpdb;
	
		$date=$_POST['date'];
	$date_end=$_POST['date_end'];
	$select_from=$_POST['select_from'];
	$select_to=$_POST[ 'select_to'];
	
	
	
	if(isset($_POST['selhour_from']))
		$selhour_from=$_POST['selhour_from'];
	else
		$selhour_from="";
	if(isset($_POST['selhour_to']))
		$selhour_to=$_POST['selhour_to'];
	else
		$selhour_to="";
	
	
	if($selhour_from)
	{
	if($selhour_to)
		$time = $selhour_from.':'.$_POST['selminute_from'].''.$select_from.'-'.$_POST[ 'selhour_to'].':'.$_POST[ 'selminute_to'].''.$select_to;
	else
		$time = $selhour_from.':'.$_POST['selminute_from'].' '.$select_from;
	}
	else
	$time ="";
	
	
	
	
	

	
$wpdb->update($wpdb->prefix.'spidercalendar_event', array(
        'title'    			=> stripslashes($_POST["title"]),
		'time'	   		    => $time,
		'calendar'    		=> $calendar_id,
		'date'     			=> $_POST["date"],
		'text_for_date'     => stripslashes($_POST["text_for_date"]),
		'published'    	 	=> $_POST["published"],
		'repeat'     		=> $_POST["repeat"],
		'week'     			=> $_POST["week"],
		'date_end'     		=> $_POST["date_end"],
		'month'     		=> $_POST["month"],
		'monthly_list'    	=> $_POST["monthly_list"],
		'month_type'     	=> $_POST["month_type"],
		'month_week'     	=> $_POST["month_week"],
		'year_month'     	=> $_POST["year_month"],
		'repeat_method'     => $_POST["repeat_method"]
		


                ),
				array('id'	=>$id,),
				array(

				'%s',
				'%s',
				'%d',
				'%s',	
				'%s',
				'%d',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',	
				'%s',	
				'%s'		
				)
                );


	?>
	<div class="updated"><p><strong><?php _e('Item Saved'); ?></strong></p></div>
	<?php
	
    return true;
	
	
	
	
	
}

function published_spider_event($id)
 {
	 		 global $wpdb;
			 $yes_or_no=$wpdb->get_var('SELECT published FROM '.$wpdb->prefix.'spidercalendar_event WHERE `id`='.$id);
			 if( $yes_or_no)
			 $yes_or_no=0;
			 else
			 $yes_or_no=1;
		 $save_or_no= $wpdb->update($wpdb->prefix.'spidercalendar_event', array(
        'published'  => $yes_or_no,
        
                ),
				array('id'=>$id),
				array(
				'%d',				
				)
                );
				?>
				<div class="updated"><p><strong><?php _e('Item Saved'); ?></strong></p></div>
                <?php
	 
 }

function remov_spider_event($calendar_id,$id){
	 global $wpdb;

  // If any item selected
  
    // Prepare sql statement, if cid array more than one, 
    // will be "cid1, cid2, ..."
    // Create sql statement
	 $sql_remov_vid="DELETE FROM ".$wpdb->prefix."spidercalendar_event WHERE id='".$id."'";
 if(!$wpdb->query($sql_remov_vid))
 {
	  ?>
	  <div id="message" class="error"><p>Event Not Deleted</p></div>
      <?php
	 
 }
 else{
 ?>
 <div class="updated"><p><strong><?php _e('Item Deleted.' ); ?></strong></p></div>
 <?php
 }

	
}



 ?>