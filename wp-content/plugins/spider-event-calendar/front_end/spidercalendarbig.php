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
require_once("functions_spidercalendarbig.php");
 if(isset($_GET['widget']))
{
	$widget=1;
}
else
{
	$widget=0;
}

 $theme_id =1;
 if($widget)
$theme 	=$wpdb->get_row($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'spidercalendar_widget_theme WHERE id=%d',$theme_id));
else
$theme 	=$wpdb->get_row($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'spidercalendar_theme WHERE id=%d',$theme_id));
 

 
 


 
 
 
 
 
 function week_number($x)
 {
	
	if($x==1)
	return __('First','sp_calendar'); 
	
	if($x==7)
	return __('Second','sp_calendar');
	
	if($x==14)
	return __('Third','sp_calendar');
	
	if($x==21)
	return __('Fourth','sp_calendar');
	
	if($x=='last')
	return __('Last','sp_calendar'); 
 }
 
 
 
 function week_convert($x)
 {
	if($x=='Mon')
	return __('Monday','sp_calendar'); 
	
	if($x=='Tue')
	return __('Tuesday','sp_calendar'); 
	
	if($x=='Wed')
	return __('Wednesday','sp_calendar'); 
	
	if($x=='Thu')
	return __('Thursday','sp_calendar'); 
	
	if($x=='Fri')
	return __('Friday','sp_calendar');
	
	if($x=='Sat')
	return __('Saturday','sp_calendar');
	
	if($x=='Sun')
	return __('Sunday','sp_calendar');
	 
	 
	 
 }
 
 
function do_nothing()
{
return false;

}

		
	
 

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
		
		$date_format_array=explode('/',$date_format);
		
		for($i=0;$i<count($date_format_array);$i++)
		{
		if($date_format_array[$i]=='w')
			$date_format_array[$i]='l';
		
		if($date_format_array[$i]=='m')
			$date_format_array[$i]='F';	
		
		if($date_format_array[$i]=='y')
			$date_format_array[$i]='Y';		
		
		}
		

	$all_files_cal=php_showevent();
	
		$row=$all_files_cal[0]['row'];
        $option=$all_files_cal[0]['option'];
		
		
		if(isset($_GET['date'])){
			if(IsDate_inputed($_GET['date']))
			$datte=$_GET['date'];
			else
			$datte=date("Y-m-d");
		}
		else
		{
			$datte=date("Y-m-d");
		}
		$activedate=explode('-',$datte);		
		$activedatetimestamp = mktime(0, 0, 0, $activedate[1], $activedate[2], $activedate[0]);				
		$activedatestr='';
		for($i=0;$i<count($date_format_array);$i++)
		{
		$activedatestr.=__(date("".$date_format_array[$i]."",$activedatetimestamp)).' ';
		}
		
		//$activedatestr=__(date("".$date_format_array[0]."",$activedatetimestamp)).' '.__(date("".$date_format_array[1]."",$activedatetimestamp)).' '.__(date("".$date_format_array[2]."",$activedatetimestamp)).' '.__(date("".$date_format_array[3]."",$activedatetimestamp));		
	
		$date =  $datte;
		$day = substr($date,8);
		if(isset($_GET['calendar_id']))
		$calendar_id	=$_GET['calendar_id'];
		else
		$calendar_id=0;
		
		 //$ev_ids =$session->get('ev_ids');
	$ev_ids_inline=$_GET['ev_ids'];
	
    $ev_id = explode(',',$ev_ids_inline);
	
   
 
 
    

 
