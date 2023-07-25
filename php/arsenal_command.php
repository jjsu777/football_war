<!-- PHP 코 부ㄴ -->
<?php
include 'test_DB_connect.php';

// 데이터베이스 연결 생성
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 게시판 id를 url parameter에서 가져옴
$board_id = $_GET["board_id"]; 

$stmt = $conn->prepare("SELECT P.post_id, P.post_title, P.team_id, P.post_content, M.member_name, P.post_date, P.post_views FROM Posts P INNER JOIN Member M ON P.member_id = M.member_id WHERE P.BoardID = ?");
$stmt->bind_param("i", $board_id);
$stmt->execute();
$result = $stmt->get_result();

// $stmt = $conn->prepare("SELECT post_id, post_title, post_content, member_id, post_date, post_views FROM Posts");
// $stmt->execute();
// $result = $stmt->get_result();

// $stmt = $conn->prepare("SELECT P.post_id, P.post_title, P.post_content, M.member_name, P.post_date, P.post_views FROM Posts P INNER JOIN Member M ON P.member_id = M.member_id");
// $stmt->execute();
// $result = $stmt->get_result();


?>

<!DOCTYPE html>
<lang="ko">
<head>
    <meta charset="UTF-8">
    <title>축구는 전쟁이다</title>
    <link rel="stylesheet" href="../css/dmz_board_style.css">
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
            <li><a href="../php/index.php">홈</a></li>
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
    <div class="board_list_wrap">
        <div class="board_list">
            <div class="top">
                <div class="num">번호</div>
                <div class="title">제목</div>
                <div class="writer">글쓴이</div>
                <div class="date">작성일</div>
                <div class="count">조회</div>
            </div>
            <?php
            $count = 1; //카운트 변수 
            while($row = $result->fetch_assoc()) {
                echo "<div>";
                echo "<div class='num'>" . $count . "</div>"; //카운트값 출력 
                echo "<div class='title'><a href='#'>" . $row["post_title"] . "</a></div>";
                echo "<div class='writer'>" . $row["member_name"] . "</div>"; // member_name 출력
                echo "<div class='date'>" . $row["post_date"] . "</div>";
                echo "<div class='count'>" . $row["post_views"] . "</div>";
                echo "</div>";
                $count++;
            }
            ?>
        </div>
            </div>
            <div class="board_page">
                <a href="#" class="bt first"><<</a>
                <a href="#" class="bt prev"><</a>
                <a href="#" class="num on">1</a>
                <a href="#" class="num">2</a>
                <a href="#" class="num">3</a>
                <a href="#" class="num">4</a>
                <a href="#" class="num">5</a>
                <a href="#" class="bt next">></a>
                <a href="#" class="bt last">>></a>
            </div>
            <div class="board-controls">
                <div class="bt_write">
                <?php
                    $board_id = $_GET["board_id"];  // URL의 board_id 값을 갯
                ?>
                    <a href="board_write.php?board_id=<?php echo $board_id; ?>" class="on">글쓰기</a>
                </div>

                </div>
                <div class="board-search">
                    <form action="#">
                        <input type="text" placeholder="검색...">
                        <button type="submit">검색</button>
                    </form>
                </div>
            </div>
            </div>
        </div>
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