<!-- PHP 코드 부분 -->
<?php
include 'test_DB_connect.php';

// 데이터베이스 연결 생성
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$post_id = $_GET["post_id"];

// 게시글 쿼리 
$postsSql = "SELECT P.post_id, P.post_title, P.team_id, P.post_content, M.member_name, P.post_date, P.post_views FROM Posts P INNER JOIN Member M ON P.member_id = M.member_id WHERE P.post_id = ?";
$postsStmt = $conn->prepare($postsSql);
$postsStmt->bind_param("i", $post_id);
$postsStmt->execute();
$result = $postsStmt->get_result();

$row = $result->fetch_assoc();


?>

<!DOCTYPE html>
<lang="ko">
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
        <Strong>DMZ 공동경비구역</Strong>
        <p>자유롭게 이야기하는 곳</p>
    </div>
   
    <form action="write_input.php" method="POST">
       <div class ="board_write_wrap">
            <div class="board_write">
                <div class="title">
                    <dl>
                        <dt>제목</dt>
                        <dd>
                        <?php
                       echo $row["post_title"]; // member_name 출력
                   ?>
                   </dd>
                        </dl>
                </div>
                <div class="info">
                    <dl>
                    <dd>
                    <?php
               echo "작성자 : " . $row["member_name"]; // member_name 출력
           ?>
                   </dd>
                    </dl>
                </div>
                <div class="cont">
                <dl>
                        <dd>
                        <?php
                       echo $row["post_content"]; // member_name 출력
                   ?>
                   </dd>
                        </dl>
                </div>
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