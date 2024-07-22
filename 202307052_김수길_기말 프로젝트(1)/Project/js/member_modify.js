   function check_input()
   {
      if (!document.member_form.pass.value)
      {
          alert("비밀번호를 입력하세요!");    
          document.member_form.pass.focus();
          return;
      }

      if (!document.member_form.pass_confirm.value)
      {
          alert("비밀번호확인을 입력하세요!");    
          document.member_form.pass_confirm.focus();
          return;
      }

      if (!document.member_form.name.value)
      {
          alert("이름을 입력하세요!");    
          document.member_form.name.focus();
          return;
      }

      if (document.member_form.pass.value != 
            document.member_form.pass_confirm.value)
      {
          alert("비밀번호가 일치하지 않습니다.\n다시 입력해 주세요!");
          document.member_form.pass.focus();
          document.member_form.pass.select();
          return;
      }

       if (!document.member_form.name.value) {
        alert("이름을 입력하세요!");    
        document.member_form.name.focus();
        return;
    }

    if (!document.member_form.age.value){
        alert("나이를 입력하세요!");
        document.member_form.age();
        return;
    }

    if (!document.member_form.phone.value){
        alert("전화번호를 입력하세요!");
        document.member_form.phone();
        return;
    }
    
    if (!document.member_form.address.value){
        alert("주소를 입력하세요!");
        document.member_form.address();
        return;
    }
    
    if (!document.member_form.gender.value){
        alert("성별을 클릭하세요!");
        document.member_form.gender();
        return;
    }
    
    // 체크박스 확인
    var hobbiess = document.getElementsByName("hobbies[]");
    var hobbyChecked = false;

    for (var i = 0; i < hobbiess.length; i++) {
        if (hobbiess[i].checked) {
            hobbyChecked = true;
            break; // 하나라도 체크된 것이 있으면 반복문 종료
        }
    }

    if (!hobbyChecked) {
        alert("하나 이상의 관심분야를 선택하세요!");
        return; // 입력값이 없으면 함수를 종료하고 폼을 제출하지 않음
    }
    
    if (!document.member_form.introduction.value){
        alert("가입인사/자기소개를 입력하세요!");
        document.member_form.introduction();
        return;
    }
    
    // 대표이미지를 선택했는지 확인
    var fileInput = document.member_form.upfile;
    if (!fileInput.value) {
        alert("대표이미지를 선택하세요!");
        fileInput.focus();
        return;
    }

    if (!document.member_form.musician.value){
        alert("뮤지션 여부를 클릭하세요!");
        document.member_form.musician();
        return;
    }
    
    // 모든 검증을 통과한 경우 폼 제출
    document.member_form.submit();
   }

   function reset_form()
   {
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

        // 뮤지션 여부 라디오 버튼 초기화
        var musicians = document.getElementsByName("musician");
        for (var i = 0; i < musicians.length; i++) {
            musicians[i].checked = false;
        }

        // 대표이미지 파일 입력 필드 초기화
        document.member_form.upfile.value = "";
        
        // 체크박스 초기화
        var checkboxes = document.getElementsByName("hobbies[]");
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });  
      document.member_form.id.focus();

      return;
  };