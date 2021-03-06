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
    if (isset($_POST["save"])) {
        if (!isset($post["error_cat"])) {
            // 保存するファイル名をidから取得
            $id = $db->prepare("SELECT MAX(id) FROM cats");
            $id->execute();
            $file_name = $id->fetch(PDO::FETCH_ASSOC);
            $file_name = (int)$file_name["MAX(id)"] + 1;
            if (strlen($file_name) === 1) {
                $file_name = "000" . $file_name;
            } elseif (strlen($file_name) === 2) {
                $file_name = "00" . $file_name;
            } elseif (strlen($file_name) === 3) {
                $file_name = "0" . $file_name;
            }
    
            // データベース書き込み
            $post["image"] = "./cats/" . $file_name . ".jpg";
            $write = $db->prepare("INSERT INTO cats SET name=?, gender=?, birthday=?, image=?");
            $write->execute(array(
                $post["name"],
                $post["gender"],
                $post["birthday"] . "-01",
                $post["image"]
            ));
    
            // base64の画像データを保存
            if (!file_exists("../cats/")) {
                mkdir("../cats/");
            }
            $img = $_POST["save_image"];
            $img = str_replace("data:image/png;base64,", "", $img);
            $img = str_replace(" ", "+", $img);
            $save_image = base64_decode($img);
            file_put_contents("../cats/" . $file_name . ".jpg", $save_image);
        // } else {

        }
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
    <link rel="stylesheet" href="./style.css?ver=1.8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>@TODO</title>
    <meta http-equiv="Content-Style-Type" content="text/css">
    <meta http-equiv="Content-Script-Type" content="text/javascript">
    <link rel="stylesheet" href="css/vendor/cropper.css" type="text/css">
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
                            <a class="nav-link" href="./edit-cat-select.php">猫ちゃん編集</a>
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
                        <?php if (!empty($post["error_cat"]["name"]) && $post["error_cat"]["name"] === "none") echo "<div class='error' style='color:red;'>入力してください</div>"; ?>
                        <div class="input-area"><input class="input__record-cat name text__record-cats" id="name" name="name" type="text" value="<?php if (isset($post["name"])) echo $post["name"]; ?>" placeholder="名前"></div>
                    </div>

                    <div class="item item-2">
                        <div class="item-name">誕生日</div>
                        <?php if (!empty($post["error_cat"]["birthday"]) && $post["error_cat"]["birthday"] === "none") echo "<div class='error' style='color:red;'>入力してください</div>"; ?>
                        <div class="input-area"><input class="input__record-cat birthday date__record-cats" id="birthday" name="birthday" type="month" value="<?php if (isset($post["birthday"])) echo $post["birthday"]; ?>"></div>
                    </div>

                    <div class="item item-3">
                        <div class="item-name">性別</div>
                        <?php if (!empty($post["error_cat"]["gender"]) && $post["error_cat"]["gender"] === "none") echo "<div class='error' style='color:red;'>入力してください</div>"; ?>
                        <div class="input-area">
                            <select class="gender select__gender" id="gender" name="gender">
                                <option value="オス" <?php if (isset($post["gender"]) and $post["gender"] === "オス") echo "selected" ?>>オス</option>
                                <option value="メス" <?php if (isset($post["gender"]) and $post["gender"] === "メス") echo "selected" ?>>メス</option>
                            </select>
                        </div>
                    </div>

                    <div class="item item-3">
                        <div class="item-name">写真</div>
                        <?php if (!empty($post["error_cat"]["save_image"]) && $post["error_cat"]["save_image"] === "none") echo "<div class='error' style='color:red;'>ファイルを選択してください</div>"; ?>
                        <div class="input-area">
                            <input class="image text__record-cats js-imageFile" id="image-file" name="image" type="file" accept="image/*" style="display: none">
                            <label class="button__file" for="image-file">ファイルを選択</label>
                            <span class="js-fileName"></span>
                        </div>
                    </div>

                    <img class="js-trimmedImg" id="preview" src="<?php if (isset($post["save_image"])) { echo $post["save_image"]; } elseif (isset($_POST["hidden_image"])) { echo $_POST["hidden_image"]; } ?>" alt="">
                    <input class="save_image" id="save_image" type="hidden" name="save_image" value="">
                    <input type="hidden" name="hidden_image" value="<?php if (isset($post["save_image"])) { echo $post["save_image"]; } elseif (isset($_POST["hidden_image"])) { echo $_POST["hidden_image"]; } ?>">

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary modal-btn" data-bs-toggle="modal" data-bs-target="#myModal" style="display:none">
                    </button>
                    <div class="modal fade js-trimmingModal" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">トリミンングしてください</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                </div>
            </div>
            <div class="save-area">
                <div class="save-message">
                    編集が終了したら→
                </div>0
                <input class="submit__save" id="submit__save" name="save" type="submit" value="保存">
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
    <script src="js/page/trimming.js?ver=0.6"></script>
</body>

</html>