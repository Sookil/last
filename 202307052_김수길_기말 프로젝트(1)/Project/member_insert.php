<?php
header('Content-Type: text/html; charset=UTF-8');
?>
<?php

// POST로 전송된 데이터 수집
$id           = $_POST["id"];
$pass         = $_POST["pass"];
$name         = $_POST["name"];
$age          = $_POST["age"];
$phone        = $_POST["phone"];
$gender       = $_POST["gender"];
$address      = $_POST["address"];
$hobbies      = isset($_POST["hobbies"]) ? implode(",", $_POST["hobbies"]) : ""; // 선택된 취미를 쉼표로 구분하여 문자열로 저장
$introduction = $_POST["introduction"];
$level        = 0;
$musician     = "아니요";

// '뮤지션 여부' 선택 여부에 따라 데이터 처리
if (isset($_POST["musician"])) {
    if ($_POST["musician"] == '예') {
        $level = 2; // 레벨을 2로 설정 (뮤지션인 경우)
        $musician = "예";
    }
}

$regist_day   = date("Y-m-d (H:i)"); // 현재 날짜와 시간을 저장

// 파일 업로드 관련 변수 설정
$upload_dir       = './uploads/';
$upfile_name      = $_FILES["upfile"]["name"];
$upfile_tmp_name  = $_FILES["upfile"]["tmp_name"];
$upfile_type      = $_FILES["upfile"]["type"];
$upfile_size      = $_FILES["upfile"]["size"];
$upfile_error     = $_FILES["upfile"]["error"];

// 파일이 존재하고 에러가 없을 경우
if ($upfile_name && !$upfile_error) {
    $file       = explode(".", $upfile_name); // 파일 이름과 확장자를 분리
    $file_name  = $file[0]; // 파일 이름
    $file_ext   = $file[1]; // 확장자

    $new_file_name      = date("Y_m_d_H_i_s"); // 새 파일 이름 설정
    $copied_file_name   = $new_file_name . "." . $file_ext; // 복사된 파일 이름 설정
    $uploaded_file      = $upload_dir . $copied_file_name; // 업로드될 파일 경로

    // 파일 크기 제한 체크 (1MB)
    if ($upfile_size > 1000000) {
        echo("
        <script>
        alert('업로드 파일 크기가 지정된 용량(1MB)을 초과합니다!<br>파일 크기를 체크해주세요!');
        history.go(-1);
        </script>
        ");
        exit;
    }

    // 파일 업로드 처리
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
    $upfile_name        = "";
    $upfile_type        = "";
    $copied_file_name   = ""; // 파일 변수 초기화
}

// 데이터베이스 연결
$con = mysqli_connect("localhost", "user1", "12345", "test");

// SQL 쿼리 작성
$sql = "INSERT INTO members (id, pass, name, age, phone, gender, address, hobbies, introduction, file_name, file_type, file_copied, musician, regist_day, level) ";
$sql .= "VALUES ('$id', '$pass', '$name', '$age', '$phone', '$gender', '$address', '$hobbies', '$introduction', '$upfile_name', '$upfile_type', '$copied_file_name', '$musician', '$regist_day', '$level')";

// SQL 실행
$result = mysqli_query($con, $sql);

// 쿼리 결과에 따른 처리
if ($result) {
    // 회원가입 성공 시 메시지 출력 후 인덱스 페이지로 이동
    echo "<script>alert('회원가입에 성공하였습니다!'); window.location.href = 'index.php';</script>";
} else {
    // 회원가입 실패 시 에러 메시지 출력
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}

mysqli_close($con); // 데이터베이스 연결 종료

// 인덱스 페이지로 이동
echo "
<script>
location.href = 'index.php';
</script>
";
?>
