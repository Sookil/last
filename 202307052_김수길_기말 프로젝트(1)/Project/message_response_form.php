<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>PHP 프로그래밍 입문</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/message.css">
<script>
  // 입력 값 검증 함수
  function check_input() {
      // 제목 입력 여부 확인
      if (!document.message_form.subject.value)
      {
          alert("제목을 입력하세요!");
          document.message_form.subject.focus();
          return;
      }
      // 내용 입력 여부 확인
      if (!document.message_form.content.value)
      {
          alert("내용을 입력하세요!");    
          document.message_form.content.focus();
          return;
      }
      // 폼을 서버로 제출
      document.message_form.submit();
   }
</script>
</head>
<body> 
<header>
    <?php include "header.php";?>
</header>  
<section>
    <div id="main_img_bar">
        <img src="./img/main_img.png">
    </div>
    <div id="message_box">
        <h3 id="write_title">
            답변 쪽지 보내기
        </h3>
<?php
    // GET 방식으로 전달된 num 값을 변수에 저장
    $num  = $_GET["num"];

    // 데이터베이스 연결
    $con = mysqli_connect("localhost", "user1", "12345", "test");
    
    // num 값을 이용하여 message 테이블에서 해당하는 레코드를 조회하는 쿼리
    $sql = "select * from message where num=$num";
    $result = mysqli_query($con, $sql);

    // 조회 결과를 배열로 변환
    $row = mysqli_fetch_array($result);
    $send_id      = $row["send_id"]; // 송신자 ID
    $rv_id      = $row["rv_id"]; // 수신자 ID
    $subject    = $row["subject"]; // 제목
    $content    = $row["content"]; // 내용

    // 제목에 'RE: '을 추가하여 답변임을 표시
    $subject = "RE: ".$subject; 

    // 내용 앞에 '>' 추가하여 이메일 답변 형식으로 변경
    $content = "> ".$content; 
    $content = str_replace("\n", "\n>", $content); // 각 줄 맨 앞에 '>' 추가
    $content = "\n\n\n-----------------------------------------------\n".$content; // 구분선 추가

    // 송신자의 이름을 members 테이블에서 조회하여 가져옴
    $result2 = mysqli_query($con, "select name from members where id='$send_id'");
    $record = mysqli_fetch_array($result2);
    $send_name    = $record["name"]; // 송신자 이름
?>      
        <form  name="message_form" method="post" action="message_insert.php?send_id=<?=$userid?>">
            <input type="hidden" name="rv_id" value="<?=$send_id?>">
            <div id="write_msg">
                <ul>
                <li>
                    <span class="col1">보내는 사람 : </span>
                    <span class="col2"><?=$userid?></span>
                </li>   
                <li>
                    <span class="col1">수신 아이디 : </span>
                    <span class="col2"><?=$send_name?>(<?=$send_id?>)</span>
                </li>   
                <li>
                    <span class="col1">제목 : </span>
                    <span class="col2"><input name="subject" type="text" value="<?=$subject?>"></span>
                </li>           
                <li id="text_area">   
                    <span class="col1">글 내용 : </span>
                    <span class="col2">
                        <textarea name="content"><?=$content?></textarea>
                    </span>
                </li>
                </ul>
                <button type="button" onclick="check_input()">보내기</button>
            </div>
        </form>
    </div> <!-- message_box -->
</section> 
<footer>
    <?php include "footer.php";?>
</footer>
</body>
</html>
