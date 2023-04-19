<?php
//  PHPでファイルを保存する機能作成
// 1. データベースにファイルデータを保存
//  ①ファイル名  →アップロードのファイル名
//  ②ファイルパス → 保存するときのファイル名(日付をつける)
//  ③キャプション → 文章
// 2. 任意のディレクトリにファイルを保存
//  ④・一時ディレクトリ(tmp)から任意の場所に移動
//    move_uploaded_file関数を使う
//    例) move_uploaded_file(tmp, 保存先パス)

//  ⑤ディレクトリトラバーサル
// 　 入力されたファイル名から他のディレクトリの情報を取られてしまったり、攻撃を受けてしまうこと
//    対策としてbasename関数を使って、パスの最後の名前を返す

require_once "./dbc.php";

$file = $_FILES['img'];
// ⑤
$filename = basename($file['name']);
$tmp_path = $file['tmp_name'];
$file_err = $file['error'];
$filesize = $file['size'];
// ①
$upload_dir = '/Applications/MAMP/htdocs/upload/images/';
// ②
$save_filename = date('YmdHis') . $filename;
$save_path = $upload_dir . $save_filename;

// caption(見出し)を取得
// サイバー攻撃につながるような文字を無効化
$caption = filter_input(INPUT_POST, 'caption', FILTER_SANITIZE_SPECIAL_CHARS);
$err_msgs = array();

// キャプションのバリデーション
// 未入力
if(empty($caption)) {
    array_push($err_msgs, 'キャプションを入力してください。');
}
// 140文字か
if(strlen($caption) > 140) {
    array_push($err_msgs, 'キャプション140文字以内で入力してください。');
}
// ファイルのバリデーション
// ファイルサイズが1MB未満か
if($filesize > 1048576 || $file_err == 2) {
    array_push($err_msgs, 'ファイルサイズは1MB未満にしてください。');
}

// 拡張は画像形式か
$allow_ext = array('jpg', 'jpeg', 'png');
$file_ext = pathinfo($filename, PATHINFO_EXTENSION);

if(!in_array(strtolower($file_ext), $allow_ext)) {
    array_push($err_msgs, '画像ファイルを添付してください。');
}

if (count($err_msgs) === 0) {
    // ファイルはあるかどうか？
    if (is_uploaded_file($tmp_path)) {
        // ④,②
        if(move_uploaded_file($tmp_path, $save_path)) {
        echo $filename . 'を' . $upload_dir .'アップしました。';
        // $fileData = array($filename, $save_path, $caption);
        // DBに保存(ファイル名、ファイルパス、キャプション)
        $result = fileSave($filename, $save_path, $caption);

       if ($result) {
        echo 'データベースに保存しました！';
      } else {
        echo 'データベースへの保存が失敗しました！';
      }
    } else {
      echo 'ファイルが保存できませんでした。';
    }
  } else {
    echo 'ファイルが選択されていません。';
    echo '<br>';
  }
} else {
  foreach ($err_msgs as $msg) {
    echo $msg;
    echo '<br>';
  }
}

?>
<a href="./upload_form.php">戻る</a>