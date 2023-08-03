<?php
include 'test_DB_connect.php';

if (isset($_POST['submit_comment'])) {
    $sql = "INSERT INTO Comments (post_id, member_id, comment_content) VALUES (?, ?, ?)";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "iis", $_POST['post_id'], $_POST['comment_member_id'], $_POST['comment_content']);

        if (mysqli_stmt_execute($stmt)) {
            // 성공 메시지
            echo "<script>
            alert('댓글 작성 성공');
            history.back();
            </script>";
        } else {
            // 실패 메시지
            echo "<script>
            alert('댓글 작성 실패');
            history.back();
            </script>";
        }
    }

    mysqli_stmt_close($stmt);

    mysqli_close($conn);
}
?>
