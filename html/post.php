<?
  try{

    if(!isset($_POST["name"]) || !isset($_POST["body"]) || $_POST["name"] == "" || $_POST["body"] == ""){
      throw new Exception("名前または本文が入力されていません");
    }

    $pdo = new PDO("sqlite:../posts.db");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $pdo->exec("CREATE TABLE IF NOT EXISTS posts(
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name VARCHAR(25),
        body VARCHAR(300),
        time TIMESTAMP DEFAULT (datetime(CURRENT_TIMESTAMP,'+9 hours'))
    )");

    $stmt = $pdo->prepare("INSERT INTO posts(name, body) VALUES(:name, :body)");

    $stmt->bindValue(":name", $_POST["name"], PDO::PARAM_STR);
    $stmt->bindValue(":body", $_POST["body"], PDO::PARAM_STR);
    $stmt->execute();

    $msg = "メッセージが投稿されました";

  }catch(Exception $e){
    // echo $e->getMessage() . PHP_EOL;
    $msg = $e->getMessage();
  }

?>
<html>
  <head>
    <title>PHP Test</title>
  </head>
  <body>
    <p><?=$msg?></p>
    <a href="/">トップへ戻る</a>
  </body>
</html>