<?php
    // GET 방식으로 전달된 실제 파일명, 원본 파일명, 파일 타입을 변수에 저장합니다.
    $real_name = $_GET["real_name"];
    $file_name = $_GET["file_name"];
    $file_type = $_GET["file_type"];

    // 파일이 저장된 경로를 설정합니다.
    $file_path = "./data/".$real_name;

    // 사용자의 브라우저가 IE인지 체크하는 조건을 설정합니다.
    $ie = preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || 
        (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0') !== false && 
            strpos($_SERVER['HTTP_USER_AGENT'], 'rv:11.0') !== false);

    // 만약 브라우저가 IE라면 한글 파일명이 깨지는 문제를 해결하기 위해 파일명을 변환합니다.
    if ($ie) {
        $file_name = iconv('utf-8', 'euc-kr', $file_name);
    }

    // 파일이 존재하는지 확인합니다.
    if (file_exists($file_path)) {
        // 파일을 읽기 모드로 열고, 다운로드할 수 있도록 HTTP 헤더를 설정합니다.
        $fp = fopen($file_path, "rb"); 
        Header("Content-type: application/x-msdownload"); 
        Header("Content-Length: ".filesize($file_path));     
        Header("Content-Disposition: attachment; filename=".$file_name);   
        Header("Content-Transfer-Encoding: binary"); 
        Header("Content-Description: File Transfer"); 
        Header("Expires: 0");       
    } 
	
    // 파일을 클라이언트로 전송합니다.
    if (!fpassthru($fp)) {
        fclose($fp); // 파일을 닫습니다.
    }
?>
