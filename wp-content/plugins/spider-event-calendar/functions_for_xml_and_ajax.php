<?php
function php_window(){
	global $wpdb;
$themes=$wpdb->get_results("SELECT id,title FROM ".$wpdb->prefix."spidercalendar_theme");
$calendars=$wpdb->get_results("SELECT id,title FROM ".$wpdb->prefix."spidercalendar_calendar WHERE published=1");
?>
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<title>Spider Calendar</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<script language="javascript" type="text/javascript" src="<?php echo get_option("siteurl"); ?>/wp-includes/js/jquery/jquery.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option("siteurl"); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script><link rel="stylesheet" href="<?php echo get_option("siteurl"); ?>/wp-includes/js/tinymce/themes/advanced/skins/wp_theme/dialog.css?ver=342-20110630100">
	<script language="javascript" type="text/javascript" src="<?php echo get_option("siteurl"); ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option("siteurl"); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<base target="_self">
</head>
<body id="link" onLoad="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';"  style="" dir="ltr" class="forceColors">
<form name="spider_cat" action="#">
	<div class="tabs" role="tablist" tabindex="-1">
		<ul>
			<li id="Single_product_tab" class="current" role="tab" tabindex="0"><span><a href="javascript:mcTabs.displayTab('Single_product_tab','Single_product_panel');" onMouseDown="return false;" tabindex="-1">Spider Calendar</a></span></li>
			
		</ul>
	</div>
	
	<div class="panel_wrapper">
		<div id="Single_product_panel" class="panel current">
		<br>
		<table border="0" cellpadding="4" cellspacing="0">
         <tbody><tr>
            <td nowrap="nowrap"><label for="spider_Calendar">Select Calendar</label></td>
            <td><select name="spider_Calendar" id="spider_Calendar" >
<option value="- Select a Calendar -" selected="selected">- Select a Calendar -</option>
<?php 
	   foreach($calendars as $calendar)
	   {
		   ?>
           <option value="<?php echo $calendar->id; ?>"><?php echo $calendar->title; ?></option>
           <?php }?>
</select>
            </td>
          </tr>
         
        </tbody></table>
		</div>
        </div>
        <div class="mceActionPanel">
		<div style="float: left">
			<input type="button" id="cancel" name="cancel" value="Cancel" onClick="tinyMCEPopup.close();" />
		</div>

		<div style="float: right">
			<input type="submit" id="insert" name="insert" value="Insert" onClick="insert_spider_calendar();" />
		</div>
	</div>

</form>

<script type="text/javascript">
function insert_spider_calendar() {
	
	
		
		
			if(document.getElementById('spider_Calendar').value=='- Select a Calendar -')
			{
				tinyMCEPopup.close();
			}
			else
			{


			   var tagtext;
			   tagtext='[Spider_Calendar id="'+document.getElementById('spider_Calendar').value+'" theme="1"]';
			   window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext);
			   tinyMCEPopup.editor.execCommand('mceRepaint');
			   tinyMCEPopup.close();

			}
		
}

</script>
</body></html>
<?php

die();	
	}

