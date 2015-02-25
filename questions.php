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
 * Date: 23. 2. 2015
 * Time: 20:18
 */
$connection = new PDO("mysql:host=localhost;dbname=quizDB",'root','');
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
echo 'connected<br/>';
$connection->query("SET NAMES utf8");
/*
for($i = 3; $i < 30; $i++) {

    $command = $connection->prepare("INSERT INTO questions (quizName) VALUE (\"Testovací kvíz č. $i\")");
    $command->execute();
}
*/

$answers = array("A", "B", "C", "D");
for($i = 1; $i <= 30; $i++) {

    for($q = 1; $q <= 15; $q++) {
        $a =  $answers[rand(0, 3)];
        $command = $connection->prepare("INSERT INTO questions(quizID, questionName, questionNumber, choiceA, choiceB, choiceC, choiceD, answer) VALUES (
    $i,
    \"$q. testovací otázka kvízu $i, $a\",
    $q,
    \"Možnost A\",
    \"Možnost B\",
    \"Možnost C\",
    \"Možnost D\",
    \"$a\"
        )");
        $command->execute();

    }
}

exit;
$command = $connection->prepare("SELECT * FROM questions ");
$command->execute();

$res = $command->setFetchMode(PDO::FETCH_ASSOC);
echo "<table border='1'>";
echo "<tr><td>ID</td><td>quizID</td><td>questionName</td><td>questionNumber</td>" ;
echo "<td>choiceA</td><td>choiceB</td><td>choiceC</td><td>choiceD</td><td>answer</td></tr>";

foreach( $command as $v)
{
    echo "<tr><td>" . $v["ID"];
    echo "</td><td>" . $v["quizID"];
    echo "</td><td>" . $v["questionName"];
    echo "</td><td>" . $v["questionNumber"];
    echo "</td><td>" . $v["choiceA"];
    echo "</td><td>" . $v["choiceB"];
    echo "</td><td>" . $v["choiceC"];
    echo "</td><td>" . $v["choiceD"];
    echo "</td><td>" . $v["answer"];
    echo "</td></tr>";
}
echo "</table>";

?>




</body>