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
<section>
   	<div id="board_box">
	    <h3 class="title">
			자유게시판 > 내용보기
		</h3>
<?php
	$num  = $_GET["num"];
	$page  = $_GET["page"];

	// 데이터베이스 연결
	$con = mysqli_connect("localhost", "user1", "12345", "test");
	$sql = "select * from f_board where num=$num";
	$result = mysqli_query($con, $sql);

	$row = mysqli_fetch_array($result);
	$id      = $row["id"];
	$name      = $row["name"];
	$regist_day = $row["regist_day"];
	$subject    = $row["subject"];
	$content    = $row["content"];
	$file_name    = $row["file_name"];
	$file_type    = $row["file_type"];
	$file_copied  = $row["file_copied"];
	$hit          = $row["hit"];

	// 내용 줄바꿈 처리
	$content = str_replace(" ", "&nbsp;", $content);
	$content = str_replace("\n", "<br>", $content);

	// 조회수 증가
	$new_hit = $hit + 1;
	$sql = "update f_board set hit=$new_hit where num=$num";   
	mysqli_query($con, $sql);
?>		
	    <ul id="view_content">
			<li>
				<span class="col1"><b>제목 :</b> <?=$subject?></span>
				<span class="col2"><?=$name?> | <?=$regist_day?></span>
			</li>
			<li>
				<?php
					if($file_name) {
						$real_name = $file_copied;
						$file_path = "./data/".$real_name;
						$file_size = filesize($file_path);

						echo "▷ 첨부파일 : $file_name ($file_size Byte) &nbsp;&nbsp;&nbsp;&nbsp;
			       		<a href='f_board_download.php?num=$num&real_name=$real_name&file_name=$file_name&file_type=$file_type'>[저장]</a><br><br>";
			        }
				?>
				<?=$content?>
			</li>		
	    </ul>
	    <ul class="buttons">
			<li><button onclick="location.href='f_board_list.php?page=<?=$page?>'">목록</button></li>
			<?php
				// 로그인한 사용자와 게시글 작성자가 동일하거나 관리자일 경우에만 수정, 삭제 버튼을 보여줍니다.
				if($userid == $id || $userlevel == 1) {
			?>
			<li><button onclick="location.href='f_board_modify_form.php?num=<?=$num?>&page=<?=$page?>'">수정</button></li> <!-- 수정하기 버튼 -->
			<?php
				} else {
			?>
			<a href="javascript:alert('작성자만 수정하실 수 있습니다!')"><button>수정</button></a>
			<?php
				}
			?>
			<?php
				// 로그인한 사용자와 게시글 작성자가 동일하거나 관리자일 경우에만 삭제 버튼을 보여줍니다.
				if($userid == $id || $userlevel == 1) {
			?>
			<li><button onclick="location.href='f_board_delete.php?num=<?=$num?>&page=<?=$page?>'">삭제</button></li> <!-- 삭제하기 버튼 -->
			<?php
				} else {
			?>
			<a href="javascript:alert('작성자만 삭제하실 수 있습니다!')"><button>삭제</button></a>
			<?php
				}
			?>
			<li><button onclick="location.href='f_board_form.php'">글쓰기</button></li>
		</ul>
	</div> <!-- board_box -->
</section> 
<footer>
    <?php include "footer.php";?>
</footer>
</body>
</html>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="./js/scripts.js?after"></script>
