<?php
require_once 'config.php';
checkAuth();

// Get stats
$today = date('Y-m-d');
$firstDayOfMonth = date('Y-m-01');

// Total tamu bertamu hari ini
$stmtToday = $pdo->prepare("SELECT COUNT(*) FROM tamu WHERE DATE(waktu_masuk) = ? AND jenis_kunjungan = 'Bertamu'");
$stmtToday->execute([$today]);
$countToday = $stmtToday->fetchColumn();

// Total titipan hari ini
$stmtTitip = $pdo->prepare("SELECT COUNT(*) FROM tamu WHERE DATE(waktu_masuk) = ? AND jenis_kunjungan = 'Titip Barang'");
$stmtTitip->execute([$today]);
$countTitip = $stmtTitip->fetchColumn();

// Total bulan ini
$stmtMonth = $pdo->prepare("SELECT COUNT(*) FROM tamu WHERE DATE(waktu_masuk) >= ?");
$stmtMonth->execute([$firstDayOfMonth]);
$countMonth = $stmtMonth->fetchColumn();

// 5 Terakhir
$stmtRecent = $pdo->query("SELECT * FROM tamu ORDER BY waktu_masuk DESC LIMIT 5");
$recentGuests = $stmtRecent->fetchAll();

// Get Pending Packages (Titipan yang belum diberikan)
$stmtPendingPackages = $pdo->query("SELECT * FROM tamu WHERE jenis_kunjungan = 'Titip Barang' AND status = 'berkunjung' ORDER BY waktu_masuk ASC");
$pendingPackages = $stmtPendingPackages->fetchAll();

// ... existing queries
$stmtMax = $pdo->query("SELECT MAX(id) FROM tamu");
$maxId = (int)$stmtMax->fetchColumn();

require_once 'includes/header.php';
require_once 'includes/sidebar.php';
?>

<div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between">
    <div>
        <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-800 tracking-tight">Dashboard Utama</h1>
        <p class="text-slate-500 mt-2 text-sm">Pantau aktivitas tamu dan inventaris hari ini.</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="tambah_tamu.php" class="inline-flex items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/30 transition-all duration-200">
            <i class="fas fa-plus mr-2"></i> Tambah Data
        </a>
    </div>
</div>

