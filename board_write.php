<?php
// 1. 공통 인클루드 파일
include ("./head.php");

// 2. 게시판 코드 검사
$bc_code = $_GET[bc_code];
if($bc_code){
    // 3. 게시판 코드가 있으면 게시판 설정 불러오기
    $b_config_sql = "select * from ".$_cfg['config_table']." where bc_code = '".$bc_code."'";
    $board_config = sql_fetch($b_config_sql);
}else{
    alert("게시판 코드가 없습니다.");
}

// 4. 존재하는 게시판인지 확인
if(!$board_config[bc_idx]){
    alert("존재 하지 않는 게시판입니다.");
}

// 5. 게시판 권한 체크
if($_SESSION[user_level]){
    $u_level = $_SESSION[user_level];
}else{
    $u_level = 0;
}



// 8. 입력 HTML 출력
?>



<br/>
<table style="width:1000px;height:50px;border:5px #CCCCCC solid;">
    <tr>
        <td align="center" valign="middle" style="font-zise:15px;font-weight:bold;">글쓰기</td>
    </tr>
</table>
<br/>
<form name="bWriteForm" method="post" enctype="multipart/form-data" action="./board_write_save.php" style="margin:0px;">
<input type="hidden" name="bc_code" value="<?=$bc_code?>">
<table style="width:1000px;height:50px;border:0px;">
    <tr>
        <td align="center" valign="middle" style="width:200px;height:50px;background-color:#CCCCCC;">글제목</td>
        <td align="left" valign="middle" style="width:800px;height:50px;"><input type="text" name="b_title" style="width:780px;"></td>
    </tr>
    <?php
    // 9.로그인 한 상태가 아니면 이름을 쓰고 로그인 한 상태면 hidden 으로 넘김
    if(!$_SESSION[user_idx]){
    ?>
    <tr>
        <td align="center" valign="middle" style="width:200px;height:50px;background-color:#CCCCCC;">작성자명</td>
        <td align="left" valign="middle" style="width:800px;height:50px;"><input type="text" name="m_name" style="width:780px;"></td>
    </tr>
    <?php
    }else{
    ?>
    <input type="hidden" name="m_name" value="<?=$_SESSION[user_name]?>">
    <?php
    }
    ?>

    

    <tr>
        <td align="center" valign="middle" style="width:200px;height:200px;background-color:#CCCCCC;">글내용</td>
        <td align="left" valign="middle" style="width:800px;height:200px;">
        <textarea name="b_contents" style="width:800px;height:200px;"></textarea>
        </td>
    </tr>



    <!-- 12. 글쓰기 버튼 클릭시 입력필드 검사 함수 write_save 실행 -->
    <tr>
        <td align="center" valign="middle" colspan="2"><input type="button" value=" 글쓰기 " onClick="write_save();">&nbsp;&nbsp;&nbsp;<input type="button" value=" 뒤로가기 " onClick="history.back();"></td>
    </tr>
</table>
</form>



<script>
// 13.입력필드 검사함수
function write_save()
{
    // 14.form 을 f 에 지정
    var f = document.bWriteForm;

    // 15.입력폼 검사

    if(f.b_title.value == ""){
        alert("글제목을 입력해 주세요.");
        return false;
    }

    <?php
    // 16. 비밀글을 사용하면 비밀글 체크 여부와 비밀번호 입력 체크
    if($board_config[bc_use_secret]){
    ?>
    if(f.b_is_secret.checked == true ){
        alert("비밀번호를 입력해 주세요.");
        return false;
    }
    <?php
    }
    ?>
    
    if(f.b_contents.value == ""){
        alert("글내용을 입력해 주세요.");
        return false;
    }

    // 17.검사가 성공이면 form 을 submit 한다
    f.submit();

}
</script>
