<?php
// 공통 인클루드 파일
include ("./head.php");

$host = 'localhost';
$user = 'root';
$dbname = 'hank_board';
$pw = 'threka4880';
$conn = mysqli_connect($host, $user,$pw, $dbname);



$point = $_POST[point];
$get_user_id = $_POST[get_user];
$send_user_id = $_POST[send_user];

echo $point;
echo $get_user_id;
echo $send_user_id;
echo "testing";


$send_user_check = "select * from bd__member where m_id = '".$send_user_id."' ";
$send_user_result = mysqli_query($conn,$send_user_check);
$send_user_data = sql_fetch($send_user_check);


$get_user_check = "select * from bd__member where m_id = '".$get_user_id."' ";
$get_user_result = mysqli_query($conn,$get_user_check);
$get_user_data = sql_fetch($get_user_check);

echo "point";
echo $send_user_data[m_point];


if($send_user_data[m_point] - $point <0 )
{

    alert("포인트가 충분하지 않습니다");
}


if(!$get_user_result){
    alert("존재 하지 않는 유저입니다.");
}


$send_sql = "update bd__member set m_point = m_point - '".$point."' where m_id = '".$send_user_id."' ";
$get_sql = "update bd__member set m_point = m_point + '".$point."' where m_id = '".$get_user_id."' ";

//TRANSACTION PART

mysqli_query("START TRANSACTION");


$send_query = mysqli_query($conn,$send_sql);
$get_query = mysqli_query($conn,$get_sql);



if ($send_query and $get_query) {
    mysqli_query("COMMIT");
} else {        
    mysqli_query("ROLLBACK");
}






alert("포인트가 보내졌습니다 ", "./index.php");

?>