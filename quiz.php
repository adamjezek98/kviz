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

if(isset($_GET["id"]) )
{
    $quizid = $_GET["id"];
    //echo "id: ".$quizid;
}
else
{
    $quizid = 5;
    //exit;
}

$connection = new PDO("mysql:host=localhost;dbname=quizDB",'root','');
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$connection->query("SET NAMES utf8");

$command = $connection->prepare("SELECT * FROM quizes WHERE ID=".$quizid);
$command->execute();
foreach( $command as $com) {
    echo "<h2>" . $com["quizName"] . "</h2>";
}

$command = $connection->prepare("SELECT * FROM questions WHERE quizID=".$quizid);
$command->execute();

$res = $command->setFetchMode(PDO::FETCH_ASSOC);
echo '<form method="POST" action="result.php?id='.$quizid.'">';
foreach( $command as $com)
{
    $qN = $com["questionNumber"];
    echo "<h3>".$com["questionNumber"].". ".$com["questionName"]."</h3>";

    echo '<select name="answer'.$qN.'">'."\n";
    echo '<option value="A">A</option>'."\n";
    echo '<option value="B">B</option>'."\n";
    echo '<option value="C">C</option>'."\n";
    echo '<option value="D">D</option>'."\n";
    echo "</select>";

    echo "<ol type='A'>";
    echo "<li>". $com["choiceA"]."</li>";
    echo "<li>". $com["choiceB"]."</li>";
    echo "<li>". $com["choiceC"]."</li>";
    echo "<li>". $com["choiceD"]."</li>";
    echo "</ol>"."\n";


}
echo "Jméno:   <input name=\"username\" type=\"text\"/><br/>";
echo "Skupina: <input name=\"groupName\" type=\"text\"/><br/>";
echo '<input type="submit" value="Pošli"></input>';
echo '</form>';



?>
</body>