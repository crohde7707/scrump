
<?php

require_once('./admin.php');
wp_enqueue_script('jquery-ui-autocomplete', '', array('jquery-ui-widget', 'jquery-ui-position'), '1.8.6');
global $wpdb;

$pid = $_GET['pid'];

?>
<head>


<html lang="en">


<script>
    	jQuery(document).ready(function(){
			$('#emailsearch').autocomplete({source:'search.php', minLength:1});
		});

</script>


  
</head>

<body>


<form action="listmembers.php?pid=<?php echo $pid;?>" method ="POST" >
    Add Member<input id='emailsearch' name="email" type="text"  size="35"/> 
    <input type="submit" name='add' value="Add">
</form>




<?php 
/*This can be converted into a switch statement*/
/*Refactor into updat if time allows*/
/*Could Use some code Reuse another time*/
if (isset($_POST['add'])) {

        $email = $_POST["email"];
        $query = "select ID from wp_users where user_email = '$email'" ;
        $uinfo = $wpdb->get_row($query);  
        $ID = $uinfo-> ID;
    
        if  (!$uinfo){  
             echo "<p style='color:red;font-size:14px'>No User Found</p>";
        } else {
        
            $query = "SELECT * FROM wp_roles WHERE user_ID = '$ID' AND  proj_ID ='$pid'" ;
            $uinfo = $wpdb->get_row($query);
            
            if  ($uinfo){
                echo "<p style='color:red;font-size:14px'>User is Already a Member</p>";
            } else {
            
                $qu = "INSERT INTO wp_roles(proj_ID, user_ID, role) values($pid, $ID, 'Member')";
                $wpdb->query($qu);
                echo "<p style='color:blue;font-size:14px'> ADDED! </p>";
            }
        }
}

if (isset($_POST['remove'])) {

        $email = $_POST["email"];
        $query = "select ID from wp_users where user_email = '$email'" ;
        $uinfo = $wpdb->get_row($query);  
        $ID = $uinfo-> ID;
    
    
        $query = "DELETE FROM wp_roles WHERE user_ID = '$ID' AND  proj_ID ='$pid'" ;
        $uinfo = $wpdb->query($query);
        
        if  ($uinfo){
            echo "<p style='color:blue;font-size:14px'>Member has been Deleted</p>";
        } else {
            echo "<p style='color:red;font-size:14px'> No User Found </p>";
        }
    }
    
if (isset($_POST['changeRole'])) {

        $email = $_POST["email"];
        $query = "select ID from wp_users where user_email = '$email'" ;
        $uinfo = $wpdb->get_row($query);  
        $ID = $uinfo-> ID;
    
        $query = "SELECT role FROM wp_roles WHERE user_ID = '$ID' AND  proj_ID ='$pid'";
        $uinfo = $wpdb->get_row($query);      
        $role = $uinfo->role;
        
        if(strcmp($role, "Member") == 0 ){
            $query = "UPDATE wp_roles SET role = 'Project Owner' WHERE user_ID = '$ID' AND  proj_ID ='$pid'" ;
            $uinfo = $wpdb->query($query);  
        } else {
            $query = "UPDATE wp_roles SET role = 'Member' WHERE user_ID = '$ID' AND  proj_ID ='$pid'" ;
            $uinfo = $wpdb->query($query);              
        }
        
        if  ($uinfo){
            echo "<p style='color:blue;font-size:14px'>Member Role has Changed</p>";
        } else {
            echo "<p style='color:red;font-size:14px'> No User Found </p>";
        }
    }
    
?>





</body>
</html>