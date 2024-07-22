<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>PHP 프로그래밍 입문</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/board.css">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<?php include "header.php";?>
</head>
<body> 
    <!-- Swiper 슬라이더 컨테이너 -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php
            // 슬라이드에 사용할 이미지 데이터
            $slides = [
                'back2.jpg',
                'back4.jpg',
                'back13.jpg',
                'back3.png'
            ];

            // 각 이미지에 대한 슬라이드 생성
            foreach ($slides as $slide) {
                echo '<div class="swiper-slide"><img src="./img/' . $slide . '" alt="' . $slide . '"></div>';
            }
            ?>
            
        </div>
        
        <!-- 스와이퍼 페이지네이션 -->
        <div class="swiper-pagination"></div>
        <!-- 이전/다음 버튼 -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <!-- 슬라이드 제목 -->
        <div class="slide-title">SQUARE,<br>당신에게 무한한 감동을</div>
    </div>

<section>
	
   	<div id="board_box">
	    <h3 class="title">
			뮤지션 게시판 > 내용보기
		</h3>
<?php
	$num  = $_GET["num"]; // URL 매개변수에서 게시물 번호 가져오기
	$page  = $_GET["page"]; // URL 매개변수에서 페이지 번호 가져오기

	$con = mysqli_connect("localhost", "user1", "12345", "test"); // MySQL 데이터베이스 연결
	$sql = "select * from m_board where num=$num"; // 해당 게시물 번호에 맞는 데이터 조회 쿼리
	$result = mysqli_query($con, $sql); // 쿼리 실행하여 결과 가져오기

	$row = mysqli_fetch_array($result); // 조회된 데이터를 배열로 변환
	$id      = $row["id"]; // 작성자 아이디
	$name      = $row["name"]; // 작성자 이름
	$regist_day = $row["regist_day"]; // 작성일
	$subject    = $row["subject"]; // 제목
	$content    = $row["content"]; // 내용
	$file_name    = $row["file_name"]; // 첨부 파일명
	$file_type    = $row["file_type"]; // 첨부 파일 타입
	$file_copied  = $row["file_copied"]; // 서버에 저장된 첨부 파일명
	$hit          = $row["hit"]; // 조회수

	$content = str_replace(" ", "&nbsp;", $content); // 공백을 HTML 공백 문자로 대체
	$content = str_replace("\n", "<br>", $content); // 줄 바꿈을 <br> 태그로 대체

	$new_hit = $hit + 1; // 조회수 증가
	$sql = "update m_board set hit=$new_hit where num=$num"; // 조회수 증가 쿼리 실행   
	mysqli_query($con, $sql); // 쿼리 실행

?>		
	    <!-- 게시물 내용 표시 -->
	    <ul id="view_content">
			<li>
				<span class="col1"><b>제목 :</b> <?=$subject?></span> <!-- 제목 표시 -->
				<span class="col2"><?=$name?> | <?=$regist_day?></span> <!-- 작성자와 작성일 표시 -->
			</li>
			<li>
				<?php
					// 첨부 파일이 있을 경우 표시
					if($file_name) {
						$real_name = $file_copied;
						$file_path = "./data/".$real_name;
						$file_size = filesize($file_path);

						echo "▷ 첨부파일 : $file_name ($file_size Byte) &nbsp;&nbsp;&nbsp;&nbsp;
			       		<a href='m_board_download.php?num=$num&real_name=$real_name&file_name=$file_name&file_type=$file_type'>[저장]</a><br><br>";
			           	}
				?>
				<?=$content?> <!-- 게시물 내용 표시 -->
			</li>		
	    </ul>
	    <!-- 버튼 그룹 -->
	    <ul class="buttons">
				<li><button onclick="location.href='m_board_list.php?page=<?=$page?>'">목록</button></li> <!-- 목록으로 돌아가기 버튼 -->
                                <?php
                                 // 작성자 또는 관리자 권한이 있는 경우 수정
                                 if($userid && ($userlevel == 1 || ($userlevel == 2 && $userid == $id))){
                                ?>
                                <li><button onclick="location.href='m_board_modify_form.php?num=<?=$num?>&page=<?=$page?>'">수정</button></li> <!-- 수정하기 버튼 -->
                                <?php
                                } else{
                                 ?>
                                   <a href="javascript:alert('작성자만 수정하실 수 있습니다!')"><button>수정</button></a>
                                <?php
                                }
                                ?>
		
				<li><?php
                                // 작성자 또는 관리자 권한이 있는 경우 삭제
                                if($userid && ($userlevel == 1 || ($userlevel == 2 && $userid == $id))){
                                ?>
                                <button onclick="location.href='m_board_delete.php?num=<?=$num?>&page=<?=$page?>'">삭제</button> <!-- 삭제하기 버튼 -->
                                <?php
                                } else{
                                ?>
                                    <a href="javascript:alert('작성자만 삭제하실 수 있습니다!')"><button>삭제</button></a>
                                <?php
                                }
                                ?>
				</li>
				<li>
                                <?php 
                                        // 로그인한 사용자가 관리자 또는 특정 권한을 가진 경우 글쓰기 버튼 표시
                                        if($userid && ($userlevel == 1 || $userlevel == 2)) {
                                    ?>
					<button onclick="location.href='m_board_form.php'">글쓰기</button>
                                    <?php
                                    } else {
                                    ?>
					<a href="javascript:alert('뮤지션만 작성 가능합니다!')"><button>글쓰기</button></a>
                                    <?php
                                    }
                               ?>
				</li>
		</ul>
	</div> <!-- board_box -->
</section> 
<footer>
    <?php include "footer.php";?> <!-- footer.php 파일 포함 -->
</footer>
</body>
</html>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="./js/scripts.js?after"></script>
