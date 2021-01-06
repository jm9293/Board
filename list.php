<?php
/**
 * Created by PhpStorm.
 * User: Jungmin
 * Date: 2021-01-05
 * Time: 오전 11:15
 */

$conn = mysqli_connect("localhost" , "boardadmin", "board1234", "board", "3306"); // DB 커넥션

if(!$conn){ // 커넥션 오류시
    // 오류방지를 위한 기본변수 선언
    $infotext =  "Error : DB 연결 오류</br>";
    $postCnt = 0;
    $pageNum = 0;
    $maxPage  = 0;
    $result = false;
    $type = 1;
    $text = "";
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

    if(isset($_GET["type"])&&isset($_GET["text"])&&((int)isset($_GET["type"]))!=0){

        $infotext = '"'.$_GET["text"].'"로 검색한 결과입니다.</br>';
        $type = (int)$_GET["type"];
        $text = $_GET["text"];

        switch ($type){
            case 1 :
                $whereQuery =" WHERE TITLE LIKE '%".$text."%' OR CONTENT LIKE '%".$text."%'";

                break;
            case 2 :
                $whereQuery =" WHERE USERNAME LIKE '%".$text."%'";
                break;
            case 3 :
                $whereQuery =" WHERE NUM =".$text;
                break;

        }
    }


    if($pageNum == 0){ // 숫자가 아닌 파라메타일 경우
        echo "파라메타 오류";
        exit();
    }

    $query = "SELECT count(*) FROM POST".$whereQuery; // 게시글 개수 확인 쿼리

    echo $query; // 쿼리문 테스트

    $result = mysqli_query($conn, $query); // 쿼리전송후 결과받음

    $postCnt = 0;

    if ( $result ) { // 결과 존재시
        $postCnt = mysqli_fetch_assoc($result)['count(*)']; // 전체게시글수

        mysqli_free_result($result); // 결과 메모리 해제

        $query = "SELECT NUM, USERNAME, TITLE, VIEWCOUNT, WRDATE FROM POST".$whereQuery.
            " ORDER BY NUM DESC LIMIT ".($pageNum-1)*$pageRow.", $pageRow"; // 페이징을 이용한 select 쿼리문

        echo $query; // 쿼리문 테스트

        $result = mysqli_query($conn, $query); // 쿼리전송후 결과받음

        $maxPage = ceil($postCnt / $pageRow); // 전체 게시글수를 보여줄 ROW수로 나눈뒤 무조건 올림

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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- 기본 폰트 구글 Noto Sans 굵기 400,500,900 -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;500;900&display=swap" rel="stylesheet">
    <!-- 기본 css -->
    <!--jquery 3.3.1 불러오기-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- 기본 css-->
    <link href="./css/basic.css" rel="stylesheet">
    <!-- 페이지 css -->
    <link href="./css/list.css" rel="stylesheet">
    <style>

    </style>

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
    <div class="menuname menuborder row col-12 col-md-8 alert-primary">
        <div class="col-2 col-md-1 menu">No</div>
        <div class="col-6 col-md-4 menu">제목</div>
        <div class="col-4 col-md-2 menu">작성자</div>
        <div class="col-2 col-md-2 menu">조회</div>
        <div class="col-10 col-md-3 menu">작성일</div>
    </div>
    <?php
    if($result) {
        while ($row = mysqli_fetch_assoc($result)) { //전체 select 된 row 만큼 반복한다.

            ?>
            <div class="menuname textarea row col-12 col-md-8 textlist" onclick="location.href='./postview.php?num=<?php echo $row["NUM"] ?>'">
                <div class="col-2 col-md-1 text" id="text1"><?php echo $row["NUM"] ?></div>
                <div class="col-6 col-md-4 text" id="text2"><?php echo $row["TITLE"] ?></div>
                <div class="col-4 col-md-2 text" id="text2"><?php echo $row["USERNAME"] ?></div>
                <div class="col-2 col-md-2 text" id="text3"><?php echo $row["VIEWCOUNT"] ?></div>
                <div class="col-10 col-md-3 text" id="text4"><?php echo $row["WRDATE"] ?></div>
            </div>
            <?php
        }

        mysqli_free_result($result); // 결과 해제
        mysqli_close($conn); // 접속종료
    }else{
        ?>
        <div class="menuname textarea row col-12 col-md-8 textlist">
            게시글을 찾을수 없거나 DB접속 오류입니다. 다시 시도해주세요.
        </div>
    <?php
    }
    ?>
    <br>
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

            <li class="paging"><a
                    href="list.php?page=<?php echo $backPage; ?>">이전</a></li>
            <?php
            for ($i = 1 ; $i <= $maxPage ; $i++) { // 1부터 max 페이지까지 li 생성

                ?>
                <li class="paging"><a <?php if($pageNum===$i) {echo 'class = "active"' ; } // 현재페이지일 경우 a에 active 클래스를줌 ?>
                        href="list.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php
            }
            ?>
            <li class="paging"><a
                    href="list.php?page=<?php echo $frontPage; ?>">다음</a></li>
        </ul>
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
            <input type="text"  name="text" class="form-control" placeholder="검색어를 입력하세요." value="<?php echo $text; ?>" required>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</html>

