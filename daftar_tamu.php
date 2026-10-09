<?php
require_once 'config.php';
checkAuth();

// Process checkout if requested
if (isset($_GET['checkout_id'])) {
    $checkout_id = (int)$_GET['checkout_id'];
    $stmt = $pdo->prepare("UPDATE tamu SET status = 'selesai', waktu_keluar = CURRENT_TIMESTAMP WHERE id = ?");
    $stmt->execute([$checkout_id]);
    header("Location: daftar_tamu.php?msg=checkout_success");
    exit;
}

// Search and Filter
$search = $_GET['search'] ?? '';
$date = $_GET['date'] ?? '';
$jenis = $_GET['jenis'] ?? '';
$status = $_GET['status'] ?? '';

$query = "SELECT * FROM tamu WHERE 1=1";
$params = [];

if ($search) {
    $query .= " AND (nama_lengkap LIKE ? OR instansi LIKE ? OR tujuan LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if ($date) {
    $query .= " AND DATE(waktu_masuk) = ?";
    $params[] = $date;
}

if ($jenis) {
    $query .= " AND jenis_kunjungan = ?";
    $params[] = $jenis;
}

if ($status) {
    $query .= " AND status = ?";
    $params[] = $status;
}

$query .= " ORDER BY waktu_masuk DESC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$guests = $stmt->fetchAll();

require_once 'includes/header.php';
require_once 'includes/sidebar.php';
?>

<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-800 tracking-tight">Daftar Tamu</h1>
        <p class="text-slate-500 mt-2 text-sm">Kelola dan pantau seluruh data kunjungan Universitas Ma'soem.</p>
    </div>
    <a href="tambah_tamu.php" class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/30 transition-all duration-200">
        <i class="fas fa-plus mr-2"></i> Tambah Data
    </a>
</div>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'checkout_success'): ?>
    <div class="bg-emerald-50 text-emerald-700 p-4 rounded-xl mb-6 flex items-start border border-emerald-200">
        <i class="fas fa-check-circle text-xl mr-3 mt-0.5"></i>
        <div>
            <h4 class="font-bold">Berhasil!</h4>
            <p class="text-sm mt-0.5">Status tamu berhasil diperbarui menjadi Selesai (Checkout).</p>
        </div>
    </div>
<?php endif; ?>

