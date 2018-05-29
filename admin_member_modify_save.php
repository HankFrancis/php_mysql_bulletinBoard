<?php
// 1. 공통 인클루드 파일
include "./admin_head.php";

$host = 'localhost';
$user = 'root';
$dbname = 'hank_board';
$pw = 'threka4880';
$conn = mysqli_connect($host, $user,$pw, $dbname);


$m_idx = $_POST['m_idx'];
$m_name = $_POST['m_name'];
$m_level = $_POST['m_level'];
$m_point = $_POST['m_point'];

// 2. 회원 존재여부 검사
$sql = "select * from bd__member where m_idx = $m_idx";
$data = sql_fetch($sql);
if(!$data[m_idx]){
    alert("없는 회원입니다.");
}

// 3. 넘어온 변수 검사
if(trim($m_name) == ""){
    alert("회원이름을 입력해 주세요.");
}

// 4. 회원 저장
$sql = "update bd__member set
        m_name = '".trim($m_name)."', 
        m_level = $m_level,
        m_point = $m_point

        where m_idx = $m_idx
        ";

mysqli_query($conn,$sql);
//sql_query($sql);

/*// 데이터 무결성
if($data[m_name] != trim($m_name)){
    $sql = "update bd__board set m_name ='".trim($m_name)."' where m_id = '".$data[m_id]."'";
    sql_query($sql);

    $sql = "update bd__comment set m_name ='".trim($m_name)."' where m_id = '".$data[m_id]."'";
    sql_query($sql);
}*/


// 6. 회원목록 페이지로 보내기
alert("회원이 수정 되었습니다.", "./admin_member_list.php");
?>