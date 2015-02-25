<!DOCTYPE html>


<html lang="cs-cz">

<head>
    <meta charset="utf-8" />
    <title>Quiz Leaderboard</title>
</head>

<body>

<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 25. 2. 2015
 * Time: 19:16
 */

$connection = new PDO("mysql:host=localhost;dbname=quizDB",'root','');
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$connection->query("SET NAMES utf8");

$command = $connection->prepare("SELECT * FROM quizes");
$command->execute();
echo "Zobrazit výsledky pro:";
echo '<form method="GET" action="leaderboard.php">';
echo '<select name="id">'."\n";
foreach( $command as $res)
{
    $name = $res["quizName"];
    $id = $res["ID"];

    echo "<option value=\"$id\">".$name.'</option>'."\n";

}
echo "</select><br/><br/>";
echo '<input type="submit" value="Pošli"></input>';
echo '</form>';


if(isset($_GET["id"]) )
{
    $quizid = $_GET["id"];
    $command = $connection->prepare("SELECT quizName FROM quizes WHERE ID=$quizid "); //
    $command->execute();
    $res = $command->setFetchMode(PDO::FETCH_ASSOC);
    echo "<h2>Zobrazeny výsledky pro: " . $command->fetchColumn() . "</h2>";
    $command = $connection->prepare("SELECT * FROM answers WHERE quizID=$quizid ORDER BY result DESC");
    $command->execute();
    $order = 0;
    echo "<table border=\"1\">";
    echo "<tr><th>#</th><th>Výsledek</th><th>Jméno</th><th>Skupina</th><th>Odpovědi</th>";
    foreach( $command as $res)
    {
        $order++;
        echo "<tr><td>".$order."</td><td>".$res["result"]."</td><td>".$res["userName"]."</td><td>".$res["groupName"]."</td><td>".$res["answers"]."</td></tr>";
    }
}



?>
</body>