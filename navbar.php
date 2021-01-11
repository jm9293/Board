<?php
/**
 * Created by PhpStorm.
 * User: Jungmin
 * Date: 2021-01-06
 * Time: 오전 11:32
 */



?>


<nav class="navbar navbar-expand-md navbar-light bg-white navbar-u col-12 col-md-8">
    <a class="navbar-brand navbar-logo text-secondary" href="./list.php">Board</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="./list.php" role="button" aria-haspopup="true" aria-expanded="false">
                    게시판
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./postwrite.php" role="button" aria-haspopup="true" aria-expanded="false">
                    글쓰기
                </a>
            </li>
            <?php
                if(isset($_SESSION["admin"])){ // 관리자 로그인시
            ?>
            <li class="nav-item">
                <button class="btn btn-outline-secondary" type="button" onclick="" data-toggle="modal"
                    data-target="#logoutmodal">
                    <?php echo $_SESSION["admin"] // 관리자 ID 출력?>
                </button>
            </li>
            <?php
                }else {
                    ?>
            <li class="nav-item">
                <button class="btn btn-outline-secondary" type="button" onclick="" data-toggle="modal"
                    data-target="#loginmodal">관리자
                </button>
            </li>
            <?php
                }
            ?>



        </ul>
    </div>
</nav>

<?php
if(isset($_SESSION["admin"])){ // 관리자 로그인시
?>
<!-- 관리자 로그아웃 모달창 -->
<div class="modal fade" id="logoutmodal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delModalLabel">로그아웃</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="./adminlogout.php" method="post">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                    <button type="submit" class="btn btn-danger">로그아웃</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
}else{
?>
<!-- 관리자 로그인 모달창 -->
<div class="modal fade" id="loginmodal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delModalLabel">관리자 로그인</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="./adminlogin.php" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="username" class="form-label">아이디</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="아이디를 입력하세요."
                            maxlength="10" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">비밀번호</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="비밀번호를 입력하세요." maxlength="10" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                    <button type="submit" class="btn btn-primary">로그인</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
}
?>