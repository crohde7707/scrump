<?php

/*
Plugin Name: Spider Event Calendar
Plugin URI: http://web-dorado.com/products/wordpress-calendar.html
Version: 1.3.0
Author: http://web-dorado.com/
License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

/*LANGUAGE localization */
//// load languages
add_action( 'init', 'sp_calendar_language_load' );

function sp_calendar_language_load() {
	 load_plugin_textdomain('sp_calendar', false, basename( dirname( __FILE__ ) ) . '/languages' );
}


/////////////// include widget


require_once("widget_spider_calendar.php");



function current_page_url_sc() {
	if(is_home())
	$pageURL = site_url();
	else
	$pageURL = get_permalink();
	return $pageURL;
}
add_action('wp_head','resolv_js_prob');
function resolv_js_prob() {
?>
<script>
var xx_cal_xx='&';
</script>
<?php
}




function spider_calendar_scripts() {
	wp_enqueue_script("jquery");
	wp_enqueue_script('thickbox',null,array('jquery'));
    wp_enqueue_style('thickbox.css', '/'.WPINC.'/js/thickbox/thickbox.css', null, '1.0');
	wp_enqueue_style( 'thickbox' );
			     
}    
 
add_action('wp_enqueue_scripts', 'spider_calendar_scripts');

$many_sp_calendar=1;


function Spider_calendar_big($atts) {
     extract(shortcode_atts(array(
	      'id' => 'no Spider catalog',
		  'theme' => '1',
     ), $atts));
     return Spider_calendar_big_front_end($id,$theme);
}
add_shortcode('Spider_Calendar', 'Spider_calendar_big');

add_action('wp_head','resolv_js_prob');


function Spider_calendar_big_front_end($id,$theme,$wiidget=0)
{
ob_start();
global $many_sp_calendar;
	?>
	<div id='bigcalendar<?php echo $many_sp_calendar ?>'></div>

<script>
var tb_pathToImage = "<?php echo plugins_url('images/loadingAnimation.gif',__FILE__) ?>";
var tb_closeImage = "<?php echo plugins_url('images/tb-close.png',__FILE__) ?>"
if(typeof showbigcalendar != 'function')
 {
function showbigcalendar(id,calendarlink)
{
var xmlHttp;
	try{	
		xmlHttp=new XMLHttpRequest();// Firefox, Opera 8.0+, Safari
	}
	catch (e){
		try{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP"); // Internet Explorer
		}
		catch (e){
		    try{
				xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e){
				alert("No AJAX!?");
				return false;
			}
		}
	}
xmlHttp.onreadystatechange=function(){
	if(xmlHttp.readyState==4){
		document.getElementById(id).innerHTML=xmlHttp.responseText;
	}
}
xmlHttp.open("GET",calendarlink,false);
xmlHttp.send();
//alert(document.getElementById('days').parentNode.lastChild.childNodes[6].innerHTML);
//document.getElementById('days').parentNode.lastChild.childNodes[6].style.borderBottomRightRadius='<?php echo $border_radius ?>px';
//document.getElementById('days').parentNode.lastChild.childNodes[0].style.borderBottomLeftRadius='<?php echo $border_radius ?>px';		
	var thickDims, tbWidth, tbHeight;
jQuery(document).ready(function($) {
        thickDims = function() {
                var tbWindow = $('#TB_window'), H = $(window).height(), W = $(window).width(), w, h;
				if(tbWidth){if(tbWidth < (W - 90)) w=tbWidth; else  w =  W - 200;} else w = W - 200;
				if(tbHeight){if(tbHeight < (H - 90)) h=tbHeight; else  h =  H - 200;} else h = H - 200;  
                if ( tbWindow.size() ) {
                        tbWindow.width(w).height(h);
                        $('#TB_iframeContent').width(w).height(h - 27);
                        tbWindow.css({'margin-left': '-' + parseInt((w / 2),10) + 'px'});
                        if ( typeof document.body.style.maxWidth != 'undefined' )
                                tbWindow.css({'top':(H-h)/2,'margin-top':'0'});
                }
        };
        thickDims();		
        $(window).resize( function() { thickDims() } );
        $('a.thickbox-preview'+id).click( function() {
                tb_click.call(this);
                var alink = $(this).parents('.available-theme').find('.activatelink'), link = '', href = $(this).attr('href'), url, text;
                var reg_with=new RegExp(xx_cal_xx+"tbWidth=[0-9]+");
				if ( tbWidth = href.match(reg_with) )
                        tbWidth = parseInt(tbWidth[0].replace(/[^0-9]+/g, ''), 10);
                else
                        tbWidth = $(window).width() - 90;
				var reg_heght=new RegExp(xx_cal_xx+"tbHeight=[0-9]+");
                if ( tbHeight = href.match(reg_heght) )
                        tbHeight = parseInt(tbHeight[0].replace(/[^0-9]+/g, ''), 10);
                else
                        tbHeight = $(window).height() - 60;
                if ( alink.length ) {
                        url = alink.attr('href') || '';
                        text = alink.attr('title') || '';
                        link = '&nbsp; <a href="' + url + '" target="_top" class="tb-theme-preview-link">' + text + '</a>';
                } else {
                        text = $(this).attr('title') || '';
                        link = '&nbsp; <span class="tb-theme-preview-link">' + text + '</span>';
                }
                $('#TB_title').css({'background-color':'#222','color':'#dfdfdf'});
                $('#TB_closeAjaxWindow').css({'float':'left'});
                $('#TB_ajaxWindowTitle').css({'float':'right'}).html(link);
                $('#TB_iframeContent').width('100%');
                thickDims();
                return false;
        } );
});  
}
 }
 document.onkeydown = function(evt) {
    evt = evt || window.event;
    if (evt.keyCode == 27) {     
		document.getElementById('sbox-window').close();		
    }
}; 
<?php
global $wpdb;
$calendarr=$wpdb->get_row($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."spidercalendar_calendar WHERE id=%d",$id));
if($calendarr->start_month){
	$date=substr($calendarr->start_month, 0, 7);
}
else
{
	$date=date("Y").'-'.date("m");
}

?>
//SqueezeBox.presets.onClose=function (){document.getElementById('sbox-content').innerHTML="";};
showbigcalendar( 'bigcalendar<?php echo $many_sp_calendar ?>','<?php  echo admin_url('admin-ajax.php?action=spiderbigcalendar').'&theme_id='.$theme.'\'+xx_cal_xx+\'calendar='.$id.'\'+xx_cal_xx+\'date='.$date.'\'+xx_cal_xx+\'many_sp_calendar='.$many_sp_calendar; echo '\'+xx_cal_xx+\'cur_page_url='.urlencode(current_page_url_sc()); if($wiidget) echo '\'+xx_cal_xx+\'widget='.$wiidget;?>')
//window.onload=document.getElementById('show_cal_frst').click();
</script>
<?php
        $many_sp_calendar++;
		$calendar=ob_get_contents();
		ob_end_clean();

		return $calendar;
}





//////////////////////////////////////////////     quick edit


add_action('wp_ajax_spidercalendarinlineedit', 'spider_calendar_quick_edit');

