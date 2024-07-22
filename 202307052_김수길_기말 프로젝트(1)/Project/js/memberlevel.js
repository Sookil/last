function checkLevel() {
    var musician = document.querySelector('input[name="musician"]:checked').value;
    if (musician === '예') {
        document.member_form.level.value = '2';
    } else {
        document.member_form.level.value = '0'; // 아니요를 선택한 경우 레벨 1로 설정
    }
}

