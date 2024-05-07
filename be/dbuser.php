<?php
$user="root";
$pass="root";
$host="127.0.0.1";
$dbName="khm";
$db=null;
try{
    $db=new PDO("mysql:host=$host;dbname=$dbName",$user,$pass);
}catch (Exception $ex){
    print "Error!: " . $ex->getMessage() . "<br/>";
    die();
}
?>