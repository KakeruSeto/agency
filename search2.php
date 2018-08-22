<?php
  require_once('./functions.php');
  session_start();
  redirectIfNotLogin();
  $id = $_SESSION['user']['id'];
  $username = $_SESSION['user']['username'];
  $nichiji  = date('Y-m-d H:i:s');
  $pdo = connectDB();

  $sql = "SELECT * FROM articles_p";
  $statement = $pdo->prepare($sql);
  $statement->execute([
      ':target_user_id' => $id,
    ]);
  $articles = $statement->fetchAll();

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $body = $_POST['body'];
    $categories = $_POST['categories'];
    $stations = $_POST['stations'];
    $wage = $_POST['wage'];
    $date = $_POST['date_a'];
    $station_id = $_POST['station_id'];
    $sql2 = "SELECT articles_p.id,article_station.station_id,article_categories.category_id,article_wage.wage,articles_p.title,articles_p.body,articles_p.user_id,article_date.date_a FROM (((article_station inner join articles_p on article_station.article_id=articles_p.id)inner join article_categories on articles_p.id=article_categories.article_id)inner join article_wage on articles_p.id=article_wage.article_id)inner join article_date on articles_p.id=article_date.article_id";
    if($categories){
      $categories_id=$categories[0];
      $sql2.=' where category_id='.$categories_id;
    }
    if($stations){
      // $stations_id=$stations[0];
      $sql2.=' where station_id='.$stations;
    }
    if($wage){
      // $wage_id=$wage[0];
      $sql2.=' where wage='.$wage;
    }
    if($date){
      // $wage_id=$wage[0];
      $sql2.=' where date_a="'.$date.'"';

    }
      $statement = $pdo->prepare($sql2);
      $statement->execute();
  $results = $statement->fetchAll();
                                            }

$sql3 = "SELECT * FROM  category";
$statement = $pdo->prepare($sql3);
$statement->execute();
$categories =$statement->fetchAll();

$sql4 = "SELECT * FROM station";
$statement = $pdo->prepare($sql4);
$statement->execute();
$stations =$statement->fetchAll();
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>AGENCY</title>
    <link rel="stylesheet" href="stylesheet.css">
    <script src="./menu.js"></script>
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
        <h2>代行検索</h2>
        <form action="search2.php" method="post">
           <h2 id="m1headline">カテゴリ</h2>
           <p id="m1content">
           <?php
           foreach($categories as $category){
            ?>
              <input type="checkbox"name="categories[]"value="<?php echo $category["id"];?>">
              <?php echo $category["category"];
           }?></p>
           <h2 id="m2headline">時給</h2>
           <p id="m2content"><input type="number" name="wage" step="10"></p>
           <h2 id="m3headline">日程</h2>
           <p id="m3content"><input type="date" name="date_a"></p>
           <h2 id="m4headline">時間</h2>
           <p id="m4content"><input type="time" name="time"></p>
          <h2 id="m5headline">駅</h2>
          <p id="m5content">
           <?php
           foreach($stations as $station){
            ?>
              <input type="checkbox"name="station_id[]"value="<?php echo $station["id"];?>">
              <?php echo $station["station"];
           }?></p>
          <input type="submit" value="検索" class="btn signup">
        </form>
      <table>
        <thead>
          <tr>
            <h2>タイトル</h2>
          </tr>
        </thead>
        <tbody>
     <?php
      foreach($results as $result):?>
        <tr>
          <p><a href="./article.php?id=<?php echo $result['id']; ?>"><?php echo h($result['title']); ?></a></p>
        </tr>
      <?php endforeach;?>
      <form action="search2.php" method="post">
       <input type="submit" value="応募" class="btn signup">
    </form>
      </div>
    </div>
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
