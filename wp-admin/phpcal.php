<?
//require_once('./admin.php');

$title = __('Cancel Appointment');
$parent_file = 'checkSchedule.php';

$today = current_time('mysql', 1);

global $wpdb;


require_once("includes/config.php");

//if(!isset($installed))
//{
//	header("Location: install.php");
//	exit;
//}
//else
//{
//	if(file_exists('install.php'))
//	{
//		header("Location: install.php");
//		exit;
//	}
//}

function getmicrotime(){ 
    list($usec, $sec) = explode(" ",microtime()); 
    return ((float)$usec + (float)$sec); 
} 

$time_start = getmicrotime();

IF(!isset($_GET['year'])){
    $_GET['year'] = date("Y");
}
IF(!isset($_GET['month'])){
    $_GET['month'] = date("n")+1;
}

$month = addslashes($_GET['month'] - 1);
$year = addslashes($_GET['year']);
$query = "SELECT * FROM wp_appt WHERE month='$month' AND year='$year' AND doc_id='$docid' ORDER BY hour";
$apptsSelected = $wpdb->get_results($query);
$count = count($apptsSelected);
foreach ($apptsSelected as $appt) {
    $day = $appt->date;
    $appt_id = $appt->id;
    $appts[$day][] = $appt_id;
    $appt_info[$appt_id]['0'] = $appt->first_name . " " . $appt->last_name;
    $appt_info[$appt_id]['1'] = date('g:i a', strtotime($appt->starts_at)) . " - " . date('g:i a', strtotime($appt->ends_at));
}

$todays_date = date("j");
$todays_month = date("n");

$days_in_month = date ("t", mktime(0,0,0,$_GET['month'],0,$_GET['year']));
$first_day_of_month = date ("w", mktime(0,0,0,$_GET['month']-1,1,$_GET['year']));
$first_day_of_month = $first_day_of_month + 1;
$count_boxes = 0;
$days_so_far = 0;

IF($_GET['month'] == 13){
    $next_month = 2;
    $next_year = $_GET['year'] + 1;
} ELSE {
    $next_month = $_GET['month'] + 1;
    $next_year = $_GET['year'];
}

IF($_GET['month'] == 2){
    $prev_month = 13;
    $prev_year = $_GET['year'] - 1;
} ELSE {
    $prev_month = $_GET['month'] - 1;
    $prev_year = $_GET['year'];
}


?>
<link href="images/cal.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<?php
$curUrl = $_SERVER['PHP_SELF'];
?>
<div align="center"><span class="currentdate"><? echo date ("F Y", mktime(0,0,0,$_GET['month']-1,1,$_GET['year'])); ?></span>
  <br>
</div>
<div align="center"><br>
  <table width="98%" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td><div align="right"><a href="<? echo "$curUrl?month=$prev_month&amp;year=$prev_year&amp;docid=$docid"; ?>">&lt;&lt;</a></div></td>
      <td width="200"><div align="center">
            
          <select name="month" id="month" onChange="MM_jumpMenu('parent',this,0)">
            <?
			for ($i = 1; $i <= 12; $i++) {
				$link = $i+1;
				IF($_GET['month'] == $link){
					$selected = "selected";
				} ELSE {
					$selected = "";
				}
				echo "<option value=\"$curUrl?month=$link&amp;year=$_GET[year]&amp;docid=$docid\" $selected>" . date ("F", mktime(0,0,0,$i,1,$_GET['year'])) . "</option>\n";
			}
			?>
          </select>
          <select name="year" id="year" onChange="MM_jumpMenu('parent',this,0)">
		  <?
		  for ($i = 2011; $i <= 2015; $i++) {
		  	IF($i == $_GET['year']){
				$selected = "selected";
			} ELSE {
				$selected = "";
			}
		  	echo "<option value=\"$curUrl?month=$_GET[month]&amp;year=$i&amp;docid=$docid\" $selected>$i</option>\n";
		  }
		  ?>
          </select>
        </div></td>
      <td><div align="left"><a href="<? echo "$curUrl?month=$next_month&amp;year=$next_year&amp;docid=$docid"; ?>">&gt;&gt;</a></div></td>
    </tr>
  </table>
  <br>
</div>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#AAA">
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="1">
        <tr class="topdays"> 
          <td><div align="center">Sunday</div></td>
          <td><div align="center">Monday</div></td>
          <td><div align="center">Tuesday</div></td>
          <td><div align="center">Wednesday</div></td>
          <td><div align="center">Thursday</div></td>
          <td><div align="center">Friday</div></td>
          <td><div align="center">Saturday</div></td>
        </tr>
		<tr valign="top" bgcolor="#FFFFFF"> 
		<?
		for ($i = 1; $i <= $first_day_of_month-1; $i++) {
			$days_so_far = $days_so_far + 1;
			$count_boxes = $count_boxes + 1;
			echo "<td width=\"150\" height=\"100\" class=\"beforedayboxes\"></td>\n";
		}
		for ($i = 1; $i <= $days_in_month; $i++) {
   			$days_so_far = $days_so_far + 1;
    			$count_boxes = $count_boxes + 1;
			IF($_GET['month'] == $todays_month+1){
				IF($i == $todays_date){
					$class = "highlighteddayboxes";
				} ELSE {
					$class = "dayboxes";
				}
			} ELSE {
				IF($i == 1){
					$class = "highlighteddayboxes";
				} ELSE {
					$class = "dayboxes";
				}
			}
			echo "<td width=\"500\" height=\"100\" class=\"$class\">\n";
			$link_month = $_GET['month'] - 1;
			echo "<div align=\"right\"><span class=\"toprightnumber\" style=\"color:#000\">\n$i&nbsp;</span></div>\n";
			IF(isset($appts[$i])){
                                echo "<div align=\"left\"><span class=\"eventinbox\">\n";
				if(strcmp($user_info-> rpr_type_of_account, "Patient") == 0) {
				   while (list($key, $value) = each ($appts[$i])) {
                                      echo "&nbsp;<div class=\"apptTxt\">" . $appt_info[$value]['1'] . "<br />Unavailable</div>\n<br />";
                                   }
                                } else {
                                   while (list($key, $value) = each ($appts[$i])) {
					echo "&nbsp;<div class=\"apptTxt\" onclick='TINY.box.show({url:\"event.php?id=$value\",animate:false,mask:false,boxid:\"appt\"})'>" . $appt_info[$value]['1'] . "<br />" . $appt_info[$value]['0'] . "</div>\n<br />";
				   }
                                }
				echo "</span></div>\n";
			}
			echo "</td>\n";
			IF(($count_boxes == 7) AND ($days_so_far != (($first_day_of_month-1) + $days_in_month))){
				$count_boxes = 0;
				echo "</TR><TR valign=\"top\" bgcolor=\"#FFF\">\n";
			}
		}
		$extra_boxes = 7 - $count_boxes;
		for ($i = 1; $i <= $extra_boxes; $i++) {
			echo "<td width=\"100\" height=\"100\" class=\"afterdayboxes\"></td>\n";
		}
		$time_end = getmicrotime();
		$time = round($time_end - $time_start, 3);
		?>
        </tr>
      </table></td>
  </tr>
</table>