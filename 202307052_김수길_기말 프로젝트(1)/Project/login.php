<head><meta charset="utf-8"></head>
<?php include "header.php";?>
<?php
    // 폼에서 전달된 아이디와 비밀번호를 변수에 저장합니다.
    $id   = $_POST["id"];
    $pass = $_POST["pass"];

    // 데이터베이스에 연결합니다.
    $con = mysqli_connect("localhost", "user1", "12345", "test");

    // 입력받은 아이디를 이용하여 회원 테이블에서 해당 레코드를 검색합니다.
    $sql = "SELECT * FROM members WHERE id='$id'";
    $result = mysqli_query($con, $sql);

    // 검색된 결과의 레코드 수를 확인합니다.
    $num_match = mysqli_num_rows($result);

    // 입력한 아이디에 해당하는 회원 정보가 없는 경우
    if (!$num_match) 
    {
        echo("
            <script>
                window.alert('등록되지 않은 아이디입니다!'); // 경고창을 띄웁니다.
                history.go(-1); // 이전 페이지로 돌아갑니다.
            </script>
        ");
    }
    else // 입력한 아이디에 해당하는 회원 정보가 있는 경우
    {
        // 검색된 레코드의 정보를 배열로 가져옵니다.
        $row = mysqli_fetch_array($result);
        $db_pass = $row["pass"]; // 데이터베이스에서 가져온 비밀번호를 변수에 저장합니다.

        mysqli_close($con); // 데이터베이스 연결을 닫습니다.

        // 입력한 비밀번호와 데이터베이스에서 가져온 비밀번호를 비교합니다.
        if ($pass != $db_pass) // 비밀번호가 일치하지 않는 경우
        {
            echo("
                <script>
                    window.alert('비밀번호가 틀립니다!'); // 경고창을 띄웁니다.
                    history.go(-1); // 이전 페이지로 돌아갑니다.
                </script>
            ");
            exit; // 프로그램을 종료합니다.
        }
        else // 비밀번호가 일치하는 경우
        {
            // 세션을 시작하여 로그인 정보를 세션 변수에 저장합니다.
            session_start();
            $_SESSION["userid"] = $row["id"]; // 사용자 아이디
            $_SESSION["username"] = $row["name"]; // 사용자 이름
            $_SESSION["userlevel"] = $row["level"]; // 사용자 레벨
            $_SESSION["userpoint"] = $row["point"]; // 사용자 포인트

            echo("
                <script>
                    location.href = 'index.php'; // 로그인 성공 후 index.php 페이지로 이동합니다.
                </script>
            ");
        }
    }        
?>
