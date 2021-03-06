<?php
/**
 * Created by PhpStorm.
 * User: Jungmin
 * Date: 2021-01-06
 * Time: 오후 9:37
 */
session_start(); // 세션사용
$success = false; // 작업 성공하였는지

if(isset($_POST['title']) && isset($_POST['text'])
    && isset($_POST['num']) && isset($_POST['password'])
    && ((int)$_POST['num'])>0 && mb_strlen($_POST['password'])<=10
    &&  mb_strlen($_POST['title'])<=30 &&  mb_strlen($_POST['text'])<=300){ //파라메타 값이 유효한지

    $conn = mysqli_connect("localhost" , "boardadmin", "board1234", "board", "3306"); // DB 커넥션

    $num = (int)$_POST['num'];

    if(isset($_SESSION["admin"])){ //관리자 로그인시 password 미검증
        $query ="UPDATE POST SET TITLE = ?, CONTENT = ?, UWDATE = NOW() WHERE NUM = ? "; // update 쿼리문
    }else{
        $query ="UPDATE POST SET TITLE = ?, CONTENT = ?, UWDATE = NOW() WHERE NUM = ? AND  PASSWORD = ?"; // update 쿼리문
    }


    $stmt = mysqli_prepare($conn, $query); // sql injection 방지 prepare stmt 사용

    if(isset($_SESSION["admin"])){ //관리자 로그인시
        mysqli_stmt_bind_param($stmt, "ssi",$_POST['title'] ,$_POST['text'], $num  ); // sql 변수에 바인딩
    }else{
        mysqli_stmt_bind_param($stmt, "ssis",$_POST['title'] ,$_POST['text'], $num , $_POST['password'] ); // sql 변수에 바인딩
    }

    mysqli_stmt_execute($stmt);

    $resInt =  mysqli_stmt_affected_rows($stmt);

    $success = true; //작업성공
    
}else {
    $success = false; //작업 실패
}

if($success){
    if($resInt == 1){ // 업데이트한 row가 있을때
    ?>
<script>
alert("게시글 수정 완료\n해당 게시글로 이동합니다.");
location.href = "./postview.php?num=<?php echo $_POST['num']; ?>";
</script>

<?php
    }else{
        ?>
<script>
alert("비밀번호가 틀렸거나 입력한 값이 유효하지 않습니다. \n이전페이지로 이동합니다.");
history.back();
</script>

<?php
    }
    mysqli_close($conn); // 커넥션종료
    exit();
}else{ // 파라메타 유효하지 않을때
    ?>
<script>
alert("입력값이 유효하지 않거나 DB 접속의 문제가 있습니다. \n이전 페이지로 이동합니다.");
history.back();
</script>
<?php
}   exit();
?>