<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "football_war_testDB";

// 데이터베이스에 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결이 성공적으로 이루어졌는지 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>