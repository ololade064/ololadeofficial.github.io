<?php
require_once '_db.php';

$json = file_get_contents('php://input');
$params = json_decode($json);

$stmt = $db->prepare("UPDATE assignment SET assignment_start = :start, assignment_end = :end WHERE id = :id");
$stmt->bindParam(':start', $params->start);
$stmt->bindParam(':end', $params->end);
$stmt->bindParam(':id', $params->id);
$stmt->execute();

class Result {}

$response = new Result();
$response->result = 'OK';
$response->message = 'Updated, id: '.$params->id;
$response->id = $db->lastInsertId();

header('Content-Type: application/json');
echo json_encode($response);
