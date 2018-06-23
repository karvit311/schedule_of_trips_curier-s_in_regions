<?php
	include ('conn.php');
	if((isset($_POST['new_region'])) ){	
        $new_region = addslashes($_POST['new_region']);
        $result = $conn->query("SELECT * FROM region WHERE name = '$new_region'");
		if (!$result) {
			die($mysqli->error);
		}
		if ($result->num_rows == 0) {
			mysqli_query($conn,"insert into `region` (`name`) values ('$new_region')") or die(mysqli_error());
			echo '1';
		}
	}
?>		
	
