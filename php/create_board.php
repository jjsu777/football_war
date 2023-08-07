<?php
session_start();
if (!isset($_SESSION['member_admin']) || $_SESSION['member_admin'] != true) {
    // 사용자가 관리자가 아니면 홈페이지로 리다이렉트
    header("Location: ../php/index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>전쟁터 생성</title>
</head>
<body>
    <form action="create_board_action.php" method="post">
        <label for="board_name">게시판 이름:</label><br>
        <input type="text" id="board_name" name="board_name"><br><br>
        <label for="board_url">게시판 URL:</label><br>
        <input type="text" id="board_url" name="board_url"><br><br>
        <input type="submit" value="생성">
    </form>
</body>
</html>
