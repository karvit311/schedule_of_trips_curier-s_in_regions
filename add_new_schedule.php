<?php include ('conn.php'); ?>
<!DOCTYPE html>
<html lang = "en">
    <head>
    	<meta charset = "UTF-8" name = "viewport" content = "width=device-width, initial-scale=1"/>
    	<title>Inserting Data into MySQL Database using PHP, AJAX, JQuery</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/aja/x/libs/moment.js/2.9.0/moment-with-locales.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/src/js/bootstrap-datetimepicker.js"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/a549aa8780dbda16f6cff545aeabc3d71073911e/build/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
        <script src="bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"></script>
    </head>
    <body>
    	<h2 style="margin: 0 auto;
        width: 500px;">Добавить новую поездку</h2>
    	<div  id ="post_form">
            <ul id="add_new_curier_or_region"> 
                <li>
                    <form method="post" >   
                        <br>
                        <input type="text" id="new_curier"><br>
                        <button type ="button" id="add_new_curier">Добавить нового курьера</button>
                    </form> 
                </li>
                <li>
                    <form method="post" >   
                        <br>
                        <input type="text" id="new_region"><br>
                        <button type ="button"  id="add_new_region">Добавить новый регион доставки</button>
                    </form> 
                    <br> 
                </li>
            </ul>
            <?php
            $query_region=mysqli_query($conn,"select * from `region` order by `id` desc") or die(mysqli_error());
            $query_curier=mysqli_query($conn,"select * from `curier` order by `id` desc") or die(mysqli_error());?>
    		<form method="post" id="add_new_schedule_form">	
                <br>
                <label>Регион:</label>
                <select id="region" name="region">
                    <?php while($row=mysqli_fetch_array($query_region)){?>  
                        <option name="<?php echo $row['name']?>" id="<?php echo $row['name']?>"><?php echo $row['name']?></option>
                    <?php }?>
                </select>
                <br>
                <label>Курьер:</label>
                <select id="curier" name="curier">
                    <?php while($row=mysqli_fetch_array($query_curier)){?>  
                        <option name="<?php echo $row['name']?>" id="<?php echo $row['name']?>"><?php echo $row['name']?></option>
                    <?php }?>
                </select><br>
                <label>Дата:</label>
                <div class="container">
                    <div class="row">
                        <div class='col-sm-6'>
                            <div class="form-group">
                                <div class='input-group date' id='datetimepicker1'  style="width: 50%;">
                                    <input type='text' class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <script type="text/javascript">
                $(document).ready(function(){
                    $('#datetimepicker1').datetimepicker();
                });
                </script>
                <div id="time_in_road"></div>
    			<button type ="button"  id="add_post">Добавить новую поездку</button>
            </form>	
    		<br>
    	</div>
        <h2 style="margin: 0 auto;
        width: 300px;">Все поездки:</h2>
    	<div id ="result"></div>
        <div id ="result_display"></div>
    </body>
    <script type = "text/javascript">
        $('#add_new_region').on('click', function(){
            if($('#new_region').val() == ""){
                alert('Please enter new region');
            }else{
                $new_region = $('#new_region').val();
                $.ajax({
                    type: "POST",
                    url: "add_new_region.php",
                    data: {
                        new_region: $new_region
                    },
                    success: function(result){
                        if (result == 1) {
                            alert('Новый регион добавлен!');
                            $('input[type="text"]').val('');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }else{
                            alert('Данный регион уже существует!');
                        }
                    }
                });
            }
        });
        $('#new_region').focus(function(){
            $(this).val('');
        });
        $('#new_curier').focus(function(){
            $(this).val('');
        });
        $('#add_new_curier').on('click', function(){
            if($('#new_curier').val() == ""){
                alert('Please enter new curier');
            }else{
                $new_curier = $('#new_curier').val();
                $.ajax({
                    type: "POST",
                    url: "add_new_curier.php",
                    data: {
                        new_curier: $new_curier
                    },
                    success: function(result){
                        if (result == 1) {
                            alert('Новый курьер добавлен!');
                            $('input[type="text"]').val('');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }else{
                            alert('Такой курьер уже существует!');
                        }
                    }
                });
            }
        });
    	$(document).ready(function(){
       
    	displayResult();
    	/*	ADDING POST	*/	
    		$('#add_post').on('click', function(){
    			if($('.form_datetime').val() == ""){
    				alert('Please choose date!');
    			}else{
                    $time1 = 575;
                    $time2 = 1110;
                    $time3 = 388;
                    $time4 = 220;
                    $time5 = 310;
                    $time6 = 1500;
                    $time7 = 275;
                    $time8 = 375;
                    $time9 = 890;
                    $time10 = 1055;
                    $city1 = 'Санкт-Петербург';
                    $city2 = 'Уфа';
                    $city3 = 'Нижний Новгород';
                    $city4 = 'Владимир';
                    $city5 = 'Кострома';
                    $city6 = 'Екатеринбург';
                    $city7 = 'Ковров';
                    $city8 = 'Воронеж';
                    $city9 = 'Самара';
                    $city10 = 'Астрахань';
                    $date = $('.form-control').val();
                    $region = $('#region').val();
                    $curier = $('#curier').val();

                    if($region == $city1){$time_in_road = $time1;}
                    if($region == $city2){$time_in_road = $time2;}
                    if($region == $city3){$time_in_road = $time3;}
                    if($region == $city4){$time_in_road = $time4;}
                    if($region == $city5){$time_in_road = $time5;}
                    if($region == $city6){$time_in_road = $time6;}
                    if($region == $city7){$time_in_road = $time7;}
                    if($region == $city8){$time_in_road = $time8;}
                    if($region == $city9){$time_in_road = $time9;}
                    if($region == $city10){$time_in_road = $time10;}
                    $('#time_in_road').html($time_in_road);           
    				$.ajax({
    					type: "POST",
    					url: "add_post.php",
    					data: {
                            region:$region,
                            curier:$curier,
                            date_depart:$date,
                            time_in_road:$time_in_road
    					},
    					success: function(result){
                            if (result == 1) {
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
    						}else{
                                alert('Данная поездка уже существует!');
                            }
    					}
    				});
    			}	
    		});
    	});
    	function displayResult(){
    		$.ajax({
    			url: 'add_post.php',
    			type: 'POST',
    			async: false,
    			data:{
    				res: 1
    			},
    			success: function(response){
    				$('#result_display').html(response);
    			}
    		});
    	}
    </script>
</html>
<style type="text/css">
    #post_form{
        margin-left: 25%;
        width: 47%;
        height: 400px;
        border: 1px solid black;
    }
    #post_form select{
        width: 40%;
    }
    #add_new_curier_or_region li{
        margin-right: 10%;
    }
    #add_new_curier_or_region li{
        float: left;
        list-style: none;
    }
    #add_new_curier_or_region button,input{
        width: 100%;
    }
    #add_new_schedule_form{
        margin-left: 10%;
    }
    #result_display{
        margin: 0 auto;
        width: 300px;
    }
</style>