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
	

