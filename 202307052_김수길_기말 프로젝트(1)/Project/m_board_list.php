<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>뮤지션 게시판 목록</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/board.css">
<link rel="stylesheet" type="text/css" href="./css/custom.css?z">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
</head>
<body> 
<header>
    <?php include "header.php";?>
    <!-- 헤더 영역 -->
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

            // 이미지 슬라이드 출력
            foreach ($slides as $slide) {
                echo '<div class="swiper-slide"><img src="./img/' . $slide . '" alt="' . $slide . '"></div>';
            }
            ?>
            
        </div>
        
        <div class="swiper-pagination"></div> <!-- 스와이퍼 페이징 -->
        <!-- 스와이퍼 이전/다음 버튼 -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <!-- 슬라이드 제목 -->
        <div class="slide-title">SQUARE,<br>당신에게 무한한 감동을</div>
    </div>
</header>  
<section>
    <!-- 본문 섹션 -->
    <div id="board_box">
        <h3>뮤지션 게시판 > 목록보기</h3>
        <ul id="board_list">
            <!-- 게시글 목록 테이블 헤더 -->
            <li>
                <span class="col1">번호</span>
                <span class="col2">제목</span>
                <span class="col3">글쓴이</span>
                <span class="col4">첨부</span>
                <span class="col5">등록일</span>
                <span class="col6">조회</span>
            </li>
            <?php
                // 페이지 번호 설정
                if (isset($_GET["page"]))
                    $page = $_GET["page"];
                else
                    $page = 1;

                // 데이터베이스 연결
                $con = mysqli_connect("localhost", "user1", "12345", "test");
                $sql = "SELECT * FROM m_board ORDER BY num DESC";
                $result = mysqli_query($con, $sql);
                $total_record = mysqli_num_rows($result); // 전체 글 수

                $scale = 10; // 한 페이지에 보여줄 글 수

                // 전체 페이지 수 계산
                if ($total_record % $scale == 0)
                    $total_page = floor($total_record / $scale);
                else
                    $total_page = floor($total_record / $scale) + 1;

                // 현재 페이지에서 보여줄 글의 시작 인덱스 계산
                $start = ($page - 1) * $scale;
                $number = $total_record - $start;

                // 데이터베이스에서 글 목록을 가져와 출력
                for ($i = $start; $i < $start + $scale && $i < $total_record; $i++) {
                    mysqli_data_seek($result, $i); // 레코드 포인터 이동
                    $row = mysqli_fetch_array($result); // 레코드 가져오기
                    $num = $row["num"];
                    $id = $row["id"];
                    $name = $row["name"];
                    $subject = $row["subject"];
                    $regist_day = $row["regist_day"];
                    $hit = $row["hit"];

                    // 첨부 파일 여부에 따른 아이콘 설정
                    if ($row["file_name"])
                        $file_image = "<img src='./img/file.gif'>";
                    else
                        $file_image = " ";
            ?>
            <!-- 각 글에 대한 목록 아이템 -->
            <li>
                <span class="col1"><?=$number?></span>
                <span class="col2"><a href="m_board_view.php?num=<?=$num?>&page=<?=$page?>"><?=$subject?></a></span>
                <span class="col3"><?=$name?></span>
                <span class="col4"><?=$file_image?></span>
                <span class="col5"><?=$regist_day?></span>
                <span class="col6"><?=$hit?></span>
            </li>
            <?php
                    $number--; // 글 번호 감소
                }
                mysqli_close($con); // 데이터베이스 연결 종료
            ?>
        </ul> <!-- board_list -->

        <!-- 페이지 번호 출력 -->
        <ul id="page_num">
            <?php
                // 이전 페이지 링크
                if ($total_page >= 2 && $page >= 2) {
                    $new_page = $page - 1;
                    echo "<li><a href='m_board_list.php?page=$new_page'>◀ 이전</a></li>";
                } else {
                    echo "<li>&nbsp;</li>";
                }

                // 페이지 번호 링크 출력
                for ($i = 1; $i <= $total_page; $i++) {
                    if ($page == $i) {
                        echo "<li><b> $i </b></li>"; // 현재 페이지는 강조 스타일
                    } else {
                        echo "<li><a href='m_board_list.php?page=$i'> $i </a></li>";
                    }
                }

                // 다음 페이지 링크
                if ($total_page >= 2 && $page != $total_page) {
                    $new_page = $page + 1;
                    echo "<li><a href='m_board_list.php?page=$new_page'>다음 ▶</a></li>";
                } else {
                    echo "<li>&nbsp;</li>";
                }
            ?>
        </ul> <!-- page_num -->

        <!-- 목록/글쓰기 버튼 -->
        <ul class="buttons">
            <li><button onclick="location.href='m_board_list.php'">목록</button></li>
            <li>
                <?php 
                    // 로그인된 사용자가 관리자 혹은 특정 권한을 가지고 있을 경우 글쓰기 버튼 출력
                    if ($userid && ($userlevel == 1 || $userlevel == 2)) {
                ?>
                <button onclick="location.href='m_board_form.php'">글쓰기</button>
                <?php
                    } else {
                ?>
                <!-- 특정 권한을 가진 사용자가 아닐 경우에는 경고 메시지와 함께 글쓰기 버튼 출력 불가능 -->
                <a href="javascript:alert('뮤지션만 작성 가능합니다!')"><button>글쓰기</button></a>
                <?php
                    }
                ?>
            </li>
        </ul> <!-- buttons -->
    </div> <!-- board_box -->
</section> <!-- section -->
<footer>
    <?php include "footer.php";?>
</footer>
</body>
</html>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="./js/scripts.js"></script>
