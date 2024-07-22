<?php
    // GET 방식으로 전달된 글 번호와 페이지 번호를 변수에 저장합니다.
    $num   = $_GET["num"];
    $page   = $_GET["page"];

    // MySQL 데이터베이스에 연결합니다.
    $con = mysqli_connect("localhost", "user1", "12345", "test");

    // 글 번호에 해당하는 게시글 정보를 조회하는 쿼리를 실행합니다.
    $sql = "select * from f_board where num = $num";
    $result = mysqli_query($con, $sql);

    // 조회된 결과에서 한 줄을 가져옵니다.
    $row = mysqli_fetch_array($result);

    // 첨부된 파일이 있다면 파일 경로를 가져와서 삭제합니다.
    $copied_name = $row["file_copied"];
    if ($copied_name) {
        $file_path = "./data/".$copied_name;
        unlink($file_path); // PHP의 unlink 함수를 사용하여 파일 삭제
    }

    // 글 삭제 쿼리를 실행합니다.
    $sql = "delete from f_board where num = $num";
    mysqli_query($con, $sql);

    // 데이터베이스 연결을 종료합니다.
    mysqli_close($con);

    // 삭제가 완료되면 목록 페이지로 이동하는 JavaScript 코드를 출력합니다.
    echo "
         <script>
             location.href = 'f_board_list.php?page=$page';
         </script>
       ";
?>
