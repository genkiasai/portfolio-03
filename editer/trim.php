<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.1">
    <link rel="stylesheet" href="./style.css?ver=1.2">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
    <title>トリミングテスト</title>

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
    <main class="main__top-page">
        <h1 class="edit__h1">トリミングテスト</h1>
        <form action="" method="POST">
            <div class="wrapper wrapper-1">
                <div class="inner inner-1">
                    <div class="item item-1">
                        <div class="item-name">写真</div>
                        <input class="image text__record-therapist js-imageFile" id="image-file" name="image[]" type="file" accept="image/*">
                    </div>
                    
                    <img class="js-trimmedImg" id="preview" src="" alt="">

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary modal-btn hide" data-bs-toggle="modal" data-bs-target="#myModal" style="display:none">
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
                            <!-- /.trimming-area --></div>
                            <!-- /.modal-body --></div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-danger js-trimmingBtn" data-option="">これで決定</button>
                            </div>
                        <!-- /.modal-content --></div>
                        <!-- /.modal-dialog --></div>
                    <!-- /.modal --></div>


                </div>
            </div>
        </form>
    </main>


    <!-- bootstrap ver5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    
    <script src="js/vendor/cropper.js"></script>
    <script src="js/page/trimming.js"></script>
    <script>
        $("#image-file").on("change", function(){
            $(".modal-btn").click();
        });
    </script>
</body>
</html>
