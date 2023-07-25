<?php
include 'test_DB_connect.php';
// SELECT 쿼리 생성
$sql = "SELECT c.CategoryID, c.CategoryName, b.BoardID, b.BoardName 
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
        echo "<li><a href='#'>".$row['BoardName']."</a></li>"; // 게시판 이름 출력
    }
    echo "</ul>"; // 마지막 카테고리의 목록 닫기
    echo "</div>"; // 게시판 목록 닫기
} else {
    echo "No results"; // 결과가 없는 경우 출력
}

$conn->close();
?>
