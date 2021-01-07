<?php
/**
 * Created by PhpStorm.
 * User: Jungmin
 * Date: 2021-01-06
 * Time: 오후 9:20
 */


session_start();

if(isset($_SESSION["admin"])) {
    $username = $_SESSION["admin"]; // 관리자는 id로
}else{
    $username = "user" . $_SERVER["REMOTE_ADDR"];// 사용자 식별은 user+ 접속 ip로
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
    <link href="./css/postwrite.css" rel="stylesheet">

    <title>글쓰기</title>
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
    <form action="writeprogress.php" method="post">
    <div class="col-12">
        <h2>글쓰기</h2>
        <h6>작성자 : <?php echo $username;?></h6>

        <div class="mb-3">
            <label for="title" class="form-label">제목</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="제목을 입력하세요 (20자이내)" maxlength="20">
            <div class="invalid-feedback">
                제목을 입력해주세요
            </div>
        </div>

    </div>

        <div class="col-12">
            <div class="mb-3">
                <label for="text" class="form-label">내용</label>
                <textarea class="form-control text" placeholder="내용을 입력해주세요 (300자 이하)" id="text" name = "text" maxlength="300"></textarea>
                <div class="invalid-feedback">
                    내용을 입력해주세요.
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">게시글 비밀번호</label>
                <input type="password" class="form-control" id="writepassword" name="password" placeholder="비밀번호를 입력하세요. (10자이내)" maxlength="10">
                <div class="invalid-feedback">
                   비밀번호를 입력해주세요.
                </div>
            </div>
            <div class="mb-3">
                <label for="passwordChk" class="form-label">비밀번호 확인</label>
                <input type="password" class="form-control" id="writepasswordChk" name="passwordChk" placeholder="한번더 입력하세요." maxlength="20">
                <div class="invalid-feedback">
                    동일한 비밀번호를 입력해주세요.
                </div>
            </div>
        </div>

        <div class="btn-box col-12">
            <button id = "writeBtn" class="btn btn-secondary" disabled>작성완료</button>
        </div>
    </form>

</div>

<!--메인 컨텐트 끝-->

</body>

<!--bootstrap js요소 4.3.1 불러오기-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<!--page js요소-->
<script src="./js/postwrite.js"></script>
</html>
