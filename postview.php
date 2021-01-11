<?php
/**
 * Created by PhpStorm.
 * User: Jungmin
 * Date: 2021-01-06
 * Time: 오후 7:06
 */

$conn = mysqli_connect("localhost" , "boardadmin", "board1234", "board", "3306"); // DB 커넥션

session_start(); // 세션사용

if(!$conn){
    ?>
<script>
alert("입력값이 유효하지 않거나 DB 접속의 문제가 있습니다. \n전 페이지로 이동합니다.");
history.back();
</script>

<?php
    exit();

}else{
    $query = "SELECT NUM, USERNAME, TITLE, CONTENT, VIEWCOUNT , WRDATE, UWDATE FROM POST WHERE NUM = ?"; // 쿼리문작성

    // 검색 url 유지용 코드 시작
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

    // 검색 url 유지용 코드 끝

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
        mysqli_free_result($result) ; // result 메모리 해제

        $cookieName = 'VIEW_'.$row['NUM'];

        if(!isset($_COOKIE[$cookieName])){ // 쿠키에 조회기록이 없을때
            // 조회수 증가
            $query = "UPDATE POST SET VIEWCOUNT = VIEWCOUNT+1 WHERE NUM = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $num); // sql 변수에 바인딩
            mysqli_stmt_execute($stmt); // 쿼리날림
            $row['VIEWCOUNT'] = (int)$row['VIEWCOUNT'] + 1; // 조회수 최신화
            setcookie("$cookieName", "1", time() + (3600*24), "/"); // 조회수를 24시간동안 안오르도록 쿠키발급
        }

        mysqli_close($conn); // 커넥션종료
    }else{
        ?>
<script>
alert("입력값이 유효하지 않거나 DB 접속의 문제가 있습니다. \n전 페이지로 이동합니다.");
history.back();
</script>

<?php
        mysqli_close($conn); // 커넥션종료
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
            <h6>작성시간 : <?php echo substr( $row["WRDATE"] , 0, strrpos($row["WRDATE"],":")); // 초단위 자르고 출력?></h6>
            <?php
        if($row['UWDATE']!=null) { // 수정일이 존재한다면 출력
            ?>
            <h6>수정시간 : <?php echo substr( $row["UWDATE"] , 0, strrpos($row["UWDATE"],":"));?></h6>
            <?php
        }
        ?>
        </div>

        <div class="col-12">
            <textarea class="form-control text" readonly maxlength="300"><?php echo $row['CONTENT']?></textarea>
        </div>


        <div class="btn-box col-12">
            <button type="button" class="btn btn-outline-primary modal-btn" data-toggle="modal" data-target="#modal"
                id="updateBtn">수정</button>
            <button type="button" class="btn btn-outline-danger modal-btn" data-toggle="modal" data-target="#modal"
                id="delBtn">삭제</button>
            <button type="button" class="btn btn-outline-secondary"
                onclick="location.href = './list.php<?php echo $urlQuery ?>'">목록으로</button>
        </div>


        <!-- 비밀번호 입력 모달창 -->
        <div class="modal fade" id="modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <?php
                    if(isset($_SESSION["admin"])) { // 관리자 로그인시
                        ?>
                        <h5 class="modal-title" id="delModalLabel">수정 & 삭제</h5>
                        <?php
                    }else{ 
                        ?>
                        <h5 class="modal-title" id="delModalLabel">비밀번호 입력</h5>
                        <?php
                        }
                    ?>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="modalform" action="" method="post">
                        <input type="hidden" name="num" value="<?php echo $row['NUM']; // 삭제나 수정시 파라메타로 넘김 ?>">
                        <div class="modal-body">

                            <?php
                        if(isset($_SESSION["admin"])) { // 관리자 로그인시 비밀번호 미입력
                            ?>
                            수정 & 삭제하시겠습니까?
                            <input type="hidden" name="password" value="admin">
                            <?php
                        }else{
                            ?>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="비밀번호를 입력하세요. (10자이내)" maxlength="10" required>
                            <?php
                        }
                        ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                            <button type="submit" class="btn btn-primary">진행</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!--메인 컨텐트 끝-->

</body>

<!--bootstrap js요소 4.3.1 불러오기-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>
<!--page js요소-->
<script src="./js/postview.js"></script>

</html>