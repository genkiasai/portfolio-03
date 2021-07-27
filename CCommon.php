<?php
    
    // 入力確認
    //////////////////////////////
    function inputCheck ($post) {
        try {
            /////////////////////
            // トップページ編集 //
            ////////////////////
            // キャッチコピー
            if (empty($post["catch_copy"])) {
                $post["error"]["catch_copy"] = "none";
            }
            
            // メッセージ１
            if (empty($post["message_1"])) {
                $post["error"]["message_1"] = "none";
            }
            
            // メッセージ２
            if (empty($post["message_2"])) {
                $post["error"]["message_2"] = "none";
            }
            
            // メッセージ３
            if (empty($post["message_3"])) {
                $post["error"]["message_3"] = "none";
            }
            
            // 住所
            if (empty($post["address"])) {
                $post["error"]["address"] = "none";
            }
            
            // 電話番号
            if (!empty($post["tel"])) {
                $tel = $post["tel"];
            } else {
                $post["error"]["tel"] = "none";
            }
            
            // 営業時間
            if (empty($post["time"])) {
                $post["error"]["time"] = "none";
            }
            
            // 定休日
            if (empty($post["holiday"])) {
                $post["error"]["holiday"] = "none";
            }
            
            // 年
            if (empty($post["year"])) {
                $post["error_info"]["year"] = "none";
            }
            
            // 月
            if (empty($post["month"])) {
                $post["error_info"]["month"] = "none";
            }
            
            // 日
            if (empty($post["day"])) {
                $post["error_info"]["day"] = "none";
            }
            
            // インフォメーション
            if (empty($post["info"])) {
                $post["error_info"]["info"] = "none";
            }
            
            /////////////////
            // 猫ちゃん登録 //
            /////////////////
            // 名前
            if (empty($post["name"])) {
                $post["error_cat"]["name"] = "none";
            }
            
            // 誕生日
            if (empty($post["birthday"])) {
                $post["error_cat"]["birthday"] = "none";
            }
            
            // 写真
            if (empty($post["image"])) {
                $post["error_cat"]["image"] = "none";
            }


            return $post;
        } catch (Exception $e) {
            throw new Exception ("入力確認エラー:" . $e->getMessage());
        }
    }

    // htmlspecialchars
    //////////////////////////////
    function h ($str) {
        return htmlspecialchars($str, ENT_QUOTES, "utf-8");
    }

    
    // 年齢算出
    //////////////////////////////
    function dateDiff ($birthDay) {
        $today = new DateTime('now');
        $birthDay = new DateTime($birthDay);
        $diff = $today->diff($birthDay);
        $age = $diff->y . "才" . $diff->m . "ヶ月";
        return $age;
    }

?>