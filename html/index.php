<?
  try{
    $pdo = new PDO("sqlite:../posts.db");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $pdo->exec("CREATE TABLE IF NOT EXISTS posts(
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name VARCHAR(25),
        body VARCHAR(300),
        time TIMESTAMP DEFAULT (datetime(CURRENT_TIMESTAMP,'+9 hours'))
    )");

    $stmt = $pdo->prepare("SELECT * FROM posts");
    $stmt->execute();
    $posts = $stmt->fetchAll();

  }catch(Exception $e){
    echo $e->getMessage() . PHP_EOL;
  }

?>
<html>
  <head>
    <title>PHP Test</title>
  </head>
  <body>
    <form action="post.php" method="POST">
      <div>
        <label>名前：</label>
        <input type="text" name="name">
      </div>
      <div>
        <label>本文：</label>
        <textarea name="body"></textarea>
      </div>
      <input type="submit" value="投稿　">
    </form>
    <? foreach($posts as $post): ?>
    <p><?=$post["name"]?> <?=$post["time"]?></p>
    <p><?=$post["body"]?></p>
    <? endforeach; ?>
  </body>
</html>