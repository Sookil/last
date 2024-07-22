<?php
    // 문서 형식 및 문자 인코딩 설정
    header('Content-Type: text/html; charset=utf-8');

    // 세션 시작
    session_start();

    // 세션에서 사용자 레벨을 가져옴
    if (isset($_SESSION["userlevel"])) {
        $userlevel = $_SESSION["userlevel"];
    } else {
        $userlevel = "";
    }

    // 관리자 레벨 확인
    if ($userlevel != 1) {
        // 관리자 레벨이 아닌 경우 경고 메시지 출력 후 이전 페이지로 이동
        echo "<script>alert('관리자가 아닙니다!'); history.go(-1);</script>";
        exit; // 스크립트 실행 중단
    }

    // 삭제할 게시글이 선택되었는지 확인
    if (isset($_POST["item"])) {
        // 데이터베이스 연결
        $con = mysqli_connect("localhost", "user1", "12345", "test");

        // 선택된 게시글 수 확인
        $num_item = count($_POST["item"]);

        // 선택된 게시글을 하나씩 삭제
        foreach ($_POST["item"] as $num) {
            // 게시글 삭제 쿼리 실행
            $sql = "DELETE FROM board WHERE num = $num";
            mysqli_query($con, $sql);

            $sql = "DELETE FROM m_board WHERE num = $num";
            mysqli_query($con, $sql);

            $sql = "DELETE FROM f_board WHERE num = $num";
            mysqli_query($con, $sql);
        }

        // 데이터베이스 연결 종료
        mysqli_close($con);

        // 삭제 후에는 다시 관리자 페이지로 이동
        echo "<script>alert('$num_item 개의 게시글이 삭제되었습니다.'); location.href = 'admin.php';</script>";
    } else {
        // 선택된 게시글이 없는 경우 경고 메시지 출력
        echo "<script>alert('삭제할 게시글을 선택해주세요.'); history.go(-1);</script>";
    }
?>