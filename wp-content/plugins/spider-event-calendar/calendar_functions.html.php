	<?php		
	
if(!current_user_can('manage_options')) {
	die('Access Denied');
}	
	
	
	
		
function html_show_spider_calendar($rows, $pageNav,$sort){

	?>
    <script language="javascript">
	function confirmation(href,title) {
		var answer = confirm("Are you sure you want to delete '"+title+"'?")
		if (answer){
			document.getElementById('admin_form').action=href;
			document.getElementById('admin_form').submit();
		}
	}
	function ordering(name,as_or_desc)
	{
		document.getElementById('asc_or_desc').value=as_or_desc;		
		document.getElementById('order_by').value=name;
		document.getElementById('admin_form').submit();
	}
	function submit_form_id(x)
				 {
					 
					 var val=x.options[x.selectedIndex].value;
					 document.getElementById("id_for_playlist").value=val;
					 document.getElementById("admin_form").submit();
				 }
				 
				 	function doNothing() {  
var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
    if( keyCode == 13 ) {


        if(!e) var e = window.event;

        e.cancelBubble = true;
        e.returnValue = false;

        if (e.stopPropagation) {
                e.stopPropagation();
                e.preventDefault();
        }
	}
}
var show_one_cal=1;
var get_cal_id=0;
function show_calendar_inline(cal_id)
{	if(show_one_cal==1){
		show_one_cal=0;
	jQuery.ajax({
 		 type: 'POST',
            url: '<?php echo admin_url('admin-ajax.php?action=spidercalendarinlineedit') ?>',
            data: {calendar_id: cal_id},
            dataType: 'html',
            success: function(data) {
				cancel_qiucik_edit(get_cal_id);
               var edit_cal_tr=document.createElement("tr")
			   edit_cal_tr.innerHTML=data;
			   edit_cal_tr.setAttribute('class','inline-edit-row inline-edit-row-page inline-edit-page quick-edit-row quick-edit-row-page inline-edit-page alternate inline-editor')
			   edit_cal_tr.setAttribute('id','edit_calendar-'+cal_id);
			   
			  document.getElementById('Calendar-'+cal_id).style.display="none";
			   document.getElementById('calendar_body').appendChild( edit_cal_tr);
			   document.getElementById('calendar_body').insertBefore(edit_cal_tr,document.getElementById('Calendar-'+cal_id) );
			   get_cal_id=cal_id;
		
			  show_one_cal=1
            }
});	
}
	
}

function cancel_qiucik_edit(cal_id)
{
	if(document.getElementById('edit_calendar-'+cal_id)){
	var tr = document.getElementById('edit_calendar-'+cal_id);
	tr.parentNode.removeChild(tr);
	document.getElementById('Calendar-'+cal_id).style.display="";
	}
	
	
}
function updae_inline_sp_calendar(cal_id)
{	
		var cal_title= document.getElementById('calendar_title').value;
		var cal_12_format =getCheckedValue(document.getElementsByName('time_format'));

	document.getElementById('imig_for_waiting').style.display="block";
	jQuery.ajax({
			 type: 'POST',
				url: '<?php echo admin_url('admin-ajax.php?action=spidercalendarinlineupdate') ?>',
				data: {
					calendar_id: cal_id,
					calendar_title:cal_title,
					us_12_format_sp_calendar:cal_12_format
				},
				dataType: 'html',
				success: function(data) {
					if(data){
					document.getElementById('imig_for_waiting').style.display="none";
					document.getElementById('Calendar-'+cal_id).innerHTML=data;
					cancel_qiucik_edit(cal_id);
					}
					else
					{
					alert('ERROR PLEAS INSTALL PLUGIN AGAIN');
					cancel_qiucik_edit(cal_id);
					}
				}
	});	
	
}
function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}

	</script>
    <form method="post" onkeypress="doNothing()" action="admin.php?page=SpiderCalendar" id="admin_form" name="admin_form">
	<table cellspacing="10" width="96.5%" id="calendar_table">
        <tr>
        <td width="100%" style="font-size:14px; font-weight:bold"><a href="http://web-dorado.com/spider-calendar-wordpress-guide-step-2.html" target="_blank" style="color:blue; text-decoration:none;">User Manual</a><br>
