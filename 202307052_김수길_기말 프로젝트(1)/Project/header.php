<?php
session_start(); // 세션을 시작합니다.

// 세션 변수에서 사용자 아이디를 가져오거나, 없으면 빈 문자열로 초기화합니다.
if (isset($_SESSION["userid"])) {
    $userid = $_SESSION["userid"];
} else {
    $userid = "";
}

// 세션 변수에서 사용자 이름을 가져오거나, 없으면 빈 문자열로 초기화합니다.
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
} else {
    $username = "";
}

// 세션 변수에서 사용자 레벨을 가져오거나, 없으면 빈 문자열로 초기화합니다.
if (isset($_SESSION["userlevel"])) {
    $userlevel = $_SESSION["userlevel"];
} else {
    $userlevel = "";
}
?>		

<div id="top">
    <h3>
        <a class="a0" href="index.php">Square</a> <!-- Square 링크를 포함한 제목 헤딩 -->
    </h3>
    <ul id="top_menu">  
        <?php
        if (!$userid) { // 사용자가 로그인하지 않은 경우
        ?>                
            <li><a href="member_form.php">회원 가입</a> </li> <!-- 회원 가입 링크 -->
            <li> | </li> <!-- 구분 선 -->
            <li><a href="login_form.php">로그인</a></li> <!-- 로그인 링크 -->
        <?php
        } else { // 사용자가 로그인한 경우
            $logged = $username . "(" . $userid . ")님[등급:" . $userlevel . "]"; // 로그인한 사용자 정보 표시 문자열 생성
        ?>
            <li><?=$logged?> </li> <!-- 사용자 정보 표시 -->
            <li> | </li> <!-- 구분 선 -->
            <li><a class="a1" href="logout.php">로그아웃</a> </li> <!-- 로그아웃 링크 -->
            <li> | </li> <!-- 구분 선 -->
            <li><a class="a1" href="member_modify_form.php">정보 수정</a></li> <!-- 정보 수정 링크 -->
        <?php
        }
        ?>
        <?php
        if ($userlevel == 1) { // 사용자 레벨이 1인 경우 (관리자인 경우)
        ?>
            <li> | </li> <!-- 구분 선 -->
            <li><a href="admin.php">관리자 모드</a></li> <!-- 관리자 모드 링크 -->
        <?php
        }
        ?>
    </ul>
</div>

<div id="menu_bar">
    <ul>  
        <li><a href="index.php">홈</a></li> <!-- 홈 링크 -->
        <li><a href="message_form.php">쪽지 게시판</a></li> <!-- 쪽지 게시판 링크 -->
        <li><a href="board_list.php">공연 공지 게시판</a></li> <!-- 공연 공지 게시판 링크 -->
        <li><a href="m_board_list.php">뮤지션 게시판</a></li> <!-- 뮤지션 게시판 링크 -->
        <li><a href="f_board_list.php">자유 게시판</a></li> <!-- 자유 게시판 링크 -->
    </ul>
</div>
