<?php
  require_once('./functions.php');
  session_start();
  $id = $_GET['id'];
  redirectIfNotLogin();
  $id = $_SESSION['user']['id'];
  $username = $_SESSION['user']['username'];
  $pdo = connectDB();

  $sql = 'SELECT articles_p.id,article_station.station_id,article_categories.category_id,article_wage.wage,articles_p.title,articles_p.body,articles_p.user_id,article_date.date_a,station.station FROM ((((article_station inner join articles_p on article_station.article_id=articles_p.id)inner join article_categories on articles_p.id=article_categories.article_id)inner join article_wage on articles_p.id=article_wage.article_id)inner join article_date on articles_p.id=article_date.article_id)inner join station on article_station.station_id=station.id where articles_p.id = :id';
  $statement = $pdo->prepare($sql);
  $statement->execute([':id' => $_GET['id']]);
  $article = $statement->fetch();
  $user_id = $article['user_id'];

  $sql2 = 'SELECT * FROM users_p WHERE id = :user_id';
  $statement = $pdo->prepare($sql2);
  $statement->execute([':user_id' => $user_id]);
  $result = $statement->fetch();

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sql3 = "INSERT INTO application(article_id,Application_user_id) VALUES(:article_id,:Application_user_id)";
    $statement = $pdo->prepare($sql3);
    $result = $statement->execute([
      ':article_id' => $_POST['id'],
      ':Application_user_id' => $id,
    ]);
    header("Location: mypage.php");
}
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>代行詳細</title>
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
        <h1>代行詳細</h1>
        <h2>タイトル：<?php echo h($article['title']); ?></h2>
        <h3>応募者：<?php echo h($result['username']); ?></h3>
    　　<p>日付：<?php echo h($article['date_a']); ?>   場所：<?php echo h($article['station']); ?>   時給：<?php echo h($article['wage']); ?></p>
        <p>内容：<?php echo h($article['body']); ?></p>
        <form action="article.php" method="post">
          <p></p>
          <p></p>
          <p></p>
          <h3>この記事に応募してよろしいでしょうか？</h3>
          <input type="hidden"name="id"value="<?php echo $article['id'];?>">
          <input type="submit" value="応募" class="btn signup">
        </form>
        <link rel="stylesheet" href="./stylesheet.css">
    </head>
    <body>
    <div class="message-wrapper">
      <div class="container">
        <div class="heading">
          <h2>どんどん、AGENCYで助け合いをはじめましょう!</h2>
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
