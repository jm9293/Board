<?php
/**
 * Created by PhpStorm.
 * User: Jungmin
 * Date: 2021-01-06
 * Time: 오후 9:37
 */

if(isset($_POST['title'])&&isset($_POST['text'])
    &&isset($_POST['password'])&&isset($_POST['passwordChk'])){


    //echo '<script>alert("작성가능!");</script>';
    $username = "user".$_SERVER["REMOTE_ADDR"];
    $conn = mysqli_connect("localhost" , "boardadmin", "board1234", "board", "3306"); // DB 커넥션

    $query ="INSERT INTO POST (USERNAME, PASSWORD, TITLE, CONTENT, VIEWCOUNT, WRDATE) 
    VALUES(?, ?, ?, ?, 0,  NOW())"; // insert 쿼리문

    $stmt = mysqli_prepare($conn, $query); // sql injection 방지 prepare stmt 사용

    mysqli_stmt_bind_param($stmt, "ssss", $username,
        $_POST['password'],$_POST['title'],$_POST['text'] ); // sql 변수에 바인딩

    mysqli_stmt_execute($stmt);







    ?>
    <script>
        alert("<?php echo mysqli_stmt_affected_rows($stmt); ?>개의 게시글 작성완료!");
        location.href = "./postview.php?num=<?php echo mysqli_insert_id($conn); ?>";
    </script>
<?php
}
?>
