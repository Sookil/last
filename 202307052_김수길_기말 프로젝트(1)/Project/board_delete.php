<?php
    $num   = $_GET["num"];  // GET 방식으로 전달된 "num" 파라미터 값을 가져와 $num 변수에 저장한다. 이는 삭제할 게시물의 번호를 나타낸다.
    $page   = $_GET["page"];  // GET 방식으로 전달된 "page" 파라미터 값을 가져와 $page 변수에 저장한다. 이는 삭제 후 이동할 페이지 번호를 나타낸다.

    // 데이터베이스에 접속한다. (localhost 서버, user1 계정, 12345 비밀번호, test 데이터베이스)
    $con = mysqli_connect("localhost", "user1", "12345", "test");

    // "board" 테이블에서 $num에 해당하는 게시물 정보를 가져오는 SQL 쿼리를 실행한다.
    $sql = "select * from board where num = $num";
    $result = mysqli_query($con, $sql);

    // 쿼리 결과에서 첫 번째 행을 배열로 가져온다.
    $row = mysqli_fetch_array($result);

    $copied_name = $row["file_copied"];  // 가져온 행에서 "file_copied" 필드의 값을 $copied_name 변수에 저장한다.

    // 만약 $copied_name 변수에 값이 있다면 (즉, 첨부된 파일이 있는 경우)
    if ($copied_name) {
        $file_path = "./data/".$copied_name;  // 첨부 파일의 경로를 지정한다.
        unlink($file_path);  // 서버에서 해당 첨부 파일을 삭제한다.
    }

    // "board" 테이블에서 $num에 해당하는 게시물을 삭제하는 SQL 쿼리를 실행한다.
    $sql = "delete from board where num = $num";
    mysqli_query($con, $sql);  // 쿼리 실행

    mysqli_close($con);  // 데이터베이스 연결을 닫는다.

    // 삭제 작업이 완료되면 게시판 목록 페이지(board_list.php)로 이동하며, 페이지 번호를 포함하여 GET 방식으로 전달한다.
    echo "
        <script>
            location.href = 'board_list.php?page=$page';
        </script>
    ";
?>