This section allows you to create calendars. You can add unlimited number of calendars. <a href="http://web-dorado.com/spider-calendar-wordpress-guide-step-2.html" target="_blank" style="color:blue; text-decoration:none;">More...</a></td>
            <td colspan="7" align="right" style="font-size:16px;">
              <a href="http://web-dorado.com/files/fromSpiderCalendarWP.php" target="_blank" style="color:red; text-decoration:none;">
            <img src="<?php echo plugins_url('images/header.png',__FILE__) ?>" border="0" alt="http://web-dorado.com/files/fromSpiderCalendarWP.php" width="215"><br>
            Get the full version&nbsp;&nbsp;&nbsp;&nbsp;
            </a>
 			 </td>
   			</tr>
    <tr>
    <td style="width:210px">
    <?php  echo "<h2>".'Calendar Manager'. "</h2>"; ?>
    </td>
    <td  style="text-align:right;"><p class="submit" style="padding:0px; text-align:right"><input type="button" class="button-secondary action" value="Add a Calendar" name="custom_parametrs" onclick="window.location.href='admin.php?page=SpiderCalendar&task=add_calendar'" /></p></td>

    </tr>
    </table>
    
   
    <?php
	if(isset($_POST['serch_or_not'])) {if($_POST['serch_or_not']=="search"){ $serch_value=$_POST['search_events_by_title']; }else{$serch_value="";}} 
	$serch_fields='<div class="alignleft actions" style="width:180px;">
    	<label for="search_events_by_title" style="font-size:14px">Title: </label>
        <input type="text" name="search_events_by_title" value="'.$serch_value.'" id="search_events_by_title" onchange="clear_serch_texts()">
    </div>
	<div class="alignleft actions">
   		<input type="button" value="Search" onclick="document.getElementById(\'page_number\').value=\'1\'; document.getElementById(\'serch_or_not\').value=\'search\';
		 document.getElementById(\'admin_form\').submit();" class="button-secondary action">
		 <input type="button" value="Reset" onclick="window.location.href=\'admin.php?page=SpiderCalendar\'" class="button-secondary action">
    </div>';
	 print_html_nav($pageNav['total'],$pageNav['limit'],$serch_fields);	
	
	?>
  <table class="wp-list-table widefat fixed pages" style="width:95%">
 <thead>
 <TR>
 <th scope="col"  id="id" class="<?php if($sort["sortid_by"]=="id") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style=" width:50px" ><a href="javascript:ordering('id',<?php if($sort["sortid_by"]=="id") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>ID</span><span class="sorting-indicator"></span></a></th>
 <th scope="col" id="title" class="<?php if($sort["sortid_by"]=="title") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" ><a href="javascript:ordering('title',<?php if($sort["sortid_by"]=="title") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>Title</span><span class="sorting-indicator"></span></a></th>
<th style="width:100px">Manage Events</th>
  
  <th scope="col" id="published" class="<?php if($sort["sortid_by"]=="published") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style=" width:100px" ><a href="javascript:ordering('published',<?php if($sort["sortid_by"]=="published") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>Published</span><span class="sorting-indicator"></span></a></th>
 </TR>
 </thead>
 <tbody id="calendar_body">
 <?php for($i=0; $i<count($rows);$i++){ ?>
 <tr id="Calendar-<?php echo $rows[$i]->id; ?>"  class=" hentry alternate iedit author-self" style="display: table-row;">
         <td><?php echo $rows[$i]->id; ?></td>
         <td class="post-title page-title column-title">
         	<a title="Manage Events" class="row-title" href="admin.php?page=SpiderCalendar&task=show_manage_event&calendar_id=<?php echo $rows[$i]->id; ?>"><?php echo $rows[$i]->title; ?></a>
            <div class="row-actions">
                <span class="edit"><a href="admin.php?page=SpiderCalendar&task=edit_calendar&id=<?php echo $rows[$i]->id; ?>" title="Edit This Calendar">Edit</a> | </span>
                <span class="inline hide-if-no-js"><a href="#" class="editinline" onclick="show_calendar_inline(<?php echo  $rows[$i]->id; ?>)" title="Edit This Calendar Inline">Quick&nbsp;Edit</a>  | </span>
                <span class="trash"><a class="submitdelete" title="Delete This Calendar" href="javascript:confirmation('admin.php?page=SpiderCalendar&task=remove_calendar&id=<?php echo $rows[$i]->id; ?>','<?php echo $rows[$i]->title; ?>')">Delete</a></span>
            </div>
         </td>
         <td><a href="admin.php?page=SpiderCalendar&task=show_manage_event&calendar_id=<?php echo $rows[$i]->id; ?>">Manage events</a></td>
         <td><a <?php if(!$rows[$i]->published) echo 'style="color:#C00"'; ?> href="admin.php?page=SpiderCalendar&task=published&id=<?php echo $rows[$i]->id; ?>"><?php if($rows[$i]->published) echo "Yes"; else echo "No"; ?></a></td>
               
  </tr> 
 <?php } ?>
 </tbody>
 </table>
 <input type="hidden" name="id_for_playlist" id="id_for_playlist" value="<?php if(isset($_POST['id_for_playlist'])) echo $_POST['id_for_playlist'];?>" />
 <input type="hidden" name="asc_or_desc" id="asc_or_desc" value="<?php if(isset($_POST['asc_or_desc'])) echo $_POST['asc_or_desc'];?>"  />
 <input type="hidden" name="order_by" id="order_by" value="<?php if(isset($_POST['order_by'])) echo $_POST['order_by'];?>"  />

 <?php
?>
    
    
   
 </form>
  
    <?php
}







function html_add_spider_calendar()
{	?>


	<script language="javascript" type="text/javascript">
		
		function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel_calendar') {
		submitform( pressbutton );
		return;
		}
					
					
		submitform( pressbutton );
		}
		
		function submitform(pressbutton){
			document.getElementById('adminForm').action=document.getElementById('adminForm').action+"&task="+pressbutton;
			document.getElementById('adminForm').submit();
			}
function doNothing() {  
var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
    if( keyCode == 13 ) {


        if(!e) var e = window.event;

        e.cancelBubble = true;
        e.returnValue = false;

        if (e.stopPropagation) {
                e.stopPropagation();
                e.preventDefault();
        }
}
}
        </script>  
        <style>
        .calendar .button
		{
		display:table-cell !important;
		}
        </style>  
            <table width="95%">
            <tr>
        	<td width="100%" style="font-size:14px; font-weight:bold"><a href="http://web-dorado.com/spider-calendar-wordpress-guide-step-2.html" target="_blank" style="color:blue; text-decoration:none;">User Manual</a><br>
This section allows you to create calendars. You can add unlimited number of calendars. <a href="http://web-dorado.com/spider-calendar-wordpress-guide-step-2.html" target="_blank" style="color:blue; text-decoration:none;">More...</a></td>
            <td colspan="7" align="right" style="font-size:16px;">
              <a href="http://web-dorado.com/files/fromSpiderCalendarWP.php" target="_blank" style="color:red; text-decoration:none;">
            <img src="<?php echo plugins_url('images/header.png',__FILE__) ?>" border="0" alt="http://web-dorado.com/files/fromSpiderCalendarWP.php" width="215"><br>
            Get the full version&nbsp;&nbsp;&nbsp;&nbsp;
            </a>
 			 </td>
   			</tr>
            <tr>
  <td width="100%"><h2>Add Calendar</h2></td>
  <td align="right"><input type="button" onclick="submitbutton('Save')" value="Save" class="button-secondary action"> </td>  
  <td align="right"><input type="button" onclick="submitbutton('Apply')" value="Apply" class="button-secondary action"> </td> 
  <td align="right"><input type="button" onclick="window.location.href='admin.php?page=SpiderCalendar'" value="Cancel" class="button-secondary action"> </td> 
  </tr></table>
	
		<form onkeypress="doNothing()" action="admin.php?page=SpiderCalendar" method="post" name="adminForm" id="adminForm">
		<table class="form-table" style="width:400px">
						<tr>
							<td class="key">
								<label for="name">
									Title:
								</label>
							</td>
							<td >
											<input type="text" name="title" id="title" size="30" value="" />
							</td>
						</tr>					                      
						
						
						
						
						
						<tr>
							<td class="key">
								<label for="name">
									Use 12 hours time format:
								</label>
							</td>
							<td>
											
	<input type="radio" name="time_format" id="time_format0" value="0" checked="checked" class="inputbox">
	<label for="time_format0">No</label>
	<input type="radio" name="time_format" id="time_format1" value="1" class="inputbox">
	<label for="time_format1">Yes</label>
							</td>
						</tr>
												<tr>
							<td class="key">
								<label for="name">
									Start with:
								</label>
							</td>
							<td>											
                          <div class="alignleft actions"><input style="width: 90px;" class="inputbox" type="text" name="start_month" id="startdate" size="10" maxlength="10" value=""> 
<input type="reset" class="button" value="..." onclick="return showCalendar('startdate','%Y-%m-%d');"> 
    </div>
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="published">
									Published:
								</label>
							</td>
							<td>
								
	<input type="radio" name="published" id="published0" value="0" class="inputbox">
	<label for="published0">No</label>
	<input type="radio" name="published" id="published1" value="1" checked="checked" class="inputbox">
	<label for="published1">Yes</label>
							</td>
						</tr>                
		 </table>        
		<input type="hidden" name="option" value="com_spidercalendar" />        
		<input type="hidden" name="id" value="<?php echo $row->id?>" />        
		<input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />        
		<input type="hidden" name="task" value="" />        
		</form>
				<?php		
			   
	
	
	
}
function html_edit_spider_calendar($row){	?>


	<script language="javascript" type="text/javascript">
	
		function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel_calendar') {
		submitform( pressbutton );
		return;
		}
	
					
		submitform( pressbutton );
		}
		
		function submitform(pressbutton){
			document.getElementById('adminForm').action=document.getElementById('adminForm').action+"&task="+pressbutton;
			document.getElementById('adminForm').submit();
			}
				function doNothing() {  
var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
    if( keyCode == 13 ) {


        if(!e) var e = window.event;

        e.cancelBubble = true;
        e.returnValue = false;

        if (e.stopPropagation) {
                e.stopPropagation();
                e.preventDefault();
        }
}
}
        </script>    
           <style>
        .calendar .button
		{
		display:table-cell !important;
		}
        </style>  
            <table width="95%">
                    <tr>
        <td width="100%" style="font-size:14px; font-weight:bold"><a href="http://web-dorado.com/spider-calendar-wordpress-guide-step-2.html" target="_blank" style="color:blue; text-decoration:none;">User Manual</a><br>
This section allows you to create calendars. You can add unlimited number of calendars. <a href="http://web-dorado.com/spider-calendar-wordpress-guide-step-2.html" target="_blank" style="color:blue; text-decoration:none;">More...</a></td>
            <td colspan="7" align="right" style="font-size:16px;">
              <a href="http://web-dorado.com/files/fromSpiderCalendarWP.php" target="_blank" style="color:red; text-decoration:none;">
            <img src="<?php echo plugins_url('images/header.png',__FILE__) ?>" border="0" alt="http://web-dorado.com/files/fromSpiderCalendarWP.php" width="215"><br>
            Get the full version&nbsp;&nbsp;&nbsp;&nbsp;
            </a>
 			 </td>
   			</tr>
            <tr>
  <td width="100%"><h2>Calendar - <?php echo $row->title ?></h2></td>
  <td align="right"><input type="button" onclick="submitbutton('Save')" value="Save" class="button-secondary action"> </td>  
  <td align="right"><input type="button" onclick="submitbutton('Apply')" value="Apply" class="button-secondary action"> </td> 
  <td align="right"><input type="button" onclick="window.location.href='admin.php?page=SpiderCalendar'" value="Cancel" class="button-secondary action"> </td> 
  </tr></table>
	
		<form onkeypress="doNothing()" action="admin.php?page=SpiderCalendar&id=<?php echo $row->id ?>" method="post" name="adminForm" id="adminForm">
		<table class="form-table" style="width:400px">
						<tr>
							<td class="key">
								<label for="name">
									Title:
								</label>
							</td>
							<td >
											<input type="text" name="title" id="title" size="30" value="<?php echo $row->title ?>" />
							</td>
						</tr>					                      
						
						
						
						
						
						<tr>
							<td class="key">
								<label for="name">
									Use 12 hours time format:
								</label>
							</td>
							<td>
											
	<input type="radio" name="time_format" id="time_format0" value="0"  <?php cheched($row->time_format,'0')  ?> class="inputbox">
	<label for="time_format0">No</label>
	<input type="radio" name="time_format" id="time_format1" value="1"  <?php cheched($row->time_format,'1')  ?> class="inputbox">
	<label for="time_format1">Yes</label>
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="name">
									Start with:
								</label>
							</td>
							<td>											
                          <div class="alignleft actions"><input style="width: 90px;" class="inputbox" type="text" name="start_month" id="startdate" size="10" maxlength="10" value="<?php echo $row->start_month ?>"> 
