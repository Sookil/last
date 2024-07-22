<?php
// header 설정: UTF-8 인코딩으로 설정
header('Content-Type: text/html; charset=UTF-8');
?>
<?php
    // GET 방식으로 전달된 send_id 값을 변수에 저장
    $send_id = $_GET["send_id"];

    // POST 방식으로 전달된 데이터를 변수에 저장
    $rv_id = $_POST['rv_id'];
    $subject = $_POST['subject'];
    $content = $_POST['content'];

    // HTML 특수 문자를 변환하여 XSS 공격을 방지하는 htmlspecialchars 함수 적용
	$subject = htmlspecialchars($subject, ENT_QUOTES);
	$content = htmlspecialchars($content, ENT_QUOTES);
	
    // 현재 시간을 '년-월-일 (시:분)' 형식으로 저장
    $regist_day = date("Y-m-d (H:i)");

    // send_id가 없는 경우, 즉 로그인 되어 있지 않은 상태에서 접근한 경우 처리
	if(!$send_id) {
		echo("
			<script>
			alert('로그인 후 이용해 주세요! ');
			history.go(-1)
			</script>
		");
		exit; // 스크립트 실행 종료
	}

	// 데이터베이스 연결
	$con = mysqli_connect("localhost", "user1", "12345", "test");

	// 수신자 ID(rv_id)로 회원 정보를 조회하는 쿼리 실행
	$sql = "select * from members where id='$rv_id'";
	$result = mysqli_query($con, $sql);
	$num_record = mysqli_num_rows($result); // 조회된 레코드 수

	// 수신자 ID가 존재하는 경우
	if($num_record)
	{
		// 메시지 테이블에 데이터를 삽입하는 쿼리 생성
		$sql = "insert into message (send_id, rv_id, subject, content,  regist_day) ";
		$sql .= "values('$send_id', '$rv_id', '$subject', '$content', '$regist_day')";
		mysqli_query($con, $sql);  // 쿼리 실행
	} else { // 수신자 ID가 존재하지 않는 경우
		echo("
			<script>
			alert('수신 아이디가 잘못 되었습니다!');
			history.go(-1)
			</script>
		");
		exit; // 스크립트 실행 종료
	}

	mysqli_close($con); // 데이터베이스 연결 종료

	// 메시지 전송 후 송신 쪽지함 페이지로 이동하는 JavaScript 코드 출력
	echo "
	   <script>
	    location.href = 'message_box.php?mode=send';
	   </script>
	";
?>
