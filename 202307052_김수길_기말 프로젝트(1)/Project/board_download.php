<?php
    $real_name = $_GET["real_name"];  // GET 방식으로 전달된 "real_name" 파라미터 값을 가져와 $real_name 변수에 저장한다. 이는 실제 파일 이름을 나타낸다.
    $file_name = $_GET["file_name"];  // GET 방식으로 전달된 "file_name" 파라미터 값을 가져와 $file_name 변수에 저장한다. 이는 다운로드될 파일 이름을 나타낸다.
    $file_type = $_GET["file_type"];  // GET 방식으로 전달된 "file_type" 파라미터 값을 가져와 $file_type 변수에 저장한다. 이는 파일의 MIME 타입을 나타낸다.
    $file_path = "./data/".$real_name;  // 다운로드할 파일의 경로를 지정한다.

    $ie = preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || 
        (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0') !== false && 
            strpos($_SERVER['HTTP_USER_AGENT'], 'rv:11.0') !== false);

    // 만약 클라이언트 브라우저가 IE인 경우 한글 파일명이 깨지는 현상을 방지하기 위해 한글 파일명을 변환한다.
    if ($ie) {
        $file_name = iconv('utf-8', 'euc-kr', $file_name);
    }

    // 지정된 파일 경로가 실제로 존재하는 경우
    if (file_exists($file_path)) { 
        $fp = fopen($file_path, "rb");  // 파일을 바이너리 읽기 모드로 열기
        Header("Content-type: application/x-msdownload");  // 다운로드할 파일의 MIME 타입을 설정한다.
        Header("Content-Length: " . filesize($file_path));  // 다운로드할 파일의 크기를 설정한다.
        Header("Content-Disposition: attachment; filename=" . $file_name);  // 다운로드할 파일의 이름을 설정하고 첨부한다.
        Header("Content-Transfer-Encoding: binary");  // 전송 인코딩을 이진(binary)으로 설정한다.
        Header("Content-Description: File Transfer");  // 파일 전송에 대한 설명을 추가한다.
        Header("Expires: 0");  // 캐시 제어를 위해 만료 시간을 0으로 설정한다.
    } 
    
    if (!fpassthru($fp))  // 파일을 클라이언트로 전송한다.
        fclose($fp);  // 파일 핸들을 닫는다.
?>