<input type="reset" class="button" value="..." onclick="return showCalendar('startdate','%Y-%m-%d');"> 
    </div>
							</td>
						</tr>
						<tr>
							<td class="key">
								<label for="published">
									Published:
								</label>
							</td>
							<td>
								
	<input type="radio" name="published" id="published0" value="0"  <?php cheched($row->published,'0')  ?> class="inputbox">
	<label for="published0">No</label>
	<input type="radio" name="published" id="published1" value="1"  <?php cheched($row->published,'1')  ?> class="inputbox">
	<label for="published1">Yes</label>
							</td>
						</tr>                
		 </table>        
		<input type="hidden" name="option" value="com_spidercalendar" />        
		<input type="hidden" name="id" value="<?php echo $row->id?>" />        
		<input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />        
		<input type="hidden" name="task" value="" />        
		</form>
				<?php		
			   
	
	
	
}
function cheched($row,$y)
{
	if($row==$y)
	{
			echo 'checked="checked"';
	}
}
function selectted($row,$y)
{
	if($row==$y)
	{
			echo 'selected="selected"';
	}
}






























////////////////////////////////////////////////         Events

















function html_show_spider_event($rows, $pageNav,$sort,$calendar_id,$cal_name){
	
	
		global $wpdb;
		
	?>
      <style>
    .calendar .button
		{
		display:table-cell !important;
		}
    
    </style>
    <script language="javascript">
	function ordering(name,as_or_desc)
	{
		document.getElementById('asc_or_desc').value=as_or_desc;		
		document.getElementById('order_by').value=name;
		document.getElementById('admin_form').submit();
	}
 	function doNothing() {  
var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
    if( keyCode == 13 ) {


        if(!e) var e = window.event;

        e.cancelBubble = true;
        e.returnValue = false;

        if (e.stopPropagation) {
                e.stopPropagation();
                e.preventDefault();
        }
}
}
	</script>
    <form method="post" onkeypress="doNothing()" action="admin.php?page=SpiderCalendar&task=show_manage_event&calendar_id=<?php echo  $calendar_id; ?>" id="admin_form" name="admin_form">
	<table cellspacing="10" width="95%">
            <tr>
        <td width="100%" style="font-size:14px; font-weight:bold"><a href="http://web-dorado.com/spider-calendar-wordpress-guide-step-3.html" target="_blank" style="color:blue; text-decoration:none;">User Manual</a><br>
This section allows you to create/edit the events of a particular calendar.<br /> You can add
unlimited number of events for each calendar. <a href="http://web-dorado.com/spider-calendar-wordpress-guide-step-3.html" target="_blank" style="color:blue; text-decoration:none;">More...</a></td>
            <td colspan="7" align="right" style="font-size:16px;">
              <a href="http://web-dorado.com/files/fromSpiderCalendarWP.php" target="_blank" style="color:red; text-decoration:none;">
            <img src="<?php echo plugins_url('images/header.png',__FILE__) ?>" border="0" alt="http://web-dorado.com/files/fromSpiderCalendarWP.php" width="215"><br>
            Get the full version&nbsp;&nbsp;&nbsp;&nbsp;
            </a>
 			 </td>
   			</tr>
    <tr>
    <td width="100%" >
    <?php  echo "<h2>".'Event Manager for calendar <font style="color:red">'.$cal_name."</font></h2>"; ?>
    </td>
    <td ><p class="submit" style="padding:0px; text-align:left"><input class="button-primary" type="button" value="Add a Event" name="custom_parametrs" onclick="window.location.href='admin.php?page=SpiderCalendar&task=add_event&calendar_id=<?php echo  $calendar_id; ?>'" />
    </p></td>
<td >
<p class="submit" style="padding:0px; text-align:left"><input type="button" class="button-primary" value="Back" name="custom_parametrs" onclick="window.location.href='admin.php?page=SpiderCalendar'" /></p>
	</td>
   
  

  
    </tr>
    </table>
    
   
    <?php
	if(isset($_POST['serch_or_not'])) {if($_POST['serch_or_not']=="search"){ $serch_value=$_POST['search_events_by_title']; }else{$serch_value="";}} 
	$serch_fields='<div class="alignleft actions" style="width:180px;">
    	<label for="search_events_by_title" style="font-size:14px">Title: </label>
        <input type="text" name="search_events_by_title" value="'.$serch_value.'" id="search_events_by_title" onchange="clear_serch_texts()">
    </div>
			<div class="alignleft actions">		    From:<input style="width: 90px;" class="inputbox" type="text" name="startdate" id="startdate" size="10" maxlength="10" value="'.$_POST["startdate"].'"> 
<input type="reset" class="button" value="..." onclick="return showCalendar(\'startdate\',\'%Y-%m-%d\');"> To:  <input style="width: 90px;" class="inputbox" type="text" name="enddate" id="enddate" size="10" maxlength="10" value="'.$_POST["enddate"].'"> 
<input type="reset" class="button" value="..." onclick="return showCalendar(\'enddate\',\'%Y-%m-%d\');">
    </div>
	<div class="alignleft actions">
   		<input type="button" value="Search" onclick="document.getElementById(\'page_number\').value=\'1\';document.getElementById(\'serch_or_not\').value=\'search\'; document.getElementById(\'admin_form\').submit();" class="button-secondary action"><input type="button" value="Reset" onclick="window.location.href=\'admin.php?page=SpiderCalendar&task=show_manage_event&calendar_id='.$calendar_id.'\'" class="button-secondary action">
    </div>';
	 print_html_nav($pageNav['total'],$pageNav['limit'],$serch_fields);	
	
	?>
  <table class="wp-list-table widefat fixed pages" style="width:95%">
 <thead>
 <TR>
 <th scope="col"  id="id" class="<?php if($sort["sortid_by"]=="id") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style=" width:50px" ><a href="javascript:ordering('id',<?php if($sort["sortid_by"]=="id") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>ID</span><span class="sorting-indicator"></span></a></th>
 <th scope="col" id="title" class="<?php if($sort["sortid_by"]=="title") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" ><a href="javascript:ordering('title',<?php if($sort["sortid_by"]=="title") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>Title</span><span class="sorting-indicator"></span></a></th>
 <th scope="col" id="date" class="<?php if($sort["sortid_by"]=="date") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" ><a href="javascript:ordering('date',<?php if($sort["sortid_by"]=="date") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>Date</span><span class="sorting-indicator"></span></a></th>
 <th scope="col" id="time" class="<?php if($sort["sortid_by"]=="time") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" ><a href="javascript:ordering('time',<?php if($sort["sortid_by"]=="time") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>Time</span><span class="sorting-indicator"></span></a></th>

  <th scope="col" id="published" class="<?php if($sort["sortid_by"]=="published") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style=" width:100px" ><a href="javascript:ordering('published',<?php if($sort["sortid_by"]=="published") echo $sort["1_or_2"]; else echo "1"; ?>)"><span>Published</span><span class="sorting-indicator"></span></a></th>
 <th style="width:80px">Edit</th>
 <th  style="width:80px">Delete</th>
 </TR>
 </thead>
 <tbody>
 <?php for($i=0; $i<count($rows);$i++){ ?>
 <tr>
         <td><?php echo $rows[$i]->id; ?></td>
         <td><a href="admin.php?page=SpiderCalendar&calendar_id=<?php echo  $calendar_id; ?>&task=edit_event&id=<?php echo $rows[$i]->id; ?>"><?php echo $rows[$i]->title; ?></a></td>
         <td><?php if($rows[$i]->date_end!='0000-00-00' ) {echo $rows[$i]->date.' - '.$rows[$i]->date_end; }else echo $rows[$i]->date;  ?></td>
         <td><?php echo $rows[$i]->time ?></td>
        
         <td><a <?php if(!$rows[$i]->published) echo 'style="color:#C00"'; ?> href="admin.php?page=SpiderCalendar&calendar_id=<?php echo  $calendar_id; ?>&task=published_event&id=<?php echo $rows[$i]->id; ?>"><?php if($rows[$i]->published) echo "Yes"; else echo "No"; ?></a></td>
         <td><a href="admin.php?page=SpiderCalendar&calendar_id=<?php echo  $calendar_id; ?>&task=edit_event&id=<?php echo $rows[$i]->id; ?>">Edit</a></td>
         <td><a href="admin.php?page=SpiderCalendar&calendar_id=<?php echo  $calendar_id; ?>&task=remove_event&id=<?php echo $rows[$i]->id; ?>">Delete</a></td>
               
  </tr> 
 <?php } ?>
 </tbody>
 </table>
 <input type="hidden" name="id_for_playlist" id="id_for_playlist" value="<?php if(isset($_POST['id_for_playlist'])) echo $_POST['id_for_playlist'];?>" />
 <input type="hidden" name="asc_or_desc" id="asc_or_desc" value="<?php if(isset($_POST['asc_or_desc'])) echo $_POST['asc_or_desc'];?>"  />
 <input type="hidden" name="order_by" id="order_by" value="<?php if(isset($_POST['order_by'])) echo $_POST['order_by'];?>"  />

 <?php
?>
    
    
   
 </form>
  
    <?php

	
}



function html_add_spider_event($calendar_id,$cal_name){
	
		?>
          <style>
    .calendar .button
		{
		display:table-cell !important;
		}
    
    </style>
 
		<script language="javascript" type="text/javascript">
		
		function submitbutton(pressbutton)

		{

			var form = document.adminForm;

			if (pressbutton == 'cancel_event') 

			{

				submitform( pressbutton );

				return;

			}
			
			
		if(form.date.value.search(/^[0-9]{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])/))
		{
			  alert('Invalid Date');
		}
		else
		if(form.selhour_from.value=="" && form.selminute_from.value=="" && form.selhour_to.value=="" && form.selminute_to.value=="")
			submitform( pressbutton );
			else
			if(form.selhour_from.value!="" && form.selminute_from.value!="" && form.selhour_to.value=="" && form.selminute_to.value=="")
				submitform( pressbutton );
				else
				if(form.selhour_from.value!="" && form.selminute_from.value!="" && form.selhour_to.value!="" && form.selminute_to.value!="")
					submitform( pressbutton );
					else
					alert('Invalid Time');
		}
		
		
		function submitform( pressbutton ){
		
		
		document.getElementById('adminForm').action=document.getElementById('adminForm').action+"&task="+pressbutton;
		document.getElementById('adminForm').submit();
		
		}
		function checkhour(id)
			{	
				if(typeof(event)!='undefined')
				{
					var e = event; // for trans-browser compatibility
					var charCode = e.which || e.keyCode;
		
						if (charCode > 31 && (charCode < 48 || charCode > 57))
						return false;
		
						hour=""+document.getElementById(id).value+String.fromCharCode(e.charCode);
						hour=parseFloat(hour);
						if(document.getSelection()!='')
						return true;
						
						if((hour<0) || (hour>23))
						return false;
				}
						return true;
			}
		
		function check12hour(id)
			{	
				if(typeof(event)!='undefined')
				{
					var e = event; // for trans-browser compatibility
					var charCode = e.which || e.keyCode;
						input=document.getElementById(id);
		
		 
						if(charCode==48 && input.value.length==0)
						return false;
						
						if (charCode > 31 && (charCode < 48 || charCode > 57))
						return false;
		
						hour=""+document.getElementById(id).value+String.fromCharCode(e.charCode);
						hour=parseFloat(hour);
						if(document.getSelection()!='')
						return true;
						
						if((hour<0) || (hour>12))
						return false;
				}
						return true;
			}
		
		function checknumber(id)
			{	
				if(typeof(event)!='undefined')
				{
					var e = event; // for trans-browser compatibility
					var charCode = e.which || e.keyCode;
		
						if (charCode > 31 && (charCode < 48 || charCode > 57))
						return false;
		
				}
						return true;
			}
		
		
		function checkminute(id)
			{	
			if(typeof(event)!='undefined')
				{
				var e = event; // for trans-browser compatibility
				var charCode = e.which || e.keyCode;
		
				if (charCode > 31 && (charCode < 48 || charCode > 57))
				return false;
		
					minute=""+document.getElementById(id).value+String.fromCharCode(e.charCode);
					minute=parseFloat(minute);
					if(document.getSelection()!='')
						return true;
					if((minute<0) || (minute>59))
				return false;
				}
						return true;
			}		
		function add_0(id)
		{
		
		    input=document.getElementById(id);
		
		    if(input.value.length==1)
		
		    {
		
			input.value='0'+input.value;
		
			input.setAttribute("value", input.value);
		
		    }
		
		}
	

		
		function change_type(type)
{
	if(document.getElementById('daily1').value=='')
		document.getElementById('daily1').value=1;
	else
		document.getElementById('repeat_input').removeAttribute('style');
	
	if(document.getElementById('weekly1').value=='')
		document.getElementById('weekly1').value=1;
	
	if(document.getElementById('monthly1').value=='')
		document.getElementById('monthly1').value=1;
	
	if(document.getElementById('yearly1').value=='')
		document.getElementById('yearly1').value=1;
		
		
	
			
	switch(type)
{
	
	
	case 'no_repeat':	
document.getElementById('daily').setAttribute('style','display:none');
document.getElementById('weekly').setAttribute('style','display:none');
document.getElementById('monthly').setAttribute('style','display:none');
document.getElementById('year_month').setAttribute('style','display:none');
//document.getElementById('repeat_input').value=1;
document.getElementById('month').value='';
document.getElementById('date_end').value=''

document.getElementById('repeat_until').setAttribute('style','display:none');
break;

	case 'daily':	
document.getElementById('daily').removeAttribute('style');
document.getElementById('weekly').setAttribute('style','display:none');
document.getElementById('monthly').setAttribute('style','display:none');
document.getElementById('repeat').innerHTML='Day(s)'
document.getElementById('repeat_input').value=document.getElementById('daily1').value;
document.getElementById('month').value='';
document.getElementById('year_month').setAttribute('style','display:none');
document.getElementById('repeat_until').removeAttribute('style');
document.getElementById('repeat_input').onchange=function onchange(event) {return input_value('daily1')};


break;

case 'weekly':	
document.getElementById('daily').removeAttribute('style');
document.getElementById('weekly').removeAttribute('style');
document.getElementById('monthly').setAttribute('style','display:none');
document.getElementById('repeat').innerHTML='Week(s) on :'
document.getElementById('repeat_input').value=document.getElementById('weekly1').value;
document.getElementById('month').value='';
document.getElementById('year_month').setAttribute('style','display:none');
document.getElementById('repeat_until').removeAttribute('style');
document.getElementById('repeat_input').onchange=function onchange(event) {return input_value('weekly1')};

break;

case 'monthly':	
document.getElementById('daily').removeAttribute('style');
document.getElementById('weekly').setAttribute('style','display:none');
document.getElementById('monthly').removeAttribute('style');
document.getElementById('repeat').innerHTML='Month(s)'
document.getElementById('repeat_input').value=document.getElementById('monthly1').value;
document.getElementById('month').value='';
document.getElementById('year_month').setAttribute('style','display:none');
document.getElementById('repeat_until').removeAttribute('style');
document.getElementById('repeat_input').onchange=function onchange(event) {return input_value('monthly1')};

break;

case 'yearly':	
document.getElementById('daily').removeAttribute('style');
document.getElementById('year_month').removeAttribute('style');
document.getElementById('weekly').setAttribute('style','display:none');
document.getElementById('monthly').removeAttribute('style');
document.getElementById('repeat').innerHTML='Year(s) in '
document.getElementById('repeat_input').value=document.getElementById('yearly1').value;
document.getElementById('month').value='';
document.getElementById('repeat_until').removeAttribute('style');
document.getElementById('repeat_input').onchange=function onchange(event) {return input_value('yearly1')};

break;

	
	
}
		
}

function week_value()
{
var value='';
for(i=1; i<=7; i++)
{

if (document.getElementById('week_'+i).checked)
{
	value=value+document.getElementById('week_'+i).value+',';
	
}
	
}
document.getElementById('week').value=value;



}


	

function input_repeat()
{
	if(document.getElementById('repeat_input').value==1)
	{
	document.getElementById('repeat_input').value='';
	
	}
	document.getElementById('repeat_input').removeAttribute('style');
	
}
		
function radio_month()
{
	if(document.getElementById('radio1').checked==true)
		{	
		document.getElementById('monthly_list').disabled=true;
		document.getElementById('month_week').disabled=true;
		document.getElementById('month').disabled=false;
		}
	else
	{
	document.getElementById('month').disabled=true;
	document.getElementById('monthly_list').disabled=false;
		document.getElementById('month_week').disabled=false;
	}
	

}
	
	
	function input_value(id)
	
{
	document.getElementById(id).value=document.getElementById('repeat_input').value;
}
		

		</script>  
        <style>
		fieldset{
	border: 2px solid #4f9bc6 ;/*#CCA383 1462a5*/
	width: 100%;
	background:  #fafbfd;
	padding: 13px;
	margin-top: 20px;	
	
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	border-radius: 8px;
	
}        </style>   
<table width="95%"><tbody>
            <tr>
        <td width="100%" style="font-size:14px; font-weight:bold"><a href="http://web-dorado.com/spider-calendar-wordpress-guide-step-3.html" target="_blank" style="color:blue; text-decoration:none;">User Manual</a><br>
This section allows you to create/edit the events of a particular calendar.<br /> You can add
unlimited number of events for each calendar. <a href="http://web-dorado.com/spider-calendar-wordpress-guide-step-3.html" target="_blank" style="color:blue; text-decoration:none;">More...</a></td>
            <td colspan="7" align="right" style="font-size:16px;">
              <a href="http://web-dorado.com/files/fromSpiderCalendarWP.php" target="_blank" style="color:red; text-decoration:none;">
            <img src="<?php echo plugins_url('images/header.png',__FILE__) ?>" border="0" alt="http://web-dorado.com/files/fromSpiderCalendarWP.php" width="215"><br>
            Get the full version&nbsp;&nbsp;&nbsp;&nbsp;
            </a>
 			 </td>
   			</tr>
            <tr>
  <td width="100%"><?php  echo "<h2>".'Add an event for calendar <font style="color:red">'.$cal_name."</font></h2>"; ?></td>
  <td align="right"><input type="button" onclick="submitbutton('save_event')" value="Save" class="button-secondary action"> </td>  
  <td align="right"><input type="button" onclick="submitbutton('apply_event')" value="Apply" class="button-secondary action"> </td> 
  <td align="right"><input type="button" onclick="window.location.href='admin.php?page=SpiderCalendar&calendar_id=<?php echo $calendar_id; ?>&task=show_manage_event'" value="Cancel" class="button-secondary action"> </td> 
  </tr></tbody></table>   
        <?php 
		global $wpdb;
		$calendar =$wpdb->get_row("SELECT * FROM ".$wpdb->prefix."spidercalendar_calendar  WHERE id='".$calendar_id."'");
	
		
		
		?>
        <form  action="admin.php?page=SpiderCalendar&calendar_id=<?php echo $calendar_id; ?>" method="post" id="adminForm" name="adminForm">

	<table width="95%"><tr><td style="width:45%">			
<div style="width:95%">
<fieldset class="adminform">
<legend>
Event Details
</legend>
                
                <table class="admintable">
                  <tr>
					<td class="key">
						<label for="message">
							Title:
						</label>
					</td>
                	<td>
                    	<input type="text" id="title" name="title" size="41" />
                    </td>
				</tr> 
                <tr>
					<td class="key">
						<label for="message">
							Date:
						</label>
					</td><td><input style="width:90px" class="inputbox" type="text" name="date" id="date" size="10" maxlength="10" value="" /> 

<input type="reset" class="button" value="..."

onclick="return showCalendar('date','%Y-%m-%d');" /> </td></tr>      
                                   
                                  <tr>
					<td class="key">
						<label for="message">
							Time:
						</label>
					</td>
                                     <?php if($calendar->time_format==1){  ?>
                                        <td>
										 
                                    <input type="text" id="selhour_from" name="selhour_from" size="1" style="text-align:right" onkeypress="return check12hour('selhour_from')" value="" title="from"   /> <b>:</b>
                                    <input type="text" id="selminute_from" name="selminute_from" size="1" style="text-align:right" onkeypress="return checkminute('selminute_from')" value="" onblur="add_0('selminute_from')"  title="from" /> 
									
									
									<select id="select_from" name="select_from" >
									<option selected="selected">AM</option>
									<option>PM</option>
									
									</select>
									
									
									<span style="font-size:12px">&nbsp;-&nbsp;</span>
                                    
									
									<input type="text" id="selhour_to" name="selhour_to" size="1" style="text-align:right" onkeypress="return check12hour('selhour_to')" value=""  title="to" /> <b>:</b>
                                    <input type="text" id="selminute_to" name="selminute_to" size="1" style="text-align:right" onkeypress="return checkminute('selminute_to')" value="" onblur="add_0('selminute_to')"  title="to" />
                                   
								   <select id="select_to" name="select_to">
									<option>AM</option>
									<option>PM</option>
									
									</select>
									
									</td>
				<?php } if($calendar->time_format==0){?>
				
				<td>
										 
                                    <input type="text" id="selhour_from" name="selhour_from" size="1" style="text-align:right" onkeypress="return checkhour('selhour_from')" value="" title="from" onblur="add_0('selhour_from')"  /> <b>:</b>
                                    <input type="text" id="selminute_from" name="selminute_from" size="1" style="text-align:right" onkeypress="return checkminute('selminute_from')" value=""  title="from" onblur="add_0('selminute_from')"/> 
									
									
									<span style="font-size:12px">&nbsp;-&nbsp;</span>
                                    
									
									<input type="text" id="selhour_to" name="selhour_to" size="1" style="text-align:right" onkeypress="return checkhour('selhour_to')" value=""  title="to" onblur="add_0('selhour_to')"/> <b>:</b>
                                    <input type="text" id="selminute_to" name="selminute_to" size="1" style="text-align:right" onkeypress="return checkminute('selminute_to')" value=""  title="to" onblur="add_0('selminute_to')"/>
                                   
									</td>
				
				<?php }?>
				</tr> 

    
				<tr>
					<td class="key">
						<label for="message">Note:
						</label>
					</td>
					<td >
                    <div  id="poststuff" style="width:100% !important;" >
<div id="<?php echo user_can_richedit() ? 'postdivrich' : 'postdiv'; ?>" class="postarea" ><?php the_editor( "","text_for_date");  ?>
</div>
</div>
					</td>
				</tr>
                

<td class="key">
<label for="note">
Published:
</label>
</td>
<td>

	<input type="radio" name="published" id="published0" value="0" class="inputbox">
	<label for="published0">No</label>
	<input type="radio" name="published" id="published1" value="1" checked="checked" class="inputbox">
	<label for="published1">Yes</label>
</td>
</tr>                
</table>   
</fieldset>
</div>
</td><td style="padding-left:25px; vertical-align:top !important; width:45%">
<div style="width:100%">
<fieldset class="adminform">
<legend>
Repeat Event
</legend>
<table>
<tr>

<td valign="top" >
 <input type="radio" value="no_repeat"  name="repeat_method"  checked="checked" onchange="change_type('no_repeat')"  />Don't repeat this event<br/>
 <input type="radio" value="daily" name="repeat_method"   onchange="change_type('daily');"    />Repeat daily<br/>
 <input type="radio" value="weekly" name="repeat_method"  onchange="change_type('weekly');" />Repeat weekly<br/>
 <input type="radio" value="monthly" name="repeat_method"  onchange="change_type('monthly');"  />Repeat monthly<br/>
 <input type="radio" value="yearly" name="repeat_method"  onchange="change_type('yearly');"   />Repeat yearly<br/>
</td>
   
<td style="padding-left:10px" valign="top">
<div id="daily" style="display:none">

Repeat every <input type="text" id="repeat_input" size="5" name="repeat"  onclick="return input_repeat()"  onkeypress="return checknumber(repeat_input)" value="1"   /> 
<label id="repeat"></label> <label id="year_month" style="display:none"><select name="year_month" id="year_month" class="inputbox"><option value="1" selected="selected">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select></label>
</div><br />
  

<input type="hidden"   id="daily1" />
<input type="hidden" id="weekly1" />
<input type="hidden"  id="monthly1" />
<input type="hidden"  id="yearly1" />

<div class="key"  id="weekly" style="display:none">



 <input type="checkbox" value="Mon"  id="week_1" onchange="week_value()"    />Mon
 <input  type="checkbox" value="Tue" id="week_2"  onchange="week_value()"    />Tue
 <input type="checkbox" value="Wed" id="week_3" onchange="week_value()"  />Wed
 <input type="checkbox" value="Thu" id="week_4" onchange="week_value()"   />Thu
 <input type="checkbox" value="Fri" id="week_5"  onchange="week_value()"   />Fri
 <input type="checkbox" value="Sat" id="week_6"  onchange="week_value()"   />Sat
 <input type="checkbox" value="Sun" id="week_7"  onchange="week_value()"   />Sun

<input type="hidden" name="week" id="week"  />



</div><br />



<div class="key" id="monthly" style="display:none">



 

<input type="radio" id="radio1"   onchange="radio_month()" name="month_type" value="1" checked="checked"  />on the: <input type="text" onkeypress="return checknumber(month)" name="month" size="3" id="month"  /><br/>
<input type="radio" id="radio2" onchange="radio_month()" name="month_type" value="2"   />on the:  <select name="monthly_list" id="monthly_list" class="inputbox">
<option value="1">First</option>
<option value="8">Second</option>
<option value="15">Third</option>
<option value="22">Fourth</option>
<option value="last">Last</option></select>
<select name="month_week" id="month_week" class="inputbox">
<option value="Mon">Monday</option>
<option value="Tue">Tuesday</option>
<option value="Wed">Wednesday</option>
<option value="Thu">Thursday</option>
<option value="Fri">Friday</option>
<option value="Sat">Saturday</option>
<option value="Sun">Sunday</option>
</select>
</div><br />
<script>
window.onload=radio_month();
</script>


</td>
</tr>

<tr id="repeat_until" style="display:none">
<td>
Repeat until: </td>
<td>
<input style="width:90px" class="inputbox" type="text" name="date_end" id="date_end" size="10" maxlength="10" value="" /> 

<input type="reset" class="button" value="..."

onclick="return showCalendar('date_end','%Y-%m-%d');" />
</td>
</tr>
</table>

</fieldset>
</div>

</td></tr></table>




     
		<input type="hidden" name="option" value="com_spidercalendar" />
		<input type="hidden" name="task" value="" />      
        <input type="hidden" name="calendar" value="<?php echo $lists['calendar']; ?>" />   
        
        </form>
        <?php
		
	
	
	
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
function html_edit_spider_event($row,$calendar_id,$id,$cal_name){
	global $wpdb;
$calendar=$wpdb->get_row("SELECT * FROM ".$wpdb->prefix."spidercalendar_calendar");
?>
          <style>
    .calendar .button
		{
		display:table-cell !important;
		}
    
    </style>
<script language="javascript" type="text/javascript">


function submitform(pressbutton){
	document.getElementById('adminForm').action=document.getElementById('adminForm').action+"&task="+pressbutton;
	document.getElementById('adminForm').submit();
}
function submitbutton(pressbutton) {

var form = document.adminForm;

if (pressbutton == 'cancel_event') {

submitform( pressbutton );

return;

}

if(form.date.value.search(/^[0-9]{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])/))
{
	  alert('Invalid Date');
}
else
		if(form.date.value.search(/^[0-9]{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])/))
		{
			  alert('Invalid Date');
		}
		else
		if(form.selhour_from.value=="" && form.selminute_from.value=="" && form.selhour_to.value=="" && form.selminute_to.value=="")
			submitform( pressbutton );
			else
			if(form.selhour_from.value!="" && form.selminute_from.value!="" && form.selhour_to.value=="" && form.selminute_to.value=="")
				submitform( pressbutton );
				else
				if(form.selhour_from.value!="" && form.selminute_from.value!="" && form.selhour_to.value!="" && form.selminute_to.value!="")
					submitform( pressbutton );
					else
					alert('Invalid Time');
		}
		
