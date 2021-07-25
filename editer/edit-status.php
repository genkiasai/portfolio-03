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
    <title>@TODO</title>
</head>
<body>
    <header id="scroll-top">
        <!-- 会社名 -->
        <nav class="nav-pc">
            <div class="row">
                <div class="col-xl-4 col-sm-4 header__contents header__contents-1"><a class="header header__company-name" href="./">@TODO店名</a></div>
                <div class="col-xl-2 col-sm-2 header__contents header__contents-2">
                    <a class="header header__menu header__menu-1" href="./record-therapist.php">
                        <div class="header__menu-1-1">RECORD</div>
                        <div class="header__menu-1-2">セラピスト登録</div>
                    </a>
                </div>
                <div class="col-xl-2 col-sm-2 header__contents header__contents-2">
                    <a class="header header__menu header__menu-1" href="#scroll-3">
                        <div class="header__menu-2-1">EDIT</div>
                        <div class="header__menu-2-2">セラピスト編集</div>
                    </a>
                </div>
                <div class="col-xl-2 col-sm-2 header__contents header__contents-2">
                    <a class="header header__menu header__menu-1" href="./edit-status.php">
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
                            <div class="nav__logo-name"><span class="nav__logo-name_bold">@TODO店名</span></div>
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
                            <a class="nav-link" href="./record-therapist.php">セラピスト登録</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#scroll-3">セラピスト編集</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./edit-status.php">出勤ステータス</a>
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
        <h1 class="edit__h1">出勤ステータス編集画面</h1>
        <form action="" method="POST">
            <div class="wrapper wrapper-1">
                <div class="inner inner-1">
                    <p class="">ステータス変更するセラピストを選択</p>
                    <select name="status" id="status">
                        <option value=""></option>
                        <option value="id1">ゲンキ</option>
                        <option value="id2">ゲンキ</option>
                        <option value="id3">ゲンキゲンキ</option>
                        <option value="id4">ゲンキ</option>
                        <option value="id5">ゲンキゲンキゲンキ</option>
                        <option value="id6">ゲンキ</option>
                    </select>
                    <div class="submit-change-area">
                        <input class="change" id="change" type="submit" name="change" value="ステータス変更">
                    </div>
                </div>
            </div>

            <div class="wrapper wrapper-2 wrapper-2__edit">
                <div class="inner inner-2">
                    <h2 class="wrapper__h2">出勤ステータス</h2>
                    <div class="table table-1" id="table-1">
                        <table class="table table-1" border="1" width="100%">
                            <tr>
                                <th width="25%">ゲンキ</th>
                                <th width="25%">ゲンキ</th>
                                <th width="25%">ゲンキゲンキ</th>
                                <th width="25%">ゲンキ</th>
                            </tr>
                            <tr>
                                <td width="25%"><img class="status-icon status-icon__on" src="./images/on.png" alt="出勤"></td>
                                <td width="25%"><img class="status-icon status-icon__off" src="./images/off.png" alt="退勤"></td>
                                <td width="25%"><img class="status-icon status-icon__off" src="./images/off.png" alt="退勤"></td>
                                <td width="25%"><img class="status-icon status-icon__on" src="./images/on.png" alt="出勤"></td>
                            </tr>
                        </table>
                        <table class="table table-2" border="1" width="100%">
                            <tr>
                                <th width="25%">ゲンキゲンキ</th>
                                <th width="25%">ゲンキ</th>
                                <th width="25%"></th>
                                <th width="25%"></th>
                            </tr>
                            <tr>
                                <td width="25%"><img class="status-icon status-icon__off" src="./images/off.png" alt="退勤"></td>
                                <td width="25%"><img class="status-icon status-icon__on" src="./images/on.png" alt="出勤"></td>
                                <td width="25%"></td>
                                <td width="25%"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </main>



    
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>