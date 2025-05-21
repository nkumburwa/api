<?php
require_once(__DIR__ . '/../db.php');

// Parse raw DELETE input into $_DELETE array
parse_str(file_get_contents("php://input"), $_DELETE);
$id = $_DELETE['id'] ?? null;

if (!$id) {
    echo json_encode(['error' => 'Missing debtor ID']);
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM debtors WHERE id = ?");
    $stmt->execute([$id]);

    // Check if a row was actually deleted
    if ($stmt->rowCount() > 0) {
        echo json_encode(['message' => 'Debtor deleted successfully']);
    } else {
        echo json_encode(['error' => 'Debtor not found or already deleted']);
    }

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
