<?php
try {
    session_start();
    require("../dbconnect.php");
    require("../CCommon.php");

    // 入力確認
    if (isset($_POST["save"])) {
        $post = inputCheck($_POST);
    }

    // データベース書き込み
    if (!isset($post["error_cat"]) && isset($_POST["save"])) {
        // 保存するファイル名をidから取得
        $id = $db->prepare("SELECT COUNT(id) FROM cats");
        $id->execute();
        (string)$file_name = $id->fetch(PDO::FETCH_ASSOC);
        if (strlen($file_name["COUNT(id)"]) === 1) {
            $file_name = "000" . $file_name["COUNT(id)"];
        } elseif(strlen($file_name["COUNT(id)"]) === 2) {
            $file_name = "00" . $file_name["COUNT(id)"];
        } elseif(strlen($file_name["COUNT(id)"]) === 3) {
            $file_name = "0" . $file_name["COUNT(id)"];
        }
        
        // データベース書き込み
        $post["image"] = "./cats/" . $file_name . ".jpg";
        $write = $db->prepare("INSERT INTO cats SET name=?, gender=?, birthday=?, image=?");
        $write->execute(array(
            $post["name"],
            $post["gender"],
            $post["birthday"],
            $post["image"]
        ));

        // base64の画像データを保存
        $img = $_POST["save_image"];
        $img = str_replace("", "", $img);
        $img = str_replace(" ", "+", $img);
        $save_image = base64_decode($img);
        file_put_contents("../cats/" . $file_name . ".jpg", $save_image);
        // move_uploaded_file($_POST["save_image"], "../cats/" . $file_name . ".jpg");

    }
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
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
    <title>@TODO</title>

    <!-- https://github.com/yuki-yoshida-z/demoes/blob/master/trimming.html参照 -->
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> -->
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0, user-scalable=no"> -->
    <meta http-equiv="Content-Style-Type" content="text/css">
    <meta http-equiv="Content-Script-Type" content="text/javascript">
    <!-- <link rel="stylesheet" href="css/base/reset.css" type="text/css">
    <link rel="stylesheet" href="css/base/layout.css" type="text/css"> -->
    <link rel="stylesheet" href="css/vendor/cropper.css" type="text/css">
    <!-- <link rel="stylesheet" href="css/vendor/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/page/trimming.css" type="text/css"> -->
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
                    <a class="header header__menu header__menu-1" href="#scroll-3">
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
                            <a class="nav-link" href="#scroll-3">猫ちゃん編集</a>
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
        <h1 class="edit__h1">猫ちゃん登録画面</h1>
        <form action="" method="POST">
            <div class="wrapper wrapper-1">
                <div class="inner inner__record-cat inner-1">
                    <div class="item item-1">
                        <div class="item-name">名前</div>
                        <?php if (!empty($post["error"]["name"]) && $post["error"]["name"] === "none") echo "<div class='error' style='color:red;'>入力してください</div>"; ?>
                        <div class="input-area"><input class="input__record-cat name text__record-cats" id="name" name="name" type="text" placeholder="名前"></div>
                    </div>

                    <div class="item item-2">
                        <div class="item-name">誕生日</div>
                        <?php if (!empty($post["error"]["birthday"]) && $post["error"]["birthday"] === "none") echo "<div class='error' style='color:red;'>入力してください</div>"; ?>
                        <div class="input-area"><input class="input__record-cat birthday date__record-cats" id="birthday" name="birthday" type="date"></div>
                    </div>

                    <div class="item item-3">
                        <div class="item-name">性別</div>
                        <?php if (!empty($post["error"]["gender"]) && $post["error"]["gender"] === "none") echo "<div class='error' style='color:red;'>入力してください</div>"; ?>
                        <div class="input-area">
                        <select class="gender select__gender" id="gender" name="gender">
                            <option value="オス">オス</option>
                            <option value="メス">メス</option>
                        </select>
                    </div>
                    </div>

                    <!-- <div class="item item-4">
                        <div class="item-name">趣味</div>
                        <div class="input-area"><input class="hobby text__record-cats" id="hobby" name="hobby[]" type="text"></div>
                        <div class="add add__hobby">追加</div>
                    </div>
                    
                    <div class="item item-5">
                        <div class="item-name">休日の過ごし方</div>
                        <div class="input-area"><input class="spend text__record-cats" id="spend" name="spend[]" type="text"></div>
                        <div class="add add__spend">追加</div>
                    </div> -->

                    <div class="item item-3">
                        <div class="item-name">写真</div>
                        <?php if (!empty($post["error"]["image"]) && $post["error"]["image"] === "none") echo "<div class='error' style='color:red;'>ファイルを選択してください</div>"; ?>
                        <div class="input-area">
                            <input class="image text__record-cats js-imageFile" id="image-file" name="image" type="file" accept="image/*">
                        </div>
                    </div>

                    <img class="js-trimmedImg" id="preview" src="" alt="">
                    <input class="save_image" id="save_image" type="hidden" name="save_image" value="">


                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary modal-btn" data-bs-toggle="modal" data-bs-target="#myModal" style="display:none">
                    </button>
                    <div class="modal fade js-trimmingModal" id="myModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">トリミンングしてください</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="trimming-area">
                                        <img src="" class="js-preaviewImage js-trimmingAreaImg">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger js-trimmingBtn" data-option="">これで決定</button>
                                </div>
                            </div>
                        </div>
                    </div>









                    <!-- 追加要素 -->
                    <!-- <div class="item item__hobby" style="display: none;">
                        <div class="item-name"></div>
                        <div class="input-area"><input class="hobby text__record-cats" id="hobby-" name="hobby[]" type="text"></div>
                        <div class="dummy"></div>
                    </div>

                    <div class="item item__spend" style="display: none;">
                        <div class="item-name"></div>
                        <div class="input-area"><input class="spend text__record-cats" id="spend-" name="spend[]" type="text"></div>
                        <div class="dummy"></div>
                    </div> -->



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

    <!-- bootstrap ver5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>


    <!-- https://github.com/yuki-yoshida-z/demoes/blob/master/trimming.html参照 -->
    <script src="js/vendor/cropper.js"></script>
    <script src="js/page/trimming.js?ver=0.1"></script>
    <script>
        $(".add__hobby").click(function() {
            $html = $(".item__hobby").eq(0).html();
            $(".item-4").append($html);
        });

        $(".add__spend").click(function() {
            $html = $(".item__spend").eq(0).html();
            $(".item-5").append($html);
        });
    </script>
</body>

</html>