add_action('wp_ajax_spidercalendarinlineupdate', 'spider_calendar_quick_update');
function spider_calendar_quick_update(){
	
	global $wpdb;
	
	if(isset($_POST['calendar_id']) && isset($_POST['calendar_title']) && isset($_POST['us_12_format_sp_calendar'])){
		$wpdb->update( 
			$wpdb->prefix.'spidercalendar_calendar', 
			array( 
				'title' => $_POST['calendar_title'],	
				'time_format' => $_POST['us_12_format_sp_calendar']
			), 
			array( 'id' => $_POST['calendar_id'] ), 
			array( 
				'%s',
				'%d'	
			), 
			array( '%d' ) 
		);
		$row=$wpdb->get_row("SELECT * FROM ".$wpdb->prefix."spidercalendar_calendar WHERE id=".$_POST['calendar_id']);
		?>
		 <td><?php echo $row->id; ?></td>
         <td class="post-title page-title column-title">
         	<a title="Manage Events" class="row-title" href="admin.php?page=SpiderCalendar&task=show_manage_event&calendar_id=<?php echo $row->id; ?>"><?php echo $row->title; ?></a>
            <div class="row-actions">
                <span class="edit"><a href="admin.php?page=SpiderCalendar&task=edit_calendar&id=<?php echo $row->id; ?>" title="Edit This Calendar">Edit</a> | </span>
                <span class="inline hide-if-no-js"><a href="#" class="editinline" onclick="show_calendar_inline(<?php echo  $row->id; ?>)" title="Edit This Calendar Inline">Quick&nbsp;Edit</a>  | </span>
                <span class="trash"><a class="submitdelete" title="Delete This Calendar" href="javascript:confirmation('admin.php?page=SpiderCalendar&task=remove_calendar&id=<?php echo $row->id; ?>','<?php echo $row->title; ?>')">Delete</a></span>
            </div>
         </td>
         <td><a href="admin.php?page=SpiderCalendar&task=show_manage_event&calendar_id=<?php echo $row->id; ?>">Manage events</a></td>
         <td><a <?php if(!$row->published) echo 'style="color:#C00"'; ?> href="admin.php?page=SpiderCalendar&task=published&id=<?php echo $row->id; ?>"><?php if($row->published) echo "Yes"; else echo "No"; ?></a></td>
		<?php
		die();
		
		
		
		
		
		
		}
	else
	{
		die();
	}
	
	
	
}
function spider_calendar_quick_edit(){
	global $wpdb;
	if(isset($_POST['calendar_id'])){
		$row=$wpdb->get_row("SELECT * FROM ".$wpdb->prefix."spidercalendar_calendar WHERE id=".$_POST['calendar_id']);
		
		
		
		?>
        
        
        
        <td colspan="4" class="colspanchange">
        
        
        <fieldset class="inline-edit-col-left">
        <div style="float:left; width:100% " class="inline-edit-col">
			<h4>Quick Edit</h4>
	
			<label >
				<span style="width:160px !important"  class="title">Title</span>
				<span class="input-text-wrap"><input type="text" style="width:150px !important" id="calendar_title" name="calendar_title" value="<?php echo $row->title ?>" class="ptitle" /></span>
			</label>
         
            <span class="title alignleft" style="width:160px !important">Use 12 hours time format: </span>
					
					
					
											
	<input style="margin-top:5px" type="radio" class="alignleft" name="time_format" id="time_format0" value="0" <?php if($row->time_format==0) echo 'checked="checked"'; ?> />
	<em style="margin:4px 5px 0 0" class="alignleft">
					No				</em>
	<input style="margin-top:5px" class="alignleft" type="radio" name="time_format" id="time_format1" value="1" <?php if($row->time_format==1) echo 'checked="checked"'; ?> />
	<em style="margin:4px 5px 0 0" class="alignleft">
					Yes				</em>			
							
				
                    
			</div>
           
	
		</div></fieldset>
	<p class="submit inline-edit-save">
			<a accesskey="c" href="#" title="Cancel" onclick="cancel_qiucik_edit(<?php echo $row->id ?>)" class="button-secondary cancel alignleft">Cancel</a>
			<input type="hidden" id="_inline_edit" name="_inline_edit" value="d8393e8662">
            <a accesskey="s" href="#" title="Update" onclick="updae_inline_sp_calendar(<?php echo  "'".$row->id."'" ?>)" class="button-primary save alignright">Update</a>
				<img id="imig_for_waiting" class="waiting" style="display:none;" src="http://localhost/wordpress/wp-admin/images/wpspin_light.gif" alt="">
						<input type="hidden" name="post_view" value="list">
			<input type="hidden" name="screen" value="edit-page">
			<span class="error" style="display:none"></span>
			<br class="clear">
		</p>
		</td>
        <?php
		
		die();
	}
	else
	{
		die();
	}
	
}



















//// add editor new mce button
add_filter('mce_external_plugins', "sp_calendar_register");
add_filter('mce_buttons', 'sp_calendar_add_button', 0);

/// function for add new button
function sp_calendar_add_button($buttons)
{
    array_push($buttons, "sp_calendar_mce");
    return $buttons;
}
 /// function for registr new button
function sp_calendar_register($plugin_array)
{
    $url = plugins_url( 'js/editor_plugin.js' , __FILE__ ); 
    $plugin_array["sp_calendar_mce"] = $url;
    return $plugin_array;
}





// function create in menu
function sp_calendar_options_panel(){
  add_menu_page('Theme page title', 'Calendar', 'manage_options', 'SpiderCalendar', 'Manage_Spider_Calendar',plugins_url("images/calendar_menu.png",__FILE__));
 $page_calendar= add_submenu_page( 'SpiderCalendar', 'Calendars', 'Calendars', 'manage_options', 'SpiderCalendar', 'Manage_Spider_Calendar');
  $page_theme=add_submenu_page( 'SpiderCalendar', 'Calendar Parameters', 'Calendar Themes', 'manage_options', 'spider_claendat_themes', 'spider_calendar_params');
    $page_widget_theme=add_submenu_page( 'SpiderCalendar', 'Calendar Parameters', 'Widget Themes', 'manage_options', 'spider_widget_claendat_themes', 'spider_widget_calendar_params');
	//add_submenu_page( 'SpiderCalendar', 'Widget Themes', 'Widget Themes', 'manage_options', 'spider_claendat_widget_themes', 'spider_claendat_widget_themes');
   add_submenu_page( 'SpiderCalendar', 'Licensing', 'Licensing', 'manage_options', 'Spider_calendar_Licensing', 'Spider_calendar_Licensing');

  add_submenu_page( 'SpiderCalendar', 'Uninstall  Spider Event Calendar', 'Uninstall  Spider Event Calendar', 'manage_options', 'Uninstall_sp_calendar', 'Uninstall_sp_calendar'); // uninstall Calendar
  
  
  
   add_action('admin_print_styles-' . $page_theme, 'spider_calendar_themes_admin_styles_scripts');
   add_action('admin_print_styles-' . $page_calendar, 'spider_calendar_admin_styles_scripts');
   add_action('admin_print_styles-' . $page_widget_theme, 'spider_widget_calendar_themes_admin_styles_scripts');
 
}



