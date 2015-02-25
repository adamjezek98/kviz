<!DOCTYPE html>


<html lang="cs-cz">

<head>
    <meta charset="utf-8" />
    <title>Quiz Home</title>
</head>

<body>

<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 24. 2. 2015
 * Time: 21:33
 */
$connection = new PDO("mysql:host=localhost;dbname=quizDB",'root','');
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$connection->query("SET NAMES utf8");
$command = $connection->prepare("SELECT * FROM quizes ");
$command->execute();

//$res = $command->setFetchMode(PDO::FETCH_ASSOC);
echo "";
echo "<table border='2'>";
echo "<tr><th>#</th><th>Kvíz</th><th><a href=\"leaderboard.php\">Vysledky</a></th></tr>" ;

foreach($command as $quiz)
{
    echo "<tr><td>" . $quiz["ID"] . '</td><td><a href="quiz.php?id='.$quiz["ID"] . '">';
    echo $quiz["quizName"]. "</a></td><td><a href=\"leaderboard.php?id=".$quiz["ID"]."\">Vysledky</a></td></tr>";
}


?>




</body>