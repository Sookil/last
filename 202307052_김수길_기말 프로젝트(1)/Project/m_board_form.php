<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>PHP 프로그래밍 입문</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/board.css">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<script>
  // 사용자 입력 유효성 검사 함수 정의
  function check_input() {
      // 제목 입력 확인
      if (!document.m_board_form.subject.value)
      {
          alert("제목을 입력하세요!");
          document.m_board_form.subject.focus();
          return;
      }
      // 내용 입력 확인
      if (!document.m_board_form.content.value)
      {
          alert("내용을 입력하세요!");    
          document.m_board_form.content.focus();
          return;
      }
      // 모든 조건이 충족되면 폼을 제출합니다.
      document.m_board_form.submit();
   }
</script>
</head>
<body> 
<header>
    <?php include "header.php";?>
    <!-- Swiper 슬라이드 쇼 설정 -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php
            // 슬라이드에 사용할 이미지 파일 리스트
            $slides = [
                'back.jpg',
                'back3.png',
                'back4.jpg',
                'back2.jpg'
            ];

            // 이미지 슬라이드를 출력하는 반복문
            foreach ($slides as $slide) {
                echo '<div class="swiper-slide"><img src="./img/' . $slide . '" alt="' . $slide . '"></div>';
            }
            ?>
        </div>
        
        <!-- 슬라이드 페이지네이션 및 네비게이션 버튼 -->
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <!-- 슬라이드 제목 -->
        <div class="slide-title">SQUARE,<br>당신에게 무한한 감동을</div>
    </div>
</header>  
<section>
    <div id="board_box">
        <h3 id="board_title">
            뮤지션 게시판 > 글 쓰기
        </h3>
        <!-- 글 작성 폼 -->
        <form name="m_board_form" method="post" action="m_board_insert.php" enctype="multipart/form-data">
            <ul id="board_form">
                <li>
                    <span class="col1">이름 : </span>
                    <span class="col2"><?=$username?></span>
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
                <li>
                    <span class="col1"> 첨부 파일</span>
                    <span class="col2"><input type="file" name="upfile"></span>
                </li>
            </ul>
            <!-- 버튼 영역 -->
            <ul class="buttons">
                <li><button type="button" onclick="check_input()">완료</button></li>
                <li><button type="button" onclick="location.href='m_board_list.php'">목록</button></li>
            </ul>
        </form>
    </div> <!-- board_box -->
</section> 
<footer>
    <?php include "footer.php";?>
</footer>
</body>
</html>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="./js/scripts.js"></script>
