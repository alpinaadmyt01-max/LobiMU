<?php
require_once 'config.php';
checkAuth();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama_lengkap']);
    $instansi = trim($_POST['instansi']);
    $jenis_kunjungan = $_POST['jenis_kunjungan'];
    
    $tujuan = '';
    $keperluan = null;
    $jenis_titipan = null;
    $keterangan_titipan = null;
    $lokasi_penyimpanan = null;

    if ($jenis_kunjungan === 'Bertamu') {
        $tujuan = trim($_POST['tujuan_bertamu'] ?? '');
        $keperluan = trim($_POST['keperluan'] ?? '');
    } else {
        $tujuan = trim($_POST['tujuan_titip'] ?? '');
        $jenis_titipan = trim($_POST['jenis_titipan'] ?? '');
        $keterangan_titipan = trim($_POST['keterangan_titipan'] ?? '');
        $lokasi_penyimpanan = trim($_POST['lokasi_penyimpanan'] ?? '');
    }

    if ($nama && $instansi && $jenis_kunjungan && $tujuan) {
        try {
            $stmt = $pdo->prepare("INSERT INTO tamu (nama_lengkap, instansi, jenis_kunjungan, tujuan, keperluan, jenis_titipan, keterangan_titipan, lokasi_penyimpanan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nama, $instansi, $jenis_kunjungan, $tujuan, $keperluan, $jenis_titipan, $keterangan_titipan, $lokasi_penyimpanan]);
            $success = "Data entri baru berhasil disimpan ke sistem!";
        } catch (PDOException $e) {
            $error = "Terjadi kesalahan database: " . $e->getMessage();
        }
    } else {
        $error = "Mohon lengkapi semua kolom yang wajib diisi!";
    }
}

require_once 'includes/header.php';
require_once 'includes/sidebar.php';
?>

<style>
    /* Custom Radio Styling for Admin */
    input[type="radio"]:checked + label {
        border-color: #2563eb; /* blue-600 */
        background-color: #eff6ff; /* blue-50 */
    }
    input[type="radio"]:checked + label .icon-box {
        background-color: #2563eb;
        color: #ffffff;
    }
    .input-premium {
        background-color: #f8fafc;
        border: 2px solid #f1f5f9;
        transition: all 0.3s ease;
    }
    .input-premium:focus {
        background-color: #ffffff;
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }
</style>

<div class="mb-8">
    <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-800 tracking-tight">Entri Data Baru</h1>
    <p class="text-slate-500 mt-2 text-sm">Tambahkan data tamu atau titipan barang secara manual.</p>
</div>

