// プロフィール画像アップロードプレビュー
function preview_image(obj) {
  var fileReader = new FileReader();
  fileReader.onload = function () {
    document.getElementById("preview").src = fileReader.result;
  };
  fileReader.readAsDataURL(obj.files[0]);
}
