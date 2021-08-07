<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission5-1</title>
</head>
<body>
    <br>
    <h1>乾杯のとき何飲む？</h1>



<?php
    // DB接続設定
    $dsn = "dsn";
    $user = "ユーザー名前";
    $password = "パスワード";
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    $sql = "CREATE TABLE IF NOT EXISTS tbtest"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    . "password TEXT"
    .");";
    $stmt = $pdo->query($sql);
    
    $sql = $pdo -> prepare("INSERT INTO tbtest (name, comment, password) VALUES (:name, :comment, :password)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql -> bindParam(':password', $password, PDO::PARAM_STR);
   
    //新規投稿
    if(!empty($_POST["name"]) && !empty($_POST["str"])
    && !empty($_POST["pass"]) && empty($_POST["edit"])){
            $name = $_POST["name"];
            $comment = $_POST["str"];
            $password = $_POST["pass"];
            $sql -> execute();
        
    
    //編集    
    }
    if(!empty($_POST["name"]) && !empty($_POST["str"]) && !empty($_POST["edit"])){
        $id = $_POST["edit"];
        $name = $_POST["name"];
        $comment = $_POST["str"];
        $password = $_POST["pass"];
        $sql = 'UPDATE tbtest SET name=:name,comment=:comment, password=:password WHERE id=:id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt -> bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

    }
    
    
    //削除
    if(!empty($_POST["deleteno"]) && !empty($_POST["passD"])){
        //投稿番号が一致したら消去
        $sql = $pdo -> prepare('delete from tbtest where id=:id and password=:password');
        $sql->bindParam(':id', $id, PDO::PARAM_INT);
        $sql->bindParam(':password', $passD, PDO::PARAM_STR);
        //変数定義
        $id = $_POST["deleteno"];
        $passD = $_POST["passD"];
        /*
        $sql = 'SELECT * FROM tbtest where id='.$id;
        /*
        $result = $pdo->query($sql);
        */


        $sql->execute();
        
        
        
        
    }
    
    //編集//番号をフォームに表示
    if(!empty($_POST["editno"]) && !empty($_POST["passE"])){
        
        
        $sql -> bindParam(':id', $id, PDO::PARAM_INT);
        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql -> bindParam(':password', $passE, PDO::PARAM_STR);
        $id = $_POST["editno"];
        $passE = $_POST["passE"];
        $sql = 'SELECT * FROM tbtest';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        /*echo "results";デバック*/
        foreach ($results as $row){
            /*echo "roop";デバック*/
            if(($row['id']==$id)&&($row['password']==$passE)){
                $editid = $row['id'];
                $editname = $row['name'];
                $editcomment = $row['comment'];
            
                
            }else{
                
            }
            
            
        
            
        
        }
    }
    
?>

<form action="" method="post">
        
        <input type="text" name="name" placeholder="名前"
        value="<?php if(!empty($_POST["editno"]) && !empty($_POST["passE"])){ echo $editname;} ?>">
        <input type="text" name="str" placeholder="コメント" 
        value="<?php if(!empty($_POST["editno"]) && !empty($_POST["passE"])){ echo $editcomment;} ?>">
        <input type="text" name="pass" placeholder="パスワード">
        <input type="submit" name="submit">
        <p>
        <input type="text" name="deleteno" placeholder="削除したい投稿番号">
        <input type="text" name="passD" placeholder="パスワード">
        <input type="submit" name="submit" value="削除"></p>
        
        <p><input type="text" name="editno" placeholder="編集したい投稿番号">
        <input type="text" name="passE" placeholder="パスワード">
        <input type="submit" name="submit" value="編集">
        <p><input type="hidden" name="edit" 
        value= "<?php if(!empty($_POST["editno"]) && !empty($_POST["passE"])){ echo $editid;} ?>">
        </p>

        </form>
    </body>
<?php    
    //表示
    $sql = 'SELECT * FROM tbtest';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['password'].'<br>';
    echo "<hr>";
  
    }
?>
    