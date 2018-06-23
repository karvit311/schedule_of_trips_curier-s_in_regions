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
    	<h2>По интервалу дат получить поездки</h2>
        <div  id ="select_form">
            <form method="post" >   
                <br>
                <div>Дата выезда из Москвы:</div>
                <span>From:</span><br/>
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
                <span>To:</span><br/>
                <div class="container">
                    <div class="row">
                        <div class='col-sm-6'>
                            <div class="form-group">
                                <div class='input-group date' id='datetimepicker2'  style="width: 50%;">
                                    <input type='text' class="form-control"  id="form-control2" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <br/>
                <button type ="button" id="select_post">Выбрать</button>
            </form> 
            <br>
        </div>
        
        <div id="select_result" style=""></div>
    </body>   
    <script>
        $(document).ready(function(){
            $('#datetimepicker1').datetimepicker();
            $('#datetimepicker2').datetimepicker();

        });
    </script>
    	
    <script type = "text/javascript">
        $(document).ready(function(){
        displayResultSelect();
            $('#select_post').on('click', function(){
                $date1 = $('.form-control').val();
                $date2 = $('#form-control2').val();

                $.ajax({
                    type: "POST",
                    url: "select_post.php",
                    data: {
                        date1: $date1,
                        date2: $date2
                    },
                    success: function(response){
                        $('#select_result').html(response);
                    }
                });   
            });
        });
        function displayResultSelect(){
            $.ajax({
                url: 'select_post.php',
                type: 'POST',
                async: false,
                data:{
                    res: 1
                },
                success: function(response){
                    $('#select_result').html(response);
                }
            });
        }
    </script>
</html>
<style type="text/css">
    #select_form{
        margin-left: 25%;
        width: 50%;
        height: 300px;
        border: 1px solid black;
    }
    #select_form form, button{
        margin-left: 5%;
    }
    #select_result{
        margin-left: 25%;
    }
</style>