<?php
session_start(); // 세션 시작
include 'test_DB_connect.php';

// 데이터베이스 연결 생성
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$post_id = $_GET["post_id"];
$board_id = $_GET["board_id"]; // 게시판 ID를 GET

// 게시글 쿼리 
$postsSql = "SELECT P.post_id, P.post_title, P.team_id, P.post_content, p.image_path, M.member_name, P.post_date, P.post_views FROM Posts P INNER JOIN Member M ON P.member_id = M.member_id WHERE P.post_id = ?";
$postsStmt = $conn->prepare($postsSql);
$postsStmt->bind_param("i", $post_id);
$postsStmt->execute();
$result = $postsStmt->get_result();

$row = $result->fetch_assoc();

// 게시판 정보 쿼리
$boardSql = "SELECT B.CategoryName, L.BoardName FROM Board_category B INNER JOIN Board_list L ON B.CategoryID = L.CategoryID WHERE L.BoardID = ?";
$boardStmt = $conn->prepare($boardSql);
$boardStmt->bind_param("i", $board_id);
$boardStmt->execute();
$boardResult = $boardStmt->get_result();

$boardRow = $boardResult->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>축구는 전쟁이다</title>
    <link rel="stylesheet" href="../css/board_write_style.css">
</head>
<body>
  <header>
    <div class="logo"></div>
    <nav>
        <ul>
            <li><a href="#"><img src="../images/ars_logo.png" alt="아스날로고"></a></li>
            <li><a href="#"><img src="../images/chels_logo.png" alt="첼시로고"></a></li>
            <li><a href="#"><img src="../images/man_logo.png" alt="맨유로고"></a></li>
            <li><a href="#"><img src="../images/mancity_logo.png" alt="맨시티로고"></a></li>
            <li><a href="#"><img src="../images/liver_logo.png" alt="리버풀로고"></a></li>
            <li><a href="#"><img src="../images/tot_logo.png" alt="토트넘로고"></a></li>
        </ul>
    </nav>
</header>
    <div class="banner">
      <div class="banner-content">
          <h1>해외축구는 전쟁이다.</h1>
          <p>해축전에 오신것을 환영합니다.</p>
      </div>
    </div>
    
    <div class="tabs">
        <ul>
            <li><a href="#">홈</a></li>
            <li><a href="#">해축전 설명서</a></li>
            <li><a href="#">팀 정보</a></li>
            <li><a href="#">전쟁터</a></li>
        </ul>
    </div>

   <!-- 게시판 섹션 시작 -->
<div class="board_wrap">
    <div class="board_title">
        <Strong><?php echo $boardRow["CategoryName"]; ?></Strong>
        <p><?php echo $boardRow["BoardName"]; ?></p>
    </div>
   
       <div class ="board_write_wrap">
            <div class="board_write">
                <div class="title">
                    <dl>
                        <dt>제목</dt>
                        <dd>
                        <?php
                       echo $row["post_title"]; // 제목 출력
                   ?>
                   </dd>
                        </dl>
                </div>
                <div class="info">
                    <dl>
                    <dd>
                    <?php
               echo "작성자 : " . $row["member_name"]; // 작성자 출력
           ?>
                   </dd>
                    </dl>
                </div>
                <div class="cont">
                <dl>
                        <dd>
                        <img class="post-image" src="<?php echo $row["image_path"]; ?>" alt="Image Description"> <!-- 이미지 출력 -->
            <?php
           
                       echo $row["post_content"]; // 본문 출력
                   ?>
                   </dd>
                        </dl>
                </div>

                <form action="comment_insert.php" method="POST">
                <input type="hidden" name="comment_member_id" value="<?php echo $_SESSION['member_id']; ?>">
                <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                <textarea name="comment_content" cols="80" rows="5" required></textarea>
                <input type="submit" name="submit_comment" value="댓글 작성">
            </form>
            <!-- 댓글 섹션 시작 -->
            <div class="comments_section">
                <h3>댓글목록</h3>

                <?php
    // 게시글에 해당하는 댓글 쿼리
    $commentsSql = "SELECT C.comment_id, C.comment_content, M.member_name, M.member_id, C.comment_date FROM Comments C INNER JOIN Member M ON C.member_id = M.member_id WHERE C.post_id = ? ORDER BY C.comment_date DESC";
    $commentsStmt = $conn->prepare($commentsSql);
    $commentsStmt->bind_param("i", $post_id);
    $commentsStmt->execute();
    $commentsResult = $commentsStmt->get_result();


    // 댓글 출력
        while ($commentsRow = $commentsResult->fetch_assoc()) {
        echo "<div class='comment'>";
        echo "<p>" . $commentsRow["member_name"] . " (" . $commentsRow["comment_date"] . "):</p>";
        echo "<p>" . $commentsRow["comment_content"] . "</p>";

    // 현재 사용자가 댓글 작성자이거나 관리자인 경우에만 삭제 버튼 표시
    if (isset($_SESSION['member_id']) && ($_SESSION['member_id'] == $commentsRow['member_id'] || $_SESSION['member_admin'] == 1)) {
        echo "<form action='comment_delete.php' method='POST'>";
        echo "<input type='hidden' name='comment_id' value='" . $commentsRow["comment_id"] . "'>";
        echo "<input type='submit' name='delete_comment' value='댓글 삭제'>";
        echo "</form>";
    }
    echo "</div>";
}

?>
            </div>
            <!-- 댓글 섹션 끝 -->

            </div>
            <div class="bt_wrap">
                <a href="#">취소</a>
            </div>
        </div>
    </form>
</div>
            </body>
        </div>
    <!-- 게시판 섹션 끝 -->
<footer>
    <div class="footer-container">
        <p>© 2023 해외축구는 전쟁이다. All rights reserved.</p>
        <p>해축전 운영팀 : jjsu777@naver.com</p>
    </div>
</footer>
</body>

</html>
