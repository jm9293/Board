<?php
/**
 * Created by PhpStorm.
 * User: Jungmin
 * Date: 2021-01-06
 * Time: 오후 9:37
 */

$success = false; // 작업 성공하였는지

if(isset($_POST['title']) && isset($_POST['text'])
    && isset($_POST['password']) && isset($_POST['passwordChk'])
    && strlen($_POST['title'])<=30 && strlen($_POST['text'])<=300
    && strlen($_POST['password'])<=10 && strcmp ($_POST['password'], $_POST['passwordChk']) == 0){ //파라메타 값이 유효하다면


    $username = "user".$_SERVER["REMOTE_ADDR"];
    $conn = mysqli_connect("localhost" , "boardadmin", "board1234", "board", "3306"); // DB 커넥션

    $query ="INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE) 
    VALUES(?, ?, ?, ?, 0,  NOW())"; // insert 쿼리문

    $stmt = mysqli_prepare($conn, $query); // sql injection 방지 prepare stmt 사용

    mysqli_stmt_bind_param($stmt, "ssss", $username,
        $_POST['password'],$_POST['title'],$_POST['text'] ); // sql 변수에 바인딩

    mysqli_stmt_execute($stmt);

    $success = true; //작업성공
    
}else {
    $success = false; //작업 실패
}

if($success){
    ?>
    <script>
        alert("<?php echo mysqli_stmt_affected_rows($stmt); ?>개의 게시글 작성완료\n작성된 게시글로 이동합니다.");
        location.href = "./postview.php?num=<?php echo mysqli_insert_id($conn); ?>";
    </script>

    <?php
    mysqli_close($conn); // 커넥션종료
}else{
    ?>
    <script>
        alert("입력값이 유효하지 않거나 DB 접속의 문제가 있습니다. \n전 페이지로 이동합니다.");
        history.back();
    </script>
    <?php
}
?>