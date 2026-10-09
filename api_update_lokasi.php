<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $lokasi = trim($_POST['lokasi'] ?? '');

    if ($id && $lokasi !== '') {
        $stmt = $pdo->prepare("UPDATE tamu SET lokasi_penyimpanan = ? WHERE id = ?");
        $stmt->execute([$lokasi, $id]);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid data']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid method']);
}
