<?php
session_start();  // 세션 시작
// post_delete.php
include 'test_DB_connect.php';

$post_id = $_GET['post_id']; // 삭제할 게시글 ID 가져오기

// 게시글 작성자의 ID를 가져옵니다.
$stmt = $conn->prepare("SELECT member_id FROM Posts WHERE post_id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();
$author_id = $post['member_id'];

// 게시글의 작성자 또는 관리자가 아닌 경우 접근 차단
if (!isset($_SESSION['member_id']) || ($_SESSION['member_id'] != $author_id && (!isset($_SESSION['member_admin']) || $_SESSION['member_admin'] != true))) {
    die("You are not authorized to access this page.");
}

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