<?php if (count($pendingPackages) > 0): ?>
<div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-2xl shadow-sm mb-8 flex flex-col md:flex-row md:items-start md:justify-between gap-4 animate-pulse-slow relative overflow-hidden">
    <div class="absolute -right-4 -bottom-4 text-red-100 opacity-50">
        <i class="fas fa-exclamation-circle text-8xl"></i>
    </div>
    <div class="relative z-10 flex-1">
        <div class="flex items-center mb-3">
            <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center mr-3">
                <i class="fas fa-box-open"></i>
            </div>
            <h2 class="text-lg font-bold text-red-800">PERHATIAN: Ada <?= count($pendingPackages) ?> Barang Titipan Belum Diserahkan!</h2>
        </div>
        <p class="text-sm text-red-700 font-medium mb-4">Mohon segera cek dan serahkan paket berikut ke penerima, atau update lokasi penyimpanannya agar mudah ditemukan admin shift berikutnya.</p>
        
        <div class="bg-white/60 rounded-xl overflow-hidden border border-red-100">
            <table class="w-full text-sm text-left">
                <thead class="bg-red-100/50 text-red-800 text-xs uppercase font-bold">
                    <tr>
                        <th class="px-4 py-2">Penerima</th>
                        <th class="px-4 py-2">Barang</th>
                        <th class="px-4 py-2">Lokasi / Rak</th>
                        <th class="px-4 py-2 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-red-100/50">
                    <?php foreach($pendingPackages as $pkg): ?>
                    <tr>
                        <td class="px-4 py-3 font-semibold text-slate-800"><?= htmlspecialchars($pkg['tujuan']) ?></td>
                        <td class="px-4 py-3 text-slate-600"><?= htmlspecialchars($pkg['jenis_titipan']) ?></td>
                        <td class="px-4 py-3 font-bold text-blue-700">
                            <?= $pkg['lokasi_penyimpanan'] ? '<i class="fas fa-map-marker-alt mr-1"></i> ' . htmlspecialchars($pkg['lokasi_penyimpanan']) : '<span class="text-red-500 italic font-normal">Belum di-set!</span>' ?>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button onclick="setLokasi(<?= $pkg['id'] ?>, '<?= htmlspecialchars($pkg['lokasi_penyimpanan'] ?? '') ?>')" class="text-xs bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 px-3 py-1.5 rounded-lg font-bold shadow-sm mr-2 transition-colors">Set Lokasi</button>
                            <a href="daftar_tamu.php?checkout_id=<?= $pkg['id'] ?>" onclick="return confirm('Serahkan paket ini sekarang?')" class="text-xs bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg font-bold shadow-sm shadow-red-500/30 transition-colors">Selesai</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="grid grid-cols-3 gap-2 sm:gap-4 mb-8">
    <!-- Card 1 -->
    <div class="relative bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl sm:rounded-2xl p-3 sm:p-5 shadow-lg shadow-blue-900/10 overflow-hidden group">
        <div class="hidden sm:block absolute -right-4 -top-4 text-white/10 transform group-hover:scale-110 group-hover:rotate-12 transition-transform duration-500">
            <i class="fas fa-users text-7xl"></i>
        </div>
        <div class="relative z-10 text-white flex flex-col justify-between h-full">
            <div class="flex items-center justify-between mb-2 sm:mb-3">
                <div class="w-7 h-7 sm:w-10 sm:h-10 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/20">
                    <i class="fas fa-user-clock text-[10px] sm:text-lg"></i>
                </div>
                <span class="hidden sm:inline-block text-[10px] font-semibold px-2.5 py-1 bg-white/20 rounded-full tracking-wider">HARI INI</span>
            </div>
            <div>
                <h3 class="text-[9px] sm:text-xs font-medium text-blue-100 mb-0.5 opacity-90 leading-tight">Tamu Masuk</h3>
                <div class="text-xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight"><?= $countToday ?></div>
            </div>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="relative bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl sm:rounded-2xl p-3 sm:p-5 shadow-lg shadow-orange-900/10 overflow-hidden group">
        <div class="hidden sm:block absolute -right-4 -top-4 text-white/10 transform group-hover:scale-110 group-hover:rotate-12 transition-transform duration-500">
            <i class="fas fa-box-open text-7xl"></i>
        </div>
        <div class="relative z-10 text-white flex flex-col justify-between h-full">
            <div class="flex items-center justify-between mb-2 sm:mb-3">
                <div class="w-7 h-7 sm:w-10 sm:h-10 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/20">
                    <i class="fas fa-dolly text-[10px] sm:text-lg"></i>
                </div>
                <span class="hidden sm:inline-block text-[10px] font-semibold px-2.5 py-1 bg-white/20 rounded-full tracking-wider">HARI INI</span>
            </div>
            <div>
                <h3 class="text-[9px] sm:text-xs font-medium text-orange-100 mb-0.5 opacity-90 leading-tight">Titipan</h3>
                <div class="text-xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight"><?= $countTitip ?></div>
            </div>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="relative bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl sm:rounded-2xl p-3 sm:p-5 shadow-lg shadow-teal-900/10 overflow-hidden group">
        <div class="hidden sm:block absolute -right-4 -top-4 text-white/10 transform group-hover:scale-110 group-hover:rotate-12 transition-transform duration-500">
            <i class="fas fa-chart-line text-7xl"></i>
        </div>
        <div class="relative z-10 text-white flex flex-col justify-between h-full">
            <div class="flex items-center justify-between mb-2 sm:mb-3">
                <div class="w-7 h-7 sm:w-10 sm:h-10 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/20">
                    <i class="fas fa-calendar-check text-[10px] sm:text-lg"></i>
                </div>
                <span class="hidden sm:inline-block text-[10px] font-semibold px-2.5 py-1 bg-white/20 rounded-full tracking-wider">BULAN INI</span>
            </div>
            <div>
                <h3 class="text-[9px] sm:text-xs font-medium text-teal-100 mb-0.5 opacity-90 leading-tight">Total Bulan Ini</h3>
                <div class="text-xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight"><?= $countMonth ?></div>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-[1.5rem] shadow-[0_5px_20px_rgba(0,0,0,0.02)] border border-slate-100 overflow-hidden mb-8">
    <div class="px-7 py-6 border-b border-slate-100 flex justify-between items-center bg-white">
        <div>
            <h3 class="font-bold text-lg text-slate-800">Aktivitas Terakhir</h3>
            <p class="text-xs text-slate-500 mt-1">Menampilkan 5 entri data terbaru.</p>
        </div>
        <a href="daftar_tamu.php" class="text-sm text-blue-600 hover:text-blue-800 font-bold bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-xl transition-colors">Lihat Semua &rarr;</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-400 text-xs uppercase tracking-widest font-bold">
                    <th class="px-7 py-4 border-b border-slate-100">Profil</th>
                    <th class="px-7 py-4 border-b border-slate-100">Layanan</th>
                    <th class="px-7 py-4 border-b border-slate-100">Tujuan & Keterangan</th>
                    <th class="px-7 py-4 border-b border-slate-100">Waktu</th>
                </tr>
            </thead>
            <tbody class="text-slate-700 text-sm">
                <?php if (empty($recentGuests)): ?>
                    <tr>
                        <td colspan="4" class="px-7 py-10 text-center text-slate-400 font-medium">Belum ada aktivitas tercatat hari ini.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($recentGuests as $guest): ?>
                    <tr class="hover:bg-slate-50/80 transition-colors border-b border-slate-50 last:border-0 group">
                        <td class="px-7 py-5">
                            <div class="font-bold text-slate-800"><?= htmlspecialchars($guest['nama_lengkap']) ?></div>
                            <div class="text-xs text-slate-500 mt-1 flex items-center"><i class="far fa-building mr-1.5"></i> <?= htmlspecialchars($guest['instansi']) ?></div>
                        </td>
                        <td class="px-7 py-5">
                            <?php if ($guest['jenis_kunjungan'] == 'Bertamu'): ?>
                                <span class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold border border-blue-100"><i class="fas fa-users mr-1.5 text-blue-500"></i> Bertamu</span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-3 py-1 bg-orange-50 text-orange-600 rounded-lg text-xs font-bold border border-orange-100"><i class="fas fa-box mr-1.5 text-orange-500"></i> Titip Barang</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-7 py-5">
                            <div class="font-semibold text-slate-700"><?= htmlspecialchars($guest['tujuan']) ?></div>
                            <div class="text-xs text-slate-500 mt-1 line-clamp-1" title="<?= htmlspecialchars($guest['keperluan']) ?>"><?= htmlspecialchars($guest['keperluan']) ?></div>
                        </td>
                        <td class="px-7 py-5 whitespace-nowrap">
                            <div class="font-medium text-slate-600"><?= date('d M Y', strtotime($guest['waktu_masuk'])) ?></div>
                            <div class="text-xs text-slate-400 mt-1"><?= date('H:i', strtotime($guest['waktu_masuk'])) ?> WIB</div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
