<?php
// 1. 공통 인클루드 파일
include ("./head.php");

$host = 'localhost';
$user = 'root';
$dbname = 'hank_board';
$pw = 'threka4880';
$conn = mysqli_connect($host, $user,$pw, $dbname);


// 2. 게시판 코드 검사
$bc_code = $_POST['bc_code'];
if($bc_code){
    // 3. 게시판 코드가 있으면 게시판 설정 불러오기
    $b_config_sql = "select * from ".$_cfg['config_table']." where bc_code = '".$bc_code."'";
    $board_config = sql_fetch($b_config_sql);
}else{
    alert("게시판 코드가 없습니다.");
}

//transaction
// 4. 존재하는 게시판인지 확인
if(!$board_config[bc_idx]){
    alert("존재 하지 않는 게시판입니다.");
}


// 6. 넘어온 변수 검사
if(trim($_POST['b_title']) == ""){
    alert("글제목을 입력해 주세요.");
}

if(trim($_POST['b_contents']) == ""){
    alert("글내용을 입력해 주세요.");
}




//여기가 중요한 부분 인듯
// 8. 글저장
$sql = "insert into ".$_cfg['board_table']." set bc_code = '".$bc_code."', m_id = '".$_SESSION[user_id]."', m_name = '".addslashes(htmlspecialchars($_POST['m_name']))."', b_title = '".addslashes(htmlspecialchars($_POST['b_title']))."',b_contents = '".addslashes(htmlspecialchars($_POST['b_contents']))."' , b_regdate = now()";

mysqli_query($conn,$sql);



// 9. 저장된 글번호 찾기
$b_idx = mysqli_insert_id();




// 12. 글목록 페이지로 보내기
alert("글이 저장 되었습니다." , "./board_list.php?bc_code=$bc_code");


?>