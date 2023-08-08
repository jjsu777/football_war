<?php
session_start();
include 'test_DB_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['delete_comment'])) {
        $comment_id = $_POST['comment_id']; // 삭제 댓글 id 받기 

        // 관리자 혹은 댓글 작성자라면 댓글 삭제
        if ($_SESSION['member_admin'] == 1) {
            $deleteSql = "DELETE FROM Comments WHERE comment_id = ?";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->bind_param("i", $comment_id);
        } else {
            $deleteSql = "DELETE FROM Comments WHERE comment_id = ? AND member_id = ?";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->bind_param("ii", $comment_id, $_SESSION['member_id']);
        }

        if ($deleteStmt->execute()) {
            echo "<script>
            alert('댓글 삭제 성공');
            history.back();
            </script>";
        } else {
            echo "<script>
            alert('댓글 삭제 실패');
            history.back();
            </script>";
        }
        $deleteStmt->close();
    }

    if (isset($_POST['delete_subcomment'])) {
        $subcomment_id = $_POST['subcomment_id']; // 삭제 대댓글 id 받기 

        // 관리자 혹은 대댓글 작성자라면 대댓글 삭제
        if ($_SESSION['member_admin'] == 1) {
            $deleteSql = "DELETE FROM Comments WHERE comment_id = ? AND parent_comment_id IS NOT NULL";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->bind_param("i", $subcomment_id);
        } else {
            $deleteSql = "DELETE FROM Comments WHERE comment_id = ? AND member_id = ? AND parent_comment_id IS NOT NULL";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->bind_param("ii", $subcomment_id, $_SESSION['member_id']);
        }

        if ($deleteStmt->execute()) {
            echo "<script>
            alert('대댓글 삭제 성공');
            history.back();
            </script>";
        } else {
            echo "<script>
            alert('대댓글 삭제 실패');
            history.back();
            </script>";
        }
        $deleteStmt->close();
    }
}
$conn->close();
?>