function big_calendarr(){
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
if(isset($_GET['widget']))
{
	$widget=1;
}
else
{
	$widget=0;
}
$many_sp_calendar=$_GET['many_sp_calendar'];

if(!is_numeric($many_sp_calendar)){
       $many_sp_calendar=1;
}
$theme_id =1;
if($widget){
	$theme 	=$wpdb->get_row( $wpdb->prepare( 'SELECT * FROM '.$wpdb->prefix.'spidercalendar_widget_theme WHERE id=%d',$theme_id));
}
	else
	{
	$theme 	=$wpdb->get_row( $wpdb->prepare( 'SELECT * FROM '.$wpdb->prefix.'spidercalendar_theme WHERE id=%d',$theme_id));
	}



////like facbook button
$path_sp_cal=$_GET['cur_page_url'];



			// load the row from the db table
			if($widget){
		 $cal_width='200';
		 $bg_top = '#'.'36A7E9';
		 $bg_bottom = '#'.'FFFFFF';
	 	 $border_color = '#'.'000000';
		 $text_color_year = '#'.'000000';
		 $text_color_month = '#'.'000000';
		 $color_week_days = '#'.'000000';
		 $text_color_other_months = '#'.'525252';
		 $text_color_this_month_unevented = '#'.'000000';
		 $evented_color = '#'.'FFFFFF';
		 $evented_color_bg = '#'.'FFA142';
		 $color_arrow_year = '#'.'000000';
		 $color_arrow_month = '#'.'000000';
		 $sun_days = '#'.'36A7E9';
		 $event_title_color = '#'.'FFFFFF';
		 $current_day_border_color = '#'.'36A7E9';
		 $cell_border_color = '#'.'000000';
		 $cell_height = '25';
		 $popup_width = '800';
		 $popup_height = '800';
		 $number_of_shown_evetns = 1;
		 $sundays_font_size ='14';
		 $other_days_font_size= '12';
		 $weekdays_font_size= '14';
		 $border_width= '4';
		 $top_height='50';
		 $bg_color_other_months='#'.'FFFFFF';
		 $sundays_bg_color='#'.'FFFFFF';
		 $weekdays_bg_color='#'.'FFFFFF';
		 $weekstart='su';
		 $weekday_sunday_bg_color='#'.'FFFFFF';
		 $border_radius='0';
		 $border_radius2=$border_radius-$border_width;
		 $week_days_cell_height='20';
		 $year_font_size='22';
		 $month_font_size='14';
		 $arrow_size='10';
	
		 $arrow_size_hover=$arrow_size+5;
	
		 $next_month_text_color = '#'.'FFFFFF';
		 $prev_month_text_color = '#'.'FFFFFF';
		 $next_month_arrow_color = '#'.'FFFFFF';
		 $prev_month_arrow_color = '#'.'FFFFFF';
		 $next_month_font_size ='';
		 $prev_month_font_size = '';
		 $month_type = 2;
		 $all_days_border_width='1';
			}
			else
			{
		 $cal_width='650';
		 $bg_top = '#'.'36A7E9';
		 $bg_bottom = '#'.'FFFFFF';
	 	 $border_color = '#'.'000000';
		 $text_color_year = '#'.'000000';
		 $text_color_month = '#'.'000000';
		 $color_week_days = '#'.'000000';
		 $text_color_other_months = '#'.'525252';
		 $text_color_this_month_unevented = '#'.'000000';
		 $evented_color = '#'.'FFFFFF';
		 $evented_color_bg = '#'.'FFA142';
		 $color_arrow_year = '#'.'000000';
		 $color_arrow_month = '#'.'000000';
		 $sun_days = '#'.'36A7E9';
		 $event_title_color = '#'.'FFFFFF';
		 $current_day_border_color = '#'.'36A7E9';
		 $cell_border_color = '#'.'000000';
		 $cell_height = '80';
		 $popup_width = '800';
		 $popup_height = '800';
		 $number_of_shown_evetns = 1;
		 $sundays_font_size ='14';
		 $other_days_font_size= '12';
		 $weekdays_font_size= '14';
		 $border_width= '4';
		 $top_height='80';
		 $bg_color_other_months='#'.'FFFFFF';
		 $sundays_bg_color='#'.'FFFFFF';
		 $weekdays_bg_color='#'.'FFFFFF';
		 $weekstart='su';
		 $weekday_sunday_bg_color='#'.'FFFFFF';
		 $border_radius='0';
		 $border_radius2=$border_radius-$border_width;
		 $week_days_cell_height='40';
		 $year_font_size='22';
		 $month_font_size='14';
		 $arrow_size='10';
	
		 $arrow_size_hover=$arrow_size+5;
	
		 $next_month_text_color = '#'.'FFFFFF';
		 $prev_month_text_color = '#'.'FFFFFF';
		 $next_month_arrow_color = '#'.'FFFFFF';
		 $prev_month_arrow_color = '#'.'FFFFFF';
		 $next_month_font_size ='';
		 $prev_month_font_size = '';
		 $month_type = 2;
		 $all_days_border_width='1';
			}
		 
		 
		 __('January','sp_calendar');
		 __('February','sp_calendar');
		 __('March','sp_calendar');
		 __('April','sp_calendar');
		 __('May','sp_calendar');
		 __('June','sp_calendar');
		 __('July','sp_calendar');
		 __('August','sp_calendar');
	     __('September','sp_calendar');
		 __('October','sp_calendar');
	     __('November','sp_calendar');
	     __('December','sp_calendar');

		 
	function php_getdays()

	{
		global $wpdb;
		$id=$_GET['id'];
		
		$calendar	=$_GET['calendar'];
		if(isset($_GET['date']))
		{
			if(IsDate_inputed($_GET['date']))
			$date=$_GET['date']; 
			else
			$date=date("Y").'-'.php_Month_num(date("F")).'-'.date("d");
		}
		else
		{
			$date=date("Y").'-'.php_Month_num(date("F")).'-'.date("d");
		}
		$year=substr( $date,0,4); 
		$month=substr( $date,5,2); 
		
		
			$theme_id =$_GET['theme_id'];
		if(isset($_GET['widget']))
		{
			$widget=1;
		}
		else
		{
			$widget=0;
		}
		

		function php_GetNextDate($beginDate,$repeat)
				{
				
				   //explode the date by "-" and storing to array
				   $date_parts1=explode("-", $beginDate);
				   
				   //gregoriantojd() Converts a Gregorian date to Julian Day Count
				   $start_date=gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
				  
				   return jdtogregorian($start_date+$repeat);
				   
				 
				}	
	
	function php_daysDifference($beginDate,$endDate)
				{
				
				   //explode the date by "-" and storing to array
				   $date_parts1=explode("-", $beginDate);
				   $date_parts2=explode("-", $endDate);
				   
				   //gregoriantojd() Converts a Gregorian date to Julian Day Count
				   $start_date=gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
				   
				   $end_date=gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
				  
				   return $end_date-$start_date;
				   
				 
				}	

		
		$show_time=1;		
		if(!$_GET['calendar'])
			$calendar=0;
		
		$rows=$wpdb->get_results($wpdb->prepare(  "SELECT * from ".$wpdb->prefix."spidercalendar_event where published=1 and ( ( (date<=%s or date like %s) and  date_end>=%s) or ( date_end is Null and date like %s ) ) and calendar=%d  ","".substr( $date,0,7)."-01","".substr( $date,0,7)."%","".substr( $date,0,7)."-01","".substr( $date,0,7)."%",$calendar));

//echo	"SELECT date,date_end,text_for_date from #__spidercalendar where published=1 and ( ( (date<='".substr( $date,0,7)."-01' or date like '".substr( $date,0,7)."%') and  date_end>='".substr( $date,0,7)."-01' ) or ( date_end is Null and date like '".substr( $date,0,7)."%' ) )  ";
		$id_array=array();
		
		$s = count($rows);
		$id_array=array();		
		$array_days=array();
		$array_days1=array();
		$title=array();
		$ev_ids=array();
		///mec FOR
		
		for($i=1; $i<=$s; $i++)
		{			

		
			$date_month=(int)substr( $rows[$i-1]->date,5,2);
			$date_end_month=(int)substr( $rows[$i-1]->date_end,5,2);
			
			$date_day=(int)substr( $rows[$i-1]->date,8,2);
			$date_end_day=(int)substr( $rows[$i-1]->date_end,8,2);
			//echo $date_day;
			$date_year_month=(int)(substr( $rows[$i-1]->date,0,4).substr( $rows[$i-1]->date,5,2));
			$date_end_year_month=(int)(substr( $rows[$i-1]->date_end,0,4).substr( $rows[$i-1]->date_end,5,2));
			
			$year_month=(int)($year.$month);
			$repeat=$rows[$i-1]->repeat;
			
			if ($repeat=="")
				$repeat=1;
				
			$start_date = $rows[$i-1]->date;
			
		//echo $date_month.'<br>' ;
		
		//echo (int)$month.'<br>';
		
			$weekly=$rows[$i-1]->week;			
			$weekly_array=explode(',',$weekly);
			 
			
			$date_days=array();
			$weekdays_start=array();
			$weekdays=array();
			
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////                NO Repeat                /////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

			if($rows[$i-1]->repeat_method=='no_repeat')
			{			
				$date_days[]=$date_day;
			}
			
	
			
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////               Repeat   Daily             /////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			if($rows[$i-1]->repeat_method=='daily')
			{
			
					$t = php_daysDifference($rows[$i-1]->date,$rows[$i-1]->date_end);
					
					for($k=1;$k<=$t/$repeat;$k++){
				
						
					$next_date=php_GetNextDate($start_date,$repeat);
					$next_date_array=explode('/',$next_date);
						
					
					
					if((int)$month==$date_month && (int)substr($date_year_month,0,4)==(int)$year)
						$date_days[0]=$date_day;
					
					
					
					
						if((int)$month==$next_date_array[0] && (int)$year==$next_date_array[2])
					
					$date_days[]=$next_date_array[1];
					$start_date = date("Y-m-d",mktime(0, 0, 0, $next_date_array[0], $next_date_array[1],$next_date_array[2]));
					
					
				
				}
			}
			
		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////               Repeat   Weekly             ///////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			
			
			if($rows[$i-1]->repeat_method=='weekly')
			{
				
			
					
				
					
				for($j=0; $j<=6;$j++)
				{
					if( in_array(date("D", mktime(0, 0, 0, $date_month, $date_day+$j, substr($rows[$i-1]->date,0,4))),$weekly_array))
					{	$weekdays_start[]=$date_day+$j;}
					
			
				}
				
				
		
				
				
				for($p=0;$p<count($weekly_array)-1;$p++)
				{
										
					$start_date = substr($rows[$i-1]->date,0,8).$weekdays_start[$p];
					$t = php_daysDifference($rows[$i-1]->date,$rows[$i-1]->date_end);
					$r=0;
					for($k=1;$k<$t/$repeat;$k++){
				

				
				$start_date_array[]=$start_date;
				
					$next_date=php_GetNextDate($start_date,$repeat* 7);
					$next_date_array=explode('/',$next_date);
					
					
			
					
				if((int)$month==$date_month && (int)substr($date_year_month,0,4)==(int)$year)
						$date_days[0]=$weekdays_start[$p];
					
					
					
						if((int)$month==$next_date_array[0] && (int)$year==$next_date_array[2])
					if((int)$year>(int)substr($date_year_month,0,4)){
				
					$weekdays[]=$next_date_array[1];
					}
					else
					{
				
					$weekdays[]=$next_date_array[1];
					
					}
					
					$start_date = date("Y-m-d",mktime(0, 0, 0, $next_date_array[0], $next_date_array[1],$next_date_array[2]));
					
					
					if($next_date_array[2]>(int)substr($rows[$i-1]->date_end,0,4))
					break;
					}
				
				$date_days=array_merge($weekdays,$date_days);
			
			
				}
				
			
				
				$repeat= $repeat * 7;
				
				
				
			}

		
		
		
		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////               Repeat   Monthly            ///////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					
		
			if($rows[$i-1]->repeat_method=='monthly')
			{
				$xxxxx=13;
				
				$year_dif_count=(int)$year-(int)substr($rows[$i-1]->date,0,4);
				$mount_dif_count=12-(int)substr($rows[$i-1]->date,5,2)+(($year_dif_count-1)*12);
				
				if($year_dif_count>0)
				for($my_serch_month=1;$my_serch_month<=12;$my_serch_month++){
					if((($mount_dif_count+$my_serch_month)%$rows[$i-1]->repeat)==0){
						$xxxxx=$my_serch_month;
						break;					
					}
				}
				if($xxxxx!=13){
					if($xxxxx<10){
						$xxxxx='0'.$xxxxx;	
					}
				}
				
				
				$month_days = date('t',mktime(0, 0, 0, $month, $date_day, $year));
				
				if($date_month<(int)$month or (int)substr($date_year_month,0,4)<$year )
						$date_day=1;
				
				
				
				
			if($year>(int)substr($date_year_month,0,4))
				$date_year_month = $year.$xxxxx;	
				$p=(int)substr($date_year_month,4,2);
				
				
				if((int)substr($date_year_month,0,4)!=(int)substr($date_end_year_month,0,4) )
					$end = (int)substr($date_end_year_month,4,2)+12;
				else
					$end = (int)substr($date_end_year_month,4,2);
				
					for($k=1; $k<=$end;$k++)
						{
																
						 if((int)$month==$p and $rows[$i-1]->month_type==1)
									 {
								 $date_days[0]=$rows[$i-1]->month;
								 	
								 
									 }
									 
									
						if($p==(int)$month and $rows[$i-1]->month_type==2)
									 {
								 if($rows[$i-1]->monthly_list!='last'){
								 for($j=$rows[$i-1]->monthly_list; $j<$rows[$i-1]->monthly_list+7;$j++)
											{
												if(date("D", mktime(0, 0, 0, $month, $j, $year)) == $rows[$i-1]->month_week)
													{	
													if($j>=$date_day)
													$date_days[0]=$j;
												
													
													}
											}
								 }
								 
								 else
								 {
								 for($j=1; $j<=$month_days;$j++)
											{
												
												if(date("D", mktime(0, 0, 0, $month, $j, $year)) == $rows[$i-1]->month_week)
													{	
													if($j>=$date_day)
													$date_days[0]=$j;
													
													}
												
											}
										
								 }
									 
									
							 
									 }		
						if($year>(int)substr($date_year_month,0,4))
						$p=1;
						$p=$p+$repeat;
						
					
						
							}
				
							
					$repeat=32;
					
					}
					
				
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////               Repeat   Yearly             ///////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					
					
			if($rows[$i-1]->repeat_method=='yearly')
			{
				
			$month_days = date('t',mktime(0, 0, 0, $month, $date_day, $year));
				
				$end =	substr($date_end_year_month,0,4)-substr($date_year_month,0,4)+1;
							if(substr($date_year_month,0,4)<$year)
							$date_day=1;
				
							for($k=0; $k<=$end; $k+=$repeat)		{					
						 if((int)$month==$rows[$i-1]->year_month and $rows[$i-1]->month_type==1 and $year==substr($date_year_month,0,4)+$k)
									 {
								 $date_days[0]=$rows[$i-1]->month;
									 }
									 
								
							}
							for($k=0; $k<=$end; $k+=$repeat)		{		 
						if((int)$month==$rows[$i-1]->year_month and $rows[$i-1]->month_type==2 and $year==substr($date_year_month,0,4)+$k)
									 {
								 if($rows[$i-1]->monthly_list!='last'){
								 for($j=$rows[$i-1]->monthly_list; $j<$rows[$i-1]->monthly_list+7;$j++)
											{
												if(date("D", mktime(0, 0, 0, $month, $j, $year)) == $rows[$i-1]->month_week)
													{	
													$date_days[0]=$j;
													
													}
											}
								 }
								 
								 else
								 {
								 for($j=1; $j<=$month_days;$j++)
											{
												if(date("D", mktime(0, 0, 0, $month, $j, $year)) == $rows[$i-1]->month_week)
													{	
													$date_days[0]=$j;
													
													}
												
											}
								 }
									 
									 
									 }	
									 
							}
						
						$repeat=32;
					
			}
			
			$used=array();
			
			foreach($date_days as $date_day)
			{
				if($date_month==$month)
				{	
									
					if(in_array($date_day, $used))
						continue;
					else
						array_push($used, $date_day);

					if(in_array($date_day, $array_days))
					{
						$key = array_search($date_day, $array_days); 
						$title_num[$date_day]++;
						
						if($rows[$i-1]->text_for_date!="")
							$array_days1[$key] = $date_day;
							

						$c=$title_num[$date_day];
							  
							$list='<p><b>'.$c.'.</b>&nbsp;&nbsp;';
									   
							
							if($rows[$i-1]->time and $show_time!=0)		
							$list.='&nbsp;'.$rows[$i-1]->title.'<br>('.$rows[$i-1]->time.')</p>';
							else
							$list.='&nbsp;'.$rows[$i-1]->title.'</p>';
							
							
							$title[$date_day]=$title[$date_day].$list;
							
						
						
						$ev_ids[$date_day]=$ev_ids[$date_day].$rows[$i-1]->id.'<br>';
						
						
							
					}
					else
					{
						$array_days[] = $date_day;
						$key = array_search($date_day, $array_days); 
						if($rows[$i-1]->text_for_date!="")
							$array_days1[$key] = $date_day;
							
						$title_num[$date_day]=1;
						
						$c=1;
								  
						$list='<p><b>'.$c.'.</b>&nbsp;&nbsp;';
								   							
						if($rows[$i-1]->time and $show_time!=0)		
							$list.='&nbsp;'.$rows[$i-1]->title.'<br>('.$rows[$i-1]->time.')</p>';
							else
							$list.='&nbsp;'.$rows[$i-1]->title.'</p>';
						
						$title[$date_day]=$list;
						$ev_ids[$date_day]=$rows[$i-1]->id.'<br>';
						
					}
					
					//$date_day=$date_day+$repeat;
				}
					
					if($date_end_month>0 and  $date_year_month==$date_end_year_month and $date_end_year_month==$year_month )
					for($j=$date_day;$j<=$date_end_day;$j=$j+$repeat)
					{	
					
					 	if(in_array($j, $used))
							continue;
						else
							array_push($used, $j);
					
						if(in_array($j, $array_days))
						{
							$key = array_search($j, $array_days); 
							$title_num[$j]++;
							
							if($rows[$i-1]->text_for_date!="")
								$array_days1[$key] = $j;
								
	
							$c=$title_num[$j];
								  
								$list='<p><b>'.$c.'.</b>&nbsp;&nbsp;';
										   
								if($rows[$i-1]->time and $show_time!=0)		
							$list.='&nbsp;'.$rows[$i-1]->title.'<br>('.$rows[$i-1]->time.')</p>';
							else
							$list.='&nbsp;'.$rows[$i-1]->title.'</p>';
								
								$title[$j]=$title[$j].$list;
							
							$ev_ids[$j]=$ev_ids[$j].$rows[$i-1]->id.'<br>';
						}
						else
						{
							$array_days[] = $j;
							$key = array_search($j, $array_days); 
							if($rows[$i-1]->text_for_date!="")
								$array_days1[$key] = $j;
								
							$title_num[$j]=1;
							
							$c=1;
									  
							$list='<p><b>'.$c.'.</b>&nbsp;&nbsp;';
									   									
							if($rows[$i-1]->time and $show_time!=0)		
							$list.='&nbsp;'.$rows[$i-1]->title.'<br>('.$rows[$i-1]->time.')</p>';
							else
							$list.='&nbsp;'.$rows[$i-1]->title.'</p>';
							
							$title[$j]=$list;
						$ev_ids[$j] = $rows[$i-1]->id.'<br>';
						}
					}
					
					
					
				
					if($date_end_month>0 and  $date_year_month<$date_end_year_month and $date_year_month==$year_month)
					
					for($j=$date_day;$j<=31;$j=$j+$repeat)
					{	
					
					 	if(in_array($j, $used))
							continue;
						else
							array_push($used, $j);
					
						if(in_array($j, $array_days))
						{
							$key = array_search($j, $array_days); 
							$title_num[$j]++;
							
							if($rows[$i-1]->text_for_date!="")
								$array_days1[$key] = $j;
								
	
							$c=$title_num[$j];
								  
								$list='<p><b>'.$c.'.</b>&nbsp;&nbsp;';
										   
										
								if($rows[$i-1]->time and $show_time!=0)		
							$list.='&nbsp;'.$rows[$i-1]->title.'<br>('.$rows[$i-1]->time.')</p>';
							else
							$list.='&nbsp;'.$rows[$i-1]->title.'</p>';
								
								$title[$j]=$title[$j].$list;
							
							$ev_ids[$j]=$ev_ids[$j].$rows[$i-1]->id.'<br>';
						}
						else
						{
							$array_days[] = $j;
							$key = array_search($j, $array_days); 
							if($rows[$i-1]->text_for_date!="")
								$array_days1[$key] = $j;
								
							$title_num[$j]=1;
							
							$c=1;
									  
							$list='<p><b>'.$c.'.</b>&nbsp;&nbsp;';
									   
									
							if($rows[$i-1]->time and $show_time!=0)		
							$list.='&nbsp;'.$rows[$i-1]->title.'<br>('.$rows[$i-1]->time.')</p>';
							else
							$list.='&nbsp;'.$rows[$i-1]->title.'</p>';
							
							$title[$j]=$list;
						$ev_ids[$j] = $rows[$i-1]->id.'<br>';
						
						}
					}
					
					if($date_end_month>0 and  $date_year_month<$date_end_year_month and   $date_end_year_month==$year_month)
					
					for($j=$date_day;$j<=$date_end_day;$j=$j+$repeat)
					{	
					
					 	if(in_array($j, $used))
							continue;
						else
							array_push($used, $j);
					
						if(in_array($j, $array_days))
						{
							$key = array_search($j, $array_days); 
							$title_num[$j]++;
							
							if($rows[$i-1]->text_for_date!="")
								$array_days1[$key] = $j;
								
	
							$c=$title_num[$j];
							  
								$list='<p><b>'.$c.'.</b>&nbsp;&nbsp;';
										   										
								if($rows[$i-1]->time and $show_time!=0)		
							$list.='&nbsp;'.$rows[$i-1]->title.'<br>('.$rows[$i-1]->time.')</p>';
							else
							$list.='&nbsp;'.$rows[$i-1]->title.'</p>';
								
								$title[$j]=$title[$j].$list;
							
							$ev_ids[$j]=$ev_ids[$j].$rows[$i-1]->id.'<br>';
						}
						else
						{
							$array_days[] = $j;
							$key = array_search($j, $array_days); 
							if($rows[$i-1]->text_for_date!="")
								$array_days1[$key] = $j;
								
							$title_num[$j]=1;
							
							$c=1;
									  
							$list='<p><b>'.$c.'.</b>&nbsp;&nbsp;';
									   									
							if($rows[$i-1]->time and $show_time!=0)		
							$list.='&nbsp;'.$rows[$i-1]->title.'<br>('.$rows[$i-1]->time.')</p>';
							else
							$list.='&nbsp;'.$rows[$i-1]->title.'</p>';
							
							$title[$j]=$list;
						$ev_ids[$j] = $rows[$i-1]->id.'<br>';
						}
					}
					
					
					if($date_end_month>0 and  $date_year_month<$date_end_year_month and   $date_end_year_month>$year_month and  $date_year_month<$year_month )
					
						for($j=$date_day;$j<=31;$j=$j+$repeat)
						{	
					
					 	if(in_array($j, $used))
							continue;
						else
							array_push($used, $j);
					
							if(in_array($j, $array_days))
							{
							$key = array_search($j, $array_days); 
							$title_num[$j]++;
							
							if($rows[$i-1]->text_for_date!="")
								$array_days1[$key] = $j;
								
	
							$c=$title_num[$j];
								  
								$list='<p><b>'.$c.'.</b>&nbsp;&nbsp;';
										   									
								if($rows[$i-1]->time and $show_time!=0)		
							$list.='&nbsp;'.$rows[$i-1]->title.'<br>('.$rows[$i-1]->time.')</p>';
							else
							$list.='&nbsp;'.$rows[$i-1]->title.'</p>';
								
								$title[$j]=$title[$j].$list;
							
							$ev_ids[$j]=$ev_ids[$j].$rows[$i-1]->id.'<br>';
						}
							else
							{
								$array_days[] = $j;
								$key = array_search($j, $array_days); 
								if($rows[$i-1]->text_for_date!="")
									$array_days1[$key] = $j;
									
								$title_num[$j]=1;
								
								$c=1;
										  
								$list='<p><b>'.$c.'.</b>&nbsp;&nbsp;';
										   										
								if($rows[$i-1]->time and $show_time!=0)		
							$list.='&nbsp;'.$rows[$i-1]->title.'<br>('.$rows[$i-1]->time.')</p>';
							else
							$list.='&nbsp;'.$rows[$i-1]->title.'</p>';
								
								$title[$j]=$list;
							$ev_ids[$j] = $rows[$i-1]->id.'<br>';
							}
						}
				
					
				
			}
				

		}
	
		
		
	
		
		

		for($i=1; $i<=count($array_days)-1; $i++)
		   if(isset($array_days[$i]))
			if($array_days[$i]>'00' && $array_days[$i]<'09' and substr( $array_days[$i],0,1)=='0')
				
				$array_days[$i] = substr( $array_days[$i],1,1);
			
			$all_calendar_files['array_days']=$array_days;
			$all_calendar_files['title']=$title;
			$all_calendar_files['option']=$option;
			$all_calendar_files['array_days1']=$array_days1;
			$all_calendar_files['calendar']=$calendar;
			$all_calendar_files['ev_ids']=$ev_ids;
		return array($all_calendar_files);


	}	 


		
	function Month_name($month_num)

{

    $timestamp = mktime(0, 0, 0, $month_num, 1, 2005);
 
    return date("F", $timestamp); 
    
};	 
	
	function add_0($month_num)
	{
	if($month_num<10)
		return '0'.$month_num;
		return $month_num;
	}		 


	function Month_num($month_name)
	
	{
		for( $month_num=1; $month_num<=12; $month_num++ )
		
		{  
			if (date( "F", mktime(0, 0, 0, $month_num, 1, 0 ) ) == $month_name)
			
			{  
			return $month_num;  
			
			} 
			 
		}
		
	};
		 
		 ///////////////////////////////////////////////////
		 $calendar_id = $_GET['calendar'];
		 
		 if($cell_height=='')
		 $cell_height=70;
		 
		 if($cal_width=='')
		 $cal_width=700;
		 if(isset($_GET['date'])){
		if(IsDate_inputed($_GET['date']))
			$date_REFERER=$_GET['date']; 
			else
			$date_REFERER= date("Y-m");
		 }
		 else{
			$date_REFERER= date("Y-m");
		 }
$year_REFERER=substr($date_REFERER,0,4); 
$month_REFERER=Month_name(substr( $date_REFERER,5,2)); 
$day_REFERER=substr( $date_REFERER,8,2); 

		 if(isset($_GET['date'])){
		if(IsDate_inputed($_GET['date']))
			$date=$_GET['date']; 
			else
			$date= date("Y-m");
		 }
		 else{
			$date= date("Y-m");
		 }


$year=substr($date,0,4); 

$month=Month_name(substr( $date,5,2)); 

$day=substr( $date,8,2); 


?>
<style type='text/css'>

#bigcalendar<?php echo $many_sp_calendar ?> td,#bigcalendar<?php echo $many_sp_calendar ?> tr,  #spiderCalendarTitlesList td,  #spiderCalendarTitlesList tr
 {
 border:none  !important;
 }
#bigcalendar<?php echo $many_sp_calendar ?> .general_table
{

border-radius: <?php echo $border_radius ?>px !important;

}
#bigcalendar<?php echo $many_sp_calendar ?> .top_table
 {

border-top-left-radius: <?php echo $border_radius2 ?>px !important;
border-top-right-radius: <?php echo $border_radius2 ?>px !important;

}
 #bigcalendar<?php echo $many_sp_calendar ?> .cala_arrow a:link, #bigcalendar .cala_arrow a:visited {
	
	text-decoration:none !important;
	background:none !important;
	font-size: <?php echo $arrow_size ?>px  !important;
}
#bigcalendar<?php echo $many_sp_calendar ?> .cala_arrow{
	vertical-align:middle !important;
}
#bigcalendar<?php echo $many_sp_calendar ?> .cala_arrow a:hover {
	font-size: <?php echo $arrow_size_hover ?>px !important;
	text-decoration:none !important;
	background:none !important;
}
#bigcalendar<?php echo $many_sp_calendar ?> .cala_day a:link, #bigcalendar<?php echo $many_sp_calendar ?> .cala_day a:visited {

	text-decoration:none !important;
	background:none !important;
	font-size:12px !important;
	color:red ;
	
}