function checkhour(id)
	{	
		if(typeof(event)!='undefined')
		{
			var e = event; // for trans-browser compatibility
			var charCode = e.which || e.keyCode;

				if (charCode > 31 && (charCode < 48 || charCode > 57))
				return false;

				hour=""+document.getElementById(id).value+String.fromCharCode(e.charCode);
				hour=parseFloat(hour);
				if(document.getSelection()!='')
						return true;
				if((hour<0) || (hour>23))
				return false;
		}
				return true;

	} 
function checkminute(id)
	{	
	if(typeof(event)!='undefined')
		{
		var e = event; // for trans-browser compatibility
		var charCode = e.which || e.keyCode;

		if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

			minute=""+document.getElementById(id).value+String.fromCharCode(e.charCode);
			minute=parseFloat(minute);
			if(document.getSelection()!='')
						return true;
			if((minute<0) || (minute>59))
		return false;
		}
				return true;
	}	
	
		function checknumber(id)
			{	
				if(typeof(event)!='undefined')
				{
					var e = event; // for trans-browser compatibility
					var charCode = e.which || e.keyCode;
		
						if (charCode > 31 && (charCode < 48 || charCode > 57))
						return false;
		
				}
						return true;
			}	
	
	
	
	function check12hour(id)
			{	
				if(typeof(event)!='undefined')
				{
					var e = event; // for trans-browser compatibility
					var charCode = e.which || e.keyCode;
						input=document.getElementById(id);
		
		 
						if(charCode==48 && input.value.length==0)
						return false;
						
						if (charCode > 31 && (charCode < 48 || charCode > 57))
						return false;
		
						hour=""+document.getElementById(id).value+String.fromCharCode(e.charCode);
						hour=parseFloat(hour);
						if(document.getSelection()!='')
						return true;
						
						if((hour<0) || (hour>12))
						return false;
				}
						return true;
			}
		
		function add_0(id)
		{
		
		    input=document.getElementById(id);
		
		    if(input.value.length==1)
		
		    {
		
			input.value='0'+input.value;
		
			input.setAttribute("value", input.value);
		
		    }
		
		}
		
