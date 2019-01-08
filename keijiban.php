<head>
<title>掲示板</title>
</head>
<body>
    <?php
        touch("comment.txt");
        if(empty($_POST["myname"])||empty($_POST["comment"]))
        {
            echo "<p>入力がありません、名前とコメントを入力してください</p>";

        }
        else
        {
            $fp = fopen("comment.txt", "a");
            fputs($fp, $_POST["myname"]. ",". $_POST["comment"]. PHP_EOL);
            echo "<p>". $_POST["myname"]. "さんが書き込みました</p>";
            $_GET["myname"] = "";
            fclose($fp);
        }
    ?>
    <ol>
        <?php
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
        <input type="submit" value="OK">
        </form>
    </div>
</body>