#bigcalendar<?php echo $many_sp_calendar ?> .cala_day a:hover {
	
	text-decoration:none !important;
	background:none !important;
	
}
#bigcalendar<?php echo $many_sp_calendar ?> .cala_day 
{

border:<?php if($widget) echo $all_days_border_width; else echo '1' ?>px solid  <?php echo $cell_border_color ?> !important;
<?php if($widget) echo 'vertical-align:middle !important; text-align: center !important;'; else echo 'vertical-align:top !important;'; ?>

}

#bigcalendar<?php echo $many_sp_calendar ?> .weekdays
{
	vertical-align:middle !important;

border:<?php if($widget) echo $all_days_border_width; else echo '1' ?>px solid  <?php echo $cell_border_color ?> !important;


}
#bigcalendar<?php echo $many_sp_calendar ?> .week_days
{
font-size: <?php echo $weekdays_font_size ?>px !important;
}


#bigcalendar<?php echo $many_sp_calendar ?> .calyear_table {
	border-spacing:0 !important;
	width:100% !important;
}

.calyear_table table
#bigcalendar<?php echo $many_sp_calendar ?> .calmonth_table {	
	border-spacing:0 !important;
	width:100% !important;
}
#bigcalendar<?php echo $many_sp_calendar ?> .calbg, #bigcalendar .calbg td
{
	background-color:<?php echo $bg ?> !important;
	text-align:center !important;
	width:14% !important;
}
#bigcalendar<?php echo $many_sp_calendar ?> .caltext_color_other_months 
{
	color: <?php echo $text_color_other_months ?> !important;
	border:<?php if($widget) echo $all_days_border_width; else echo '1' ?>px solid  <?php echo $cell_border_color ?> !important;
	<?php if($widget) echo 'vertical-align:middle !important; text-align: center !important;'; else echo 'vertical-align:top !important;'; ?>
	
	
}
#bigcalendar<?php echo $many_sp_calendar ?> .caltext_color_this_month_unevented {
	color: <?php echo $text_color_this_month_unevented ?> !important;
}
#bigcalendar<?php echo $many_sp_calendar ?> .calfont_year {
	
	font-size:24px !important;
	font-weight:bold !important;
	color: <?php echo $text_color_year ?> !important;
}
.general_table table,.general_table td, .general_table tr {
	border:inherit !important;
	vertical-align:initial !important;
	border-collapse:inherit !important;
	margin:inherit !important;
	padding:inherit !important;
}
.general_table{
	border-collapse:inherit !important;
	margin:inherit !important;
}
.general_table p{

	margin:inherit !important;
	padding:inherit !important;
}

