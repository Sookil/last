<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>공연 공지 게시판 목록</title>
<link rel="stylesheet" type="text/css" href="./css/common.css?">
<link rel="stylesheet" type="text/css" href="./css/board.css?">
<link rel="stylesheet" type="text/css" href="./css/custom.css?z">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
</head>
<body> 
<header>
    <?php include "header.php";?>
    <!-- 헤더를 include하여 페이지 상단에 공통 헤더를 출력 -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php
            // 슬라이드에 사용할 이미지 데이터 배열
            $slides = [
                'back.jpg',
                'back3.png',
                'back4.jpg',
                'back2.jpg'
            ];

            // 슬라이드 각각에 대한 HTML 출력
            foreach ($slides as $slide) {
                echo '<div class="swiper-slide"><img src="./img/' . $slide . '" alt="' . $slide . '"></div>';
            }
            ?>
        </div>
        
        <div class="swiper-pagination"></div>
        <!-- Swiper 플러그인을 위한 페이지네이션 요소 -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <!-- Swiper 이전/다음 버튼 요소 -->
        <div class="slide-title">SQUARE,<br>당신에게 무한한 감동을</div>
        <!-- 슬라이드 제목 -->
    </div>
</header>  
<section>
    <div id="board_box">
        <h3>공연 공지 게시판 > 목록보기</h3>
        <!-- 게시판 목록 제목 -->

        <ul id="board_list">
            <li>
                <!-- 테이블 헤더 -->
                <span class="col1">번호</span>
                <span class="col2">제목</span>
                <span class="col3">글쓴이</span>
                <span class="col4">첨부</span>
                <span class="col5">등록일</span>
                <span class="col6">조회</span>
                <span class="col7">찜</span> <!-- 새로 추가된 찜 기능 -->
            </li>

            <?php
            if (isset($_GET["page"]))  // 페이지 번호가 있으면 해당 페이지 번호를 가져옴
                $page = $_GET["page"];
            else
                $page = 1;  // 기본적으로 1페이지로 설정

            $con = mysqli_connect("localhost", "user1", "12345", "test");  // MySQL 데이터베이스 연결
            $sql = "select * from board order by num desc";  // num 기준으로 내림차순 정렬하여 모든 게시글 가져오기
            $result = mysqli_query($con, $sql);
            $total_record = mysqli_num_rows($result);  // 전체 게시글 수 계산

            $scale = 10;  // 한 페이지에 출력할 게시글 수

            // 전체 페이지 수 계산
            if ($total_record % $scale == 0)
                $total_page = floor($total_record / $scale);
            else
                $total_page = floor($total_record / $scale) + 1;

            // 현재 페이지에 따라 시작할 레코드 위치 계산
            $start = ($page - 1) * $scale;
            $number = $total_record - $start;  // 각 게시글에 붙일 일련번호 초기화

            // 페이지에 해당하는 범위 내의 게시글 데이터를 가져와서 출력
            for ($i = $start; $i < $start + $scale && $i < $total_record; $i++) {
                mysqli_data_seek($result, $i);  // 레코드 포인터를 해당 위치로 이동
                $row = mysqli_fetch_array($result);  // 결과 레코드 배열로 가져오기

                // 게시글 데이터 변수에 할당
                $num = $row["num"];
                $id = $row["id"];
                $name = $row["name"];
                $subject = $row["subject"];
                $regist_day = $row["regist_day"];
                $hit = $row["hit"];

                // 첨부 파일이 있으면 파일 아이콘 표시
                if ($row["file_name"])
                    $file_image = "<img src='./img/file.gif'>";
                else
                    $file_image = " ";
            ?>
            <li>
                <!-- 각 게시글 항목 -->
                <span class="col1"><?= $number ?></span>
                <span class="col2"><a href="board_view.php?num=<?= $num ?>&page=<?= $page ?>"><?= $subject ?></a></span>
                <span class="col3"><?= $name ?></span>
                <span class="col4"><?= $file_image ?></span>
                <span class="col5"><?= $regist_day ?></span>
                <span class="col6"><?= $hit ?></span>
                <!-- 찜 버튼을 통해 favorites.php로 이동하며 게시글 번호(num)를 전달 -->
                <span class="col7"><button onclick="location.href='favorites.php?num=<?= $num ?>'">찜/삭제</button></span>
            </li>
            <?php
                $number--;  // 다음 게시글을 위한 일련번호 줄이기
            }
            mysqli_close($con);  // MySQL 데이터베이스 연결 닫기
            ?>
        </ul> <!-- 게시글 목록 테이블 -->

        <ul id="page_num"> 
            <!-- 페이지 번호 목록 -->
            <?php
            if ($total_page >= 2 && $page >= 2) {
                $new_page = $page - 1;
                echo "<li><a href='board_list.php?page=$new_page'>◀ 이전</a></li>";
            } else
                echo "<li>&nbsp;</li>";

            // 페이지 링크 번호 출력
            for ($i = 1; $i <= $total_page; $i++) {
                if ($page == $i)
                    echo "<li><b> $i </b></li>";  // 현재 페이지 강조 표시
                else
                    echo "<li><a href='board_list.php?page=$i'> $i </a></li>";  // 페이지 번호 링크
            }

            if ($total_page >= 2 && $page != $total_page) {
                $new_page = $page + 1;
                echo "<li><a href='board_list.php?page=$new_page'>다음 ▶</a></li>";
            } else
                echo "<li>&nbsp;</li>";
            ?>
        </ul> <!-- 페이지 번호 목록 -->

        <ul class="buttons">                               
            <!-- 목록, 글쓰기 버튼 -->
            <li><button onclick="location.href='board_list.php'">목록</button></li>
            
            <?php 
            // 관리자 권한($userlevel == 1)일 때만 글쓰기 버튼 표시
            if ($userid && $userlevel == 1) {
            ?>
            <li><button onclick="location.href='board_form.php'">글쓰기</button></li>
            <?php
            } else {
            ?>
            <li><a href="javascript:alert('관리자가 아닙니다!')"><button>글쓰기</button></a></li>
            <?php
            }
            ?>
        </ul> <!-- 목록, 글쓰기 버튼 -->

    </div> <!-- board_box -->
</section> 
<footer>
    <?php include "footer.php";?>
</footer>
</body>
</html>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="./js/scripts.js"></script>

                                                                                                                                                