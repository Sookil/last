<?php
    // GET 방식으로 전달된 실제 파일명(real_name), 원본 파일명(file_name), 파일 타입(file_type)을 변수에 저장합니다.
    $real_name = $_GET["real_name"];
    $file_name = $_GET["file_name"];
    $file_type = $_GET["file_type"];

    // 파일이 저장된 경로를 설정합니다.
    $file_path = "./data/" . $real_name;

    // 사용자의 브라우저가 IE인지 확인하는 코드를 작성합니다.
    $ie = preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || 
          (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0') !== false && 
           strpos($_SERVER['HTTP_USER_AGENT'], 'rv:11.0') !== false);

    // 만약 브라우저가 IE인 경우, 한글 파일명이 깨지는 문제를 해결하기 위해 파일명을 UTF-8에서 EUC-KR로 변환합니다.
    if ($ie) {
        $file_name = iconv('utf-8', 'euc-kr', $file_name);
    }

    // 파일이 실제로 존재하는지 확인합니다.
    if (file_exists($file_path)) {
        // 파일을 읽기 모드로 열고 파일 관련 헤더를 설정하여 다운로드합니다.
        $fp = fopen($file_path, "rb");
        if ($fp) {
            Header("Content-type: application/x-msdownload");
            Header("Content-Length: " . filesize($file_path));
            Header("Content-Disposition: attachment; filename=" . $file_name);
            Header("Content-Transfer-Encoding: binary");
            Header("Content-Description: File Transfer");
            Header("Expires: 0");

            // 파일을 출력합니다.
            if (!fpassthru($fp)) {
                fclose($fp);
            }
        }
    }
?>
