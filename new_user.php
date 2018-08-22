<?php
 session_start();
 require_once('./functions.php');

 if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $passwd = $_POST['passwd'];
    $passwd_confirmation = $_POST['passwd_confirmation'];
    $phonenumber = $_POST['phonenumber'];
    $nichiji = date('Y-m-d H:i:s');

 if (empty($username) || empty($passwd) || empty($passwd_confirmation)|| empty($passwd_confirmation) ||empty($phonenumber)) {
        $_SESSION["error"] = "入力されていない項目があります";
        header("Location: new_user.php");
     return;

    }

if ($passwd !== $passwd_confirmation) {
        $_SESSION["error"] = "パスワードが一致しません";
        header("Location: new_user.php");
        return;
    }

    $pdo = connectDB();
    $sql = "INSERT INTO users_p(username,passwd,phonenumber,created_at,modified_at)
     VALUES(:username,:passwd,:phonenumber,:created_at,:modified_at)";
    $statement = $pdo->prepare($sql);
    $result = $statement->execute([
      ':username'=>$username,
      ':passwd'=>password_hash($passwd,PASSWORD_DEFAULT),
      ':phonenumber'=>$phonenumber,
     	':created_at'=>$nichiji,
      ':modified_at'=>$nichiji,
    ]);

 if (!$result) {
        die('Database Error');
    }
    $_SESSION["success"] = "登録が完了しました。ログインしてください。";
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>ユーザー登録</title>
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="stylesheet" href="">
  </head>
  <body>
    <header>
      <div class="container">
        <div class="header-left">
          <a class="logo">AGENCY</a>
        </div>
        <div class="header-right">
          <a href="./login.php" class="login">ログイン</a>
        </div>
      </div>
    </header>
   <?php if(!empty($_SESSION['success'])): ?>
        <div class="alert alert-success" role="success">
            <pre><?php echo $_SESSION['success']; ?></pre>
            <?php $_SESSION['success'] = null; ?>
        </div>
    <?php endif; ?>
    <?php if(!empty($_SESSION['error'])): ?>
        <div>
            <pre><?php echo $_SESSION['error']; ?></pre>
            <?php $_SESSION['error'] = null; ?>
        </div>
    <?php endif; ?>
    <div class="top-wrapper">
      <div class="container">
        <h1>AGENCY</h1>
        <h2>ユーザー登録</h2>
        <form action="" method="POST">
            <p>ユーザー名:
                <input type="text" name="username">
            </p>
            <p>パスワード:
                <input type="password" name="passwd">
            </p>
            <p>パスワード再入力:
                <input type="password" name="passwd_confirmation">
            </p>
            <p>電話番号:
                <input type="text"name="phonenumber">
            </p>
                <input type="submit" value="登録" class="btn signup">
        </form>
      </div>
    </div>
    <footer>
      <div class="container">
        <p>HELP　EACH　OTHER.</p>
      </div>
    </footer>
  </body>
</html>
