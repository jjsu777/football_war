<?php
include 'test_DB_connect.php';

if(isset($_POST['submit_subcomment'])){
    $comment_member_id = $_POST["comment_member_id"];
    $parent_comment_id = $_POST["parent_comment_id"];
    $subcomment_content = $_POST["subcomment_content"];
    
    $sql = "INSERT INTO Comments (member_id, parent_comment_id, comment_content) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $comment_member_id, $parent_comment_id, $subcomment_content);
    
    if ($stmt->execute()) {
        // 성공 메시지
        echo "<script>
        alert('대댓글 작성 성공');
        history.back();
        </script>";
    } else {
        // 실패 메시지
        echo "<script>
        alert('대댓글 작성 실패');
        history.back();
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
