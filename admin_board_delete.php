<?php
// 공통 인클루드 파일
include "./admin_head.php";



$host = 'localhost';
$user = 'root';
$dbname = 'hank_board';
$pw = 'threka4880';
$conn = mysqli_connect($host, $user,$pw, $dbname);

$bc_idx = $_GET['bc_idx'];

// 게시판 존재여부 검사
$sql = "select * from bd__board_config where bc_idx = '".$_GET[bc_idx]."'";
$data = sql_fetch($sql);


if(!$data[bc_idx]){
    alert("없는 게시판입니다.");
}



mysqli_autocommit($conn,FALSE);


try{

// 게시판 삭제
$sql = "delete from bd__board_config where bc_idx = $bc_idx";
mysqli_query($conn,$sql);



//댓글 삭제 위한 게시글 목록 구하기 
$sql = "select * from ".$_cfg['board_table']." where bc_code = '".$data[bc_code]."' ";
$result = mysqli_query($conn,$sql);

// 게시글 삭제
$sql = "delete from bd__board where bc_code = '".$data[bc_code]."'";
mysqli_query($conn,$sql);



while($data = mysqli_fetch_array($result)){

    // 삭제
    $comment_delete = "delete from ".$_cfg['comment_table']." where b_idx = '".$data[b_idx]."'";
    mysqli_query($conn,$comment_delete);
}





mysqli_commit($conn);

// 게시판목록 페이지로 보내기
alert("게시판이 삭제 되었습니다.", "./admin_board_list.php");


}

catch(Exception $e){
	mysqli_rollback($conn);
	alert("RollBack", "./admin_board_list.php");
}


?>