#bigcalendar<?php echo $many_sp_calendar ?> .calsun_days 
{
	color: <?php echo $sun_days ?> !important;
	border:<?php if($widget) echo $all_days_border_width; else echo '1' ?>px solid  <?php echo $cell_border_color ?> !important;
		<?php if($widget) echo 'vertical-align:middle !important; text-align: center !important;'; else echo 'vertical-align:top !important; text-align:left !important;'; ?>
	
	background-color: <?php echo $sundays_bg_color ?> !important;
	
}
#bigcalendar<?php echo $many_sp_calendar ?> .calbottom_border
{

}
#bigcalendar<?php echo $many_sp_calendar ?> .calyear_table a
{
	vertical-align:top !important;
}
#bigcalendar<?php echo $many_sp_calendar ?> .calborder_day
{
border: solid  <?php echo $border_day ?> <?php if($widget) echo $all_days_border_width; else echo '1' ?>px !important;
}
#TB_window{
z-index: 10000;
}
</style>


<?php


$cell_width=$cal_width/7;



?>

<div style="width:<?php echo $cal_width; ?>px !important;" >
<table cellpadding="0" cellspacing="0"  class="general_table"  style="border-spacing:0 !important; width:<?php echo $cal_width ?>px !important;border:<?php echo $border_color ?> solid <?php echo $border_width ?>px !important; margin:0 !important; padding:0 !important;background-color:<?php echo $bg_bottom; ?> !important;">
    <tr>
        <td width="100%" style="padding:0 !important; margin:0 !important;">            
              <table  cellpadding="0" cellspacing="0" border="0" style="border-spacing:0 !important; font-size:12px !important; margin:0 !important; padding:0 !important;"  width="<?php echo $cal_width ?>"  >
                <tr  style="height:40px !important; width:<?php echo $cal_width ?>">
					<?php if($month_type==1){ ?>
                    	<td class="top_table" align="center" colspan="7" style="padding:0 !important; margin:0 !important; background-color:<?php echo $bg_top ?> !important;height:20px !important; " >
                        <?php //YEAR TABLE ?>

                   			<table cellpadding="0" cellspacing="0" border="0" align="center" class="calyear_table"  style="margin:0 !important; padding:0 !important; text-align:center !important; width:<?php echo (int)($cal_width+abs(14*$all_days_border_width-4)); ?>px !important; height:<?php echo $top_height ?>px !important;">
                            	<tr>
									<td style="width:100% !important;vertical-align:bottom !important;padding-bottom:0px !important;">
										<table style="width:100% !important;">
											<tr>
                               					 <td class="cala_arrow" width="40%"  style="text-align:right !important;margin:0px !important;padding:0px">
													<a style="color:<?php echo $color_arrow_year ?>"  href="javascript:showbigcalendar( 'bigcalendar<?php echo $many_sp_calendar ?>','<?php echo admin_url('admin-ajax.php?action=spiderbigcalendar').'&theme_id='.$theme_id.'&calendar='.$calendar_id.'&date='.($year-1).'-'.add_0(Month_num($month)).'&many_sp_calendar='.$many_sp_calendar; echo '&cur_page_url='.$path_sp_cal; if($widget) echo '&widget=1'; ?>')">&#9668;</a>
												 </td>
                               					 <td style="text-align:center !important; margin:0 !important; padding:0 !important;" width="20%" >
                                   					 <input name="year" type="hidden" readonly  value="<?php echo $year?>"/>
                                  					  <span style="font-family:arial !important;font-size:<?php echo $year_font_size ?>px !important;font-weight:bold !important;color:<?php echo $text_color_year;?> !important;"><?php echo $year;?></span> 
												</td>
                                                <td style="margin:0 !important; padding:0 !important;text-align:left !important;" width="40%"  class="cala_arrow"> 
                                             	   <a  style="color:<?php echo $color_arrow_year ?>"  href="javascript:showbigcalendar( 'bigcalendar<?php echo $many_sp_calendar ?>','<?php echo admin_url('admin-ajax.php?action=spiderbigcalendar').'&theme_id='.$theme_id.'&calendar='.$calendar_id.'&date='.($year+1).'-'.add_0(Month_num($month)).'&many_sp_calendar='.$many_sp_calendar; echo '&cur_page_url='.$path_sp_cal; if($widget) echo '&widget=1' ?>')">&#9658;</a>
                                                </td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td style="width:100% !important;vertical-align:bottom !important; padding-bottom:5px !important;">
										<table style="width:100% !important;line-height:150% !important;">
											<tr style="padding-top:5px !important">
												<td class="cala_arrow" width="40%"  style="text-align:left !important;margin:0px !important;padding:0px !important;">
													<table width="80%">
														<tr>
															<td width="15%">
																<a  style="color:<?php echo $prev_month_arrow_color ?> !important;"	 href="javascript:showbigcalendar( 'bigcalendar<?php echo $many_sp_calendar ?>','<?php  
																if(Month_num($month)==1)
																		echo admin_url('admin-ajax.php?action=spiderbigcalendar').'&theme_id='.$theme_id.'&calendar='.$calendar_id.'&date='.($year-1).'-12'.'&many_sp_calendar='.$many_sp_calendar.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'');
													
																		else echo admin_url('admin-ajax.php?action=spiderbigcalendar').'&theme_id='.$theme_id.'&calendar='.$calendar_id.'&date='.$year.'-'.add_0((Month_num($month)-1)).'&many_sp_calendar='.$many_sp_calendar.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'');
							
																?>')">&#9668; </a>
															</td>
															<td style="vertical-align:middle !important">
																<span style="font-family:arial !important; color:<?php echo $prev_month_text_color;?> !important; font-size:<?php echo $prev_month_font_size ?>px !important;"><?php echo  __(Month_name(Month_num($month)-1),'sp_calendar')  ?></span>
															</td>
														</tr>
													</table>
												</td>
												<td style="text-align:center !important; margin:0 !important; vertical-align:middle !important; padding:0px !important;" width="20%" >
                                                    <input type="hidden" name="month" readonly value="<?php echo $month?>"/>
                                                    <span  style="font-family:arial !important; color:<?php echo $text_color_month;?> !important; font-size:<?php echo $month_font_size ?>px !important;"><?php echo __($month,'sp_calendar')?></span>
										  
											
												</td>	
												<td style="margin:0 !important; padding:0 !important;text-align:right" width="40%"  class="cala_arrow"> 
													<table width="100%">
														<tr>
															<td  style="text-align:right; vertical-align:middle !important">
																<span style="font-family:arial !important; color:<?php echo $next_month_text_color;?> !important; font-size:<?php echo $next_month_font_size ?>px !important;"><?php echo  __(Month_name(Month_num($month)+1),'sp_calendar')  ?></span><?php if(!$widget) echo "&nbsp;&nbsp;&nbsp;"; else echo "&nbsp;" ?>
															</td>
															<td width="10%" style="text-align:right">
																<a  style="color:<?php echo $next_month_arrow_color ?> !important;" href="javascript:showbigcalendar( 'bigcalendar<?php echo $many_sp_calendar ?>','<?php  

																		if(Month_num($month)==12)
																		echo admin_url('admin-ajax.php?action=spiderbigcalendar').'&theme_id='.$theme_id.'&calendar='.$calendar_id.'&date='.($year+1).'-01'.'&many_sp_calendar='.$many_sp_calendar.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'');
													
																		else echo admin_url('admin-ajax.php?action=spiderbigcalendar').'&theme_id='.$theme_id.'&calendar='.$calendar_id.'&date='.$year.'-'.add_0((Month_num($month)+1)).'&many_sp_calendar='.$many_sp_calendar.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'');
							
																?>')">&#9658;</a>
															</td>
														</tr>
													</table>
												</td>													
											</tr>
									</table>
								</td>	
                            </tr>							
                        </table>					
                    </td>
                <?php } ?> 
				<?php if($month_type==2){ ?>
				
                    <td class="top_table" align="center" colspan="7" style="padding:0 !important; margin:0 !important; background-color:<?php echo $bg_top ?> !important;height:20px !important; " >

                        <?php //YEAR TABLE ?>

                   <table cellpadding="0" cellspacing="0" border="0" align="center" class="calyear_table"  style="margin:0 !important; padding:0 !important; text-align:center !important; width:100% !important; height:<?php echo $top_height ?>px !important;">

                            <tr>
								<td style="width:100% !important;vertical-align:bottom !important;padding-bottom:0px !important;">
								<table style="width:100% !important;">
								<tr>
                                <td class="cala_arrow" width="40%"  style="text-align:right !important;margin:0px !important;padding:0px">
								<a style="color:<?php echo $color_arrow_year ?>"  href="javascript:showbigcalendar( 'bigcalendar<?php echo $many_sp_calendar ?>','<?php echo admin_url('admin-ajax.php?action=spiderbigcalendar').'&theme_id='.$theme_id.'&calendar='.$calendar_id.'&date='.($year-1).'-'.add_0(Month_num($month)).'&many_sp_calendar='.$many_sp_calendar; echo '&cur_page_url='.$path_sp_cal; if($widget) echo '&widget=1'; ?>')">&#9668;</a>
								</td>


                                <td style="text-align:center !important; margin:0 !important; padding:0 !important;" width="20%" >

                                    <input name="year" type="hidden" readonly  value="<?php echo $year?>"/>
                                    <span style="font-family:arial !important;font-size:<?php echo $year_font_size ?>px !important;font-weight:bold !important;color:<?php echo $text_color_year;?> !important;"><?php echo $year;?></span> 
									
									
                                
								</td>
								<td style="margin:0 !important; padding:0 !important;text-align:left" width="40%"  class="cala_arrow"> 
								<a  style="color:<?php echo $color_arrow_year ?>"  href="javascript:showbigcalendar( 'bigcalendar<?php echo $many_sp_calendar ?>','<?php echo admin_url('admin-ajax.php?action=spiderbigcalendar').'&theme_id='.$theme_id.'&calendar='.$calendar_id.'&date='.($year+1).'-'.add_0(Month_num($month)).'&many_sp_calendar='.$many_sp_calendar; echo '&cur_page_url='.$path_sp_cal; if($widget) echo '&widget=1'; ?>')">&#9658;</a>
								</td>
								</tr>
								</table>
								</td>
								</tr>
								<tr>
								<td style="width:100% !important;vertical-align:top">
								<table style="width:100% !important;line-height:150%">
								<tr>
									<td class="cala_arrow" width="40%"  style="text-align:right !important;margin:0px !important;padding:0px">
									<a  style="color:<?php echo $color_arrow_month ?>"
													href="javascript:showbigcalendar( 'bigcalendar<?php echo $many_sp_calendar ?>','<?php  

											if(Month_num($month)==1)
											echo admin_url('admin-ajax.php?action=spiderbigcalendar').'&theme_id='.$theme_id.'&calendar='.$calendar_id.'&date='.($year-1).'-12'.'&many_sp_calendar='.$many_sp_calendar.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'');
						
											else echo admin_url('admin-ajax.php?action=spiderbigcalendar').'&theme_id='.$theme_id.'&calendar='.$calendar_id.'&date='.$year.'-'.add_0((Month_num($month)-1)).'&many_sp_calendar='.$many_sp_calendar.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'');

									?>')">&#9668;</a>
									</td>
									<td style="text-align:center !important; margin:0 !important;" width="20%" >

											<input type="hidden" name="month" readonly value="<?php echo $month?>"/>
										   <span  style="font-family:arial !important; color:<?php echo $text_color_month;?> !important; font-size:<?php echo $month_font_size ?>px !important;"><?php echo __($month,'sp_calendar')?></span>
										  
											
									</td>	
									<td style="margin:0 !important; padding:0 !important;text-align:left" width="40%"  class="cala_arrow"> 
									<a  style="color:<?php echo $color_arrow_month ?>" href="javascript:showbigcalendar( 'bigcalendar<?php echo $many_sp_calendar ?>','<?php  

											if(Month_num($month)==12)
											echo admin_url('admin-ajax.php?action=spiderbigcalendar').'&theme_id='.$theme_id.'&calendar='.$calendar_id.'&date='.($year+1).'-01'.'&many_sp_calendar='.$many_sp_calendar.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'');
						
											else echo admin_url('admin-ajax.php?action=spiderbigcalendar').'&theme_id='.$theme_id.'&calendar='.$calendar_id.'&date='.$year.'-'.add_0((Month_num($month)+1)).'&many_sp_calendar='.$many_sp_calendar.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'');

									?>')">&#9658;</a>

									</td>
													
									</tr>
									</table>
									</td>	
                            </tr>
							
                        </table>
					
                    </td>

				<?php } ?> 
				
                    <td colspan="7" style="margin:0 !important; padding:0 !important; background-color:<?php echo $bg_top ?> !important;" >

                        <?php //MONTH TABLE ?>

                    </td>

                </tr>

                <tr align="center"  height="<?php echo $week_days_cell_height ?>" style="background-color:<?php echo $weekdays_bg_color ?> !important; ">

                   <?php if($weekstart=="su"){?>			 
					 
 <td class="weekdays" style="width:<?php echo $cell_width; ?>px !important; 	color:<?php echo $color_week_days;?> !important; margin:0 !important; padding:0 !important;background-color:<?php echo $weekday_sunday_bg_color  ?>">

                    	 <div class="calbottom_border" style="text-align:center !important; width:<?php echo $cell_width; ?>px !important; margin:0 !important; padding:0 !important;"><b class="week_days"> <?php if($widget) echo __( 'Su','sp_calendar' ); else echo __( 'Sunday','sp_calendar' ); ?> </b></div></td>
						 <?php } ?>

                    <td class="weekdays" style="width:<?php echo $cell_width; ?>px !important; 	color:<?php echo $color_week_days;?> !important; margin:0 !important; padding:0">

                    	 <div class="calbottom_border" style="text-align:center !important; width:<?php echo $cell_width; ?>px !important; margin:0 !important; padding:0 !important;"><b class="week_days"> <?php if($widget) echo __( 'Mo','sp_calendar' ); else echo __( 'Monday','sp_calendar' ); ?> </b></div></td>

                    <td class="weekdays" style="width:<?php echo $cell_width; ?>px !important; 	color:<?php echo $color_week_days;?> !important; margin:0 !important; padding:0">

                   	 <div class="calbottom_border" style="text-align:center !important; width:<?php echo $cell_width; ?>px !important; margin:0 !important; padding:0 !important;"><b class="week_days"> <?php if($widget) echo __( 'Tu','sp_calendar' ); else echo __( 'Tuesday','sp_calendar' ); ?> </b></div></td>

                    <td class="weekdays" style="width:<?php echo $cell_width; ?>px !important; 	color:<?php echo $color_week_days;?> !important; margin:0 !important; padding:0">

                   	 <div class="calbottom_border" style="text-align:center !important; width:<?php echo $cell_width; ?>px !important; margin:0 !important; padding:0 !important;"><b class="week_days"> <?php if($widget) echo __( 'We','sp_calendar' ); else echo __( 'Wednesday','sp_calendar' ); ?> </b></div></td>

                    <td class="weekdays" style="width:<?php echo $cell_width; ?>px !important; 	color:<?php echo $color_week_days;?> !important; margin:0 !important; padding:0">

                    	 <div class="calbottom_border" style="text-align:center !important; width:<?php echo $cell_width; ?>px !important; margin:0 !important; padding:0 !important;"><b class="week_days"> <?php if($widget) echo __( 'Th','sp_calendar' ); else echo __( 'Thursday','sp_calendar' ); ?> </b></div></td>

					<td class="weekdays" style="width:<?php echo $cell_width; ?>px !important; 	color:<?php echo $color_week_days;?> !important; margin:0 !important; padding:0">

                   	 <div class="calbottom_border" style="text-align:center !important; width:<?php echo $cell_width; ?>px !important; margin:0 !important; padding:0 !important;"><b class="week_days"> <?php if($widget) echo __( 'Fr','sp_calendar' ); else echo __( 'Friday','sp_calendar' ); ?> </b></div></td>
					 
                    <td class="weekdays" style="width:<?php echo $cell_width; ?>px !important;	color:<?php echo $color_week_days;?> !important; margin:0 !important; padding:0">

                   	 <div class="calbottom_border" style="text-align:center !important; width:<?php echo $cell_width; ?>px !important; margin:0 !important; padding:0 !important;"><b class="week_days"> <?php if($widget) echo __( 'Sa','sp_calendar' ); else echo __( 'Saturday','sp_calendar' ); ?> </b></div></td>
	<?php if($weekstart=="mo"){?>			 
					 
 <td class="weekdays" style="width:<?php echo $cell_width; ?>px !important; 	color:<?php echo $color_week_days;?> !important; margin:0 !important; padding:0 !important;background-color:<?php echo $weekday_sunday_bg_color  ?>">

                    	 <div class="calbottom_border" style="text-align:center !important; width:<?php echo $cell_width; ?>px !important; margin:0 !important; padding:0 !important;"><b class="week_days"> <?php if($widget) echo __( 'Su','sp_calendar' ); else echo __( 'Sunday','sp_calendar' ); ?> </b></div></td>
						 <?php } ?>
                </tr>

				
                    <?php

