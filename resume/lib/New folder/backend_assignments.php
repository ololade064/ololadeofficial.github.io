<?php
require_once '_db.php';

$stmt = $db->prepare("SELECT * FROM assignment WHERE NOT ((assignment_end <= :start) OR (assignment_start >= :end))");
$stmt->bindParam(':start', $_GET['start']);
$stmt->bindParam(':end', $_GET['end']);
$stmt->execute();
$result = $stmt->fetchAll();

class Event {}
$events = array();

$location = $_GET['location'];

foreach($result as $row) {
  $active = $row['location_id'] == $location;

  if ($active) {
    $e = new Event();
    $e->id = $row['id'];
    $e->text = "";
    $e->start = $row['assignment_start'];
    $e->end = $row['assignment_end'];
    $e->resource = $row['person_id'];

    $e->person = $row['person_id'];
    $e->location = $row['location_id'];
    $e->join = $row['id'];
    $events[] = $e;

    $e = new Event();
    $e->id = "L".$row['id'];
    $e->text = "";
    $e->start = $row['assignment_start'];
    $e->end = $row['assignment_end'];
    $e->resource = 'L'.$row['location_id'];

    $e->person = $row['person_id'];
    $e->location = $row['location_id'];
    $e->type = 'location';
    $e->join = $row['id'];
    $events[] = $e;
  }
  else {
    $e = new Event();
    $e->id = $row['id'];
    $e->text = "";
    $e->start = $row['assignment_start'];
    $e->end = $row['assignment_end'];
    $e->resource = $row['person_id'];

    $e->person = $row['person_id'];
    $e->location = $row['location_id'];
    $e->type = 'inactive';
    $e->join = $row['id'];
    $events[] = $e;
  }
}

header('Content-Type: application/json');
echo json_encode($events);
