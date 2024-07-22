<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>회원가입</title>
<link rel="stylesheet" type="text/css" href="./css/common.css?after">
<link rel="stylesheet" type="text/css" href="./css/member.css??after">
<link rel="stylesheet" type="text/css" href="./css/custom.css?after">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<header><?php include "header.php";?> <!-- 헤더 부분 포함(가져오기) -->
</header>
<script>
   function check_input() {
      if (!document.member_form.id.value) {
          alert("아이디를 입력하세요!");    
          document.member_form.id.focus();
          return;
      }

      if (!document.member_form.pass.value) {
          alert("비밀번호를 입력하세요!");    
          document.member_form.pass.focus();
          return;
      }

      if (!document.member_form.pass_confirm.value) {
          alert("비밀번호확인을 입력하세요!");    
          document.member_form.pass_confirm.focus();
          return;
      }

      if (!document.member_form.name.value) {
          alert("이름을 입력하세요!");    
          document.member_form.name.focus();
          return;
      }

      if (!document.member_form.age.value) {
          alert("나이를 입력하세요!");    
          document.member_form.age.focus();
          return;
      }

      if (!document.member_form.phone.value) {
          alert("전화번호를 입력하세요!");    
          document.member_form.phone.focus();
          return;
      }

      // 성별 선택 여부 확인
      var genders = document.getElementsByName("gender");
      var genderChecked = false;
      for (var i = 0; i < genders.length; i++) {
         if (genders[i].checked) {
            genderChecked = true;
            break;
         }
      }
      if (!genderChecked) {
         alert("성별을 선택하세요!");
         return;
      }

      // 취미 선택 여부 확인
      var hobbies = document.getElementsByName("hobbies[]");
      var hobbyChecked = false;
      for (var i = 0; i < hobbies.length; i++) {
         if (hobbies[i].checked) {
            hobbyChecked = true;
            break;
         }
      }
      if (!hobbyChecked) {
         alert("하나 이상의 관심분야를 선택하세요!");
         return;
      }

      if (!document.member_form.introduction.value) {
          alert("자기소개를 입력하세요!");    
          document.member_form.introduction.focus();
          return;
      }
      
      if (!document.member_form.upfile.value) {
          alert("프로필 이미지를 올려주세요!");    
          document.member_form.upfile.focus();
          return;
      }

      if (document.member_form.pass.value != document.member_form.pass_confirm.value) {
          alert("비밀번호가 일치하지 않습니다.\n다시 입력해 주세요!");
          document.member_form.pass.focus();
          document.member_form.pass.select();
          return;
      }

      // 뮤지션 여부 선택 여부 확인
      var musicianChecked = false;
      var musicianOptions = document.getElementsByName("musician");
      for (var i = 0; i < musicianOptions.length; i++) {
         if (musicianOptions[i].checked) {
            musicianChecked = true;
            break;
         }
      }
      if (!musicianChecked) {
         alert("뮤지션 여부를 선택하세요!");
         return;
      }
      
      document.member_form.submit();
   }

   function reset_form() {
      document.member_form.id.value = "";
      document.member_form.pass.value = "";
      document.member_form.pass_confirm.value = "";
      document.member_form.name.value = "";
      document.member_form.age.value = "";
      document.member_form.phone.value = "";
      document.member_form.address.value = "";
      document.member_form.introduction.value = "";
      
      // 성별 라디오 버튼 초기화
      var genders = document.getElementsByName("gender");
      for (var i = 0; i < genders.length; i++) {
         genders[i].checked = false;
      }

      // 취미 체크박스 초기화
      var hobbies = document.getElementsByName("hobbies[]");
      for (var i = 0; i < hobbies.length; i++) {
         hobbies[i].checked = false;
      }

      // 뮤지션 여부 라디오 버튼 초기화
      var musicianOptions = document.getElementsByName("musician");
      for (var i = 0; i < musicianOptions.length; i++) {
         musicianOptions[i].checked = false;
      }

      // 프로필 이미지 파일 초기화
      document.member_form.upfile.value = "";

      document.member_form.id.focus();
   }

   function check_id() {
      window.open("member_check_id.php?id=" + document.member_form.id.value,
         "IDcheck",
         "left=700,top=300,width=350,height=200,scrollbars=no,resizable=yes");
   }
