<?php
// 공통 인클루드 파일
include "./admin_head.php";

// 입력 HTML 출력
?>
<br/>
<table style="width:1000px;height:30px;border:5px #CCCCCC solid;">
    <tr>
        <td align="center" valign="middle" style="font-zise:15px;font-weight:bold;">게시판 생성</td>
    </tr>
</table>
<br/>
<form name="bWriteForm" method="post" enctype="multipart/form-data" action="./admin_board_insert_save.php" style="margin:0px;">
<table style="width:1000px;height:30px;border:0px;">
    <tr>
        <td align="center" valign="middle" style="width:200px;height:30px;background-color:#CCCCCC;">게시판코드</td>
        <td align="left" valign="middle" style="width:800px;height:30px;"><input type="text" name="bc_code" style="width:780px;"></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="width:200px;height:30px;background-color:#CCCCCC;">게시판이름</td>
        <td align="left" valign="middle" style="width:800px;height:30px;"><input type="text" name="bc_name" style="width:780px;"></td>
    </tr>
    
    <tr>
        <td align="center" valign="middle" style="width:200px;height:30px;background-color:#CCCCCC;">게시판 관리자ID</td>
        <td align="left" valign="middle" style="width:800px;height:30px;"><input type="text" name="bc_admin" style="width:780px;"></td>
    </tr>
    <tr>
        <td align="center" valign="middle" colspan="2"><input type="button" value=" 게시판생성 " onClick="write_save();">&nbsp;&nbsp;&nbsp;<input type="button" value=" 뒤로가기 " onClick="history.back();"></td>
    </tr>
</table>
</form>
<script>
// 입력필드 검사함수
function write_save()
{
    // form 을 f 에 지정
    var f = document.bWriteForm;

    // 입력폼 검사

    if(f.bc_code.value == ""){
        alert("게시판코드를 입력해 주세요.");
        return false;
    }

    if(f.bc_name.value == ""){
        alert("게시판이름을 입력해 주세요.");
        return false;
    }

    // 검사가 성공이면 form 을 submit 한다
    f.submit();

}
</script>