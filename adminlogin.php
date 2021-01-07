<?php
/**
 * Created by PhpStorm.
 * User: Jungmin
 * Date: 2021-01-07
 * Time: 오후 3:11
 */
session_start(); // 세션사용
if(isset($_POST['username']) && isset($_POST['password'])
    && mb_strlen($_POST['username'])<=10 && mb_strlen($_POST['password'])<=10){ // 로그인 입력 값이 유효할시

    $conn = mysqli_connect("localhost" , "boardadmin", "board1234", "board", "3306"); // DB 커넥션


    $query ="SELECT ID FROM ADMIN WHERE ID = ? AND PASSWORD = ?"; // select 쿼리문

    $stmt = mysqli_prepare($conn, $query); // sql injection 방지 prepare stmt 사용

    mysqli_stmt_bind_param($stmt, "ss", $_POST['username'] , $_POST['password'] ); // sql 변수에 바인딩

    mysqli_stmt_execute($stmt);


    $result = mysqli_stmt_get_result($stmt); // 결과받음

    if($result && mysqli_stmt_affected_rows($stmt) != 0){ // result가존재하고 결과 row가 있을때;
        $row = mysqli_fetch_assoc($result); // ROW 추출
        mysqli_free_result($result) ; // result 메모리 해제
        mysqli_close($conn); // 커넥션종료'


        $_SESSION["admin"] = $row['ID']; // 세션의 관리자 ID 발급


        ?>
        <script>
            alert("로그인성공\n<?php echo $row['ID'] ?>님 환영합니다.");
            location.href = document.referrer;
        </script>

        <?php

    }else{
        ?>
        <script>
            alert("아이디나 비밀번호가 맞지 않습니다. \n전 페이지로 이동합니다.");
            history.back();
        </script>

        <?php
        mysqli_close($conn); // 커넥션종료
        exit();
    }







}else { // 파라메타 유효하지 않을시
    ?>
    <script>
        alert("입력값이 유효하지 않습니다. \n이전 페이지로 이동합니다.");
        history.back();
    </script>
    <?php
}



