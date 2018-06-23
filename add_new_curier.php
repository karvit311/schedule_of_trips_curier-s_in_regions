<?php
	include ('conn.php');
	if((isset($_POST['new_curier'])) ){	
        $new_curier = addslashes($_POST['new_curier']);
        $result = $conn->query("SELECT * FROM curier WHERE name = '$new_curier'");
		if (!$result) {
			die($mysqli->error);
		}
		if ($result->num_rows == 0) {
			mysqli_query($conn,"insert into `curier` (`name`) values ('$new_curier')" ) or die(mysqli_error());
			echo '1';
	    }
	}
?>		
	