<div class="w-full bg-white rounded-[1.5rem] shadow-[0_5px_20px_rgba(0,0,0,0.02)] border border-slate-100 overflow-hidden mb-10">
    <div class="bg-white px-8 py-6 border-b border-slate-100 flex items-center justify-between">
        <h3 class="font-bold text-lg text-slate-800">Formulir Pendataan</h3>
        <span class="text-xs font-semibold text-slate-400 uppercase tracking-widest bg-slate-50 px-3 py-1 rounded-full">LOBI Admin</span>
    </div>
    
    <div class="p-8">
        <?php if ($success): ?>
            <div class="bg-emerald-50 text-emerald-700 p-4 rounded-xl mb-8 flex items-start border border-emerald-200">
                <i class="fas fa-check-circle text-xl mr-3 mt-0.5"></i>
                <div>
                    <h4 class="font-bold">Berhasil!</h4>
                    <p class="text-sm mt-0.5"><?= htmlspecialchars($success) ?></p>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-8 flex items-start border border-red-200">
                <i class="fas fa-exclamation-triangle text-xl mr-3 mt-0.5"></i>
                <div>
                    <h4 class="font-bold">Gagal Menyimpan</h4>
                    <p class="text-sm mt-0.5"><?= htmlspecialchars($error) ?></p>
                </div>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
                
                <!-- Kolom Kiri: Informasi Dasar & Jenis Kunjungan -->
                <div class="lg:col-span-5 space-y-8">
                    
                    <div class="space-y-6">
                        <div class="relative">
                            <label class="block text-[10px] sm:text-xs font-bold text-slate-500 mb-2 tracking-wider uppercase">Nama Lengkap</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="far fa-user text-slate-400"></i>
                                </div>
                                <input type="text" name="nama_lengkap" class="input-premium w-full pl-11 pr-4 py-3.5 rounded-xl text-slate-800 text-sm placeholder-slate-400 font-medium" placeholder="Sesuai identitas" required>
                            </div>
                        </div>
                        <div class="relative">
                            <label class="block text-[10px] sm:text-xs font-bold text-slate-500 mb-2 tracking-wider uppercase">Instansi / Asal</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="far fa-building text-slate-400"></i>
                                </div>
                                <input type="text" name="instansi" class="input-premium w-full pl-11 pr-4 py-3.5 rounded-xl text-slate-800 text-sm placeholder-slate-400 font-medium" placeholder="Asal instansi/perusahaan" required>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-8">
                        <label class="block text-[10px] sm:text-xs font-bold text-slate-500 mb-3 tracking-wider uppercase">Tujuan Kedatangan</label>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="relative h-full">
                                <input type="radio" id="opt_bertamu" name="jenis_kunjungan" value="Bertamu" class="absolute opacity-0 w-full h-full cursor-pointer z-10" checked onchange="toggleForm()">
                                <label for="opt_bertamu" class="relative flex flex-col items-center text-center p-4 border-2 border-slate-100 rounded-xl cursor-pointer transition-all duration-300">
                                    <div class="icon-box w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 mb-3 transition-colors">
                                        <i class="fas fa-users text-lg"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800 text-sm mb-0.5">Bertamu</div>
                                        <div class="text-[10px] text-slate-500">Menemui staf/unit</div>
                                    </div>
                                </label>
                            </div>

                            <div class="relative h-full">
                                <input type="radio" id="opt_titip" name="jenis_kunjungan" value="Titip Barang" class="absolute opacity-0 w-full h-full cursor-pointer z-10" onchange="toggleForm()">
                                <label for="opt_titip" class="relative flex flex-col items-center text-center p-4 border-2 border-slate-100 rounded-xl cursor-pointer transition-all duration-300">
                                    <div class="icon-box w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 mb-3 transition-colors">
                                        <i class="fas fa-box-open text-lg"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800 text-sm mb-0.5">Titip Barang</div>
                                        <div class="text-[10px] text-slate-500">Paket / Dokumen</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Divider Vertikal (Desktop) -->
                <div class="hidden lg:flex lg:col-span-1 justify-center">
                    <div class="w-px h-full bg-slate-100"></div>
                </div>

                <!-- Kolom Kanan: Form Dinamis & Tombol Submit -->
                <div class="lg:col-span-6 flex flex-col justify-between">
                    <div>
                        <div class="mb-6 lg:mb-8 pb-4 border-b border-slate-100">
                            <h4 class="font-bold text-slate-800"><i class="fas fa-info-circle text-blue-500 mr-2"></i> Detail Informasi Kunjungan</h4>
                            <p class="text-xs text-slate-500 mt-1">Lengkapi informasi berikut sesuai dengan tujuan kedatangan.</p>
                        </div>

                        <!-- Dynamic Section: Bertamu -->
                        <div id="section-bertamu" class="space-y-6 transition-all duration-300">
                            <div class="relative">
                                <label class="block text-[10px] sm:text-xs font-bold text-slate-500 mb-2 tracking-wider uppercase">Bertemu Siapa / Unit Apa</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="far fa-address-card text-slate-400"></i>
                                    </div>
                                    <input type="text" id="tujuan_bertamu" name="tujuan_bertamu" class="input-premium w-full pl-11 pr-4 py-3.5 rounded-xl text-slate-800 text-sm placeholder-slate-400 font-medium" placeholder="Cth: Bpk. Rektor / BAU" required>
                                </div>
                            </div>
                            <div class="relative">
                                <label class="block text-[10px] sm:text-xs font-bold text-slate-500 mb-2 tracking-wider uppercase">Keperluan Bertamu</label>
                                <div class="relative">
                                    <div class="absolute top-4 left-0 pl-4 flex items-start pointer-events-none">
                                        <i class="far fa-comment-dots text-slate-400"></i>
                                    </div>
                                    <textarea id="keperluan" name="keperluan" rows="4" class="input-premium w-full pl-11 pr-4 py-3.5 rounded-xl text-slate-800 text-sm resize-none placeholder-slate-400 font-medium" placeholder="Tuliskan tujuan secara lengkap..." required></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Dynamic Section: Titip Barang -->
                        <div id="section-titip" class="space-y-6 hidden transition-all duration-300">
                            <div class="relative">
                                <label class="block text-[10px] sm:text-xs font-bold text-slate-500 mb-2 tracking-wider uppercase">Penerima Titipan</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="far fa-handshake text-slate-400"></i>
                                    </div>
                                    <input type="text" id="tujuan_titip" name="tujuan_titip" class="input-premium w-full pl-11 pr-4 py-3.5 rounded-xl text-slate-800 text-sm placeholder-slate-400 font-medium" placeholder="Nama atau Unit penerima">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="relative">
                                    <label class="block text-[10px] sm:text-xs font-bold text-slate-500 mb-2 tracking-wider uppercase">Jenis Titipan</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                                            <i class="fas fa-box text-slate-400"></i>
                                        </div>
                                        <select id="jenis_titipan" name="jenis_titipan" class="input-premium w-full pl-11 pr-10 py-3.5 rounded-xl text-slate-800 text-sm appearance-none cursor-pointer font-medium relative">
                                            <option value="" disabled selected>Pilih jenis...</option>
                                            <option value="Surat / Dokumen">Surat / Dokumen</option>
                                            <option value="Paket Kecil">Paket Kecil</option>
                                            <option value="Paket Besar">Paket Besar</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                                            <i class="fas fa-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative">
                                    <label class="block text-[10px] sm:text-xs font-bold text-slate-500 mb-2 tracking-wider uppercase">Keterangan <span class="font-normal normal-case">(Opsional)</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-info-circle text-slate-400"></i>
                                        </div>
                                        <input type="text" id="keterangan_titipan" name="keterangan_titipan" class="input-premium w-full pl-11 pr-4 py-3.5 rounded-xl text-slate-800 text-sm placeholder-slate-400 font-medium" placeholder="No Resi / Ekspedisi">
                                    </div>
                                </div>
                            </div>
                            <div class="relative mt-6">
                                <label class="block text-[10px] sm:text-xs font-bold text-slate-500 mb-2 tracking-wider uppercase text-blue-600"><i class="fas fa-map-marker-alt mr-1"></i> Lokasi Penyimpanan (Internal Admin)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-archive text-slate-400"></i>
                                    </div>
                                    <input type="text" id="lokasi_penyimpanan" name="lokasi_penyimpanan" class="input-premium w-full pl-11 pr-4 py-3.5 rounded-xl text-slate-800 text-sm placeholder-slate-400 font-medium border-blue-200 bg-blue-50/30 focus:border-blue-500 focus:bg-white" placeholder="Cth: Laci FO, Rak B1, Di atas meja...">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col-reverse sm:flex-row justify-end sm:space-x-4 border-t border-slate-100 pt-8 mt-10">
                        <button type="reset" class="mt-3 sm:mt-0 px-8 py-3.5 rounded-xl text-slate-500 font-bold hover:bg-slate-100 hover:text-slate-700 transition-colors w-full sm:w-auto text-center">
                            Batal
                        </button>
                        <button type="submit" class="px-8 py-3.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold shadow-lg shadow-blue-500/30 transition-all focus:ring-4 focus:ring-blue-500/50 w-full sm:w-auto flex justify-center items-center group">
                            <i class="fas fa-save mr-2.5 transform group-hover:scale-110 transition-transform"></i> Simpan Data Entri
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
    function toggleForm() {
        const isBertamu = document.getElementById('opt_bertamu').checked;
        const secBertamu = document.getElementById('section-bertamu');
        const secTitip = document.getElementById('section-titip');
        
        const inputTujuanBertamu = document.getElementById('tujuan_bertamu');
        const inputKeperluan = document.getElementById('keperluan');
        const inputTujuanTitip = document.getElementById('tujuan_titip');
        const inputJenisTitipan = document.getElementById('jenis_titipan');

        if (isBertamu) {
            secBertamu.classList.remove('hidden');
            secTitip.classList.add('hidden');
            
            inputTujuanBertamu.setAttribute('required', 'true');
            inputKeperluan.setAttribute('required', 'true');
            
            inputTujuanTitip.removeAttribute('required');
            inputJenisTitipan.removeAttribute('required');
        } else {
            secBertamu.classList.add('hidden');
            secTitip.classList.remove('hidden');
            
            inputTujuanBertamu.removeAttribute('required');
            inputKeperluan.removeAttribute('required');
            
            inputTujuanTitip.setAttribute('required', 'true');
            inputJenisTitipan.setAttribute('required', 'true');
        }
    }
</script>

<?php require_once 'includes/footer.php'; ?>
