<?php
//  공통 인클루드 파일 
include ("./head.php");

//  로그인 안한 회원은 로그인 페이지로 보내기
if(!$_SESSION[user_id]){
    alert("로그인 하셔야 합니다.", "./login.php");
}


$host = 'localhost';
$user = 'root';
$dbname = 'hank_board';
$pw = 'threka4880';
$conn = mysqli_connect($host, $user,$pw, $dbname);


//  회원 설정 데이터 불러오기
$sql = "select * from bd__member where m_idx = '".$_SESSION[user_idx]."'";
$data = sql_fetch($sql);

//  입력 HTML 출력
?>
<br/>
<table style="width:1000px;height:50px;border:5px #CCCCCC solid;">
    <tr>
        <td align="center" valign="middle" style="font-zise:15px;font-weight:bold;">회원 정보 수정</td>
    </tr>
</table>
<br/>
<form name="modifyForm" method="post" action="./member_modify_save.php" style="margin:0px;">
<table style="width:1000px;height:50px;border:0px;">
    <tr>
        <td align="center" valign="middle" style="width:200px;height:50px;background-color:#CCCCCC;">회원이름</td>
        <td align="left" valign="middle" style="width:800px;height:50px;"><input type="text" name="m_name" style="width:780px;" value="<?=$data[m_name]?>"></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="width:200px;height:50px;background-color:#CCCCCC;">비밀번호</td>
        <td align="left" valign="middle" style="width:800px;height:50px;"><input type="password" name="m_pass" style="width:380px;"></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="width:200px;height:50px;background-color:#CCCCCC;">비밀번호 확인</td>
        <td align="left" valign="middle" style="width:800px;height:50px;"><input type="password" name="m_pass2" style="width:380px;"></td>
    </tr>
   
    <tr>
        <td align="center" valign="middle" colspan="2"><input type="button" value=" 정보수정 " onClick="member_save();"></td>
    </tr>
</table>
</form>
<script>
// 입력필드 검사함수
function member_save()
{
    // form 을 f 에 지정
    var f = document.modifyForm;

    // 입력폼 검사

    if(f.m_name.value == ""){
        alert("회원이름을 입력해 주세요.");
        return false;
    }

    if(f.m_pass.value == ""){
        alert("비밀번호를 입력해 주세요.");
        return false;
    }

    if(f.m_pass.value != f.m_pass2.value){
        // 비밀번호와 확인이 서로 다르면 경고창으로 메세지 출력 후 함수 종료
        alert("비밀번호를 확인해 주세요.");
        return false;
    }

    // 검사가 성공이면 form 을 submit 한다
    f.submit();

}


</script>


</br>
</br>

<form name="bWriteForm" method="post" action="./point_save.php" style="margin:0px;">
<table style="width:1000px;height:50px;border:0px;">
   <tr>
    
    <td align="center" valign="middle" width="800" style="height:30px;background-color:#FFFFFF;"><input type="hidden" name="send_user" value= <?=$_SESSION[user_id]?> style="width:0px;"></td>
    <td align="right" valign="middle" width="800" style="height:30px;background-color:#FFFFFF;">유저 ID</td>
    <td align="center" valign="middle" width="800" style="height:30px;background-color:#FFFFFF;"><input type="text" name="get_user" style="width:200px;"></td>
    <td align="right" valign="middle" width="800" style="height:30px;background-color:#FFFFFF;">보낼 포인트</td>
    <td align="center" valign="middle" width="800" style="height:30px;background-color:#FFFFFF;"><input type="number" name="point" min ="0" style="width:200px;"></td>
    
    <td align="center" valign="middle" width="100" style="height:30px;background-color:#FFFFFF;"><input type="button" value="보내기" onClick="point_save();"></td>
    </tr>

<script>
       function point_save()
    {
        var f = document.bWriteForm;

        if(f.point.value == ""){
            alert("포인트를 입력해 주세요.");
            return false;
        }

        if(f.get_user.value == ""){
            alert("받을 사람을 입력해 주세요.");
            return false;
        }

        f.submit();
    }
</script>
</table>
</form>