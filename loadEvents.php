<?php
// Read the JSON file
$jsonFile = 'sportData.json';
$jsonData = file_get_contents($jsonFile);
header('Content-Type: application/json');
echo $jsonData;
?>
