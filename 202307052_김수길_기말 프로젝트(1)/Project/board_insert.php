<?php
session_start();
if (isset($_SESSION["userid"])) $userid = $_SESSION["userid"];  // 세션에 "userid"가 존재하면 해당 값을 $userid 변수에 할당
else $userid = "";  // 세션에 "userid"가 존재하지 않으면 $userid 변수를 빈 문자열로 초기화

if (isset($_SESSION["username"])) $username = $_SESSION["username"];  // 세션에 "username"이 존재하면 해당 값을 $username 변수에 할당
else $username = "";  // 세션에 "username"이 존재하지 않으면 $username 변수를 빈 문자열로 초기화

if (!$userid) {  // 만약 $userid가 비어있다면 (즉, 로그인이 되어있지 않은 상태라면)
    echo("
        <script>
        alert('게시판 글쓰기는 로그인 후 이용해 주세요!');  // 경고창을 띄워 사용자에게 로그인 후 이용하도록 안내
        history.go(-1);  // 이전 페이지로 돌아감
        </script>
    ");
    exit;  // 스크립트 실행을 중지하고 종료
}

$subject = $_POST["subject"];  // 글 작성 폼에서 전송된 제목을 $subject 변수에 저장
$content = $_POST["content"];  // 글 작성 폼에서 전송된 내용을 $content 변수에 저장

$subject = htmlspecialchars($subject, ENT_QUOTES);  // HTML 특수 문자를 HTML 엔티티로 변환하여 보안 강화
$content = htmlspecialchars($content, ENT_QUOTES);  // HTML 특수 문자를 HTML 엔티티로 변환하여 보안 강화

$regist_day = date("Y-m-d (H:i)");  // 현재 날짜와 시간을 "년-월-일 (시:분)" 형식으로 저장

$upload_dir = './data/';  // 파일 업로드 디렉토리 경로

$upfile_name     = $_FILES["upfile"]["name"];     // 업로드된 파일의 원본 이름
$upfile_tmp_name = $_FILES["upfile"]["tmp_name"]; // 업로드된 파일의 임시 저장 경로
$upfile_type     = $_FILES["upfile"]["type"];     // 업로드된 파일의 MIME 타입
$upfile_size     = $_FILES["upfile"]["size"];     // 업로드된 파일의 크기
$upfile_error    = $_FILES["upfile"]["error"];    // 업로드 과정에서 발생한 오류 코드

if ($upfile_name && !$upfile_error) {  // 업로드된 파일 이름이 존재하고 오류가 발생하지 않았다면
    $file = explode(".", $upfile_name);  // 파일 이름에서 확장자 분리
    $file_name = $file[0];               // 파일 이름
    $file_ext  = $file[1];               // 파일 확장자

    $new_file_name = date("Y_m_d_H_i_s");  // 현재 시간을 기반으로 새로운 파일 이름 생성
    $copied_file_name = $new_file_name.".".$file_ext;  // 새로운 파일 이름과 확장자를 결합하여 저장할 파일 이름 생성
    $uploaded_file = $upload_dir.$copied_file_name;  // 파일이 저장될 경로

    if ($upfile_size > 1000000) {  // 업로드된 파일의 크기가 1MB를 초과하는 경우
        echo("
            <script>
            alert('업로드 파일 크기가 지정된 용량(1MB)을 초과합니다!');  // 경고창을 띄워 파일 크기 제한을 안내
            history.go(-1);  // 이전 페이지로 돌아감
            </script>
        ");
        exit;  // 스크립트 실행을 중지하고 종료
    }

    if (!move_uploaded_file($upfile_tmp_name, $uploaded_file)) {  // 파일을 지정한 디렉토리로 이동하지 못한 경우
        echo("
            <script>
            alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');  // 경고창을 띄워 파일 복사 실패를 안내
            history.go(-1);  // 이전 페이지로 돌아감
            </script>
        ");
        exit;  // 스크립트 실행을 중지하고 종료
    }
} else {  // 업로드된 파일이 없거나 오류가 발생한 경우
    $upfile_name      = "";  // 파일 이름 초기화
    $upfile_type      = "";  // 파일 타입 초기화
    $copied_file_name = "";  // 복사된 파일 이름 초기화
}

$con = mysqli_connect("localhost", "user1", "12345", "test");  // MySQL 데이터베이스 연결
$sql = "insert into board (id, name, subject, content, regist_day, hit, file_name, file_type, file_copied) ";
$sql .= "values('$userid', '$username', '$subject', '$content', '$regist_day', 0, ";
$sql .= "'$upfile_name', '$upfile_type', '$copied_file_name')";  // 게시글 정보를 데이터베이스에 삽입하는 SQL 쿼리

mysqli_query($con, $sql);  // SQL 쿼리를 실행하여 데이터베이스에 게시글 정보를 저장
mysqli_close($con);  // 데이터베이스 연결 종료

echo "
   <script>
    location.href = 'board_list.php';  // 게시글 작성 완료 후 목록 페이지로 이동
   </script>
";
?>
