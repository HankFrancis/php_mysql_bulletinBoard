<?php
// 공통 인클루드 파일
include "./admin_head.php";

// 넘어온 변수 검사
if(trim($_POST[bc_code]) == ""){
    alert("게시판코드를 입력해 주세요.");
}


$host = 'localhost';
$user = 'root';
$dbname = 'hank_board';
$pw = 'threka4880';
$conn = mysqli_connect($host, $user,$pw, $dbname);



$sql = "select * from bd__board_config where bc_code = '".trim($_POST[bc_code])."'";



$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$data = $row;


if($data[bc_idx]){
    alert("이미 존재하는 게시판입니다.");
}

if(trim($_POST[bc_name]) == ""){
    alert("게시판이름을 입력해 주세요.");
}



// 파일 저장 디렉토리 검사 후 없으면 생성
$dir = "./data/board_config";
if(!is_dir($dir)){
    @mkdir($dir, 0707);
    @chmod($dir, 0707);
}


// 게시판 저장
$sql = "insert into bd__board_config set
        bc_code = '".trim($_POST[bc_code])."', 
        bc_name = '".trim($_POST[bc_name])."', 
        bc_admin = '".$_POST[bc_admin]."'     
        ";
mysqli_query($conn,$sql);


// 저장된 게시판번호 찾기
$bc_idx = mysqli_insert_id();



// 게시판목록 페이지로 보내기
alert("게시판이 생성 되었습니다.", "./admin_board_list.php");
?>