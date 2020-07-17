<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test ajax project</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js" crossorigin="anonymous"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/app.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <!--    <script type="text/javascript" src='js/ajax.js'></script>-->

</head>
<body>
<?php

function getArticles($pageNum)
{
    if(isset($_POST['1'])){
        $pageNum = 1;
    }elseif(isset($_POST['2'])){
        $pageNum = 2;
    }elseif(isset($_POST['3'])){
        $pageNum = 3;
    }
    $curl = curl_init();
    if ($pageNum == '') {
        $pageNum = 1;
    }

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://newsapi.org/v2/everything?q=Linux&language=en&sortBy=publishedAt&apiKey=6e6d9f7d53644208b1e46ea7b7a47eab&pageSize=30&page=" . $pageNum,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        if ($err){
            var_dump($err); exit;
        }
        curl_close($curl);
        $response = json_decode($response, true);
        if (isset($response['articles'])){
            return $response['articles'];
        } else {
            echo 'На данной странице нет статей, перейдите на страницу 1'.'<form method="post" action="index.php">
                <input class="page-num" name="1" type="submit" value="1"/>
            </form>'; exit;
        }


}
?>
<div class="container text-center">
    <div class="row" id="article-box">
                <?php foreach (getArticles(1) as $article): ?>
                <div class="article-wrapper col-lg-12">
                    <img class="col-lg-3 article-image" src="<?php echo $article['urlToImage'] ? $article['urlToImage'] : 'http://placehold.it/350x250' ?>">
                    <div class="col-lg-9 text-justify">
                        <a href="<?php echo $article['url'] ?>" class="article-title mt-2"
                           id="#article-title"><?php echo $article['title'] ?></a>
                        <div class="article-author mt-2"><?php echo $article['source']['name'] ?></div>
                        <div class="article-description mt-2"><?php echo strip_tags($article['description']) ?></div>
                        <div class="article-created mt-2"><?php echo $article['publishedAt'] ?></div>
                        <div class="article-content mt-2"><?php echo $article['content'] ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
    </div>
    <div class="pagination w-100">
        <div class="text-center" style="display: flex;">
            <form method="post" action="index.php">
                <input class="page-num" name="1" type="submit" value="1"/>
            </form>
            <form method="post">
                <input class="page-num" name="2" type="submit" value="2"/>
            </form>
            <form method="post">
                <input class="page-num" name="3" type="submit" value="3"/>
            </form>
        </div>
    </div>
</div>



</body>
</html>