<?php
require_once 'config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Metode tidak diizinkan.']);
    exit;
}

$nama = trim($_POST['nama_lengkap'] ?? '');
$instansi = trim($_POST['instansi'] ?? '');
$jenis_kunjungan = $_POST['jenis_kunjungan'] ?? 'Bertamu';

if (empty($nama) || empty($instansi)) {
    echo json_encode(['status' => 'error', 'message' => 'Nama lengkap dan Instansi wajib diisi.']);
    exit;
}

$tujuan = '';
$keperluan = '';
$jenis_titipan = null;
$keterangan_titipan = null;
$status = 'berkunjung';

if ($jenis_kunjungan === 'Bertamu') {
    $tujuan = trim($_POST['tujuan_bertamu'] ?? '');
    $keperluan = trim($_POST['keperluan'] ?? '');
    if (empty($tujuan) || empty($keperluan)) {
        echo json_encode(['status' => 'error', 'message' => 'Tujuan dan Keperluan wajib diisi untuk tamu.']);
        exit;
    }
} else if ($jenis_kunjungan === 'Titip Barang') {
    $tujuan = trim($_POST['tujuan_titip'] ?? '');
    $jenis_titipan = trim($_POST['jenis_titipan'] ?? '');
    $keterangan_titipan = trim($_POST['keterangan_titipan'] ?? '');
    $keperluan = "Titip: " . $jenis_titipan; // fallback untuk legacy
    if (empty($tujuan) || empty($jenis_titipan)) {
        echo json_encode(['status' => 'error', 'message' => 'Penerima dan Jenis Titipan wajib diisi.']);
        exit;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Jenis kunjungan tidak valid.']);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO tamu (nama_lengkap, instansi, tujuan, keperluan, jenis_kunjungan, jenis_titipan, keterangan_titipan, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nama, $instansi, $tujuan, $keperluan, $jenis_kunjungan, $jenis_titipan, $keterangan_titipan, $status]);
    
    echo json_encode(['status' => 'success', 'message' => 'Data Anda telah tersimpan. Silakan tunggu atau hubungi resepsionis.']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
}
?>