<div class="bg-white rounded-[1.5rem] shadow-[0_5px_20px_rgba(0,0,0,0.02)] border border-slate-100 overflow-hidden mb-10">
    <!-- Filter Section -->
    <div class="p-6 border-b border-slate-100 bg-white">
        <form method="GET" action="" class="flex flex-col xl:flex-row gap-4">
            
            <div class="flex-grow">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-slate-400"></i>
                    </div>
                    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="w-full pl-11 pr-4 py-3 rounded-xl border-2 border-slate-100 focus:border-blue-500 focus:bg-white outline-none transition-all text-sm text-slate-700 font-medium bg-slate-50" placeholder="Cari nama, instansi, atau tujuan...">
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="w-full sm:w-44 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="far fa-calendar-alt text-slate-400"></i>
                    </div>
                    <input type="date" name="date" value="<?= htmlspecialchars($date) ?>" class="w-full pl-11 pr-4 py-3 rounded-xl border-2 border-slate-100 focus:border-blue-500 focus:bg-white outline-none transition-all text-sm text-slate-700 font-medium bg-slate-50 text-slate-500">
                </div>

                <div class="w-full sm:w-44 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                        <i class="fas fa-filter text-slate-400"></i>
                    </div>
                    <select name="jenis" class="w-full pl-11 pr-8 py-3 rounded-xl border-2 border-slate-100 focus:border-blue-500 focus:bg-white outline-none transition-all text-sm text-slate-700 font-medium bg-slate-50 appearance-none cursor-pointer">
                        <option value="">Semua Kunjungan</option>
                        <option value="Bertamu" <?= $jenis === 'Bertamu' ? 'selected' : '' ?>>Bertamu</option>
                        <option value="Titip Barang" <?= $jenis === 'Titip Barang' ? 'selected' : '' ?>>Titipan</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                        <i class="fas fa-chevron-down text-[10px]"></i>
                    </div>
                </div>

                <div class="w-full sm:w-44 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                        <i class="fas fa-tasks text-slate-400"></i>
                    </div>
                    <select name="status" class="w-full pl-11 pr-8 py-3 rounded-xl border-2 border-slate-100 focus:border-blue-500 focus:bg-white outline-none transition-all text-sm text-slate-700 font-medium bg-slate-50 appearance-none cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="berkunjung" <?= $status === 'berkunjung' ? 'selected' : '' ?>>Aktif (Berkunjung)</option>
                        <option value="selesai" <?= $status === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                        <i class="fas fa-chevron-down text-[10px]"></i>
                    </div>
                </div>

                <div class="flex space-x-3 w-full sm:w-auto">
                    <button type="submit" class="flex-1 sm:flex-none px-6 py-3 bg-slate-800 hover:bg-slate-900 text-white text-sm font-bold rounded-xl transition-colors shadow-lg shadow-slate-800/20 whitespace-nowrap">
                        Terapkan
                    </button>
                    <?php if ($search || $date || $jenis || $status): ?>
                        <a href="daftar_tamu.php" class="px-4 py-3 bg-red-50 hover:bg-red-100 text-red-600 text-sm font-bold rounded-xl transition-colors inline-flex items-center justify-center border border-red-100" title="Reset Filter">
                            <i class="fas fa-times"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

        </form>
    </div>

    <!-- Table Section -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-400 text-xs uppercase tracking-widest font-bold">
                    <th class="px-7 py-4 border-b border-slate-100">Info Pengunjung</th>
                    <th class="px-7 py-4 border-b border-slate-100">Tujuan & Keterangan</th>
                    <th class="px-7 py-4 border-b border-slate-100">Waktu</th>
                    <th class="px-7 py-4 border-b border-slate-100">Status</th>
                    <th class="px-7 py-4 border-b border-slate-100 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-slate-700 divide-y divide-slate-50">
                <?php if (empty($guests)): ?>
                    <tr>
                        <td colspan="5" class="px-7 py-16 text-center text-slate-400">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                                <i class="fas fa-inbox text-3xl text-slate-300"></i>
                            </div>
                            <p class="font-medium text-slate-500">Belum ada data tamu yang ditemukan.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($guests as $guest): ?>
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-7 py-5">
                            <div class="font-bold text-slate-800 text-base"><?= htmlspecialchars($guest['nama_lengkap']) ?></div>
                            <div class="text-slate-500 text-xs mt-1 font-medium flex items-center"><i class="far fa-building mr-1.5"></i> <?= htmlspecialchars($guest['instansi']) ?></div>
                            
                            <div class="mt-2.5">
                                <?php if ($guest['jenis_kunjungan'] === 'Bertamu'): ?>
                                    <span class="inline-flex items-center px-2.5 py-1 bg-blue-50 text-blue-600 rounded-md text-[10px] font-bold border border-blue-100 uppercase tracking-wide"><i class="fas fa-users mr-1.5 text-blue-500"></i> Bertamu</span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-1 bg-orange-50 text-orange-600 rounded-md text-[10px] font-bold border border-orange-100 uppercase tracking-wide"><i class="fas fa-box mr-1.5 text-orange-500"></i> Titipan</span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="px-7 py-5">
                            <div class="font-bold text-slate-700">
                                <?php if ($guest['jenis_kunjungan'] === 'Titip Barang'): ?>
                                    Ke: <?= htmlspecialchars($guest['tujuan']) ?>
                                <?php else: ?>
                                    <?= htmlspecialchars($guest['tujuan']) ?>
                                <?php endif; ?>
                            </div>
                            <div class="text-slate-500 text-xs mt-1.5 leading-relaxed" title="<?= htmlspecialchars($guest['keperluan']) ?>">
                                <?php if ($guest['jenis_kunjungan'] === 'Titip Barang'): ?>
                                    <span class="font-semibold text-slate-600"><i class="fas fa-cube mr-1"></i> <?= htmlspecialchars($guest['jenis_titipan']) ?></span>
                                    <?php if($guest['keterangan_titipan']) echo "<br><span class='text-slate-400'>Resi/Ket:</span> " . htmlspecialchars($guest['keterangan_titipan']); ?>
                                    <?php if($guest['lokasi_penyimpanan']) echo "<br><span class='text-blue-600 font-bold'><i class='fas fa-map-marker-alt mr-1'></i> Lokasi: " . htmlspecialchars($guest['lokasi_penyimpanan']) . "</span>"; ?>
                                <?php else: ?>
                                    <span class="text-slate-500 line-clamp-2"><?= htmlspecialchars($guest['keperluan']) ?></span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="px-7 py-5 text-xs">
                            <div class="flex flex-col gap-2">
                                <div class="flex items-center bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                                    <i class="fas fa-sign-in-alt text-emerald-500 mr-2"></i>
                                    <div>
                                        <span class="text-slate-400 block text-[9px] uppercase tracking-wider font-bold">Masuk</span>
                                        <span class="font-semibold text-slate-700"><?= date('d/m/Y H:i', strtotime($guest['waktu_masuk'])) ?></span>
                                    </div>
                                </div>
                                <?php if ($guest['waktu_keluar']): ?>
                                    <div class="flex items-center bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                                        <i class="fas fa-sign-out-alt text-red-400 mr-2"></i>
                                        <div>
                                            <span class="text-slate-400 block text-[9px] uppercase tracking-wider font-bold">Keluar</span>
                                            <span class="font-semibold text-slate-700"><?= date('d/m/Y H:i', strtotime($guest['waktu_keluar'])) ?></span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="px-7 py-5">
                            <?php if ($guest['status'] === 'berkunjung'): ?>
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-600 border border-amber-200 shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-2 animate-pulse"></span> <?= $guest['jenis_kunjungan'] === 'Bertamu' ? 'Berkunjung' : 'Diproses' ?>
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200 shadow-sm">
                                    <i class="fas fa-check-circle mr-1.5 text-emerald-500"></i> Selesai
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-7 py-5 text-right">
                            <?php if ($guest['status'] === 'berkunjung'): ?>
                                <div class="flex flex-col items-end gap-2">
                                    <a href="?checkout_id=<?= $guest['id'] ?>" onclick="return confirm('Tandai data ini sudah selesai / tamu sudah keluar?')" class="inline-flex items-center px-4 py-2 bg-white border-2 border-slate-200 rounded-xl text-xs font-bold text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 transition-all shadow-sm hover:shadow group">
                                        Checkout <i class="fas fa-arrow-right ml-2 opacity-50 group-hover:opacity-100 group-hover:translate-x-1 transition-all"></i>
                                    </a>
                                    <?php if ($guest['jenis_kunjungan'] === 'Titip Barang'): ?>
                                    <button onclick="setLokasi(<?= $guest['id'] ?>, '<?= htmlspecialchars($guest['lokasi_penyimpanan'] ?? '') ?>')" class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg text-[10px] font-bold border border-blue-200 transition-colors">
                                        <i class="fas fa-map-pin mr-1.5"></i> <?= $guest['lokasi_penyimpanan'] ? 'Edit Lokasi' : 'Set Lokasi Barang' ?>
                                    </button>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-50 border border-slate-100 text-slate-300">
                                    <i class="fas fa-check"></i>
                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
async function setLokasi(id, currentLokasi) {
    const newLokasi = prompt("Masukkan detail lokasi penyimpanan barang (misal: Rak B1, Laci FO, dll):", currentLokasi);
    if (newLokasi !== null && newLokasi.trim() !== "") {
        const formData = new FormData();
        formData.append('id', id);
        formData.append('lokasi', newLokasi);
        
        try {
            const res = await fetch('api_update_lokasi.php', {
                method: 'POST',
                body: formData
            });
            const data = await res.json();
            if(data.success) {
                location.reload();
            } else {
                alert('Gagal mengupdate lokasi.');
            }
        } catch(e) {
            console.error(e);
            alert('Terjadi kesalahan jaringan.');
        }
    }
}
</script>

<?php require_once 'includes/footer.php'; ?>
