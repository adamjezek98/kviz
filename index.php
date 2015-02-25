<!DOCTYPE html>


<html lang="cs-cz">

<head>
    <meta charset="utf-8" />
    <title>quiz test</title>
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

$res = $command->setFetchMode(PDO::FETCH_ASSOC);
echo "<table border='1'>";
echo "<tr><td>#</td><td>Kvíz</td></tr>" ;

foreach($command as $quiz)
{
    echo "<tr><td>" . $quiz["ID"] . '</td><td><a href="quiz.php?id='.$quiz["ID"] . '">';
    echo $quiz["quizName"]. "</a></td></tr>";
}


?>




</body>