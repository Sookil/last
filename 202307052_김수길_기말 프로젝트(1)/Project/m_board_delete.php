<?php
    // GET 방식으로 전달된 num과 page 파라미터를 변수에 저장합니다.
    $num = $_GET["num"];
    $page = $_GET["page"];

    // 데이터베이스에 접속합니다.
    $con = mysqli_connect("localhost", "user1", "12345", "test");

    // m_board 테이블에서 num에 해당하는 데이터를 조회하는 SQL 쿼리를 준비합니다.
    $sql = "select * from m_board where num = $num";

    // SQL 쿼리를 실행하고 결과를 $result에 저장합니다.
    $result = mysqli_query($con, $sql);

    // 조회된 데이터를 $row에 저장합니다.
    $row = mysqli_fetch_array($result);

    // 파일이 첨부되어 있는 경우 해당 파일을 경로에서 삭제합니다.
    $copied_name = $row["file_copied"];
    if ($copied_name) {
        $file_path = "./data/" . $copied_name;
        unlink($file_path); // PHP의 unlink 함수를 사용하여 파일을 삭제합니다.
    }

    // m_board 테이블에서 num에 해당하는 데이터를 삭제하는 SQL 쿼리를 준비합니다.
    $sql = "delete from m_board where num = $num";

    // SQL 쿼리를 실행합니다.
    mysqli_query($con, $sql);

    // 데이터베이스 접속을 종료합니다.
    mysqli_close($con);

    // 삭제 작업이 완료되면 m_board_list.php 페이지로 이동하는 JavaScript 코드를 출력합니다.
    echo "
         <script>
             location.href = 'm_board_list.php?page=$page';
         </script>
       ";
?>
