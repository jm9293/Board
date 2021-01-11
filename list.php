<?php
/**
 * Created by PhpStorm.
 * User: Jungmin
 * Date: 2021-01-05
 * Time: 오전 11:15
 */
session_start(); // 세션사용
$conn = mysqli_connect("localhost" , "boardadmin", "board1234", "board", "3306"); // DB 커넥션

if(!$conn){ // 커넥션 오류시
    ?>
<script>
alert("입력값이 유효하지 않거나 DB 접속의 문제가 있습니다.");
</script>
<?php
    exit();
}else{

    $pageRow = 10; // 한페이지에가 가져올 게시글 개수

    if(isset($_GET["page"])){ //파라메타가 있을시
        $pageNum = (int)$_GET["page"];
    }else{
        $pageNum = 1;
    }

    $whereQuery = ""; // 검색시 사용한 where 구문

    $infotext = ""; // 결과에대해 안내해주는 문자열

    $type = 1; // 검색 타입 없을시 1로 초기화

    $text = ""; // 검색 입력값

    $urlQuery = ""; //현재 파라메타 유지용 문자열

    $query = "SELECT count(*) FROM POST";

    $searchbool =  isset($_GET["type"])&&isset($_GET["text"])&&((int)$_GET["type"])!=0; // 검색에 요구되는 파라메타가 존재하고 그값이 유효한지 여부

    if($searchbool){

        $infotext = '"'.$_GET["text"].'"로 검색한 결과입니다.</br>';
        $type = (int)$_GET["type"];
        $text = $_GET["text"];
        $buf_text = "%".$_GET["text"]."%"; // 입력값에 %%를 붙인 임시 문자열
        $urlQuery = "type=".$type."&text=".$_GET["text"]."&"; // 파라메타 저장
        switch ($type){
            case 1 :
                $whereQuery =" WHERE TITLE LIKE ? OR CONTENT LIKE ?";
                $query.= $whereQuery;
                $stmt = mysqli_prepare($conn, $query); // sql injection 방지 prepare stmt 사용
                mysqli_stmt_bind_param($stmt, "ss", $buf_text,$buf_text); // sql 변수에 바인딩
                break;
            case 2 :
                $whereQuery =" WHERE USERNAME LIKE ?";
                $query.= $whereQuery;
                $stmt = mysqli_prepare($conn, $query); // sql injection 방지 prepare stmt 사용
                mysqli_stmt_bind_param($stmt, "s", $buf_text); // sql 변수에 바인딩
                break;
            case 3 :
                $whereQuery =" WHERE NUM =?";
                $query.= $whereQuery;
                $num = (int)$_GET["text"]; // 검색입력값을 숫자로 바꿈 숫자가아닐시 0이 나오므로 검색결과 없음
                $stmt = mysqli_prepare($conn, $query); // sql injection 방지 prepare stmt 사용
                mysqli_stmt_bind_param($stmt, "i", $num); // sql 변수에 바인딩
                break;
        }

    }else{ //검색이 아닐때
        $stmt = mysqli_prepare($conn, $query);
    }

    // 게시글 개수 확인 쿼리

    mysqli_stmt_execute($stmt); // 쿼리날림

    $result = mysqli_stmt_get_result($stmt); // 결과받음


    if($pageNum == 0){ // 숫자가 아닌 파라메타일 경우
        ?>
<script>
alert("입력값이 유효하지 않거나 DB 접속의 문제가 있습니다. \n전 페이지로 이동합니다.");
history.back();
</script>

<?php
        exit();
    }

    
    $postCnt = 0;

    if ( $result ) { // 결과 존재시
        $postCnt = mysqli_fetch_assoc($result)['count(*)']; // 전체게시글수

        mysqli_free_result($result); // 결과 메모리 해제

        $query = "SELECT NUM, USERNAME, TITLE, VIEWCOUNT, WRDATE FROM POST".$whereQuery.
            " ORDER BY NUM DESC LIMIT ".($pageNum-1)*$pageRow.", $pageRow"; // 페이징을 이용한 select 쿼리문

        if($searchbool){
            switch ($type){
                case 1 :
                    $stmt = mysqli_prepare($conn, $query); // sql injection 방지 prepare stmt 사용
                    mysqli_stmt_bind_param($stmt, "ss", $buf_text,$buf_text); // sql 변수에 바인딩
                    break;
                case 2 :
                    $stmt = mysqli_prepare($conn, $query); // sql injection 방지 prepare stmt 사용
                    mysqli_stmt_bind_param($stmt, "s", $buf_text); // sql 변수에 바인딩
                    break;
                case 3 :
                    $num = (int)$_GET["text"]; // 검색입력값을 숫자로 바꿈 숫자가아닐시 0이 나오므로 검색결과 없음
                    $stmt = mysqli_prepare($conn, $query); // sql injection 방지 prepare stmt 사용
                    mysqli_stmt_bind_param($stmt, "i", $num); // sql 변수에 바인딩
                    break;
            }
        }else{
            $stmt = mysqli_prepare($conn, $query);
        }
        
        mysqli_stmt_execute($stmt); // 쿼리날림

        $result = mysqli_stmt_get_result($stmt); // 결과받음

        $maxPage = ceil($postCnt / $pageRow); // 전체 게시글수를 보여줄 ROW수로 나눈뒤 무조건 올림 페이징될 전체페이지수

    } else { // 미존재시 종료
        $infotext = "결과를 찾을수없습니다.";
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
    <link href="./css/list.css" rel="stylesheet">

    <title>게시판</title>
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
    <div class="content">
        <div class="col-12 col-md-8 head">
            <h2>게시판</h2>
            <!-- 게시글 개수 출력 -->
            <?php echo $infotext; // 안내메시지 출력?>
            총 <?php echo $postCnt; ?>개의 게시글이 있습니다.

        </div>
        <br>
        <div class="menuname menuborder row col-12 col-md-8 alert-secondary">
            <div class="col-2 col-md-1 menu">No</div>
            <div class="col-6 col-md-4 menu">제목</div>
            <div class="col-4 col-md-2 menu">작성자</div>
            <div class="col-2 col-md-2 menu">조회</div>
            <div class="col-10 col-md-3 menu">작성시간</div>
        </div>
        <?php
    if($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) { //전체 select 된 row 만큼 반복한다.

            ?>
        <div class="menuname row col-12 col-md-8 textlist"
            onclick="location.href='./postview.php?<?php echo $urlQuery."num=".$row["NUM"]."&page=".$pageNum; //클릭시 해당글로이동 ?> '">
            <div class="col-2 col-md-1 text" id="text1"><?php echo $row["NUM"] ?></div>
            <div class="col-6 col-md-4 text" id="text2"><?php echo $row["TITLE"] ?></div>
            <div class="col-4 col-md-2 text" id="text2"><?php echo $row["USERNAME"] ?></div>
            <div class="col-2 col-md-2 text" id="text3"><?php echo $row["VIEWCOUNT"] ?></div>
            <div class="col-10 col-md-3 text" id="text4">
                <?php echo substr( $row["WRDATE"] , 0, strrpos($row["WRDATE"],":")); // 초단위 자르고 출력?></div>
        </div>
        <?php
        }

        mysqli_free_result($result); // 결과 해제
        mysqli_close($conn); // 접속종료
    }else{
        ?>
        <div class="menuname row col-12 col-md-8 textlist">
            게시물을 찾을수 없습니다.
        </div>
        <?php
    }
    ?>
        <br />
        <div class="box_ul">
            <ul class="box_li">

                <?php
            if($pageNum == 1){ // 이전페이지 번호
                $backPage = 1;
            }else{
                $backPage = $pageNum - 1;
            }

            if($pageNum == $maxPage){ // 이후 페이지 번호
                $frontPage = $maxPage;
            }else{
                $frontPage = $pageNum + 1;
            }
            ?>

                <li class="paging"><a href="list.php?<?php echo $urlQuery."page=".$backPage; ?>">이전</a></li>
                <?php
            for ($i = 1 ; $i <= $maxPage ; $i++) { // 1부터 max 페이지까지 li 생성

                ?>
                <li class="paging"><a
                        <?php if($pageNum===$i) {echo 'class = "bg-secondary text-white"' ; } // 현재페이지일 경우 a에 active 클래스를줌 ?>
                        href="list.php?<?php echo $urlQuery."page=".$i; ?>"><?php echo $i; ?></a></li>
                <?php
            }
            ?>
                <li class="paging"><a href="list.php?<?php echo $urlQuery."page=".$frontPage; ?>">다음</a></li>
            </ul>
        </div>
        <div class="btn-box col-12 col-md-8">
            <button type="button" class="btn btn-outline-secondary"
                onclick="location.href = './postwrite.php'">글쓰기</button>
        </div>

        <form action="./list.php">
            <div class="searchbox col-12 col-md-8 col-lg-6 row">
                <!--검색 박스-->
                <div class="col-4 col-md-3">
                    <!--검색 종류 선택-->
                    <select class="form-select form-control" name="type">
                        <option value="1" <?php echo $type==1 ? "selected" : "";?>>제목,내용</option>
                        <option value="2" <?php echo $type==2 ? "selected" : "";?>>작성자</option>
                        <option value="3" <?php echo $type==3 ? "selected" : "";?>>글번호</option>
                    </select>
                </div>
                <div class="col-5 col-md-7">
                    <input type="text" name="text" class="form-control" placeholder="검색어를 입력하세요."
                        value="<?php echo $text; ?>" required>
                </div>
                <div class="col-3 col-md-2">
                    <button class="btn btn-outline-secondary col-12 col-md-8" type="submit">검색</button>
                </div>

            </div>
        </form>


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

</html>