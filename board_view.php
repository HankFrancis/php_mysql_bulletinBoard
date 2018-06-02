<?php
// 1. 공통 인클루드 파일
include ("./head.php");


$host = 'localhost';
$user = 'root';
$dbname = 'hank_board';
$pw = 'threka4880';
$conn = mysqli_connect($host, $user,$pw, $dbname);

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


if($_SESSION[user_level]){
    $u_level = $_SESSION[user_level];
}else{
    $u_level = 0;
}

// 8. 페이징 변수 설정
if($_GET[page] && $_GET[page] > 0){
    // 현재 페이지 값이 존재하고 0 보다 크면 그대로 사용
    $page = $_GET[page];
}else{
    // 그 외의 경우는 현재 페이지를 1로 설정
    $page = 1;
}

// 9. 글정보 가져오기
$b_idx = $_GET[b_idx];
$sql = "select * from ".$_cfg['board_table']." where bc_code = '".$bc_code."' and b_idx = '".$b_idx."'";
$data = sql_fetch($sql);

// 10. 해당 글이 있는지 와 비밀글이면 비밀번호 입력여부 체크체크
if(!$data[b_idx]){
    alert("존재 하지 않는 글입니다.");
}

/*if($data[b_is_secret] && !$_SESSION["b_pass_".$b_idx] && $_SESSION[user_id] != $data[m_id] && $u_level != 9){
    alert("비밀번호를 입력하여 주세요.");
}*/

// 11.글내용 출력




$query = "update bd__board set b_cnt = b_cnt + 1 where b_idx=$b_idx ";
mysqli_query($conn,$query);

?>




<br/>
<table style="width:1000px;height:50px;border:5px #CCCCCC solid;">
    <tr>
        <td align="center" valign="middle" style="font-zise:15px;font-weight:bold;">글보기</td>
    </tr>
</table>
<table style="width:1000px;height:50px;border:0px;">
     <tr>
        <td align="center" valign="middle" style="width:200px;height:50px;background-color:#CCCCCC;">작성일</td>
        <td align="left" valign="middle" style="width:800px;height:50px;"><?=substr($data[b_regdate],0,10)?></td>
     </tr>
     <tr>
        <td align="center" valign="middle" style="width:200px;height:50px;background-color:#CCCCCC;">조회수</td>
        <td align="left" valign="middle" style="width:800px;height:50px;"><?=$data[b_cnt]?></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="width:200px;height:50px;background-color:#CCCCCC;">글제목</td>
        <td align="left" valign="middle" style="width:800px;height:50px;"><?=$data[b_title]?></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="width:200px;height:50px;background-color:#CCCCCC;">작성자명</td>
        <td align="left" valign="middle" style="width:800px;height:50px;"><?=$data[m_name]?></td>
    </tr>
    
    <tr>
        <td align="center" valign="middle" style="width:200px;height:200px;background-color:#CCCCCC;">글내용</td>
        <td align="left" valign="middle" style="width:800px;height:200px;"><?=nl2Br($data[b_contents])?></td>
    </tr>
</table>

<br/>
<table style="width:1000px;height:50px;">
    <tr>
        <td align="center" valign="middle"><input type="button" value=" 목록보기 " onClick="location.href='./board_list.php?bc_code=<?=$bc_code?>&page=<?=$page?>';"></td>
    
    
    <?php
    if($_SESSION[user_id] == $data[m_id] || $u_level == 9)
    {?>
        <td align="center" valign="middle"><input type="button" value=" 글수정 " onClick="location.href='./board_modify.php?bc_code=<?=$bc_code?>&b_idx=<?=$b_idx?>&page=<?=$page?>';"></td>
    <?php
    }?>


    <?php 
    if($_SESSION[user_id] == $data[m_id] || $u_level == 9)
    {?>
        <td align="center" valign="middle"><input type="button" value=" 글삭제 " onClick="location.href='./board_delete.php?bc_code=<?=$bc_code?>&b_idx=<?=$b_idx?>&page=<?=$page?>';"></td>
    <?php
    }?>

    </tr>
</table>


<br/>
    <table style="width:1000px;height:50px;border:5px #CCCCCC solid;">
        <tr>
            <td align="center" valign="middle" style="font-zise:15px;font-weight:bold;">댓글작성</td>
        </tr>
    </table>
