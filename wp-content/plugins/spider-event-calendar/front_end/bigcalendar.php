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
require_once("functions_bigcalendar.php");
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
													<a style="color:<?php echo $color_arrow_year ?>"  href="javascript:showbigcalendar( 'bigcalendar<?php echo $many_sp_calendar ?>','<?php echo plugins_url("bigcalendar.php",__FILE__).'?theme_id='.$theme_id.'&calendar='.$calendar_id.'&date='.($year-1).'-'.add_0(Month_num($month)).'&many_sp_calendar='.$many_sp_calendar; echo '&cur_page_url='.$path_sp_cal; if($widget) echo '&widget=1'; ?>')">&#9668;</a>
												 </td>
                               					 <td style="text-align:center !important; margin:0 !important; padding:0 !important;" width="20%" >
                                   					 <input name="year" type="hidden" readonly=""  value="<?php echo $year?>"/>
                                  					  <span style="font-family:arial !important;font-size:<?php echo $year_font_size ?>px !important;font-weight:bold !important;color:<?php echo $text_color_year;?> !important;"><?php echo $year;?></span> 
												</td>
                                                <td style="margin:0 !important; padding:0 !important;text-align:left !important;" width="40%"  class="cala_arrow"> 
                                             	   <a  style="color:<?php echo $color_arrow_year ?>"  href="javascript:showbigcalendar( 'bigcalendar<?php echo $many_sp_calendar ?>','<?php echo plugins_url("bigcalendar.php",__FILE__).'?theme_id='.$theme_id.'&calendar='.$calendar_id.'&date='.($year+1).'-'.add_0(Month_num($month)).'&many_sp_calendar='.$many_sp_calendar; echo '&cur_page_url='.$path_sp_cal; if($widget) echo '&widget=1' ?>')">&#9658;</a>
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
																		echo plugins_url("bigcalendar.php",__FILE__).'?theme_id='.$theme_id.'&calendar='.$calendar_id.'&date='.($year-1).'-12'.'&many_sp_calendar='.$many_sp_calendar.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'');
													
																		else echo plugins_url("bigcalendar.php",__FILE__).'?theme_id='.$theme_id.'&calendar='.$calendar_id.'&date='.$year.'-'.add_0((Month_num($month)-1)).'&many_sp_calendar='.$many_sp_calendar.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'');
							
																?>')">&#9668; </a>
															</td>
															<td style="vertical-align:middle !important">
																<span style="font-family:arial !important; color:<?php echo $prev_month_text_color;?> !important; font-size:<?php echo $prev_month_font_size ?>px !important;"><?php echo  __(Month_name(Month_num($month)-1),'sp_calendar')  ?></span>
															</td>
														</tr>
													</table>
												</td>
												<td style="text-align:center !important; margin:0 !important; vertical-align:middle !important; padding:0px !important;" width="20%" >
                                                    <input type="hidden" name="month" readonly="" value="<?php echo $month?>"/>
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
																		echo plugins_url("bigcalendar.php",__FILE__).'?theme_id='.$theme_id.'&calendar='.$calendar_id.'&date='.($year+1).'-01'.'&many_sp_calendar='.$many_sp_calendar.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'');
													
																		else echo plugins_url("bigcalendar.php",__FILE__).'?theme_id='.$theme_id.'&calendar='.$calendar_id.'&date='.$year.'-'.add_0((Month_num($month)+1)).'&many_sp_calendar='.$many_sp_calendar.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'');
							
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
								<a style="color:<?php echo $color_arrow_year ?>"  href="javascript:showbigcalendar( 'bigcalendar<?php echo $many_sp_calendar ?>','<?php echo plugins_url("bigcalendar.php",__FILE__).'?theme_id='.$theme_id.'&calendar='.$calendar_id.'&date='.($year-1).'-'.add_0(Month_num($month)).'&many_sp_calendar='.$many_sp_calendar; echo '&cur_page_url='.$path_sp_cal; if($widget) echo '&widget=1'; ?>')">&#9668;</a>
								</td>


                                <td style="text-align:center !important; margin:0 !important; padding:0 !important;" width="20%" >

                                    <input name="year" type="hidden" readonly=""  value="<?php echo $year?>"/>
                                    <span style="font-family:arial !important;font-size:<?php echo $year_font_size ?>px !important;font-weight:bold !important;color:<?php echo $text_color_year;?> !important;"><?php echo $year;?></span> 
									
									
                                
								</td>
								<td style="margin:0 !important; padding:0 !important;text-align:left" width="40%"  class="cala_arrow"> 
								<a  style="color:<?php echo $color_arrow_year ?>"  href="javascript:showbigcalendar( 'bigcalendar<?php echo $many_sp_calendar ?>','<?php echo plugins_url("bigcalendar.php",__FILE__).'?theme_id='.$theme_id.'&calendar='.$calendar_id.'&date='.($year+1).'-'.add_0(Month_num($month)).'&many_sp_calendar='.$many_sp_calendar; echo '&cur_page_url='.$path_sp_cal; if($widget) echo '&widget=1'; ?>')">&#9658;</a>
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
											echo plugins_url("bigcalendar.php",__FILE__).'?theme_id='.$theme_id.'&calendar='.$calendar_id.'&date='.($year-1).'-12'.'&many_sp_calendar='.$many_sp_calendar.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'');
						
											else echo plugins_url("bigcalendar.php",__FILE__).'?theme_id='.$theme_id.'&calendar='.$calendar_id.'&date='.$year.'-'.add_0((Month_num($month)-1)).'&many_sp_calendar='.$many_sp_calendar.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'');

									?>')">&#9668;</a>
									</td>
									<td style="text-align:center !important; margin:0 !important;" width="20%" >

											<input type="hidden" name="month" readonly="" value="<?php echo $month?>"/>
										   <span  style="font-family:arial !important; color:<?php echo $text_color_month;?> !important; font-size:<?php echo $month_font_size ?>px !important;"><?php echo __($month,'sp_calendar')?></span>
										  
											
									</td>	
									<td style="margin:0 !important; padding:0 !important;text-align:left" width="40%"  class="cala_arrow"> 
									<a  style="color:<?php echo $color_arrow_month ?>" href="javascript:showbigcalendar( 'bigcalendar<?php echo $many_sp_calendar ?>','<?php  

											if(Month_num($month)==12)
											echo plugins_url("bigcalendar.php",__FILE__).'?theme_id='.$theme_id.'&calendar='.$calendar_id.'&date='.($year+1).'-01'.'&many_sp_calendar='.$many_sp_calendar.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'');
						
											else echo plugins_url("bigcalendar.php",__FILE__).'?theme_id='.$theme_id.'&calendar='.$calendar_id.'&date='.$year.'-'.add_0((Month_num($month)+1)).'&many_sp_calendar='.$many_sp_calendar.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'');

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

