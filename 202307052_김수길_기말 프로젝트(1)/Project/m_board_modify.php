<?php
    // GET 방식으로 전달된 num과 page 파라미터 가져오기
    $num = $_GET["num"];
    $page = $_GET["page"];

    // POST 방식으로 전달된 제목과 내용 가져오기
    $subject = $_POST["subject"];
    $content = $_POST["content"];
          
    // MySQL 데이터베이스 연결
    $con = mysqli_connect("localhost", "user1", "12345", "test");

    // 게시글 업데이트를 위한 SQL 쿼리 작성
    $sql = "update m_board set subject='$subject', content='$content' ";
    $sql .= " where num=$num";  // num이 일치하는 게시글 업데이트

    // SQL 쿼리 실행
    mysqli_query($con, $sql);

    // MySQL 연결 종료
    mysqli_close($con);     

    // 게시글 업데이트 후 목록 페이지로 이동하는 자바스크립트 코드 출력
    echo "
        <script>
            location.href = 'm_board_list.php?page=$page';
        </script>
    ";
?>
