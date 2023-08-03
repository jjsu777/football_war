<?php
session_start();
include 'test_DB_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['delete_comment'])) {
        //삭제요청 확인

        $comment_id = $_POST['comment_id']; // 삭제 댓글 id 받기 
        
        if ($_SESSION['member_admin'] == 1) {
            // 관리자 댓글 삭제
            $deleteSql = "DELETE FROM Comments WHERE comment_id = ?";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->bind_param("i", $comment_id);
        } else {
            // 댓글 작성자라면 댓글 삭제
            $deleteSql = "DELETE FROM Comments WHERE comment_id = ? AND member_id = ?";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->bind_param("ii", $comment_id, $_SESSION['member_id']);
        }

        if ($deleteStmt->execute()) {
            //성공 메시지
            echo "<script>
            alert('댓글 삭제 성공');
            history.back();
            </script>";
        } else {
            //실패 메시지
            echo "<script>
            alert('댓글 삭제 실패');
            history.back();
            </script>";
        }
        $deleteStmt->close();
    }
}
$conn->close();
?>
