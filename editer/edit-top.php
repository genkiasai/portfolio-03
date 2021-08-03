<?php
try {
    session_start();
    require("../dbconnect.php");
    require("../CCommon.php");

    // 入力確認
    if (isset($_POST["save"])) {
        $post = inputCheck($_POST);
    }

    // データベース書き込み（インフォメーション以外）
    if (!isset($post["error"]) && isset($_POST["save"])) {
        $write = $db->prepare("INSERT INTO top_page SET catch_copy=?, message_1=?, message_2=?, message_3=?, address=?, tel=?, time=?, holiday=?");
        $write->execute(array(
            $post["catch_copy"],
            $post["message_1"],
            $post["message_2"],
            $post["message_3"],
            $post["address"],
            $post["tel"],
            $post["time"],
            $post["holiday"]
        ));
    }

    // データベース書き込み（インフォメーション）
    if (!isset($post["error_info"]) && isset($_POST["save"])) {
        $write = $db->prepare("INSERT INTO top_info SET year=?, month=?, day=?, info=?");
        $write->execute(array(
            $post["year"],
            $post["month"],
            $post["day"],
            $post["info"]
        ));
    }

    // 削除ボタン押下時
    if (isset($_GET["delete"])) {
        $delete = $db->prepare("DELETE FROM top_info WHERE id=?");
        $delete->execute(array(
            $_GET["delete"]
        ));
    }

    // データベース読み込み（インフォメーション以外）
    $exports = $db->prepare("SELECT * FROM top_page WHERE id=(SELECT MAX(id) FROM top_page)");
    $exports->execute();
    $export = $exports->fetch(PDO::FETCH_ASSOC);
    $export_infos = $db->prepare("SELECT * FROM top_info ORDER BY id DESC");
    $export_infos->execute();
    $export_info = $export_infos->fetch(PDO::FETCH_ASSOC);

    // データベース読み込み（インフォメーション）
    $infos = $db->prepare("SELECT * FROM top_info ORDER BY id DESC");
    $infos->execute();
} catch (Exception $e) {
    echo "エラー：" . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css?ver=1.4">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>ねこCafe</title>
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
                        <div class="header__menu-2-1">CAT-EDIT</div>
                        <div class="header__menu-2-2">猫ちゃん編集</div>
                    </a>
                </div>
                <div class="col-xl-2 col-sm-2 header__contents header__contents-2">
                    <a href="./edit-top.php" class="header header__menu header__menu-1">
                        <div class="header__menu-3-1">TOP-EDIT</div>
                        <div class="header__menu-3-2">トップページ編集</div>
                    </a>
                </div>
                <div class="col-xl-2 col-sm-2 header__contents header__contents-2">
                    <a href="../" class="header header__menu header__menu-1">
                        <div class="header__menu-4-1">TOP-PAGE</div>
                        <div class="header__menu-4-2">トップページ</div>
                    </a>
                </div>
            </div>
        </nav>

        <nav class="navbar navbar-expand-lg navbar-light nav-mobile">
            <div class="toggle">
                <a class="navbar-brand" href="./">
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
                            <a class="nav-link" href="#scroll-3">猫ちゃん編集</a>
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
        <h1 class="edit__h1">トップページ編集画面</h1>
        <form action="" method="POST">
            <div class="wrapper wrapper-1">
                <div class="inner inner-1">
                    <h2 class="wrapper__h2">キャッチコピー</h2>
                    <?php if (!empty($post["error"]["catch_copy"]) && $post["error"]["catch_copy"] === "none") echo "<div class='error' style='color:red;'>入力してください</div>"; ?>
                    <input class="text text__catch-copy" id="catch_copy" type="text" name="catch_copy" placeholder="キャッチコピー" value=<?php echo h($export["catch_copy"]); ?>>
                </div>
            </div>

            <div class="wrapper wrapper-2">
                <div class="inner inner-2">
                    <h2 class="wrapper__h2">インフォメーション</h2>
                    <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4)) echo "<div class='error' style='color:red;'>入力漏れがありました。</div>"; ?>
                    <div class="info-area-1">
                        <div class="info-area-1-1">
                            <div class="info__date">
                                <select name="year" id="info__date-year">
                                    <option value="" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["year"] === "") echo "selected"; ?>></option>
                                    <option value="2021" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["year"] === "2021") echo "selected"; ?>>2021</option>
                                </select>
                                年
                                <select name="month" id="info__date-month">
                                    <option value="" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["month"] === "") echo "selected"; ?>></option>
                                    <option value="1" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["month"] === "1") echo "selected"; ?>>1</option>
                                    <option value="2" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["month"] === "2") echo "selected"; ?>>2</option>
                                    <option value="3" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["month"] === "3") echo "selected"; ?>>3</option>
                                    <option value="4" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["month"] === "4") echo "selected"; ?>>4</option>
                                    <option value="5" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["month"] === "5") echo "selected"; ?>>5</option>
                                    <option value="6" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["month"] === "6") echo "selected"; ?>>6</option>
                                    <option value="7" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["month"] === "7") echo "selected"; ?>>7</option>
                                    <option value="8" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["month"] === "8") echo "selected"; ?>>8</option>
                                    <option value="9" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["month"] === "9") echo "selected"; ?>>9</option>
                                    <option value="10" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["month"] === "10") echo "selected"; ?>>10</option>
                                    <option value="11" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["month"] === "11") echo "selected"; ?>>11</option>
                                    <option value="12" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["month"] === "12") echo "selected"; ?>>12</option>
                                </select>
                                月
                                <select name="day" id="info__date-day">
                                    <option value="" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "") echo "selected"; ?>></option>
                                    <option value="1" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "1") echo "selected"; ?>>1</option>
                                    <option value="2" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "2") echo "selected"; ?>>2</option>
                                    <option value="3" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "3") echo "selected"; ?>>3</option>
                                    <option value="4" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "4") echo "selected"; ?>>4</option>
                                    <option value="5" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "5") echo "selected"; ?>>5</option>
                                    <option value="6" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "6") echo "selected"; ?>>6</option>
                                    <option value="7" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "7") echo "selected"; ?>>7</option>
                                    <option value="8" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "8") echo "selected"; ?>>8</option>
                                    <option value="9" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "9") echo "selected"; ?>>9</option>
                                    <option value="10" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "10") echo "selected"; ?>>10</option>
                                    <option value="11" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "11") echo "selected"; ?>>11</option>
                                    <option value="12" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "12") echo "selected"; ?>>12</option>
                                    <option value="13" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "13") echo "selected"; ?>>13</option>
                                    <option value="14" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "14") echo "selected"; ?>>14</option>
                                    <option value="15" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "15") echo "selected"; ?>>15</option>
                                    <option value="16" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "16") echo "selected"; ?>>16</option>
                                    <option value="17" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "17") echo "selected"; ?>>17</option>
                                    <option value="18" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "18") echo "selected"; ?>>18</option>
                                    <option value="19" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "19") echo "selected"; ?>>19</option>
                                    <option value="20" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "20") echo "selected"; ?>>20</option>
                                    <option value="21" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "21") echo "selected"; ?>>21</option>
                                    <option value="22" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "22") echo "selected"; ?>>22</option>
                                    <option value="23" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "23") echo "selected"; ?>>23</option>
                                    <option value="24" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "24") echo "selected"; ?>>24</option>
                                    <option value="25" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "25") echo "selected"; ?>>25</option>
                                    <option value="26" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "26") echo "selected"; ?>>26</option>
                                    <option value="27" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "27") echo "selected"; ?>>27</option>
                                    <option value="28" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "28") echo "selected"; ?>>28</option>
                                    <option value="29" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "29") echo "selected"; ?>>29</option>
                                    <option value="30" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "30") echo "selected"; ?>>30</option>
                                    <option value="31" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["day"] === "31") echo "selected"; ?>>31</option>
                                </select>
                                日
                            </div>
                        </div>
                        <div class="info-area-1-2">
                            <input class="text text__info" id="text__info" type="text" name="info" placeholder="インフォメーション" <?php if (isset($post["error_info"]) && (count($post["error_info"]) < 4) && $post["info"] !== "") echo "value=" . h($post["info"]); ?>>
                        </div>
                    </div>
                    <div class="info-area-2">
                        <div class="info-inner">
                            <?php foreach ($infos as $info) : ?>
                                <div class="now-info info-<?php echo $info["id"]; ?>">
                                    <div class="info-data date date-<?php echo $info["id"]; ?>"><?php echo $info["year"] . "/" . $info["month"] . "/" . $info["day"]; ?></div>
                                    <div class="info-data sentence-button">
                                        <div class="sentence sentence-<?php echo $info["id"]; ?>"><?php echo h($info["info"]); ?></div>
                                        <a href="./edit-top.php?delete=<?php echo $info["id"]; ?>">削除</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wrapper wrapper-3">
                <div class="inner inner-3">
                    <h2 class="wrapper__h2">アクセス</h2>
                    <?php if (!empty($post["error"]["address"]) && $post["error"]["address"] === "none") echo "<div class='error' style='color:red;'>入力してください</div>"; ?>
                    <div class="accsess__item">
                        <div class="access__item-name">住所</div>
                        <input class="text text__access text__access_address" id="text__access_address" name="address" type="text" value="<?php echo h($export["address"]); ?>">
                    </div>
                    <?php if (!empty($post["error"]["tel"]) && $post["error"]["tel"] === "none") echo "<div class='error' style='color:red;'>入力してください</div>"; ?>
                    <div class="accsess__item">
                        <div class="access__item-name">TEL</div>
                        <input class="text text__access text__access_tel" id="text__access_tel" name="tel" type="text" value="<?php echo h($export["tel"]); ?>">
                    </div>
                    <?php if (!empty($post["error"]["time"]) && $post["error"]["time"] === "none") echo "<div class='error' style='color:red;'>入力してください</div>"; ?>
                    <div class="accsess__item">
                        <div class="access__item-name">営業時間</div>
                        <input class="text text__access text__access_time" id="text__access_time" name="time" type="text" value="<?php echo h($export["time"]); ?>">
                    </div>
                    <?php if (!empty($post["error"]["holiday"]) && $post["error"]["holiday"] === "none") echo "<div class='error' style='color:red;'>入力してください</div>"; ?>
                    <div class="accsess__item">
                        <div class="access__item-name">定休日</div>
                        <input class="text text__access text__access_holiday" id="text__access_holiday" name="holiday" type="text" value="<?php echo h($export["holiday"]); ?>">
                    </div>
                </div>
            </div>

            <div class="save-area">
                <div class="save-message">
                    編集が終了したら→
                </div>
                <input class="submit__save" id="submit__save" name="save" type="submit" value="保存">
            </div>
        </form>
    </main>




    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>