<br/>
    
    <form name="bWriteForm" method="post" enctype="multipart/form-data" action="./board_comment_save.php" style="margin:0px;">
    
    <input type="hidden" name="bc_code" value="<?=$bc_code?>">
    <input type="hidden" name="b_idx" value="<?=$b_idx?>">
    <input type="hidden" name="page" value="<?=$page?>">
    <table cellspacing="1" style="width:1000px;height:50px;border:0px;background-color:#999999;">
    
        <tr>
            <td align="center" valign="middle" width="100" style="height:30px;background-color:#CCCCCC;">이름</td>
            <td align="center" valign="middle" width="800" style="height:30px;background-color:#CCCCCC;">댓글내용</td>
            <td align="center" valign="middle" width="100" style="height:30px;background-color:#CCCCCC;">&nbsp;</td>
        </tr>
        <tr>
            <td align="center" valign="middle" width="100" style="height:30px;background-color:#FFFFFF;">
            <input typr="text" name="m_name" <?php if($_SESSION[user_idx]) { echo " value='".$_SESSION[user_name]."' readOnly";}?>  style="width:90px;">
            </td>
            <td align="center" valign="middle" width="800" style="height:30px;background-color:#FFFFFF;"><input type="text" name="co_contents" style="width:780px;"></td>
            <?php if($_SESSION[user_id] == $data[m_id] || $u_level == 9){ ?>
            <td align="center" valign="middle" width="100" style="height:30px;background-color:#FFFFFF;"><input type="button" value=" 댓글쓰기 " onClick="write_save();"></td>
            <?php
          } ?>
        </tr>
    </table>
    
    <script>



    function write_save()
    {
        var f = document.bWriteForm;

        if(f.m_name.value == ""){
            alert("이름을 입력해 주세요.");
            return false;
        }

        if(f.co_contents.value == ""){
            alert("댓글내용을 입력해 주세요.");
            return false;
        }

        f.submit();
    }

    </script>
    </form>

    <br/>
    <table style="width:1000px;height:50px;border:5px #CCCCCC solid;">
        <tr>
            <td align="center" valign="middle" style="font-zise:15px;font-weight:bold;">댓글목록</td>
        </tr>
    </table>
    <br/>
    <table cellspacing="1" style="width:1000px;height:50px;border:0px;background-color:#999999;">
        <tr>
            <td align="center" valign="middle" width="5%" style="height:30px;background-color:#CCCCCC;">번호</td>
            <td align="center" valign="middle" width="50%" style="height:30px;background-color:#CCCCCC;">댓글내용</td>
            <td align="center" valign="middle" width="15%" style="height:30px;background-color:#CCCCCC;">글쓴이</td>
            <td align="center" valign="middle" width="20%" style="height:30px;background-color:#CCCCCC;">작성일</td>
            
        </tr>




    <?php

    // 16. 전체 댓글 갯수 알아내기
    $sql = "select count(*) as cnt from ".$_cfg['comment_table']." where b_idx = '".$b_idx."' ";
    $total_count = sql_total($sql);


    // 17. 댓글목록 구하기
    $query = "select * from ".$_cfg['comment_table']." where b_idx = '".$b_idx."' order by co_idx desc ";
    $result = mysqli_query($conn, $query);

    // 18.데이터 갯수 체크를 위한 변수 설정
    $i = 0;



    // 19.데이터가 있을 동안 반복해서 값을 한 줄씩 읽기
    while($data_commnent = mysqli_fetch_array($result)){
    ?>
        <tr>
            <td align="center" valign="middle" style="height:30px;background-color:#FFFFFF;"><?=($total_count - $i )?></td>
            <td align="left" valign="middle" style="height:30px;background-color:#FFFFFF;">&nbsp;<?=$data_commnent[co_contents]?></td>
            <td align="center" valign="middle" style="height:30px;background-color:#FFFFFF;"><?=$data_commnent[m_name]?></td>
            <td align="center" valign="middle" style="height:30px;background-color:#FFFFFF;"><?=substr($data_commnent[co_regdate],0,10)?></td>
            <?php
          if($_SESSION[user_id] == $data_commnent[m_name]|| $u_level == 9){
          ?>
            <td align="center" valign="middle" style="height:30px;background-color:#FFFFFF;"><input type="button" value=" 지우기 "
               onClick="location.href='./board_comment_delete.php?co_idx=<?=$data_commnent[co_idx]?>&m_name=<?=$data_commnent[m_name]?>&bc_code=<?=$bc_code?>&b_idx=<?=$b_idx?>&page=<?=$page?>';"></td>
               <?php
              }
                ?>
        </tr>
    <?php
        // 21.데이터 갯수 체크를 위한 변수를 1 증가시킴
        $i++;
    }


    // 22. 댓글데이터가 하나도 없으면 
    if($i == 0){
    ?>
        <tr>
            <td align="center" valign="middle" colspan="4" style="height:50px;background-color:#FFFFFF;">댓글이 하나도 없습니다.</td>
        </tr>
    <?php
    }
    ?>