function Spider_calendar_Licensing(){
	?>
    
   <div style="width:95%"> <p>
This plugin is the non-commercial version of the Spider Event Calendar. Use of the calendar is free.<br /> The only
limitation is the use of the themes. If you want to use one of the 11 standard themes or create a new one that
satisfies the needs of your web site, you are required to purchase a license.<br /> Purchasing a license will add 11
standard themes and give possibility to edit the themes of the Spider Event Calendar. </p>
<br /><br />
<a href="http://web-dorado.com/files/fromSpiderCalendarWP.php" class="button-primary" target="_blank">Purchase a License</a>
<br /><br /><br />
<p>After the purchasing the commercial version follow this steps:</p>
<ol>
	<li>Deactivate Spider Event Calendar Plugin</li>
	<li>Delete Spider Event Calendar Plugin</li>
	<li>Install the downloaded commercial version of the plugin</li>
</ol>
</div>

    
    
    <?php
	
	
	}
function spider_calendar_themes_admin_styles_scripts(){
	
	
	wp_enqueue_script("jquery");	
	wp_enqueue_script("standart_themes",plugins_url('elements/theme_reset.js', __FILE__));
	wp_enqueue_script("colcor_js",plugins_url('jscolor/jscolor.js', __FILE__));
	if(isset($_GET['task']))
	{
		if($_GET['task']=='edit_theme' || $_GET['task']=='add_theme' || $_GET['task']=='Apply')
	wp_enqueue_style( "parsetheme_css", plugins_url('style_for_cal/style_for_tables_cal.css', __FILE__));
	}
	}

		
		
		
function spider_widget_calendar_themes_admin_styles_scripts(){
	

	wp_enqueue_script("jquery");
	wp_enqueue_script("standart_themes",plugins_url('elements/theme_reset_widget.js', __FILE__));
	wp_enqueue_script("colcor_js",plugins_url('jscolor/jscolor.js', __FILE__));
	if(isset($_GET['task']))
	{
		if($_GET['task']=='edit_theme' || $_GET['task']=='add_theme' || $_GET['task']=='Apply')
	wp_enqueue_style( "parsetheme_css", plugins_url('style_for_cal/style_for_tables_cal.css', __FILE__));
	}
	}

			
function spider_calendar_admin_styles_scripts()
{
				
	
				wp_enqueue_script("Calendar",plugins_url("elements/calendar.js",__FILE__),false);
 			  	wp_enqueue_script("calendar-setup",plugins_url("elements/calendar-setup.js",__FILE__),false);
				wp_enqueue_script("calendar_function",plugins_url("elements/calendar_function.js",__FILE__),false);
				wp_enqueue_style("Css",plugins_url("elements/calendar-jos.css",__FILE__),false); 
}


add_filter('admin_head','spide_ShowTinyMCE');

function spide_ShowTinyMCE() {

	// conditions here

	wp_enqueue_script( 'common' );

	wp_enqueue_script( 'jquery-color' );

	wp_print_scripts('editor');

	if (function_exists('add_thickbox')) add_thickbox();

	wp_print_scripts('media-upload');

	if (function_exists('wp_tiny_mce')) wp_tiny_mce();

	wp_admin_css();

	wp_enqueue_script('utils');

	do_action("admin_print_styles-post-php");

	do_action('admin_print_styles');

}








// add menu
add_action('admin_menu', 'sp_calendar_options_panel');


require_once("functions_for_xml_and_ajax.php");


//////////////////////////////////////////////////////////////////////////actions for popup and xmls
add_action('wp_ajax_spiderseemore'		, 'seemore');
add_action('wp_ajax_spiderbigcalendar'		, 'big_calendarr');
add_action('wp_ajax_spiderbigcalendarrr'		, 'spiderbigcalendar');
add_action('wp_ajax_window'		, 'php_window');


////////////////////////////ajax for users
add_action('wp_ajax_nopriv_spiderseemore'		, 'seemore');
add_action('wp_ajax_nopriv_spiderbigcalendar'		, 'big_calendarr');
add_action('wp_ajax_nopriv_spiderbigcalendarrr'		, 'spiderbigcalendar');
add_action('wp_ajax_nopriv_window'		, 'php_window');

// add style head
function add_button_style_calendar()
{
echo '<style type="text/css">
.wp_themeSkin span.mce_sp_calendar_mce {background:url('.plugins_url( 'images/calendar.png' , __FILE__ ).') no-repeat !important;}
.wp_themeSkin .mceButtonEnabled:hover span.mce_sp_calendar_mce,.wp_themeSkin .mceButtonActive span.mce_sp_calendar_mce
{background:url('.plugins_url( 'images/calendar_hover.png' , __FILE__ ).') no-repeat !important;}
</style>';
}

add_action('admin_head', 'add_button_style_calendar');

////end////






function Manage_Spider_Calendar(){
	global $wpdb;
	
	 // wp_enqueue_script('media-upload');
	  //wp_admin_css('thickbox')
	  if(!function_exists('print_html_nav'))
	  require_once("nav_function/nav_html_func.php");
	require_once("calendar_functions.php");// add functions for Spider_Video_Player
	require_once("calendar_functions.html.php");// add functions for vive Spider_Video_Player
 /*
	?>
   <form action="" method="post">
    <input type="text" value="asdgadsfg" id="narek" />
    <input type="button" onclick="alert(document.getElementById('narek').value);"  />
	<a href="<?php echo plugins_url("calendar_function.html.php",__FILE__) ?>?TB_iframe=1&amp;width=640&amp;height=394" class="thickbox add_media" id="content-add_media" title="Add Video" onclick="return false;">Insert Video</a>
	</form>
	<?php
	 */
	if(isset($_GET["task"])){
	$task=$_GET["task"];
	}
	else
	{
		$task="default";
	}
	if(isset($_GET["id"]))
	{
		$id=$_GET["id"];
	}
	else
	{
		$id=0;
	}
	if(isset($_GET["calendar_id"]))
	{
		$calendar_id=$_GET["calendar_id"];
	}
	else
	{
		$calendar_id=0;
	}
	switch($task){
			
	case 'calendar':
		show_spider_calendar();
		break;
		
	case 'add_calendar':
		add_spider_calendar();
		break;
		
	case 'published';		
		spider_calendar_published($id);
		show_spider_calendar();
		break;

	case 'Save':
	if(!$id)
	{		
	
		save_spider_calendar();
	}
	else
	{
		apply_spider_calendar($id);
	}
		show_spider_calendar();
		break;
		case 'Apply':
		if(!$id)
		{
			save_spider_calendar();
			$id=$wpdb->get_var("SELECT MAX(id) FROM ".$wpdb->prefix."spidercalendar_calendar");
		}
		else
		{
			apply_spider_calendar($id);
		}
		edit_spider_calendar($id);

		break;
		
	case 'edit_calendar':
    		edit_spider_calendar($id);
    		break;	
		
	case 'remove_calendar':
		remove_spider_calendar($id);
		show_spider_calendar();
		break;
		
			////////////////////////////
			////////////////////////////    EVENTS
			////////////////////////////
			
			
			
			
		case 'show_manage_event':
	   	show_spider_event($calendar_id);
	    	break;	
			case 'add_event':
	   	add_spider_event($calendar_id);
	    	break;	
			case 'save_event':
			if($id){	
			apply_spider_event($calendar_id,$id);	   	
			}
			else
			{
				save_spider_event($calendar_id);
			}
		show_spider_event($calendar_id);
	    	break;
			case 'apply_event':
			if($id){
	   	apply_spider_event($calendar_id,$id);
			}
			else{
				save_spider_event($calendar_id);
				$id=$wpdb->get_var("SELECT MAX(id) FROM ".$wpdb->prefix."spidercalendar_event");
			}
				edit_spider_event($calendar_id,$id);
	    	break;	
			case 'edit_event':
	  		 	edit_spider_event($calendar_id,$id);
	    	break;
			case 'remove_event':
	  		 	remov_spider_event($calendar_id,$id);
				show_spider_event($calendar_id);
	    	break;
			
		case 'published_event';		
		published_spider_event($id);
		show_spider_event($calendar_id);
		break;

			

	default:
	show_spider_calendar();
	break;
				
	}
	

}

