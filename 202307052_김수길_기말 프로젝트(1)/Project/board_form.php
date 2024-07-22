<!DOCTYPE html>
<html>
<head> 
    <meta charset="utf-8">
    <title>글쓰기</title>
    <link rel="stylesheet" type="text/css" href="./css/common.css">
    <link rel="stylesheet" type="text/css" href="./css/board.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <script>
        // 사용자 입력을 검사하여 필수 입력 항목이 비어있으면 경고 메시지를 표시하고 해당 입력 항목에 포커스를 맞추는 함수
        function check_input() {
            if (!document.board_form.subject.value) {
                alert("제목을 입력하세요!");
                document.board_form.subject.focus();
                return;
            }
            if (!document.board_form.content.value) {
                alert("내용을 입력하세요!");    
                document.board_form.content.focus();
                return;
            }
            document.board_form.submit();  // 모든 필수 입력 항목이 채워졌을 경우 폼을 서버로 제출한다.
        }
    </script>
</head>
<body> 
<header>
    <?php include "header.php"; ?>
    <!-- Swiper 슬라이더 컨테이너 -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php
            // 슬라이드에 사용할 이미지 파일명 배열
            $slides = [
                'back.jpg',
                'back3.png',
                'back4.jpg',
                'back2.jpg'
            ];

            // 배열에 있는 각 이미지를 슬라이드로 출력한다
            foreach ($slides as $slide) {
                echo '<div class="swiper-slide"><img src="./img/' . $slide . '" alt="' . $slide . '"></div>';
            }
            ?>
            
        </div>
        
        <!-- 슬라이더 페이지네이션 -->
        <div class="swiper-pagination"></div>
        <!-- 이전/다음 버튼 -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <!-- 슬라이드 제목 -->
        <div class="slide-title">SQUARE,<br>당신에게 무한한 감동을</div>
    </div>
</header>  
<section>
    <div id="board_box">
        <h3 id="board_title">공연 공지 게시판 > 글 쓰기</h3>
        <form name="board_form" method="post" action="board_insert.php" enctype="multipart/form-data">
            <ul id="board_form">
                <li>
                    <span class="col1">이름 : </span>
                    <span class="col2"><?= $username ?></span>
                </li>		
                <li>
                    <span class="col1">제목 : </span>
                    <span class="col2"><input name="subject" type="text"></span>
                </li>	    	
                <li id="text_area">	
                    <span class="col1">내용 : </span>
                    <span class="col2"><textarea name="content"></textarea></span>
                </li>
                <li>
                    <span class="col1"> 첨부 파일</span>
                    <span class="col2"><input type="file" name="upfile"></span>
                </li>
            </ul>
            <ul class="buttons">
                <li><button type="button" onclick="check_input()">완료</button></li>
                <li><button type="button" onclick="location.href='board_list.php'">목록</button></li>
            </ul>
        </form>
    </div> <!-- board_box -->
</section> 
<footer>
    <?php include "footer.php"; ?>
</footer>
<!-- Swiper 슬라이더 라이브러리 -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<!-- 사용자 정의 스크립트 -->
<script src="./js/scripts.js?after"></script>
</body>
</html>
