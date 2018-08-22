<?php
  require_once('./functions.php');
  session_start();
  $id = $_SESSION['user']['id'];
  $username = $_SESSION['user']['username'];
  $pdo = connectDB();

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id=$_POST['id'];
    $sql = "DELETE FROM application WHERE id=:id";
    $statement = $pdo->prepare($sql);
    $result = $statement->execute([
    ':id'=>$id,
  ]);
}
    $sql2 = "SELECT * FROM articles_p inner join application on articles_p.id=application.article_id WHERE Application_user_id =:target_user_id";
    $statement = $pdo->prepare($sql2);
    $statement->execute([
    ':target_user_id' => $id,
  ]);
    $articles = $statement->fetchAll();
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>応募一覧</title>
    <link rel="stylesheet" href="stylesheet.css">
  </head>
  <body>
    <header>
      <div class="container">
        <div class="header-left">
          <a class="logo">AGENCY</a>
        </div>
        <div class="header-right">
          <a href="./logout.php" class="login">ログアウト</a>
        </div>
        <div class="header-right">
          <a href="./search.php" class="login">検索</a>
        </div>
        <div class="header-right">
          <a href="./Recruitment.php" class="login">募集</a>
        </div>
        <div class="header-right">
          <a href="./Application_list.php" class="login">応募一覧</a>
        </div>
        <div class="header-right">
          <a href="./Recruitment_list.php" class="login">募集一覧</a>
        </div>
        <div class="header-right">
         <a href="./mypage.php" class="login">マイページ</a>
        </div>
      </div>
    </header>
    <div class="top-wrapper">
      <div class="container">
        <table>
          <thead>
            <tr>
              <h2>応募一覧</h2>
              <h2>     </h2>
            </tr>
          </thead>
          <tbody>
            <?php foreach($articles as $article): ?>
              <tr>
                <p><a href="./article.php?id=<?php echo $article['id']; ?>"><?php echo h($article['title']); ?></a></p>
                <p>
                  <form action='' method='post'>
                    <input type ="hidden"name="id"value="<?php echo $article['id']?>">
                    <input type="submit" value="削除"　class="btn signup">
                  </form>
                </p>
              </tr>
            <?php endforeach; ?>
          </tbody>
       </table>
      </div>
    </div>
    <div class="message-wrapper">
      <div class="container">
        <div class="heading">
          <h2>どんどん、AGENCYで助け合いをはじめましょう！</h2>
          <h3>HELP EACH OTHER!</h3>
        </div>

      </div>
    </div>
    <footer>
      <div class="container">
        <p>HELP　EACH　OTHER.</p>
      </div>
    </footer>
  </body>
</html>
