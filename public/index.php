<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="icon" href="%PUBLIC_URL%/favicon.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="theme-color" content="#000000" />
  <meta name="description" content="Web site created using create-react-app" />
  <link rel="apple-touch-icon" href="%PUBLIC_URL%/logo192.png" />
  <link rel="manifest" href="%PUBLIC_URL%/manifest.json" />
  <title>Snakey Snake</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Supermercado+One&display=swap" rel="stylesheet">
</head>

<body>
  <div id="root"></div>
  <?php
  session_start();
  if (empty($_SESSION['site-visited'])) {
    $counter = file_get_contents('./visits.txt') + 1;
    file_put_contents('./visits.txt', $counter);
  }
  $_SESSION['site-visited'] = true;

  $visitCounter = file_get_contents('./visits.txt');
  echo ("<script>window.pageVisits = " . $visitCounter . ";</script>");

  $content = file_get_contents('./highscores.txt');
  $scores = json_decode($content);
  echo ("<script>window.highScores = {");
  foreach ($scores as $key => $value) {
    echo ($key . ":{name:'" . $value[0] . "',score:" . $value[1] . "},");
  }
  echo ("}</script>");
  ?>
</body>

</html>