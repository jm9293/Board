<?php
/**
 * Created by PhpStorm.
 * User: Jungmin
 * Date: 2021-01-06
 * Time: 오후 9:37
 */

$success = false; // 작업 성공하였는지

if(isset($_POST['num']) && isset($_POST['password'])
    && ((int)$_POST['num'])>0 && strlen($_POST['password'])<=10){ //파라메타 값이 유효하다면

    $conn = mysqli_connect("localhost" , "boardadmin", "board1234", "board", "3306"); // DB 커넥션

    $num = (int)$_POST['num'];

    $query ="DELETE FROM POST WHERE NUM = ? AND PASSWORD = ?"; // insert 쿼리문

    $stmt = mysqli_prepare($conn, $query); // sql injection 방지 prepare stmt 사용

    mysqli_stmt_bind_param($stmt, "is", $num ,
        $_POST['password'] ); // sql 변수에 바인딩

    mysqli_stmt_execute($stmt);

    $resInt =  mysqli_stmt_affected_rows($stmt);

    $success = true; //작업성공
    
}else {
    $success = false; //작업 실패
}

if($success){
    if($resInt == 1){
    ?>
    <script>
        alert("게시글 삭제 완료\n게시판으로 이동합니다.");
        location.href = "./list.php";
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
}else{
    ?>
    <script>
        alert("입력값이 유효하지 않거나 DB 접속의 문제가 있습니다. \n이전 페이지로 이동합니다.");
        history.back();
    </script>
    <?php
}
?>