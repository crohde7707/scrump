<?php
  //---------------- Wordpress API -------------------
  /** Load WordPress Bootstrap */
  require_once('./admin.php');
  /** Load WordPress dashboard API */
  require_once(ABSPATH . 'wp-admin/includes/dashboard.php');

  wp_dashboard_setup();
  //---------------End Wordpress API -----------------

  //---------------- Current User Info ---------------
  $user_id = get_current_user_id();
  $user_info = get_userdata($user_id);  
  //--------------------------------------------------  
  
  $title = __('Patient Chart');
  $parent_file = 'patientSearch.php';

  include (ABSPATH . 'wp-admin/admin-header.php');

  $today = current_time('mysql', 1);
  
  //-------------Displays success msg if updated------
  $item = $_GET['update'];
  ?><div class="wrap">
  <?php if($item) { ?>
     <div class="msgSuccess">
        <h4>'<?php 
        switch($item) {
           case "pInfo":
              echo "Personal Information";
              break;
           case "mInfo":
              echo "Medical Information";
              break;
           case "iInfo":
              echo "Insurance Information";
              break;
           default:
           ;
        }
        ?>' updated successfully</h4>
     </div>
  <?php }
   //-------------------------------------------------

  //-------------------- Menu ------------------------
  include (ABSPATH . 'wp-admin/menuBar.php'); 
  //--------------------------------------------------

  $uid = $_GET['uid'];
  
  //If Patient and isn't his chart, send to landing page---
  if( (strcmp($user_info-> rpr_type_of_account, "Patient") == 0) && (strcmp($uid, $user_id) != 0) ) { ?>
     <script type="text/javascript">
        window.location.href='http://ehisys.org/wp-admin/landing.php';
     </script>
  <?php }
  //-------------------------------------------------------

  //Wordpress database hook
  global $wpdb;

  //------------------ SQL Queries ----------------------  
    //-------------------Patient-------------------------
    $query = "select * from wp_userchart where user_id = '$uid'";

       $chart = $wpdb->get_row($query);
       $numrows=count($query);
    //------------------ Tests --------------------------
    $tQuery = "select * from wp_tests where user_id = '$uid'";
       $tests = $wpdb->get_results($tQuery);
    //------------------ Receipts -----------------------
    $rQuery = "select * from wp_rc where user_id = '$uid' order by timestamp";
       $rcs = $wpdb->get_results($rQuery);
    //------------------ Appt ---------------------------
    $aQuery = "select * from wp_appt where user_id = '$uid' AND DATEDIFF(starts_at, NOW()) = 0 AND checked_in = 0";
    $appt = $wpdb->get_row($aQuery);
    if(count($appt) == 0) {
       $disabled = "disabled";
    } else {
       $disabled = "";
    } 
    //------------------ Perscriptions -----------------
    $pQuery = "select * from wp_percs where user_id = '$uid' order by timestamp";
       $percs = $wpdb->get_results($pQuery);
    //------------------ Diagnosis -----------------
    $diQuery = "select * from wp_diag where user_id = '$uid' order by timestamp";
       $diags = $wpdb->get_results($diQuery);
    //------------------ Conditionss -----------------
    $cQuery = "select * from wp_cond where user_id = '$uid' order by timestamp";
       $conds = $wpdb->get_results($cQuery);
    //------------------ Doc/Nurse ---------------------
    $dQuery = "select last_name from wp_userchart where user_id='$user_id'";
       $emp = $wpdb->get_var($dQuery);
     
  //-----------------------------------------------------
  $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';
  $type = $user_info-> rpr_type_of_account;
  switch($action) {

  case 'view':
  if(isset($_REQUEST['test'])) { ?>
     <div class="msgSuccess">
        <?php
           switch($_REQUEST['test']) {
              case 'entered':
                 ?><h3>Test Order added to patient chart</h3><?php
                 break;
              case 'sent':
                 ?><h3>Test Order successfully sent to the lab</h3><?php
                 break;
              default:
              ;
           }?>
     </div>
  <?php } ?>
    <h2><?php echo "$chart->first_name $chart->last_name";?>'s Chart <input style="font-size:13px; padding:4px;"type="button" onclick=window.location.href='chart.php?uid=<?php echo "$uid";?>&action=edit' value="Edit Info" /> <?php if(strcmp($type, "Receptionist") == 0) {?><form style="display:inline" method="post" id="checkin" action="checkin.php"><input name="uid" type="hidden" value="<?php echo "$uid";?>" /><input name="apptid" type="hidden" value="<?php echo "$appt->id";?>" /> <button <?php echo "$disabled";?> style="font-size:13px; padding:4px;" type="submit">Check In</button></form><?php } ?></h2>
    <div id="pChart">
       <?php if(strcmp($type, "Patient") == 0 || strcmp($type, "Receptionist") == 0) {?>
       <h3>Personal Information</h3>
       <div>
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
      <?php }
      if(strcmp($type, "Doctor") == 0 || strcmp($type, "Nurse") == 0) {?> 
      <h3>Medical History</h3>
      <div>
         <h3>Basic Info</h3>
         <?php
            $height = explode(",",$chart->height);?>
         <span class="iLabel">Height:</span> <?php echo "$height[0]";?>&#39; <?php echo "$height[1]";?>&#34;<br />
         <span class="iLabel">Weight:</span> <?php echo "$chart->weight";?>lbs<br />
         
         <h3>Past Ailments</h3>
         <?php
            $ails = explode(",", $chart->ails);
         ?>
         <div class="column">
            <input type="checkbox" name="ail[]" value="1" disabled=true <?php if(in_array("1", $ails)) echo 'checked';?>/> AIDS/HIV Positive<br />
            <input type="checkbox" name="ail[]" value="2" disabled=true <?php if(in_array("2", $ails)) echo 'checked';?>/> Alzheimer's Disease<br />
            <input type="checkbox" name="ail[]" value="3" disabled=true <?php if(in_array("3", $ails)) echo 'checked';?>/> Anaphylais<br />
            <input type="checkbox" name="ail[]" value="4" disabled=true <?php if(in_array("4", $ails)) echo 'checked';?>/> Anemia<br />
            <input type="checkbox" name="ail[]" value="5" disabled=true <?php if(in_array("5", $ails)) echo 'checked';?>/> Angina<br />
            <input type="checkbox" name="ail[]" value="6" disabled=true <?php if(in_array("6", $ails)) echo 'checked';?>/> Arthritis/Gout<br />
            <input type="checkbox" name="ail[]" value="7" disabled=true <?php if(in_array("7", $ails)) echo 'checked';?>/> Artificial Heart Valve<br />
            <input type="checkbox" name="ail[]" value="8" disabled=true <?php if(in_array("8", $ails)) echo 'checked';?>/> Artificial Joint<br />
            <input type="checkbox" name="ail[]" value="9" disabled=true <?php if(in_array("9", $ails)) echo 'checked';?>/> Asthma<br />
            <input type="checkbox" name="ail[]" value="10" disabled=true <?php if(in_array("10", $ails)) echo 'checked';?>/> Blood Disease<br />
            <input type="checkbox" name="ail[]" value="11" disabled=true <?php if(in_array("11", $ails)) echo 'checked';?>/> Blood Transfusion<br />
            <input type="checkbox" name="ail[]" value="12" disabled=true <?php if(in_array("12", $ails)) echo 'checked';?>/> Breathing Problem<br />
            <input type="checkbox" name="ail[]" value="13" disabled=true <?php if(in_array("13", $ails)) echo 'checked';?>/> Bruise Easily<br />
            <input type="checkbox" name="ail[]" value="14" disabled=true <?php if(in_array("14", $ails)) echo 'checked';?>/> Cancer<br />
            <input type="checkbox" name="ail[]" value="15" disabled=true <?php if(in_array("15", $ails)) echo 'checked';?>/> Chemotherapy<br />
            <input type="checkbox" name="ail[]" value="16" disabled=true <?php if(in_array("16", $ails)) echo 'checked';?>/> Chest Pains<br />
            <input type="checkbox" name="ail[]" value="17" disabled=true <?php if(in_array("17", $ails)) echo 'checked';?>/> Cold Sores/Fever Blisters<br />
            <input type="checkbox" name="ail[]" value="18" disabled=true <?php if(in_array("18", $ails)) echo 'checked';?>/> Congenital Heart Disorder<br />
            <input type="checkbox" name="ail[]" value="19" disabled=true <?php if(in_array("19", $ails)) echo 'checked';?>/> Convulsions<br />
        </div>
        <div class="column">
            <input type="checkbox" name="ail[]" value="20" disabled=true <?php if(in_array("20", $ails)) echo 'checked';?>/> Cortisone Medicine<br />
            <input type="checkbox" name="ail[]" value="21" disabled=true <?php if(in_array("21", $ails)) echo 'checked';?>/> Diabetes<br />
            <input type="checkbox" name="ail[]" value="22" disabled=true <?php if(in_array("22", $ails)) echo 'checked';?>/> Drug Addiction<br />
            <input type="checkbox" name="ail[]" value="23" disabled=true <?php if(in_array("23", $ails)) echo 'checked';?>/> Easily Winded<br />
            <input type="checkbox" name="ail[]" value="24" disabled=true <?php if(in_array("24", $ails)) echo 'checked';?>/> Emphysema<br />
            <input type="checkbox" name="ail[]" value="25" disabled=true <?php if(in_array("25", $ails)) echo 'checked';?>/> Epilepsy or Seizures<br />
            <input type="checkbox" name="ail[]" value="26" disabled=true <?php if(in_array("26", $ails)) echo 'checked';?>/> Excessive Bleeding<br />
            <input type="checkbox" name="ail[]" value="27" disabled=true <?php if(in_array("27", $ails)) echo 'checked';?>/> Excessive Thirst<br />
            <input type="checkbox" name="ail[]" value="28" disabled=true <?php if(in_array("28", $ails)) echo 'checked';?>/> Fainting Spells/Dizziness<br />
            <input type="checkbox" name="ail[]" value="29" disabled=true <?php if(in_array("29", $ails)) echo 'checked';?>/> Frequent Cough<br />
            <input type="checkbox" name="ail[]" value="30" disabled=true <?php if(in_array("30", $ails)) echo 'checked';?>/> Frequent Diarrhea<br />
            <input type="checkbox" name="ail[]" value="31" disabled=true <?php if(in_array("31", $ails)) echo 'checked';?>/> Frequent Headaches<br />
            <input type="checkbox" name="ail[]" value="32" disabled=true <?php if(in_array("32", $ails)) echo 'checked';?>/> Genital Herpes<br />
            <input type="checkbox" name="ail[]" value="33" disabled=true <?php if(in_array("33", $ails)) echo 'checked';?>/> Glaucoma<br />
            <input type="checkbox" name="ail[]" value="34" disabled=true <?php if(in_array("34", $ails)) echo 'checked';?>/> Hay Fever<br />
            <input type="checkbox" name="ail[]" value="35" disabled=true <?php if(in_array("35", $ails)) echo 'checked';?>/> Heart Attack/Failure<br />
            <input type="checkbox" name="ail[]" value="36" disabled=true <?php if(in_array("36", $ails)) echo 'checked';?>/> Heart Murmur<br />
            <input type="checkbox" name="ail[]" value="37" disabled=true <?php if(in_array("37", $ails)) echo 'checked';?>/> Heart Pace Maker<br />
            <input type="checkbox" name="ail[]" value="38" disabled=true <?php if(in_array("38", $ails)) echo 'checked';?>/> Heart Trouble/Disease<br />
        </div>
        <div class="column">
            <input type="checkbox" name="ail[]" value="39" disabled=true <?php if(in_array("39", $ails)) echo 'checked';?>/> Hemophilia<br />
            <input type="checkbox" name="ail[]" value="40" disabled=true <?php if(in_array("40", $ails)) echo 'checked';?>/> Hepatitis A<br />
            <input type="checkbox" name="ail[]" value="41" disabled=true <?php if(in_array("41", $ails)) echo 'checked';?>/> Hepatitis B or C<br />
            <input type="checkbox" name="ail[]" value="42" disabled=true <?php if(in_array("42", $ails)) echo 'checked';?>/> Herpes<br />
            <input type="checkbox" name="ail[]" value="43" disabled=true <?php if(in_array("43", $ails)) echo 'checked';?>/> High Blood Pressure<br />
            <input type="checkbox" name="ail[]" value="44" disabled=true <?php if(in_array("44", $ails)) echo 'checked';?>/> Hives/Rash<br />
            <input type="checkbox" name="ail[]" value="45" disabled=true <?php if(in_array("45", $ails)) echo 'checked';?>/> Hypoglycemia<br />
            <input type="checkbox" name="ail[]" value="46" disabled=true <?php if(in_array("46", $ails)) echo 'checked';?>/> Irregular Heartbeat<br />
            <input type="checkbox" name="ail[]" value="47" disabled=true <?php if(in_array("47", $ails)) echo 'checked';?>/> Kidney Problems<br />
            <input type="checkbox" name="ail[]" value="48" disabled=true <?php if(in_array("48", $ails)) echo 'checked';?>/> Leukemia<br />
            <input type="checkbox" name="ail[]" value="49" disabled=true <?php if(in_array("49", $ails)) echo 'checked';?>/> Liver Disease<br />
            <input type="checkbox" name="ail[]" value="50" disabled=true <?php if(in_array("50", $ails)) echo 'checked';?>/> Low Blood Pressure<br />
            <input type="checkbox" name="ail[]" value="51" disabled=true <?php if(in_array("51", $ails)) echo 'checked';?>/> Lung Disease<br />
            <input type="checkbox" name="ail[]" value="52" disabled=true <?php if(in_array("52", $ails)) echo 'checked';?>/> Mitral Valve Prolapse<br />
            <input type="checkbox" name="ail[]" value="53" disabled=true <?php if(in_array("53", $ails)) echo 'checked';?>/> Pain in Jaw Joints<br />
            <input type="checkbox" name="ail[]" value="54" disabled=true <?php if(in_array("54", $ails)) echo 'checked';?>/> Parathyroid Disease<br />
            <input type="checkbox" name="ail[]" value="55" disabled=true <?php if(in_array("55", $ails)) echo 'checked';?>/> Psychiatric Care<br />
            <input type="checkbox" name="ail[]" value="56" disabled=true <?php if(in_array("56", $ails)) echo 'checked';?>/> Radiation Treatments<br />
            <input type="checkbox" name="ail[]" value="57" disabled=true <?php if(in_array("57", $ails)) echo 'checked';?>/> Recent Weight Loss<br />
        </div>
        <div class="column">
            <input type="checkbox" name="ail[]" value="58" disabled=true <?php if(in_array("58", $ails)) echo 'checked';?>/> Renal Dialysis<br />
            <input type="checkbox" name="ail[]" value="59" disabled=true <?php if(in_array("59", $ails)) echo 'checked';?>/> Rheumatic Fever<br />
            <input type="checkbox" name="ail[]" value="60" disabled=true <?php if(in_array("60", $ails)) echo 'checked';?>/> Rheumatism<br />
            <input type="checkbox" name="ail[]" value="61" disabled=true <?php if(in_array("61", $ails)) echo 'checked';?>/> Scarlet Fever<br />
            <input type="checkbox" name="ail[]" value="62" disabled=true <?php if(in_array("62", $ails)) echo 'checked';?>/> Shingles<br />
            <input type="checkbox" name="ail[]" value="63" disabled=true <?php if(in_array("63", $ails)) echo 'checked';?>/> Sickle Cell Disease<br />
            <input type="checkbox" name="ail[]" value="64" disabled=true <?php if(in_array("64", $ails)) echo 'checked';?>/> Sinus Trouble<br />
            <input type="checkbox" name="ail[]" value="65" disabled=true <?php if(in_array("65", $ails)) echo 'checked';?>/> Spina Bifida<br />
            <input type="checkbox" name="ail[]" value="66" disabled=true <?php if(in_array("66", $ails)) echo 'checked';?>/> Stomach/Intestinal Disease<br />
            <input type="checkbox" name="ail[]" value="67" disabled=true <?php if(in_array("67", $ails)) echo 'checked';?>/> Stroke<br />
            <input type="checkbox" name="ail[]" value="68" disabled=true <?php if(in_array("68", $ails)) echo 'checked';?>/> Swelling of Limbs<br />
            <input type="checkbox" name="ail[]" value="69" disabled=true <?php if(in_array("69", $ails)) echo 'checked';?>/> Thyroid Disease<br />
            <input type="checkbox" name="ail[]" value="70" disabled=true <?php if(in_array("70", $ails)) echo 'checked';?>/> Tonsillitis<br />
            <input type="checkbox" name="ail[]" value="71" disabled=true <?php if(in_array("71", $ails)) echo 'checked';?>/> Tuberculosis<br />
            <input type="checkbox" name="ail[]" value="72" disabled=true <?php if(in_array("72", $ails)) echo 'checked';?>/> Tumors or Growths<br />
            <input type="checkbox" name="ail[]" value="73" disabled=true <?php if(in_array("73", $ails)) echo 'checked';?>/> Ulcers<br />
            <input type="checkbox" name="ail[]" value="74" disabled=true <?php if(in_array("74", $ails)) echo 'checked';?>/> Venereal Disease<br />
            <input type="checkbox" name="ail[]" value="75" disabled=true <?php if(in_array("75", $ails)) echo 'checked';?>/> Yellow Jaundice<br />
        </div>
      </div>
      <?php }
      if(strcmp($type, "Patient") == 0 || strcmp($type, "Receptionist") == 0) {?>
      <h3>Insurance Information</h3>
      <div>
        <ul class="insuranceInfo">
           <h4>Insurance Company</h4>
           <li>Company Name: <?php echo "$chart->ins_company";?></li>
           <li>Address: <?php echo "$chart->ins_address";?></li>
           <li>City: <?php echo "$chart->ins_city";?> State: <?php echo "$chart->ins_state";?> Zip: <?php echo "$chart->ins_zip";?></li>
           <li>Phone: <?php echo "$chart->ins_phone";?></li>
           <h4>Policy</h4>
           <li>Policyholder's Name: <?php echo "$chart->ins_phname";?></li>
           <li>Policyholder's DOB: <?php echo "$chart->ins_phdob";?></li>
           <li>Policyholder's Phone: <?php echo "$chart->ins_phphone";?></li>
           <li>Policy Number: <?php echo "$chart->ins_number";?></li>
           <li>Group/Plan Number: <?php echo "$chart->ins_gnumber";?></li>
        </ul>
      </div>
      <?php }
      if(strcmp($type, "Doctor") == 0 || strcmp($type, "Nurse") == 0) {?> 
      <h3>Medical Conditions</h3>
      <div id="condition">
         <h3>Add Condition</h3>
         <div>
           <form action="updat.php" method="post" id="enterCond">
             <input type="hidden" name="uid" value="<?php echo "$uid";?>" />
             <input type="hidden" name="section" value="enterCond" />
             <strong>Enter Cond:</strong><br />
             <textarea rows="10" cols="50" name="cond"></textarea><br />
             <button class="submitButton" type="submit" form="enterCond">Add Condition to Chart</button>
            </form>
        </div>
        <h3>Current Conditions</h3>
         <div>
            <ul><?php
            foreach($conds as $cond) { 
               $date = date("F j, Y, g:i a", strtotime($cond->timestamp));?>
               <li><strong><?php echo "$date";?>:</strong> <br /><?php echo "$cond->condition";?></li>
      <?php } ?>
            </ul>
         </div>
      </div>
      <?php }
      if(strcmp($type, "Doctor") == 0) {?>
      <h3>Diagnosis</h3>
      <div id="diagnosis">
         <h3>Create Diagnosis</h3>
         <div>
           <form action="updat.php" method="post" id="enterDiag">
             <input type="hidden" name="uid" value="<?php echo "$uid";?>" />
             <input type="hidden" name="section" value="enterDiag" />
             <strong>Enter Diagnosis:</strong><br />
             <textarea rows="10" cols="50" name="diag"></textarea><br />
             <button class="submitButton" type="submit" form="enterDiag">Save Diagnosis</button>
            </form>
        </div>
        <h3>View Diagnosis</h3>
         <div>
            <ul><?php
            foreach($diags as $diag) { 
               $date = date("F j, Y, g:i a", strtotime($diag->timestamp));?>
               <li><strong><?php echo "$date";?>:</strong> <br /><?php echo "$diag->diagnosis";?></li>
      <?php } ?>
            </ul>
         </div>
      </div>
      <?php }
      if(strcmp($type, "Doctor") == 0 || strcmp($type, "Nurse") == 0) {?>
      <h3>Prescriptions</h3>
      <div id="prescriptions">
         <h3>Create Prescription</h3>
         <div>
           <form action="generate.php" method="post" id="enterPersc">
             <input type="hidden" name="uid" value="<?php echo "$uid";?>" />
             <input type="hidden" name="section" value="enterPersc" />
             <input type="hidden" name="emp" value="<?php echo "$type $emp";?>" />
             <input type="hidden" name="patientfn" value="<?php echo "$chart->first_name";?>" />
             <input type="hidden" name="patientmi" value="<?php echo "$chart->middle_i";?>" />
             <input type="hidden" name="patientln" value="<?php echo "$chart->last_name";?>" />
             <div id="fields"></div>
             <div class="formbuttons"><button type="button" id="addVar">Add item</button>       <button class="submitButton" type="submit" form="enterPersc">Generate Prescription</button></div>
            </form>
        </div>
        <h3>Send Prescription</h3>
         <div>
            <form action="updat.php" method="post" id="sendPersc">
               <input type="hidden" name="uid" value="<?php echo "$uid";?>" />
               <input type="hidden" name="section" value="sendPersc" />
               <ul>
               <?php 
                 foreach($percs as $perc) { 
                    $link = "/wp-admin/includes/files/percs/" . $perc->filename;
                    $sent = (strcmp($perc->sent, 'false') == 0) ? "Not Sent" : "Sent"; ?>
                    <li><input type="radio" name="perc" value="<?php echo "$perc->id";?>" /> Prescription: <?php echo "$perc->timestamp";?> <a href='<?php echo "$link";?>' target="_blank">View Prescription</a> [<?php echo "$sent"; ?>]</li>
              <?php 
                 }?>
             </ul>
               <button type="submit" form="sendPersc">Send Prescription to Pharmacy</button>
            </form>
         </div>
      </div>
      <?php }
      if(strcmp($type, "Doctor") == 0) {?>
      <h3>Test Orders</h3>
      <div id="tOrder">
        <h3>Enter Test Order<h3>
        <div>
           <form action="updat.php" method="post" id="eTestOrder">
             <input type="hidden" name="uid" value="<?php echo "$uid";?>" />
             <input type="hidden" name="section" value="enterT">
             <ul>
                 <li>Test Name: <input type="text" name="test_name" /></li>
                 <li>Test Description: <br /><textarea rows="10" cols="50" name="test_description"></textarea>
             </ul>
             <button type="submit" form="eTestOrder">Save Order</button>
           </form>
        </div>
        <h3>Send Test Order</h3>
        <div>
           <form action="updat.php" method="post" id="sTestOrder">
             <input type="hidden" name="uid" value="<?php echo "$uid";?>" />
             <input type="hidden" name="section" value="sendT" />
             <ul>
             <?php 
                foreach($tests as $test) {
                   if(strcmp($test->sent, "false") == 0) { ?>
                      <li><input type="radio" name="test" value="<?php echo "$test->id"; ?>" /> <?php echo "$test->test_name"; ?>: <?php echo "$test->test_description";?></li>
             <?php } 
                }?>
             </ul>
             <button type="submit" form="sTestOrder">Send Test</button>
           </form>
        </div>
      </div>
      <?php }
      if(strcmp($type, "Doctor") == 0 || strcmp($type, "Nurse") == 0) {?>
      <h3>Test Results</h3>
      <div style="max-height:300px; overflow:scroll">
        <ul>
        <?php
           foreach($tests as $test) {
              if(strcmp($test->sent, "true") == 0) {
                 if(strcmp($test->result, "") != 0) {
                    $link = "/wp-admin/includes/files/tests/" . $test->result; ?>
                    <li><?php echo "$test->test_name";?>: [ <a href="<?php echo $link; ?>">Link to file</a> ] <img style="height:16px;" src="/wp-admin/images/pdf.gif" /></li>
           <?php } else { ?>
                    <li>
                       <form action="updat.php" method="post" enctype="multipart/form-data"> 
                          <input type="hidden" name="uid" value="<?php echo "$uid";?>" />
                          <input type="hidden" name="section" value="fileUpload">
                          <?php echo "$test->test_name";?>: <input type="file" name="file" size="30"> <button type="submit">Upload</button></form></li>
           <?php }
             } 
          } ?>
        </ul>
      </div>
      <?php }
      if(strcmp($type, "Receptionist") == 0) {?>
      <h3>Transmit Information to Insurance Agency</h3>
      <div>
         <form action="updat.php" method="post" id="transmitIns">
            <input type="hidden" name="pid" value="<?php echo "$uid";?>" />
            <input type="hidden" name="section" value="transmitIns" />
            Transmit Info for <?php echo "$chart->first_name $chart->last_name";?>: <button type="submit" form="transmitIns">Transmit</button>
         </form>
      </div>
      <h3>Itemized Receipts</h3>
      <div id="receipts">
         <h3>Create Receipt</h3>
         <div>
            <form action="generate.php" method="post" id="genReceipt">
               <input type="hidden" name="uid" value="<?php echo "$uid";?>" />
               <input type="hidden" name="section" value="genReceipt" />
               <input type="hidden" name="patientfn" value="<?php echo "$chart->first_name";?>" />
               <input type="hidden" name="patientmi" value="<?php echo "$chart->middle_i";?>" />
               <input type="hidden" name="patientln" value="<?php echo "$chart->last_name";?>" />
               <div id="fields"></div>
               <div class="formbuttons"><input type="radio" name="status" value="paid" /> Paid <input type="radio" name="status" value="bill" /> Bill<br /><button type="button" id="addVar">Add item</button>       <button class="submitButton" type="submit" form="genReceipt">Generate Receipt</button></div>
            </form>
         </div>
         <h3>Send Patient Receipt</h3>
         <div>
            <form action="updat.php" method="post" id="sendReceipt">
               <input type="hidden" name="uid" value="<?php echo "$uid";?>" />
               <input type="hidden" name="section" value="sendReceipt" />
               <ul>
               <?php 
                 foreach($rcs as $rc) { 
                    $link = "/wp-admin/includes/files/rc/" . $rc->filename;
                    $sent = (strcmp($rc->sent, 'false') == 0) ? "Not Sent" : "Sent"; ?>
                    <li><input type="radio" name="rc" value="<?php echo "$rc->id";?>" /> Receipt: <?php echo "$rc->timestamp";?> <a href='<?php echo "$link";?>' target="_blank">View Receipt</a> [<?php echo "$sent"; ?>]</li>
              <?php 
                 }?>
             </ul>
               <button type="submit" form="sendReceipt">Send Receipt to Patient</button>
            </form>
         </div>
      </div>
      <?php }
      if(strcmp($type, "Patient") == 0 || strcmp($type, "Receptionist") == 0) {?>
      <h3>Account Balance</h3>
      <div>
         <ul>
            <li>Current Balance: $<?php echo "$chart->acct_bal"; ?></li>
         </ul>
      </div>
      <?php } ?>
    </div>
  <script>
    $(function() {
      $( "#pChart" ).accordion({
         active: false,
         collapsible: true,
         heightStyle: "content"
      });
    });
    <?php if(strcmp($type, "Doctor") == 0) {?>
    $(function() {
      $( "#tOrder" ).accordion({
         active: false,
         collapsible: true,
         heightStyle: "content"
      });
    });
    $(function() {
      $( "#diagnosis" ).accordion({
         active: false,
         collapsible: true,
         heightStyle: "content"
      });
    });
    <?php }
    if(strcmp($type, "Doctor") == 0 || strcmp($type, "Nurse") == 0) {?>
    $(function() {
      $( "#condition" ).accordion({
         active: false,
         collapsible: true,
         heightStyle: "content"
      });
    });
    <?php }
    if(strcmp($type, "Receptionist") == 0) {?>
    $(function() {
      $( "#receipts" ).accordion({
         active: false,
         collapsible: true,
         heightStyle: "content"
      });
    });
    var startingNo = 3;
    var $node = "";
    for(varCount=1;varCount<=startingNo;varCount++){
      $node += 'Item Name: <input type="text" name="name'+varCount+'" /> Price: <input type="text" name="price'+varCount+'" /><br />';
    }
    //add them to the DOM
    $('#fields').prepend($node);
    //remove a textfield    
    $('#fields').on('click', '.removeVar', function(){
      $(this).parent().remove();
      varCount--;
    });
    //add a new node
    $('#addVar').on('click', function(){
      $node = 'Item Name: <input type="text" name="name'+varCount+'" /> Price: <input type="text" name="price'+varCount+'" /><br />';
      $('#fields').append($node);
      varCount++;
    });
    <?php }
    if(strcmp($type, "Doctor") == 0 || strcmp($type, "Nurse") == 0) {?>
    $(function() {
      $( "#prescriptions" ).accordion({
         active: false,
         collapsible: true,
         heightStyle: "content"
      });
    });
    var startingNo = 3;
    var $node = "";
    for(varCount=1;varCount<=startingNo;varCount++){
      $node += 'Drug: <input type="text" name="drug'+varCount+'" /> Dosage: <input type="text" name="dosage'+varCount+'" /> Refills: <input type="text" name="refill'+varCount+'" /><br />';
    }
    //add them to the DOM
    $('#fields').prepend($node);
    //remove a textfield    
    $('#fields').on('click', '.removeVar', function(){
      $(this).parent().remove();
      varCount--;
    });
    //add a new node
    $('#addVar').on('click', function(){
      $node = 'Drug: <input type="text" name="drug'+varCount+'" /> Dosage: <input type="text" name="dosage'+varCount+'" /> Refills: <input type="text" name="refill'+varCount+'" /><br />';
      $('#fields').append($node);
      varCount++;
    });
    <?php } ?>
  </script>
  <?php 
  break;

  case 'edit': 
  $state = $chart->state;
  ?>
    <h2>Editing <?php echo "$chart->first_name $chart->last_name";?>'s Chart <input style="font-size:13px; padding:4px;"type="button" onclick=window.location.href='chart.php?uid=<?php echo "$uid";?>' value="Cancel Edit" /></h2>
    <div id="pChart">
       <?php if(strcmp($type, "Patient") == 0 || strcmp($type, "Receptionist") == 0) {?>
       <h3>Personal Information</h3>
       <div>
          <form action="updat.php" method="post" id="pInfo">
             <input type="hidden" name="uid" value="<?php echo "$uid";?>" />
             <input type="hidden" name="section" value="pInfo">
             <ul class="patientInfo">
                <li>First Name: <input name="first" type="text" value="<?php echo "$chart->first_name";?>" /></li>
                <li>MI: <input name="middle" type="text" value="<?php echo "$chart->middle_i";?>" /></li>
                <li>Last Name: <input name="last" type="text" value="<?php echo "$chart->last_name";?>" /></li>
                <li>Sex: <input type='radio' name='sex' value='Male' <?php echo (($chart->sex == 'Male') ? "checked"   : "");?> />Male <input type='radio' name='sex' value='Female' <?php echo (($chart->sex == 'Female') ? "checked"   : "");?> />Female</li>
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
      <?php }
      if(strcmp($type, "Doctor") == 0 || strcmp($type, "Nurse") == 0) {?>
      <h3>Medical Information</h3>
      <div>
        <form action="updat.php" method="post" id="mInfo">
             <input type="hidden" name="uid" value="<?php echo "$uid";?>" />
             <input type="hidden" name="section" value="mInfo">
             <div>
        <h3>Basic Info</h3>
         <?php
            $height = explode(",",$chart->height);?>
         <span class="iLabel">Height:</span> <input name="heightF" type="text" value="<?php echo "$height[0]";?>" size=5 />&#39; <input name="heightI" type="text" value="<?php echo "$height[1]";?>" size=5 />&#34;<br />
         <span class="iLabel">Weight:</span> <input name="weight" type="text" value="<?php echo "$chart->weight";?>" size=5 />lbs<br />
         
         <h3>Past Ailments</h3>
         <?php
            $ails = explode(",", $chart->ails);
         ?>
         <div class="column">
            <input type="checkbox" name="ail[]" value="1" <?php if(in_array("1", $ails)) echo 'checked';?>/> AIDS/HIV Positive<br />
            <input type="checkbox" name="ail[]" value="2" <?php if(in_array("2", $ails)) echo 'checked';?>/> Alzheimer's Disease<br />
            <input type="checkbox" name="ail[]" value="3" <?php if(in_array("3", $ails)) echo 'checked';?>/> Anaphylais<br />
            <input type="checkbox" name="ail[]" value="4" <?php if(in_array("4", $ails)) echo 'checked';?>/> Anemia<br />
            <input type="checkbox" name="ail[]" value="5" <?php if(in_array("5", $ails)) echo 'checked';?>/> Angina<br />
            <input type="checkbox" name="ail[]" value="6" <?php if(in_array("6", $ails)) echo 'checked';?>/> Arthritis/Gout<br />
            <input type="checkbox" name="ail[]" value="7" <?php if(in_array("7", $ails)) echo 'checked';?>/> Artificial Heart Valve<br />
            <input type="checkbox" name="ail[]" value="8" <?php if(in_array("8", $ails)) echo 'checked';?>/> Artificial Joint<br />
            <input type="checkbox" name="ail[]" value="9" <?php if(in_array("9", $ails)) echo 'checked';?>/> Asthma<br />
            <input type="checkbox" name="ail[]" value="10" <?php if(in_array("10", $ails)) echo 'checked';?>/> Blood Disease<br />
            <input type="checkbox" name="ail[]" value="11" <?php if(in_array("11", $ails)) echo 'checked';?>/> Blood Transfusion<br />
            <input type="checkbox" name="ail[]" value="12" <?php if(in_array("12", $ails)) echo 'checked';?>/> Breathing Problem<br />
            <input type="checkbox" name="ail[]" value="13" <?php if(in_array("13", $ails)) echo 'checked';?>/> Bruise Easily<br />
            <input type="checkbox" name="ail[]" value="14" <?php if(in_array("14", $ails)) echo 'checked';?>/> Cancer<br />
            <input type="checkbox" name="ail[]" value="15" <?php if(in_array("15", $ails)) echo 'checked';?>/> Chemotherapy<br />
            <input type="checkbox" name="ail[]" value="16" <?php if(in_array("16", $ails)) echo 'checked';?>/> Chest Pains<br />
            <input type="checkbox" name="ail[]" value="17" <?php if(in_array("17", $ails)) echo 'checked';?>/> Cold Sores/Fever Blisters<br />
            <input type="checkbox" name="ail[]" value="18" <?php if(in_array("18", $ails)) echo 'checked';?>/> Congenital Heart Disorder<br />
            <input type="checkbox" name="ail[]" value="19" <?php if(in_array("19", $ails)) echo 'checked';?>/> Convulsions<br />
        </div>
        <div class="column">
            <input type="checkbox" name="ail[]" value="20" <?php if(in_array("20", $ails)) echo 'checked';?>/> Cortisone Medicine<br />
            <input type="checkbox" name="ail[]" value="21" <?php if(in_array("21", $ails)) echo 'checked';?>/> Diabetes<br />
            <input type="checkbox" name="ail[]" value="22" <?php if(in_array("22", $ails)) echo 'checked';?>/> Drug Addiction<br />
            <input type="checkbox" name="ail[]" value="23" <?php if(in_array("23", $ails)) echo 'checked';?>/> Easily Winded<br />
            <input type="checkbox" name="ail[]" value="24" <?php if(in_array("24", $ails)) echo 'checked';?>/> Emphysema<br />
            <input type="checkbox" name="ail[]" value="25" <?php if(in_array("25", $ails)) echo 'checked';?>/> Epilepsy or Seizures<br />
            <input type="checkbox" name="ail[]" value="26" <?php if(in_array("26", $ails)) echo 'checked';?>/> Excessive Bleeding<br />
            <input type="checkbox" name="ail[]" value="27" <?php if(in_array("27", $ails)) echo 'checked';?>/> Excessive Thirst<br />
            <input type="checkbox" name="ail[]" value="28" <?php if(in_array("28", $ails)) echo 'checked';?>/> Fainting Spells/Dizziness<br />
            <input type="checkbox" name="ail[]" value="29" <?php if(in_array("29", $ails)) echo 'checked';?>/> Frequent Cough<br />
            <input type="checkbox" name="ail[]" value="30" <?php if(in_array("30", $ails)) echo 'checked';?>/> Frequent Diarrhea<br />
            <input type="checkbox" name="ail[]" value="31" <?php if(in_array("31", $ails)) echo 'checked';?>/> Frequent Headaches<br />
            <input type="checkbox" name="ail[]" value="32" <?php if(in_array("32", $ails)) echo 'checked';?>/> Genital Herpes<br />
            <input type="checkbox" name="ail[]" value="33" <?php if(in_array("33", $ails)) echo 'checked';?>/> Glaucoma<br />
            <input type="checkbox" name="ail[]" value="34" <?php if(in_array("34", $ails)) echo 'checked';?>/> Hay Fever<br />
            <input type="checkbox" name="ail[]" value="35" <?php if(in_array("35", $ails)) echo 'checked';?>/> Heart Attack/Failure<br />
            <input type="checkbox" name="ail[]" value="36" <?php if(in_array("36", $ails)) echo 'checked';?>/> Heart Murmur<br />
            <input type="checkbox" name="ail[]" value="37" <?php if(in_array("37", $ails)) echo 'checked';?>/> Heart Pace Maker<br />
            <input type="checkbox" name="ail[]" value="38" <?php if(in_array("38", $ails)) echo 'checked';?>/> Heart Trouble/Disease<br />
        </div>
        <div class="column">
            <input type="checkbox" name="ail[]" value="39" <?php if(in_array("39", $ails)) echo 'checked';?>/> Hemophilia<br />
            <input type="checkbox" name="ail[]" value="40" <?php if(in_array("40", $ails)) echo 'checked';?>/> Hepatitis A<br />
            <input type="checkbox" name="ail[]" value="41" <?php if(in_array("41", $ails)) echo 'checked';?>/> Hepatitis B or C<br />
            <input type="checkbox" name="ail[]" value="42" <?php if(in_array("42", $ails)) echo 'checked';?>/> Herpes<br />
            <input type="checkbox" name="ail[]" value="43" <?php if(in_array("43", $ails)) echo 'checked';?>/> High Blood Pressure<br />
            <input type="checkbox" name="ail[]" value="44" <?php if(in_array("44", $ails)) echo 'checked';?>/> Hives/Rash<br />
            <input type="checkbox" name="ail[]" value="45" <?php if(in_array("45", $ails)) echo 'checked';?>/> Hypoglycemia<br />
            <input type="checkbox" name="ail[]" value="46" <?php if(in_array("46", $ails)) echo 'checked';?>/> Irregular Heartbeat<br />
            <input type="checkbox" name="ail[]" value="47" <?php if(in_array("47", $ails)) echo 'checked';?>/> Kidney Problems<br />
            <input type="checkbox" name="ail[]" value="48" <?php if(in_array("48", $ails)) echo 'checked';?>/> Leukemia<br />
            <input type="checkbox" name="ail[]" value="49" <?php if(in_array("49", $ails)) echo 'checked';?>/> Liver Disease<br />
            <input type="checkbox" name="ail[]" value="50" <?php if(in_array("50", $ails)) echo 'checked';?>/> Low Blood Pressure<br />
            <input type="checkbox" name="ail[]" value="51" <?php if(in_array("51", $ails)) echo 'checked';?>/> Lung Disease<br />
            <input type="checkbox" name="ail[]" value="52" <?php if(in_array("52", $ails)) echo 'checked';?>/> Mitral Valve Prolapse<br />
            <input type="checkbox" name="ail[]" value="53" <?php if(in_array("53", $ails)) echo 'checked';?>/> Pain in Jaw Joints<br />
            <input type="checkbox" name="ail[]" value="54" <?php if(in_array("54", $ails)) echo 'checked';?>/> Parathyroid Disease<br />
            <input type="checkbox" name="ail[]" value="55" <?php if(in_array("55", $ails)) echo 'checked';?>/> Psychiatric Care<br />
            <input type="checkbox" name="ail[]" value="56" <?php if(in_array("56", $ails)) echo 'checked';?>/> Radiation Treatments<br />
            <input type="checkbox" name="ail[]" value="57" <?php if(in_array("57", $ails)) echo 'checked';?>/> Recent Weight Loss<br />
        </div>
        <div class="column">
            <input type="checkbox" name="ail[]" value="58" <?php if(in_array("58", $ails)) echo 'checked';?>/> Renal Dialysis<br />
            <input type="checkbox" name="ail[]" value="59" <?php if(in_array("59", $ails)) echo 'checked';?>/> Rheumatic Fever<br />
            <input type="checkbox" name="ail[]" value="60" <?php if(in_array("60", $ails)) echo 'checked';?>/> Rheumatism<br />
            <input type="checkbox" name="ail[]" value="61" <?php if(in_array("61", $ails)) echo 'checked';?>/> Scarlet Fever<br />
            <input type="checkbox" name="ail[]" value="62" <?php if(in_array("62", $ails)) echo 'checked';?>/> Shingles<br />
            <input type="checkbox" name="ail[]" value="63" <?php if(in_array("63", $ails)) echo 'checked';?>/> Sickle Cell Disease<br />
            <input type="checkbox" name="ail[]" value="64" <?php if(in_array("64", $ails)) echo 'checked';?>/> Sinus Trouble<br />
            <input type="checkbox" name="ail[]" value="65" <?php if(in_array("65", $ails)) echo 'checked';?>/> Spina Bifida<br />
            <input type="checkbox" name="ail[]" value="66" <?php if(in_array("66", $ails)) echo 'checked';?>/> Stomach/Intestinal Disease<br />
            <input type="checkbox" name="ail[]" value="67" <?php if(in_array("67", $ails)) echo 'checked';?>/> Stroke<br />
            <input type="checkbox" name="ail[]" value="68" <?php if(in_array("68", $ails)) echo 'checked';?>/> Swelling of Limbs<br />
            <input type="checkbox" name="ail[]" value="69" <?php if(in_array("69", $ails)) echo 'checked';?>/> Thyroid Disease<br />
            <input type="checkbox" name="ail[]" value="70" <?php if(in_array("70", $ails)) echo 'checked';?>/> Tonsillitis<br />
            <input type="checkbox" name="ail[]" value="71" <?php if(in_array("71", $ails)) echo 'checked';?>/> Tuberculosis<br />
            <input type="checkbox" name="ail[]" value="72" <?php if(in_array("72", $ails)) echo 'checked';?>/> Tumors or Growths<br />
            <input type="checkbox" name="ail[]" value="73" <?php if(in_array("73", $ails)) echo 'checked';?>/> Ulcers<br />
            <input type="checkbox" name="ail[]" value="74" <?php if(in_array("74", $ails)) echo 'checked';?>/> Venereal Disease<br />
            <input type="checkbox" name="ail[]" value="75" <?php if(in_array("75", $ails)) echo 'checked';?>/> Yellow Jaundice<br />
        </div>
        <div style="clear:both"></div>
           <button type="submit" form="mInfo">Save Changes</button>
        </form>
      </div></div>
      <?php }
      if(strcmp($type, "Patient") == 0 || strcmp($type, "Receptionist") == 0) {?>
      <h3>Insurance Information</h3>
      <div>
        <form action="updat.php" method="post" id="iInfo">
             <input type="hidden" name="uid" value="<?php echo "$uid";?>" />
             <input type="hidden" name="section" value="iInfo">
             <ul class="insuranceInfo">
               <h4>Insurance Company</h4>
               <li>Company Name: <input name="name" type="text" value="<?php echo "$chart->ins_company";?>" /></li>
               <li>Address: <input name="address" type="text" value="<?php echo "$chart->ins_address";?>" /></li>
               <li>City: <input name="city" type="text" value="<?php echo "$chart->ins_city";?>" /></li>
               <li>State: <input name="state" type="text" value="<?php echo "$chart->ins_state";?>" /></li> 
               <li>Zip: <input name="zip" type="text" value="<?php echo "$chart->ins_zip";?>" /></li>
               <li>Phone: <input name="phone" type="text" value="<?php echo "$chart->ins_phone";?>" /></li>
               <h4>Policy</h4>
               <li>Policyholder's Name: <input name="phname" type="text" value="<?php echo "$chart->ins_phname";?>" /></li>
               <li>Policyholder's DOB: <input name="phdob" type="text" value="<?php echo "$chart->ins_phdob";?>" /></li>
               <li>Policyholder's Phone: <input name="phphone" type="text" value="<?php echo "$chart->ins_phphone";?>" /></li>
               <li>Policy Number: <input name="number" type="text" value="<?php echo "$chart->ins_number";?>" /></li>
               <li>Group/Plan Number: <input name="gnumber" type="text" value="<?php echo "$chart->ins_gnumber";?>" /></li>
              </ul>
           <button type="submit" form="iInfo">Save Changes</button>
        </form>
      </div>
      <?php } ?>
    </div>


  <script>
    $(function() {
      $( "#pChart" ).accordion({
         active: false,
         collapsible: true,
         heightStyle: "content"
      });
    });
  </script>
  <?php 
  break;

  default:
  ;
  }
  //wp_dashboard(); ?>

  </div><!-- wrap -->
  <?php require(ABSPATH . 'wp-admin/admin-footer.php'); ?>