<?php
session_start(); // 세션을 시작합니다.

// 세션 변수에서 사용자 정보를 가져옵니다. 만약 없으면 빈 문자열로 초기화합니다.
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

// 만약 사용자가 로그인하지 않은 상태라면 경고창을 띄우고 이전 페이지로 되돌아갑니다.
if (!$userid) {
    echo("
        <script>
        alert('게시판 글쓰기는 로그인 후 이용해 주세요!');
        history.go(-1);
        </script>
    ");
    exit; // 스크립트를 종료합니다.
}

// POST로 전송된 제목과 내용을 가져옵니다. XSS 공격을 방지하기 위해 htmlspecialchars 함수를 사용하여 필터링합니다.
$subject = $_POST["subject"];
$content = $_POST["content"];
$subject = htmlspecialchars($subject, ENT_QUOTES);
$content = htmlspecialchars($content, ENT_QUOTES);

// 현재 시간을 '년-월-일 시:분' 형식으로 저장합니다.
$regist_day = date("Y-m-d (H:i)");

// 파일 업로드 관련 변수를 초기화합니다.
$upload_dir = './data/';
$upfile_name = $_FILES["upfile"]["name"];
$upfile_tmp_name = $_FILES["upfile"]["tmp_name"];
$upfile_type = $_FILES["upfile"]["type"];
$upfile_size = $_FILES["upfile"]["size"];
$upfile_error = $_FILES["upfile"]["error"];

// 만약 업로드된 파일이 있고 오류가 없다면 처리합니다.
if ($upfile_name && !$upfile_error) {
    // 파일명과 확장자를 분리합니다.
    $file = explode(".", $upfile_name);
    $file_name = $file[0];
    $file_ext = $file[1];

    // 새로운 파일명을 생성합니다. (업로드 시간 기반)
    $new_file_name = date("Y_m_d_H_i_s");
    $copied_file_name = $new_file_name . "." . $file_ext;
    $uploaded_file = $upload_dir . $copied_file_name;

    // 파일 크기가 1MB를 초과하는지 검사합니다.
    if ($upfile_size > 1000000) {
        echo("
            <script>
            alert('업로드 파일 크기가 지정된 용량(1MB)을 초과합니다! 파일 크기를 체크해주세요!');
            history.go(-1);
            </script>
        ");
        exit; // 스크립트를 종료합니다.
    }

    // 임시 업로드된 파일을 지정된 디렉토리로 이동합니다.
    if (!move_uploaded_file($upfile_tmp_name, $uploaded_file)) {
        echo("
            <script>
            alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
            history.go(-1);
            </script>
        ");
        exit; // 스크립트를 종료합니다.
    }
} else {
    // 파일이 업로드되지 않았을 경우 초기화합니다.
    $upfile_name = "";
    $upfile_type = "";
    $copied_file_name = "";
}

// 데이터베이스에 연결합니다.
$con = mysqli_connect("localhost", "user1", "12345", "test");

// 글 쓰기 SQL 쿼리를 작성하고 실행합니다.
$sql = "INSERT INTO f_board (id, name, subject, content, regist_day, hit, file_name, file_type, file_copied) ";
$sql .= "VALUES ('$userid', '$username', '$subject', '$content', '$regist_day', 0, ";
$sql .= "'$upfile_name', '$upfile_type', '$copied_file_name')";
mysqli_query($con, $sql); // SQL 쿼리를 실행합니다.

mysqli_close($con); // 데이터베이스 연결을 닫습니다.

// 글 작성 후 목록 페이지로 이동하는 JavaScript 코드를 출력합니다.
echo "
   <script>
    location.href = 'f_board_list.php';
   </script>
";
?>
