

<?php

	$num = $_GET["num"]; // GET 방식으로 전달된 num 파라미터를 가져와 변수 $num에 저장합니다.

	$mode = $_GET["mode"]; // GET 방식으로 전달된 mode 파라미터를 가져와 변수 $mode에 저장합니다.



	$con = mysqli_connect("localhost", "user1", "12345", "test"); // 데이터베이스에 연결합니다.


	$sql = "delete from message where num=$num"; // 메시지 테이블에서 num 값이 $num인 레코드를 삭제하는 SQL 쿼리를 준비합니다.

	mysqli_query($con, $sql); // 준비된 SQL 쿼리를 실행하여 메시지 테이블에서 해당 레코드를 삭제합니다.



	mysqli_close($con); // 데이터베이스 연결을 닫습니다. DB 연결 끊기



	if($mode == "send")
		$url = "message_box.php?mode=send"; // $mode가 "send"일 경우 송신 쪽지함 페이지로 이동할 URL을 설정합니다.
	else
		$url = "message_box.php?mode=rv"; // $mode가 "send"가 아닐 경우 수신 쪽지함 페이지로 이동할 URL을 설정합니다.



	echo "

	<script>

		location.href = '$url'; 

	</script>

	";

?>

