<?php
// 1. 공통 인클루드 파일
include ("./head.php");

$host = 'localhost';
$user = 'root';
$dbname = 'hank_board';
$pw = 'threka4880';
$conn = mysqli_connect($host, $user,$pw, $dbname);

$co_idx = $_GET[co_idx];
$m_name = $_GET[m_name];

$bc_code = $_GET[bc_code];
$b_idx = $_GET[b_idx];
$page = $_GET[page];

$sql = "select * from ".$_cfg['board_table']." where bc_code = '".$bc_code."' and b_idx = '".$data[b_idx]."' ";
$result = mysqli_query($conn,$sql);


$comment_delete = "delete from ".$_cfg['comment_table']." where b_idx = '".$b_idx."' and co_idx = '".$co_idx."' and m_name = '".$m_name."'";
mysqli_query($conn, $comment_delete);


alert("댓글 삭제 요청이 완료되었습니다. ", "./board_view.php?bc_code=".$bc_code."&b_idx=".$b_idx."&page=".$page);
?>
