<?php
include 'test_DB_connect.php';

// 데이터베이스 연결 생성
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 폼 데이터 처리
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $team = $_POST["team"];

    // 비밀번호를 해싱
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 이메일 중복 여부 확인
    $duplicate = checkEmailDuplicate($conn, $email);

    if ($duplicate) {
        echo "<script>alert('중복된 이메일입니다.'); window.location.href = 'join.html';</script>";
        exit;
    } else {
        // 데이터베이스에 데이터 저장
        $sql = "INSERT INTO Member (member_name, member_email, member_pass, member_team) VALUES ('$name', '$email', '$hashed_password', '$team')";

        if ($conn->query($sql) === TRUE) {
            echo "회원가입이 완료되었습니다.";
        } else {
            echo "오류: " . $sql . "<br>" . $conn->error;
        }
    }
}

// 데이터베이스 연결 종료
$conn->close();

// 이메일 중복 여부 확인 함수
function checkEmailDuplicate($conn, $email) {
    $sql = "SELECT member_email FROM Member WHERE member_email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return true; // 중복된 이메일이 존재함
    } else {
        return false; // 중복된 이메일이 존재하지 않음
    }
}
?>

<script>
    var password = document.getElementById("password"),
        confirm_password = document.getElementById("confirm_password");

    function validatePassword() {
        if (password.value != confirm_password.value) {
            confirm_password.setCustomValidity("비밀번호가 일치하지 않습니다");
        } else {
            confirm_password.setCustomValidity('');
        }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;
</script>