//$today=$realtoday;
/*$document = &JFactory::getDocument();
   $document->addScript("media/system/js/thickbox-preview.js");
   $document->addStyleSheet("media/system/css/thickbox-preview.css");*/
   







$month_first_weekday = date("N", mktime(0, 0, 0, Month_num($month), 1, $year));

if($weekstart=="su"){
$month_first_weekday++;
if($month_first_weekday==8)
$month_first_weekday=1;
}

$month_days = date("t", mktime(0, 0, 0, Month_num($month), 1, $year));

$last_month_days = date("t", mktime(0, 0, 0, Month_num($month)-1, 1, $year));

$weekday_i=$month_first_weekday;

$last_month_days=$last_month_days-$weekday_i+2;

$percent=1;

$sum=$month_days-8+$month_first_weekday;

if($sum % 7 <> 0)

$percent = $percent + 1;

$sum = $sum - ( $sum % 7 );

$percent = $percent + ( $sum / 7 );

$percent=107/$percent;
$all_calendar_files=php_getdays();

$array_days=$all_calendar_files[0]['array_days'];
$array_days1=$all_calendar_files[0]['array_days1'];
$title=$all_calendar_files[0]['title'];
$ev_ids=$all_calendar_files[0]['ev_ids'];




//var_dump($title);
//var_dump($array_days);

