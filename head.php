<?php
include "./inc/config.php";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<title></title>
</head>
<table style="width:1000px;height:50px;border:5px #CCCCCC solid;">
    <tr>
        <td align="center" valign="middle" colspan="3" style="font-zise:15px;font-weight:bold;">
        TEAM K 게시판
        </td>
    </tr>
    <?php
    // 로그인 여부에 따라 상단 메뉴가 다르게
    if($_SESSION[user_idx]){
    ?>
    <tr>
        <?php
        // 로그인한 사람이 관리자면 관리자페이지 링크를, 아니면 홈 링크를
        if($_SESSION[user_level] == 9){
        ?>
        <td align="center" valign="middle" style="font-size:12px;"><a href="./admin_index.php">관리자페이지</a></td>
        <?php  }

        else{?>
        <td align="center" valign="middle" style="font-size:12px;"><a href="./index.php">홈</a></td>
        <?php  }?>
        <td align="center" valign="middle" style="font-size:12px;"><a href="./member_modify.php">정보수정&포인트보내기</a></td>
        <td align="center" valign="middle" style="font-size:12px;"><a href="./logout.php">로그아웃</a></td>
    </tr>

 
    <?php  }


    else{?>
    <tr>
        <td align="center" valign="middle" style="font-size:12px;"><a href="./index.php">홈</a></td>
        <td align="center" valign="middle" style="font-size:12px;"><a href="./member_join.php">회원가입</a></td>
        <td align="center" valign="middle" style="font-size:12px;"><a href="./login.php">로그인</a></td>
    </tr>
    <?php  }?>


</table>
<br>
<table style="width:1000px;height:30px;border:5px #CCCCCC solid;">
    <tr>
<?php
// 생성된 게시판 목록 불러와 링크 만들기
    $sql = "select * from bd__board_config where 1 order by bc_idx desc";
    $data = sql_list($sql);
    
    for($i=0;$i<count($data);$i++){
        // 게시판 목록을 보여주는 파일에 게시판 종류를 구분하는 bc_code 를 get 으로 연결
?>
        <td><a href="./board_list.php?bc_code=<?=$data[$i][bc_code]?>"><?=$data[$i][bc_name]?></a></td>
    <?php
    }
    ?>
    </tr>
</table>