<?php
/**
 * Created by PhpStorm.
 * User: Jungmin
 * Date: 2021-01-07
 * Time: 오후 3:46
 */

session_start();


if(isset($_SESSION["admin"])){ //관리자 로그인 중이라면
    session_destroy();// 관리자 로그인밖에 없으므로 세션 삭제
    ?>
    <script>
        alert("로그아웃완료되었습니다.");
        location.href = document.referrer;
    </script>
    <?php
}else{
    ?>
    <script>
        alert("잘못된 접근.");
        location.href = document.referrer;
    </script>
    <?php
}
?>

