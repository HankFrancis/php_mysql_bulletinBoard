<?php
// 공통 인클루드 파일
include ("./head.php");

$host = 'localhost';
$user = 'root';
$dbname = 'hank_board';
$pw = 'threka4880';
$conn = mysqli_connect($host, $user,$pw, $dbname);


//  로그인한 회원은 뒤로 보내기
if($_SESSION[user_id]){
    ?>
    <script>
        alert("로그인 하신 상태입니다.");
        history.back();
    </script>
    <?php
}

// 넘어온 변수 검사
if(trim($_POST[m_id]) == ""){
    ?>
    <script>
        alert("아이디를 입력해 주세요.");
        history.back();
    </script>
    <?php
    exit;
}

if(trim($_POST[m_name]) == ""){
    ?>
    <script>
        alert("이름을 입력해 주세요.");
        history.back();
    </script>
    <?php
    exit;
}

if($_POST[m_pass] == ""){
    ?>
    <script>
        alert("비밀번호를 입력해 주세요.");
        history.back();
    </script>
    <?php
    exit;
}

if($_POST[m_pass] != $_POST[m_pass2]){
    ?>
    <script>
        alert("비밀번호를 확인해 주세요.");
        history.back();
    </script>
    <?php
    exit;
}

// 같은 아이디가 있는지 검사
$chk_sql = "select * from bd__member where m_id = '".trim($_POST[m_id])."'";
$chk_result = mysqli_query($conn,$chk_sql);
$chk_data = mysqli_fetch_array($chk_result);

//  가입된 아이디가 있으면 되돌리기
if($chk_data[m_idx]){
    ?>
    <script>
        alert("이미 가입된 아이디 입니다.");
        history.back();
    </script>
    <?php
    exit;
}

//  회원정보 적기
$sql = "insert into bd__member (m_id, m_name, m_pass, m_level) values ('".trim($_POST[m_id])."', '".trim($_POST[m_name])."', '".$_POST[m_pass]."', 1)";
mysqli_query($conn,$sql);

//  로그인 페이지로 보내기
?>
<script>
alert("회원가입이 완료 되었습니다.");
location.replace("./index.php");
</script>