function change_type(type)
{
	
	if(document.getElementById('daily1').value=='')
		document.getElementById('daily1').value=1;
	
	if(document.getElementById('weekly1').value=='')
		document.getElementById('weekly1').value=1;
	
	if(document.getElementById('monthly1').value=='')
		document.getElementById('monthly1').value=1;
	
	if(document.getElementById('yearly1').value=='')
		document.getElementById('yearly1').value=1;
	
	

	switch(type)
{
	
	
	case 'no_repeat':	
document.getElementById('daily').setAttribute('style','display:none');
document.getElementById('weekly').setAttribute('style','display:none');
document.getElementById('monthly').setAttribute('style','display:none');
document.getElementById('year_month').setAttribute('style','display:none');
document.getElementById('repeat_until').setAttribute('style','display:none');
//document.getElementById('repeat_input').value='';
document.getElementById('month').value='';
document.getElementById('date_end').value=''
break;

	case 'daily':	
document.getElementById('daily').removeAttribute('style');
document.getElementById('repeat_until').removeAttribute('style');
document.getElementById('weekly').setAttribute('style','display:none');
document.getElementById('monthly').setAttribute('style','display:none');
document.getElementById('repeat').innerHTML='Day(s)'
document.getElementById('repeat_input').onchange=function onchange(event) {return input_value('daily1')};
document.getElementById('month').value='';
document.getElementById('year_month').setAttribute('style','display:none');
document.getElementById('repeat_input').value=document.getElementById('daily1').value;


break;

case 'weekly':	
document.getElementById('daily').removeAttribute('style');
document.getElementById('weekly').removeAttribute('style');
document.getElementById('monthly').setAttribute('style','display:none');
document.getElementById('repeat').innerHTML='Week(s) on :'
document.getElementById('repeat_input').onchange=function onchange(event) {return input_value('weekly1')};
document.getElementById('month').value='';
document.getElementById('year_month').setAttribute('style','display:none');
document.getElementById('repeat_until').removeAttribute('style');
document.getElementById('repeat_input').value=document.getElementById('weekly1').value;
break;

case 'monthly':	
document.getElementById('daily').removeAttribute('style');
document.getElementById('weekly').setAttribute('style','display:none');
document.getElementById('monthly').removeAttribute('style');
document.getElementById('repeat').innerHTML='Month(s)'
document.getElementById('repeat_input').value=document.getElementById('monthly1').value;
document.getElementById('month').value='';
document.getElementById('year_month').setAttribute('style','display:none');
document.getElementById('repeat_until').removeAttribute('style');
document.getElementById('repeat_input').onchange=function onchange(event) {return input_value('monthly1')};
break;

case 'yearly':	
document.getElementById('daily').removeAttribute('style');
document.getElementById('year_month').removeAttribute('style');
document.getElementById('weekly').setAttribute('style','display:none');
document.getElementById('monthly').removeAttribute('style');
document.getElementById('repeat').innerHTML='Year(s) in '
document.getElementById('repeat_input').value=document.getElementById('yearly1').value;
document.getElementById('month').value='';
document.getElementById('repeat_until').removeAttribute('style');
document.getElementById('repeat_input').onchange=function onchange(event) {return input_value('yearly1')};
break;

	
	
}
		
}