function spider_widget_calendar_params()
{
		 wp_enqueue_script('media-upload');
	  	wp_admin_css('thickbox');
	 if(!function_exists('print_html_nav'))
	require_once("nav_function/nav_html_func.php");
	require_once("widget_Theme_functions.php");
	
	global $wpdb;
	if(isset($_GET["task"]))
	{
		$task=$_GET["task"];
	}
	else
	{
		$task="";
	}
	if(isset($_GET["id"]))
	{
		$id=$_GET["id"];
	}
	else
	{
		$id=0;
	}
	switch($task){
	case 'theme':
		show_theme_calendar_widget();
		break;
	case 'add_theme':
		add_theme_calendar_widget();
		break;
		
	case 'Save':
	if($id)
	{
		apply_theme_calendar_widget($id);
	}
	else
	{
		save_theme_calendar_widget();
		
	}
	
	show_theme_calendar_widget();	
		break;
		
		case 'Apply':	
		if($id)	
		{
			
			apply_theme_calendar_widget($id);
		}
		else
		{
			
			save_theme_calendar_widget();
			$id=$wpdb->get_var("SELECT MAX(id) FROM ".$wpdb->prefix."spidercalendar_widget_theme");
		}
		
		edit_theme_calendar_widget($id);
		break;
		
	case 'edit_theme':
    		edit_theme_calendar_widget($id);
    		break;	
		
	case 'remove_theme_calendar':
		remove_theme_calendar_widget($id);
		show_theme_calendar_widget();
		break;
		default:
		show_theme_calendar_widget();
	}

}



/*Calendar themes */
function spider_calendar_params(){
	 wp_enqueue_script('media-upload');
	  wp_admin_css('thickbox');
	    if(!function_exists('print_html_nav'))
	  require_once("nav_function/nav_html_func.php");
	require_once("Theme_functions.php");// add functions for Spider_Video_Player
	
	
	global $wpdb;
	if(isset($_GET["task"]))
	{
		$task=$_GET["task"];
	}
	else
	{
		$task="";
	}
	if(isset($_GET["id"]))
	{
		$id=$_GET["id"];
	}
	else
	{
		$id=0;
	}
	switch($task){
	case 'theme':
		show_theme_calendar();
		break;
	case 'add_theme':
		add_theme_calendar();
		break;
		
	case 'Save':
	if($id)
	{
		apply_theme_calendar($id);
	}
	else
	{
		save_theme_calendar();
		
	}
	
	show_theme_calendar();	
		break;
		
		case 'Apply':	
		if($id)	
		{
			
			apply_theme_calendar($id);
		}
		else
		{
			
			save_theme_calendar();
			$id=$wpdb->get_var("SELECT MAX(id) FROM ".$wpdb->prefix."spidercalendar_theme");
		}
		
		edit_theme_calendar($id);
		break;
		
	case 'edit_theme':
    		edit_theme_calendar($id);
    		break;	
		
	case 'remove_theme_calendar':
		remove_theme_calendar($id);
		show_theme_calendar();
		break;
		default:
		show_theme_calendar();
	}

}

function spider_claendat_widget_themes()
{
}


function Uninstall_sp_calendar(){


	global $wpdb;
	
$base_name = plugin_basename('Spider_Calendar');
$base_page = 'admin.php?page='.$base_name;
$mode = trim($_GET['mode']);


if(!empty($_POST['do'])) {

	if($_POST['do']=="Uninstall Spider Event Calendar") {
			check_admin_referer('Spider_Calendar uninstall');
			if(trim($_POST['Spider_Calendar_yes']) == 'yes') {
				
				echo '<div id="message" class="updated fade">';
				echo '<p>';
				echo "Table '".$wpdb->prefix."spidercalendar_event' has been deleted.";
				$wpdb->query("DROP TABLE ".$wpdb->prefix."spidercalendar_event");
				echo '<font style="color:#000;">';
				echo '</font><br />';
				echo '</p>';
				echo '<p>';
				echo "Table '".$wpdb->prefix."spidercalendar_calendar' has been deleted.";
				$wpdb->query("DROP TABLE ".$wpdb->prefix."spidercalendar_calendar");
				echo '<font style="color:#000;">';
				echo '</font><br />';
				echo '</p>';
				echo '<p>';
				echo "Table '".$wpdb->prefix."spidercalendar_theme' has been deleted.";
				$wpdb->query("DROP TABLE ".$wpdb->prefix."spidercalendar_theme");
				echo '<font style="color:#000;">';
				echo '</font><br />';
				echo '</p>';
				echo '<p>';
				echo "Table '".$wpdb->prefix."spidercalendar_widget_theme' has been deleted.";
				$wpdb->query("DROP TABLE ".$wpdb->prefix."spidercalendar_widget_theme");
				echo '<font style="color:#000;">';
				echo '</font><br />';
				echo '</p>';
				echo '</div>'; 
				
				$mode = 'end-UNINSTALL';
			}
		}
}



switch($mode) {

		case 'end-UNINSTALL':
			$deactivate_url = wp_nonce_url('plugins.php?action=deactivate&amp;plugin='.plugin_basename(__FILE__), 'deactivate-plugin_'.plugin_basename(__FILE__));
			echo '<div class="wrap">';
			echo '<h2>Uninstall Spider Event Calendar</h2>';
			echo '<p><strong>'.sprintf('<a href="%s">Click Here</a> To Finish The Uninstallation And Spider Event Calendar Will Be Deactivated Automatically.', $deactivate_url).'</strong></p>';
			echo '</div>';
			break;
	// Main Page
	default:
?>
<form method="post" action="<?php echo admin_url('admin.php?page=Uninstall_sp_calendar'); ?>">
<?php wp_nonce_field('Spider_Calendar uninstall'); ?>
<div class="wrap">
	<div id="icon-Spider_Calendar" class="icon32"><br /></div>
	<h2><?php echo 'Uninstall Spider Event Calendar'; ?></h2>
	<p>
		<?php echo 'Deactivating Spider Event Calendar plugin does not remove any data that may have been created. To completely remove this plugin, you can uninstall it here.'; ?>
	</p>
	<p style="color: red">
		<strong><?php echo'WARNING:'; ?></strong><br />
		<?php echo 'Once uninstalled, this cannot be undone. You should use a Database Backup plugin of WordPress to back up all the data first.'; ?>
	</p>
	<p style="color: red">
		<strong><?php echo 'The following WordPress Options/Tables will be DELETED:'; ?></strong><br />
	</p>
	<table class="widefat">
		<thead>
			<tr>
				<th><?php echo 'WordPress Tables'; ?></th>
			</tr>
		</thead>
		<tr>
			<td valign="top">
				<ol>
				<?php
						echo '<li>'.$wpdb->prefix.'spidercalendar_event</li>'."\n";
						echo '<li>'.$wpdb->prefix.'spidercalendar_calendar</li>'."\n";
						echo '<li>'.$wpdb->prefix.'spidercalendar_theme</li>'."\n";
                        echo '<li>'.$wpdb->prefix.'spidercalendar_widget_theme</li>'."\n";
				?>
				</ol>
			</td>
		</tr>
	</table>
	<p style="text-align: center;">
		<?php echo 'Do you really want to Uninstall Spider Event Calendar?'; ?><br /><br />
		<input type="checkbox" name="Spider_Calendar_yes" value="yes" />&nbsp;<?php echo 'Yes'; ?><br /><br />
		<input type="submit" name="do" value="<?php echo 'Uninstall Spider Event Calendar'; ?>" class="button-primary" onclick="return confirm('<?php echo 'You Are About To Uninstall Spider Event Calendar From WordPress.\nThis Action Is Not Reversible.\n\n Choose [Cancel] To Stop, [OK] To Uninstall.'; ?>')" />
	</p>
</div>
</form>
<?php
} // End switch($mode)


	
	
	
	
}




