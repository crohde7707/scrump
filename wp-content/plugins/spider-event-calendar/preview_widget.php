<?php 

	
if ( !defined('WP_LOAD_PATH') ) {

	/** classic root path if wp-content and plugins is below wp-config.php */
	$classic_root = dirname(dirname(dirname(dirname(__FILE__)))) . '/' ;
	
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



if(!current_user_can('manage_options')) {
	die('Access Denied');
}	
?>
<script>
cal_width=window.parent.document.getElementById('width').value;
bg_top='#'+window.parent.document.getElementById('bg_top').value;
bg_bottom='#'+window.parent.document.getElementById('bg_bottom').value;
border_color='#'+window.parent.document.getElementById('border_color').value;
text_color_year='#'+window.parent.document.getElementById('text_color_year').value;
text_color_month='#'+window.parent.document.getElementById('text_color_month').value;
color_week_days='#'+window.parent.document.getElementById('text_color_week_days').value;
text_color_other_months='#'+window.parent.document.getElementById('text_color_other_months').value;
text_color_this_month_unevented='#'+window.parent.document.getElementById('text_color_this_month_unevented').value;
evented_color='#'+window.parent.document.getElementById('text_color_this_month_evented').value;
evented_color_bg='#'+window.parent.document.getElementById('bg_color_this_month_evented').value;
color_arrow_year='#'+window.parent.document.getElementById('arrow_color_year').value;
color_arrow_month='#'+window.parent.document.getElementById('arrow_color_month').value;
sun_days='#'+window.parent.document.getElementById('text_color_sun_days').value;
event_title_color='#'+window.parent.document.getElementById('event_title_color').value;
current_day_border_color='#'+window.parent.document.getElementById('current_day_border_color').value;
cell_border_color='#'+window.parent.document.getElementById('cell_border_color').value;
cell_height=window.parent.document.getElementById('cell_height').value;
popup_width=window.parent.document.getElementById('popup_width').value;
popup_height=window.parent.document.getElementById('popup_height').value;
number_of_shown_evetns=window.parent.document.getElementById('number_of_shown_evetns').value;
sundays_font_size=window.parent.document.getElementById('sundays_font_size').value;
other_days_font_size=window.parent.document.getElementById('other_days_font_size').value;
weekdays_font_size=window.parent.document.getElementById('weekdays_font_size').value;
border_width=window.parent.document.getElementById('border_width').value;
top_height=window.parent.document.getElementById('top_height').value;
bg_color_other_months='#'+window.parent.document.getElementById('bg_color_other_months').value;
sundays_bg_color='#'+window.parent.document.getElementById('sundays_bg_color').value;
weekdays_bg_color='#'+window.parent.document.getElementById('weekdays_bg_color').value;
weekstart=window.parent.document.getElementById('week_start_day').value;
weekday_sunday_bg_color='#'+window.parent.document.getElementById('weekday_sunday_bg_color').value;
border_radius=window.parent.document.getElementById('border_radius').value;
border_radius2=border_radius-border_width;
week_days_cell_height=window.parent.document.getElementById('week_days_cell_height').value;
year_font_size=window.parent.document.getElementById('year_font_size').value;
month_font_size=window.parent.document.getElementById('month_font_size').value;
arrow_size=window.parent.document.getElementById('arrow_size').value;
arrow_size_hover=parseInt(arrow_size);
next_month_text_color='#'+window.parent.document.getElementById('next_month_text_color').value;
prev_month_text_color='#'+window.parent.document.getElementById('prev_month_text_color').value;
next_month_arrow_color='#'+window.parent.document.getElementById('next_month_arrow_color').value;
prev_month_arrow_color='#'+window.parent.document.getElementById('prev_month_arrow_color').value;
next_month_font_size=window.parent.document.getElementById('next_month_font_size').value;
prev_month_font_size=window.parent.document.getElementById('prev_month_font_size').value;
all_day_border_width=window.parent.document.getElementById('all_days_border_width').value;
month_type=window.parent.document.getElementById('month_type').value;
cell_width=cal_width/7;
if(cell_height=="")
cell_height=70;









var head = document.getElementsByTagName('head')[0],
    style = document.createElement('style'),
    rules = document.createTextNode(
	
'#bigcalendar .cala_arrow a:link, #bigcalendar .cala_arrow a:visited{text-decoration:none;background:none;font-size:'+arrow_size+'px; }'+

'#bigcalendar td,#bigcalendar tr,  #spiderCalendarTitlesList td,  #spiderCalendarTitlesList tr {border:none;}'+

'#bigcalendar .general_table{border-radius: '+border_radius+'px;}'+

'#bigcalendar .top_table {border-top-left-radius: '+border_radius2+'px;border-top-right-radius: '+border_radius2+'px;}'+

'#bigcalendar .cala_arrow a:hover{font-size:'+arrow_size_hover+'px;text-decoration:none;background:none;}'+ 

'#bigcalendar .cala_day a:link, #bigcalendar .cala_day a:visited {text-decoration:none;background:none;font-size:12px;color:red;}'+ 

'#bigcalendar .cala_day a:hover {text-decoration:none;background:none;}'+

'#bigcalendar .cala_day {border:'+all_day_border_width+'px solid '+cell_border_color+';vertical-align:middle;text-align:center}'+ 

'#bigcalendar .weekdays {border:'+all_day_border_width+'px solid '+cell_border_color+'}'+

'#bigcalendar .week_days {font-size:'+weekdays_font_size+'px;font-family:arial}'+

'#bigcalendar .calyear_table, .calmonth_table {border-spacing:0;width:100%; }'+

'#bigcalendar .calbg, #bigcalendar .calbg td {text-align:center;	width:14%;}'+

'#bigcalendar .caltext_color_other_months  {color:'+text_color_other_months+';border:'+all_day_border_width+'px solid '+cell_border_color+';vertical-align:middle;text-align:center;}'+

'#bigcalendar .caltext_color_this_month_unevented {color:'+text_color_this_month_unevented+';}'+

'#bigcalendar .calfont_year {font-family:arial;font-size:24px;font-weight:bold;color:'+text_color_year+';}'+

'#bigcalendar .calsun_days {color:'+sun_days+';border:'+all_day_border_width+'px solid '+cell_border_color+';vertical-align:middle;text-align:center;background-color:'+sundays_bg_color+';}'


 
 );

style.type = 'text/css';
if(style.styleSheet)
    style.styleSheet.cssText = rules.nodeValue;
else style.appendChild(rules);
head.appendChild(style);



</script>






<div id="bigcalendar" style="">



<table cellpadding="0" cellspacing="0" id="general_table"  class="general_table"  style="border-spacing:0; margin:0; padding:0;">

    <tr>

        <td width="100%" style=" padding:0; margin:0">

            
              <table  cellpadding="0" id="header_table"  cellspacing="0" border="0" style="border-spacing:0; font-size:12px; margin:0; padding:0;">
				
				

                <tr  style="height:40px;">
				
                    <td id="top_table" class="top_table" align="center" colspan="7" style="padding:0; margin:0;height:20px; " >
					
						
						
						


                  


				  <table cellpadding="0" cellspacing="0" border="0" align="center" class="calyear_table" id="calyear_table" style="margin:0; padding:0; text-align:center;">

                            <tr>
								<td style="width:100%;vertical-align:bottom;padding-bottom:0px;">
								<table style="width:100%;">
								<tr>
                                <td  class="cala_arrow" width="40%"  style="text-align:right;margin:0px;padding:0px">
								<a id="cala_arrow_year_prev" style=""  href="">&#9668;</a>
								</td>

                        

                                <td style="text-align:center; margin:0; padding:0;" width="20%" >

                                    <span id="year_span" style="font-family:arial;font-weight:bold;">2012</span> 
	
									
                                
								</td>
								<td style="margin:0; padding:0;text-align:left" width="40%"  class="cala_arrow"> 
								<a  id="cala_arrow_year_next" style=""  href="">&#9658;</a>

								</td>
								</tr>
								</table>
								</td>
								</tr>
								<tr>
								<td style="width:100%;vertical-align:bottom; padding-bottom:5px;">
								<table style="width:100%;line-height:150%">
								<tr>
									<td class="cala_arrow" width="40%"  style="text-align:left;margin:0px;padding:0px">
									<table width="80%">
									<tr>
									<td width="15%">
									<a id="cala_arrow_month_prev"  style="" href="" >&#9668; </a>
							
									</td>
									<td>
									<span id="cala_arrow_month_prev_span"  style="font-family:arial;">May</span>

									</td>
									</tr>
									</table>
									</td>
									<td style="text-align:center; margin:0;" width="20%" >

										
						<span id="current_month"  style="font-family:arial;">June</span>
	
									</td>	
									<td style="margin:0; padding:0;text-align:right" width="40%"  class="cala_arrow"> 
									<table width="100%">
									<tr>
									<td style="margin:0; padding:0;text-align:right" >
									<span id="cala_arrow_month_next_span" style="font-family:arial;">July</span>

									</td>
									<td width="10%">
									<a  id="cala_arrow_month_next" href="">&#9658;</a>

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
                    <td id="top_td" colspan="7" style="margin:0; padding:0;" >

                    

                    </td>

                </tr>

                <tr align="center"  id="week_days_tr" style="">

				
                    <td id="weekdays1" class="weekdays" style="margin:0; padding:0">

                    <div id="calbottom_border1" class="calbottom_border" style="text-align:center; margin:0; padding:0;"><b class="week_days"> <?php echo __( 'Mo','sp_calendar' ); ?> </b></div></td>

                    <td id="weekdays2" class="weekdays" style="margin:0; padding:0">

					
					
					
                   	 <div id="calbottom_border2" class="calbottom_border" style="text-align:center; margin:0; padding:0;"><b class="week_days"> <?php echo __( 'Tu','sp_calendar' ); ?> </b></div></td>

				  <td id="weekdays3" class="weekdays" style="margin:0; padding:0">

                   	 <div id="calbottom_border3" class="calbottom_border" style="text-align:center; margin:0; padding:0;"><b class="week_days"> <?php echo __( 'We','sp_calendar' ); ?> </b></div></td>

                    <td id="weekdays4" class="weekdays" style=" margin:0; padding:0">

                    	 <div id="calbottom_border4" class="calbottom_border" style="text-align:center;margin:0; padding:0;"><b class="week_days"> <?php echo __( 'Th','sp_calendar' ); ?> </b></div></td>

					<td id="weekdays5" class="weekdays" style="margin:0; padding:0">

                   	 <div id="calbottom_border5" class="calbottom_border" style="text-align:center;margin:0; padding:0;"><b class="week_days"> <?php echo __( 'Fr','sp_calendar' ); ?> </b></div></td>
					 
                    <td id="weekdays6" class="weekdays" style=" margin:0; padding:0">

                   	 <div id="calbottom_border6" class="calbottom_border" style="text-align:center;margin:0; padding:0;"><b class="week_days"> <?php echo __( 'Sa','sp_calendar' ); ?> </b></div></td>

					<td id="weekdays_su" class="weekdays" style=" margin:0; padding:0;">

                    <div id="calbottom_border_su" class="calbottom_border" style="text-align:center;  margin:0; padding:0;"><b class="week_days"> <?php echo __( 'Su','sp_calendar' ); ?> </b></div></td>
					
                
				</tr>

                    <?php

//$today=$realtoday;
/*$document = &JFactory::getDocument();
   $document->addScript("media/system/js/modal.js");
   $document->addStyleSheet("media/system/css/modal.css");*/
   $weekday_i=6;
   $month_days=30;
   $last_month_days=31;
   $last_month_days=$last_month_days-$weekday_i+2;
   $percent=1;
   $weekstart='mo';
   $sum=$month_days-8+6;
   
   if($sum % 7 <> 0)

$percent = $percent + 1;

$sum = $sum - ( $sum % 7 );

$percent = $percent + ( $sum / 7 );

$percent=107/$percent;

$array_days=array(11);

$array_days1=$array_days;
$title=array(11=>'');

$ev_ids=array(11 => '97<br>
98<br>
99<br>
100');
$day_REFERER='';
$month='June';
$year='2012';
$number_of_shown_evetns=2;
?>
<script>
document.write('<tr  id="days"   style=";line-height:15px;">');
</script>         
<?php



for($i=1; $i<6; $i++)

{
?>
<script>
document.write('<td class="caltext_color_other_months" style=" border: '+all_day_border_width+'px solid '+cell_border_color+';vertical-align:middle;text-align:center;background-color:'+bg_color_other_months+'"  ><span style="font-size:'+other_days_font_size+'px"><?php echo $last_month_days ?></span></td>');
</script>
<?php
$last_month_days=$last_month_days+1;

}



for($i=1; $i<=$month_days; $i++)

{

if($i==11)
{
$ev_title=explode('</p>',$title[11]);


$k=count($ev_title);
////
$ev_id=explode('<br>',$ev_ids[$i]);
array_pop($ev_id);



}


$dayevent='';

	if(($weekday_i%7==0 and $weekstart=="mo") or ($weekday_i%7==1 and $weekstart=="su"))

	{
	
		if($i==$day_REFERER and $month==$month_REFERER and $year==$year_REFERER )
	
		{ 
		
		?>
		
		<script>
			document.write('<td bgcolor="'+bg_color_selected+'"  class="cala_day" style="padding:0; margin:0;line-height:15px;"><div class="calborder_day" style=" width:'+cell_width+'px; margin:0; padding:0;"><b style="color:'+evented_color+'"><a>'<?php echo $i ?>'</a></b>');
		</script>
		<?php
		
		$r=0;
		for($j=0;$j<$k; $j++)	
			{
			if($r<$number_of_shown_evetns)
			?>
			<script>
			
			document.write('<a class="modal"  style="background:none;color:'+event_title_color+'; text-decoration:underline;" href="" ></b></a>');
			</script>
			<?php
			
			$r++;
			}
			
			echo '</td></div>';
	
		}
	
		else
		
		if($i==date('j') and $month==date('F') and $year==date('Y'))
		{
	
			if( in_array ($i,$array_days)){
			
	?>
			<script>
	document.write('<td class="cala_day" style="vertical-align:middle;text-align:center;background-color:'+evented_color_bg+';padding:0; margin:0;line-height:15px; border: px solid '+border_day+'"><b style="color:'.$evented_color.';font-size:'.$other_days_font_size.'px"><a>'<?php echo $i ?>'</a></b>');
	</script>
			<?php
	$r=0;
	for($j=0;$j<$k; $j++)	
			{
			if($r<$number_of_shown_evetns)
			{
			?>
			<script>
			document.write('<a class="modal"  rel="{handler: \'iframe\', size: {x: '+popup_width+', y: '+popup_height+'}}" style="background:none;color:'+event_title_color+'; text-decoration:underline;" href="" ><b></b></a>');
			document.write('<a class="modal"  rel="{handler: \'iframe\', size: {x: '+popup_width+', y: '+popup_height+'}}" style="background:none;color:'+event_title_color+';text-align:center;text-decoration:underline;" href=""> <b></b></a>');
			</script>
			<?php
			}
			
			}
			echo '</td>';
	}
			else
			{
			?>
			<script>
			document.write('<td class="calsun_days" id="calsun_days" style="vertical-align:middle;text-align:center;padding:0; font-size:'+sundays_font_size+'px; margin:0;line-height:15px; border: '+all_day_border_width+'px solid '+cell_border_color+'"><b><?php echo  $i ?></b></td>');
			</script>
			<?php
			}
		}

		else
		{
	
			if( in_array ($i,$array_days)){
			?>
	<script>
	document.write('<td class="cala_day" style="vertical-align:middle;text-align:center;background-color:'+evented_color_bg+';padding:0; margin:0;line-height:15px; border: px solid '+border_day+'"><b style="color:'+evented_color+';font-size:'+other_days_font_size+'px"><a>'<?php echo $i ?>'</a></b>');
	</script>
			<?php
	$r=0;
	for($j=0;$j<$k; $j++)	
			{
			if($r<$number_of_shown_evetns)
			{
			?>
			<script>
			document.write('<a class="modal"  rel="{handler: \'iframe\', size: {x: '+popup_width+', y: '+popup_height+'}}" style="background:none;color:'+event_title_color+'; text-decoration:underline;" href="" ><b></b></a>');
			document.write('<a class="modal"  rel="{handler: \'iframe\', size: {x: '+popup_width+', y: '+popup_height+'}}" style="background:none;color:'+event_title_color+';text-align:center;text-decoration:underline;" href=""> <b></b></a>');
			</script>
			<?php
			}
			}
			echo '</td>';
	}
			else
			{
			?>
			<script>
			document.write('<td class="calsun_days" id="calsun_days" style="vertical-align:middle;text-align:center;padding:0; font-size:'+sundays_font_size+'px; margin:0;line-height:15px; border: '+all_day_border_width+'px solid '+cell_border_color+'"><b><?php echo  $i ?></b></td>');
			</script>
			<?php
			}
		}

	}
/////////////////////////////////////////////////////////////////////////mec else
	else

		if($i==$day_REFERER and $month==$month_REFERER and $year==$year_REFERER )
	
		{ 	?>
			<script>
			document.write('<td bgcolor="'+bg_color_selected+'" class="cala_day" style="padding:0; margin:0;line-height:15px;"><div class="calborder_day" style=" width:'+cell_width+'px; margin:0; padding:0;"><b style="color:'+evented_color+';font-size:'+other_days_font_size+'px"><a><?php echo  $i ?></a></b>');
			</script>
			<?php
			$r=0;
	for($j=0;$j<$k; $j++)	
			{
			if($r<$number_of_shown_evetns)
			{
			?>
			<script>
			document.write('<a class="modal"  rel="{handler: \'iframe\', size: {x: '+popup_width+', y: '+popup_height+'}}" style="background:none;color:'+event_title_color+'; text-decoration:underline;" href="" ><b></b></a>');
			document.write('<a class="modal"  rel="{handler: \'iframe\', size: {x: '+popup_width+', y: '+popup_height+'}}" style="background:none;color:'+event_title_color+';text-align:center;text-decoration:underline;" href=""> <b></b></a>');
			</script>
			<?php
			}
			
			}
			
			echo '</td></div>';
	
		}

		else
	
		{
			if($i==13 and $month=='June' and $year=='2012')
			
		{
				if( in_array ($i,$array_days)){
		
			?>
			<script>	
			document.write('<td class="cala_day" style="vertical-align:middle;text-align:center;background-color:'+evented_color_bg+';padding:0; margin:0;line-height:15px; border: 3px solid '+current_day_border_color+'"><b style="color:'+evented_color+';font-size:'+other_days_font_size+'px"><a><?php echo  $i ?></a></b>');
			</script>
			<?php
			$r=0;
	for($j=0;$j<$k; $j++)	
			{
			if($r<$number_of_shown_evetns)
			{
			?>
			<script>
			document.write('<a class="modal"  rel="{handler: \'iframe\', size: {x: '+popup_width+', y: '+popup_height+'}}" style="background:none;color:'+event_title_color+'; text-decoration:underline;" href="" ><b></b></a>');
			document.write('<a class="modal"  rel="{handler: \'iframe\', size: {x: '+popup_width+', y: '+popup_height+'}}" style="background:none;color:'+event_title_color+';text-align:center;text-decoration:underline;" href=""> <b></b></a>');

			</script>
			<?php
			}
			else
			{
			?>
			<script>
			</script>
			<?php
			break;
			}
			$r++;
			}
			echo '</td>';
				}
		
				else
				{
			?>
			<script>
				document.write('<td style=" color:'+text_color_this_month_unevented+';padding:0; margin:0; line-height:15px; border: 3px solid '+current_day_border_color+'; vertical-align:middle;text-align:center;"><b style="font-size:'+other_days_font_size+'px"><?php echo  $i ?></b></td>');
			</script>
			<?php
			
			}
		}
	
	else
			if( in_array ($i,$array_days)){
	
		?>
			<script>
		document.write('<td class="cala_day" style="vertical-align:middle;text-align:center;background-color:'+evented_color_bg+';padding:0; margin:0;line-height:15px;"><b style="color:'+evented_color+';font-size:'+other_days_font_size+'px"><a><?php echo  $i ?></a></b>');
		</script>
			<?php
		$r=0;
		for($j=0;$j<$k; $j++)	
			{
			if($r<$number_of_shown_evetns)
			{
			?>
			<script>
			document.write('<a class="modal"  rel="{handler: \'iframe\', size: {x: '+popup_width+', y: '+popup_height+'}}" style="background:none;color:'+event_title_color+'; text-decoration:underline;" href="" ><b></b></a>');
			document.write('<a class="modal"  rel="{handler: \'iframe\', size: {x: '+popup_width+', y: '+popup_height+'}}" style="background:none;color:'+event_title_color+';text-align:center;text-decoration:underline;" href=""> <b></b></a>');
			</script>
			<?php
			}
			
			}
			echo '</td>';
			}
	
			else
			{
			?>
			<script>
			document.write('<td style=" color:'+text_color_this_month_unevented+';padding:0; margin:0; line-height:15px;border: '+all_day_border_width+'px solid '+cell_border_color+';vertical-align:middle;text-align:center;text-align:center;"><b style="font-size:'+other_days_font_size+'px"><?php echo  $i ?></b></td>');
			</script>
			<?php
			
			}
			

	}

	if($weekday_i%7==0 && $i<>$month_days)

	{
	?>
	<script>
	document.write('</tr><tr height="'+cell_height+'" style="line-height:15px">');
	</script>
	<?php
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
{
?>

<script>
docuemnt.write('<td class="caltext_color_other_months" style="background-color:'+bg_color_other_months+'"  >'<?php echo $next_i ?>'</td>');
</script>
<?php
}
else
{
?>
<script>
document.write ('<td class="caltext_color_other_months" style="background-color:'+bg_color_other_months+';"  >'<?php echo $next_i ?>'</td>');
</script>
<?php
}
$next_i=$next_i+1;

}

echo '</tr></table>';

?>

                    <input type="text" value="1" name="day" style="display:none" />

          

               

        </td>

    </tr>

</table>
</div>
<script>
								document.getElementById('bigcalendar').style.width=cal_width;
								document.getElementById('general_table').style.width=cal_width;
								document.getElementById('general_table').style.border=border_color+' solid '+border_width;
								document.getElementById('general_table').style.backgroundColor=bg_bottom;
								document.getElementById('header_table').style.width=cal_width;
								document.getElementById('top_table').style.backgroundColor=bg_top;
								document.getElementById('calyear_table').style.width=cal_width;
								document.getElementById('calyear_table').style.height=top_height;
								document.getElementById('cala_arrow_year_prev').style.color=color_arrow_year;
								document.getElementById('cala_arrow_year_next').style.color=color_arrow_year;
								document.getElementById('year_span').style.fontSize=year_font_size;
								document.getElementById('year_span').style.color=text_color_year;
								document.getElementById('cala_arrow_month_prev').style.color=prev_month_arrow_color;
								document.getElementById('cala_arrow_month_prev_span').style.color=prev_month_text_color;
								document.getElementById('cala_arrow_month_prev_span').style.fontSize=prev_month_font_size;
								
								document.getElementById('cala_arrow_month_next_span').style.color=next_month_text_color;
								document.getElementById('cala_arrow_month_next_span').style.fontSize=next_month_font_size;								
								
								document.getElementById('current_month').style.fontSize=month_font_size;
								document.getElementById('current_month').style.color=text_color_month;
								
								document.getElementById('cala_arrow_month_next').style.color=next_month_arrow_color;
								document.getElementById('week_days_tr').style.height=week_days_cell_height;
								document.getElementById('week_days_tr').style.backgroundColor=weekdays_bg_color;
								document.getElementById('top_td').style.backgroundColor=bg_top;
								
								for(var i=1;i<=6;i++){
								document.getElementById('weekdays'+i).style.width=cell_width;
								document.getElementById('weekdays'+i).style.color=color_week_days;
								document.getElementById('calbottom_border'+i).style.width=cell_width;
								}
								
								document.getElementById('weekdays_su').style.width=cell_width;
								document.getElementById('calbottom_border_su').style.width=cell_width;
								document.getElementById('weekdays_su').style.color=color_week_days;
								document.getElementById('weekdays_su').style.backgroundColor=weekday_sunday_bg_color;
								document.getElementById('days').style.height=cell_height;
								
								</script>







<?php
