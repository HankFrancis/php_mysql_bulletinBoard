<?php
// 공통 인클루드 파일
include "./admin_head.php";

// 게시판 존재여부 검사
$sql = "select * from bd__board_config where bc_idx = '".$_POST[bc_idx]."'";


$host = 'localhost';
$user = 'root';
$dbname = 'hank_board';
$pw = 'threka4880';
$conn = mysqli_connect($host, $user,$pw, $dbname);


$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$data = $row;

if(!$data[bc_idx]){
    alert("없는 게시판입니다.");
}

// 넘어온 변수 검사
if(trim($_POST[bc_code]) == ""){
    alert("게시판코드를 입력해 주세요.");
}

$sql = "select * from bd__board_config where bc_code = '".trim($_POST[bc_code])."' and bc_idx != '".$_POST[bc_idx]."'";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$data1 = $row;

if($data1[bc_idx]){
    alert("이미 존재하는 게시판입니다.");
}

if(trim($_POST[bc_name]) == ""){
    alert("게시판이름을 입력해 주세요.");
}

$bc_idx = $_POST[bc_idx];

$dir = "./data/board_config";


// 게시판 저장
$sql = "update bd__board_config set
        bc_code = '".trim($_POST[bc_code])."', 
        bc_name = '".trim($_POST[bc_name])."', 
        bc_admin = '".$_POST[bc_admin]."'
        where bc_idx = '".$bc_idx."'
        ";


mysqli_query($conn,$sql);


// 데이터 무결성
if($data[bc_code] != trim($_POST[bc_code])){
    $sql = "update bd__board set bc_code ='".trim($_POST[bc_code])."' where bc_code = '".$data[bc_code]."'";
    mysqli_query($conn,$sql);
}

// 게시판목록 페이지로 보내기
alert("게시판이 수정 되었습니다.", "./admin_board_list.php");
?>