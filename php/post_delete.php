<?php
 session_start();  // 세션 시작
// post_delete.php
include 'test_DB_connect.php';

// 관리자가 아닌 경우 접근 차단
if (!isset($_SESSION['member_admin']) || $_SESSION['member_admin'] != true) {
    die("You are not authorized to access this page.");
}

$post_id = $_GET['post_id']; // 삭제할 게시글 ID 가져오기

// prepare sql and bind parameters
$stmt = $conn->prepare("DELETE FROM Posts WHERE post_id = ?");
$stmt->bind_param("i", $post_id);

if ($stmt->execute()) {
    //성공 메시지
    echo "<script>
    alert('게시글 삭제 성공');
    history.back();
    </script>";
} else {
    //실패 메시지
    echo "<script>
    alert('게시글 삭제 실패');
    history.back();
    </script>";
}
$stmt->close();
$conn->close();
?>