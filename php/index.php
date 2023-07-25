<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>축구는 전쟁이다</title>
    <link rel="stylesheet" href="../css/index_style.css">
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

<div class="container">
<div class="left-section">
    <!-- 로그인 폼 혹은 로그인한 사용자 정보 -->
    <div class ="login">
        <?php
        session_start();
        if (isset($_SESSION['name'])) {
            // 로그인 상태인 경우
            echo "환영합니다, " . $_SESSION['name'] . "!";
            echo "<br>";
            echo "<a href='logout.php'>로그아웃</a>";
        } else {
            // 로그인 상태가 아닌 경우
        ?>
            <form method="POST" action="../php/login.php">
            <label for="email">이메일:</label><br>
            <input type="text" id="email" name="email"><br>
            <label for="password">비밀번호:</label><br>
            <input type="password" id="password" name="password"><br><br>
            <input type="submit" value="로그인" name="login">
            <input type="submit" value="회원가입" name="signup">
            </form>
        <?php
        }
        ?>
    </div>

    <?php
    include 'test_DB_connect.php';

    // 데이터베이스 연결
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SELECT 쿼리 생성
    $sql = "SELECT c.CategoryID, c.CategoryName, b.BoardID, b.BoardName, b.BoardURL 
            FROM Board_category c
            JOIN Board_list b ON c.CategoryID = b.CategoryID"; 

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // 각 행에 대한 출력
        $currentCategoryId = null;
        echo "<div class ='board-list'>"; // 게시판 목록 시작
        while($row = $result->fetch_assoc()) {
            if ($row['CategoryID'] !== $currentCategoryId) {
                // 새로운 카테고리 시작
                if ($currentCategoryId !== null) {
                    echo "</ul>"; // 이전 카테고리의 목록 닫기
                }
                echo "<h2>".$row['CategoryName']."</h2>"; // 카테고리 이름 출력
                echo "<ul>"; // 카테고리의 목록 시작
                $currentCategoryId = $row['CategoryID'];
            }
            echo "<li><a href='".$row['BoardURL'].".php?board_id=".$row['BoardID']."'>".$row['BoardName']."</a></li>";
        }
        echo "</ul>"; // 마지막 카테고리의 목록 닫기
        echo "</div>"; // 게시판 목록 닫기
    } else {
        echo "No results"; // 결과가 없는 경우 출력
    }

    $conn->close();
    ?>
</div>

<div class="right-section">
    <!-- 오른쪽 섹션 내용 추가 -->
    <div class="news">
        <div class="news-item">
            <a href="news1.html">
                <h2>최신 뉴스1</h2>
                <p>뉴스 이미지가 여기에 표시</p>
            </a>
        </div>

        <div class="news-item">
            <a href="news2.html">
                <h2>최신 뉴스2</h2>
                <p>뉴스 이미지가 여기에 표시</p>
                <?php
            if (isset($_SESSION['member_admin']) && $_SESSION['member_admin'] == true) {
        ?>
        <a href="admin_news_write.php"><button>관리자 버튼</button></a>
        <?php
            }
        ?>
                
            </a>
        </div>

        <div class="news-item">
            <a href="news3.html">
                <h2>최신 뉴스3</h2>
                <p>뉴스 이미지가 여기에 표시</p>
            </a>
        </div>
    </div>

    <div class="topic">
        <div class="hot-topic">
            <h2>오늘의 화제</h2>
            <ul>
                <li><a href="#">화제의 게시글1</a></li>
                <li><a href="#">화제의 게시글2</a></li>
                <li><a href="#">화제의 게시글3</a></li>
                <li><a href="#">화제의 게시글3</a></li>
                <li><a href="#">화제의 게시글3</a></li>
                <li><a href="#">화제의 게시글3</a></li>
                <li><a href="#">화제의 게시글3</a></li>
                <li><a href="#">화제의 게시글3</a></li>
                <li><a href="#">화제의 게시글3</a></li>
            </ul>
        </div>

        <div class="free-board">
            <h2>DMZ 공동경비구역</h2>
            <ul>
            <?php
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 게시판 id를 url parameter에서 가져옴
$board_id = 1;

// 페이지당 게시글 수
$perPage = 10;

// 총 게시글 수를 가져오는 쿼리
$totalPostsSql = "SELECT COUNT(*) as cnt FROM Posts WHERE BoardID = ?";
$totalPostsStmt = $conn->prepare($totalPostsSql);
$totalPostsStmt->bind_param("i", $board_id);
$totalPostsStmt->execute();
$totalPostsResult = $totalPostsStmt->get_result();
$totalPostsRow = $totalPostsResult->fetch_assoc();

// 총 게시글 수
$totalPosts = $totalPostsRow['cnt'];

// 총 페이지 수
$totalPages = ceil($totalPosts / $perPage);

// 현재 페이지 번호 없으면 기본 1
$page = (isset($_GET['page']) && !empty($_GET['page'])) ? $_GET['page'] : 1;

// DB에서 가져올 게시글의 시작 위치
$start = ($page-1) * $perPage;

// 게시글 쿼리 수정
$postsSql = "SELECT P.post_id, P.post_title, P.team_id, M.member_name FROM Posts P INNER JOIN Member M ON P.member_id = M.member_id WHERE P.BoardID = ? ORDER BY P.post_date DESC LIMIT ?, ?";
//Posts 테이블과 Member 테이블을 결합, 결합 조건은 Posts 테이블의 member_id가 Member 테이블의 member_id와 같은 행을 찾아라 

$postsStmt = $conn->prepare($postsSql);
$postsStmt->bind_param("iii", $board_id, $start, $perPage);
$postsStmt->execute();
$result = $postsStmt->get_result();

$count = 0; //카운트 변수
while($row = $result->fetch_assoc()) {
    $team_stmt = $conn->prepare("SELECT team_name FROM Teams WHERE team_id = ?");
    $team_stmt->bind_param("i", $row["team_id"]);
    $team_stmt->execute();
    $team_result = $team_stmt->get_result();
    $team_name = $team_result->fetch_assoc()["team_name"];

    $postNumber = $totalPosts - (($page - 1) * $perPage + $count); // 게시글 고유 번호 계산

    echo "<div>";
    echo "<div class='title'><a href='board_detail.php?post_id=" . $row["post_id"] . "'>[" . $team_name . "] " . $row["post_title"] . "</a></div>"; // post_id 추가            
    echo "<div class='writer'>" . $row["member_name"] . "</div>"; // member_name 출력
    echo "</div>";
    $count++;
} 
?>

            </ul>
        </div>
    </div>

    <div class="battleground-board">
        <h2>전쟁터 현황</h2>
    </div>

</div>
</div>
<footer>
    <div class="footer-container">
        <p>© 2023 해외축구는 전쟁이다. All rights reserved.</p>
        <p>해축전 운영팀 : jjsu777@naver.com</p>
    </div>
</footer>
</body>
</html>
