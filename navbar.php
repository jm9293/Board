<?php
/**
 * Created by PhpStorm.
 * User: Jungmin
 * Date: 2021-01-06
 * Time: 오전 11:32
 */
?>

<nav class="navbar navbar-expand-md navbar-light bg-white navbar-u col-12 col-md-8">
    <a class="navbar-brand navbar-logo" href="./list.php">Board</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="./list.php"  role="button"  aria-haspopup="true" aria-expanded="false">
                    게시판
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./postwrite.php"  role="button"  aria-haspopup="true" aria-expanded="false">
                    글쓰기
                </a>
            </li>
            <li class="nav-item">
                <button class="btn btn-outline-primary" type="button" onclick="" data-toggle="modal" data-target="#loginmodal">관리자</button>
            </li>
        </ul>
    </div>
</nav>

