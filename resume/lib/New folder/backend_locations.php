<?php
require_once '_db.php';

//$json = file_get_contents('php://input');
//$params = json_decode($json);

$stmt = $db->prepare("SELECT * FROM location ORDER BY name");
$stmt->execute();
$locations = $stmt->fetchAll();

class Item {}

$result = array();

foreach($locations as $location) {
  $r = new Item();
  $r->id = $location['id'];
  $r->name = $location['name'];
  $result[] = $r;
  
}

header('Content-Type: application/json');
echo json_encode($result);