echo '<tr  id="days"  height="'.$cell_height.'" style="line-height:15px !important;">';

for($i=1; $i<$weekday_i; $i++)

{


echo '<td class="caltext_color_other_months" style="background-color:'.$bg_color_other_months.'"  ><span style="font-size:'.$other_days_font_size.'px !important;">'.$last_month_days.'</span></td>';

$last_month_days=$last_month_days+1;

}






for($i=1; $i<=$month_days; $i++)

{

if(isset($title[$i]))
{
$ev_title=explode('</p>',$title[$i]);
array_pop($ev_title);
$k=count($ev_title);
////
$ev_id=explode('<br>',$ev_ids[$i]);
array_pop($ev_id);
$ev_ids_inline=implode(',' , $ev_id);



}


$dayevent='';

	if(($weekday_i%7==0 and $weekstart=="mo") or ($weekday_i%7==1 and $weekstart=="su"))

	{
	
		if($i==$day_REFERER and $month==$month_REFERER and $year==$year_REFERER )
	
		{ 
		
		if($widget){
			if($k!=1)
			echo  '<td bgcolor="'.$bg_color_selected.'"  class="cala_day" style="padding:0 !important; margin:0 !important;line-height:15px !important;"><div class="calborder_day" style=" width:'.$cell_width.'px !important; margin:0 !important; padding:0 !important;"><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.admin_url('admin-ajax.php?action=spiderseemore').'&theme_id='.$theme_id.'&ev_ids='.$ev_ids_inline.'&calendar_id='.$calendar_id.'&date='.$year.'-'.add_0(Month_num($month).'-'.$i).'&cur_page_url='.$path_sp_cal.'&widget=1&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'"><b style="color:'.$evented_color.'">'.$i.'</b></a></td></div>';
			else
			echo  '<td bgcolor="'.$bg_color_selected.'"  class="cala_day" style="padding:0 !important; margin:0 !important;line-height:15px !important;"><div class="calborder_day" style=" width:'.$cell_width.'px !important; margin:0 !important; padding:0 !important;"><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.admin_url('admin-ajax.php?action=spiderbigcalendarrr').'&day='.$i.'&theme_id='.$theme_id.'&calendar_id='.$calendar_id.'&ev_ids='.$ev_ids_inline.'&eventID='.$ev_id[0].'&date='.$year.'-'.add_0(Month_num($month).'-'.$i).'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'"><b style="color:'.$evented_color.'">'.$i.'</b></a></td></div>';
		}
		else{
		
			echo  '<td bgcolor="'.$bg_color_selected.'"  class="cala_day" style="padding:0 !important; margin:0 !important;line-height:15px !important;"><div class="calborder_day" style=" width:'.$cell_width.'px !important; margin:0 !important; padding:0 !important;"><b style="color:'.$evented_color.'">'.$i.'</b>';
		$r=0;
		for($j=0;$j<$k; $j++)	
			{
			if($r<$number_of_shown_evetns)
			echo '<a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="background:none !important;color:'.$event_title_color.' !important; " href="'.admin_url('admin-ajax.php?action=spiderbigcalendarrr').'&day='.$i.'&theme_id='.$theme_id.'&calendar_id='.$calendar_id.'&ev_ids='.$ev_ids_inline.'&eventID='.$ev_id[$j].'&date='.$year.'-'.add_0(Month_num($month).'-'.$i).'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" ><b>'.$ev_title[$j].'</b></a>';
			else
			{
			echo '<br><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.admin_url('admin-ajax.php?action=spiderseemore').'&theme_id='.$theme_id.'&ev_ids='.$ev_ids_inline.'&calendar_id='.$calendar_id.'&date='.$year.'-'.add_0(Month_num($month).'-'.$i).'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'"> <b>'.__('See more...','sp_calendar').'</b></a>';
			break;
			}
			$r++;
			}
			
			echo '</div></td>';
			}
		}
	
		else
		
		if($i==date('j') and $month==date('F') and $year==date('Y'))
		{
	
			if( in_array ($i,$array_days)){
			if($widget){
				if($k!=1)
				echo  '<td class="cala_day" style="background-color:'.$evented_color_bg.' !important;padding:0 !important; margin:0 !important;line-height:15px !important; border: px solid '.$border_day.' !important;"><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.admin_url('admin-ajax.php?action=spiderseemore').'&theme_id='.$theme_id.'&ev_ids='.$ev_ids_inline.'&calendar_id='.$calendar_id.'&date='.$year.'-'.add_0(Month_num($month).'-'.$i).'&cur_page_url='.$path_sp_cal.'&widget=1&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'&Itemid=1" '.$dayevent.'><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px">'.$i.'</b></a></td>';
			 	else
				echo  '<td class="cala_day" style="background-color:'.$evented_color_bg.' !important;padding:0 !important; margin:0 !important;line-height:15px !important; border: px solid '.$border_day.' !important;"><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.admin_url('admin-ajax.php?action=spiderbigcalendarrr').'&day='.$i.'&theme_id='.$theme_id.'&calendar_id='.$calendar_id.'&ev_ids='.$ev_ids_inline.'&eventID='.$ev_id[0].'&date='.$year.'-'.add_0(Month_num($month).'-'.$i).'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" '.$dayevent.'><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px">'.$i.'</b></a></td>';
			}
			else
			{
			
	
	echo  '<td class="cala_day" style="background-color:'.$evented_color_bg.' !important;padding:0 !important; margin:0 !important;line-height:15px !important; border: '.(($widget)?($all_days_border_width):'1').'px solid '.$border_day.' !important;"><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px">'.$i.'</b>';
	$r=0;
	
	for($j=0;$j<$k; $j++)	
			{
			if($r<$number_of_shown_evetns)
				echo '<a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="background:none !important;color:'.$event_title_color.' !important; " href="'.admin_url('admin-ajax.php?action=spiderbigcalendarrr').'&day='.$i.'&theme_id='.$theme_id.'&calendar_id='.$calendar_id.'&ev_ids='.$ev_ids_inline.'&eventID='.$ev_id[$j].'&date='.$year.'-'.add_0(Month_num($month).'-'.$i).'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" ><b>'.$ev_title[$j].'</b></a>';
			else
			{
				echo '<br><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.admin_url('admin-ajax.php?action=spiderseemore').'&theme_id='.$theme_id.'&ev_ids='.$ev_ids_inline.'&calendar_id='.$calendar_id.'&date='.$year.'-'.add_0(Month_num($month).'-'.$i).'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'&Itemid=1" '.$dayevent.'> <b>'.__('See more...','sp_calendar').'</b></a>';
				break;
			}
				$r++;
				}
			echo '</td>';
	}
	}
			else
	
			echo  '<td class="calsun_days" style="padding:0 !important; font-size:'.$sundays_font_size.'px !important; margin:0 !important;line-height:15px !important; border: '.(($widget)?($all_days_border_width):'1').'px solid '.$border_day.' !important;"><b>'.$i.'</b></td>';
	
		}

		else
		{
	
			if( in_array ($i,$array_days)){
			if($widget){
			if($k!=1)
				echo  '<td class="cala_day" style="background-color:'.$evented_color_bg.' !important;padding:0 !important; margin:0 !important;line-height:15px !important;"><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.admin_url('admin-ajax.php?action=spiderseemore').'&theme_id='.$theme_id.'&ev_ids='.$ev_ids_inline.'&calendar_id='.$calendar_id.'&date='.$year.'-'.add_0(Month_num($month)).'-'.$i.'&Itemid='.$Itemid.'&cur_page_url='.$path_sp_cal.'&widget=1&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" '.$dayevent.'><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px !important;">'.$i.'</b></a></td>';
				else
				echo  '<td class="cala_day" style="background-color:'.$evented_color_bg.' !important;padding:0 !important; margin:0 !important;line-height:15px !important;"><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.admin_url('admin-ajax.php?action=spiderbigcalendarrr').'&day='.$i.'&theme_id='.$theme_id.'&calendar_id='.$calendar_id.'&ev_ids='.$ev_ids_inline.'&eventID='.$ev_id[0].'&date='.$year.'-'.add_0(Month_num($month).'-'.$i).'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" '.$dayevent.'><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px !important;">'.$i.'</b></a></td>';
			}
			else
			{
			
			echo  '<td class="cala_day" style="background-color:'.$evented_color_bg.' !important;padding:0 !important; margin:0 !important;line-height:15px !important;"><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px !important;">'.$i.'</b>';
			$r=0;
			for($j=0;$j<$k; $j++)
			{
			if($r<$number_of_shown_evetns)
			echo '<a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="background:none !important;color:'.$event_title_color.' !important; " href="'.admin_url('admin-ajax.php?action=spiderbigcalendarrr').'&day='.$i.'&theme_id='.$theme_id.'&calendar_id='.$calendar_id.'&ev_ids='.$ev_ids_inline.'&eventID='.$ev_id[$j].'&date='.$year.'-'.add_0(Month_num($month).'-'.$i).'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" ><b>'.$ev_title[$j].'</b></a>';
			else
			{
			echo '<br><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.admin_url('admin-ajax.php?action=spiderseemore').'&theme_id='.$theme_id.'&ev_ids='.$ev_ids_inline.'&calendar_id='.$calendar_id.'&date='.$year.'-'.add_0(Month_num($month)).'-'.$i.'&Itemid='.$Itemid.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" '.$dayevent.'> <b>'.__('See more...','sp_calendar').'</b></a>';
			break;
			}
			$r++;
			}
			echo '</td>';
			}
			}
			else
	
			echo  '<td class="calsun_days" style="padding:0 !important; margin:0 !important;line-height:15px !important;font-size:'.$sundays_font_size.'px !important; "><b>'.$i.'</b></td>';
	
		}

	}
/////////////////////////////////////////////////////////////////////////mec else
	else

		if($i==$day_REFERER and $month==$month_REFERER and $year==$year_REFERER )
	
		{ 
			if($widget)
			{
				if($k!=1)
				echo  '<td bgcolor="'.$bg_color_selected.'" class="cala_day" style="padding:0 !important; margin:0 !important;line-height:15px !important;"><div class="calborder_day" style=" width:'.$cell_width.'px !important; margin:0 !important; padding:0 !important;"><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.admin_url('admin-ajax.php?action=spiderseemore').'&theme_id='.$theme_id.'&ev_ids='.$ev_ids_inline.'&calendar_id='.$calendar_id.'&date='.$year.'-'.add_0(Month_num($month)).'-'.$i.'&Itemid='.$Itemid.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" '.$dayevent.'><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px">'.$i.'</b></a></div></td>';
				else
				echo  '<td bgcolor="'.$bg_color_selected.'" class="cala_day" style="padding:0 !important; margin:0 !important;line-height:15px !important;"><div class="calborder_day" style=" width:'.$cell_width.'px !important; margin:0 !important; padding:0 !important;"><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.admin_url('admin-ajax.php?action=spiderbigcalendarrr').'&day='.$i.'&theme_id='.$theme_id.'&calendar_id='.$calendar_id.'&ev_ids='.$ev_ids_inline.'&eventID='.$ev_id[0].'&date='.$year.'-'.add_0(Month_num($month).'-'.$i).'&Itemid='.$Itemid.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" '.$dayevent.'><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px">'.$i.'</b></a></div></td>';
			}
			else
			{
			
			echo  '<td bgcolor="'.$bg_color_selected.'" class="cala_day" style="padding:0 !important; margin:0 !important;line-height:15px !important;"><div class="calborder_day" style=" width:'.$cell_width.'px !important; margin:0 !important; padding:0 !important;"><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px">'.$i.'</b>';
			$r=0;
			for($j=0;$j<$k; $j++)
			{
			if($r<$number_of_shown_evetns)
			echo '<a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="background:none !important;color:'.$event_title_color.' !important; " href="'.admin_url('admin-ajax.php?action=spiderbigcalendarrr').'&day='.$i.'&theme_id='.$theme_id.'&calendar_id='.$calendar_id.'&ev_ids='.$ev_ids_inline.'&eventID='.$ev_id[$j].'&date='.$year.'-'.add_0(Month_num($month).'-'.$i).'&Itemid='.$Itemid.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" ><b>'.$ev_title[$j].'</b></a>';
			else
			{
			echo '<br><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.admin_url('admin-ajax.php?action=spiderseemore').'&theme_id='.$theme_id.'&ev_ids='.$ev_ids_inline.'&calendar_id='.$calendar_id.'&date='.$year.'-'.add_0(Month_num($month)).'-'.$i.'&Itemid='.$Itemid.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" '.$dayevent.'> <b>'.__('See more...','sp_calendar').'</b></a>';
			break;
			}
			$r++;
			}
			echo '</div></td>';
		}
		}

		else
	
		{
			if($i==date('j') and $month==date('F') and $year==date('Y'))
			
		{
				if( in_array ($i,$array_days)){
					if($widget)
					{
						if($k!=1)
						echo  '<td class="cala_day" style="background-color:'.$evented_color_bg.' !important;padding:0 !important; margin:0 !important;line-height:15px !important; border: 3px solid '.$current_day_border_color.' !important;"><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.admin_url('admin-ajax.php?action=spiderseemore').'&theme_id='.$theme_id.'&ev_ids='.$ev_ids_inline.'&calendar_id='.$calendar_id.'&date='.$year.'-'.add_0(Month_num($month)).'-'.$i.'&Itemid='.$Itemid.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" '.$dayevent.'><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px">'.$i.'</b></a></td>';
						else
						echo  '<td class="cala_day" style="background-color:'.$evented_color_bg.' !important;padding:0 !important; margin:0 !important;line-height:15px !important; border: 3px solid '.$current_day_border_color.' !important;"><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.admin_url('admin-ajax.php?action=spiderbigcalendarrr').'&day='.$i.'&theme_id='.$theme_id.'&calendar_id='.$calendar_id.'&ev_ids='.$ev_ids_inline.'&eventID='.$ev_id[0].'&date='.$year.'-'.add_0(Month_num($month)).'-'.$i.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" '.$dayevent.'><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px">'.$i.'</b></a></td>';
					}
					else
					{
						
					
		
				
			echo  '<td class="cala_day" style="background-color:'.$evented_color_bg.' !important;padding:0 !important; margin:0 !important;line-height:15px !important; border: 3px solid '.$current_day_border_color.' !important;"><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px">'.$i.'</b>';
			$r=0;
			for($j=0;$j<$k; $j++)
			{
			if($r<$number_of_shown_evetns)
			echo '<a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="background:none !important;color:'.$event_title_color.' !important; " href="'.admin_url('admin-ajax.php?action=spiderbigcalendarrr').'&day='.$i.'&theme_id='.$theme_id.'&calendar_id='.$calendar_id.'&ev_ids='.$ev_ids_inline.'&eventID='.$ev_id[$j].'&date='.$year.'-'.add_0(Month_num($month)).'-'.$i.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" ><b>'.$ev_title[$j].'</b></a>';
			else{
			echo '<br><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.admin_url('admin-ajax.php?action=spiderseemore').'&theme_id='.$theme_id.'&ev_ids='.$ev_ids_inline.'&calendar_id='.$calendar_id.'&date='.$year.'-'.add_0(Month_num($month)).'-'.$i.'&Itemid='.$Itemid.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" '.$dayevent.'> <b>'.__('See more...','sp_calendar').'</b></a>';
			break;
			}
			$r++;
			}			
			echo '</td>';
				}
				}
		
				else
		
				echo  '<td style=" color:'.$text_color_this_month_unevented.' !important;padding:0 !important; margin:0 !important; line-height:15px !important; border: 3px solid '.$current_day_border_color.' !important; '.(($widget)?('vertical-align:middle !important; text-align: center'):'vertical-align:top').' !important;"><b style="font-size:'.$other_days_font_size.'px">'.$i.'</b></td>';
		
		}
	
	else
			if( in_array ($i,$array_days)){
				if($widget)
					{
						if($k!=1)
						echo  '<td class="cala_day" style="background-color:'.$evented_color_bg.' !important;padding:0 !important; margin:0 !important;line-height:15px !important;"><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.admin_url('admin-ajax.php?action=spiderseemore').'&theme_id='.$theme_id.'&ev_ids='.$ev_ids_inline.'&calendar_id='.$calendar_id.'&date='.$year.'-'.add_0(Month_num($month)).'-'.$i.'&Itemid='.$Itemid.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" '.$dayevent.'><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px !important;">'.$i.'</b></a></b>';
						else
						echo  '<td class="cala_day" style="background-color:'.$evented_color_bg.' !important;padding:0 !important; margin:0 !important;line-height:15px !important;"><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.admin_url('admin-ajax.php?action=spiderbigcalendarrr').'&day='.$i.'&theme_id='.$theme_id.'&calendar_id='.$calendar_id.'&ev_ids='.$ev_ids_inline.'&eventID='.$ev_id[0].'&date='.$year.'-'.add_0(Month_num($month)).'-'.$i.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" '.$dayevent.'><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px !important;">'.$i.'</b></a></b>';
					
					}
					else
					{
					
		
		echo  '<td class="cala_day" style="background-color:'.$evented_color_bg.' !important;padding:0 !important; margin:0 !important;line-height:15px !important;"><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px !important;">'.$i.'</b>';
		$r=0;
		for($j=0;$j<$k; $j++)
			{
			if($r<$number_of_shown_evetns)
			echo '<a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="background:none !important;color:'.$event_title_color.' !important; " href="'.admin_url('admin-ajax.php?action=spiderbigcalendarrr').'&day='.$i.'&theme_id='.$theme_id.'&calendar_id='.$calendar_id.'&ev_ids='.$ev_ids_inline.'&eventID='.$ev_id[$j].'&date='.$year.'-'.add_0(Month_num($month)).'-'.$i.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" ><b>'.$ev_title[$j].'</b></a>';
			else{
			echo '<p><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.admin_url('admin-ajax.php?action=spiderseemore').'&theme_id='.$theme_id.'&ev_ids='.$ev_ids_inline.'&calendar_id='.$calendar_id.'&date='.$year.'-'.add_0(Month_num($month)).'-'.$i.'&Itemid='.$Itemid.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" '.$dayevent.'> <b>'.__('See more...','sp_calendar').'</b></a></p>';
			break;
			}
			$r++;
			}
			echo '</td>';
			}}
	
			else
	
			echo  '<td style=" color:'.$text_color_this_month_unevented.' !important;padding:0 !important; margin:0 !important; line-height:15px !important;border: '.(($widget)?($all_days_border_width):'1').'px solid '.$cell_border_color.' !important; '.(($widget)?('vertical-align:middle !important; text-align: center'):'vertical-align:top').' !important;"><b style="font-size:'.$other_days_font_size.'px">'.$i.'</b></td>';
	
			

	}

	if($weekday_i%7==0 && $i<>$month_days)

	{
	
	echo '</tr><tr height="'.$cell_height.'" style="!important;line-height:15px">';

	$weekday_i=0;

	}

	$weekday_i=$weekday_i+1;

}

