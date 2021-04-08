<?php
//@session_start();

//if(!isset($_SESSION['user_id'])){
//}
$dsn = 'mysql:host=localhost;charset=utf8;dbname=gamalek';
$user = 'root';
$pass = '';
//   To make new connection
try {
    $db = new PDO($dsn, $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo 'failed'. $e->getMessage() ;
}

//if(isset($_SESSION['user_id'])){
//    $user_id = $_SESSION['user_id'];
//    $ip = $_SESSION['user_ip'];
//    $session_time = $_SESSION['time'];
//}
?>