<?php

require_once "dbc.php";
//ファイル関連の取得
$file = $_FILES['img'];
$filename = basename($file['name']);
$tmp_path = $file['tmp_name'];
$file_err = $file['error'];
$filesize = $file['size'];
$upload_dir = 'images/';
$save_filename = date('YmdHis') . $filename;
$err_msgs = array();
$save_path = $upload_dir. $save_filename;

//キャプションを取得
$caption = filter_input(INPUT_POST, 'caption', FILTER_SANITIZE_SPECIAL_CHARS);

//キャプションのバリデーション
//未入力
if(empty($caption)){
    array_push($err_msgs, "キャプションを入力してください");
    echo '<br>';
    
}
//１４０文字か
if(strlen($caption) > 140){
    array_push($err_msgs,'１４０文字以内で入力してください');
    echo '<br>';
    
}

//ファイルのバリデーション
//ファイルサイズが1MB未満か
if($filesize > 1048576 || $file_err == 2){
    array_push($err_msgs, "ファイルサイズは1MB未満にしてください");
    echo '<br>';
    
}

//拡張子が画像形式か
$allw_ext = array('jpg', 'jpeg', 'png');
$file_ext = pathinfo($filename, PATHINFO_EXTENSION);

if(!in_array(strtolower($file_ext), $allw_ext)){
    array_push($err_msgs, "画像ファイルを添付してください");
    echo '<br>';
    
}

if(count($err_msgs) == 0){
    

//アップロードされてるか
    if(is_uploaded_file($tmp_path)){
        if(move_uploaded_file($tmp_path, $save_path)){
        echo $filename . "を" . $upload_dir . "にアップロードしました"; 
        
        
        //DBに保存（ファイル名ファイルパスキャプション)
        $result = fileSave($filename, $save_path, $caption);
        
        }else{
            array_push($err_msgs, "ファイルが保存できません");
        
    }
    
    }else{
        array_push($err_msgs, "ファイルが選択されていません");
        echo '<br>';
    
    }
}else{
        foreach($err_msgs as $msg){
        echo $msg;
        echo '<br>';
        }   
    }



?>
<a href="./mypage.php">戻る</a>