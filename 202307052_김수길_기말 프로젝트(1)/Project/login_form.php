<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>PHP 프로그래밍 입문</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/login.css">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<script type="text/javascript" src="./js/login.js"></script>

</head>
<?php include "header.php";?>
<body> 
	<section>	
        <div id="main_content">
      		<div id="login_box">
	    		<div id="login_title">
		    		<span>로그인</span>
	    		</div>
	    		<div id="login_form">
          		<form  name="login_form" method="post" action="login.php">		       	
                  	<ul>
                    <li><input type="text" name="id" placeholder="아이디" ></li>
                    <li><input type="password" id="pass" name="pass" placeholder="비밀번호" ></li> <!-- pass -->
                  	</ul>
                  	<div id="login_btn">
                      	<a href="#"><img src="./img/login.png" onclick="check_input()"></a>
                  	</div>		    	
           		</form>
        		</div> <!-- login_form -->
    		</div> <!-- login_box -->
        </div> <!-- main_content -->
            <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php
            // 슬라이드에 넣을 데이터 예시
            $slides = [
                'back2.jpg',
                'back4.jpg',
                'back13.jpg',
                'back3.png'
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
	</section> 
	<footer>
    	<?php include "footer.php";?>
    </footer>
</body>
</html>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="./js/scripts.js?after"></script>
