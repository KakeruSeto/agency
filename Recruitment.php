<?php
  require_once('./functions.php');
  session_start();
  redirectIfNotLogin();
  $id = $_SESSION['user']['id'];
  $username = $_SESSION['user']['username'];
  $nichiji  = date('Y-m-d H:i:s');
  $pdo = connectDB();

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $body = $_POST['body'];
    $categories = $_POST['categories'];
    $stations = $_POST['stations'];
    $wage = $_POST['wage'];
    $date_a=$_POST['date_a'];
    $station_id = $_POST['station_id'];

    $sql = "INSERT INTO articles_p (user_id, title,body,created_at,modified_at) VALUES(:user_id, :title,:body,:created_at,:modified_at)";
    $statement = $pdo->prepare($sql);
    $result = $statement->execute([
      ':user_id' => $id,
      ':title' => $title,
      ':body' => $body,
      ':created_at' => $nichiji,
      ':modified_at' => $nichiji,
    ]);

    $sql2 = "SELECT * FROM  articles_p where title ='".$title."'";
    $statement2 = $pdo->prepare($sql2);
    $statement2->execute();
    $article =$statement2->fetch(PDO::FETCH_ASSOC);

    foreach($categories as $category){
    $sql3 = "INSERT INTO article_categories (article_id,category_id) VALUES(:article_id,:category_id)";
    $statement = $pdo->prepare($sql3);
    $result = $statement->execute([
      ':article_id' => $article["id"],
      ':category_id' => $category,
    ]);
  }
  $sql4 = "INSERT INTO article_wage (article_id,wage) VALUES(:article_id,:wage)";
  $statement = $pdo->prepare($sql4);
  $result = $statement->execute([
    ':article_id' => $article["id"],
    ':wage' => $wage,

  ]);
  $sql5 = "INSERT INTO  article_date (article_id,date_a) VALUES(:article_id,:date_a)";
  $statement = $pdo->prepare($sql5);
  $result = $statement->execute([
    ':article_id' => $article["id"],
    ':date_a' => $date_a,
  ]);

  $sql6 = "INSERT INTO article_station (article_id,station_id) VALUES(:article_id,:station_id)";
  $statement = $pdo->prepare($sql6);
  $result = $statement->execute([
    ':article_id' => $article["id"],
    ':station_id' => $station_id,
  ]);

    header("Location: mypage.php");
}
$sql7 = "SELECT * FROM  category";
$statement = $pdo->prepare($sql7);
$statement->execute();
$categories =$statement->fetchAll();

$sql8 = "SELECT * FROM station";
$statement = $pdo->prepare($sql8);
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
        <h2>代行募集</h2>
        　<form action="" method="post">
          <p>タイトル:<input type="text" name="title" size="50" maxlength="50" value=""></p>
          <p>内容：<textarea name="body" rows="5" cols="40"></textarea></p>
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
             <input type="radio"name="station_id"value="<?php echo $station["id"];?>">
             <?php echo $station["station"];
           }?></p>
           <input type="submit" value="募集" class="btn signup">
        </form>
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
