<?php
require_once 'config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$last_id = (int)($_GET['last_id'] ?? 0);

try {
    $stmt = $pdo->prepare("SELECT id, nama_lengkap, instansi, tujuan, jenis_kunjungan, waktu_masuk FROM tamu WHERE id > ? ORDER BY id DESC");
    $stmt->execute([$last_id]);
    $new_guests = $stmt->fetchAll();
    
    echo json_encode(['status' => 'success', 'new_guests' => $new_guests]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
