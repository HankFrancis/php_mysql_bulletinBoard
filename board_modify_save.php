<?php
// 공통 인클루드 파일
include ("./head.php");

$host = 'localhost';
$user = 'root';
$dbname = 'hank_board';
$pw = 'threka4880';
$conn = mysqli_connect($host, $user,$pw, $dbname);


// 게시판 코드 검사
$bc_code = $_POST[bc_code];
if($bc_code){
    // 게시판 코드가 있으면 게시판 설정 불러오기
    $b_config_sql = "select * from ".$_cfg['config_table']." where bc_code = '".$bc_code."'";
    $board_config = sql_fetch($b_config_sql);
}else{
    alert("게시판 코드가 없습니다.");
}

// 존재하는 게시판인지 확인
if(!$board_config[bc_idx]){
    alert("존재 하지 않는 게시판입니다.");
}

//  게시판 권한 체크
if($_SESSION[user_level]){
    $u_level = $_SESSION[user_level];
}else{
    $u_level = 0;
}

//  글 데이터 불러오기
$b_idx = $_POST[b_idx];
$sql = "select * from ".$_cfg['board_table']." where bc_code = '".$bc_code."' and b_idx = '".$b_idx."'";
$data = sql_fetch($sql);

// 글이 없으면 메세지 출력후 되돌리기
if(!$data[b_idx]){
    alert("존재하지 않는 글입니다.");
}

// 본인의 글이 아니면 메세지 출력후 되돌리기
if($data[m_id] != $_SESSION[user_id] && $u_level != 9){
    alert("본인의 글이 아닙니다.");
}

//  넘어온 변수 검사
if(trim($_POST[b_title]) == ""){
    alert("글제목을 입력해 주세요.");
}

if(trim($_POST[b_contents]) == ""){
    alert("글내용을 입력해 주세요.");
}





// 글저장
$sql = "update ".$_cfg['board_table']." set b_title = '".addslashes(htmlspecialchars($_POST[b_title]))."', b_contents = '".addslashes(htmlspecialchars($_POST[b_contents]))."' where b_idx = '".$b_idx."'";

mysqli_query($conn,$sql);




//  글목록 페이지로 보내기
alert("글이 저장 되었습니다.", "./board_view.php?bc_code=".$bc_code."&b_idx=".$b_idx."&page=".$_POST[page]);
?>