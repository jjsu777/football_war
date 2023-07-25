<?php
include 'test_DB_connect.php';

// 데이터베이스 연결 생성
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $team = $_POST["team"];
    $content = $_POST["content"];
    $board_id = $_POST["board_id"]; // URL로부터 board_id 값을 받아옵니다.
    // board_id 값이 존재하지 않는 경우에는 오류를 처리하거나 기본값을 설정해주세요.
    session_start();
    $username = $_SESSION['name'] ?? null; // 사용자가 로그인되어 있다고 가정하고, 사용자명을 세션에서 받아옵니다.
    $date = date('Y-m-d H:i:s'); // 현재 날짜와 시간을 가져옵니다.

    // 작성자의 사용자명($username)으로부터 member_id 값을 조회합니다.
    $stmt = $conn->prepare("SELECT member_id FROM member WHERE member_name = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $member_id = $row['member_id'];

    // SQL 쿼리문을 준비합니다.
    $stmt = $conn->prepare("INSERT INTO Posts (post_title, team_id, post_content, BoardID, member_id, post_date) VALUES (?, ?, ?, ?, ?, ?)");

    // 준비된 쿼리문에 변수들을 바인딩합니다.
    $stmt->bind_param("sisiis", $title, $team, $content, $board_id, $member_id, $date);

    // 준비된 쿼리문을 실행합니다.
    if ($stmt->execute()) {
        echo "새로운 글이 성공적으로 등록되었습니다.";
    } else {
        echo "오류 발생: " . $stmt->error;
    }
}

$conn->close();
?>