$weekday_i;

$next_i=1;

if($weekday_i!=1)

for($i=$weekday_i; $i<=7; $i++)

{
if($i!=7)
echo '<td class="caltext_color_other_months" style="background-color:'.$bg_color_other_months.' !important;"  ><span style="font-size:'.$other_days_font_size.'px !important;">'.$next_i.'</span></td>';
else
echo '<td class="caltext_color_other_months" style="background-color:'.$bg_color_other_months.' !important;"  ><span style="font-size:'.$other_days_font_size.'px !important;">'.$next_i.'</span></td>';
$next_i=$next_i+1;

}

echo '</tr></table>';

?>

                    <input type="text" value="1" name="day" style="display:none" />

          

               

        </td>

    </tr>

</table>


</div>

<?php 



function php_Month_num($month_name)

	{
		for( $month_num=1; $month_num<=12; $month_num++ )
		
		{  
		    if (date( "F", mktime(0, 0, 0, $month_num, 1, 0 ) ) == $month_name and ($month_num<10) )
		    
		    {
			return '0'.$month_num;  
			
		    }
		    
		    else
		    
		    {
			return $month_num;  
			
		    } 

		     
		}
		
	}
	
	
	die();			
	}



function seemore(){
	function php_Month_num($month_name)

		

	{

		for( $month_num=1; $month_num<=12; $month_num++ )

		

		{  

		    if (date( "F", mktime(0, 0, 0, $month_num, 1, 0 ) ) == $month_name)
		    {  
				return $month_num; 
		    } 

			     

		}

			

	}

	
	function php_showevent()



	{
		global $wpdb;
		
		if(isset($_GET['calendar_id']))
		$calendar	=$_GET['calendar_id'];
		else
		$calendar=0;
		if(isset($_GET['date'])){
		if(IsDate_inputed($_GET['date']))
			$date=$_GET['date'];
			else
			$date=date("Y-m-d");	
		}
		else 
		$date=date("Y").'-'.php_Month_num(date("F")).'-'.date("d");
		$year=substr( $date,0,4); 
		$month=substr( $date,5,2); 
	
		$query =  $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."spidercalendar_event where calendar=%d",$calendar);
			
	
  
  $rows = $wpdb->get_results($query);
			$all_spider_files['rows']=$rows;
			$all_spider_files['option']=$option;
		return array($all_spider_files);



	}
	
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


	
 

 	 	 $title_color='#'.$theme->title_color;
		 
		 $title_size=$theme->title_font_size;
		 
		 $title_font=$theme->title_font;
		 
		 $title_style=$theme->title_style;
		 
		 $date_color='#'.$theme->date_color;
		 
		 $date_size=$theme->date_size;
		 
		 $date_font=$theme->date_font;
		 
		 $date_style=$theme->date_style;
		 
		 $next_prev_event_bgcolor='#'.$theme->next_prev_event_bgcolor;
		 $next_prev_event_arrowcolor='#'.$theme->next_prev_event_arrowcolor;
		 $show_event_bgcolor='#'.$theme->show_event_bgcolor;
		 
		 $popup_width = $theme->popup_width;
		 $popup_height = $theme->popup_height;
		 $show_event= $theme->day_start;
		 
		 $date_format='';
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
				   
					
				   window.location='<?php echo admin_url('admin-ajax.php?action=spiderbigcalendarrr')?>?theme_id='+theme_id+'&calendar_id='+calendar_id+'&eventID='+day_events[parseInt(key) +1]+'&date='+date+'&day='+day<?php if($widget)echo "+'&widget=1'" ?>;
		  
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
				   
					
				   window.location='<?php echo admin_url('admin-ajax.php?action=spiderbigcalendarrr') ?>?theme_id='+theme_id+'&calendar_id='+calendar_id+'&eventID='+day_events[parseInt(key) -1]+'&date='+date+'&day='+day<?php if($widget)echo "+'&widget=1'" ?>;
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
  
