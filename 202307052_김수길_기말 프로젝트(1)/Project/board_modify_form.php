<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>글쓰기</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/board.css">
<script type="text/javascript" src="./js/member_modify.js?"></script>
<script>
  // 입력 유효성 검사 함수
  function check_input() {
      if (!document.board_form.subject.value)
      {
          alert("제목을 입력하세요!");  // 제목 입력 확인 알림
          document.board_form.subject.focus();  // 제목 입력 필드로 포커스 이동
          return;
      }
      if (!document.board_form.content.value)
      {
          alert("내용을 입력하세요!");  // 내용 입력 확인 알림   
          document.board_form.content.focus();  // 내용 입력 필드로 포커스 이동
          return;
      }
      document.board_form.submit();  // 유효성 검사 통과 시 폼 제출
   }
</script>
</head>
<body> 
<header>
    <?php include "header.php";?>  <!-- 헤더 파일 포함 -->
</header>  
<section>
   	<div id="board_box">
	    <h3 id="board_title">
	    		게시판 > 글 쓰기
		</h3>
<?php
	$num  = $_GET["num"];  // GET 방식으로 전달된 글 번호(num) 가져오기
	$page = $_GET["page"];  // GET 방식으로 전달된 페이지 번호(page) 가져오기
	
	$con = mysqli_connect("localhost", "user1", "12345", "test");  // MySQL 데이터베이스 연결
	$sql = "select * from board where num=$num";  // 글 번호에 해당하는 게시글 조회 쿼리
	$result = mysqli_query($con, $sql);  // 쿼리 실행
	$row = mysqli_fetch_array($result);  // 결과에서 한 줄 가져오기
	$name       = $row["name"];  // 작성자 이름
	$subject    = $row["subject"];  // 제목
	$content    = $row["content"];  // 내용		
	$file_name  = $row["file_name"];  // 첨부 파일 이름
?>
	    <form  name="board_form" method="post" action="board_modify.php?num=<?=$num?>&page=<?=$page?>" enctype="multipart/form-data">
	    	 <ul id="board_form">
				<li>
					<span class="col1">이름 : </span>
					<span class="col2"><?=$name?></span>  <!-- 작성자 이름 출력 -->
				</li>		
	    		<li>
	    			<span class="col1">제목 : </span>
	    			<span class="col2"><input name="subject" type="text" value="<?=$subject?>"></span>  <!-- 기존 제목 표시 -->
	    		</li>	    	
	    		<li id="text_area">	
	    			<span class="col1">내용 : </span>
	    			<span class="col2">
	    				<textarea name="content"><?=$content?></textarea>  <!-- 기존 내용 표시 -->
	    			</span>
	    		</li>
	    		<li>
			        <span class="col1"> 첨부 파일 : </span>
			        <span class="col2"><?=$file_name?></span>  <!-- 기존 첨부 파일 이름 표시 -->
			    </li>
	    	    </ul>
	    	<ul class="buttons">
				<li><button type="button" onclick="check_input()">수정하기</button></li>  <!-- 입력 유효성 검사 함수 호출 -->
				<li><button type="button" onclick="location.href='board_list.php'">목록</button></li>  <!-- 목록으로 돌아가기 버튼 -->
			</ul>
	    </form>
	</div> <!-- board_box -->
</section> 
<footer>
    <?php include "footer.php";?>  <!-- 푸터 파일 포함 -->
</footer>
</body>
</html>
