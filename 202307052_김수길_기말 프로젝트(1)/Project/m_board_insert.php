<?php
    session_start();
    // 세션에서 사용자 정보 가져오기
    if (isset($_SESSION["userid"])) {
        $userid = $_SESSION["userid"];
    } else {
        $userid = "";
    }
    if (isset($_SESSION["username"])) {
        $username = $_SESSION["username"];
    } else {
        $username = "";
    }

    // 로그인 여부 확인
    if (!$userid) {
        // 로그인되지 않은 경우 경고 메시지 출력 후 이전 페이지로 이동
        echo("
            <script>
                alert('게시판 글쓰기는 로그인 후 이용해 주세요!');
                history.go(-1);
            </script>
        ");
        exit;
    }

    // POST로 전송된 제목과 내용 가져오기
    $subject = $_POST["subject"];
    $content = $_POST["content"];

    // XSS 방지를 위해 htmlspecialchars 함수로 특수 문자 처리
    $subject = htmlspecialchars($subject, ENT_QUOTES);
    $content = htmlspecialchars($content, ENT_QUOTES);

    // 현재 날짜와 시간을 "년-월-일 시:분" 형식으로 저장
    $regist_day = date("Y-m-d (H:i)");

    // 파일 업로드 관련 변수 설정
    $upload_dir = './data/';
    $upfile_name    = $_FILES["upfile"]["name"];
    $upfile_tmp_name = $_FILES["upfile"]["tmp_name"];
    $upfile_type    = $_FILES["upfile"]["type"];
    $upfile_size    = $_FILES["upfile"]["size"];
    $upfile_error   = $_FILES["upfile"]["error"];

    // 파일이 업로드되었고 에러가 없는 경우
    if ($upfile_name && !$upfile_error) {
        // 파일 이름에서 확장자 추출
        $file = explode(".", $upfile_name);
        $file_name = $file[0];
        $file_ext  = $file[1];

        // 새로운 파일 이름 설정 (년월일시분초 형식)
        $new_file_name = date("Y_m_d_H_i_s");
        $copied_file_name = $new_file_name.".".$file_ext;
        $uploaded_file = $upload_dir.$copied_file_name;

        // 파일 크기 제한 (1MB)
        if ($upfile_size > 1000000) {
            echo("
                <script>
                    alert('업로드 파일 크기가 지정된 용량(1MB)을 초과합니다! 파일 크기를 체크해주세요.');
                    history.go(-1);
                </script>
            ");
            exit;
        }

        // 파일을 지정한 디렉토리로 이동
        if (!move_uploaded_file($upfile_tmp_name, $uploaded_file)) {
            echo("
                <script>
                    alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
                    history.go(-1);
                </script>
            ");
            exit;
        }
    } else {
        // 파일이 업로드되지 않은 경우
        $upfile_name      = "";
        $upfile_type      = "";
        $copied_file_name = "";
    }

    // 데이터베이스 연결 설정
    $con = mysqli_connect("localhost", "user1", "12345", "test");

    // 게시글 정보를 m_board 테이블에 삽입하는 SQL 쿼리
    $sql = "INSERT INTO m_board (id, name, subject, content, regist_day, hit, file_name, file_type, file_copied) ";
    $sql .= "VALUES ('$userid', '$username', '$subject', '$content', '$regist_day', 0, ";
    $sql .= "'$upfile_name', '$upfile_type', '$copied_file_name')";
    mysqli_query($con, $sql);  // SQL 실행

    mysqli_close($con);  // 데이터베이스 연결 종료

    // 글 작성 완료 후 게시판 목록 페이지로 이동
    echo "
        <script>
            location.href = 'm_board_list.php';
        </script>
    ";
?>
