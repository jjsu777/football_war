<?php
session_start();
if (!isset($_SESSION['member_admin']) || $_SESSION['member_admin'] != true) {
    // 사용자가 관리자가 아니면 홈페이지로 리다이렉트
    header("Location: ../php/index.php");
    exit;
}

// 데이터베이스 연결 설정
include 'test_DB_connect.php';
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 입력받은 게시판 이름
$board_name = $_POST['board_name'];
$board_url = $_POST['board_url'];


// 게시판 생성 시 카테고리 ID 값을 10으로 설정
$category_id = 10;

// SQL 쿼리 준비
$stmt = $conn->prepare("INSERT INTO Board_list (BoardName, CategoryID, BoardURL) VALUES (?, ?, ?)");
$stmt->bind_param("sis", $board_name, $category_id, $board_url);

// 쿼리 실행
if ($stmt->execute() === TRUE) {
    echo "새로운 게시판이 성공적으로 생성되었습니다. <a href='../php/index.php'>홈으로 돌아가기</a>";
} else {
    echo "게시판 생성 중 오류 발생: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
