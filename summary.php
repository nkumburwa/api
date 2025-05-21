<?php
require_once(__DIR__ . '/../db.php');

try {
    $stmt = $pdo->query("SELECT 
        COUNT(*) as total_debtors, 
        SUM(amount) as total_amount, 
        SUM(paid) as total_paid 
        FROM debtors");
    $summary = $stmt->fetch(PDO::FETCH_ASSOC);

    $totalDebtors = intval($summary['total_debtors'] ?? 0);
    $totalAmount = floatval($summary['total_amount'] ?? 0);
    $totalPaid = floatval($summary['total_paid'] ?? 0);
    $totalUnpaid = $totalAmount - $totalPaid;

    // Dusubize array yuzuye
    $result = [
        'total_debtors' => $totalDebtors,
        'total_amount' => $totalAmount,
        'total_paid' => $totalPaid,
        'total_unpaid' => $totalUnpaid > 0 ? $totalUnpaid : 0
    ];

    echo json_encode($result);

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
