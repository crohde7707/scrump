<?php  
$path  = ''; // It should be end with a trailing slash  
if ( !defined('WP_LOAD_PATH') ) {

	/** classic root path if wp-content and plugins is below wp-config.php */
	$classic_root = dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/' ;
	
	if (file_exists( $classic_root . 'wp-load.php') )
		define( 'WP_LOAD_PATH', $classic_root);
	else
		if (file_exists( $path . 'wp-load.php') )
			define( 'WP_LOAD_PATH', $path);
		else
			exit("Could not find wp-load.php");
}

// let's load WordPress
require_once( WP_LOAD_PATH . 'wp-load.php');
global $wpdb;
function IsDate_inputed( $str ){ 
    $stamp = strtotime( $str ); 
    if (!is_numeric($stamp)) 
        return FALSE; 
    $month = date( 'm', $stamp ); 
    $day   = date( 'd', $stamp ); 
    $year  = date( 'Y', $stamp ); 
    if (checkdate($month, $day, $year)) 
        return TRUE; 
    return FALSE; 
}
require_once("functions_spidercalendarbig_seemore.php");

 $theme_id =$_GET['theme_id'];
 
 
 
 if(isset($_GET['widget']))
{
	$widget=1;
}
else
{
	$widget=0;
}
if($widget)
{
$theme 	=$wpdb->get_row($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'spidercalendar_widget_theme WHERE id=%d',$theme_id));
}
else
$theme 	=$wpdb->get_row($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'spidercalendar_theme WHERE id=%d',$theme_id));
 $path_sp_cal=$_GET['cur_page_url'];


	
 

  	 	 $title_color='#'.'000';
		 
		 $title_size='';
		 
		 $title_font='';
		 
		 $title_style='normal';
		 
		 $date_color='#'.'000';
		 
		 $date_size=16;
		 
		 $date_font='';
		 
		 $date_style='bold';
		 
		 $next_prev_event_bgcolor='#'.'FFA142';
		 $next_prev_event_arrowcolor='#'.'FFFFFF';
		 $show_event_bgcolor='#'.'36A7E9';
		 
		 $popup_width ='800';
		 $popup_height ='600';
		 
		 
		 $date_format='w/d/m/y';
		 
		 $show_repeat=1;
		 
		 
 		$all_files=php_showevent();
		$rows=$all_files[0]['rows'];
        $option=$all_files[0]['option'];
		
		if(isset($_GET['date'])){
			if(IsDate_inputed($_GET['date']))
			$datee=$_GET['date'];
			else
			$datee=date("Y-m-d");
		}
		else
		{
			$datee=date("Y-m-d");
		}
		$activedate=explode('-',$datee);				
		$activedatetimestamp = mktime(0, 0, 0, $activedate[1], $activedate[2], $activedate[0]);				
		$activedatestr=date("l",$activedatetimestamp).', '.date("d",$activedatetimestamp).' '.date("F",$activedatetimestamp).', '.date("Y",$activedatetimestamp);		
		$date =  $datee;
		$day = substr($date,8);
		if(isset($_GET['calendar_id']))
		$calendar_id	=$_GET['calendar_id'];
		else
		$calendar_id	=0;
		 $ev_ids =$_GET['ev_ids'];
	
    $ev_id = explode(',',$ev_ids);

 
 
   


$eventID=$_GET['eventID'];
 
 ?>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
  <script>
  
  
  function next(day_events,ev_id,theme_id,calendar_id,date,day)
  {

  
	
	  var p=0;
	   for (var key in day_events)
	   {	  p=p+1;
		   if(day_events[key]==ev_id && day_events[parseInt(key) +1])
		   {
				   
					
				   window.location='<?php echo plugins_url("spidercalendarbig.php",__FILE__) ?>?theme_id='+theme_id+'&calendar_id='+calendar_id+'&eventID='+day_events[parseInt(key) +1]+'&date='+date+'&day='+day<?php if($widget)echo "+'&widget=1'" ?>;
		  
		   }
		 	   		   
	  }

	  
  }
  
  
  function change()
  {
  
  $('#dayevent').ready(function() {
  $('#dayevent').animate({
      
    opacity: 1,
	
    marginLeft: "0in",
	
   
  }, 1000, function() {
  

    
  });
});
  
  }

  window.onload=change();
  
  function prev(array1,ev_id,theme_id,calendar_id,date,day)
  {
   var day_events = array1;
 
	   for (var key in day_events)
	   {	  
		   if(day_events[key]==ev_id && day_events[parseInt(key) -1] )
		   {
				   
					
				   window.location='<?php echo plugins_url("spidercalendarbig.php",__FILE__) ?>?theme_id='+theme_id+'&calendar_id='+calendar_id+'&eventID='+day_events[parseInt(key) -1]+'&date='+date+'&day='+day<?php if($widget)echo "+'&widget=1'" ?>;
		   }
	  }
	  
  
  
  
  }
  
  
  document.onkeydown = function(evt) {
    evt = evt || window.event;
    if (evt.keyCode == 27) {

		window.parent.document.getElementById('sbox-window').close();
    }
}; 
  

  
  </script>
  
<div style="background-color:#FFF; height:<?php echo $popup_height-30 ?>px;padding:15px;">
 <?php 
 

 
 foreach($rows as $row)
 {
 for($i=0;$i<count($ev_id);$i++)
 if($row->id==$ev_id[$i])
 echo '<div ><a style="font-size:'.$title_size.'px;color:'.$title_color.'; line-height:30px" href="'.plugins_url("spidercalendarbig.php",__FILE__).'?theme_id='.$theme_id.'&calendar_id='.$calendar_id.'&ev_ids='.$ev_ids.'&eventID='.$ev_id[$i].'&date='.$date.'&day='.$day.(($widget)?('&widget=1'):'').'&cur_page_url='.$path_sp_cal.'">'.($i+1).' '.$row->title .'</a> '.$row->time .'</div>';
 
 }
 
 
 
 
 ?>
 </div>
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 

