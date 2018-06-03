<?php
// 공통 인클루드 파일
include ("./head.php");

$host = 'localhost';
$user = 'root';
$dbname = 'hank_board';
$pw = 'threka4880';
$conn = mysqli_connect($host, $user,$pw, $dbname);

// 게시판 코드 검사
$bc_code = $_GET[bc_code];
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

// 게시판 권한 체크
if($_SESSION[user_level]){
    $u_level = $_SESSION[user_level];
}else{
    $u_level = 0;
}

// 글 데이터 불러오기
$b_idx = $_GET[b_idx];
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

// 유저 정보에서 게시글수 -1 줄여주기
/*
$sql = "update bd__member set m_post = m_post -1 where m_id = '".$data[m_id]."' ";
mysqli_query($conn,$sql);*/




mysqli_autocommit($conn,FALSE);
try{


// 댓글 삭제하기
$sql = "select * from ".$_cfg['board_table']." where bc_code = '".$bc_code."' and b_idx = '".$data[b_idx]."' ";
$result = mysqli_query($conn,$sql);


while($data = mysqli_fetch_array($result)){

    // 삭제
    $comment_delete = "delete from ".$_cfg['comment_table']." where b_idx = '".$data[b_idx]."'";
    sql_query($comment_delete);
}


$sql = "select * from ".$_cfg['board_table']." where bc_code = '".$bc_code."' and b_idx = '".$b_idx."'";
$data = sql_fetch($sql);



// 7. 글 삭제하기
$sql_delete = "delete from ".$_cfg['board_table']." where bc_code = '".$bc_code."' and b_idx = '".$data[b_idx]."' ";
mysqli_query($conn,$sql_delete);

mysqli_commit($conn);
// 8. 글목록 페이지로 보내기
alert("글이 삭제 되었습니다.", "./board_list.php?bc_code=".$bc_code."&page=".$_GET[page]);



}
catch(Exception $e){
    mysqli_rollback($conn);
    alert("RollBack", "./board_list.php?bc_code=".$bc_code."&page=".$_GET[page]);
}

?>