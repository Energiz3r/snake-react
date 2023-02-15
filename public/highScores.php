<?php
session_start();
$data = json_decode(file_get_contents("php://input"), true);
if(isset($data['newScore']) and isset($data['name'])){
    
    $name = preg_replace("/[^a-zA-Z]/", "", $data['name']);
    $newScore = preg_replace('/[^0-9]/', '', $data['newScore']);
    if (strlen($name) < 1 or !is_numeric($newScore)) {
        echo('invalid params!');
        return;
    }
    
    echo("Setting new score ". $name . " " . $newScore);
    
    $content = file_get_contents('./highscores.txt');
    $scores = json_decode($content, true);
    $position = "none";
    
    if ($newScore >= $scores["third"][1]) { $position = "third"; }
    if ($newScore >= $scores["second"][1]) { $position = "second"; }
    if ($newScore >= $scores["first"][1]) { $position = "first"; }
    if ($position === "none") { return; }
    
    if ($position === "first") {
        echo("new first place score");
        $scores["third"] = $scores["second"];
        $scores["second"] = $scores["first"];
        $scores["first"] = array($name, $newScore);
    } elseif ($position === "second") {
        echo("new second place score");
        $scores["third"] = $scores["second"];
        $scores["second"] = array($name, $newScore);
    } elseif ($position === "third") {
        echo("new third place score");
        $scores["third"] = array($name, $newScore);
    }
    
    $scoreJson = json_encode($scores);
    file_put_contents('./highscores.txt', $scoreJson);
    echo("Updated scores!");
    
} elseif (isset($_POST['defaultScores'])) {
    $defaultScores = array(
        "first" => array("Tim", 250),
        "second" => array("nobody", 0),
        "third" => array("nobody", 0)
    );
    $scoreJson = json_encode($defaultScores);
    file_put_contents('./highscores.txt', $scoreJson);
    echo("Defaulted the scores!");
} else { 
    echo("missing params!");
}
