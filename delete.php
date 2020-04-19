<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> 削除 </title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <!-- <link rel="stylesheet" href="style.css"> -->
</head>

<body>
  <header>
  </header>
  <main>
    <div class="container">

      <?php
        if (isset($_GET["name"])) {
            try {
                $dsn = 'mysql:dbname=server;host=localhost';
                $user_name = 'root';
                $password = '';
                $dbh = new PDO($dsn, $user_name, $password); //データベースに接続
                $dbh->query('SET NAMES utf8'); //文字コードのための設定
                                
                $sql = "SELECT ip, user FROM server_table WHERE 1";
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
                $dbh = null; //データベースから切断
            } catch (Exception $e) {
                print 'サーバが停止しておりますので暫くお待ちください。';
                exit();
            }
            foreach ($stmt as $row) {
                if ($row["user"] == $_GET["name"]) {
                    print "<div class='text-center my-4'>";
                    print "<h2>以下の登録を削除しますか？</h2>";
                    print "</div>";
                    print "<div class='table-responsive'>";
                    print "<table class='table table-bordered table-striped'>";
                    print "<thead>";
                    print "<tr>";
                    printf("<th>#</th>");
                    printf("<th>名前</th>");
                    print "</tr>";
                    print "</thead>";
                    print "<tbody>";
                    print "<tr>";
                    printf("<th scope='row'>%s</th>", $row["ip"]);
                    printf("<td>%s</td>", $row["user"]);
                    print "</tr>";
                    print "</tbody>";
                    print "</table>";
                    print "</div>";
                    print "<br>";
                }
            }
        }
            
        if (isset($_POST['delete'])) {
            $name = $_GET['name'];
            try {
                $dsn = 'mysql:dbname=server;host=localhost';
                $user = 'root';
                $password = '';
                $dbh = new PDO($dsn, $user, $password); //データベースに接続
                $dbh->query('SET NAMES utf8'); //文字コードのための設定
            
                $sql = "DELETE FROM server_table WHERE user = :user";
                $stmt = $dbh->prepare($sql);
                $data = array(':user' => $_GET['name']);
                $stmt->execute($data);
                $dbh = null; //データベースから切断
                header("Location: index.php"); //削除作業後に利用者管理画面に戻る
                exit();
            } catch (Exception $e) {
                print 'サーバが停止しておりますので暫くお待ちください。';
                exit();
            }
        }
                
    ?>

      <form method="post" action="">
        <div class="form-group">
          <input class="form-control" type="submit" name="delete" value="Yes">
        </div>
        <div class="form-group">
          <input class="form-control" type="button" value="No" onClick="location.href='index.php'">
        </div>
      </form>
    </div>
  </main>
  <footer>
  </footer>
</body>

</html>