<?php
require('fpdf.php');
date_default_timezone_set('America/Cancun');
$date = date("D, F j, Y, g:i a");
$section = $_POST['section'];
switch($section) {
   case "genReceipt":
      $title = "EHIS Itemized Receipt";
      $total = 0.00;
      $uid = $_POST['uid'];
      $status = $_POST['status'];
      $filename = strtolower($_POST['patientln']) . strtolower(substr($_POST['patientfn'], 0, 2)) . strtolower($_POST['patientmi']) . date("YmdGi") . ".pdf";
      if($_POST['name1']) {
        $item1 = $_POST['name1'] . ": $" . $_POST['price1'];
        $total += floatval($_POST['price1']);
      }
      if($_POST['name2']) {
        $item2 = $_POST['name2'] . ": $" . $_POST['price2'];
        $total += floatval($_POST['price2']);
      }
      if($_POST['name3']) {
        $item3 = $_POST['name3'] . ": $" . $_POST['price3'];
        $total += floatval($_POST['price3']);
      }
      if($_POST['name4']) {
        $item4 = $_POST['name4'] . ": $" . $_POST['price4'];
        $total += floatval($_POST['price4']);
      }
      if($_POST['name5']) {
        $item5 = $_POST['name5'] . ": $" . $_POST['price5'];
        $total += floatval($_POST['price5']);
      }
      if($_POST['name6']) {
        $item6 = $_POST['name6'] . ": $" . $_POST['price6'];
        $total += floatval($_POST['price6']);
      }
      if($_POST['name7']) {
        $item7 = $_POST['name7'] . ": $" . $_POST['price7'];
        $total += floatval($_POST['price7']);
      }
      if($_POST['name8']) {
        $item8 = $_POST['name8'] . ": $" . $_POST['price8'];
        $total += floatval($_POST['price8']);
      }
      if($_POST['name9']) {
        $item9 = $_POST['name9'] . ": $" . $_POST['price9'];
        $total += floatval($_POST['price9']);
      }
      if($_POST['name10']) {
        $item10 = $_POST['name10'] . ": $" . $_POST['price10'];
        $total += floatval($_POST['price10']);
      }
      $dTotal = "Total: $" . $total;
      $amtOwed = "$" . $total;
      if(strcmp($status, "paid") == 0) {
         $amtOwed = "$0.00";
      }
      $pdf = new FPDF();
      $pdf->AddPage();
      $pdf->SetFont('Arial', 'B', 16);
      $pdf->Cell(0, 10, $title, 0, 1, 'C');
      $pdf->Cell(0, 10, $date, 0, 1, 'C');
      $pdf->Cell(0, 10, ($_POST['patientfn'] . " " . $_POST['patientmi'] . ". " . $_POST['patientln']), 0, 1, 'C');
      $pdf->Ln();
      for ($i = 1; $i <= 5; $i++) {
         if(isset(${"item" . $i})) {
            $pdf->Cell(0, 10, ${"item" . $i}, 0, 1, 'R');
         }
      }
      $pdf->Cell(0, 10, "-----------------------------------------------", 0, 1, 'R');
      $pdf->Cell(0, 10, $dTotal, 0, 1, 'R');
      $pdf->Cell(0, 10, ("Status: " . $status), 0, 1, 'R');
      $pdf->Cell(0, 10, ("Amount Owed: " . $amtOwed), 0, 1, 'R');
      $file = $pdf->Output('includes/files/rc/'.$filename, 'F');

      require_once('./admin.php');

      global $wpdb;
      $curtime = date("Y-m-d H:i:s");
      $queryRC = "INSERT INTO wp_rc (user_id, filename, timestamp, sent, status) VALUES ('$uid', '$filename', '$curtime', 'false', '$status')";
      $wpdb->query($queryRC);

      if(strcmp($status, "bill") == 0) {
        $queryBal = "Select acct_bal from wp_userchart where user_id = '$uid'";
        $curbal = $wpdb->get_var($queryBal);
        $curbal += $total;
        $upQuery = "UPDATE wp_userchart SET acct_bal='$curbal' where user_id = '$uid'";
        $wpdb->query($upQuery);
      }
      $stat = "rec";
      break;

   case "enterPersc":
      $title = "EHIS Prescription";
      $uid = $_POST['uid'];
      $emp = $_POST['emp'];
      $filename = strtolower($_POST['patientln']) . strtolower(substr($_POST['patientfn'], 0, 2)) . strtolower($_POST['patientmi']) . date("YmdGi") . ".pdf";
      if($_POST['drug1']) {
        $item1 = "Drug: " . $_POST['drug1'] . ", Dosage: " . $_POST['dosage1'] . ", Refills: " . $_POST['refill1'];
      }
      if($_POST['drug2']) {
        $item1 = "Drug: " . $_POST['drug2'] . ", Dosage: " . $_POST['dosage2'] . ", Refills: " . $_POST['refill2'];
      }
      if($_POST['drug3']) {
        $item1 = "Drug: " . $_POST['drug3'] . ", Dosage: " . $_POST['dosage3'] . ", Refills: " . $_POST['refill3'];
      }
      if($_POST['drug4']) {
        $item1 = "Drug: " . $_POST['drug4'] . ", Dosage: " . $_POST['dosage4'] . ", Refills: " . $_POST['refill4'];
      }
      if($_POST['drug5']) {
        $item1 = "Drug: " . $_POST['drug5'] . ", Dosage: " . $_POST['dosage5'] . ", Refills: " . $_POST['refill5'];
      }
      if($_POST['drug6']) {
        $item1 = "Drug: " . $_POST['drug6'] . ", Dosage: " . $_POST['dosage6'] . ", Refills: " . $_POST['refill6'];
      }
      if($_POST['drug7']) {
        $item1 = "Drug: " . $_POST['drug7'] . ", Dosage: " . $_POST['dosage7'] . ", Refills: " . $_POST['refill7'];
      }
      if($_POST['drug8']) {
        $item1 = "Drug: " . $_POST['drug8'] . ", Dosage: " . $_POST['dosage8'] . ", Refills: " . $_POST['refill8'];
      }
      if($_POST['drug9']) {
        $item1 = "Drug: " . $_POST['drug9'] . ", Dosage: " . $_POST['dosage9'] . ", Refills: " . $_POST['refill9'];
      }
      if($_POST['drug10']) {
        $item1 = "Drug: " . $_POST['drug10'] . ", Dosage: " . $_POST['dosage10'] . ", Refills: " . $_POST['refill10'];
      }
      
      $pdf = new FPDF();
      $pdf->AddPage();
      $pdf->SetFont('Arial', 'B', 16);
      $pdf->Cell(0, 10, $title, 0, 1, 'C');
      $pdf->Cell(0, 10, $date, 0, 1, 'C');
      $pdf->Cell(0, 10, ("Issued By: " . $emp), 0, 1, 'C');
      $pdf->Cell(0, 10, ($_POST['patientfn'] . " " . $_POST['patientmi'] . ". " . $_POST['patientln']), 0, 1, 'C');
      $pdf->Ln();
      for ($i = 1; $i <= 5; $i++) {
         if(isset(${"item" . $i})) {
            $pdf->Cell(0, 10, ${"item" . $i}, 0, 1, 'C');
         }
      }
      $file = $pdf->Output('includes/files/percs/'.$filename, 'F');

      require_once('./admin.php');

      global $wpdb;
      $curtime = date("Y-m-d H:i:s");
      $queryRC = "INSERT INTO wp_percs (user_id, filename, timestamp) VALUES ('$uid', '$filename', '$curtime')";
      $wpdb->query($queryRC);
      $stat = "percs";
      break;
   
   default:
   ;
}

?>
<script type="text/javascript">
   window.location.href = 'http://ehisys.org/wp-admin/chart.php?uid=<?php echo "$uid";?>&<?php echo "$stat";?>=gen';
</script>