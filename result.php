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
 * Date: 25. 2. 2015
 * Time: 12:50
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
if(! isset($_POST["answer1"]))
    exit;

$connection = new PDO("mysql:host=localhost;dbname=quizDB",'root','');
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$connection->query("SET NAMES utf8");

$command = $connection->prepare("SELECT COUNT(*) FROM questions WHERE quizID=$quizid");
$command->execute();
$questioncount = $command->fetchColumn();
echo "Počet otázek: " . $questioncount . "<br/>\n";

echo "Vyhodnocení: <br/>";

$points = 0;
$answerstring = "";
for($i = 0; $i < $questioncount; $i++ ) {
    $num = $i + 1;
    $useranswer = $_POST["answer" . $num]; //get user answer

    //get right answer
    $command = $connection->prepare("SELECT answer FROM questions WHERE quizID=$quizid and questionNumber = $num");
    $command->execute();
    $rightanswer = $command->fetchColumn();

    //get question text
    $command = $connection->prepare("SELECT questionName FROM questions WHERE quizID=$quizid and questionNumber = $num");
    $command->execute();
    $question = $command->fetchColumn();

    //get choiceA
    $command = $connection->prepare("SELECT choiceA FROM questions WHERE quizID=$quizid and questionNumber = $num");
    $command->execute();
    $choiceA = $command->fetchColumn();

    //get choiceB
    $command = $connection->prepare("SELECT choiceB FROM questions WHERE quizID=$quizid and questionNumber = $num");
    $command->execute();
    $choiceB = $command->fetchColumn();

    //get choiceC
    $command = $connection->prepare("SELECT choiceC FROM questions WHERE quizID=$quizid and questionNumber = $num");
    $command->execute();
    $choiceC = $command->fetchColumn();

    //get choiceD
    $command = $connection->prepare("SELECT choiceD FROM questions WHERE quizID=$quizid and questionNumber = $num");
    $command->execute();
    $choiceD = $command->fetchColumn();

    echo "Otázka č." . $num . ": " . $question . "<br/>";
    echo "Zvolil jsi $useranswer <br/> \n";
    $answerstring = $answerstring . $num . ":". $useranswer;
    if ($useranswer == $rightanswer) {
        echo "<font  color=\"green\">Správně!";
        $points++;
        $answerstring = $answerstring . "(Y) | ";
    } else {

        echo "<font  color=\"red\">Špatně! Správná odpověď byla $rightanswer";
        $answerstring = $answerstring . "(N:$rightanswer) | ";
    }

    echo "<ol><li>$choiceA</li><li>$choiceB</li><li>$choiceC</li><li>$choiceD</li></ol> \n";
    echo "</font>";

}
echo "<b>Máš $points bodů z $questioncount. <br/> ";
$result = (100*$points) / $questioncount;
echo "To je $result % </b><br/> \n";

$username = $_POST["username"];
$groupname = $_POST["groupname"];

$command = $connection->prepare("INSERT INTO
 answers (
quizID, userName, groupName, result, answers ) VALUES
 ($quizid,
  \"$username\",
  \"$groupname\"
  ,$result,
  \"$answerstring\")");

$command->execute();

?>
</body>