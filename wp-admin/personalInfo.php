<?php

/** Load WordPress Bootstrap */
require_once('./admin.php');

/** Load WordPress dashboard API */
require_once(ABSPATH . 'wp-admin/includes/dashboard.php');

wp_dashboard_setup();

$user_id = get_current_user_id();
$user_info = get_userdata($user_id);  
  
$title = __('Patient Chart');
$parent_file = 'patientSearch.php';

include (ABSPATH . 'wp-admin/admin-header.php');

$today = current_time('mysql', 1);

$item = $_GET['update'];
?>
<div class="wrap">
<?php if($item) { ?>
   <div class="successMsg">
      <h4>Personal Information updated successfully</h4>
   </div>
<?php }

include (ABSPATH . 'wp-admin/menuBar.php'); 

if(strcmp($_REQUEST['nav'], "disabled") == 0) { ?>
   <script type="text/javascript">
   window.onload = function() {
     var anchors = document.getElementsByTagName("a");
     for (var i = 0; i < anchors.length; i++) {
        anchors[i].onclick = function() {return(false);};
     }
   };
   </script>
<?php }

//Wordpress database hook
global $wpdb;

// Build SQL Query  
$query = "select * from wp_userchart where user_id = '$user_id'";

   $chart = $wpdb->get_row($query);
   $numrows=count($query);

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';
$type = $user_info-> rpr_type_of_account;
switch($action) {

case 'view':
// begin to show results set
?>
  <h2>Personal Information <input style="font-size:13px; padding:4px;"type="button" onclick=window.location.href='personalInfo.php?action=edit' value="Edit Info" /></h2>
  <div id="personalInfo">
     <ul class="patientInfo">
            <li><span class="iLabel">First Name:</span> <?php echo "$chart->first_name";?></li>
            <li><span class="iLabel">MI:</span> <?php echo "$chart->middle_i";?></li>
            <li><span class="iLabel">Last Name:</span> <?php echo "$chart->last_name";?></li>
            <li><span class="iLabel">Sex:</span> <?php echo "$chart->sex";?></li>
            <li><span class="iLabel">Marital Status: </span> <?php echo "$chart->marital";?></li>
            <li><span class="iLabel">SSN:</span> <?php echo "$chart->ssn";?></li>
            <li><span class="iLabel">Address 1:</span> <?php echo "$chart->address1";?></li>
            <li><span class="iLabel">DOB:</span> <?php echo "$chart->dob";?></li>
            <li><span class="iLabel">Address 2:</span> <?php echo "$chart->address2";?></li>
            <li><span class="iLabel">City:</span> <?php echo "$chart->city";?></li>
            <li><span class="iLabel">State:</span> <?php echo "$chart->state";?></li>
            <li><span class="iLabel">Zip:</span> <?php echo "$chart->zip";?></li>
            <li><span class="iLabel">Primary Phone:</span> <?php echo "$chart->primary_phone";?></li>
            <li><span class="iLabel">Secondary Phone:</span> <?php echo "$chart->secondary_phone";?></li>
            <li><span class="iLabel">Email:</span> <?php echo "$chart->email";?></li>
            <li><span class="iLabel">Occupation:</span> <?php echo "$chart->occupation";?></li>
            <h4>Emergency Contact</h4>
            <li><span class="iLabel">Name:</span> <?php echo "$chart->e_first_name $chart->e_last_name";?></li>
            <li><span class="iLabel">Phone:</span> <?php echo "$chart->e_phone";?></li>
            <li><span class="iLabel">Email:</span> <?php echo "$chart->e_email";?></li>
         </ul>
  </div>
<?php 
break;

case 'edit': 
$state = $chart->state;
?>
  <h2>Editing Personal Information</h2>
  <div id="personalInfo">
     <form action="updat.php" method="post" id="pInfo">
           <input type="hidden" name="uid" value="<?php echo "$uid";?>" />
           <input type="hidden" name="section" value="pInfo">
           <input type="hidden" name="initial" value="true">
           <ul class="patientInfo">
              <li>First Name: <input name="first" type="text" value="<?php echo "$chart->first_name";?>" /></li>
              <li>MI: <input name="middle" type="text" value="<?php echo "$chart->middle_i";?>" /></li>
              <li>Last Name: <input name="last" type="text" value="<?php echo "$chart->last_name";?>" /></li>
              <li>Sex: <input type='radio' name='sex' value='male' <?php echo (($chart->sex == 'Male') ? "checked"   : "");?> />Male <input type='radio' name='sex' value='female' <?php echo (($chart->sex == 'Female') ? "checked"   : "");?> />Female</li>
              <li><span class="iLabel">Marital Status: </span> <input type='radio' name='marital' value='Single' <?php echo (($chart->marital == 'Single') ? "checked"   : "");?> />Single <input type='radio' name='marital' value='Married' <?php echo (($chart->marital == 'Married') ? "checked"   : "");?> />Married <input type='radio' name='marital' value='Divorced' <?php echo (($chart->marital == 'Divorced') ? "checked"   : "");?> />Divorced <input type='radio' name='marital' value='Widowed' <?php echo (($chart->marital == 'Widowed') ? "checked"   : "");?> />Widowed</li>
              <li>SSN: <input name="ssn" type='text' value="<?php echo "$chart->ssn";?>" /></li>
              <li>Address 1: <input name="address1" type='text' value="<?php echo "$chart->address1";?>" /></li>
              <li>DOB: <input name="dob" type="text" value="<?php echo "$chart->dob";?>" /> (YYYY/MM/DD)</li>
              <li>Address 2: <input name="address2" type='text' value="<?php echo "$chart->address2";?>" /></li>
              <li>City: <input name="city" type='text' value="<?php echo "$chart->city";?>" /></li>
              <li>State: <select name='state' size='1'>
                <option value='AL'<?php if($state === 'AL') echo ' selected';?>>Alabama</option>
                <option value='AK'<?php if($state === 'AK') echo ' selected';?>>Alaska</option>
                <option value='AZ'<?php if($state === 'AZ') echo ' selected';?>>Arizona</option>
                <option value='AR'<?php if($state === 'AR') echo ' selected';?>>Arkansas</option>
                <option value='CA'<?php if($state === 'CA') echo ' selected';?>>California</option>
                <option value='CO'<?php if($state === 'CO') echo ' selected';?>>Colorado</option>
                <option value='CT'<?php if($state === 'CT') echo ' selected';?>>Connecticut</option>
                <option value='DE'<?php if($state === 'DE') echo ' selected';?>>Delaware</option>
                <option value='DC'<?php if($state === 'DC') echo ' selected';?>>Dist of Columbia</option>
                <option value='FL'<?php if($state === 'FL') echo ' selected';?>>Florida</option>
                <option value='GA'<?php if($state === 'GA') echo ' selected';?>>Georgia</option>
                <option value='HI'<?php if($state === 'HI') echo ' selected';?>>Hawaii</option>
                <option value='ID'<?php if($state === 'ID') echo ' selected';?>>Idaho</option>
                <option value='IL'<?php if($state === 'IL') echo ' selected';?>>Illinois</option>
                <option value='IN'<?php if($state === 'IN') echo ' selected';?>>Indiana</option>
                <option value='IA'<?php if($state === 'IA') echo ' selected';?>>Iowa</option>
                <option value='KS'<?php if($state === 'KS') echo ' selected';?>>Kansas</option>
                <option value='KY'<?php if($state === 'KY') echo ' selected';?>>Kentucky</option>
                <option value='LA'<?php if($state === 'LA') echo ' selected';?>>Louisiana</option>
                <option value='ME'<?php if($state === 'ME') echo ' selected';?>>Maine</option>
                <option value='MD'<?php if($state === 'MD') echo ' selected';?>>Maryland</option>
                <option value='MA'<?php if($state === 'MA') echo ' selected';?>>Massachusetts</option>
                <option value='MI'<?php if($state === 'MI') echo ' selected';?>>Michigan</option>
                <option value='MN'<?php if($state === 'MN') echo ' selected';?>>Minnesota</option>
                <option value='MS'<?php if($state === 'MS') echo ' selected';?>>Mississippi</option>
                <option value='MO'<?php if($state === 'MO') echo ' selected';?>>Missouri</option>
                <option value='MT'<?php if($state === 'MT') echo ' selected';?>>Montana</option>
                <option value='NE'<?php if($state === 'NE') echo ' selected';?>>Nebraska</option>
                <option value='NV'<?php if($state === 'NV') echo ' selected';?>>Nevada</option>
                <option value='NH'<?php if($state === 'NH') echo ' selected';?>>New Hampshire</option>
                <option value='NJ'<?php if($state === 'NJ') echo ' selected';?>>New Jersey</option>
                <option value='NM'<?php if($state === 'NM') echo ' selected';?>>New Mexico</option>
                <option value='NY'<?php if($state === 'NY') echo ' selected';?>>New York</option>
                <option value='NC'<?php if($state === 'NC') echo ' selected';?>>North Carolina</option>
                <option value='ND'<?php if($state === 'ND') echo ' selected';?>>North Dakota</option>
                <option value='OH'<?php if($state === 'OH') echo ' selected';?>>Ohio</option>
                <option value='OK'<?php if($state === 'OK') echo ' selected';?>>Oklahoma</option>
                <option value='OR'<?php if($state === 'OR') echo ' selected';?>>Oregon</option>
                <option value='PA'<?php if($state === 'PA') echo ' selected';?>>Pennsylvania</option>
                <option value='RI'<?php if($state === 'RI') echo ' selected';?>>Rhode Island</option>
                <option value='SC'<?php if($state === 'SC') echo ' selected';?>>South Carolina</option>
                <option value='SD'<?php if($state === 'SD') echo ' selected';?>>South Dakota</option>
                <option value='TN'<?php if($state === 'TN') echo ' selected';?>>Tennessee</option>
                <option value='TX'<?php if($state === 'TX') echo ' selected';?>>Texas</option>
                <option value='UT'<?php if($state === 'UT') echo ' selected';?>>Utah</option>
                <option value='VT'<?php if($state === 'VT') echo ' selected';?>>Vermont</option>
                <option value='VA'<?php if($state === 'VA') echo ' selected';?>>Virginia</option>
                <option value='WA'<?php if($state === 'WA') echo ' selected';?>>Washington</option>
                <option value='WV'<?php if($state === 'WV') echo ' selected';?>>West Virginia</option>
                <option value='WI'<?php if($state === 'WI') echo ' selected';?>>Wisconsin</option>
                <option value='WY'<?php if($state === 'WY') echo ' selected';?>>Wyoming</option>
              </select></li>
              <li>Zip: <input name="zip" type="text" value="<?php echo "$chart->zip";?>" /></li>
              <li>Primary Phone: <input name="pphone" type="text" value="<?php echo "$chart->primary_phone";?>" /></li>
              <li>Secondary Phone: <input name="sphone" type="text" value="<?php echo "$chart->secondary_phone";?>" /></li>
              <li>Email: <input name="email" type="text" value="<?php echo "$chart->email";?>" /></li>
              <li><span class="iLabel">Occupation:</span> <input name="occupation" type="text" value="<?php echo "$chart->occupation";?>" /></li>
              <h4>Emergency Contact</h4>
              <li>Name: <input name="ename" type="text" value="<?php echo "$chart->e_first_name $chart->e_last_name";?>" /></li>
              <li>Phone: <input name="ephone" type="text" value="<?php echo "$chart->e_phone";?>" /></li>
              <li>Email: <input name="eemail" type="text" value="<?php echo "$chart->e_email";?>" /></li>
            </ul>
          <button type="submit" form="pInfo">Save Changes</button>
        </form>
    </div>
    <?php 
break;

default:
;
}
//wp_dashboard(); ?>

</div><!-- wrap -->
<?php require(ABSPATH . 'wp-admin/admin-footer.php'); ?>