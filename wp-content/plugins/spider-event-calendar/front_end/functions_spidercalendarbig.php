<?php
 
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
	?>