<?php 
$host = "localhost";
$user = "root";
$password = "";
$dbname = "book";

$conn = mysqli_connect($host, $user, $password, $dbname);
if (!$conn){
    die("ошибка подключения");
}
session_start();
?>