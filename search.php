<?php
  require_once('./functions.php');
  session_start();
  redirectIfNotLogin();
  $id = $_SESSION['user']['id'];
  $username = $_SESSION['user']['username'];
  $pdo = connectDB();

$sql = "SELECT * FROM  category";
$statement = $pdo->prepare($sql);
$statement->execute();
$categories =$statement->fetchAll();

$sql2 = "SELECT * FROM station";
$statement = $pdo->prepare($sql2);
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
      </div>
    </div>
    <div class="message-wrapper">
      <div class="container">
        <div class="heading">
          <h2>どんどん、AGENCYはで助け合いをはじめましょう!</h2>
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
