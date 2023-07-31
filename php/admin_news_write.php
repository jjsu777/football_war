<!-- PHP 코드 부분 -->
<?php
include 'test_DB_connect.php';

// 데이터베이스 연결 생성
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
        <Strong>뉴스 올리기</Strong>
        <p>관리자 뉴스 작성 폼</p>
    </div>
   
    <form action="write_input.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="board_id" value="<?php echo $_GET['board_id']; ?>">
       <div class ="board_write_wrap">
            <div class="board_write">
                <div class="title">
                    <dl>
                        <dt>제목</dt>
                        <dd><input type="text" name="title" placeholder="제목 입력" /></dd>
                    </dl>
                </div>
                <div class="info">
                <dl>
                        <dt>이미지 업로드</dt>
                    <dd>
                    <input type="file" name="team_image">
                     </dd>

                            </select>
                        </dd>
                    </dl>
                </div>
                <div class="cont">
                    <textarea name="content" placeholder="내용입력"></textarea>
                </div>
            </div>
            <div class="bt_wrap">
                <button type="submit" class="on">등록</button>
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