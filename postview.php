<?php
/**
 * Created by PhpStorm.
 * User: Jungmin
 * Date: 2021-01-06
 * Time: 오후 7:06
 */

$conn = mysqli_connect("localhost" , "boardadmin", "board1234", "board", "3306"); // DB 커넥션

if(!$conn){
    echo "Error : DB 연결 오류</br>";
    exit();

}else{
    $query = "SELECT NUM, USERNAME, TITLE, CONTENT, VIEWCOUNT , WRDATE, UWDATE FROM POST WHERE NUM = ?"; // 쿼리문작성


    $urlQuery = ""; //현재 파라메타 유지용 문자열
    $seachQuery = ""; //검색용 쿼리

    if(isset($_GET["type"])&&isset($_GET["text"])&&((int)$_GET["type"])>0){ // 검색에 요구되는 파라메타가 존재하고 그값이 유효할때
         $seachQuery = "type=".$_GET["type"]."&text=".$_GET["text"]; // 파라메타 저장
    }

    $pageNumQuery = ""; //페이징 유지용 쿼리

    if(isset($_GET['page'])&&((int)$_GET["page"])>0){ //페이지 파라메타가 존재하고 유효할때
        $pageNumQuery = "page=".$_GET["page"];
    }

    if($seachQuery!=""&&$pageNumQuery!=""){
        $urlQuery = "?".$seachQuery."&".$pageNumQuery;
    }else if($seachQuery!=""){
        $urlQuery = "?".$seachQuery;
    }else if($pageNumQuery!=""){
        $urlQuery = "?".$pageNumQuery;
    }


    $num = 0; //파라메타 게시글 번호

    if(isset($_GET['num'])){ // 파라메타가 존재할때
        if(((int)$_GET['num'])>0){ // 파라메타가 숫자로 변환가능하고 0보다 클때
            $num = (int)$_GET['num'];  // 대입
        }
    }

    $stmt = mysqli_prepare($conn, $query); // sql injection 방지 prepare stmt 사용

    mysqli_stmt_bind_param($stmt, "i", $num); // sql 변수에 바인딩

    mysqli_stmt_execute($stmt); // 쿼리날림

    $result = mysqli_stmt_get_result($stmt); // 결과받음

    if($result){
        $row = mysqli_fetch_assoc($result); // ROW 추출
    }else{
        echo "Error : 해당게시글 없음</br>";
        exit();
    }



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
    <link href="./css/postview.css" rel="stylesheet">

    <title><?php echo $row['TITLE']?></title>
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
    <div class="col-12">
        <h6><?php echo $row['NUM']?>번 게시물 보기 </h6>
        <h2>제목 : <?php echo $row['TITLE']?></h2>
        <h6>작성자 : <?php echo $row['USERNAME']?> </h6>
        <h6>조회수 : <?php echo $row['VIEWCOUNT']?></h6>
        <h6>작성일 : <?php echo $row['WRDATE']?> (<?php echo $row['UWDATE']?>)</h6>
    </div>

    <div class="col-12">
        <textarea class="form-control text" readonly maxlength="300"><?php echo $row['CONTENT']?></textarea>
    </div>
    
    <div class="btn-box col-12">
        <button class="btn btn-outline-primary">수정</button>
        <button class="btn btn-outline-primary">삭제</button>
        <button class="btn btn-outline-primary" onclick="location.href = './list.php<?php echo $urlQuery ?>'">목록으로</button>
    </div>

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
