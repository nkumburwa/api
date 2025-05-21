<?php
require_once(__DIR__ . '/../db.php');

parse_str(file_get_contents("php://input"), $_PUT);

$id = $_PUT['id'] ?? null;
$name = $_PUT['name'] ?? null;
$amount = $_PUT['amount'] ?? null;
$paid = $_PUT['paid'] ?? 0;  // default 0 niba itoherejwe
$status = $_PUT['status'] ?? null;

if (!$id || !$name || !$amount || !$status) {
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE debtors SET name = ?, amount = ?, paid = ?, status = ? WHERE id = ?");
    $stmt->execute([$name, $amount, $paid, $status, $id]);
    echo json_encode(['message' => 'Debtor updated successfully']);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
