<?php
require_once '_db.php';

$stmt = $db->prepare("SELECT * FROM person ORDER BY name");
$stmt->execute();
$people = $stmt->fetchAll();

class Item {}

$result = array();

foreach($people as $person) {
  $r = new Item();
  $r->id = $person['id'];
  $r->name = $person['name'];
  $result[] = $r;
  
}

header('Content-Type: application/json');
echo json_encode($result);
