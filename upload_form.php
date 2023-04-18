<?php
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>アップロードフォーム</title>
    <link rel="stylesheet" href="style.css">
  </head>
  
  <body>
    <!-- 複数のファイルを送る -->
    <form enctype="multipart/form-data" action="./file_upload.php" method="POST">
      <div class="file-up">
        <!-- １メガ以上のファイルを送るとエラー -->
        <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
        <!-- 画像の拡張子のみ選択 -->
        <input name="img" type="file" accept="image/*" />
      </div>
      <div>
        <textarea
          name="caption"
          placeholder="キャプション（140文字以下）"
          id="caption"
        ></textarea>
      </div>
      <div class="submit">
        <input type="submit" value="送信" class="btn" />
      </div>
    </form>

    <p>PHPで利用するfilter_inputメソッドは、指定した名称の値をフィルタリングする処理を行うことが可能です。フィルタリングというのは、目的の値が正しいものか調査することを意味します。
       filter_inputを利用すると、指定した名称の値を取得しつつ、バリデーションとも呼ばれるフィルタリング処理を行うことが可能です。
       これは、値をフィルターに通して、正しいかどうかを判断するイメージです。実際に利用する場合は、ユーザが入力した値が正しいものかを調査する処理などで利用します。</p>

  </body>
</html>
