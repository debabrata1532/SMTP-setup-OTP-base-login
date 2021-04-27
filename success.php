<?php   


$server= "localhost";
$user= "root";
$password = "";
$database = "your database name";

$con= mysqli_connect($server,$user,$password,$database);

$otpverify = $_POST['otp'];

$sql = "select * from otp where otp = $otpverify";
$result = mysqli_query($con, $sql);
$count = mysqli_num_rows($result);

if ($count > 0){
    echo "verfied";
}
else{
    echo "Not verified";
}





?>