function week_value()
{
var value='';
for(i=1; i<=7; i++)
{

if (document.getElementById('week_'+i).checked)
{
	value=value+document.getElementById('week_'+i).value+',';
	
}
	
}
document.getElementById('week').value=value;



}


		
function radio_month()
{
	if(document.getElementById('radio1').checked==true)
		{	
		document.getElementById('monthly_list').disabled=true;
		document.getElementById('month_week').disabled=true;
		document.getElementById('month').disabled=false;
		}
	else
	{
	document.getElementById('month').disabled=true;
	document.getElementById('monthly_list').disabled=false;
		document.getElementById('month_week').disabled=false;
	}
	

}

function input_value(id)
	
{
	document.getElementById(id).value=document.getElementById('repeat_input').value;
}

</script>     

 <style>
		fieldset{
	border: 2px solid #4f9bc6 ;/*#CCA383 1462a5*/
	width: 100%;
	background:  #fafbfd;
	padding: 13px;
	margin-top: 20px;	
	
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	border-radius: 8px;
	
}        </style> 
<table width="95%">
            <tr>
        <td width="100%" style="font-size:14px; font-weight:bold"><a href="http://web-dorado.com/spider-calendar-wordpress-guide-step-3.html" target="_blank" style="color:blue; text-decoration:none;">User Manual</a><br>
