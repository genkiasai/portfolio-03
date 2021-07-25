//ファイルが選択されたら
  //ファイル名を表示する
  //選択された画像をプレビュー表示
  //トリミング用のモーダルにも画像をセットする(まだ非表示)
  $(".js-imageFile").on("change", function(){
    $(".modal-btn").click();
    selectImage();
  });
  
  //選択ファイル読み込み
  function selectImage(){
    var file = document.getElementById('image-file').files[0];
    showFileName(file)
    var reader = new FileReader();
    reader.onload = function() {
      showFileImage(reader)
    }
    reader.readAsDataURL(file);
  };
  //ファイル名を表示する
  function showFileName(file){
    var fileName = file.name
    $(".js-fileName").text(fileName)
  };
  //選択された画像をプレビュー表示
  //トリミング用のモーダルにも画像をセットする(まだ非表示)
  function showFileImage(reader){
    $(".js-previewImageBlock").css("border", "none");
    $('.js-preaviewImage').attr("src", reader.result);
    $(".js-trimmingAreaImg").attr("src", reader.result);
  };
  
  //モーダルが表示されたらトリミング画面開始
  $(".js-trimmingModal").on("shown.bs.modal", function(){
  //画像トリミング
    var image = $(".js-trimmingAreaImg")[0];
    var options = {aspectRatio: 1 / 1.5};
    var cropper = new Cropper(image, options);
    //ボタンをクリックしたらトリミング終了
    $(".js-trimmingBtn").one("click", function(e) {
      //トリミングしたデータ
      var result = cropper.getCroppedCanvas({width: 500, height: 500})
      //トリミングデータを表示
      $(".js-trimmedImg").attr("src", result.toDataURL())
      // $(".save_image").attr("value", result.toDataURL())
      $(".save_image").val(result.toDataURL())
      // 一旦トリミングしたらトリミングのデータはリセット
      cropper.destroy()
      // モーダル非表示
      $(".js-trimmingModal").modal("hide")
    });
  });