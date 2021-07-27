<?php
try {
    session_start();
    require("./dbconnect.php");
    require("./CCommon.php");

    // トップページ各種情報読み込み
    $tops = $db->prepare("SELECT * FROM top_page WHERE id=(SELECT MAX(id) FROM top_page)");
    $tops->execute();
    $top = $tops->fetch(PDO::FETCH_ASSOC);

    // インフォメーションの読み込み
    $infos = $db->prepare("SELECT * FROM top_info ORDER BY id DESC");
    $infos->execute();

    // 猫ちゃん読み込み
    $cats = $db->prepare("SELECT * FROM cats ORDER BY id DESC");
    $cats->execute();
} catch (Exception $e) {
    echo "エラー：" . $e;
}
?>



<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css?ver=0.6">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>ポートフォリオ</title>
</head>

<body>
    <header id="scroll-top">
        <!-- 会社名 -->
        <nav class="nav-pc">
            <div class="row">
                <div class="col-xl-4 col-sm-4 header__contents header__contents-1"><a class="header header__company-name" href="./">ポートフォリオ</a></div>
                <div class="col-xl-2 col-sm-2 header__contents header__contents-2">
                    <a class="header header__menu header__menu-1" href="./">
                        <div class="header__menu-1-1">HOME</div>
                        <div class="header__menu-1-2">ホーム</div>
                    </a>
                </div>
                <div class="col-xl-2 col-sm-2 header__contents header__contents-2">
                    <a class="header header__menu header__menu-1" href="#scroll-3">
                        <div class="header__menu-2-1">CAT</div>
                        <div class="header__menu-2-2">猫たちの紹介</div>
                    </a>
                </div>
                <div class="col-xl-2 col-sm-2 header__contents header__contents-2">
                    <a class="header header__menu header__menu-1" href="#scroll-5">
                        <div class="header__menu-3-1">MENU</div>
                        <div class="header__menu-3-2">メニュー</div>
                    </a>
                </div>
                <div class="col-xl-2 col-sm-2 header__contents header__contents-2">
                    <a href="#scroll-6" class="header header__menu header__menu-1">
                        <div class="header__menu-4-1">ACCESS</div>
                        <div class="header__menu-4-2">アクセス</div>
                    </a>
                </div>
            </div>
        </nav>

        <nav class="navbar navbar-expand-lg navbar-light nav-mobile">
            <div class="toggle">
                <a class="navbar-brand" href="#scroll-1">
                    <div class="nav__logo-area_sp">
                        <div class="nav__logo-name"><span class="nav__logo-name_bold">ポートフォリオ</span></div>
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
                            <a class="nav-link" href="#scroll-top">ホーム</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#scroll-3">猫たちの紹介</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#scroll-5">メニュー</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#scroll-6">アクセス</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <!-- 編集画面ボタン@TODO 一時的 -->
        <div class="button__edit">
            <a class="button__edit--a" href="./editer/index.php">編集画面<br>（一時的）</a>
        </div>
        <!-- /編集画面ボタン@TODO 一時的 -->


        <!-- wrapper-1 -->
        <div class="wrapper wrapper-1 wrapper-1__top" id="scroll-1">
            <h1 class="wrapper-1__catch-copy"><?php echo h($top["catch_copy"]); ?></h1>
        </div>
        <!-- /wrapper-1 -->

        <!-- wrapper-2 -->
        <div class="wrapper wrapper-2">
            <div class="inner inner-2">
                <h2 class="wrapper__h2">インフォメーション</h2>
                <div class="info-area">
                    <?php foreach ($infos as $info) : ?>
                        <div class="info info-<?php h($info["id"]); ?>">
                            <div class="info-data date date-<?php echo h($info["id"]); ?>"><?php echo h($info["year"]) . "/" . h($info["month"]) . "/" . h($info["day"]); ?></div>
                            <div class="info-data sentence sentence-<?php echo h($info["id"]); ?>"><?php echo h($info["info"]); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!-- /wrapper-2 -->

        <!-- wrapper-3 -->
        <div class="wrapper wrapper-3" id="scroll-3">
            <div class="inner inner-3">
                <h2 class="wrapper__h2">猫たちの紹介</h2>
                <div class="images-area images-area-1">
                    <?php $i = 1; ?>
                    <?php foreach ($cats as $cat) : ?>
                        <div class="image-area image-area-<?php echo h($i); ?>">
                            <a class="cat" href="./">
                                <img class="image" src=<?php echo h($cat["image"]) ?> alt=<?php echo h($cat["name"]); ?>>
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
        <!-- /wrapper-3 -->

        <!-- wrapper-5 -->
        <div class="wrapper wrapper-5" id="scroll-5">
            <div class="inner inner-5">
                <div class="menu">
                    <h2 class="wrapper__h2">メニュー</h2>
                    <div class="inner__menu">
                        <div class="item_menu item_menu-1">
                            <div class="name__menu">コーヒー</div>
                            <div class="price__menu">￥400</div>
                        </div>
                        <div class="item_menu item_menu-2">
                            <div class="name__menu">紅茶</div>
                            <div class="price__menu">￥400</div>
                        </div>
                        <div class="item_menu item_menu-3">
                            <div class="name__menu">オレンジジュース</div>
                            <div class="price__menu">￥400</div>
                        </div>
                        <div class="item_menu item_menu-4">
                            <div class="name__menu">ねこのミルク</div>
                            <div class="price__menu">￥100</div>
                        </div>
                        <div class="item_menu item_menu-5">
                            <div class="name__menu">ねこのえさ</div>
                            <div class="price__menu">￥100</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /wrapper-5 -->

        <!-- wrapper-6 -->
        <div class="wrapper wrapper-6" id="scroll-6">
            <div class="inner inner-6">
                <h2 class="wrapper__h2">アクセス</h2>
                <div class="access-area">
                    <div class="access access-1">
                        <div class="access-item access-address address">場所</div>
                        <div class="access-address sentence sentence-address"><?php echo h($top["address"]); ?></div>
                    </div>
                    <div class="access access-2">
                        <div class="access-item access-tel tel">TEL</div>
                        <div class="access-tel sentence sentence-tel"><?php echo h($top["tel"]); ?></div>
                    </div>
                    <div class="access access-3">
                        <div class="access-item access-time time">営業時間</div>
                        <div class="access-time sentence sentence-time"><?php echo h($top["time"]); ?></div>
                    </div>
                    <div class="access access-4">
                        <div class="access-item access-holiday holiday">定休日</div>
                        <div class="access-holiday sentence sentence-holiday"><?php echo h($top["holiday"]); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /wrapper-6 -->


        <div>
            <?php //foreach ($cats as $cat) : 
            ?>
            <!-- <div class="image-area image-area-7">
                    <a class="cat" href="./"><img class="image" src="<?php $cat["image"]; ?>" alt="">
                        <div class="intro intro-1">
                            <p class="no-margin"><?php $cat["name"] ?></p>
                            <p class="no-margin">オス　4才</p>
                        </div>
                    </a>
                </div> -->


            <?php //endforeach; 
            ?>
        </div>
    </main>

    <footer>

    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        $(function() {
            $('a[href^="#"]').click(function() {
                let speed = 1000;
                let href = $(this).attr("href");
                let target = $(href == "#" || href == "" ? 'html' : href);
                let position = target.offset().top;
                $("html, body").animate({
                    scrollTop: position
                }, speed, "swing");
                return false;
            });
        });
    </script>
</body>

</html>