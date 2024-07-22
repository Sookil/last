<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>PHP 프로그래밍 입문</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/message.css">
</head>
<body> 
<header>
    <?php include "header.php";?>
</header>  
<section>
    
    <div id="message_box">
        <h3 class="title">
<?php
    // GET 방식으로 전달된 mode와 num 값을 변수에 저장
    $mode = $_GET["mode"];
    $num  = $_GET["num"];

    // 데이터베이스 연결
    $con = mysqli_connect("localhost", "user1", "12345", "test");
    
    // num 값을 이용하여 message 테이블에서 해당하는 레코드를 조회하는 쿼리
    $sql = "select * from message where num=$num";
    $result = mysqli_query($con, $sql);

    // 조회된 결과를 배열로 변환
    $row = mysqli_fetch_array($result);
    $send_id    = $row["send_id"]; // 송신자 ID
    $rv_id      = $row["rv_id"]; // 수신자 ID
    $regist_day = $row["regist_day"]; // 등록일
    $subject    = $row["subject"]; // 제목
    $content    = $row["content"]; // 내용

    // 내용에서 공백을 &nbsp;로 변경하여 출력 형식을 조정
    $content = str_replace(" ", "&nbsp;", $content);
    // 내용에서 줄바꿈을 <br>로 변경하여 HTML 줄바꿈으로 변환
    $content = str_replace("\n", "<br>", $content);

    // mode 값에 따라 송신 쪽지함 또는 수신 쪽지함을 결정하여 출력할 메시지의 이름을 조회
    if ($mode=="send")
        $result2 = mysqli_query($con, "select name from members where id='$rv_id'");
    else
        $result2 = mysqli_query($con, "select name from members where id='$send_id'");

    // 조회된 결과에서 이름을 추출
    $record = mysqli_fetch_array($result2);
    $msg_name = $record["name"];

    // mode 값에 따라 제목을 설정하여 출력
    if ($mode=="send")          
        echo "송신 쪽지함 > 내용보기";
    else
        echo "수신 쪽지함 > 내용보기";
?>
        </h3>
        <ul id="view_content">
            <li>
                <span class="col1"><b>제목 :</b> <?=$subject?></span>
                <span class="col2"><?=$msg_name?> | <?=$regist_day?></span>
            </li>
            <li>
                <?=$content?>
            </li>       
        </ul>
        <ul class="buttons">
                <!-- 각 버튼 클릭 시 해당 페이지로 이동하는 버튼들 -->
                <li><button onclick="location.href='message_box.php?mode=rv'">수신 쪽지함</button></li>
                <li><button onclick="location.href='message_box.php?mode=send'">송신 쪽지함</button></li>
                <li><button onclick="location.href='message_response_form.php?num=<?=$num?>'">답변 쪽지</button></li>
                <li><button onclick="location.href='message_delete.php?num=<?=$num?>&mode=<?=$mode?>'">삭제</button></li>
        </ul>
    </div> <!-- message_box -->
</section> 
<footer>
    <?php include "footer.php";?>
</footer>
</body>
</html>
