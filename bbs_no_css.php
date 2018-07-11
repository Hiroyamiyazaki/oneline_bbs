<?php
  // ここにDBに登録する処理を記述する
  if(isset($_POST) && !empty($_POST['nickname']) && !empty($_POST['comment'])){
    $nickname = htmlspecialchars($_POST['nickname']);
    $comment = htmlspecialchars($_POST['comment']);

    if (empty($nickname)){
      return;
    };
    if (empty($comment)){
      return;
    };

    $dsn = 'mysql:dbname=oneline_bbs;host=localhost';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');


    $sql = 'INSERT INTO `posts`(`nickname`,`comment`) VALUES ("'.$nickname.'","'.$comment.'")';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $dbh = null;
  };

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>セブ掲示版</title>
</head>
<body>
    <form method="post" action="bbs_no_css.php">
      <p><input type="text" name="nickname" placeholder="nickname"></p>
      <p><textarea type="text" name="comment" placeholder="comment"></textarea></p>
      <p><button type="submit" >つぶやく</button></p>
    </form>
    <!-- ここにニックネーム、つぶやいた内容、日付を表示する -->

</body>
</html>