</script>
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
</head>
<body> 
    <section>
        <div id="main_content">
            <div id="join_box">
                <form  name="member_form" method="post" action="member_insert.php" enctype="multipart/form-data">
                    <h2>회원 가입</h2>
                    <div class="form id">
                        <div class="col1">아이디</div>
                        <div class="col2">
                            <input type="text" name="id">
                        </div>  
                        <div class="col3">
                            <a href="#"><img src="./img/check_id.gif" onclick="check_id()"></a>
                        </div>                 
                    </div>
                    <div class="clear"></div>

                    <div class="form">
                        <div class="col1">비밀번호</div>
                        <div class="col2">
                            <input type="password" name="pass">
                        </div>                 
                    </div>
                    <div class="clear"></div>
                    <div class="form">
                        <div class="col1">비밀번호 확인</div>
                        <div class="col2">
                            <input type="password" name="pass_confirm">
                        </div>                 
                    </div>
                    <div class="clear"></div>
                    <div class="form">
                        <div class="col1">이름</div>
                        <div class="col2">
                            <input type="text" name="name">
                        </div>                 
                    </div>
                    <div class="clear"></div>
                    <div class="form">
                        <div class="col1">나이</div>
                        <div class="col2">
                            <input type="text" name="age">
                        </div>                 
                    </div>
                    <div class="clear"></div>
                    <div class="form">
                        <div class="col1">전화번호</div>
                        <div class="col2">
                            <input type="text" name="phone">
                        </div>                 
                    </div>
                    <div class="clear"></div> 
                    <div class="form">
                        <div class="col1">성별</div>
                        <div class="col4">
                            <label><input type="radio" name="gender" value="여">남</label>
                            <label><input type="radio" name="gender" value="남">여</label>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="form">
                        <div class="col1">주소</div>
                        <div class="col2">
                            <input type="text" name="address">
                        </div>                 
                    </div>
                    <div class="clear"></div>
                    <div class="form">
                        <div class="col1">취미</div>
                        <div class="col2">
                            <input type="checkbox" name="hobbies[]" value="재즈"> 재즈
                            <input type="checkbox" name="hobbies[]" value="클래식"> 클래식
                            <input type="checkbox" name="hobbies[]" value="POP"> POP
                            <input type="checkbox" name="hobbies[]" value="EDM"> EDM
                            <input type="checkbox" name="hobbies[]" value="아이돌"> 아이돌
                            <input type="checkbox" name="hobbies[]" value="발라드"> 발라드
                            <input type="checkbox" name="hobbies[]" value="락"> 락
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="form">
                        <div class="col1">자기소개</div>
                        <div class="col2">
                            <textarea name="introduction"></textarea>
                        </div>                 
                    </div>
                    <input type="hidden" name="musician" id="musician" value="">
                    <input type="hidden" name="level" value="0">
                    <div class="clear"></div>
                     <div class="form">
                        <div class="col1">뮤지션 여부</div>
                        <div class="col4">
                            <label><input type="radio" name="musician" value="예">예</label>
                            <label><input type="radio" name="musician" value="아니요">아니요</label>
                        </div>
                    </div>

                    
                
                    <div class="clear"></div>
                    <div class="form">
                        <div class="col1">프로필 이미지</div>
                        <div class="col2">
                            <input type="file" name="upfile">
                        </div>                 
                    </div>
                    <div class="clear"></div>
                    <div class="bottom_line"> </div>
                    <div class="buttons">
                        <img style="cursor:pointer" src="./img/button_save.gif" onclick="check_input()">&nbsp;
                        <img id="reset_button" style="cursor:pointer" src="./img/button_reset.gif" onclick="reset_form()">
                       
                    </div>
                </form>
            </div> <!-- join_box -->
        </div> <!-- main_content -->
    </section> 
    <footer>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="./js/scripts.js"></script>   
    </footer>
</body>
</html>
