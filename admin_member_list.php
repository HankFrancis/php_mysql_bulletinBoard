<?php
// 공통 인클루드 파일
include "./admin_head.php";

//  페이지 변수 설정
if($_GET[page] && $_GET[page] > 0){
    // 현재 페이지 값이 존재하고 0 보다 크면 그대로 사용
    $page = $_GET[page];
}else{
    // 그 외의 경우는 현재 페이지를 1로 설정
    $page = 1;
}
// 한 페이지에 보일 글 수
$page_row = 10;
// 한줄에 보여질 페이지 수
$page_scale = 10;
// 페이징을 출력할 변수 초기화
$paging_str = "";

// 3. 전체 회원 갯수 알아내기
$sql = "select count(*) as cnt from bd__member where 1";
$total_count = sql_total($sql);



// 페이지 출력 내용 만들기
$paging_str = paging($page, $page_row, $page_scale, $total_count);

//  시작 열을 구함
$from_record = ($page - 1) * $page_row;

//  목록 구하기
$query = "select * from bd__member where 1 order by m_idx desc limit $from_record, $page_row ";
$data = sql_list($query);
?>


<br/>
<table style="width:1000px;height:50px;border:5px #CCCCCC solid;">
    <tr>
        <td align="center" valign="middle" style="font-zise:15px;font-weight:bold;">회원 목록</td>
    </tr>
</table>
<br/>
<table cellspacing="1" style="width:1000px;height:50px;border:0px;background-color:#999999;">
    <tr>
        <td align="center" valign="middle" width="5%" style="height:30px;background-color:#CCCCCC;">번호</td>
        <td align="center" valign="middle" width="10%" style="height:30px;background-color:#CCCCCC;">아이디</td>
        <td align="center" valign="middle" width="35%" style="height:30px;background-color:#CCCCCC;">이름</td>
        <td align="center" valign="middle" width="20%" style="height:30px;background-color:#CCCCCC;">레벨</td>
        <td align="center" valign="middle" width="15%" style="height:30px;background-color:#CCCCCC;">포인트</td>
        <td align="center" valign="middle" width="15%" style="height:30px;background-color:#CCCCCC;">게시글 수</td>
    </tr>
<?php
if($total_count > 0){
    for($i=0;$i<count($data);$i++){
?>
    <tr>
        <td align="center" valign="middle" style="height:30px;background-color:#FFFFFF;"><?=($total_count - (($page - 1) * $page_row) - $i )?></td>
        <td align="center" valign="middle" style="height:30px;background-color:#FFFFFF;"><a href="./admin_member_modify.php?m_idx=<?=$data[$i][m_idx]?>&page=<?=$page?>"><?=$data[$i][m_id]?></a></td>
        <td align="center" valign="middle" style="height:30px;background-color:#FFFFFF;"><a href="./admin_member_modify.php?m_idx=<?=$data[$i][m_idx]?>&page=<?=$page?>"><?=$data[$i][m_name]?></a></td>
        <td align="center" valign="middle" style="height:30px;background-color:#FFFFFF;">
        <?php
        if($data[$i][m_level] == 1){
            echo "normal";
        }else if($data[$i][m_level] == 9){
            echo "admin";
        }else{
            echo $data[$i][m_level];
        }?>
        </td>
        <td align="center" valign="middle" style="height:30px;background-color:#FFFFFF;"><a href="./admin_member_modify.php?m_idx=<?=$data[$i][m_idx]?>&page=<?=$page?>"><?=$data[$i][m_point]?></a></td>
        <td align="center" valign="middle" style="height:30px;background-color:#FFFFFF;"><?=$data[$i][m_post]?></a></td>
    </tr>
<?php
    }
}else{?>
    <tr>
        <td align="center" valign="middle" colspan="4" style="height:50px;background-color:#FFFFFF;">회원이 하나도 없습니다.</td>
    </tr>
<?php } 
?>
</table>