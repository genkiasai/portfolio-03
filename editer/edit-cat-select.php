<?php
try {
    session_start();
    require("../dbconnect.php");
    require("../CCommon.php");

    // 猫ちゃん読み込み
    $cats = $db->prepare("SELECT * FROM cats ORDER BY id DESC");
    $cats->execute();
} catch (Exception $e) {
    echo "エラー：" . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.1">
    <link rel="stylesheet" href="./style.css?ver=1.6">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>@TODO</title>

    <!-- https://github.com/yuki-yoshida-z/demoes/blob/master/trimming.html参照 -->
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> -->
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0, user-scalable=no"> -->
    <meta http-equiv="Content-Style-Type" content="text/css">
    <meta http-equiv="Content-Script-Type" content="text/javascript">
    <!-- <link rel="stylesheet" href="css/base/reset.css" type="text/css">
    <link rel="stylesheet" href="css/base/layout.css" type="text/css"> -->
    <link rel="stylesheet" href="css/vendor/cropper.css" type="text/css">
    <!-- <link rel="stylesheet" href="css/vendor/bootstrap.min.css" type="text/css"> -->
    <!-- <link rel="stylesheet" href="css/page/trimming.css" type="text/css"> -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>


</head>

<body>
    <header id="scroll-top">
        <nav class="nav-pc">
            <div class="row">
                <div class="col-xl-4 col-sm-4 header__contents header__contents-1"><a class="header header__company-name" href="./">編集画面</a></div>
                <div class="col-xl-2 col-sm-2 header__contents header__contents-2">
                    <a class="header header__menu header__menu-1" href="./record-cat.php">
                        <div class="header__menu-1-1">RECORD</div>
                        <div class="header__menu-1-2">猫ちゃん登録</div>
                    </a>
                </div>
                <div class="col-xl-2 col-sm-2 header__contents header__contents-2">
                    <a class="header header__menu header__menu-1" href="./edit-cat-select.php">
                        <div class="header__menu-2-1">EDIT</div>
                        <div class="header__menu-2-2">猫ちゃん編集</div>
                    </a>
                </div>
                <div class="col-xl-2 col-sm-2 header__contents header__contents-2">
                    <a class="header header__menu header__menu-1" href="#scroll-5">
                        <div class="header__menu-3-1">WORK</div>
                        <div class="header__menu-3-2">出勤ステータス</div>
                    </a>
                </div>
                <div class="col-xl-2 col-sm-2 header__contents header__contents-2">
                    <a href="./edit-top.php" class="header header__menu header__menu-1">
                        <div class="header__menu-4-1">TOP-PAGE</div>
                        <div class="header__menu-4-2">トップページ編集</div>
                    </a>
                </div>
            </div>
        </nav>

        <nav class="navbar navbar-expand-lg navbar-light nav-mobile">
            <div class="toggle">
                <a class="navbar-brand" href="#scroll-1">
                    <div class="nav__logo-area_sp">
                        <!-- <div class="nav__logo-item col-4 px-0"><img src="./images/logo.webp" alt="ロゴ"></div> -->
                        <div class="nav__logo-name"><span class="nav__logo-name_bold">編集画面</span></div>
                    </div>
                </a>
                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="menu-list">
                <div class="navbar-collapse collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="./record-cat.php">猫ちゃん登録</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./edit-cat-select.php">猫ちゃん編集</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#scroll-5">出勤ステータス</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./edit-top.php">トップページ編集</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="main__top-page">
        <h1 class="edit__h1">猫ちゃん編集画面</h1>
        <form action="" method="POST">
            <div class="wrapper wrapper-1">
                <div class="inner">
                    <?php $i = 1; ?>
                    <div class="images-area images-area-1">
                        <?php foreach ($cats as $cat) : ?>
                            <div class="image-area image-area-<?php echo h($i); ?>">
                                <a class="cat" href="./edit-cat.php?id=<?php echo $cat["id"]; ?>">
                                    <img class="image" src=<?php echo "." . h($cat["image"]) ?> alt=<?php echo h($cat["name"]); ?>>
                                    <div class="intro intro-<?php echo h($i); ?>">
                                        <p class="no-margin"><?php echo h($cat["name"]); ?></p>
                                        <p class="no-margin"><?php echo h($cat["gender"]) . "　" . h(dateDiff($cat["birthday"])); ?></p>
                                    </div>
                                </a>
                            </div>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <!-- bootstrap ver5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- https://github.com/yuki-yoshida-z/demoes/blob/master/trimming.html参照 -->
    <script src="js/vendor/cropper.js"></script>
    <script src="js/page/trimming.js?ver=0.1"></script>
</body>

</html>