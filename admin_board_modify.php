<?php
// 1. 공통 인클루드 파일
include "./admin_head.php";


$host = 'localhost';
$user = 'root';
$dbname = 'hank_board';
$pw = 'threka4880';
$conn = mysqli_connect($host, $user, $pw, $dbname);


$bc_idx = $_GET['bc_idx'];

echo "$bc_idx";

// 2. 게시판 설정 데이터 불러오기
$sql = "select * from bd__board_config where bc_idx = $bc_idx ";


$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$data = $row;


if(!$data[bc_idx]){
    alert("없는 게시판입니다.");
}

echo "testing";

echo "testing2";
// 3. 입력 HTML 출력
?>

<br/>
<table style="width:1000px;height:30px;border:5px #CCCCCC solid;">
    <tr>
        <td align="center" valign="middle" style="font-zise:15px;font-weight:bold;">게시판 생성</td>
    </tr>
</table>
<br/>
<form name="bWriteForm" method="post" enctype="multipart/form-data" action="./admin_board_modify_save.php" style="margin:0px;">
<input type="hidden" name="bc_idx" value="<?=$data[bc_idx]?>">
<table style="width:1000px;height:30px;border:0px;">
    <tr>
        <td align="center" valign="middle" style="width:200px;height:30px;background-color:#CCCCCC;">게시판코드</td>
        <td align="left" valign="middle" style="width:800px;height:30px;"><input type="text" name="bc_code" style="width:780px;" value="<?=$data[bc_code]?>"></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="width:200px;height:30px;background-color:#CCCCCC;">게시판이름</td>
        <td align="left" valign="middle" style="width:800px;height:30px;"><input type="text" name="bc_name" style="width:780px;" value="<?=$data[bc_name]?>"></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="width:200px;height:30px;background-color:#CCCCCC;">게시판 관리자ID</td>
        <td align="left" valign="middle" style="width:800px;height:30px;"><input type="text" name="bc_admin" style="width:780px;" value="<?=$data[bc_admin]?>"></td>
    </tr>
    <!-- 4. 수정 버튼 클릭시 입력필드 검사 함수 write_save 실행 -->
    <tr>
        <td align="center" valign="middle" colspan="2"><input type="button" value=" 게시판수정 " onClick="write_save();">&nbsp;&nbsp;&nbsp;<input type="button" value=" 삭제 " onClick="location.replace('./admin_board_delete.php?bc_idx=<?=$data[bc_idx]?>')">&nbsp;&nbsp;&nbsp;<input type="button" value=" 뒤로가기 " onClick="history.back();"></td>
    </tr>
</table>
</form>
<script>
// 5.입력필드 검사함수
function write_save()
{
    // 6.form 을 f 에 지정
    var f = document.bWriteForm;

    // 7.입력폼 검사

    if(f.bc_code.value == ""){
        alert("게시판코드를 입력해 주세요.");
        return false;
    }

    if(f.bc_name.value == ""){
        alert("게시판이름을 입력해 주세요.");
        return false;
    }

    // 8.검사가 성공이면 form 을 submit 한다
    f.submit();

}
</script>