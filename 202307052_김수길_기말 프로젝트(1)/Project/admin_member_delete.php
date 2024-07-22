<?php
    session_start();  // 세션 시작
    
    // 세션에서 사용자 레벨을 가져옴
    if (isset($_SESSION["userlevel"])) 
        $userlevel = $_SESSION["userlevel"];
    else 
        $userlevel = "";  // 세션에 사용자 레벨이 없으면 빈 문자열로 초기화

    // 관리자가 아닌 경우 경고 메시지 출력 후 이전 페이지로 이동
    if ($userlevel != 1) {
        echo("
            <script>
                alert('관리자가 아닙니다! 회원 삭제는 관리자만 가능합니다!');
                history.go(-1);  // 이전 페이지로 이동
            </script>
        ");
        exit;  // 스크립트 실행 후 스크립트 종료
    }

    $num = $_GET["num"];  // GET 방식으로 전달된 회원 번호 가져오기

    // 데이터베이스 연결
    $con = mysqli_connect("localhost", "user1", "12345", "test");

    // 회원 삭제 SQL 실행
    $sql = "delete from members where num = $num";
    mysqli_query($con, $sql);

    mysqli_close($con);  // 데이터베이스 연결 닫기

    // 삭제 후 관리자 페이지(admin.php)로 이동
    echo "
        <script>
            location.href = 'admin.php';
        </script>
    ";
?>
