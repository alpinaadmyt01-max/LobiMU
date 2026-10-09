<!-- Sidebar -->
<aside id="mobile-sidebar" class="w-64 bg-[#0f172a] text-slate-400 flex flex-col fixed inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition-transform duration-300 ease-in-out border-r border-slate-800 z-50 h-[100dvh]">
    <div class="h-16 flex items-center justify-between px-6 border-b border-slate-800/60 bg-[#0b1120]">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center shadow-lg p-1.5 shrink-0">
                <img src="assets/logo.png" alt="Logo" class="w-full h-full object-contain">
            </div>
            <h1 class="text-lg font-bold tracking-wider text-white">LOBI<span class="text-yellow-500 font-extrabold">.</span></h1>
        </div>
        <button onclick="toggleSidebar()" class="md:hidden text-slate-400 hover:text-white p-1 rounded-md focus:outline-none focus:ring-2 focus:ring-slate-600">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>
    
    <div class="px-5 py-5 text-[10px] font-bold tracking-widest text-slate-500 uppercase mb-1">Menu Utama</div>
    
    <nav class="flex-1 px-3 space-y-1">
        <?php $current_page = basename($_SERVER['PHP_SELF']); ?>
        <a href="dashboard.php" class="flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-300 <?= $current_page == 'dashboard.php' ? 'bg-blue-600 text-white shadow-md shadow-blue-900/20 font-medium' : 'hover:bg-slate-800/50 hover:text-slate-200' ?>">
            <i class="fas fa-chart-pie w-5 text-base <?= $current_page == 'dashboard.php' ? 'text-blue-200' : 'text-slate-500' ?>"></i>
            <span class="ml-3">Dashboard</span>
        </a>
        <a href="tambah_tamu.php" class="flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-300 <?= $current_page == 'tambah_tamu.php' ? 'bg-blue-600 text-white shadow-md shadow-blue-900/20 font-medium' : 'hover:bg-slate-800/50 hover:text-slate-200' ?>">
            <i class="fas fa-user-plus w-5 text-base <?= $current_page == 'tambah_tamu.php' ? 'text-blue-200' : 'text-slate-500' ?>"></i>
            <span class="ml-3">Tambah Data</span>
        </a>
        <a href="daftar_tamu.php" class="flex items-center px-4 py-3 text-sm rounded-xl transition-all duration-300 <?= $current_page == 'daftar_tamu.php' ? 'bg-blue-600 text-white shadow-md shadow-blue-900/20 font-medium' : 'hover:bg-slate-800/50 hover:text-slate-200' ?>">
            <i class="fas fa-users w-5 text-base <?= $current_page == 'daftar_tamu.php' ? 'text-blue-200' : 'text-slate-500' ?>"></i>
            <span class="ml-3">Daftar Tamu</span>
        </a>
    </nav>
    
    <div class="p-3 m-3 bg-slate-800/30 rounded-xl border border-slate-800">
        <div class="flex items-center space-x-3 mb-3 px-2">
            <div class="h-9 w-9 rounded-full bg-gradient-to-tr from-yellow-400 to-yellow-600 flex items-center justify-center text-white font-bold shadow-lg shrink-0 text-sm">
                <?= strtoupper(substr($_SESSION['nama_lengkap'] ?? 'U', 0, 1)) ?>
            </div>
            <div class="overflow-hidden">
                <p class="text-xs font-semibold text-white truncate"><?= htmlspecialchars($_SESSION['nama_lengkap'] ?? 'Administrator') ?></p>
                <p class="text-[9px] text-slate-500 uppercase tracking-wider">Admin Panel</p>
            </div>
        </div>
        <a href="logout.php" class="flex items-center justify-center w-full px-3 py-2 text-xs font-semibold text-red-400 bg-red-400/10 hover:bg-red-500 hover:text-white rounded-lg transition-all duration-300">
            <i class="fas fa-sign-out-alt mr-2"></i> Keluar
        </a>
    </div>
</aside>

