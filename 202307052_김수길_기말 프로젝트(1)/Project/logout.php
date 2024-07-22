<?php
  // 세션을 시작합니다.
  session_start();

  // 세션 변수를 unset 함수를 이용해 모두 제거합니다.
  unset($_SESSION["userid"]);
  unset($_SESSION["username"]);
  unset($_SESSION["userlevel"]);
  unset($_SESSION["userpoint"]);
  
  // 로그아웃 후 index.php 페이지로 이동하는 JavaScript 코드를 출력합니다.
  echo("
       <script>
          location.href = 'index.php'; // index.php 페이지로 이동합니다.
       </script>
       ");
?>
