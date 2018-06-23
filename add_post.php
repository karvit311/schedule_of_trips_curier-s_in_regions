<?php
	include ('conn.php');
	if((isset($_POST['region'])  && isset(($_POST['curier']))) && isset($_POST['date_depart'])) {	
        $date_depart_res = $_POST['date_depart'];//06/20/2018 6:13 AM
        $date_depart_res = strtotime("$date_depart_res");
        $date_depart_res = date("m/d/Y H:i:s", $date_depart_res);        
        //время в пути: 375 minuts
        $date_depart = strtotime("$date_depart_res");
        $time_in_road = $_POST['time_in_road']; //375 minuts
        // время прибытия: 06/15/2018 23:38:001
        $total = $time_in_road*2;
        $minutes_to_add = $total;
        $time = new DateTime($date_depart_res); 
        $time->add(new DateInterval('PT' . $total . 'M'));
        $stamp_total_time_in_road = $time->format('m/d/Y H:i:s');

        $region = addslashes($_POST['region']);
        $gPlaceholderName = $conn->prepare("SELECT * FROM `region` WHERE `name` = ?");
        $gPlaceholderName->bind_param("s", $region);
        $gPlaceholderName->execute();
        $result = $gPlaceholderName->get_result();
        while ($row = $result->fetch_assoc()) {
            $region_id = $row['id'];
        }
        $curier = addslashes($_POST['curier']);
        $gPlaceholderName = $conn->prepare("SELECT * FROM `curier` WHERE `name` = ?");
        $gPlaceholderName->bind_param("s", $curier);
        $gPlaceholderName->execute();
        $result = $gPlaceholderName->get_result();
        while ($row = $result->fetch_assoc()) {
            $curier_id = $row['id'];

        }
        $res = mysqli_query($conn,"select * from `schedule` WHERE  date_depart BETWEEN '$date_depart_res' and '$stamp_total_time_in_road' or  date_arrival BETWEEN '$date_depart_res' and '$stamp_total_time_in_road'  ");
        if((mysqli_num_rows($res)>0) ){
            echo 'yse';
        }else{ 
    		mysqli_query($conn,"insert into `schedule` (`region_id`,`curier_id`,`date_depart`,`time_in_road`,`date_arrival`) values ('$region_id','$curier_id','$date_depart_res','$time_in_road','$stamp_total_time_in_road')") or die(mysqli_error());

            echo '1';
        }
	}
	if(isset($_POST['res'])){
		$query=mysqli_query($conn,"select * from `schedule` order by `date_depart` asc") or die(mysqli_error());
		while($row=mysqli_fetch_array($query)){
		    $region_id = $row['region_id'];
            $curier_id = $row['curier_id'];
            $date_depart_res = $row['date_depart'];
            $date_depart = strtotime($date_depart_res);
            // время прибытия: 2018-06-15 06:13
            $minutes_to_add = $row['time_in_road'];
            $time = new DateTime(date('Y-m-d H:i', $date_depart));
            $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
            $stamp = $time->format('m/d/Y H:i');
            // время в пути: 0 дней, 14 часов, 50 минут
            $minutes = $minutes_to_add;
            $zero    = new DateTime('@0');
            $offset  = new DateTime('@' . $minutes * 60);
            $diff    = $zero->diff($offset);
            $time_in_road = $diff->format('%a дней, %h часов, %i минут');

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
                    echo 'Date depart: '.$date_depart_res.'<br>';
                    echo 'Time in road: '.$time_in_road.'<br>';
                    echo 'Time arrival: '.$stamp.'<br>';
                    echo '</li></ul>';
                }
            }
		}
	}	
?>