<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>쪽지 게시판 목록</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/message.css?">
<link rel="stylesheet" type="text/css" href="./css/custom.css?after">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<script>
  function check_input() {
      // 함수 정의: 사용자가 입력한 값들을 검증하는 함수
      if (!document.message_form.rv_id.value)
      {
          alert("수신 아이디를 입력하세요!"); // 수신 아이디가 비어있으면 경고창을 띄우고
          document.message_form.rv_id.focus(); // 포커스를 수신 아이디 입력 필드로 이동합니다.
          return;
      }
      if (!document.message_form.subject.value)
      {
          alert("제목을 입력하세요!"); // 제목이 비어있으면 경고창을 띄우고
          document.message_form.subject.focus(); // 포커스를 제목 입력 필드로 이동합니다.
          return;
      }
      if (!document.message_form.content.value)
      {
          alert("내용을 입력하세요!"); // 내용이 비어있으면 경고창을 띄우고
          document.message_form.content.focus(); // 포커스를 내용 입력 필드로 이동합니다.
          return;
      }
      document.message_form.submit(); // 모든 조건을 통과하면 form을 제출합니다.
   }
</script>
</head>
<body> 
<header>
    <?php include "header.php";?>
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php
            // 슬라이드에 넣을 데이터 예시
            $slides = [
                'back.jpg',
                'back3.png',
                'back4.jpg',
                'back2.jpg'
            ];

            foreach ($slides as $slide) {
                echo '<div class="swiper-slide"><img src="./img/' . $slide . '" alt="' . $slide . '"></div>';
            }
            ?>
            
        </div>
        
        <div class="swiper-pagination"></div>
        <!-- Add Navigation -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="slide-title">SQUARE,<br>당신에게 무한한 감동을</div>
    </div>
    
</header>  
<?php
    // 사용자가 로그인하지 않은 경우 처리
	if (!$userid )
	{
		echo("<script>
				alert('로그인 후 이용해주세요!'); // 경고창을 띄우고
				history.go(-1); // 이전 페이지로 이동합니다.
				</script>
			");
		exit; // 스크립트 실행을 종료합니다.
	}
?>
<section>
	
   	<div id="message_box">
	    <h3 id="write_title">
	    		쪽지 보내기
		</h3>
		<ul class="top_buttons">
				<li><span><a href="message_box.php?mode=rv">수신 쪽지함 </a></span></li>
				<li><span><a href="message_box.php?mode=send">송신 쪽지함</a></span></li>
		</ul>
	    <form  name="message_form" method="post" action="message_insert.php?send_id=<?=$userid?>">
	    	<div id="write_msg">
	    	    <ul>
				<li>
					<span class="col1">보내는 사람 : </span>
					<span class="col2"><?=$userid?></span>
				</li>	
				<li>
					<span class="col1">수신 아이디 : </span>
					<span class="col2"><input name="rv_id" type="text"></span>
				</li>	
	    		<li>
	    			<span class="col1">제목 : </span>
	    			<span class="col2"><input name="subject" type="text"></span>
	    		</li>	    	
	    		<li id="text_area">	
	    			<span class="col1">내용 : </span>
	    			<span class="col2">
	    				<textarea name="content"></textarea>
	    			</span>
	    		</li>
	    	    </ul>
	    	    <button type="button" onclick="check_input()">보내기</button> <!-- 버튼 클릭 시 check_input 함수 호출 -->
	    	</div>	    	
	    </form>
	</div> <!-- message_box -->
</section> 
<footer>
    <?php include "footer.php";?>
</footer>
</body>
</html>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="./js/scripts.js"></script>