///// when activated plugin
function SpiderCalendar_activate()
{
	global $wpdb;
	$spider_event_table="CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."spidercalendar_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `calendar` int(11) NOT NULL,
  `date` date NOT NULL,
  `date_end` date NOT NULL,
  `title` text NOT NULL,
  `time` varchar(20) NOT NULL,
  `text_for_date` longtext NOT NULL,
  `userID` varchar(255) NOT NULL,
  `repeat_method` varchar(255) NOT NULL,
  `repeat` varchar(255) NOT NULL,
  `week` varchar(255) NOT NULL,
  `month` varchar(255) NOT NULL,
  `month_type` varchar(255) NOT NULL,
  `monthly_list` varchar(255) NOT NULL,
  `month_week` varchar(255) NOT NULL,
  `year_month` varchar(255) NOT NULL,
  `published` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";



$spider_calendar_table="CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."spidercalendar_calendar` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `gid` varchar(255) NOT NULL,
  `time_format` tinyint(1) NOT NULL,
  `allow_publish` varchar(255) NOT NULL,
  `start_month` varchar(255) NOT NULL,
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";



$spider_theme_table="CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."spidercalendar_theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `width` varchar(255) NOT NULL,
  `cell_height` varchar(255) NOT NULL,
  `bg_top` varchar(255) NOT NULL,
  `bg_bottom` varchar(255) NOT NULL,
  `border_color` varchar(255) NOT NULL,
  `text_color_year` varchar(255) NOT NULL,
  `text_color_month` varchar(255) NOT NULL,
  `text_color_week_days` varchar(255) NOT NULL,
  `text_color_other_months` varchar(255) NOT NULL,
  `text_color_this_month_unevented` varchar(255) NOT NULL,
  `text_color_this_month_evented` varchar(255) NOT NULL,
  `event_title_color` varchar(255) NOT NULL,
  `current_day_border_color` varchar(255) NOT NULL,
  `bg_color_this_month_evented` varchar(255) NOT NULL,
  `next_prev_event_arrowcolor` varchar(255) NOT NULL,
  `show_event_bgcolor` varchar(255) NOT NULL,
  `cell_border_color` varchar(255) NOT NULL,
  `arrow_color_year` varchar(255) NOT NULL,
  `week_days_cell_height` varchar(255) NOT NULL,
  `arrow_color_month` varchar(255) NOT NULL,
  `text_color_sun_days` varchar(255) NOT NULL,
  `title_color` varchar(255) NOT NULL,
  `next_prev_event_bgcolor` varchar(255) NOT NULL,
  `title_font_size` varchar(255) NOT NULL,
  `title_font` varchar(255) NOT NULL,
  `title_style` varchar(255) NOT NULL,
  `date_color` varchar(255) NOT NULL,
  `date_size` varchar(255) NOT NULL,
  `date_font` varchar(255) NOT NULL,
  `date_style` varchar(255) NOT NULL,
  `popup_width` varchar(255) NOT NULL,
  `popup_height` varchar(255) NOT NULL,
  `number_of_shown_evetns` varchar(255) NOT NULL,
  `sundays_font_size` varchar(255) NOT NULL,
  `other_days_font_size` varchar(255) NOT NULL,
  `weekdays_font_size` varchar(255) NOT NULL,
  `border_width` varchar(255) NOT NULL,
  `top_height` varchar(255) NOT NULL,
  `bg_color_other_months` varchar(255) NOT NULL,
  `sundays_bg_color` varchar(255) NOT NULL,
  `weekdays_bg_color` varchar(255) NOT NULL,
  `week_start_day` varchar(255) NOT NULL,
  `weekday_sunday_bg_color` varchar(255) NOT NULL,
  `border_radius` varchar(255) NOT NULL,
  `year_font_size` varchar(255) NOT NULL,
  `month_font_size` varchar(255) NOT NULL,
  `arrow_size` varchar(255) NOT NULL,
  `next_month_text_color` varchar(255) NOT NULL,
  `prev_month_text_color` varchar(255) NOT NULL,
  `next_month_arrow_color` varchar(255) NOT NULL,
  `prev_month_arrow_color` varchar(255) NOT NULL,
  `next_month_font_size` varchar(255) NOT NULL,
  `prev_month_font_size` varchar(255) NOT NULL,
  `month_type` varchar(255) NOT NULL,
  `date_format` varchar(255) NOT NULL,
  `show_time` tinyint(1) NOT NULL,
  `show_repeat` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";




$spider_widhet_theme_table="CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."spidercalendar_widget_theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `width` varchar(255) NOT NULL,
  `cell_height` varchar(255) NOT NULL,
  `bg_top` varchar(255) NOT NULL,
  `bg_bottom` varchar(255) NOT NULL,
  `border_color` varchar(255) NOT NULL,
  `text_color_year` varchar(255) NOT NULL,
  `text_color_month` varchar(255) NOT NULL,
  `text_color_week_days` varchar(255) NOT NULL,
  `text_color_other_months` varchar(255) NOT NULL,
  `text_color_this_month_unevented` varchar(255) NOT NULL,
  `text_color_this_month_evented` varchar(255) NOT NULL,
  `event_title_color` varchar(255) NOT NULL,
  `current_day_border_color` varchar(255) NOT NULL,
  `bg_color_this_month_evented` varchar(255) NOT NULL,
  `next_prev_event_arrowcolor` varchar(255) NOT NULL,
  `show_event_bgcolor` varchar(255) NOT NULL,
  `cell_border_color` varchar(255) NOT NULL,
  `arrow_color_year` varchar(255) NOT NULL,
  `week_days_cell_height` varchar(255) NOT NULL,
  `arrow_color_month` varchar(255) NOT NULL,
  `text_color_sun_days` varchar(255) NOT NULL,
  `title_color` varchar(255) NOT NULL,
  `next_prev_event_bgcolor` varchar(255) NOT NULL,
  `title_font_size` varchar(255) NOT NULL,
  `title_font` varchar(255) NOT NULL,
  `title_style` varchar(255) NOT NULL,
  `date_color` varchar(255) NOT NULL,
  `date_size` varchar(255) NOT NULL,
  `date_font` varchar(255) NOT NULL,
  `date_style` varchar(255) NOT NULL,
  `popup_width` varchar(255) NOT NULL,
  `popup_height` varchar(255) NOT NULL,
  `number_of_shown_evetns` varchar(255) NOT NULL,
  `sundays_font_size` varchar(255) NOT NULL,
  `other_days_font_size` varchar(255) NOT NULL,
  `weekdays_font_size` varchar(255) NOT NULL,
  `border_width` varchar(255) NOT NULL,
  `top_height` varchar(255) NOT NULL,
  `bg_color_other_months` varchar(255) NOT NULL,
  `sundays_bg_color` varchar(255) NOT NULL,
  `weekdays_bg_color` varchar(255) NOT NULL,
  `week_start_day` varchar(255) NOT NULL,
  `weekday_sunday_bg_color` varchar(255) NOT NULL,
  `border_radius` varchar(255) NOT NULL,
  `year_font_size` varchar(255) NOT NULL,
  `month_font_size` varchar(255) NOT NULL,
  `arrow_size` varchar(255) NOT NULL,
  `next_month_text_color` varchar(255) NOT NULL,
  `prev_month_text_color` varchar(255) NOT NULL,
  `next_month_arrow_color` varchar(255) NOT NULL,
  `prev_month_arrow_color` varchar(255) NOT NULL,
  `next_month_font_size` varchar(255) NOT NULL,
  `prev_month_font_size` varchar(255) NOT NULL,
  `month_type` varchar(255) NOT NULL,
  `date_format` varchar(255) NOT NULL,
  `show_time` tinyint(1) NOT NULL,
  `show_repeat` tinyint(1) NOT NULL,
  `all_days_border_width` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

$spider_widget_theme_rows="INSERT INTO `".$wpdb->prefix."spidercalendar_widget_theme` (`id`, `title`, `width`, `cell_height`, `bg_top`, `bg_bottom`, `border_color`, `text_color_year`, `text_color_month`, `text_color_week_days`, `text_color_other_months`, `text_color_this_month_unevented`, `text_color_this_month_evented`, `event_title_color`, `current_day_border_color`, `bg_color_this_month_evented`, `next_prev_event_arrowcolor`, `show_event_bgcolor`, `cell_border_color`, `arrow_color_year`, `week_days_cell_height`, `arrow_color_month`, `text_color_sun_days`, `title_color`, `next_prev_event_bgcolor`, `title_font_size`, `title_font`, `title_style`, `date_color`, `date_size`, `date_font`, `date_style`, `popup_width`, `popup_height`, `number_of_shown_evetns`, `sundays_font_size`, `other_days_font_size`, `weekdays_font_size`, `border_width`, `top_height`, `bg_color_other_months`, `sundays_bg_color`, `weekdays_bg_color`, `week_start_day`, `weekday_sunday_bg_color`, `border_radius`, `year_font_size`, `month_font_size`, `arrow_size`, `next_month_text_color`, `prev_month_text_color`, `next_month_arrow_color`, `prev_month_arrow_color`, `next_month_font_size`, `prev_month_font_size`, `month_type`, `date_format`, `show_time`, `show_repeat`, `all_days_border_width`) VALUES
(1, 'Blue Dark', '230', '30', '00004F', '5BCAFF', '00004F', 'D1D4F5', 'D1D4F5', 'FFFFFF', 'E6E6E6', '000000', 'FFFFFF', 'FFFFFF', 'FFFFFF', '00004F', 'FFFFFF', '009EEB', '000000', 'FFFFFF', '30', 'FFFFFF', '000000', 'FFFFFF', '00004F', '', '', 'normal', 'FFFFFF', '', '', 'normal', '600', '500', '1', '14', '12', '14', '2', '40', '5BCAFF', '5BCAFF', '00004F', 'su', '00004F', '', '18', '14', '14', 'FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF', '9', '9', '2', 'w/d/m/y', 0, 1, 0),
(2, 'Green Light', '230', '25', 'A6BA7D', 'FDFCDE', '000000', '000000', '080808', '000000', '6E5959', '060D12', '000000', '000000', '4AFF9E', 'FF6933', 'E0E0C5', 'FDFCDE', '000000', '000000', '25', '000000', 'FF0000', '000000', 'CCCCCC', '18', 'Courier New', 'normal', '000000', '16', 'Courier New', 'bold', '800', '600', '1', '14', '12', '14', '2', '70', 'FFFFFF', 'FDFCDE', 'E6E6DE', 'su', 'BD848A', '0', '16', '14', '14', 'FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF', '9', '9', '2', 'w/d/m/y', 0, 1, 0),
(3, 'Blue Light', '220', '25', '36A7E9', 'FFFFFF', '000000', '000000', '000000', '000000', '525252', '000000', 'FFFFFF', 'FFFFFF', '36A7E9', 'FFA142', 'FFFFFF', '36A7E9', '000000', '000000', '30', '000000', '36A7E9', 'FFFFFF', 'FFA142', '12', 'Courier New', 'normal', 'FFFFFF', '16', 'Courier New', 'bold', '800', '600', '1', '14', '12', '14', '2', '70', 'FFFFFF', 'FFFFFF', 'FFFFFF', 'su', 'FFFFFF', '0', '18', '14', '10', 'FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF', '9', '9', '2', 'w/d/m/y', 0, 1, 0),
(4, 'Black light', '230', '30', '2A2829', '363636', '000000', 'FFFFFF', 'FFFFFF', 'FFFFFF', 'BDBDBD', 'FFFFFF', '000000', '000000', 'FFFFFF', 'F0F0F0', 'C7C7C7', '969696', '000000', 'FFFFFF', '25', 'FFFFFF', 'FFFFFF', 'FFFFFF', '323232', '', '', 'normal', 'FFFFFF', '', '', 'normal', '600', '500', '1', '14', '12', '14', '2', '30', '363636', '363636', '2A2829', 'su', '2A2829', '4', '18', '14', '12', 'FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF', '9', '9', '1', 'w/d/m/y', 0, 1, 0),
(5, 'Red Elegant', '220', '27', '9A0000', 'CDCC96', 'D9D9D7', 'FFFFFF', 'FFFFFF', '000000', '525252', '000000', 'FFFFFF', 'FFFFFF', '9A0000', '9A0000', 'DEDDB5', 'FFFED0', 'FFFFFF', 'FFFFFF', '25', 'FFFFFF', '9A0000', '000000', '9A0000', '', '', 'normal', '000000', '', '', 'normal', '600', '500', '1', '14', '', '14', '6', '70', 'E4E7CC', 'CDCC96', 'FFFED0', 'mo', 'FFFED0', '3', '18', '14', '9', 'FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF', '9', '9', '2', 'w/d/m/y', 0, 1, 1),
(6, 'Blue Simple', '220', '25', 'FCF7D9', 'FFFFFF', '3DBCEB', '9A0000', '9A0000', 'FFFFFF', 'C7C7C7', '1374C3', '000000', '000000', '9A0000', 'FCF7D9', 'E0E0E0', 'FCF7D9', '1374C3', '9A0000', '20', '9A0000', '013A7D', '000000', '21B5FF', '', '', 'normal', '000000', '', '', 'bold', '600', '500', '1', '14', '12', '14', '5', '70', 'FFFFFF', 'FFFFFF', '013A7D', 'su', '1374C3', '3', '18', '14', '9', 'FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF', '9', '9', '2', 'w/d/m/y', 0, 1, 0),
(7, 'Green Dark', '210', '27', '598923', 'F0F0E6', 'D78B29', 'FFFFFF', 'FFFFFF', '000000', 'A6A6A6', '5C5C5C', 'FFFFFF', 'FFFFFF', '000000', 'D78B29', 'D78B29', 'FFB061', '363636', 'FFFFFF', '25', 'FFFFFF', '000000', 'FFFFFF', 'DDDCC8', '', 'Courier New', 'bold', '000000', '', '', 'normal', '600', '500', '1', '14', '12', '12', '6', '70', 'DDDCC8', 'F0F0E6', 'D78B29', 'su', 'D78B29', '2', '18', '14', '8', 'FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF', '9', '9', '1', 'w/d/m/y', 0, 1, 1),
(8, 'Green Elegant', '195', '20', '009898', 'FDFDCC', 'FDFDCC', 'FFFFFF', 'FFFFFF', '000000', '8C8C8C', '383838', '383838', 'FFFFFF', '000000', 'FE7C00', 'FEAC30', 'FE7C00', '4D4D4D', 'FFFFFF', '25', 'FFFFFF', '000000', 'FFFFFF', 'FDFDE8', '', '', 'normal', 'FFFFFF', '', '', 'normal', '600', '500', '1', '14', '12', '14', '7', '40', 'FDFDE8', 'BACBDC', '9865FE', 'su', '9865FE', '2', '18', '14', '8', 'FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF', '9', '9', '1', 'w/d/m/y', 0, 1, 0),
(9, 'Blue Elegant', '240', '30', '346699', 'E3F9F9', '346699', 'FFFFFF', 'FFFFFF', 'FFFFFF', 'CCCCCC', '2410EE', '000000', '000000', '346699', 'FFCC33', 'E3B62D', 'FFCC33', '6B6B6B', 'FFFFFF', '25', 'FFFFFF', '2410EE', 'FFFFFF', '346699', '', '', 'normal', '000000', '', '', 'normal', '600', '500', '1', '14', '12', '12', '4', '60', 'E3F9F9', 'E3F9F9', '68676D', 'su', '68676D', '3', '18', '12', '8', 'FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF', '10', '10', '2', 'w/d/m/y', 0, 1, 0),
(10, 'Blue Green Mix', '220', '25', 'C0EFC0', 'E3F9F9', 'ABCEA8', '58A42B', '58A42B', '000000', 'B0B0B0', '383838', '383838', '383838', '58A42B', 'C0EFC0', 'AED9AE', 'C0EFC0', 'B1B1B0', '58A42B', '20', '58A42B', 'FF7C5C', 'FFFFFF', '58A42B', '12', '', 'normal', '262626', '12', '', 'normal', '600', '500', '1', '12', '14', '12', '6', '70', 'E1DDE9', 'FFFFFF', 'FFFFFF', 'su', 'FFFFFF', '2', '18', '12', '10', '58A42B', '58A42B', '58A42B', '58A42B', '10', '10', '2', 'w/d/m/y', 0, 1, 0),
(11, 'Brown Elegant', '210', '25', 'E7C892', '7E5F43', 'FFC219', '404040', '404040', '404040', 'FFFFFF', 'FFFFFF', '404040', '404040', 'FFFFFF', 'FFC219', 'B3875F', '7E5F43', '000000', '404040', '20', '404040', 'FFFFFF', 'FFFFFF', 'FFC219', '', '', 'normal', 'FFFFFF', '', '', 'normal', '800', '500', '2', '14', '12', '12', '4', '60', '523F30', '7E5F43', 'FFC219', 'su', 'FFC219', '2', '16', '11', '10', '404040', '404040', '404040', '404040', '9', '9', '1', 'w/d/m/y', 1, 1, 0);";




$spider_theme_rows="INSERT INTO `".$wpdb->prefix."spidercalendar_theme` (`id`, `title`, `width`, `cell_height`, `bg_top`, `bg_bottom`, `border_color`, `text_color_year`, `text_color_month`, `text_color_week_days`, `text_color_other_months`, `text_color_this_month_unevented`, `text_color_this_month_evented`, `event_title_color`, `current_day_border_color`, `bg_color_this_month_evented`, `next_prev_event_arrowcolor`, `show_event_bgcolor`, `cell_border_color`, `arrow_color_year`, `week_days_cell_height`, `arrow_color_month`, `text_color_sun_days`, `title_color`, `next_prev_event_bgcolor`, `title_font_size`, `title_font`, `title_style`, `date_color`, `date_size`, `date_font`, `date_style`, `popup_width`, `popup_height`, `number_of_shown_evetns`, `sundays_font_size`, `other_days_font_size`, `weekdays_font_size`, `border_width`, `top_height`, `bg_color_other_months`, `sundays_bg_color`, `weekdays_bg_color`, `week_start_day`, `weekday_sunday_bg_color`, `border_radius`, `year_font_size`, `month_font_size`, `arrow_size`, `next_month_text_color`, `prev_month_text_color`, `next_month_arrow_color`, `prev_month_arrow_color`, `next_month_font_size`, `prev_month_font_size`, `month_type`, `date_format`, `show_time`, `show_repeat`) VALUES
(1, 'Blue Light', '650', '80', '36A7E9', 'FFFFFF', '000000', '000000', '000000', '000000', '525252', '000000', 'FFFFFF', 'FFFFFF', '36A7E9', 'FFA142', 'FFFFFF', '36A7E9', '000000', '000000', '40', '000000', '36A7E9', 'FFFFFF', 'FFA142', '', '', 'normal', 'FFFFFF', '16', '', 'bold', '800', '600', '1', '14', '12', '14', '4', '80', 'FFFFFF', 'FFFFFF', 'FFFFFF', 'su', 'FFFFFF', '0', '22', '14', '10', 'FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF', '', '', '2', 'w/d/m/y', 1, 1),
(2, 'Blue Dark', '650', '70', '00004F', '5BCAFF', '000000', 'D1D4F5', 'D1D4F5', 'FFFFFF', 'E6E6E6', '000000', 'FFFFFF', 'FFFFFF', 'FFFFFF', '00004F', 'FFFFFF', '009EEB', '000000', 'FFFFFF', '30', 'FFFFFF', '000000', 'FFFFFF', '00004F', '', '', 'normal', 'FFFFFF', '', '', 'normal', '600', '500', '1', '18', '14', '14', '2', '120', 'C0C0C0', '8ADAFF', '000000', 'su', '000000', '', '40', '20', '14', 'FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF', '', '', '1', 'w/d/m/y', 1, 1),
(3, 'Green Light', '650', '70', 'A6BA7D', 'FDFCDE', '000000', '000000', '080808', '000000', '6E5959', '060D12', '000000', '000000', '4AFF9E', 'FF6933', 'E0E0C5', 'FDFCDE', '000000', '000000', '50', '000000', 'FF0000', '000000', 'CCCCCC', '18', 'Courier New', 'normal', '000000', '16', 'Courier New', 'bold', '800', '600', '1', '18', '12', '14', '2', '90', 'FFFFFF', 'FDFCDE', 'E6E6DE', 'su', 'BD848A', '0', '28', '18', '18', 'FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF', '', '', '1', 'w/d/m/y', 1, 1),
(4, 'Black light', '650', '70', '2A2829', '323232', '000000', 'FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF', '000000', '000000', 'FFFFFF', 'F0F0F0', 'C7C7C7', '969696', '000000', 'FFFFFF', '35', 'FFFFFF', 'FFFFFF', 'FFFFFF', '323232', '', '', 'normal', 'FFFFFF', '', '', 'normal', '600', '500', '1', '16', '12', '14', '2', '90', '282828', '323232', '969696', 'su', '969696', '8', '33', '16', '12', 'FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF', '', '', '1', 'w/d/m/y', 1, 1),
(5, 'Red Elegant', '650', '70', '9A0000', 'CDCC96', 'E6E6E4', 'FFFFFF', 'FFFFFF', '000000', '525252', '000000', 'FFFFFF', 'FFFFFF', '9A0000', '9A0000', 'DEDDB5', 'FFFED0', 'FFFFFF', 'FFFFFF', '60', 'FFFFFF', '000000', '000000', '9A0000', '', '', 'normal', '000000', '', '', 'normal', '600', '500', '1', '18', '', '14', '18', '100', 'E4E7CC', 'CDCC96', 'FFFED0', 'mo', 'FFFED0', '6', '33', '16', '10', 'FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF', '', '', '1', 'w/d/m/y', 1, 1),
(6, 'Blue Simple', '650', '70', 'FCF7D9', 'FFFFFF', '3DBCEB', '9A0000', '9A0000', 'FFFFFF', 'C7C7C7', '1374C3', '000000', '000000', '9A0000', 'FCF7D9', 'E0E0E0', 'FCF7D9', '1374C3', '9A0000', '20', '9A0000', '013A7D', '000000', '21B5FF', '', '', 'normal', '000000', '', '', 'bold', '600', '500', '1', '16', '12', '14', '12', '93', 'FFFFFF', 'FFFFFF', '013A7D', 'su', '1374C3', '6', '33', '16', '10', 'FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF', '', '', '1', 'w/d/m/y', 1, 1),
(7, 'Green Dark', '650', '70', '598923', 'F0F0E6', 'D78B29', 'FFFFFF', 'FFFFFF', '000000', 'A6A6A6', '5C5C5C', 'FFFFFF', 'FFFFFF', '000000', 'D78B29', 'D78B29', 'FFB061', '363636', 'FFFFFF', '30', 'FFFFFF', '000000', 'FFFFFF', 'DDDCC8', '', 'Courier New', 'bold', '000000', '', '', 'normal', '600', '500', '1', '16', '12', '14', '12', '100', 'DDDCC8', 'F0F0E6', 'D78B29', 'su', 'D78B29', '6', '33', '16', '12', 'FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF', '', '', '1', 'w/d/m/y', 1, 1),
(8, 'Green Elegant', '650', '70', '009898', 'FDFDCC', 'FDFDCC', 'FFFFFF', 'FFFFFF', '000000', '8C8C8C', '383838', '383838', 'FFFFFF', '000000', 'FE7C00', 'FEAC30', 'FE7C00', '4D4D4D', 'FFFFFF', '30', 'FFFFFF', '000000', 'FFFFFF', 'FDFDE8', '', '', 'normal', 'FFFFFF', '', '', 'normal', '600', '500', '1', '16', '12', '14', '14', '90', 'FDFDE8', 'BACBDC', '9865FE', 'su', '9865FE', '2', '30', '16', '12', 'FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF', '', '', '1', 'w/d/m/y', 1, 1),
(9, 'Blue Elegant', '650', '70', '346699', 'E3F9F9', '346699', 'FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF', '2410EE', '000000', '000000', '346699', 'FFCC33', 'E3B62D', 'FFCC33', '6B6B6B', 'FFFFFF', '25', 'FFFFFF', '2410EE', 'FFFFFF', '346699', '', '', 'normal', '000000', '', '', 'normal', '600', '500', '1', '18', '14', '14', '10', '100', 'CCCCCC', 'CDDDFF', '68676D', 'su', '68676D', '4', '33', '16', '12', 'FFFFFF', 'FFFFFF', 'FFFFFF', 'FFFFFF', '', '', '1', 'w/d/m/y', 1, 1),
(10, 'Blue Green Mix', '650', '70', 'C0EFC0', 'E3F9F9', 'ABCEA8', '58A42B', '58A42B', '000000', 'B0B0B0', '383838', '383838', '383838', '58A42B', 'C0EFC0', 'AED9AE', 'C0EFC0', 'B1B1B0', '58A42B', '25', '58A42B', 'FF7C5C', 'FFFFFF', '58A42B', '', '', 'normal', '262626', '', '', 'normal', '600', '500', '1', '16', '12', '12', '8', '40', 'E1DDE9', 'FFFFFF', 'FFFFFF', 'su', 'FFFFFF', '2', '18', '18', '10', '58A42B', '58A42B', '58A42B', '58A42B', '16', '16', '2', 'w/d/m/y', 1, 1),
(11, 'Brown Elegant', '650', '70', 'E7C892', '7E5F43', 'FFC219', '404040', '404040', '404040', 'FFFFFF', 'FFFFFF', '404040', '404040', 'FFFFFF', 'FFC219', 'B3875F', '7E5F43', '000000', '404040', '30', '404040', 'FFFFFF', 'FFFFFF', 'FFC219', '', '', 'normal', 'FFFFFF', '', '', 'normal', '800', '500', '2', '18', '12', '14', '10', '100', '523F30', '7E5F43', 'FFC219', 'su', 'FFC219', '6', '30', '20', '12', '404040', '404040', '404040', '404040', '16', '16', '1', 'w/d/m/y', 1, 1);";

	
//create tables
$wpdb->query($spider_event_table);
$wpdb->query($spider_calendar_table);
$wpdb->query($spider_theme_table);
$wpdb->query($spider_widhet_theme_table);
$wpdb->query($spider_theme_rows);
$wpdb->query($spider_widget_theme_rows);


}


register_activation_hook( __FILE__, 'SpiderCalendar_activate' );
///////////////////// update plugin


if(get_bloginfo ('version')>=3.1){

add_action('plugins_loaded', 'spider_calendar_chech_update');

}
else{
	spider_calendar_chech_update();
}


function spider_calendar_chech_update() {
	global $wpdb;
	
   if(get_site_option('spider_calendar_cureent_version')!='1.1') {
	   
	 	$sql="ALTER TABLE ".$wpdb->prefix."spidercalendar_calendar  ADD start_month varchar(255);";	  
	  	$wpdb->query($sql);
		
if(!get_site_option('spider_calendar_cureent_version',false)){
	if($wpdb->get_var("SHOW TABLES LIKE '".$wpdb->prefix."spidercalendar_widget_theme'") == $wpdb->prefix."spidercalendar_widget_theme")
add_option('spider_calendar_cureent_version','1.1');
}
else{
	if($wpdb->get_var("SHOW TABLES LIKE '".$wpdb->prefix."spidercalendar_widget_theme'") == $wpdb->prefix."spidercalendar_widget_theme")
update_option('spider_calendar_cureent_version','1.1');
}
    }
}







?>