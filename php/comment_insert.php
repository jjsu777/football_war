<?php
include 'test_DB_connect.php';

if (isset($_POST['submit_comment'])) {
    $sql = "INSERT INTO Comments (post_id, member_id, comment_content) VALUES (?, ?, ?)";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "iis", $_POST['post_id'], $_POST['comment_member_id'], $_POST['comment_content']);

        if (mysqli_stmt_execute($stmt)) {
            echo "댓글이 성공적으로 등록되었습니다.";
        } else {
            echo "댓글을 등록하는 도중 문제가 발생했습니다: " . mysqli_error($conn);
        }
    }

    mysqli_stmt_close($stmt);

    mysqli_close($conn);
}
?>
