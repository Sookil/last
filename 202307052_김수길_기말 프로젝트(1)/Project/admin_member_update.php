<?php
    session_start();  // 세션을 시작한다.

    // 세션에서 사용자 레벨을 가져온다. 만약 세션에 "userlevel"이라는 값이 있다면 $userlevel 변수에 저장하고, 없다면 빈 문자열로 초기화한다.
    if (isset($_SESSION["userlevel"])) 
        $userlevel = $_SESSION["userlevel"];
    else 
        $userlevel = ""; 

    // 만약 $userlevel 값이 1이 아니라면 (즉, 관리자가 아닌 경우)
    if ($userlevel != 1) {
        echo("
            <script>
                alert('관리자가 아닙니다! 회원정보 수정은 관리자만 가능합니다!');  // 경고창을 띄워 관리자가 아님을 알린다.
                history.go(-1);  // 이전 페이지로 돌아간다.
            </script>
        ");
        exit;  // 스크립트 실행을 종료한다.
    }

    $num = $_GET["num"];  // GET 방식으로 전달된 "num" 파라미터 값을 가져와 $num 변수에 저장한다. 이는 수정할 회원의 번호를 나타낸다.
    $level = $_POST["level"];  // POST 방식으로 전달된 "level" 파라미터 값을 가져와 $level 변수에 저장한다. 이는 수정할 회원의 레벨을 나타낸다.

    // 데이터베이스에 접속한다. (localhost 서버, user1 계정, 12345 비밀번호, test 데이터베이스)
    $con = mysqli_connect("localhost", "user1", "12345", "test");

    // "members" 테이블에서 $num에 해당하는 회원의 레벨을 $level로 업데이트하는 SQL 쿼리를 실행한다.
    $sql = "update members set level=$level where num=$num";
    mysqli_query($con, $sql);

    mysqli_close($con);  // 데이터베이스 연결을 닫는다.

    // 회원 정보 수정 작업이 완료되면 관리자 페이지(admin.php)로 이동한다.
    echo "
        <script>
            location.href = 'admin.php';
        </script>
    ";
?>
