<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Form Registrasi MBMT LMB ITS</title>
    <meta name="description" content="Form Pendaftaran Resmi MBMT LMB ITS. Silahkan isi form dengan teliti.">
    <link rel="stylesheet" href="{{ asset('css/app-styles.css') }}?v=3.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="fixed-background">
        <img src="{{ asset('assets/Vector.svg') }}" alt="Siluet" class="bg-silhouette">
        <img src="{{ asset('assets/bg-cahaya.svg') }}" alt="Cahaya" class="bg-cahaya">
        <img src="{{ asset('assets/Elemen tetap tidak bergeser ketika discroll.svg') }}" class="fixed-star star-left" alt="Bintang Kiri">
        <img src="{{ asset('assets/Elemen tetap tidak bergeser ketika discroll.svg') }}" class="fixed-star star-right" alt="Bintang Kanan" style="transform: scaleX(-1) translateY(-50%);">
    </div>

    <main class="app-container">
        <header class="top-sticky-header">
            <img src="{{ asset('assets/Logo yang harus tetap di atas.png') }}" alt="Logo Institusi" class="sticky-logo-img">
        </header>

        <div class="main-title-wrapper">
            <img src="{{ asset('assets/Teks Header.svg') }}" alt="Pendaftaran MBMT LMB ITS 2026" class="main-title-img">
        </div>

        <section class="form-container">
            <div class="paging-badge-wrapper">
                <div class="paging-badge">
                    <p id="step-badge-text">BAGIAN 1 DARI 3</p>
                </div>
            </div>
            <h1 class="form-title">Silahkan isi form di bawah ini dengan teliti!</h1>

            <form id="registrationForm" onsubmit="handleSubmit(event)" novalidate>

                <!-- ===== STEP 1 ===== -->
                <div id="step-1" class="form-step">

                    <!-- NAMA -->
                    <div class="form-group">
                        <div class="label-badge">NAMA</div>
                        <div class="input-wrapper" id="iw-nama">
                            <input type="text" id="nama" class="form-input" autocomplete="name" required>
                            <label for="nama" class="custom-placeholder">
                                <span class="required-asterisk">*</span>Contoh: Anisa Fitriani
                            </label>
                        </div>
                        <p class="field-error-msg" id="err-nama">⚠ Nama wajib diisi!</p>
                    </div>

                    <!-- EMAIL -->
                    <div class="form-group">
                        <div class="label-badge">EMAIL</div>
                        <div class="input-wrapper" id="iw-email">
                            <input type="email" id="email" class="form-input" autocomplete="email" required>
                            <label for="email" class="custom-placeholder">
                                <span class="required-asterisk">*</span>Contoh: anisa@student.its.ac.id
                            </label>
                        </div>
                        <p class="field-error-msg" id="err-email">⚠ Email valid wajib diisi!</p>
                    </div>

                    <!-- NRP -->
                    <div class="form-group">
                        <div class="label-badge">NRP</div>
                        <div class="input-wrapper" id="iw-nrp">
                            <input type="text" id="nrp" class="form-input" inputmode="numeric" maxlength="10" autocomplete="off" required>
                            <label for="nrp" class="custom-placeholder">
                                <span class="required-asterisk">*</span>Contoh: 5024536283
                            </label>
                        </div>
                        <p class="field-error-msg" id="err-nrp">⚠ NRP harus terdiri dari tepat 10 digit angka!</p>
                    </div>

                    <!-- FAKULTAS -->
                    <div class="form-group">
                        <div class="label-badge">FAKULTAS</div>
                        <div class="dropdown-container">
                            <div class="input-wrapper custom-select-wrapper" id="iw-fakultas" onclick="toggleDropdown('fakultas')">
                                <span class="custom-dd-display" id="disp-fakultas"><span class="required-asterisk">*</span>&nbsp;Silahkan pilih dropdown</span>
                                <div class="dropdown-icon"></div>
                            </div>
                            <div class="custom-dd-panel" id="panel-fakultas"></div>
                        </div>
                        <input type="hidden" id="val-fakultas">
                        <p class="field-error-msg" id="err-fakultas">⚠ Harap pilih Fakultas!</p>
                    </div>

                    <!-- DEPARTEMEN -->
                    <div class="form-group">
                        <div class="label-badge">DEPARTEMEN</div>
                        <div class="dropdown-container">
                            <div class="input-wrapper custom-select-wrapper" id="iw-departemen" onclick="toggleDropdown('departemen')">
                                <span class="custom-dd-display" id="disp-departemen"><span class="required-asterisk">*</span>&nbsp;Menunggu masukan dari "Fakultas"</span>
                                <div class="dropdown-icon"></div>
                            </div>
                            <div class="custom-dd-panel" id="panel-departemen"></div>
                        </div>
                        <input type="hidden" id="val-departemen">
                        <p class="field-error-msg" id="err-departemen">⚠ Harap pilih Departemen!</p>
                    </div>

                    <!-- JURUSAN / PRODI -->
                    <div class="form-group">
                        <div class="label-badge">JURUSAN</div>
                        <div class="dropdown-container">
                            <div class="input-wrapper custom-select-wrapper" id="iw-jurusan" onclick="toggleDropdown('jurusan')">
                                <span class="custom-dd-display" id="disp-jurusan"><span class="required-asterisk">*</span>&nbsp;Menunggu masukan dari "Depart."</span>
                                <div class="dropdown-icon"></div>
                            </div>
                            <div class="custom-dd-panel" id="panel-jurusan"></div>
                        </div>
                        <input type="hidden" id="val-jurusan">
                        <p class="field-error-msg" id="err-jurusan">⚠ Harap pilih Jurusan/Prodi!</p>
                    </div>

                    <!-- UKM ASAL -->
                    <div class="form-group">
                        <div class="label-badge">UKM ASAL</div>
                        <div class="dropdown-container">
                            <div class="input-wrapper custom-select-wrapper" id="iw-ukm" onclick="toggleDropdown('ukm')">
                                <span class="custom-dd-display" id="disp-ukm"><span class="required-asterisk">*</span>&nbsp;Silahkan pilih dropdown</span>
                                <div class="dropdown-icon"></div>
                            </div>
                            <div class="custom-dd-panel" id="panel-ukm"></div>
                        </div>
                        <input type="hidden" id="val-ukm">
                        <p class="field-error-msg" id="err-ukm">⚠ Harap pilih UKM Asal!</p>
                    </div>

                    <!-- NO TELEPON -->
                    <div class="form-group">
                        <div class="label-badge" style="letter-spacing: -0.5px;">NO. TELEPON</div>
                        <div class="input-wrapper" id="iw-telp">
                            <input type="tel" id="telp" class="form-input" autocomplete="tel" required>
                            <label for="telp" class="custom-placeholder">
                                <span class="required-asterisk">*</span>Contoh: 0821-2837-3847
                            </label>
                        </div>
                        <p class="field-error-msg" id="err-telp">⚠ No. Telepon wajib diisi!</p>
                    </div>

                    <!-- Next Button -->
                    <div class="step-nav-wrapper flex-end">
                        <button type="button" class="btn-next" onclick="goToStep(2)">
                            <span class="btn-next-text" style="margin-right: 6px;">Next</span>
                            <img src="{{ asset('assets/panah.svg') }}" alt="Next Arrow" class="btn-next-icon">
                        </button>
                    </div>
                </div>

                <!-- ===== STEP 2 ===== -->
                <div id="step-2" class="form-step" style="display: none;">

                    <!-- ALERGI RADIO -->
                    <div class="form-group">
                        <div class="label-badge label-badge-multiline" style="font-size: 20px; line-height: 1;">APAKAH ANDA MEMILIKI ALERGI</div>
                        <div class="input-wrapper radio-wrapper" id="iw-alergi">
                            <div class="radio-header">
                                <span class="required-asterisk">*</span>Silahkan pilih opsi di bawah ini
                            </div>
                            <div class="radio-options">
                                <label class="radio-option">
                                    <input type="radio" name="alergi" value="ya" class="d-none" onchange="toggleAlergiField(this.value)">
                                    <span class="custom-radio"></span>
                                    <span class="radio-label">YA</span>
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="alergi" value="tidak" class="d-none" onchange="toggleAlergiField(this.value)">
                                    <span class="custom-radio"></span>
                                    <span class="radio-label">Tidak</span>
                                </label>
                            </div>
                        </div>
                        <p class="field-error-msg" id="err-alergi">⚠ Harap pilih salah satu opsi!</p>
                    </div>

                    <!-- ALERGI TEXTAREA (hidden by default) -->
                    <div class="form-group" id="alergi-field-wrapper" style="display: none;">
                        <div class="label-badge label-badge-multiline" style="height: auto; font-size: 19px; line-height: 1; padding: 5px 12px 5px 10px;">APA MAKANAN/MINUMAN PEMICU ALERGI TERSEBUT?</div>
                        <div class="input-wrapper textarea-wrapper" id="iw-alergi-desc">
                            <textarea id="alergi_desc" class="form-input" required></textarea>
                            <label for="alergi_desc" class="custom-placeholder">
                                <span class="required-asterisk">*</span>Jelaskan secara rinci dan mudah dipahami, heheh :)
                            </label>
                        </div>
                        <p class="field-error-msg" id="err-alergi-desc">⚠ Harap jelaskan pemicu alergi Anda!</p>
                    </div>

                    <!-- Step 2 Navigation -->
                    <div class="step-nav-wrapper">
                        <button type="button" class="btn-next btn-prev" onclick="goToStep(1)">
                            <img src="{{ asset('assets/panah.svg') }}" alt="Prev Arrow" class="btn-next-icon" style="transform: scaleX(-1);">
                            <span class="btn-next-text" style="margin-left: 6px;">Prev</span>
                        </button>
                        <button type="button" class="btn-next" onclick="goToStep(3)">
                            <span class="btn-next-text" style="margin-right: 6px;">Next</span>
                            <img src="{{ asset('assets/panah.svg') }}" alt="Next Arrow" class="btn-next-icon">
                        </button>
                    </div>
                </div>

                <!-- ===== STEP 3 ===== -->
                <div id="step-3" class="form-step" style="display: none;">
                    <div class="form-group">
                        <div class="label-badge">Pakta Integritas</div>
                        <div class="input-wrapper pakta-wrapper" style="height: auto; min-height: 450px; padding: 20px 15px;">
                            <div class="pakta-content" style="font-size: 11px; font-family: 'Poppins', sans-serif; color: #000; text-align: left;">
                                <p style="font-weight: 700; text-align: center; font-size: 11px;">PAKTA INTEGRITAS PESERTA MBMT 2026</p>
                                <br>
                                <p>Yang bertanda tangan di bawah ini:</p>
                                <br>
                                <p>Nama Lengkap : <span style="font-weight: 700;" id="pakta-nama">{Nama Lengkap - Bold}</span></p>
                                <p>NRP : <span style="font-weight: 700;" id="pakta-nrp">{NRP - Bold}</span></p>
                                <p>Departemen : <span style="font-weight: 700;" id="pakta-dept">{Departemen - Bold}</span></p>
                                <br>
                                <p>Dengan ini menyatakan secara sadar dan tanpa paksaan dari pihak mana pun, bahwa saya:</p>
                                <ol style="padding-left: 15px; margin-top: 5px; margin-bottom: 5px;">
                                    <li style="margin-bottom: 5px;">Telah mengisi data RSVP MBMT 2026 dengan sebenar-benarnya.</li>
                                    <li style="margin-bottom: 5px;">Berkomitmen penuh untuk mengikuti seluruh rangkaian acara MBMT 2026 yang akan dilaksanakan pada hari Sabtu, 16 Mei 2026, di Teater A.</li>
                                    <li style="margin-bottom: 5px;">Bersedia menerima sanksi atau konsekuensi yang telah ditetapkan oleh panitia penyelenggara apabila saya tidak hadir pada waktu dan tempat yang telah ditentukan tersebut tanpa alasan yang berdasar dan sah.</li>
                                </ol>
                                <br>
                                <p>Demikian Pakta Integritas ini saya buat dengan sebenar-benarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
                                <br>
                                <p>Surabaya, <span id="pakta-tanggal">...</span></p>
                                <p>Yang membuat pernyataan,</p>
                                <br>
                                <p id="pakta-info-text"><span class="required-asterisk">*</span> Silahkan centang checker di bawah ini untuk menyetujui pakta ini!</p>
                                <br>
                                <label class="radio-option checker-wrapper" style="display: inline-flex; align-items: center; cursor: pointer;">
                                    <input type="checkbox" id="pakta-check" class="d-none" onchange="togglePaktaText(this)">
                                    <span class="custom-radio custom-checkout" style="border-radius: 4px; border: 2px solid #ccc;"></span>
                                    <span class="radio-label" style="margin-left: 10px; font-size: 14px;">Tandatangani</span>
                                </label>
                                <br><br>
                                <p style="font-weight: 700;" id="pakta-nama-bawah">{Nama Peserta}</p>
                                <p id="pakta-nrp-bawah">{Nrp Peserta}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 Navigation -->
                    <div class="step-nav-wrapper">
                        <button type="button" class="btn-next btn-prev" onclick="goToStep(2)">
                            <img src="{{ asset('assets/panah.svg') }}" alt="Prev Arrow" class="btn-next-icon" style="transform: scaleX(-1);">
                            <span class="btn-next-text" style="margin-left: 6px;">Prev</span>
                        </button>
                        <button type="submit" class="btn-next" style="justify-content: center; padding: 0 15px;">
                            <span class="btn-next-text">Submit</span>
                        </button>
                    </div>
                </div>

                <!-- SUCCESS STATE -->
                <div id="step-selesai" class="form-step" style="display: none; height: auto; min-height: 300px; padding: 40px 20px;">
                    <div style="font-family: 'Poppins', sans-serif; font-weight: 700; color: #243e88; font-size: 18px; text-align: left; line-height: 1.4;">
                        <p>Terima kasih atas waktunya karena telah mengisi form reservasi ini.</p>
                    </div>
                </div>

            </form>
        </section>

        <footer class="app-footer">
            <p>Departemen Media Kreatif, Lembaga Minat Bakat, Institut Teknologi Sepuluh Nopember 2026 &copy; All Rights Reserved.</p>
            <p>Powered by Icadsproject. See more at <a href="https://porto.icadsproject.com" style="color: white;">porto.icadsproject.com</a></p>
        </footer>
    </main>

    <script>
    // =====================================================
    // DATA ITS
    // =====================================================
    const itsData = {
        'FSAD - Fakultas Sains dan Analitika Data': {
            'Fisika': ['Sarjana Fisika (S1)'],
            'Matematika': ['Sarjana Matematika (S1)'],
            'Statistika': ['Sarjana Statistika (S1)', 'Sarjana Sains Data (S1)'],
            'Kimia': ['Sarjana Kimia (S1)', 'Sarjana Sains Analitik dan Instrumentasi Kimia (S1)'],
            'Biologi': ['Sarjana Biologi (S1)'],
            'Aktuaria': ['Sarjana Aktuaria (S1)'],
        },
        'FTIRS - Fakultas Teknologi Industri dan Rekayasa Sistem': {
            'Teknik Mesin': ['Sarjana Teknik Mesin (S1)', 'Sarjana Rekayasa Keselamatan Proses (S1)'],
            'Teknik Kimia': ['Sarjana Teknik Kimia (S1)', 'Sarjana Teknik Pangan (S1)'],
            'Teknik Fisika': ['Sarjana Teknik Fisika (S1)'],
            'Teknik dan Sistem Industri': ['Sarjana Teknik Industri (S1)'],
            'Teknik Material dan Metalurgi': ['Sarjana Teknik Material (S1)'],
            'Teknik Pangan': ['Sarjana Teknik Pangan (S1)'],
        },
        'FTSPK - Fakultas Teknik Sipil, Perencanaan, dan Kebumian': {
            'Teknik Sipil': ['Sarjana Teknik Sipil (S1)'],
            'Arsitektur': ['Sarjana Arsitektur (S1)'],
            'Teknik Lingkungan': ['Sarjana Teknik Lingkungan (S1)'],
            'Teknik Geomatika': ['Sarjana Teknik Geomatika (S1)'],
            'Perencanaan Wilayah dan Kota': ['Sarjana Perencanaan Wilayah dan Kota (S1)'],
            'Teknik Geofisika': ['Sarjana Teknik Geofisika (S1)'],
            'Teknik Pertambangan': ['Sarjana Teknik Pertambangan (S1)'],
        },
        'FTK - Fakultas Teknologi Kelautan': {
            'Teknik Perkapalan': ['Sarjana Teknik Perkapalan (S1)'],
            'Teknik Sistem Perkapalan': ['Sarjana Teknik Sistem Perkapalan (S1)'],
            'Teknik Kelautan': ['Sarjana Teknik Kelautan (S1)'],
            'Teknik Transportasi Laut': ['Sarjana Teknik Transportasi Laut (S1)'],
            'Teknik Lepas Pantai': ['Sarjana Teknik Lepas Pantai (S1)'],
        },
        'FTEIC - Fakultas Teknologi Elektro dan Informatika Cerdas': {
            'Teknik Elektro': ['Sarjana Teknik Elektro (S1)'],
            'Teknik Informatika': ['Sarjana Teknik Informatika (S1)', 'Sarjana Rekayasa Perangkat Lunak (S1)', 'Sarjana Rekayasa Kecerdasan Artifisial (S1)'],
            'Sistem Informasi': ['Sarjana Sistem Informasi (S1)', 'Sarjana Inovasi Digital (S1)'],
            'Teknik Komputer': ['Sarjana Teknik Komputer (S1)'],
            'Teknik Biomedik': ['Sarjana Teknik Biomedik (S1)'],
            'Teknologi Informasi': ['Sarjana Teknologi Informasi (S1)'],
            'Teknik Telekomunikasi': ['Sarjana Teknik Telekomunikasi (S1)'],
        },
        'FDKBD - Fakultas Desain Kreatif dan Bisnis Digital': {
            'Manajemen Bisnis': ['Sarjana Manajemen Bisnis (S1)', 'Sarjana Bisnis Digital (S1)'],
            'Desain Produk Industri': ['Sarjana Desain Produk Industri (S1)'],
            'Desain Interior': ['Sarjana Desain Interior (S1)'],
            'Desain Komunikasi Visual': ['Sarjana Desain Komunikasi Visual (S1)'],
            'Studi Pembangunan': ['Sarjana Studi Pembangunan (S1)'],
        },
        'FV - Fakultas Vokasi': {
            'Teknik Infrastruktur Sipil': ['Sarjana Terapan Teknik Sipil (D4)', 'Sarjana Terapan Teknologi Rekayasa Konstruksi Bangunan Air (D4)'],
            'Teknik Mesin Industri': ['Sarjana Terapan Teknologi Rekayasa Manufaktur (D4)', 'Sarjana Terapan Teknologi Rekayasa Konversi Energi (D4)'],
            'Teknik Kimia Industri': ['Sarjana Terapan Teknik Teknologi Rekayasa Kimia Industri (D4)'],
            'Teknik Elektro Otomasi': ['Sarjana Terapan Teknologi Rekayasa Otomasi (D4)'],
            'Teknik Instrumentasi': ['Sarjana Terapan Rekayasa Teknologi Instrumentasi (D4)'],
            'Statistika Bisnis': ['Sarjana Terapan Statistika Bisnis (D4)'],
        },
        'FKK - Fakultas Kedokteran dan Kesehatan': {
            'Kedokteran': ['Sarjana Kedokteran (S1)', 'Sarjana Teknologi Kedokteran (S1)'],
        },
    };

    const ukmOptions = ['LMB', 'Lainnya'];

    let currentStep = 1;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const registrationEndpoint = @json(route('registrations.store'));

    // =====================================================
    // CUSTOM DROPDOWN ENGINE
    // =====================================================
    function buildDropdownPanel(panelId, items, onSelect) {
        const panel = document.getElementById(panelId);
        panel.innerHTML = '';
        if (!items || items.length === 0) {
            const div = document.createElement('div');
            div.className = 'custom-dd-item dd-disabled';
            div.textContent = '— Pilih Fakultas/Departemen terlebih dahulu —';
            panel.appendChild(div);
            return;
        }
        items.forEach(item => {
            const div = document.createElement('div');
            div.className = 'custom-dd-item';
            div.textContent = item;
            div.addEventListener('click', (e) => {
                e.stopPropagation();
                onSelect(item);
                closeAllDropdowns();
            });
            panel.appendChild(div);
        });
    }

    function toggleDropdown(id) {
        const panel = document.getElementById('panel-' + id);
        const isOpen = panel.classList.contains('open');
        closeAllDropdowns();
        if (!isOpen) {
            panel.classList.add('open');
            // Elevate z-index of parent form-group so panel shows above siblings
            const fgEl = panel.closest('.form-group');
            if (fgEl) fgEl.style.zIndex = '50';
        }
    }

    function closeAllDropdowns() {
        document.querySelectorAll('.custom-dd-panel.open').forEach(p => {
            p.classList.remove('open');
            const fg = p.closest('.form-group');
            if (fg) fg.style.zIndex = '';
        });
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown-container')) closeAllDropdowns();
    });

    function setDropdownValue(id, value, displayText) {
        document.getElementById('val-' + id).value = value;
        const disp = document.getElementById('disp-' + id);
        if (displayText) {
            disp.innerHTML = `<span class="custom-dd-value">${displayText}</span>`;
            disp.classList.add('has-value');
        } else {
            disp.innerHTML = `<span class="required-asterisk">*</span>&nbsp;Silahkan pilih dropdown`;
            disp.classList.remove('has-value');
        }
        // Mark selected item in panel
        document.querySelectorAll('#panel-' + id + ' .custom-dd-item').forEach(el => {
            el.classList.toggle('selected', el.textContent === value);
        });
        clearFieldError(id);
        saveFormData();
    }

    // =====================================================
    // INIT DROPDOWNS
    // =====================================================
    function initDropdowns() {
        // Fakultas
        buildDropdownPanel('panel-fakultas', Object.keys(itsData), function(value) {
            setDropdownValue('fakultas', value, value);
            onFakultasChange(value);
        });
        // UKM
        buildDropdownPanel('panel-ukm', ukmOptions, function(value) {
            setDropdownValue('ukm', value, value);
        });
        // Departemen & Jurusan start empty
        buildDropdownPanel('panel-departemen', [], null);
        buildDropdownPanel('panel-jurusan', [], null);
    }

    function onFakultasChange(fakultas) {
        // Update departemen placeholder
        const dispDept = document.getElementById('disp-departemen');
        dispDept.innerHTML = `<span class="required-asterisk">*</span>&nbsp;Silahkan pilih departemen Anda`;
        dispDept.classList.remove('has-value');

        // Reset departemen value & jurusan
        document.getElementById('val-departemen').value = '';
        document.getElementById('val-jurusan').value = '';
        const dispJur = document.getElementById('disp-jurusan');
        dispJur.innerHTML = `<span class="required-asterisk">*</span>&nbsp;Menunggu masukan dari "Depart."`;
        dispJur.classList.remove('has-value');

        clearFieldError('departemen');
        clearFieldError('jurusan');

        const deptKeys = itsData[fakultas] ? Object.keys(itsData[fakultas]) : [];
        buildDropdownPanel('panel-departemen', deptKeys, function(value) {
            setDropdownValue('departemen', value, value);
            onDepartemenChange(fakultas, value);
        });
        buildDropdownPanel('panel-jurusan', [], null);
        updatePaktaFields();
    }

    function onDepartemenChange(fakultas, dept) {
        // Update jurusan placeholder
        const dispJur = document.getElementById('disp-jurusan');
        dispJur.innerHTML = `<span class="required-asterisk">*</span>&nbsp;Silahkan pilih prodi Anda`;
        dispJur.classList.remove('has-value');
        document.getElementById('val-jurusan').value = '';
        clearFieldError('jurusan');

        const prodis = (itsData[fakultas] && itsData[fakultas][dept]) ? itsData[fakultas][dept] : [];
        buildDropdownPanel('panel-jurusan', prodis, function(value) {
            setDropdownValue('jurusan', value, value);
            updatePaktaFields();
        });
        updatePaktaFields();
    }

    // =====================================================
    // TEXT INPUT LISTENERS
    // =====================================================
    document.getElementById('nrp').addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
        if (this.value) clearFieldError('nrp');
        saveFormData();
        updatePaktaFields();
    });

    document.getElementById('nama').addEventListener('input', function() {
        if (this.value) clearFieldError('nama');
        updatePaktaFields();
        saveFormData();
    });

    document.getElementById('email').addEventListener('input', function() {
        if (this.value) clearFieldError('email');
        saveFormData();
    });

    document.getElementById('telp').addEventListener('input', function() {
        if (this.value) clearFieldError('telp');
        saveFormData();
    });

    document.getElementById('alergi_desc').addEventListener('input', function() {
        this.classList.toggle('has-value', this.value !== '');
        if (this.value) clearFieldError('alergi-desc', 'iw-alergi-desc');
        saveFormData();
    });

    // =====================================================
    // VALIDATION
    // =====================================================
    function showFieldError(id, iwOverride) {
        const errEl = document.getElementById('err-' + id);
        const iwEl = document.getElementById(iwOverride || ('iw-' + id));
        if (errEl) errEl.classList.add('visible');
        if (iwEl) iwEl.classList.add('field-invalid');
    }

    function clearFieldError(id, iwOverride) {
        const errEl = document.getElementById('err-' + id);
        const iwEl = document.getElementById(iwOverride || ('iw-' + id));
        if (errEl) errEl.classList.remove('visible');
        if (iwEl) iwEl.classList.remove('field-invalid');
    }

    function clearAllErrors() {
        document.querySelectorAll('.field-error-msg.visible').forEach(el => el.classList.remove('visible'));
        document.querySelectorAll('.field-invalid').forEach(el => el.classList.remove('field-invalid'));
    }

    function validateStep(stepNum) {
        clearAllErrors();
        let valid = true;
        let firstInvalidEl = null;

        function mark(id, iwOverride) {
            showFieldError(id, iwOverride);
            if (!firstInvalidEl) firstInvalidEl = document.getElementById(iwOverride || ('iw-' + id));
            valid = false;
        }

        if (stepNum === 1) {
            if (!document.getElementById('nama').value.trim())          mark('nama');
            const emailVal = document.getElementById('email').value.trim();
            if (!emailVal || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailVal)) mark('email');
            if (document.getElementById('nrp').value.length !== 10)     mark('nrp');
            if (!document.getElementById('val-fakultas').value)         mark('fakultas');
            if (!document.getElementById('val-departemen').value)       mark('departemen');
            if (!document.getElementById('val-jurusan').value)          mark('jurusan');
            if (!document.getElementById('val-ukm').value)              mark('ukm');
            if (!document.getElementById('telp').value.trim())          mark('telp');
        }

        if (stepNum === 2) {
            const checked = document.querySelector('input[name="alergi"]:checked');
            if (!checked) {
                mark('alergi');
            } else if (checked.value === 'ya' && !document.getElementById('alergi_desc').value.trim()) {
                mark('alergi-desc', 'iw-alergi-desc');
            }
        }

        if (!valid && firstInvalidEl) {
            firstInvalidEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        return valid;
    }

    // =====================================================
    // STEP NAVIGATION
    // =====================================================
    function goToStep(targetStep) {
        if (targetStep > currentStep && !validateStep(currentStep)) return;
        clearAllErrors();
        closeAllDropdowns();
        document.querySelectorAll('.form-step').forEach(s => s.style.display = 'none');
        document.getElementById('step-' + targetStep).style.display = 'block';
        const badge = document.getElementById('step-badge-text');
        if (badge) badge.innerText = 'BAGIAN ' + targetStep + ' DARI 3';
        currentStep = targetStep;
        if (targetStep === 3) updatePaktaFields();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // =====================================================
    // ALERGI CONDITIONAL
    // =====================================================
    function toggleAlergiField(value) {
        const wrapper = document.getElementById('alergi-field-wrapper');
        const textarea = document.getElementById('alergi_desc');
        if (value === 'ya') {
            wrapper.style.display = 'block';
        } else {
            wrapper.style.display = 'none';
            textarea.value = '';
            textarea.classList.remove('has-value');
            clearFieldError('alergi-desc', 'iw-alergi-desc');
        }
        clearFieldError('alergi');
        saveFormData();
    }

    // =====================================================
    // PAKTA INTEGRITAS
    // =====================================================
    function togglePaktaText(checkbox) {
        const infoText = document.getElementById('pakta-info-text');
        if (checkbox.checked) {
            infoText.innerHTML = '<span style="color:#1a7a1a; font-weight:700; font-size:11px; line-height:1.5;">✓ Anda sudah mencentang pakta integritas. Ketika Anda submit form ini, maka perubahan ini tidak dapat dilakukan. Anda harus mematuhi ketentuan acara yang telah ditetapkan oleh LMB ITS sendiri!</span>';
        } else {
            infoText.innerHTML = '<span class="required-asterisk">*</span> Silahkan centang checker di bawah ini untuk menyetujui pakta ini!';
        }
    }

    function updatePaktaFields() {
        const nama = document.getElementById('nama').value || '{Nama Lengkap - Bold}';
        const nrp  = document.getElementById('nrp').value  || '{NRP - Bold}';
        const dept = document.getElementById('val-departemen').value || '{Departemen - Bold}';
        document.getElementById('pakta-nama').innerText = nama;
        document.getElementById('pakta-nrp').innerText  = nrp;
        document.getElementById('pakta-dept').innerText = dept;
        document.getElementById('pakta-nama-bawah').innerText = (nama !== '{Nama Lengkap - Bold}') ? nama : '{Nama Peserta}';
        document.getElementById('pakta-nrp-bawah').innerText  = (nrp  !== '{NRP - Bold}')         ? nrp  : '{Nrp Peserta}';
    }

    // =====================================================
    // LOCAL STORAGE PERSISTENCE
    // =====================================================
    const STORAGE_KEY = 'mbmt-form-v2';

    function saveFormData() {
        const data = {
            nama:         document.getElementById('nama').value,
            email:        document.getElementById('email').value,
            nrp:          document.getElementById('nrp').value,
            telp:         document.getElementById('telp').value,
            valFakultas:  document.getElementById('val-fakultas').value,
            valDepartemen:document.getElementById('val-departemen').value,
            valJurusan:   document.getElementById('val-jurusan').value,
            valUkm:       document.getElementById('val-ukm').value,
            alergi:       document.querySelector('input[name="alergi"]:checked')?.value || '',
            alergiDesc:   document.getElementById('alergi_desc').value,
        };
        try { localStorage.setItem(STORAGE_KEY, JSON.stringify(data)); } catch(e) {}
    }

    function loadFormData() {
        let data;
        try { data = JSON.parse(localStorage.getItem(STORAGE_KEY)); } catch(e) {}
        if (!data) return;

        // Text fields
        if (data.nama)  document.getElementById('nama').value  = data.nama;
        if (data.email) document.getElementById('email').value = data.email;
        if (data.nrp)   document.getElementById('nrp').value   = data.nrp;
        if (data.telp)  document.getElementById('telp').value  = data.telp;

        // Cascade: Fakultas → Departemen → Jurusan
        if (data.valFakultas) {
            setDropdownValue('fakultas', data.valFakultas, data.valFakultas);

            // Rebuild departemen panel with proper callbacks
            const deptKeys = itsData[data.valFakultas] ? Object.keys(itsData[data.valFakultas]) : [];
            buildDropdownPanel('panel-departemen', deptKeys, function(value) {
                setDropdownValue('departemen', value, value);
                onDepartemenChange(data.valFakultas, value);
            });

            // Update placeholder
            document.getElementById('disp-departemen').innerHTML = `<span class="required-asterisk">*</span>&nbsp;Silahkan pilih departemen Anda`;

            if (data.valDepartemen) {
                setDropdownValue('departemen', data.valDepartemen, data.valDepartemen);

                // Rebuild jurusan panel
                const prodis = (itsData[data.valFakultas] && itsData[data.valFakultas][data.valDepartemen])
                    ? itsData[data.valFakultas][data.valDepartemen] : [];
                buildDropdownPanel('panel-jurusan', prodis, function(value) {
                    setDropdownValue('jurusan', value, value);
                    updatePaktaFields();
                });
                document.getElementById('disp-jurusan').innerHTML = `<span class="required-asterisk">*</span>&nbsp;Silahkan pilih prodi Anda`;

                if (data.valJurusan) {
                    setDropdownValue('jurusan', data.valJurusan, data.valJurusan);
                }
            }
        }

        if (data.valUkm) setDropdownValue('ukm', data.valUkm, data.valUkm);

        // Radio alergi
        if (data.alergi) {
            const radio = document.querySelector(`input[name="alergi"][value="${data.alergi}"]`);
            if (radio) { radio.checked = true; toggleAlergiField(data.alergi); }
        }

        // Textarea
        if (data.alergiDesc) {
            const ta = document.getElementById('alergi_desc');
            ta.value = data.alergiDesc;
            ta.classList.add('has-value');
        }

        updatePaktaFields();
    }

    // =====================================================
    // FORM SUBMIT
    // =====================================================
    function buildSubmissionPayload() {
        const selectedAlergi = document.querySelector('input[name="alergi"]:checked')?.value || '';
        const hasAllergy = selectedAlergi === 'ya';

        return {
            name: document.getElementById('nama').value.trim(),
            email: document.getElementById('email').value.trim(),
            nrp: document.getElementById('nrp').value.trim(),
            faculty: document.getElementById('val-fakultas').value,
            department: document.getElementById('val-departemen').value,
            major: document.getElementById('val-jurusan').value,
            ukm: document.getElementById('val-ukm').value,
            phone: document.getElementById('telp').value.trim(),
            has_allergy: hasAllergy,
            allergy_description: hasAllergy ? document.getElementById('alergi_desc').value.trim() : null,
            integrity_agreed: document.getElementById('pakta-check').checked,
        };
    }

    function extractServerErrorMessage(responsePayload) {
        if (!responsePayload || typeof responsePayload !== 'object') {
            return 'Terjadi kesalahan saat mengirim data ke server.';
        }

        if (responsePayload.errors && typeof responsePayload.errors === 'object') {
            const firstKey = Object.keys(responsePayload.errors)[0];
            if (firstKey && Array.isArray(responsePayload.errors[firstKey]) && responsePayload.errors[firstKey][0]) {
                return responsePayload.errors[firstKey][0];
            }
        }

        if (typeof responsePayload.message === 'string' && responsePayload.message.length > 0) {
            return responsePayload.message;
        }

        return 'Terjadi kesalahan saat mengirim data ke server.';
    }

    async function handleSubmit(event) {
        event.preventDefault();

        // Double-check all required steps before final submission.
        if (!validateStep(1) || !validateStep(2)) {
            return;
        }

        const paktaCheck = document.getElementById('pakta-check');
        if (!paktaCheck.checked) {
            alert('Harap tandatangani Pakta Integritas terlebih dahulu dengan mencentang kotak tersebut.');
            return;
        }

        const submitButton = event.submitter || document.querySelector('#step-3 button[type="submit"]');
        const originalButtonHtml = submitButton ? submitButton.innerHTML : '';
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="btn-next-text">Mengirim...</span>';
        }

        try {
            const response = await fetch(registrationEndpoint, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(buildSubmissionPayload()),
            });

            let responsePayload = null;
            try {
                responsePayload = await response.json();
            } catch (jsonError) {
                responsePayload = null;
            }

            if (!response.ok) {
                alert(extractServerErrorMessage(responsePayload));
                return;
            }

            document.querySelectorAll('.form-step').forEach(s => s.style.display = 'none');
            document.getElementById('step-selesai').style.display = 'block';
            document.getElementById('step-badge-text').innerText = 'SELESAI';
            const formTitle = document.querySelector('.form-title');
            if (formTitle) formTitle.style.display = 'none';
            try { localStorage.removeItem(STORAGE_KEY); } catch(e) {}
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } catch (error) {
            alert('Koneksi ke server gagal. Silakan cek internet atau coba lagi beberapa saat.');
        } finally {
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonHtml;
            }
        }
    }

    // =====================================================
    // REALTIME DATE
    // =====================================================
    const BULAN_ID = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

    function formatTanggalID(date) {
        return `${date.getDate()} ${BULAN_ID[date.getMonth()]} ${date.getFullYear()}`;
    }

    function updateDate() {
        const el = document.getElementById('pakta-tanggal');
        if (el) el.textContent = formatTanggalID(new Date());
    }

    // =====================================================
    // INIT ON PAGE LOAD
    // =====================================================
    document.addEventListener('DOMContentLoaded', function() {
        initDropdowns();
        loadFormData();
        updatePaktaFields();
        updateDate();
        setInterval(updateDate, 60000);
    });
    </script>
</body>
</html>
