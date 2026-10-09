<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOBI - Universitas Ma'soem</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; scroll-behavior: smooth; }
        
        /* Custom Radio Styling */
        input[type="radio"]:checked + label {
            border-color: #1e3a8a; /* blue-900 */
            background-color: #f8fafc;
            box-shadow: 0 4px 14px 0 rgba(30, 58, 138, 0.1);
        }
        input[type="radio"]:checked + label .icon-box {
            background-color: #1e3a8a;
            color: #ffffff;
            transform: scale(1.1);
        }
        input[type="radio"]:checked + label .check-icon {
            opacity: 1;
            transform: scale(1);
        }
        input[type="radio"] + label .icon-box {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f8fafc; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        /* Form inputs custom styling */
        .input-premium {
            background-color: #f8fafc;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }
        .input-premium:focus {
            background-color: #ffffff;
            border-color: #3b82f6; /* blue-500 */
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
    </style>
</head>
<body class="bg-[#f1f5f9] text-slate-800">

    <div class="flex flex-col lg:flex-row min-h-screen">
        
        <!-- Hero Section / Left Panel -->
        <div class="w-full lg:w-5/12 h-[100dvh] lg:h-screen lg:fixed lg:top-0 lg:left-0 relative flex flex-col justify-center lg:justify-between items-center lg:items-start p-8 lg:p-16 text-center lg:text-left overflow-hidden">
            
            <!-- Background Image -->
            <div class="absolute inset-0 bg-[url('assets/bg-masoem.jpg')] bg-cover bg-center bg-no-repeat transform scale-105 transition-transform duration-[20s] hover:scale-110"></div>
            
            <!-- Elegant Overlays -->
            <div class="absolute inset-0 bg-blue-950/70 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-blue-950 via-blue-900/60 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-blue-950/90 via-blue-900/40 to-transparent hidden lg:block"></div>
            
            <div class="relative z-10 flex flex-col items-center lg:items-start justify-center h-full w-full max-w-md mx-auto lg:mx-0 mt-[-5dvh] lg:mt-0">
                
                <!-- Logo & LOBI beside it -->
                <div class="flex flex-row items-center justify-center lg:justify-start space-x-4 lg:space-x-5 mb-5 lg:mb-8">
                    <!-- The Logo Image -->
                    <div class="w-16 h-16 lg:w-20 lg:h-20 bg-white rounded-2xl flex items-center justify-center shadow-[0_0_20px_rgba(255,255,255,0.2)] p-1.5 overflow-hidden shrink-0">
                        <img src="assets/logo.png" alt="Logo Univ" class="w-full h-full object-contain rounded-xl">
                    </div>
                    <!-- The LOBI text -->
                    <h1 class="text-5xl lg:text-6xl font-extrabold text-white tracking-tight drop-shadow-xl mt-1">LOBI</h1>
                </div>
                
                <p class="text-yellow-400 text-xs sm:text-sm lg:text-lg font-bold tracking-[0.2em] mb-6 lg:mb-10 uppercase drop-shadow-md">Buku Tamu & Inventaris</p>
                
                <div class="hidden lg:block w-16 h-1.5 bg-yellow-400 mb-8 rounded-full shadow-[0_0_15px_rgba(250,204,21,0.6)]"></div>
                
                <p class="text-blue-50/90 leading-relaxed font-light text-sm lg:text-lg drop-shadow-md max-w-sm lg:max-w-none">
                    Sistem pendataan terpadu Universitas Ma'soem. Silakan lengkapi formulir untuk melanjutkan proses kunjungan atau penitipan barang Anda.
                </p>

                <!-- Scroll Down Indicator (Mobile Only) -->
                <a href="#form-section" class="lg:hidden absolute bottom-8 flex flex-col items-center text-white/70 hover:text-white transition-colors animate-bounce">
                    <span class="text-[10px] uppercase tracking-[0.3em] mb-2 font-medium">Isi Formulir</span>
                    <div class="w-9 h-9 rounded-full border border-white/30 flex items-center justify-center bg-white/10 backdrop-blur-sm">
                        <i class="fas fa-arrow-down text-sm"></i>
                    </div>
                </a>
            </div>
            
            <!-- Footer on Desktop -->
            <div class="hidden lg:flex relative z-10 items-center justify-between w-full pt-12">
                <p class="text-white/60 text-[10px] font-medium tracking-widest uppercase">&copy; <?= date('Y') ?> Universitas Ma'soem</p>
                <a href="login.php" class="w-10 h-10 rounded-full bg-white/10 border border-white/10 flex items-center justify-center text-white/80 hover:bg-white hover:text-blue-900 transition-all backdrop-blur-sm shadow-lg" title="Login Admin">
                    <i class="fas fa-sign-in-alt text-sm"></i>
                </a>
            </div>
        </div>

        <!-- Form Section / Right Panel -->
        <div id="form-section" class="w-full lg:w-7/12 lg:ml-[41.666667%] min-h-screen lg:bg-white p-3 sm:p-8 lg:p-16 flex flex-col justify-center relative z-20">
            
            <!-- Form Card Wrapper -->
            <!-- On mobile, overlaps the hero section. We use a full-width card with rounded top edges -->
            <div class="w-full max-w-2xl mx-auto bg-white rounded-t-[2.5rem] lg:rounded-none shadow-[0_-15px_40px_rgba(0,0,0,0.15)] lg:shadow-none p-6 sm:p-10 lg:p-0 -mt-10 lg:mt-0 relative z-30 min-h-[50vh]">
                
                <!-- Mobile Drag Handle -->
                <div class="w-12 h-1.5 bg-slate-200 rounded-full mx-auto mb-8 lg:hidden"></div>
                
                <div class="mb-8 lg:mb-12 text-center lg:text-left">
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-slate-800 mb-1 lg:mb-2">Formulir Pendataan</h2>
                    <p class="text-slate-500 text-xs sm:text-sm lg:text-base">Mohon kelengkapan data diri dan tujuan kunjungan.</p>
                </div>

                <div id="alert-box" class="hidden mb-6 p-4 rounded-2xl flex items-start border">
                    <i id="alert-icon" class="fas mr-3 mt-0.5 text-lg"></i>
                    <p id="alert-text" class="text-sm font-medium leading-relaxed"></p>
                </div>

                <form id="lobiForm" onsubmit="submitForm(event)">
                    
                    <!-- Section: Biodata -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6 mb-8">
                        <div class="relative">
                            <label class="block text-[10px] sm:text-xs font-bold text-slate-500 mb-1.5 tracking-wider uppercase">Nama Lengkap</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="far fa-user text-slate-400"></i>
                                </div>
                                <input type="text" name="nama_lengkap" class="input-premium w-full pl-11 pr-4 py-3.5 rounded-xl text-slate-800 text-sm placeholder-slate-400 font-medium" placeholder="Sesuai identitas" required>
                            </div>
                        </div>
                        <div class="relative">
                            <label class="block text-[10px] sm:text-xs font-bold text-slate-500 mb-1.5 tracking-wider uppercase">Instansi / Asal</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="far fa-building text-slate-400"></i>
                                </div>
                                <input type="text" name="instansi" class="input-premium w-full pl-11 pr-4 py-3.5 rounded-xl text-slate-800 text-sm placeholder-slate-400 font-medium" placeholder="Asal instansi/perusahaan" required>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Jenis Kunjungan -->
                    <div class="mb-8">
                        <label class="block text-[10px] sm:text-xs font-bold text-slate-500 mb-3 tracking-wider uppercase">Tujuan Kedatangan</label>
                        <div class="grid grid-cols-2 gap-3 sm:gap-5">
                            
                            <!-- Option 1 -->
                            <div class="relative h-full">
                                <input type="radio" id="opt_bertamu" name="jenis_kunjungan" value="Bertamu" class="absolute opacity-0 w-full h-full cursor-pointer z-10" checked onchange="toggleForm()">
                                <label for="opt_bertamu" class="relative h-full flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left p-3 sm:p-4 border-2 border-slate-100 rounded-2xl cursor-pointer transition-all duration-300 hover:border-slate-300 bg-white">
                                    <div class="icon-box shrink-0 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 mb-2 sm:mb-0 sm:mr-3">
                                        <i class="fas fa-users text-base sm:text-lg"></i>
                                    </div>
                                    <div class="flex-1 flex flex-col justify-center">
                                        <div class="font-bold text-slate-800 text-sm sm:text-base leading-tight mb-1">Bertamu</div>
                                        <div class="text-[9px] sm:text-[11px] text-slate-500 leading-tight">Menemui staf/unit</div>
                                    </div>
                                    <div class="check-icon absolute top-3 right-3 text-blue-700 opacity-0 transform scale-50 transition-all duration-300 hidden sm:block">
                                        <i class="fas fa-check-circle text-lg"></i>
                                    </div>
                                </label>
                            </div>

                            <!-- Option 2 -->
                            <div class="relative h-full">
                                <input type="radio" id="opt_titip" name="jenis_kunjungan" value="Titip Barang" class="absolute opacity-0 w-full h-full cursor-pointer z-10" onchange="toggleForm()">
                                <label for="opt_titip" class="relative h-full flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left p-3 sm:p-4 border-2 border-slate-100 rounded-2xl cursor-pointer transition-all duration-300 hover:border-slate-300 bg-white">
                                    <div class="icon-box shrink-0 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 mb-2 sm:mb-0 sm:mr-3">
                                        <i class="fas fa-box-open text-base sm:text-lg"></i>
                                    </div>
                                    <div class="flex-1 flex flex-col justify-center">
                                        <div class="font-bold text-slate-800 text-sm sm:text-base leading-tight mb-1">Titip Barang</div>
                                        <div class="text-[9px] sm:text-[11px] text-slate-500 leading-tight">Paket / Dokumen</div>
                                    </div>
                                    <div class="check-icon absolute top-3 right-3 text-blue-700 opacity-0 transform scale-50 transition-all duration-300 hidden sm:block">
                                        <i class="fas fa-check-circle text-lg"></i>
                                    </div>
                                </label>
                            </div>

                        </div>
                    </div>

                    <!-- Dynamic Section: Bertamu -->
                    <div id="section-bertamu" class="space-y-4 sm:space-y-5 mb-8 transition-all duration-300">
                        <div class="relative">
                            <label class="block text-[10px] sm:text-xs font-bold text-slate-500 mb-1.5 tracking-wider uppercase">Bertemu Siapa / Unit Apa</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="far fa-address-card text-slate-400"></i>
                                </div>
                                <input type="text" id="tujuan_bertamu" name="tujuan_bertamu" class="input-premium w-full pl-11 pr-4 py-3.5 rounded-xl text-slate-800 text-sm placeholder-slate-400 font-medium" placeholder="Cth: Bpk. Rektor / BAU" required>
                            </div>
                        </div>
                        <div class="relative">
                            <label class="block text-[10px] sm:text-xs font-bold text-slate-500 mb-1.5 tracking-wider uppercase">Keperluan Bertamu</label>
                            <div class="relative">
                                <div class="absolute top-4 left-0 pl-4 flex items-start pointer-events-none">
                                    <i class="far fa-comment-dots text-slate-400"></i>
                                </div>
                                <textarea id="keperluan" name="keperluan" rows="2" class="input-premium w-full pl-11 pr-4 py-3.5 rounded-xl text-slate-800 text-sm resize-none placeholder-slate-400 font-medium" placeholder="Tuliskan tujuan singkat Anda..." required></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Section: Titip Barang -->
                    <div id="section-titip" class="space-y-4 sm:space-y-5 mb-8 hidden transition-all duration-300">
                        <div class="relative">
                            <label class="block text-[10px] sm:text-xs font-bold text-slate-500 mb-1.5 tracking-wider uppercase">Penerima Titipan</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="far fa-handshake text-slate-400"></i>
                                </div>
                                <input type="text" id="tujuan_titip" name="tujuan_titip" class="input-premium w-full pl-11 pr-4 py-3.5 rounded-xl text-slate-800 text-sm placeholder-slate-400 font-medium" placeholder="Nama atau Unit penerima">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                            <div class="relative">
                                <label class="block text-[10px] sm:text-xs font-bold text-slate-500 mb-1.5 tracking-wider uppercase">Jenis Titipan</label>
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
                                <label class="block text-[10px] sm:text-xs font-bold text-slate-500 mb-1.5 tracking-wider uppercase">Keterangan <span class="font-normal normal-case">(Opsional)</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-info-circle text-slate-400"></i>
                                    </div>
                                    <input type="text" id="keterangan_titipan" name="keterangan_titipan" class="input-premium w-full pl-11 pr-4 py-3.5 rounded-xl text-slate-800 text-sm placeholder-slate-400 font-medium" placeholder="No Resi / Ekspedisi">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="btn-submit" class="w-full bg-yellow-500 hover:bg-yellow-400 text-blue-900 font-bold text-sm sm:text-base py-4 px-6 rounded-xl shadow-[0_8px_20px_-6px_rgba(234,179,8,0.5)] hover:shadow-[0_12px_25px_-6px_rgba(234,179,8,0.6)] hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center mt-2 group">
                        <span id="btn-text">Kirim Data Kunjungan</span>
                        <i id="btn-icon" class="fas fa-arrow-right ml-2.5 transition-transform group-hover:translate-x-1"></i>
                    </button>
                    
                    <!-- Footer Mobile -->
                    <div class="flex lg:hidden justify-between items-center mt-10 px-2">
                        <p class="text-slate-400 text-[10px] font-medium uppercase tracking-widest">&copy; <?= date('Y') ?></p>
                        <a href="login.php" class="text-slate-300 hover:text-slate-500 transition-colors bg-slate-50 p-2 rounded-full" title="Login Admin">
                            <i class="fas fa-sign-in-alt text-sm"></i>
                        </a>
                    </div>
                </form>
            </div>
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

        async function submitForm(e) {
            e.preventDefault();
            const form = document.getElementById('lobiForm');
            const btn = document.getElementById('btn-submit');
            const btnText = document.getElementById('btn-text');
            const btnIcon = document.getElementById('btn-icon');
            
            const alertBox = document.getElementById('alert-box');
            const alertIcon = document.getElementById('alert-icon');
            const alertText = document.getElementById('alert-text');
            
            const formData = new FormData(form);
            
            btnText.innerText = 'Memproses...';
            btnIcon.className = 'fas fa-circle-notch fa-spin ml-2.5';
            btn.classList.add('opacity-80', 'cursor-not-allowed', 'pointer-events-none');
            
            try {
                const response = await fetch('api_submit_tamu.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                alertBox.className = 'mb-6 p-4 rounded-2xl flex items-start border';
                alertIcon.className = 'fas mr-3 mt-0.5 text-lg';

                if (result.status === 'success') {
                    alertBox.classList.add('bg-emerald-50', 'border-emerald-200', 'text-emerald-800');
                    alertIcon.classList.add('fa-check-circle', 'text-emerald-600');
                    alertText.innerHTML = '<strong>Berhasil Terkirim!</strong><br>' + result.message;
                    
                    form.reset();
                    toggleForm(); 
                    
                    setTimeout(() => {
                        alertBox.classList.add('hidden');
                    }, 5000);
                } else {
                    alertBox.classList.add('bg-red-50', 'border-red-200', 'text-red-800');
                    alertIcon.classList.add('fa-exclamation-circle', 'text-red-600');
                    alertText.innerHTML = '<strong>Gagal!</strong><br>' + result.message;
                }
            } catch (error) {
                alertBox.className = 'mb-6 p-4 rounded-2xl flex items-start border bg-red-50 border-red-200 text-red-800';
                alertIcon.className = 'fas fa-exclamation-circle mr-3 mt-0.5 text-lg text-red-600';
                alertText.innerHTML = '<strong>Kesalahan Sistem!</strong><br>Tidak dapat terhubung ke server.';
            }

            btnText.innerText = 'Kirim Data Kunjungan';
            btnIcon.className = 'fas fa-arrow-right ml-2.5 transition-transform group-hover:translate-x-1';
            btn.classList.remove('opacity-80', 'cursor-not-allowed', 'pointer-events-none');
            
            const y = alertBox.getBoundingClientRect().top + window.scrollY - 100;
            window.scrollTo({top: y, behavior: 'smooth'});
        }
    </script>
</body>
</html>
