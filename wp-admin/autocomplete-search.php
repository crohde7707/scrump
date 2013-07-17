
<?php

require_once('./admin.php');
wp_enqueue_script('jquery-ui-autocomplete', '', array('jquery-ui-widget', 'jquery-ui-position'), '1.8.6');
global $wpdb;



?>
<head>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/vader/jquery-ui.css" type="text/css" rel="stylesheet" />

<html lang="en">

<script>
    jQuery(document).ready(function() {
    $( "#site_role" ).buttonset();
    $( "#locked" ).buttonset();


    });
</script>

<script>
    	jQuery(document).ready(function(){
			$('#emailsearch').autocomplete({source:'search.php', minLength:1});
		});

</script>

<script>
  jQuery(document).ready(function() {
    $( "#dialog" ).dialog({
      width: 600,
      height: 500,
      modal : true,
      autoOpen: false,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
    });

    $( "#opener" ).ready(function() {
      $( "#dialog" ).dialog( "open" );
       
    });
  });
</script>

  
</head>

<body>


<form action="manageusers.php" method ="POST" >
Email:<input id='emailsearch' name="email" type="text"  size="35"/> 
<input type="submit" name='go' value="EDIT">
</form>

<?php 
/*User has pressed the EDIT button checks for valid info
returns to main page if user does not exit or input was blank*/
if (isset($_POST['go']) && !empty($_POST['email'])){ 
    $email = $_POST["email"];
    $query = "select user_nicename, site_role, locked from wp_users where user_email = '$email'" ;
    $uinfo = $wpdb->get_row($query);  
    $role = $uinfo-> site_role;
    $locked =  $uinfo->locked;
    $username = $uinfo->user_nicename;
    if  (!$uinfo){
        echo "<script>
        location.reload()
        </script>";      
    }
        
    
?>


<!--Div for dialog Box once open display current user statuses-->
<div id="dialog" title="<?php echo 'Editing User '. $username; ?>">
 <p>All form fields are required.</p>
<span class="ui-helper-hidden-accessible"><input type="text"/></span>
  <form method="post" action="manageusers.php" >
    <fieldset>
        <label for="role">Site Role</label><br>
        <div id="site_role">
            <input type="radio" id="radio1" name="group1" value="Admin" <?php if (strcmp($role, "Admin") == 0) echo "checked"; ?> ><label for="radio1">Admin</label>
            <input type="radio" id="radio2" name="group1" value="Developer" <?php if (strcmp($role, "Developer") == 0) echo "checked"; ?> > <label for="radio2">Developer</label>
            <input type="radio" id="radio3" name="group1" value="Manager" <?php if (strcmp($role, "Manager") == 0) echo "checked"; ?> > <label for="radio3">Manager</label>
        </div>
    </fieldset>
    <fieldset>
        <label for="status">Status</label><br>
        <div id="locked">
            <input type="radio" id="radio4" name="group2" value="1" <?php if ($locked == 1) echo "checked"; ?> ><label for="radio4">Locked</label>
            <input type="radio" id="radio5" name="group2" value="0" <?php if ($locked == 0) echo "checked"; ?>><label for="radio5">Unlocked</label>
        </div>
        <input type="hidden" name="email" value= <?php echo $email; ?>>
        <input type="submit" name ="save" value="Save"> 
    </fieldset>
  </form>
</div>


<?php }/*Once the user hits the save button update all fields*/ 
if (isset($_POST['save'])) {

    $newrole = $_POST['group1'];
    $newlocked = $_POST['group2'];
    $email =$_POST['email'];
    echo "Saved!";
    
    
    
    $qu = "UPDATE wp_users SET site_role='$newrole', locked='$newlocked' WHERE user_email = '$email'";
    $wpdb->query($qu);
    
    }
?>





</body>
</html>