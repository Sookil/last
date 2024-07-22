<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>PHP 프로그래밍 입문</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/board.css">
<script>
  // 입력 유효성 검사 함수
  function check_input() {
      if (!document.board_form.subject.value)
      {
          alert("제목을 입력하세요!");
          document.board_form.subject.focus();
          return;
      }
      if (!document.board_form.content.value)
      {
          alert("내용을 입력하세요!");    
          document.board_form.content.focus();
          return;
      }
      document.board_form.submit();
   }
</script>
</head>
<body> 
<header>
    <?php include "header.php";?>
</header>  
<section>
    <div id="board_box">
        <h3 id="board_title">
            뮤지션 게시판 > 글 수정
        </h3>
<?php
    // GET 파라미터에서 글 번호와 페이지 번호 가져오기
    $num  = $_GET["num"];
    $page = $_GET["page"];
    
    // 데이터베이스에서 해당 글 정보 가져오기
    $con = mysqli_connect("localhost", "user1", "12345", "test");
    $sql = "SELECT * FROM m_board WHERE num=$num";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $name       = $row["name"];       // 글쓴이 이름
    $subject    = $row["subject"];    // 글 제목
    $content    = $row["content"];    // 글 내용
    $file_name  = $row["file_name"];  // 첨부 파일명
?>
        <!-- 글 수정 폼 -->
        <form  name="board_form" method="post" action="m_board_modify.php?num=<?=$num?>&page=<?=$page?>" enctype="multipart/form-data">
             <ul id="board_form">
                <li>
                    <span class="col1">이름 : </span>
                    <span class="col2"><?=$name?></span> <!-- 글쓴이 이름 표시 -->
                </li>       
                <li>
                    <span class="col1">제목 : </span>
                    <span class="col2"><input name="subject" type="text" value="<?=$subject?>"></span> <!-- 글 제목 입력 필드 -->
                </li>            
                <li id="text_area">   
                    <span class="col1">내용 : </span>
                    <span class="col2">
                        <textarea name="content"><?=$content?></textarea> <!-- 글 내용 입력 필드 -->
                    </span>
                </li>
                <li>
                    <span class="col1"> 첨부 파일 : </span>
                    <span class="col2"><?=$file_name?></span> <!-- 첨부 파일명 표시 -->
                </li>
                </ul>
            <!-- 버튼 그룹 -->
            <ul class="buttons">
                <li><button type="button" onclick="check_input()">수정하기</button></li> <!-- 입력 유효성 검사 후 수정하기 버튼 -->
                <li><button type="button" onclick="location.href='m_board_list.php'">목록</button></li> <!-- 목록으로 돌아가기 버튼 -->
            </ul>
        </form>
    </div> <!-- board_box -->
</section> 
<footer>
    <?php include "footer.php";?> <!-- footer.php 파일 포함 -->
</footer>
</body>
</html>
