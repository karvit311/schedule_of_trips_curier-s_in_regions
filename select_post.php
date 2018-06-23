<?php
	include ('conn.php');
	if(isset($_POST['date1']) && (isset($_POST['date2']))){
        $date1 = $_POST['date1'];
        $date2 = $_POST['date2'];
        $from = $_POST['date1'];//06/20/2018 6:13 AM
        $from = strtotime("$from");
        $from = date("m/d/Y H:i:s", $from);
        $to = $_POST['date2'];//06/20/2018 6:13 AM
        $to = strtotime("$to");
        $to = date("m/d/Y H:i:s", $to);    
        $gPlaceholderName = $conn->prepare("SELECT * FROM `schedule` WHERE `date_depart` BETWEEN ? and ? order by `date_depart` asc ");
        $gPlaceholderName->bind_param("ss", $from,$to);
        $gPlaceholderName->execute();
        $result = $gPlaceholderName->get_result();
        while ($row = $result->fetch_assoc()) {
            $region_id = $row['region_id'];
            $curier_id = $row['curier_id'];
            $date_depart = $row['date_depart'];
            $date_arrival = $row['date_arrival'];
            $region_name = $conn->prepare("SELECT * FROM `region` WHERE `id` = ?");
            $region_name->bind_param("s", $region_id);
            $region_name->execute();
            $result_region_name = $region_name->get_result();
            while ($row = $result_region_name->fetch_assoc()) {
                $region_name_final = $row['name'];
                $curier_name = $conn->prepare("SELECT * FROM `curier` WHERE `id` = ?");
                $curier_name->bind_param("s", $curier_id);
                $curier_name->execute();
                $result_curier_name = $curier_name->get_result();
                while ($row = $result_curier_name->fetch_assoc()) {
                    $curier_name_final = $row['name'];
                    echo '<ul><li><br>';
                    echo 'Region: '.$region_name_final.'<br>';
                    echo 'Curier: '.$curier_name_final.'<br>';
                    echo 'Date depart: '.$date_depart.'<br>';
                    echo 'Arrival: '.$date_arrival.'<br>';
                    echo '</li></ul>';
                }
            }
        }
    }
?>