<!DOCTYPE html>
<head>
<meta charset="utf-8">
<style>
h3 {
   padding-left: 5px;
   border-left: solid 5px #edbf07;
}
#close {
   margin:20px 0 0 80px;
   cursor:pointer;
}
</style>
</head>
<body>
<h3>아이디 중복체크</h3>
<p>
<?php
   $id = $_GET["id"];

   // 아이디 입력 여부 확인
   if(!$id) 
   {
      echo("<li>아이디를 입력해 주세요!</li>");
   }
   else
   {
      // 데이터베이스 연결
      $con = mysqli_connect("localhost", "user1", "12345", "test");

      // 입력된 아이디로 데이터베이스 조회
      $sql = "select * from members where id='$id'";
      $result = mysqli_query($con, $sql);

      // 조회된 레코드 개수 확인
      $num_record = mysqli_num_rows($result);

      // 아이디 중복 여부에 따른 메시지 출력
      if ($num_record)
      {
         echo "<li>".$id." 아이디는 중복됩니다.</li>";
         echo "<li>다른 아이디를 사용해 주세요!</li>";
      }
      else
      {
         echo "<li>".$id." 아이디는 사용 가능합니다.</li>";
      }
    
      // 데이터베이스 연결 종료
      mysqli_close($con);
   }
?>
</p>
<div id="close">
   <img src="./img/close.png" onclick="javascript:self.close()">
</div>
</body>
</html>
