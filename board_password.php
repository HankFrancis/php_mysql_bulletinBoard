<?php
//  공통 인클루드 파일
include ("./head.php");

// 게시판 코드 검사
$bc_code = $_GET[bc_code];
if($bc_code){
    // 게시판 코드가 있으면 게시판 설정 불러오기
    $b_config_sql = "select * from ".$_cfg['config_table']." where bc_code = '".$bc_code."'";
    $board_config = sql_fetch($b_config_sql);
}else{
    alert("게시판 코드가 없습니다.");
}

//  존재하는 게시판인지 확인
if(!$board_config[bc_idx]){
    alert("존재 하지 않는 게시판입니다.");
}

//  게시판 권한 체크
if($_SESSION[user_level]){
    $u_level = $_SESSION[user_level];
}else{
    $u_level = 0;
}



//  페이징 변수 설정
if($_GET[page] && $_GET[page] > 0){
    // 현재 페이지 값이 존재하고 0 보다 크면 그대로 사용
    $page = $_GET[page];
}else{
    // 그 외의 경우는 현재 페이지를 1로 설정
    $page = 1;
}

//  글정보 가져오기
$b_idx = $_GET[b_idx];
$sql = "select * from ".$_cfg['board_table']." where bc_code = '".$bc_code."' and b_idx = '".$b_idx."'";
$data = sql_fetch($sql);

//  해당 글이 있는지체크
if(!$data[b_idx]){
    alert("존재 하지 않는 글입니다.");
}

// 비밀번호 입력 출력
?>
<br/>
<table style="width:1000px;height:50px;border:5px #CCCCCC solid;">
    <tr>
        <td align="center" valign="middle" style="font-zise:15px;font-weight:bold;">글보기 비밀번호 확인</td>
    </tr>
</table>
<br/>
<form name="passForm" method="post" action="./board_password_chk.php" style="margin:0px;">
<input type="hidden" name="bc_code" value="<?=$bc_code?>">
<input type="hidden" name="b_idx" value="<?=$b_idx?>">
<input type="hidden" name="page" value="<?=$_GET[page]?>">
<table style="width:1000px;height:50px;border:0px;">
    <tr>
        <td align="center" valign="middle" style="width:200px;height:50px;background-color:#CCCCCC;">비밀번호</td>
        <td align="left" valign="middle" style="width:800px;height:50px;"><input type="password" name="b_pass" style="width:380px;"></td>
    </tr>
   
    <tr>
        <td align="center" valign="middle" colspan="2"><input type="button" value=" 글보기 " onClick="pass_chk();">&nbsp;<input type="button" value=" 취소 " onClick="history.back();"></td>
    </tr>
</table>
</form>
<script>
// 입력필드 검사함수
function pass_chk()
{
    // form 을 f 에 지정
    var f = document.passForm;

    if(f.b_pass.value == ""){
        alert("비밀번호를 입력해 주세요.");
        return false;
    }

    // 검사가 성공이면 form 을 submit 한다
    f.submit();

}
</script>
