<?php
//phpでリアルタイムな時間を指定することができる
date_default_timezone_set('Asia/Manila');

    $dsn = 'mysql:dbname=oneline_bbs;host=localhost';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');
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


    $sql = 'INSERT INTO `posts`(`nickname`,`comment`,`created`) VALUES (?,?,?)';
    $data [] =$nickname;
    $data [] =$comment;
    $data [] =date("Y-m-d H:i:s");

    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
}

//データベースを取ってきて　縦に順番に並べる
    $sql ='SELECT * FROM `posts` ORDER BY `created` DESC';

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

//データベースの内容をhtmlの特定の場所に入れる場合のPHPを作成する
    $comments = array(); //⇦ここで配列の箱を作る
    //データを１件ずつ追加
    while (1) {
      $rec = $stmt->fetch(PDO::FETCH_ASSOC);//1件ずつデータをとってくる文
      if($rec === false){
          break;
      }
      $comments[] =$rec;//⇦配列に追加

    }

  $dbh = null;

  ?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>セブ掲示版</title>

  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="assets/css/form.css">
  <link rel="stylesheet" href="assets/css/timeline.css">
  <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
  <!-- ナビゲーションバー -->
  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header page-scroll">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#page-top"><span class="strong-title"><i class="fa fa-linux"></i> Oneline bbs</span></a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
              </ul>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
  </nav>

  <!-- Bootstrapのcontainer -->
  <div class="container">
    <!-- Bootstrapのrow -->
    <div class="row">

      <!-- 画面左側 -->
      <div class="col-md-4 content-margin-top">
        <!-- form部分 -->
        <form action="bbs.php" method="post">
          <!-- nickname -->
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="nickname" class="form-control" id="validate-text" placeholder="nickname" required>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
          </div>
          <!-- comment -->
          <div class="form-group">
            <div class="input-group" data-validate="length" data-length="4">
              <textarea type="text" class="form-control" name="comment" id="validate-length" placeholder="comment" required></textarea>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
          </div>
          <!-- つぶやくボタン -->
          <button type="submit" class="btn btn-primary col-xs-12" disabled>つぶやく</button>
        </form>
      </div>

      <!-- 画面右側 -->
      <div class="col-md-8 content-margin-top">
        <div class="timeline-centered">

          <!-- foreach文でcomments(上で書いた箱)から取り出す処理を指示する -->
                    <?php foreach ($comments as $comment): ?>
          <article class="timeline-entry">
              <div class="timeline-entry-inner">
                  <div class="timeline-icon bg-success">
                      <i class="entypo-feather"></i>
                      <i class="fa fa-cogs"></i>
                  </div>
                  <div class="timeline-label">
                     <h2>
                        <a href="#"><?php echo $comment['nickname'] ?></a> <span><?php echo $comment['created'] ?></span>
                        
                        <a href="edit.php?id=<?php echo $comment["id"];?>"  class="btn btn-success" style ="color: white">編集</a>

                        <a href="delete.php?id=<?php echo $comment["id"];?>"  class="btn btn-danger" style ="color: white">削除</a>

                      </h2>
                      <p><?php echo $comment['comment'] ?></p>
                  </div>
              </div>
          </article>

          <article class="timeline-entry begin">
              <div class="timeline-entry-inner">
                  <div class="timeline-icon" style="-webkit-transform: rotate(-90deg); -moz-transform: rotate(-90deg);">
                      <i class="entypo-flight"></i> +
                  </div>
              </div>
          </article>
        <?php endforeach;?>
        <!-- ここでforeeachを締める -->
        </div>
      </div>

    </div>
  </div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/form.js"></script>
</body>
</html>