function Month_name($month_num)

{

    $timestamp = mktime(0, 0, 0, $month_num, 1, 2005);
 
    return date("F", $timestamp); 
    
};

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
			echo  '<td bgcolor="'.$bg_color_selected.'"  class="cala_day" style="padding:0 !important; margin:0 !important;line-height:15px !important;"><div class="calborder_day" style=" width:'.$cell_width.'px !important; margin:0 !important; padding:0 !important;"><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.plugins_url("spidercalendarbig_seemore.php",__FILE__).'?theme_id='.$theme_id.'&ev_ids='.$ev_ids_inline.'&calendar_id='.$calendar_id.'&date='.$year.'-'.add_0(Month_num($month).'-'.$i).'&cur_page_url='.$path_sp_cal.'&widget=1&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'"><b style="color:'.$evented_color.'">'.$i.'</b></a></td></div>';
			else
			echo  '<td bgcolor="'.$bg_color_selected.'"  class="cala_day" style="padding:0 !important; margin:0 !important;line-height:15px !important;"><div class="calborder_day" style=" width:'.$cell_width.'px !important; margin:0 !important; padding:0 !important;"><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.plugins_url("spidercalendarbig.php",__FILE__).'?theme_id='.$theme_id.'&calendar_id='.$calendar_id.'&ev_ids='.$ev_ids_inline.'&eventID='.$ev_id[0].'&date='.$year.'-'.add_0(Month_num($month).'-'.$i).'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'"><b style="color:'.$evented_color.'">'.$i.'</b></a></td></div>';
			
		}
		else{
		
			echo  '<td bgcolor="'.$bg_color_selected.'"  class="cala_day" style="padding:0 !important; margin:0 !important;line-height:15px !important;"><div class="calborder_day" style=" width:'.$cell_width.'px !important; margin:0 !important; padding:0 !important;"><b style="color:'.$evented_color.'">'.$i.'</b>';
		$r=0;
		for($j=0;$j<$k; $j++)	
			{
			if($r<$number_of_shown_evetns)
			echo '<a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="background:none !important;color:'.$event_title_color.' !important; " href="'.plugins_url("spidercalendarbig.php",__FILE__).'?theme_id='.$theme_id.'&calendar_id='.$calendar_id.'&ev_ids='.$ev_ids_inline.'&eventID='.$ev_id[$j].'&date='.$year.'-'.add_0(Month_num($month).'-'.$i).'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" ><b>'.$ev_title[$j].'</b></a>';
			else
			{
			echo '<br><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.plugins_url("spidercalendarbig_seemore.php",__FILE__).'?theme_id='.$theme_id.'&ev_ids='.$ev_ids_inline.'&calendar_id='.$calendar_id.'&date='.$year.'-'.add_0(Month_num($month).'-'.$i).'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'"> <b>'.__('See more...','sp_calendar').'</b></a>';
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
				echo  '<td class="cala_day" style="background-color:'.$evented_color_bg.' !important;padding:0 !important; margin:0 !important;line-height:15px !important; border: px solid '.$border_day.' !important;"><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.plugins_url("spidercalendarbig_seemore.php",__FILE__).'?theme_id='.$theme_id.'&ev_ids='.$ev_ids_inline.'&calendar_id='.$calendar_id.'&date='.$year.'-'.add_0(Month_num($month).'-'.$i).'&cur_page_url='.$path_sp_cal.'&widget=1&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'&Itemid=1" '.$dayevent.'><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px">'.$i.'</b></a></td>';
			 	else
				echo  '<td class="cala_day" style="background-color:'.$evented_color_bg.' !important;padding:0 !important; margin:0 !important;line-height:15px !important; border: px solid '.$border_day.' !important;"><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.plugins_url("spidercalendarbig.php",__FILE__).'?theme_id='.$theme_id.'&calendar_id='.$calendar_id.'&ev_ids='.$ev_ids_inline.'&eventID='.$ev_id[0].'&date='.$year.'-'.add_0(Month_num($month).'-'.$i).'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" '.$dayevent.'><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px">'.$i.'</b></a></td>';
			}
			else
			{
			
	
	echo  '<td class="cala_day" style="background-color:'.$evented_color_bg.' !important;padding:0 !important; margin:0 !important;line-height:15px !important; border: '.(($widget)?($all_days_border_width):'1').'px solid '.$border_day.' !important;"><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px">'.$i.'</b>';
	$r=0;
	
	for($j=0;$j<$k; $j++)	
			{
			if($r<$number_of_shown_evetns)
				echo '<a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="background:none !important;color:'.$event_title_color.' !important; " href="'.plugins_url("spidercalendarbig.php",__FILE__).'?theme_id='.$theme_id.'&calendar_id='.$calendar_id.'&ev_ids='.$ev_ids_inline.'&eventID='.$ev_id[$j].'&date='.$year.'-'.add_0(Month_num($month).'-'.$i).'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" ><b>'.$ev_title[$j].'</b></a>';
			else
			{
				echo '<br><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.plugins_url("spidercalendarbig_seemore.php",__FILE__).'?theme_id='.$theme_id.'&ev_ids='.$ev_ids_inline.'&calendar_id='.$calendar_id.'&date='.$year.'-'.add_0(Month_num($month).'-'.$i).'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'&Itemid=1" '.$dayevent.'> <b>'.__('See more...','sp_calendar').'</b></a>';
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
				echo  '<td class="cala_day" style="background-color:'.$evented_color_bg.' !important;padding:0 !important; margin:0 !important;line-height:15px !important;"><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.plugins_url("spidercalendarbig_seemore.php",__FILE__).'?theme_id='.$theme_id.'&ev_ids='.$ev_ids_inline.'&calendar_id='.$calendar_id.'&date='.$year.'-'.add_0(Month_num($month)).'-'.$i.'&Itemid='.$Itemid.'&cur_page_url='.$path_sp_cal.'&widget=1&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" '.$dayevent.'><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px !important;">'.$i.'</b></a></td>';
				else
				echo  '<td class="cala_day" style="background-color:'.$evented_color_bg.' !important;padding:0 !important; margin:0 !important;line-height:15px !important;"><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.plugins_url("spidercalendarbig.php",__FILE__).'?theme_id='.$theme_id.'&calendar_id='.$calendar_id.'&ev_ids='.$ev_ids_inline.'&eventID='.$ev_id[0].'&date='.$year.'-'.add_0(Month_num($month).'-'.$i).'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" '.$dayevent.'><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px !important;">'.$i.'</b></a></td>';
			}
			else
			{
			
			echo  '<td class="cala_day" style="background-color:'.$evented_color_bg.' !important;padding:0 !important; margin:0 !important;line-height:15px !important;"><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px !important;">'.$i.'</b>';
			$r=0;
			for($j=0;$j<$k; $j++)
			{
			if($r<$number_of_shown_evetns)
			echo '<a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="background:none !important;color:'.$event_title_color.' !important; " href="'.plugins_url("spidercalendarbig.php",__FILE__).'?theme_id='.$theme_id.'&calendar_id='.$calendar_id.'&ev_ids='.$ev_ids_inline.'&eventID='.$ev_id[$j].'&date='.$year.'-'.add_0(Month_num($month).'-'.$i).'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" ><b>'.$ev_title[$j].'</b></a>';
			else
			{
			echo '<br><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.plugins_url("spidercalendarbig_seemore.php",__FILE__).'?theme_id='.$theme_id.'&ev_ids='.$ev_ids_inline.'&calendar_id='.$calendar_id.'&date='.$year.'-'.add_0(Month_num($month)).'-'.$i.'&Itemid='.$Itemid.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" '.$dayevent.'> <b>'.__('See more...','sp_calendar').'</b></a>';
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
				echo  '<td bgcolor="'.$bg_color_selected.'" class="cala_day" style="padding:0 !important; margin:0 !important;line-height:15px !important;"><div class="calborder_day" style=" width:'.$cell_width.'px !important; margin:0 !important; padding:0 !important;"><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.plugins_url("spidercalendarbig_seemore.php",__FILE__).'?theme_id='.$theme_id.'&ev_ids='.$ev_ids_inline.'&calendar_id='.$calendar_id.'&date='.$year.'-'.add_0(Month_num($month)).'-'.$i.'&Itemid='.$Itemid.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" '.$dayevent.'><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px">'.$i.'</b></a></div></td>';
				else
				echo  '<td bgcolor="'.$bg_color_selected.'" class="cala_day" style="padding:0 !important; margin:0 !important;line-height:15px !important;"><div class="calborder_day" style=" width:'.$cell_width.'px !important; margin:0 !important; padding:0 !important;"><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.plugins_url("spidercalendarbig.php",__FILE__).'?theme_id='.$theme_id.'&calendar_id='.$calendar_id.'&ev_ids='.$ev_ids_inline.'&eventID='.$ev_id[0].'&date='.$year.'-'.add_0(Month_num($month).'-'.$i).'&Itemid='.$Itemid.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" '.$dayevent.'><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px">'.$i.'</b></a></div></td>';
			}
			else
			{
			
			echo  '<td bgcolor="'.$bg_color_selected.'" class="cala_day" style="padding:0 !important; margin:0 !important;line-height:15px !important;"><div class="calborder_day" style=" width:'.$cell_width.'px !important; margin:0 !important; padding:0 !important;"><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px">'.$i.'</b>';
			$r=0;
			for($j=0;$j<$k; $j++)
			{
			if($r<$number_of_shown_evetns)
			echo '<a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="background:none !important;color:'.$event_title_color.' !important; " href="'.plugins_url("spidercalendarbig.php",__FILE__).'?theme_id='.$theme_id.'&calendar_id='.$calendar_id.'&ev_ids='.$ev_ids_inline.'&eventID='.$ev_id[$j].'&date='.$year.'-'.add_0(Month_num($month).'-'.$i).'&Itemid='.$Itemid.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" ><b>'.$ev_title[$j].'</b></a>';
			else
			{
			echo '<br><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.plugins_url("spidercalendarbig_seemore.php",__FILE__).'?theme_id='.$theme_id.'&ev_ids='.$ev_ids_inline.'&calendar_id='.$calendar_id.'&date='.$year.'-'.add_0(Month_num($month)).'-'.$i.'&Itemid='.$Itemid.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" '.$dayevent.'> <b>'.__('See more...','sp_calendar').'</b></a>';
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
						echo  '<td class="cala_day" style="background-color:'.$evented_color_bg.' !important;padding:0 !important; margin:0 !important;line-height:15px !important; border: 3px solid '.$current_day_border_color.' !important;"><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.plugins_url("spidercalendarbig_seemore.php",__FILE__).'?theme_id='.$theme_id.'&ev_ids='.$ev_ids_inline.'&calendar_id='.$calendar_id.'&date='.$year.'-'.add_0(Month_num($month)).'-'.$i.'&Itemid='.$Itemid.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" '.$dayevent.'><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px">'.$i.'</b></a></td>';
						else
						echo  '<td class="cala_day" style="background-color:'.$evented_color_bg.' !important;padding:0 !important; margin:0 !important;line-height:15px !important; border: 3px solid '.$current_day_border_color.' !important;"><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.plugins_url("spidercalendarbig.php",__FILE__).'?theme_id='.$theme_id.'&calendar_id='.$calendar_id.'&ev_ids='.$ev_ids_inline.'&eventID='.$ev_id[0].'&date='.$year.'-'.add_0(Month_num($month)).'-'.$i.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" '.$dayevent.'><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px">'.$i.'</b></a></td>';
					}
					else
					{
						
					
		
				
			echo  '<td class="cala_day" style="background-color:'.$evented_color_bg.' !important;padding:0 !important; margin:0 !important;line-height:15px !important; border: 3px solid '.$current_day_border_color.' !important;"><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px">'.$i.'</b>';
			$r=0;
			for($j=0;$j<$k; $j++)
			{
			if($r<$number_of_shown_evetns)
			echo '<a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="background:none !important;color:'.$event_title_color.' !important; " href="'.plugins_url("spidercalendarbig.php",__FILE__).'?theme_id='.$theme_id.'&calendar_id='.$calendar_id.'&ev_ids='.$ev_ids_inline.'&eventID='.$ev_id[$j].'&date='.$year.'-'.add_0(Month_num($month)).'-'.$i.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" ><b>'.$ev_title[$j].'</b></a>';
			else{
			echo '<br><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.plugins_url("spidercalendarbig_seemore.php",__FILE__).'?theme_id='.$theme_id.'&ev_ids='.$ev_ids_inline.'&calendar_id='.$calendar_id.'&date='.$year.'-'.add_0(Month_num($month)).'-'.$i.'&Itemid='.$Itemid.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" '.$dayevent.'> <b>'.__('See more...','sp_calendar').'</b></a>';
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
						echo  '<td class="cala_day" style="background-color:'.$evented_color_bg.' !important;padding:0 !important; margin:0 !important;line-height:15px !important;"><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.plugins_url("spidercalendarbig_seemore.php",__FILE__).'?theme_id='.$theme_id.'&ev_ids='.$ev_ids_inline.'&calendar_id='.$calendar_id.'&date='.$year.'-'.add_0(Month_num($month)).'-'.$i.'&Itemid='.$Itemid.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" '.$dayevent.'><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px !important;">'.$i.'</b></a></b>';
						else
						echo  '<td class="cala_day" style="background-color:'.$evented_color_bg.' !important;padding:0 !important; margin:0 !important;line-height:15px !important;"><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.plugins_url("spidercalendarbig.php",__FILE__).'?theme_id='.$theme_id.'&calendar_id='.$calendar_id.'&ev_ids='.$ev_ids_inline.'&eventID='.$ev_id[0].'&date='.$year.'-'.add_0(Month_num($month)).'-'.$i.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" '.$dayevent.'><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px !important;">'.$i.'</b></a></b>';
					}
					else
					{
					
		
		echo  '<td class="cala_day" style="background-color:'.$evented_color_bg.' !important;padding:0 !important; margin:0 !important;line-height:15px !important;"><b style="color:'.$evented_color.' !important;font-size:'.$other_days_font_size.'px !important;">'.$i.'</b>';
		$r=0;
		for($j=0;$j<$k; $j++)
			{
			if($r<$number_of_shown_evetns)
			echo '<a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="background:none !important;color:'.$event_title_color.' !important; " href="'.plugins_url("spidercalendarbig.php",__FILE__).'?theme_id='.$theme_id.'&calendar_id='.$calendar_id.'&ev_ids='.$ev_ids_inline.'&eventID='.$ev_id[$j].'&date='.$year.'-'.add_0(Month_num($month)).'-'.$i.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" ><b>'.$ev_title[$j].'</b></a>';
			else{
			echo '<p><a class="thickbox-previewbigcalendar'.$many_sp_calendar.'"  rel="{handler: \'iframe\', size: {x: '.$popup_width.', y: '.$popup_height.'}}" style="font-size:11px !important;background:none !important;color:'.$event_title_color.' !important;text-align:center !important;" href="'.plugins_url("spidercalendarbig_seemore.php",__FILE__).'?theme_id='.$theme_id.'&ev_ids='.$ev_ids_inline.'&calendar_id='.$calendar_id.'&date='.$year.'-'.add_0(Month_num($month)).'-'.$i.'&Itemid='.$Itemid.'&cur_page_url='.$path_sp_cal.(($widget)?('&widget=1'):'').'&TB_iframe=1&tbWidth='.$popup_width.'&tbHeight='.$popup_height.'" '.$dayevent.'> <b>'.__('See more...','sp_calendar').'</b></a></p>';
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

