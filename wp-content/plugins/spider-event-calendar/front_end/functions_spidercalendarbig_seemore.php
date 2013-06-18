<?php
 
 /**
 * @package Spider Calendar
 * @author Web-Dorado
 * @copyright (C) 2011 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/




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


	?>