<!-- Overlay for mobile sidebar -->
<div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 hidden transition-opacity duration-300 opacity-0"></div>

<!-- Main Content Wrapper -->
<div class="flex-1 flex flex-col h-[100dvh] overflow-hidden bg-[#f8fafc]">
    <!-- Topbar -->
    <header class="h-16 bg-white/80 backdrop-blur-xl shadow-sm border-b border-slate-200/60 flex items-center justify-between px-4 lg:px-8 z-10 sticky top-0 shrink-0">
        <div class="flex items-center">
            <button onclick="toggleSidebar()" class="md:hidden text-slate-500 hover:text-blue-600 focus:outline-none transition-colors p-2 -ml-1 rounded-lg hover:bg-slate-100 focus:ring-2 focus:ring-blue-100">
                <i class="fas fa-bars text-lg"></i>
            </button>
            
            <div class="hidden md:flex flex-col ml-3">
                <h2 class="text-lg font-bold text-slate-800 leading-tight">Selamat Datang, <?= htmlspecialchars(explode(' ', $_SESSION['nama_lengkap'] ?? 'Admin')[0]) ?>!</h2>
                <p class="text-[10px] text-slate-500 font-medium">Universitas Ma'soem Dashboard</p>
            </div>
        </div>
        
        <div class="flex items-center space-x-5 md:space-x-6">
            <!-- Time Indicator -->
            <div class="hidden sm:flex items-center px-4 py-2 bg-slate-50 border border-slate-100 rounded-full text-xs font-semibold text-slate-600 shadow-inner">
                <i class="far fa-calendar-alt text-blue-500 mr-2"></i>
                <?= date('d M Y') ?>
            </div>
            
            <!-- Notification Bell -->
            <?php
            // Ambil notifikasi dari tamu yang masih berkunjung
            $stmtNotif = $pdo->query("SELECT id, nama_lengkap, jenis_kunjungan, tujuan, waktu_masuk FROM tamu WHERE status = 'berkunjung' ORDER BY waktu_masuk DESC LIMIT 5");
            $notifList = $stmtNotif->fetchAll();
            $notifCount = count($notifList);
            ?>
            <div class="relative" id="notifWrapper">
                <button onclick="toggleNotif()" class="relative p-2 text-slate-400 hover:text-blue-600 transition-colors rounded-full hover:bg-blue-50 focus:outline-none">
                    <i class="fas fa-bell text-xl"></i>
                    <?php if ($notifCount > 0): ?>
                    <span id="notifBadge" class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full animate-pulse"></span>
                    <?php endif; ?>
                </button>
                
                <!-- Dropdown -->
                <div id="notifDropdown" class="hidden absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.1)] border border-slate-100 overflow-hidden z-50 transform origin-top-right transition-all">
                    <div class="px-5 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <h3 class="font-bold text-slate-800">Notifikasi</h3>
                        <span class="text-xs bg-blue-100 text-blue-700 font-bold px-2 py-0.5 rounded-full" id="notifCountText"><?= $notifCount ?> Baru</span>
                    </div>
                    <div class="max-h-80 overflow-y-auto" id="notifListContainer">
                        <?php if ($notifCount > 0): ?>
                            <?php foreach ($notifList as $n): ?>
                            <div class="px-5 py-4 border-b border-slate-50 hover:bg-slate-50 transition-colors flex items-start group notif-item" data-id="<?= $n['id'] ?>">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 mt-0.5 <?= $n['jenis_kunjungan'] == 'Bertamu' ? 'bg-blue-100 text-blue-500' : 'bg-orange-100 text-orange-500' ?>">
                                    <i class="fas <?= $n['jenis_kunjungan'] == 'Bertamu' ? 'fa-users' : 'fa-box' ?> text-xs"></i>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm font-semibold text-slate-800 leading-tight"><?= htmlspecialchars($n['nama_lengkap']) ?></p>
                                    <p class="text-xs text-slate-500 mt-0.5">Menunggu: <?= htmlspecialchars($n['tujuan']) ?></p>
                                    <p class="text-[10px] text-slate-400 mt-1"><i class="far fa-clock mr-1"></i> <?= date('H:i', strtotime($n['waktu_masuk'])) ?> WIB</p>
                                </div>
                                <button onclick="removeNotif(this, '<?= $n['id'] ?>')" class="text-slate-300 hover:text-red-500 transition-colors p-1 opacity-0 group-hover:opacity-100" title="Hapus Notif">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="px-5 py-8 text-center text-slate-400" id="emptyNotif">
                                <i class="fas fa-bell-slash text-3xl mb-3 text-slate-200"></i>
                                <p class="text-sm font-medium">Belum ada notifikasi baru.</p>
                            </div>
                        <?php endif; ?>
                        <div class="hidden px-5 py-8 text-center text-slate-400" id="emptyNotifHidden">
                            <i class="fas fa-check-circle text-3xl mb-3 text-emerald-200"></i>
                            <p class="text-sm font-medium">Semua notifikasi telah dibaca.</p>
                        </div>
                    </div>
                </div>
            </div>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Sembunyikan notif yang sudah dihapus sebelumnya
                let dismissedNotifs = JSON.parse(localStorage.getItem('dismissedNotifs') || '[]');
                document.querySelectorAll('.notif-item').forEach(item => {
                    if (dismissedNotifs.includes(item.dataset.id)) {
                        item.remove();
                    }
                });
                updateNotifUI();
            });

            function updateNotifUI() {
                const container = document.getElementById('notifListContainer');
                if (!container) return;
                
                const remaining = container.querySelectorAll('.notif-item').length;
                const countText = document.getElementById('notifCountText');
                if (countText) countText.innerText = remaining + ' Baru';
                
                if (remaining === 0) {
                    const badge = document.getElementById('notifBadge');
                    if(badge) badge.remove(); // Hapus dot merah
                    
                    const emptyHidden = document.getElementById('emptyNotifHidden');
                    if (emptyHidden) emptyHidden.classList.remove('hidden');
                    const emptyNotif = document.getElementById('emptyNotif');
                    if(emptyNotif) emptyNotif.classList.add('hidden');
                }
            }

            function toggleNotif() {
                const dropdown = document.getElementById('notifDropdown');
                const badge = document.getElementById('notifBadge');
                
                // Toggle visibility
                dropdown.classList.toggle('hidden');
                
                // Hentikan lampu berkedip saat dibuka
                if(badge) {
                    badge.classList.remove('animate-pulse');
                    badge.classList.replace('bg-red-500', 'bg-slate-300'); // ubah ke warna kalem
                }
            }

            function removeNotif(btn, id) {
                // Simpan ID ke local storage agar tidak muncul lagi saat di-refresh
                if (id) {
                    let dismissed = JSON.parse(localStorage.getItem('dismissedNotifs') || '[]');
                    if (!dismissed.includes(id.toString())) {
                        dismissed.push(id.toString());
                        localStorage.setItem('dismissedNotifs', JSON.stringify(dismissed));
                    }
                }
                
                // Hapus elemen notif baris tersebut
                const item = btn.closest('.notif-item');
                if (item) item.remove();
                
                updateNotifUI();
            }

            // Tutup dropdown jika klik di luar
            document.addEventListener('click', function(event) {
                const wrapper = document.getElementById('notifWrapper');
                const dropdown = document.getElementById('notifDropdown');
                if (wrapper && !wrapper.contains(event.target) && document.body.contains(event.target)) {
                    dropdown.classList.add('hidden');
                }
            });

            function toggleSidebar() {
                const sidebar = document.getElementById('mobile-sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                
                sidebar.classList.toggle('-translate-x-full');
                
                if (overlay.classList.contains('hidden')) {
                    overlay.classList.remove('hidden');
                    setTimeout(() => overlay.classList.remove('opacity-0'), 10);
                } else {
                    overlay.classList.add('opacity-0');
                    setTimeout(() => overlay.classList.add('hidden'), 300);
                }
            }
            </script>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 overflow-y-auto p-4 lg:p-6 bg-slate-50">