$eventID=$_GET['eventID'];
 
 ?>
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
  <script>
  
  
  function next(day_events,ev_id,theme_id,calendar_id,date,day,ev_ids)
  {

  
	
	  var p=0;
	   for (var key in day_events)
	   {	  p=p+1;
		   if(day_events[key]==ev_id && day_events[parseInt(key) +1])
		   {
				   
					
				   window.location='<?php echo plugins_url("spidercalendarbig.php",__FILE__) ?>?theme_id='+theme_id+'&calendar_id='+calendar_id+'&eventID='+day_events[parseInt(key) +1]+'&date='+date+'&day='+day+'&ev_ids='+ev_ids<?php if($widget)echo "+'&widget=1'" ?>;
		  
		   }
		 	   		   
	  }

	  
  }
  
  
  function change()
  {
  
  jQuery('#dayevent').ready(function() {
  jQuery('#dayevent').animate({
      
    opacity: 1,
	
    marginLeft: "0in",
	
   
  }, 1000, function() {
  

    
  });
});
  
  }

  window.onload=change();
  
  function prev(array1,ev_id,theme_id,calendar_id,date,day,ev_ids)
  {
   var day_events = array1;
 
	   for (var key in day_events)
	   {	  
		   if(day_events[key]==ev_id && day_events[parseInt(key) -1] )
		   {
				   
					
				   window.location='<?php echo plugins_url("spidercalendarbig.php",__FILE__) ?>?theme_id='+theme_id+'&calendar_id='+calendar_id+'&eventID='+day_events[parseInt(key) -1]+'&date='+date+'&ev_ids='+ev_ids+'&day='+day<?php if($widget)echo "+'&widget=1'" ?>;
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
  
 <?php
 

		?>
		
		<style>
		#dayevent
		{
		 opacity:0;
		
		}
		#previous , #next
		{
		width:5%;
		height:<?php echo $popup_height - 6 ?>px;
		cursor:pointer;
		
		}
		
		.arrow
		{
		font-size:50px;
		color:<?php echo $next_prev_event_arrowcolor ?>;
		text-decoration:none;
		
		}
		
		
		</style>
		
		
		<table style="height:<?php echo $popup_height ?>px;width:100%;background-color:<?php echo $show_event_bgcolor ?>; border-spacing:0"  align="center">
		<tr>
		
		<td  id="previous" onclick="prev([<?php echo $ev_ids_inline ?>],<?php echo $eventID ?>,<?php echo $theme_id ?>,<?php echo $calendar_id ?>,'<?php echo $date; ?>',<?php echo $day ?>,'<?php echo $ev_ids_inline ?>')"  style="<?php if(count($ev_id)==1 or $eventID==$ev_id[0] ) echo 'display:none' ?>;text-align:center" onmouseover="document.getElementById('previous').style.backgroundColor='<?php echo $next_prev_event_bgcolor ?>'" onmouseout="document.getElementById('previous').style.backgroundColor=''" >
		
		<span class="arrow"  >&lt;</span>
		
		</td>
		
		<td style="vertical-align:top; width:90%">
		<?php
		
		echo '<div id="dayevent" style="padding:0px 0px 0px 7px ;line-height:30px; padding-top:0px;">';		
				
		
		if($date_style=="bold" or $date_style=="bold/italic" )
		$date_font_weight="font-weight:bold";
		else
		$date_font_weight="font-weight:normal";
		if($date_style=="italic" or $date_style=="bold/italic" )
		$date_font_style="font-style:italic";
		else
		$date_font_style="";
		

		echo '<div style="color:'.$date_color.';font-size:'.$date_size.'px; font-family:'.$date_font.'; '.$date_font_weight.'; '.$date_font_style.'  ">'.$activedatestr.'</div>';
		if($title_style=="bold" or $title_style=="bold/italic" )
		$font_weight="font-weight:bold";
		else
		$font_weight="font-weight:normal";
		if($title_style=="italic" or $title_style=="bold/italic" )
		$font_style="font-style:italic";
		else
		$font_style="";
		
		$weekdays=explode(',',$row->week);
	
		$date_format1='d/m/y';
		
		if($row->repeat=='1')
		$repeat='';
		else
		$repeat=$row->repeat;

		if($row->text_for_date!='')
		{		
		if($row->date_end and $row->date_end!='0000-00-00')
					echo '<div style="color:'.$date_color.';font-size:'.$date_size.'px; font-family:'.$date_font.'; '.$date_font_weight.'; '.$date_font_style.'  ">'.__('Date','sp_calendar').':'.str_replace("d",substr($row->date,8,2),str_replace("m",substr($row->date,5,2),str_replace("y",substr($row->date,0,4),$date_format1))).'&nbsp;-&nbsp;'.str_replace("d",substr($row->date_end,8,2),str_replace("m",substr($row->date_end,5,2),str_replace("y",substr($row->date_end,0,4),$date_format1))).'&nbsp;'.$row->time.'</div>';
					else
								echo '<div style="color:'.$date_color.';font-size:'.$date_size.'px; font-family:'.$date_font.'; '.$font_weight.'; '.$font_style.'  ">'.$row->time.'</div>';
	


if($show_repeat==1)						
	{		
		if($row->repeat_method=='daily')
		echo '<div style="color:'.$date_color.';font-size:'.$date_size.'px; font-family:'.$date_font.'; '.$date_font_weight.'; '.$date_font_style.'  ">'.__('Repeat Every','sp_calendar').' ' .$repeat.' '.__('Day','sp_calendar').'</div>';
		if($row->repeat_method=='weekly')
		{
		echo '<div style="color:'.$date_color.';font-size:'.$date_size.'px; font-family:'.$date_font.'; '.$date_font_weight.'; '.$date_font_style.'  ">'.__('Repeat Every','sp_calendar').' ' .$repeat.' '.__('Week(s) on','sp_calendar').' : ';
		for ($i=0;$i<count($weekdays);$i++) 
		{
			if($weekdays[$i]!=''){
				if($i!=count($weekdays)-2)
					echo week_convert($weekdays[$i]).',';
				else
					echo week_convert($weekdays[$i]);
			
			}
			
		}
		echo '</div>';
		}
		if($row->repeat_method=='monthly' and $row->month_type==1)
		echo '<div style="color:'.$date_color.';font-size:'.$date_size.'px; font-family:'.$date_font.'; '.$date_font_weight.'; '.$date_font_style.'  ">'.__('Repeat Every','sp_calendar').' ' .$repeat.' '.__('Month(s) on the','sp_calendar').' '.$row->month.'</div>';	

		if($row->repeat_method=='monthly' and $row->month_type==2)
		echo '<div style="color:'.$date_color.';font-size:'.$date_size.'px; font-family:'.$date_font.'; '.$date_font_weight.'; '.$date_font_style.'  ">'.__('Repeat Every','sp_calendar').' '.$repeat.' '.__('Month(s) on the','sp_calendar').' '.week_number($row->monthly_list).' '.week_convert($row->month_week).'</div>';

		if($row->repeat_method=='yearly' and $row->month_type==1)
		echo '<div style="color:'.$date_color.';font-size:'.$date_size.'px; font-family:'.$date_font.'; '.$date_font_weight.'; '.$date_font_style.'  ">'.__('Repeat Every','sp_calendar').' ' .$repeat.' '.__('Year(s) in','sp_calendar').' '.date('F',mktime(0,0,0,$row->year_month + 1,0,0)).' '.__('on the','sp_calendar').' '.$row->month.'</div>';	

		if($row->repeat_method=='yearly' and $row->month_type==2)
		echo '<div style="color:'.$date_color.';font-size:'.$date_size.'px; font-family:'.$date_font.'; '.$date_font_weight.'; '.$date_font_style.'  ">'.__('Repeat Every','sp_calendar').' ' .$repeat.' '.__('Year(s) in','sp_calendar').' '.date('F',mktime(0,0,0,$row->year_month + 1,0,0)).' '.__('on the','sp_calendar').' '.week_number($row->monthly_list).' '.week_convert($row->month_week).'</div>';		

		
			}
					
					
					echo '<div style="color:'.$title_color.';font-size:'.$title_size.'px; font-family:'.$title_font.'; '.$font_weight.'; '.$font_style.'  ">'.$row->title.'</div>';

					echo '<div style="line-height:20px">'.$row->text_for_date.'</div>';
					
					
					
					
				
		}
		else
		{
		echo '<div style="color:'.$title_color.';font-size:'.$title_size.'px; font-family:'.$title_font.'; '.$font_weight.'; '.$font_style.'  ">'.$row->title.'</div>';
		echo '<h1 style="text-align:center"></h1>';
		}
		echo '</div>';	
		
	?>
	<div style="width:98%;text-align:right; display:<?php if(count($ev_id)==1) echo 'none'; ?>"><a style="color:<?php echo $title_color?>;font-size:15px; font-family:<?php echo $title_font?>; <?php echo $font_weight?>; <?php echo $font_style?>" href="<?php echo plugins_url("spidercalendarbig_seemore.php",__FILE__).'?theme_id='.$theme_id.'&ev_ids='.$ev_ids_inline.'&calendar_id='.$calendar_id.'&date='.$date.''.(($widget)?('&widget=1'):'') ?>">Back to event list</a></div>
	</td>
	
	<td id="next"  onclick="next([<?php echo $ev_ids_inline ?>],<?php echo $eventID ?>,<?php echo $theme_id ?>,<?php echo $calendar_id ?>,'<?php echo $date ?>',<?php echo $day ?>,'<?php echo $ev_ids_inline ?>')"   style="<?php if(count($ev_id)==1 or $eventID==end($ev_id)) echo 'display:none' ?>;text-align:center" onmouseover="document.getElementById('next').style.backgroundColor='<?php echo $next_prev_event_bgcolor ?>'" onmouseout="document.getElementById('next').style.backgroundColor=''" >
	
		<span class="arrow"  >&gt;</span>
		
		</td>
	
	</tr>
	
	</table>
<?php	
			
			////////////////
			
			$url_for_page=$_GET['cur_page_url'];
			 
	$url_for_page_de=urldecode($url_for_page);	
	if(!strpos($url_for_page_de,'?')){
		$cuery_string='?'.$_SERVER['QUERY_STRING'];
	}
	else
	{
		$cuery_string='&'.$_SERVER['QUERY_STRING'];
	}
	$url_for_page_de.=$cuery_string;
	$url_for_page_de=str_replace('theme_id=','frst_theme_id=\'',$url_for_page_de);
	$url_for_page_de=str_replace('calendar_id=','frst_calendar_id=\'',$url_for_page_de);
	$url_for_page_de=str_replace('ev_ids=','frst_ev_ids=\'',$url_for_page_de);
	$url_for_page_de=str_replace('eventID=','frst_eventID=\'',$url_for_page_de);
	$url_for_page_de=str_replace('date=','frst_date=\'',$url_for_page_de);
	$url_for_page_de=str_replace('day=','frst_day=\'',$url_for_page_de);
	if(substr($url_for_page_de, -1)=='&')
	$url_for_page_de=substr_replace($url_for_page_de ,"",-1);
	$zzzzzzzzz=0;
	if($zzzzzzzzz==1){
?>
<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo urlencode($url_for_page_de); ?>" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:80px;" allowTransparency="true"></iframe>
<?php
	}



	?>

