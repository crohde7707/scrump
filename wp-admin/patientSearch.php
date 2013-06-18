<?php

/** Load WordPress Bootstrap */
require_once('./admin.php');

/** Load WordPress dashboard API */
require_once(ABSPATH . 'wp-admin/includes/dashboard.php');

wp_dashboard_setup();

wp_enqueue_script( 'dashboard' );
if ( current_user_can( 'edit_theme_options' ) )
	wp_enqueue_script( 'customize-loader' );
if ( current_user_can( 'install_plugins' ) )
	wp_enqueue_script( 'plugin-install' );
if ( current_user_can( 'upload_files' ) )
	wp_enqueue_script( 'media-upload' );
add_thickbox();

if ( wp_is_mobile() )
	wp_enqueue_script( 'jquery-touch-punch' );

  $user_id = get_current_user_id();
  $user_info = get_userdata($user_id);  
  
$title = __('Patient Search');
$parent_file = 'landing.php';



include (ABSPATH . 'wp-admin/admin-header.php');

$today = current_time('mysql', 1);
?>

<div class="wrap">
<?php include (ABSPATH . 'wp-admin/menuBar.php'); ?>
<h2><?php echo esc_html( $title ); ?></h2>

<?php if ( has_action( 'welcome_panel' ) && current_user_can( 'edit_theme_options' ) ) :
	$classes = 'welcome-panel';

	$option = get_user_meta( get_current_user_id(), 'show_welcome_panel', true );
	// 0 = hide, 1 = toggled to show or single site creator, 2 = multisite site owner
	$hide = 0 == $option || ( 2 == $option && wp_get_current_user()->user_email != get_option( 'admin_email' ) );
	if ( $hide )
		$classes .= ' hidden'; ?>

 	<div id="welcome-panel" class="<?php echo esc_attr( $classes ); ?>">
 		<?php wp_nonce_field( 'welcome-panel-nonce', 'welcomepanelnonce', false ); ?>
		<a class="welcome-panel-close" href="<?php echo esc_url( admin_url( '?welcome=0' ) ); ?>"><?php _e( 'Dismiss' ); ?></a>
		<?php do_action( 'welcome_panel' ); ?>
	</div>
<?php endif; ?>

<form name="form" action="patientSearch.php" method="get">
  First and Last name: <input type="text" name="pname" /> OR SSN: <input type="text" name="ssn" />
  <input type="submit" name="Submit" value="Search" />
</form>

<?php

  // Get the search variable from URL

  $name = @$_GET['pname'];
  $ssn = @$_GET['ssn'];
  $trimmedName = trim($name); //trim whitespace from the stored variable
  $trimmedSSN = trim($ssn);

// rows to return
$limit=10; 

// check for an empty string and display a message.
if ($trimmedName == "" && $trimmedSSN == "")
  {
  echo "<p>Please enter a search...</p>";
  exit;
  }

// check for a search parameter
if (!isset($name) && !isset($ssn))
  {
  echo "<p>We dont seem to have a search parameter!</p>";
  exit;
  }

//Wordpress database hook
global $wpdb;

// Build SQL Query  
$querySSN = "select * from wp_userchart where ssn = '$trimmedSSN'";
$queryName = "select * from wp_userchart where CONCAT(first_name, ' ', last_name) = '$trimmedName'";

   if( strcmp($name, "") != 0 ) {
     $patientID = $wpdb->get_row($queryName);
     $numrows=count($patientID);
     $namedsearch = 1;
   }
   if( strcmp($ssn, "") != 0 ) {
     $patientID = $wpdb->get_row($querySSN);
     $numrows=count($patientID);
     $namedsearch = 0;
   }

// If we have no results, display no result message

if ($numrows == 0) {
  echo "<h4>Results</h4>";
  echo "<p>Sorry, your search: &quot;" . $trimmedName . " | " . $trimmedSSN . "&quot; returned zero results</p>";

// next determine if s has been passed to script, if not use 0
  if (empty($s)) {
  $s=0;
  }
}
// display what the person searched for
if($namedsearch == 1) {
   echo "<p>You searched for: &quot;" . $name . "&quot;</p>";
} else if($namedsearch == 0) {
   echo "<p>You searched for: &quot;" . $ssn . "&quot;</p>";
}
$chartQuery = "select * from wp_userchart where user_id = '$patientID->user_id'";
$chart = $wpdb->get_results($chartQuery);

// begin to show results set
echo "Results";
$count = 0;

  echo "<table>";
  echo "<thead><tr><td>#</td><td>Patient Name</td><td>Patient SSN</td><td>Action</td></tr></thead><tbody>";
  foreach($chart as $item) {
     $count = $count + 1;
     if($count % 2 == 0) {
        echo "<tr>";
     } else {
        echo "<tr class='oddrow'>";
     }
     echo "<td>".$count."</td>";
     echo "<td>".$item->first_name." ".$item->last_name."</td>";
     echo "<td>".$item->ssn."</td>";
     echo "<td><input type='button' class='chartButton' onclick=window.location.href='http://ehisys.org/wp-admin/chart.php?uid=$item->user_id' value='View Chart' /></td>";
     echo "</tr>";
  }
  echo "</tbody></table>";

  
?>

<?php //wp_dashboard(); ?>

</div><!-- wrap -->
<?php require(ABSPATH . 'wp-admin/admin-footer.php'); ?>