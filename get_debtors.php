<?php
require_once(__DIR__ . '/../db.php');

try {
    $stmt = $pdo->query("SELECT id, name, amount, paid, status FROM debtors ORDER BY id DESC");
    $debtors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($debtors);

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
