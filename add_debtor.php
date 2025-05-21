<?php
require_once(__DIR__ . '/../db.php');

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->name) || !isset($data->amount)) {
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}

// Default paid = 0 if not sent
$paid = isset($data->paid) ? floatval($data->paid) : 0.0;

// Determine status based on paid amount
$status = ($paid >= $data->amount) ? 'paid' : 'unpaid';

try {
    $stmt = $pdo->prepare("INSERT INTO debtors (name, amount, paid, status) VALUES (?, ?, ?, ?)");
    $stmt->execute([$data->name, $data->amount, $paid, $status]);
    
    // Get last inserted debtor
    $id = $pdo->lastInsertId();
    $stmt = $pdo->prepare("SELECT * FROM debtors WHERE id = ?");
    $stmt->execute([$id]);
    $newDebtor = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($newDebtor);

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