let lastId = <?= $maxId ?>;

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

setInterval(async () => {
    try {
        const res = await fetch(`api_check_notif.php?last_id=${lastId}`);
        const data = await res.json();
        
        if (data.new_guests && data.new_guests.length > 0) {
            lastId = data.new_guests[0].id;
            
            const btn = document.querySelector('button[onclick="toggleNotif()"]');
            let badge = document.getElementById('notifBadge');
            if (badge) {
                badge.classList.add('animate-pulse', 'bg-red-500');
                badge.classList.remove('bg-slate-300');
            } else if (btn) {
                const newBadge = document.createElement('span');
                newBadge.id = 'notifBadge';
                newBadge.className = 'absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full animate-pulse';
                btn.appendChild(newBadge);
            }
            
            const container = document.getElementById('notifListContainer');
            if(container) {
                // hide empty text if visible
                const emptyHidden = document.getElementById('emptyNotifHidden');
                if(emptyHidden) emptyHidden.classList.add('hidden');
                const emptyNotif = document.getElementById('emptyNotif');
                if(emptyNotif) emptyNotif.classList.add('hidden');
                
                let dismissedNotifs = JSON.parse(localStorage.getItem('dismissedNotifs') || '[]');
                
                data.new_guests.reverse().forEach(g => {
                    if (dismissedNotifs.includes(g.id.toString())) return;
                    
                    const iconBg = g.jenis_kunjungan === 'Bertamu' ? 'bg-blue-100 text-blue-500' : 'bg-orange-100 text-orange-500';
                    const iconType = g.jenis_kunjungan === 'Bertamu' ? 'fa-users' : 'fa-box';
                    
                    const el = document.createElement('div');
                    el.className = 'px-5 py-4 border-b border-slate-50 hover:bg-slate-50 transition-colors flex items-start group notif-item';
                    el.dataset.id = g.id;
                    el.innerHTML = `
                        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 mt-0.5 ${iconBg}">
                            <i class="fas ${iconType} text-xs"></i>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-semibold text-slate-800 leading-tight">${g.nama_lengkap}</p>
                            <p class="text-xs text-slate-500 mt-0.5">Menunggu: ${g.tujuan}</p>
                            <p class="text-[10px] text-slate-400 mt-1"><i class="far fa-clock mr-1"></i> Baru saja</p>
                        </div>
                        <button onclick="removeNotif(this, '${g.id}')" class="text-slate-300 hover:text-red-500 transition-colors p-1 opacity-0 group-hover:opacity-100" title="Hapus Notif">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    container.insertBefore(el, container.firstChild);
                });
                
                // update count text
                if (typeof updateNotifUI === 'function') {
                    updateNotifUI();
                } else {
                    const currentCountText = document.getElementById('notifCountText');
                    if(currentCountText) {
                        const count = container.querySelectorAll('.notif-item').length;
                        currentCountText.innerText = count + ' Baru';
                    }
                }
            }
            
            // Auto reload the dashboard if there are new Titipan items so they show up in the main alert box
            if (data.new_guests.some(g => g.jenis_kunjungan === 'Titip Barang')) {
                setTimeout(() => location.reload(), 2000);
            }
        }
    } catch (e) {
        console.error('Polling error', e);
    }
}, 3000); // Poll every 3 seconds
</script>

<?php require_once 'includes/footer.php'; ?>