This section allows you to create/edit the events of a particular calendar.<br /> You can add
unlimited number of events for each calendar. <a href="http://web-dorado.com/spider-calendar-wordpress-guide-step-3.html" target="_blank" style="color:blue; text-decoration:none;">More...</a></td>
            <td colspan="7" align="right" style="font-size:16px;">
              <a href="http://web-dorado.com/files/fromSpiderCalendarWP.php" target="_blank" style="color:red; text-decoration:none;">
            <img src="<?php echo plugins_url('images/header.png',__FILE__) ?>" border="0" alt="http://web-dorado.com/files/fromSpiderCalendarWP.php" width="215"><br>
            Get the full version&nbsp;&nbsp;&nbsp;&nbsp;
            </a>
 			 </td>
   			</tr>
<tbody><tr>
  <td width="100%"><?php  echo "<h2>".'Edit an event for calendar <font style="color:red">'.$cal_name."</font></h2>"; ?></td>
  <td align="right"><input type="button" onclick="submitbutton('save_event')" value="Save" class="button-secondary action"> </td>  
  <td align="right"><input type="button" onclick="submitbutton('apply_event')" value="Apply" class="button-secondary action"> </td> 
  <td align="right"><input type="button" onclick="window.location.href='admin.php?page=SpiderCalendar&calendar_id=<?php echo $calendar_id; ?>&task=show_manage_event'" value="Cancel" class="button-secondary action"> </td> 
  </tr></tbody></table>   
<form action="admin.php?page=SpiderCalendar&calendar_id=<?php echo $calendar_id; ?>&id=<?php echo $id; ?>" method="post" id="adminForm" name="adminForm">

	<table width="95%"><tr><td style="width:45%">			
<div style="width:95%">
<fieldset class="adminform">
<legend>
Event Details
</legend>
<table class="admintable">
                <tr>
					<td class="key">
						<label for="message">
                        Title:
						</label>
					</td>
                	<td>
                    	<input type="text" id="title" name="title" size="41"  value="<?php echo htmlspecialchars($row->title, ENT_QUOTES); ?>" />
                    </td>
				</tr>    

                <tr>
					<td class="key">
						<label for="message">
							Date:
						</label>
					</td>
				 
                <td>
                    	<input class="inputbox" style="width:90px" type="text" name="date" id="date" size="10" maxlength="10" value="<?php echo $row ->date; ?>" /> 
<?php
if ($row ->date_end=='0000-00-00')
$row ->date_end="";
?>
<input type="reset" class="button" value="..." onclick="return showCalendar('date','%Y-%m-%d');" /> 
                </td>           
                </tr> 
  <tr>
					<td class="key">
						<label for="message">
						Time:
						</label>
					</td>
                                        <td>
                                                                  
                                     <?php 
				     if(!$row ->time)
				     { 
				     	$from[0]="";
				     	$from[1]="";
				     	$to[0]="";
				     	$to[1]="";
				     }
				     else
				     {
					     $from_to = explode("-", $row ->time);
					     $from    = explode(":", $from_to[0]);
						if(isset($from_to[1]))
					     		$to = explode(":", $from_to[1]);
						else
						{
							$to[0]="";
							$to[1]="";
						}
				     }
				     ?> 
                                      
                                   <?php if($calendar->time_format==0){?>  
                                    <input type="text" id="selhour_from" name="selhour_from" size="1" style="text-align:right" onkeypress="return checkhour('selhour_from')" value="<?php echo $from[0]; ?>" title="from"  onblur="add_0('selhour_from')"/> <b>:</b>
                                    <input type="text" id="selminute_from" name="selminute_from" size="1" style="text-align:right" onkeypress="return checkminute('selminute_from')" value="<?php echo substr($from[1],0,2); ?>"  title="from" onblur="add_0('selminute_from')"/> <span style="font-size:12px">&nbsp;-&nbsp;</span>
                                    <input type="text" id="selhour_to" name="selhour_to" size="1" style="text-align:right" onkeypress="return checkhour('selhour_to')" value="<?php echo $to[0]; ?>"  title="to" onblur="add_0('selhour_to')" /> <b>:</b>
                                    <input type="text" id="selminute_to" name="selminute_to" size="1" style="text-align:right" onkeypress="return checkminute('selminute_to')" value="<?php echo substr($to[1],0,2); ?>"  title="to" onblur="add_0('selminute_to')"/>
                                    
									<?php }   if($calendar->time_format==1){?>
									 
									<input type="text" id="selhour_from" name="selhour_from" size="1" style="text-align:right" onkeypress="return check12hour('selhour_from')" value="<?php echo $from[0]; ?>" title="from"  onblur="add_0('selhour_from')"/> <b>:</b>
                                    <input type="text" id="selminute_from" name="selminute_from" size="1" style="text-align:right" onkeypress="return checkminute('selminute_from')" value="<?php echo substr($from[1],0,2); ?>"  title="from" onblur="add_0('selminute_from')"/> 
                                    <select id="select_from" name="select_from" >
									<option <?php if(substr($from[1],2,2)=="AM") echo 'selected="selected"'; ?>>AM</option>
									<option <?php if(substr($from[1],2,2)=="PM") echo 'selected="selected"'; ?>>PM</option>
									
									</select>
								   
									<span style="font-size:12px">&nbsp;-&nbsp;</span>
									
									<input type="text" id="selhour_to" name="selhour_to" size="1" style="text-align:right" onkeypress="return check12hour('selhour_to')" value="<?php echo $to[0]; ?>"  title="to" onblur="add_0('selhour_to')" /> <b>:</b>
                                    <input type="text" id="selminute_to" name="selminute_to" size="1" style="text-align:right" onkeypress="return checkminute('selminute_to')" value="<?php echo substr($to[1],0,2); ?>"  title="to" onblur="add_0('selminute_to')"/>
                                     
									 <select id="select_to" name="select_to">
									<option <?php if(substr($to[1],2,2)=="AM") echo 'selected="selected"'; ?>>AM</option>
									<option <?php if(substr($to[1],2,2)=="PM") echo 'selected="selected"';  ?>>PM</option>
									
									</select>
									
									
									
									<?php }?>
									</td>
				</tr> 
               
<tr>
<td class="key">
<label for="note">Note:
</label>
</td>
<td >
       <div  id="poststuff" style="width:100% !important;" >
<div id="<?php echo user_can_richedit() ? 'postdivrich' : 'postdiv'; ?>" class="postarea" ><?php the_editor( $row->text_for_date,"text_for_date");  ?>
</div>
</div>
</td>
</tr>
<tr>




