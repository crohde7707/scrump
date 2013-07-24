
<?php

require_once('./admin.php');
wp_enqueue_script('jquery-ui-autocomplete', '', array('jquery-ui-widget', 'jquery-ui-position'), '1.8.6');


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




</body>
</html>