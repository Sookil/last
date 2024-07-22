<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>목록</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/board.css">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
</head>
<?php include "header.php";?>
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
			공연 공지 게시판 > 내용보기
		</h3>
<?php
	$num  = $_GET["num"];  // GET으로 전달된 글 번호 가져오기
	$page = isset($_GET["page"]) ? $_GET["page"] : 1;  // GET으로 전달된 페이지 번호 가져오기 (기본값은 1)

	$con = mysqli_connect("localhost", "user1", "12345", "test");  // MySQL 데이터베이스 연결
	$sql = "select * from board where num=$num";  // 글 번호에 해당하는 게시글 조회 쿼리
	$result = mysqli_query($con, $sql);  // 쿼리 실행

	$row = mysqli_fetch_array($result);  // 결과에서 한 줄 가져오기
	$id      = $row["id"];  // 작성자 ID
	$name      = $row["name"];  // 작성자 이름
	$regist_day = $row["regist_day"];  // 등록일
	$subject    = $row["subject"];  // 제목
	$content    = $row["content"];  // 내용
	$file_name    = $row["file_name"];  // 첨부 파일 이름
	$file_type    = $row["file_type"];  // 첨부 파일 유형
	$file_copied  = $row["file_copied"];  // 첨부 파일 복사된 이름
	$hit          = $row["hit"];  // 조회수

	$content = str_replace(" ", "&nbsp;", $content);  // 내용의 공백을 &nbsp;로 변환하여 HTML에서 줄바꿈 유지
	$content = str_replace("\n", "<br>", $content);  // 내용의 개행을 <br>로 변환하여 HTML에서 줄바꿈 유지

	$new_hit = $hit + 1;  // 조회수 증가
	$sql = "update board set hit=$new_hit where num=$num";  // 조회수 업데이트 쿼리
	mysqli_query($con, $sql);  // 쿼리 실행
?>		
	    <ul id="view_content">
			<li>
				<span class="col1"><b>제목 :</b> <?=$subject?></span>
				<span class="col2"><?=$name?> | <?=$regist_day?></span>  <!-- 작성자 이름과 등록일 표시 -->
			</li>
			<li>
				<?php
					if($file_name) {  // 첨부 파일이 있는 경우
						$real_name = $file_copied;  // 실제 저장된 파일 이름
						$file_path = "./data/".$real_name;  // 파일 경로
						$file_size = filesize($file_path);  // 파일 크기

						echo "▷ 첨부파일 : $file_name ($file_size Byte) &nbsp;&nbsp;&nbsp;&nbsp;
			       		<a href='board_download.php?num=$num&real_name=$real_name&file_name=$file_name&file_type=$file_type'>[저장]</a><br><br>";
			       		// 첨부 파일 다운로드 링크 출력
			       	}
				?>
				<?=$content?>  <!-- 게시글 내용 출력 -->
			</li>		
	    </ul>
	    <ul class="buttons">
				<li><button onclick="location.href='board_list.php?page=<?=$page?>'">목록</button></li>  <!-- 목록 버튼 -->
                                <?php
                                 if($userid == $id){  // 작성자와 로그인 사용자가 동일한 경우
                                ?>
                                <li><button onclick="location.href='board_modify_form.php?num=<?=$num?>&page=<?=$page?>'">수정</button></li> <!-- 수정하기 버튼 -->
                                <?php
                                } else{  // 작성자와 로그인 사용자가 다른 경우
                                 ?>
                                   <a href="javascript:alert('관리자만 수정하실 수 있습니다!')"><button>수정</button></a>  <!-- 수정 불가능 알림 -->
                                <?php
                                }
                                ?>
		
				<li><?php
                                if($userid == $id){  // 작성자와 로그인 사용자가 동일한 경우
                                ?>
                                <li><button onclick="location.href='board_delete.php?num=<?=$num?>&page=<?=$page?>'">삭제</button></li> <!-- 삭제하기 버튼 -->
                                <?php
                                } else{  // 작성자와 로그인 사용자가 다른 경우
                                ?>
                                    <a href="javascript:alert('관리자만 삭제하실 수 있습니다!')"><button>삭제</button></a>  <!-- 삭제 불가능 알림 -->
                                <?php
                                }
                                ?>
				<li><?php 
                                        if($userid && $userlevel == 1 ) {  // 로그인 사용자가 관리자일 경우
                                    ?>
					<button onclick="location.href='board_form.php'">글쓰기</button>  <!-- 글쓰기 버튼 -->
                                    <?php
                                    } else {  // 로그인 사용자가 일반 사용자일 경우
                                    ?>
					<a href="javascript:alert('관리자만 작성 가능합니다!')"><button>글쓰기</button></a>  <!-- 글쓰기 불가능 알림 -->
                                    <?php
                                    }
                               ?></li>
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