<td class="key">
<label for="note">
Published:
</label>
</td>
<td >
<input type="radio" name="published" id="published0" value="0"  <?php cheched($row->published,'0')  ?> class="inputbox">
	<label for="published0">No</label>
	<input type="radio" name="published" id="published1" value="1"  <?php cheched($row->published,'1')  ?> class="inputbox">
	<label for="published1">Yes</label>
</td>
</tr>                
</table>   
</fieldset>     
</div>

</td>

<td style="padding-left:25px; vertical-align:top !important; width:45%">
<div style="width:100%">
<fieldset class="adminform">
<legend>
Repeat Event
</legend>
<table>
<tr>

<td valign="top" >
 <input type="radio" value="no_repeat"  name="repeat_method" <?php if ($row->repeat_method == 'no_repeat') echo 'checked="checked"' ?> checked="checked" onchange="change_type('no_repeat')"  />Don't repeat this event<br/>
 <input type="radio" value="daily" name="repeat_method" <?php if ($row->repeat_method == 'daily') echo 'checked="checked"' ?>  onchange="change_type('daily')"    />Repeat daily<br/>
 <input type="radio" value="weekly" name="repeat_method" <?php if ($row->repeat_method == 'weekly') echo 'checked="checked"' ?> onchange="change_type('weekly')" />Repeat weekly<br/>
 <input type="radio" value="monthly" name="repeat_method" <?php if ($row->repeat_method == 'monthly') echo 'checked="checked"'?> onchange="change_type('monthly')"  />Repeat monthly<br/>
 <input type="radio" value="yearly" name="repeat_method" <?php if ($row->repeat_method == 'yearly') echo 'checked="checked"' ?> onchange="change_type('yearly')"   />Repeat yearly<br/>
</td>
   
<td style="padding-left:10px" valign="top">
<div id="daily" style="display:<?php if ($row->repeat_method=='no_repeat') echo 'none';  ?>">

Repeat every <input type="text"  id="repeat_input" size="5" name="repeat" onkeypress="return checknumber(repeat_input)" value="<?php echo $row->repeat ?>"  /> 
<label id="repeat"><?php if($row->repeat_method=='daily') echo 'Day(s)';  
if($row->repeat_method=='weekly') echo 'Week(s) on :';
if($row->repeat_method=='monthly') echo 'Month(s)';
if($row->repeat_method=='yearly') echo 'Year(s) in';
?></label> <label id="year_month" style="display:<?php if($row->repeat_method!='yearly') echo 'none'; ?>">


<select name="year_month" id="year_month" class="inputbox">
<option  value="1" <?php echo selectted($row->year_month,'1'); ?>>January</option>
<option value="2" <?php echo selectted($row->year_month,'2'); ?>>February</option>
<option value="3" <?php echo selectted($row->year_month,'3'); ?>>March</option>
<option value="4" <?php echo selectted($row->year_month,'4'); ?>>April</option>
<option value="5" <?php echo selectted($row->year_month,'5'); ?>>May</option>
<option value="6" <?php echo selectted($row->year_month,'6'); ?>>June</option>
<option value="7" <?php echo selectted($row->year_month,'7'); ?>>July</option>
<option value="8" <?php echo selectted($row->year_month,'8'); ?>>August</option>
<option value="9" <?php echo selectted($row->year_month,'9'); ?>>September</option>
<option value="10" <?php echo selectted($row->year_month,'10'); ?>>October</option>
<option value="11" <?php echo selectted($row->year_month,'11'); ?>>November</option>
<option value="12" <?php echo selectted($row->year_month,'12'); ?>>December</option>
</select></label>
<input  type="hidden" value="<?php if($row->repeat_method=='daily') echo $row->repeat ?>"    id="daily1" />
<input type="hidden" value="<?php if($row->repeat_method=='weekly') echo $row->repeat ?>"  id="weekly1" />
<input type="hidden"  value="<?php if($row->repeat_method=='monthly') echo $row->repeat ?>"  id="monthly1" />
<input type="hidden" value="<?php if($row->repeat_method=='yearly') echo $row->repeat ?>"   id="yearly1" />

</div><br />
  



<div class="key"  id="weekly" style="display:<?php if ($row->repeat_method!='weekly') echo 'none';  ?>">



 <input type="checkbox" value="Mon"  id="week_1" onchange="week_value()" <?php if (in_array('Mon',explode(',',$row->week))) echo 'checked="checked"' ?>   />Mon
 <input  type="checkbox" value="Tue" id="week_2"  onchange="week_value()" <?php if (in_array('Tue',explode(',',$row->week))) echo 'checked="checked"' ?>   />Tue
 <input type="checkbox" value="Wed" id="week_3" onchange="week_value()" <?php if (in_array('Wed',explode(',',$row->week))) echo 'checked="checked"' ?> />Wed
 <input type="checkbox" value="Thu" id="week_4" onchange="week_value()" <?php if (in_array('Thu',explode(',',$row->week))) echo 'checked="checked"' ?>  />Thu
 <input type="checkbox" value="Fri" id="week_5"  onchange="week_value()"  <?php if (in_array('Fri',explode(',',$row->week))) echo 'checked="checked"' ?> />Fri
 <input type="checkbox" value="Sat" id="week_6"  onchange="week_value()" <?php if (in_array('Sat',explode(',',$row->week))) echo 'checked="checked"' ?>  />Sat
 <input type="checkbox" value="Sun" id="week_7"  onchange="week_value()"  <?php if (in_array('Sun',explode(',',$row->week))) echo 'checked="checked"' ?> />Sun

<input type="hidden" name="week" id="week" value="<?php echo $row->week ?>" />



</div><br />



<div class="key" id="monthly" style="display:<?php if ($row->repeat_method!='monthly' && $row->repeat_method!='yearly') echo 'none';  ?>">
<input type="radio" id="radio1" name="month_type" onchange="radio_month()" value="1" checked="checked" <?php if ($row->month_type == 1) echo 'checked="checked"' ?>  />on the: <input type="text" name="month" size="3" onkeypress="return checknumber(month)"  id="month" value="<?php echo $row->month ?>" /><br/>
<input type="radio" id="radio2" name="month_type" onchange="radio_month()" value="2" <?php if ($row->month_type == 2) echo 'checked="checked"' ?> />on the: 
 <select name="monthly_list" id="monthly_list" class="inputbox">
<option <?php echo selectted($row->monthly_list,'1'); ?> value="1">First</option>
<option <?php echo selectted($row->monthly_list,'8'); ?> value="8">Second</option>
<option <?php echo selectted($row->monthly_list,'15'); ?> value="15">Third</option>
<option <?php echo selectted($row->monthly_list,'22'); ?> value="22">Fourth</option>
<option <?php echo selectted($row->monthly_list,'last'); ?> value="last">Last</option>
</select>

<select name="month_week" id="month_week" class="inputbox">
<option <?php echo selectted($row->month_week,'Mon'); ?> value="Mon">Monday</option>
<option <?php echo selectted($row->month_week,'Tue'); ?> value="Tue">Tuesday</option>
<option <?php echo selectted($row->month_week,'Wed'); ?> value="Wed">Wednesday</option>
<option <?php echo selectted($row->month_week,'Thu'); ?> value="Thu">Thursday</option>
<option <?php echo selectted($row->month_week,'Fri'); ?> value="Fri">Friday</option>
<option <?php echo selectted($row->month_week,'Sat'); ?> value="Sat">Saturday</option>
<option <?php echo selectted($row->month_week,'Sun'); ?> value="Sun">Sunday</option>
</select>



</div>  <br />
<script>
window.onload=radio_month();


</script>


</td>
</tr>

<tr id="repeat_until" style="display:<?php if($row->repeat_method=='no_repeat') echo 'none'; ?>">
<td>
Repeat until: </td>
<td>
<input style="width:90px" class="inputbox" type="text" name="date_end" id="date_end" size="10" maxlength="10" value="<?php echo $row->date_end; ?>" /> 

<input type="reset" class="button" value="..."

onclick="return showCalendar('date_end','%Y-%m-%d');" />
</td>
</tr>
</table>

</fieldset>
</div>
</td></tr></table>









<input type="hidden" name="option" value="com_spidercalendar" />
<input type="hidden" name="id" value="<?php echo $row->id?>" />        
<input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />        
<input type="hidden" name="task" value="event" />   
<input type="hidden" name="calendar" value="<?php echo $lists['calendar']; ?>" />  

</form>
        <?php		
}