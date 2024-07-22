<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>공연홍보사이트</title>
<link rel="stylesheet" type="text/css" href="./css/common.css?z">
<link rel="stylesheet" type="text/css" href="./css/custom.css?z">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
</head>
<body> 
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
   <section class="features">
    <div class="container">
        <h2> 더 많은 공연 정보 </h2>
        <div class="feature-list">
            <div class="feature-item" onclick="location.href='http://ticket.yes24.com/New/Perf/Detail/Detail.aspx?IdPerf=36028'">
                <img src="./img/back1.jpg" alt="아이콘 1">
                <h3>Turn on that Blue Vinyl</h3>
                <p>"블루 바이닐을 틀어줘요."</p>
            </div>
            <div class="feature-item" onclick="location.href='https://tickets.interpark.com/goods/23005010'">
                <img src="./img/back11.jpg" alt="아이콘 2">
                <h3>Square</h3>
                <p>"과거와 현재 그리고 다음"</p>
            </div>
            <div class="feature-item" onclick="location.href='https://tickets.interpark.com/goods/24001411'">
                <img src="./img/jinah.jpg" alt="아이콘 3">
                <h3>꽃 말</h3>
                <p>"자신만의 이야기를 품는 한 송이 꽃"</p>
            </div>
            <div class="feature-item" onclick="location.href='https://tickets.interpark.com/goods/23008938'">
                <img src="./img/gun2.jpg" alt="아이콘 3">
                <h3>Love me</h3>
                <p>"오로지 당신들을 위한"</p>
            </div>
        </div>
    </div>
   </section>
   <div id="main_content">
        <div id="latest">
            <h4>공연 공지 게시판 </h4>
            <ul>
    <!-- 최근 게시 글 DB에서 불러오기 -->
    <?php
        $con = mysqli_connect("localhost", "user1", "12345", "test");
        $sql = "select * from board order by num desc limit 5";
        $result = mysqli_query($con, $sql);

        if (!$result)
            echo "게시판 DB 테이블(board)이 생성 전이거나 아직 게시글이 없습니다!";
        else
        {
            while( $row = mysqli_fetch_array($result) )
            {
                $regist_day = substr($row["regist_day"], 0, 10);
    ?>
            <li>
                <span><?=$row["subject"]?></a></span>
                <span><?=$row["name"]?></span>
                <span><?=$regist_day?></span>
            </li>
    <?php
            }
        }
    ?>
        </div>
    </div>
</body>
</html>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="./js/scripts.js?after"></script>