<div style="background-color:<?php echo $show_event_bgcolor ?>; height:<?php echo $popup_height-30 ?>px;padding:15px;">
 <?php 
 

 
 foreach($rows as $row)
 {
 for($i=0;$i<count($ev_id);$i++)
 if($row->id==$ev_id[$i]){
 echo '<div ><a style="font-size:'.$title_size.'px;color:'.$title_color.'; line-height:30px" href="'.admin_url('admin-ajax.php?action=spiderbigcalendarrr').'&theme_id='.$theme_id.'&calendar_id='.$calendar_id.'&ev_ids='.$ev_ids.'&eventID='.$ev_id[$i].'&date='.$date.'&day='.$day.(($widget)?('&widget=1'):'').'&cur_page_url='.$path_sp_cal.'">';
 if($show_event)
 echo ($i+1);
 echo ' '.$row->title .'</a></div>';
 }
 
 
 }
 
 
 
 
 ?>
 </div>
 <?php
	die();
	}


function spiderbigcalendar(){
	function php_Month_num($month_name)

		

	{

		for( $month_num=1; $month_num<=12; $month_num++ )

		

		{  

		    if (date( "F", mktime(0, 0, 0, $month_num, 1, 0 ) ) == $month_name)

			    

		    {  

			return $month_num;  

				

		    } 

			     

		}

			

	}

	
	function php_showevent()



	{
		global $wpdb;
		if(isset($_GET['date']))
		{
			
			if(IsDate_inputed($_GET['date']))
			$date=$_GET['date'];
			else
			$date=date("Y").'-'.php_Month_num(date("F")).'-'.date("d");
		}
		else
		{
			
			$date=date("Y").'-'.php_Month_num(date("F")).'-'.date("d");
		}
		if(isset($_GET['calendar_id']))
		{
			
		$calendar	=$_GET['calendar_id'];
		}
		else
		{
			$calendar=0;
		}
		$year=substr( $date,0,4); 
		$month=substr( $date,5,2); 
				
		$eventID=$_GET['eventID'];
		$row =$wpdb->get_row($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'spidercalendar_event WHERE id=%d',$eventID));			
			$all_files_spider_cal['row']=$row;
			$all_files_spider_cal['option']=$option;
			
		return array($all_files_spider_cal);



	}
	
	
	
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

 if(isset($_GET['widget']))
{
	$widget=1;
}
else
{
	$widget=0;
}

 $theme_id =$_GET['theme_id'];
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

		
	
 

 	 	 $title_color='#'.$theme->title_color;
		 
		 $title_size=$theme->title_font_size;
		 
		 $title_font=$theme->title_font;
		 
		 $title_style=$theme->title_style;
		 
		 $date_color='#'.$theme->date_color;
		 
		 $date_size=$theme->date_size;
		 
		 $date_font=$theme->date_font;
		 
		 $date_style=$theme->date_style;
		 
		 $next_prev_event_bgcolor='#'.$theme->next_prev_event_bgcolor;
		 $next_prev_event_arrowcolor='#'.$theme->next_prev_event_arrowcolor;
		 $show_event_bgcolor='#'.$theme->show_event_bgcolor;
		 
		 $popup_width = $theme->popup_width;
		 $popup_height = $theme->popup_height;
		 
		 
		 $date_format=$theme->date_format;
		 
		 $show_repeat=$theme->show_repeat;
		
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
				   
					
				   window.location='<?php echo admin_url('admin-ajax.php?action=spiderbigcalendarrr')?>&theme_id='+theme_id+'&calendar_id='+calendar_id+'&eventID='+day_events[parseInt(key) +1]+'&date='+date+'&day='+day+'&ev_ids='+ev_ids<?php if($widget)echo "+'&widget=1'" ?>;
		  
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
				   
					
				   window.location='<?php echo admin_url('admin-ajax.php?action=spiderbigcalendarrr')?>&theme_id='+theme_id+'&calendar_id='+calendar_id+'&eventID='+day_events[parseInt(key) -1]+'&date='+date+'&ev_ids='+ev_ids+'&day='+day<?php if($widget)echo "+'&widget=1'" ?>;
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
		
		<td  id="previous" onClick="prev([<?php echo $ev_ids_inline ?>],<?php echo $eventID ?>,<?php echo $theme_id ?>,<?php echo $calendar_id ?>,'<?php echo $date; ?>',<?php echo $day ?>,'<?php echo $ev_ids_inline ?>')"  style="<?php if(count($ev_id)==1 or $eventID==$ev_id[0] ) echo 'display:none' ?>;text-align:center" onMouseOver="document.getElementById('previous').style.backgroundColor='<?php echo $next_prev_event_bgcolor ?>'" onMouseOut="document.getElementById('previous').style.backgroundColor=''" >
		
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
		echo '<h1 style="text-align:center">There Is No Text For This Event</h1>';
		}
		echo '</div>';	
		
	?>
	<div style="width:98%;text-align:right; display:<?php if(count($ev_id)==1) echo 'none'; ?>"><a style="color:<?php echo $title_color?>;font-size:15px; font-family:<?php echo $title_font?>; <?php echo $font_weight?>; <?php echo $font_style?>" href="<?php echo admin_url('admin-ajax.php?action=spiderseemore').'&theme_id='.$theme_id.'&ev_ids='.$ev_ids_inline.'&calendar_id='.$calendar_id.'&date='.$date.''.(($widget)?('&widget=1'):'') ?>">Back to event list</a></div>
	</td>
	
	<td id="next"  onclick="next([<?php echo $ev_ids_inline ?>],<?php echo $eventID ?>,<?php echo $theme_id ?>,<?php echo $calendar_id ?>,'<?php echo $date ?>',<?php echo $day ?>,'<?php echo $ev_ids_inline ?>')"   style="<?php if(count($ev_id)==1 or $eventID==end($ev_id)) echo 'display:none' ?>;text-align:center" onMouseOver="document.getElementById('next').style.backgroundColor='<?php echo $next_prev_event_bgcolor ?>'" onMouseOut="document.getElementById('next').style.backgroundColor=''" >
	
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
die();
	
	}

?>