<?php
$id = $_GET["id"]; // URL 매개변수로 전달받은 회원의 ID를 가져옵니다.

// POST 방식으로 전달된 회원 정보를 변수에 저장합니다.
$pass = $_POST["pass"];
$name = $_POST["name"];
$phone = $_POST["phone"];
$age = $_POST["age"];
$gender = $_POST["gender"];
$address = $_POST["address"];
$introduction = $_POST["introduction"];
$hobbies = isset($_POST["hobbies"]) ? implode(",", $_POST["hobbies"]) : ""; // 배열을 문자열로 변환하여 저장합니다.
$regist_day = date("Y-m-d (H:i)"); // 현재 날짜와 시간을 저장합니다.

// 뮤지션 여부를 체크하고 해당 정보를 변수에 저장합니다.
$level = isset($_POST["level"]) ? $_POST["level"] : "";
$musician = "아니요";
if (isset($_POST["musician"]) && $_POST["musician"] == '예') {
    $level = 2; // 뮤지션인 경우 레벨을 2로 설정합니다.
    $musician = "예";
}

// 파일 업로드 처리를 위한 변수들을 초기화합니다.
$upload_dir = './uploads/';
$upfile_name = isset($_FILES["upfile"]["name"]) ? $_FILES["upfile"]["name"] : "";
$upfile_tmp_name = isset($_FILES["upfile"]["tmp_name"]) ? $_FILES["upfile"]["tmp_name"] : "";
$upfile_type = isset($_FILES["upfile"]["type"]) ? $_FILES["upfile"]["type"] : "";
$upfile_size = isset($_FILES["upfile"]["size"]) ? $_FILES["upfile"]["size"] : 0;
$upfile_error = isset($_FILES["upfile"]["error"]) ? $_FILES["upfile"]["error"] : 0;

// 파일이 존재하고 업로드 오류가 없는 경우에만 처리합니다.
if ($upfile_name && !$upfile_error) {
    // 파일명과 확장자를 분리합니다.
    $file = explode(".", $upfile_name);
    $file_name = $file[0];
    $file_ext = $file[1];

    // 새로운 파일명을 생성하여 파일을 업로드할 경로를 지정합니다.
    $new_file_name = date("Y_m_d_H_i_s");
    $copied_file_name = $new_file_name . "." . $file_ext;
    $uploaded_file = $upload_dir . $copied_file_name;

    // 파일 크기가 1MB를 초과하는 경우 경고 메시지를 출력하고 이전 페이지로 이동합니다.
    if ($upfile_size > 1000000) {
        echo("
        <script>
        alert('업로드 파일 크기가 지정된 용량(1MB)을 초과합니다!<br>파일 크기를 체크해주세요!');
        history.go(-1);
        </script>
        ");
        exit;
    }

    // 파일을 지정한 디렉토리로 이동시킵니다. 실패 시에는 경고 메시지를 출력하고 이전 페이지로 이동합니다.
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
    $copied_file_name = ""; // 파일이 존재하지 않거나 업로드 오류가 있는 경우, 파일명을 초기화합니다.
}

// MySQL 데이터베이스에 접속합니다.
$con = mysqli_connect("localhost", "user1", "12345", "test");

// SQL 문을 생성합니다. 회원 정보를 UPDATE하는 쿼리를 작성합니다.
$sql = "UPDATE members SET 
    pass='$pass', 
    name='$name', 
    phone='$phone', 
    age='$age', 
    gender='$gender', 
    address='$address', 
    hobbies='$hobbies', 
    level='$level', 
    introduction='$introduction', 
    musician='$musician'";

// 만약 업로드된 파일이 있다면, 해당 파일명을 업데이트하는 SQL 문을 추가합니다.
if ($copied_file_name) {
    $sql .= ", file_name='$copied_file_name'";
}

// WHERE 조건을 추가하여 특정 회원의 정보를 업데이트합니다.
$sql .= " WHERE id='$id'";

// SQL 문을 실행합니다.
mysqli_query($con, $sql);

// 데이터베이스 연결을 종료합니다.
mysqli_close($con);

// 회원 정보 수정이 완료되면 메인 페이지로 이동하는 JavaScript 코드를 출력합니다.
echo "
<script>
location.href = 'index.php';
</script>
";
?>
