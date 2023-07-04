<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="Dipana_shrestha-2330816.css">
</head>
<body>
    <div class="card">
        <!-- SEARCH BAR -->
        <div class="search-bar">
            <input type="text" placeholder="Enter city name" value="enterprise">
            <span class="material-symbols-outlined location">
                location_on
            </span>
            <button class="material-symbols-outlined search">
                search
            </button>

        </div>

        <!-- TEMP BOX -->
        <div class="temp-box">
            <div class="weather-icon">
                <img id="dontshow" src="">
            </div>
            <div class="current-temp">
                <div class="num"></div>
                <div class="derg">°C</div>
            </div>
            <div class="description">
            </div>
            <div class="location-response">
                <span class="material-symbols-outlined location-response-icon">
                    location_on
                </span>
                <div class="location-response-name"></div>
            </div>
            <div id="time" class="time">
                5th April, 2023
            </div>
            <div class="weather-details">
                <div class="item">
                    <span class="material-symbols-outlined icon">
                        humidity_percentage
                    </span>
                    
                    <div>
                        <span class="value humidity">50%</span>
                        <p>Humidity</p>
                    </div>
                </div>
                <div class="item">
                    <span class="material-symbols-outlined icon">
                        air
                    </span>
                    <div>
                        <span class="value wind-speed" >1.5 km/h</span> 
                        <p>Wind Speed</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="showweather" id="Showweather">
   Weather
    </div>
        <!-- ERROR BOX -->
        <div class="error-box">
            <div class="error-icon">
                
            </div>
            <div class="error-message">
                Not Found!
            </div>
        </div>
    </div>



    <div class="data" style="display: none;">
    <?php
 $servern="localhost";
 $usern="root";
 $pass="";
 $conn=mysqli_connect($servern, $usern, $pass);
 function createdb(){
    $servern="localhost";
    $usern="root";
    $pass="";
    $conn=mysqli_connect($servern, $usern, $pass);
    if(!$conn){
        die("Not Found: ".mysqli_connect_error());
    }
    else{
        echo "Connection Successful<br>";
    }
    $sql="CREATE DATABASE `weather`";
    $result=mysqli_query($conn,$sql);
    if($result){
        echo "Database created Successfully<br>";
    }
    else{
        echo "Dabtabase not created Error: ".mysqli_error($conn);
    }
 } 
 function createtable(){
    $servern="localhost";
    $usern="root";
    $pass="";
    $database="weather";
    $conn=mysqli_connect($servern, $usern, $pass,$database);
    if(!$conn){
        die("Not Found: ".mysqli_connect_error());
    }
    else{
        echo "Connection Successful<br>";
    }
    $sql="CREATE TABLE `weatherdata`(`Day` VARCHAR(20) ,`Max` VARCHAR(20) , `Min` VARCHAR(20),`Status` VARCHAR(80))";
    $result=mysqli_query($conn,$sql);

    if($result){
        echo "Table Created<br>";
    }
    else{
        echo "Table Creation Unsuccessful Error: ".mysqli_error($conn);
    }
 };

 function adddata(){

 };
 function addicon(){

 };
    createdb();
    createtable();
    $servern="localhost";
    $usern="root";
    $pass="";
    $database="weather";
    $conn=mysqli_connect($servern, $usern, $pass, $database);
    if(!$conn){
        die("Not Found: ".mysqli_connect_error());
    }
    else{
        echo "Connection Successful<br>";
    }

function cityname(){
    $data=json_decode(file_get_contents("php://input"),true);
    return $data;
};   
$cname=cityname();
if($cname!=""){
    $city=$cname;
}
else{
    $city="Sheffield";
};
$end_date=date("Y-m-d", strtotime("0 day"));
$start_date=date("Y-m-d", strtotime("-7 day"));
echo "Start Date: ".$start_date." End Date: ".$end_date."<br>";
$weatherapi="http://api.weatherapi.com/v1/history.json?key=8a60381b6635470e94674335230505&q=".$city."%20City&dt=".$start_date."&end_dt=".$end_date;
$jsondata=file_get_contents($weatherapi);
$weather=json_decode($jsondata,true);
$days=$weather['forecast']['forecastday'];
echo $weather['location']['name']."<br>";
for($i=0;$i<7;$i++){
    $time=$days[$i]['date_epoch'];
    $dname=date("l",$time);
    $maxtemp=$days[$i]['day']['maxtemp_c'];
    $mintemp=$days[$i]['day']['mintemp_c'];
    $condition=$days[$i]['day']['condition']['text'];
    $sql="INSERT INTO `weatherdata`(`Day`,`Max`,`Min`,`Status`) VALUES('$dname','$maxtemp','$mintemp','$condition')";
    $result=mysqli_query($conn,$sql);
    if($result){
        echo("Record Inserted..");
    }
    else{
        echo("Record Insertion Failed Error").mysqli_error($conn);
    }
}
?>
    </div>
<div class="data" id="data" style="display: none;">
<?php
$hostname="localhost";
$username="root";
$password="";
$database="weather";

$con=mysqli_connect($hostname,$username,$password,$database);
$sql1="select Day from `weatherdata`";
$sql2="select Max from `weatherdata`";
$sql3="select Min from `weatherdata`";
$result=mysqli_query($con,$sql1);
$result1=mysqli_query($con,$sql2);
$result2=mysqli_query($con,$sql3);
$col=mysqli_fetch_all($result);
$col1=mysqli_fetch_all($result1);
$col2=mysqli_fetch_all($result2);
$z=0;
$days=array();
$maxt=array();
$mint=array();
for($i=0;$i<7;$i++){
    array_push($days,$col[$i][$z]);
    array_push($maxt,$col1[$i][$z]);
    array_push($mint,$col2[$i][$z]);
}
$html="";
for($j=0;$j<7;$j++){
    echo $days[$j]."__<br>";
    echo "Max_Temp: ".$maxt[$j]."<br>";
    echo "Min_Temp: ".$mint[$j]."<br>";
};
?>
</div>

</body>
<script src="Dipana_shrestha-2330816.js"></script>
</html>