<!DOCTYPE html>
<html laong="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="sample.css">
<title>掲示板</title>
</head>
<body>
    <div class="top" style="text-align:center"><h1>掲示板</h1></div>
    <?php
        //セッション開始
        session_start();
        //名前とコメントのテキストを作成
        touch("comment.txt");
        //初めて入るときに書き込み失敗や入力がありませんと表示しないように
        if(isset($_SESSION)&&
        isset($_POST))
        {
            //連投防止のためにセクションで管理
            if($_SESSION['key']==$_POST['key'])
            {
                //名前とコメントが空白を確認
                if(empty($_POST["myname"])||empty($_POST["comment"]))
                {
                    echo "<p>入力がありません、名前とコメントを入力してください</p>";

                }
                else
                {
                    //メモ帳の末尾に書き込む
                    $fp = fopen("comment.txt", "a");
                    //テキストに名前とコメントを一行で保存
                    fputs($fp, $_POST["myname"]. ",". $_POST["comment"]. PHP_EOL);
                    echo "<p>". $_POST["myname"]. "さんが書き込みました</p>";
                    fclose($fp);
                }
            }
            else
            {
                echo "<p>書き込みに失敗しました</p>";
            }
        }
        // タイムスタンプと推測できない文字列にてキーを発行
        $key = md5(time()."推測できない文字列");
        // 発行したキーをセッションに保存
        $_SESSION['key'] = $key;
    ?>
    <ol>
        <?php
            //コメントを一覧表示
            $deta_file = 'comment.txt';
            $ext = file_exists($deta_file);
            $lines = $ext ? file($deta_file) : array(); 
            foreach($lines as $ln){
                $line = explode(",", $ln);
                echo "<li>\n";
                echo "<p>". $line[0]. "</p>";
                echo "<p>". $line[1]. "</p>";
                echo "</li>\n";
            }
        ?>
    </ol>
    <div align="left">
        <form action="keijiban.php" method="POST">
        <p>名前を入力:<input type="text" name="myname"></p>
        <p>コメント:<input type="text" name="comment"></p>
        <input type="hidden" name="key" value="<?= $key; ?>" />
        <input type="submit" value="OK">
        </form>
    </div>
</body>
</html>