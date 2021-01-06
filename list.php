<?php
/**
 * Created by PhpStorm.
 * User: Jungmin
 * Date: 2021-01-05
 * Time: 오전 11:15
 */

$conn = mysqli_connect("localhost" , "boardadmin", "board1234", "board", "3306"); // DB 커넥션

$pageRow = 10; // 한페이지에가 가져올 게시글 개수

if(isset($_GET["page"])){ //파라메타가 있을시
    $pageNum = (int)$_GET["page"];
}else{
    $pageNum = 1;
}

if($pageNum == 0){ // 숫자가 아닌 파라메타일 경우
    echo "파라메타 오류";
    exit();
}

$query = "SELECT count(*) FROM POST"; // 게시글 개수 확인 쿼리

$result = mysqli_query($conn, $query); // 쿼리전송후 결과받음


if ( $result ) { // 결과 존재시
    $postCnt = mysqli_fetch_assoc($result)['count(*)']; // 전체게시글수
    mysqli_free_result($result); // 결과 해제
} else { // 미존재시 종료
    echo "Error : DB오류";
    exit();
}

$query = "SELECT NUM, USERNAME, TITLE, VIEWCOUNT, WRDATE FROM POST
          ORDER BY NUM DESC
          LIMIT ".($pageNum-1)*$pageRow.", $pageRow"; // 페이징을 이용한 select 쿼리문

$result = mysqli_query($conn, $query); // 쿼리전송후 결과받음

$maxPage = ceil($postCnt / $pageRow);


?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- bootstrap 4.3.1 css요소 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"crossorigin="anonymous">
    <!-- 기본 폰트 구글 Noto Sans 굵기 400,500,900 -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;500;900&display=swap" rel="stylesheet">
    <!-- 기본 css -->
    <!--jquery 3.3.1 불러오기-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- 페이지 css -->
    <style>
        .searchbox{
            margin:auto;
        }
        .searchbox div{
            padding:0;
        }
        .menuname{
            margin: auto;
            padding:0;
        }
        .content{
            margin-top: 5%;
        }
        .menu{
            text-align: center;
            height: 45px;
            line-height: 45px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            border: 1px solid white;
        }
        .text{
            box-sizing: border-box;
            text-align: center;
            font-size: 15px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            height: 50px;
            line-height: 50px;
        }
        #text1{
            border-right: 1px dotted rgb(190, 189, 189);
            border-bottom: 1px dotted rgb(190, 189, 189);
        }
        #text2{
            border-right: 1px dotted rgb(190, 189, 189);
            border-bottom: 1px dotted rgb(190, 189, 189);
        }
        #text3{
            border-bottom: 1px dotted rgb(190, 189, 189);
        }
        #text4{
            border-right: 1px dotted rgb(190, 189, 189);
        }
        #text5{
            border-right: 1px dotted rgb(190, 189, 189);
        }
        .menuborder{
            border-radius: 5px 5px 0px 0px;
            padding: 0;
        }
        h2{
            font-weight: bold;
        }
        .head{
            margin: auto;
        }
        .textlist{
            border-bottom: 1px solid rgb(158, 156, 156);
        }
        .textlist:hover{
            background: rgb(190, 189, 189);
            opacity: 0.9;
        }
        .box_ul{
            text-align: center;
            margin: auto;
        }
        .box_li{
            list-style-type:none
        }
        .paging{
            display: inline-block;
        }
        .paging a{
            color: black;
            float: left;
            padding: 4px 8px;
            text-decoration: none;
            transition: background-color .3s;
            margin: 0px;
        }
        .paging a.active{
            border-radius: 30%;
            background-color: rgb(52, 152, 219);
            color: white;
            border: 1px solid rgb(52, 152, 219);
        }
        .paging a:hover:not(.active) {background-color: #ddd;}
        #write{
            text-align: center;
            margin-top:10px;
            margin-left:35%;
        }
        @media (min-width: 767px) {
            #write {
                margin: 0;
                position: absolute;
                top: 9px;
                left: 83%;
            }
            #text1{
                border: 0;
            }
            #text2{
                border: 0;
            }
            #text3{
                border: 0;
            }
            #text4{
                border: 0;
            }
            #text5{
                border: 0;
            }
            .searchbox div{
                padding:10px;
            }
            #mybtn {
                margin: 0;
                position: absolute;
                top:10px;
                left:81%;
            }}
    </style>
    <link rel="stylesheet" href="sup_Qna.css">
    <title>게시판</title>
</head>
<body>
<!--네비바 시작-->
<div id="navbar">

</div>

<!--네비바 끝-->

<!--메인 컨텐트 영역-->
<div class="content">
    <div class="col-12 col-md-8 head row">
        <h2 class="col-12">게시판</h2>
        <!-- 게시글 개수 출력 -->
        총 <?php echo $postCnt ?>개의 게시글이 있습니다.

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
            <div class="menuname textarea row col-12 col-md-8 textlist" onclick="location.href=''">
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
    }
    ?>
    <br>
    <div class="box_ul">
        <ul class="box_li">

            <?php
            if($pageNum == 1){ // 이전페이지 번호
                $backPage = 1;
            }else{
                $backPage = $pageNum-1;
            }

            if($pageNum == $maxPage){
                $frontPage = $maxPage;
            }else{
                $frontPage = $pageNum+1;
            }
            ?>

            <li class="paging"><a
                    href="list.php?page=<?php echo $backPage; ?>">이전</a></li>
            <?php
            for ($i = 1 ; $i <= $maxPage ; $i++) { // 1부터 max 페이지까지 li 생성

                ?>
                <li class="paging"><a
                        href="list.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php
            }
            ?>
            <li class="paging"><a
                    href="list.php?page=<?php echo $frontPage; ?>">다음</a></li>
        </ul>
    </div>


</div>


<!--메인 컨텐트 끝-->

<!--푸터 시작-->
<div id="footer-wrap"></div>
<script>
    $("#footer-wrap").load("../basic/footer.html");
</script>
<!--푸터 끝-->
<!--js 불러오기-->
<!--bootstrap js요소 4.3.1 불러오기-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>

