<?php
    if (isset($_POST['signup'])) {
        // 회원가입 버튼이 눌렸을 때 실행할 코드
        header('Location: /football_war/php/info_agree.html');
        exit;
    }elseif (isset($_POST['login'])) {
        // 로그인 버튼이 눌렸을 때 실행할 코드
        include 'test_DB_connect.php';
        $email = $_POST['email'];
        $password = $_POST['password'];

        // DB에서 사용자 정보를 확인하는 코드...
        $sql = "SELECT member_id, member_email, member_pass, member_name, member_admin FROM Member WHERE member_email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($member_id, $member_email, $member_pass, $member_name, $member_admin);
        $stmt->fetch();
        if (password_verify($password, $member_pass)) {
            // 로그인 성공
            session_start(); // Start the session
            $_SESSION["email"] = $email; 
            $_SESSION['name'] = $member_name; // 세션에 닉네임 저장
            $_SESSION['member_id'] = $member_id; // 세션에 멤버id 저장
            $_SESSION['member_admin'] = $member_admin; // 세션에 admin여부 저장

            header('Location: index.php');
            exit;
        } else {
            // 로그인 실패
            echo "<script>
            alert('로그인 실패!');
            window.location.href = 'index.php';
            </script>";
        }
        $stmt->close();
    }
?>


