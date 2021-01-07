<?php
/**
 * Created by PhpStorm.
 * User: Jungmin
 * Date: 2021-01-06
 * Time: 오후 9:20
 */

if(isset($_POST['num']) && isset($_POST['password'])
    && ((int)$_POST['num'])>0 && strlen($_POST['password'])<=10){ //파라메타 값이 유효하다면

    $conn = mysqli_connect("localhost" , "boardadmin", "board1234", "board", "3306"); // DB 커넥션

    $num = (int)$_POST['num'];

    $query ="SELECT NUM, USERNAME, PASSWORD, TITLE, CONTENT , VIEWCOUNT, WRDATE , UWDATE FROM POST WHERE NUM = ? AND PASSWORD = ?"; // select 쿼리문

    $stmt = mysqli_prepare($conn, $query); // sql injection 방지 prepare stmt 사용

    mysqli_stmt_bind_param($stmt, "is", $num ,
        $_POST['password'] ); // sql 변수에 바인딩

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt); // 결과받음

    if($result && mysqli_stmt_affected_rows($stmt) != 0){ // result가존재하고 결과 row가 있을때;
        $row = mysqli_fetch_assoc($result); // ROW 추출
        mysqli_free_result($result) ; // result 메모리 해제
        mysqli_close($conn); // 커넥션종료
    }else{
        ?>
        <script>
            alert("비밀번호가 틀렸거나 해당게시글은 존재하지 않습니다. \n전 페이지로 이동합니다.");
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


?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- bootstrap 4.3.1 css요소 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- 기본 폰트 구글 Noto Sans 굵기 400,500,900 -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;500;900&display=swap" rel="stylesheet">
    <!-- 기본 css -->
    <!--jquery 3.3.1 불러오기-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- 기본 css-->
    <link href="./css/basic.css" rel="stylesheet">
    <!-- 페이지 css -->
    <link href="./css/postupdate.css" rel="stylesheet">

    <title>글수정</title>
</head>
<body>
<!--네비바 시작-->
<div id="navbar">
    <?php
    include "navbar.php";
    ?>
</div>

<!--네비바 끝-->

<!--메인 컨텐트 영역-->
<div class="content col-12 col-md-8 row">
    <form action="updateprogress.php" method="post">
    <div class="col-12">
        <h2>글수정</h2>
        <h6>작성자 : <?php echo $row['USERNAME']; ?> </h6>
        <h6>조회수 : <?php echo $row['VIEWCOUNT']?></h6>
        <h6>작성일 : <?php echo $row['WRDATE']; ?> </h6>
        <?php
        if($row['UWDATE']!=null) { //수정했었다면
        ?>
        <h6>최근 수정일 : <?php echo $row['UWDATE']?></h6>
        <?php
        }
        ?>
        <div class="mb-3">
            <label for="title" class="form-label">제목</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="제목을 입력하세요 (20자이내)" value="<?php echo $row['TITLE']; ?>" maxlength="20">
        </div>

    </div>

        <div class="col-12">
            <div class="mb-3">
                <label for="text" class="form-label">내용</label>
                <textarea class="form-control text" placeholder="내용을 입력해주세요 (300자 이하)" id="text" name = "text" maxlength="300"><?php echo $row['CONTENT']; ?></textarea>
                <input type="hidden" name ="num" value="<?php echo $_POST['num']; ?>">
                <input type="hidden" name ="password" value="<?php echo $_POST['password']; ?>">
            </div>
        </div>

        <div class="btn-box col-12">
            <button class="btn btn-outline-primary">수정완료</button>
        </div>
    </form>

</div>

<!--메인 컨텐트 끝-->

</body>

<!--bootstrap js요소 4.3.1 불러오기-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>

    $(function () {

        function changeText() { // textarea 크기자동조절
            $(this).height(1).height( $(this).prop('scrollHeight')+12 );
        }

        $(".text").on("keydown keyup", changeText);
        $(".text").keyup();
    });

</script>
</html>
