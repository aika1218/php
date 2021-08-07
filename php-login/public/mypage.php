<?php
session_start();
require_once '../classes/UserLogic.php';
require_once '../functions.php';

//　ログインしているか判定し、していなかったら新規登録画面へ返す
$result = UserLogic::checkLogin();

if (!$result) {
  $_SESSION['login_err'] = 'ユーザを登録してログインしてください！';
  header('Location: signup_form.php');
  return;
}

$login_user = $_SESSION['login_user'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP" rel="stylesheet">
  <link rel="stylesheet" href="a.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>マイページ</title>

</head>

<body class="wrap">
    <header>
    <h1>
        <a href="/">Let's go future! 〜指定校推薦検索サイト〜</a>
    </h1>
    <nav>
    <ul>
      <li><a href="">お気に入り</a></li>
      <li><a href="">閲覧履歴</a></li>
      <li><a href="">偏差値ランキング</a></li>
      <li><a href="">部活動</a></li>
    </ul>
  </nav>
        <form action="logout.php" method="POST">
        <input type="submit" name="logout" value="ログアウト" class="btn">
        </form>
 

</nav>
</header>
    <div class="content">
        <div id="parent">
            <div id="child1">
                <h3><?php echo h($login_user['name']) ?>のページ</h3>
                <p>メールアドレス：<?php echo h($login_user['email']) ?></p>
                <br>
                <div class="title-box5">
                    <div class="title-box5-title">検索</div>
                    <p>
                        <form action="postserch.php" method="get">
                        <input type="search" name="college" placeholder="大学名">
                        評定：<select name="select" >
                        <option>4.0~</option>
                        <option>3.5~</option>
                        <option>3.0~</option>
                        <option>2.0~</option>
                            </select>
                        文理：
                        <input type="radio" name="ribu" value="理系" /> 理系　
                        <input type="radio" name="ribu" value="文系" /> 文系
                        <input type="submit" name="submit" value="検索">
                        </form>
                    </p>
                </div>

                <?php
                    require_once "dbc.php";
                    $files = getAllFile();

                ?>
                <br>
                <h3>プロフィール画像変更</h3>
                <form enctype="multipart/form-data" action="./file_upload.php" method="POST">
                    <div class="file-up">
                        <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
                        <input name="img" type="file" accept="image/*" />
                    </div>
                    <div>
                        <textarea
                        name="caption" placeholder="キャプション（140文字以下）"id="caption"></textarea>
                    </div>
                    <div class="submit">
                        <input type="submit" value="送信"  />
                    </div>
                </form>
                <div>
                    <?php foreach($files as $file): ?>
                    <img src="<?php echo "{$file['file_path']}";?>">
                    <p><?php echo "{$file['description']}"; ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
            <div id="child2">
                <div style="position:absolute; top:150px; left:1150px">
                    <img src="https://tyoudoii-illust.com/wp-content/uploads/2021/01/graduate_student_simple.png" width="280" height="350">
                </div>
                
            </div>
        </div>
    </div>


</body>
</html>