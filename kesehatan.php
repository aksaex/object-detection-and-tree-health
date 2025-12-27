<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>🌿 Cek Kesehatan - TreeHealth AI</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* --- TEMA HIJAU (KESEHATAN) --- */
        :root {
            --primary: #2E8B57;       /* SeaGreen */
            --primary-light: #3CAE73;
            --primary-dark: #1E5C3B;
            --secondary: #F5F9F6;
            --accent: #FFB74D;
            --dark: #1A2F1A;
            --light: #FFFFFF;
            --gray: #6B7280;
            --gray-light: #F3F4F6;
            --danger: #ef4444;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background-color: var(--secondary); color: var(--dark); min-height: 100vh; display: flex; flex-direction: column; }
        
        /* LAYOUT UTAMA */
        .dashboard-container { display: flex; min-height: 100vh; }
        
        /* SIDEBAR (Desktop) */
        .sidebar { 
            width: 280px;
            background: linear-gradient(180deg, var(--primary-dark) 0%, var(--primary) 100%); 
            color: white; padding: 30px 20px; 
            position: sticky; top: 0; height: 100vh; 
            display: flex; flex-direction: column;
            flex-shrink: 0;
        }

        /* HEADER MOBILE (HP) */
        .mobile-header {
            display: none; /* Hidden on Desktop */
            background: var(--primary);
            color: white;
            padding: 15px 20px;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky; top: 0; z-index: 100;
        }
        .mobile-brand { font-weight: 700; font-size: 1.2rem; display: flex; align-items: center; gap: 10px; }
        .mobile-nav-btn { color: white; text-decoration: none; font-size: 1.5rem; }

        /* LOGO & NAV ITEMS */
        .logo { display: flex; align-items: center; gap: 12px; margin-bottom: 40px; font-size: 1.5rem; font-weight: 700; }
        .logo-icon { font-size: 2rem; }
        .nav-title { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; color: rgba(255, 255, 255, 0.7); margin: 25px 0 15px 0; }
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 14px 16px; border-radius: 8px; color: white; text-decoration: none; margin-bottom: 8px; transition: all 0.3s ease; font-weight: 500; }
        .nav-item:hover, .nav-item.active { background-color: rgba(255, 255, 255, 0.2); border-left: 4px solid var(--accent); }
        .nav-item i { width: 20px; text-align: center; }

        /* KONTEN UTAMA */
        .main-content { 
            flex: 1; 
            padding: 30px 40px; 
            overflow-y: auto; 
            height: 100vh;
        }
        
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .page-title h1 { font-size: 2rem; font-weight: 700; color: var(--primary-dark); margin-bottom: 5px; }
        .page-title p { color: var(--gray); }

        /* WRAPPER ALAT SCAN */
        .scan-wrapper {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        }

        /* AREA VIDEO */
        .video-container {
            position: relative;
            background: black;
            border-radius: 16px;
            overflow: hidden;
            width: 100%;
            aspect-ratio: 4/3;
            display: flex; justify-content: center; align-items: center;
            box-shadow: inset 0 0 20px rgba(0,0,0,0.5);
        }
        video, img { 
            width: 100%; height: 100%; 
            object-fit: cover; 
            position: absolute; top: 0; left: 0; 
        }
        
        /* TOMBOL SWITCH (Floating) */
        .switch-btn {
            position: absolute; top: 15px; right: 15px;
            width: 45px; height: 45px;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 1.2rem; cursor: pointer;
            transition: 0.3s; z-index: 20;
            border: 1px solid rgba(255,255,255,0.3);
        }

        /* PANEL KONTROL */
        .control-panel { display: flex; flex-direction: column; gap: 20px; }

        /* HASIL DIAGNOSIS (Warna Dinamis) */
        .result-card {
            background: var(--secondary);
            border-radius: 16px; padding: 25px; text-align: center;
            border: 2px solid var(--gray-light); transition: 0.3s;
        }
        .result-card h2 { margin: 0; color: var(--dark); font-size: 1.5rem; font-weight: 700; }
        .result-card small { color: var(--gray); font-size: 0.9rem; }
        
        /* Status Colors */
        .result-card.success { background: #dcfce7; border-color: #22c55e; color: #14532d; }
        .result-card.warning { background: #fef9c3; border-color: #eab308; color: #713f12; }
        .result-card.danger { background: #fee2e2; border-color: #ef4444; color: #7f1d1d; }

        /* TABS */
        .tab-group { display: flex; background: var(--gray-light); padding: 5px; border-radius: 12px; }
        .tab-btn {
            flex: 1; border: none; padding: 12px; border-radius: 8px;
            font-weight: 600; cursor: pointer; background: transparent; color: var(--gray);
        }
        .tab-btn.active { background: white; color: var(--primary); box-shadow: 0 2px 5px rgba(0,0,0,0.05); }

        /* TOMBOL AKSI */
        .action-btn {
            width: 100%; padding: 16px; border: none; border-radius: 12px;
            font-size: 1rem; font-weight: 700; cursor: pointer; color: white;
            display: flex; align-items: center; justify-content: center; gap: 10px;
        }
        .btn-start { background: var(--primary); box-shadow: 0 4px 15px rgba(46, 139, 87, 0.3); }
        .btn-stop { background: var(--danger); }
        .btn-upload { background: var(--dark); }

        /* --- RESPONSIF ANDROID (max-width 768px) --- */
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .mobile-header { display: flex; }
            
            .dashboard-container { flex-direction: column; display: block; }
            .main-content { padding: 20px; height: auto; overflow: visible; }
            
            .page-header { flex-direction: column; align-items: flex-start; gap: 10px; margin-bottom: 20px; }
            .page-title h1 { font-size: 1.5rem; }
            
            .scan-wrapper { grid-template-columns: 1fr; gap: 20px; padding: 15px; }
            .video-container { aspect-ratio: 1 / 1; height: auto; }
            
            .control-panel { gap: 15px; }
            .action-btn { padding: 14px; font-size: 0.9rem; }
        }
    </style>
</head>
<body>

<div class="mobile-header">
    <div class="mobile-brand">
        <i class="fas fa-leaf"></i> TreeHealth AI
    </div>
    <a href="index.php" class="mobile-nav-btn">
        <i class="fas fa-home"></i>
    </a>
</div>

<div class="dashboard-container">
    
    <div class="sidebar">
        <div class="logo">
            <div class="logo-icon">🌿</div>
            <div>TreeHealth AI</div>
        </div>
        
        <div class="nav-title">Menu Utama</div>
        <a href="index.php" class="nav-item">
            <i class="fas fa-home"></i> <span>Dashboard</span>
        </a>
        <a href="#" class="nav-item active">
            <i class="fas fa-stethoscope"></i> <span>Cek Kesehatan Pohon</span>
        </a>
        <a href="deteksi.php" class="nav-item">
            <i class="fas fa-tree"></i> <span>Deteksi & Hitung Pohon</span>
        </a>

        <div style="margin-top: auto; padding-top: 50px; opacity: 0.6; font-size: 0.8rem;">
            &copy; kelompok hutan
        </div>
    </div>

    <div class="main-content">
        
        <div class="page-header">
            <div class="page-title">
                <h1>Cek Kesehatan Pohon</h1>
                <p>Analisis penyakit tanaman menggunakan MobileNetV2</p>
            </div>
            <div style="background: var(--accent); color: var(--dark); padding: 6px 12px; border-radius: 20px; font-weight: 600; font-size: 0.8rem;">
                Mode Klasifikasi
            </div>
        </div>

        <div class="scan-wrapper">
            
            <div class="video-container">
                <video id="video" autoplay playsinline muted></video>
                <img id="preview" style="display: none;" alt="Preview">
                <canvas id="canvas" style="display: none;"></canvas>
                
                <div class="switch-btn" onclick="switchCam()" title="Putar Kamera">
                    <i class="fas fa-sync-alt"></i>
                </div>
            </div>

            <div class="control-panel">
                
                <div class="result-card" id="status-box">
                    <h2 id="label">Siap Scan</h2>
                    <small id="acc">Akurasi AI: -</small>
                </div>

                <div class="tab-group">
                    <button class="tab-btn active" id="mode-cam" onclick="setMode('cam')">
                        <i class="fas fa-camera"></i> Live
                    </button>
                    <button class="tab-btn" id="mode-file" onclick="setMode('file')">
                        <i class="fas fa-image"></i> Upload
                    </button>
                </div>

                <div style="flex-grow: 1; min-height: 10px;"></div>

                <div id="cam-ctrl">
                    <button class="action-btn btn-start" id="btn-start" onclick="toggleCam()">
                        <i class="fas fa-play"></i> Mulai Kamera
                    </button>
                    <p style="text-align: center; margin-top: 10px; font-size: 0.75rem; color: var(--gray);">
                        *Scan tiap 2 detik
                    </p>
                </div>

                <div id="file-ctrl" style="display: none;">
                    <input type="file" id="fileInput" accept="image/*" hidden onchange="handleFile(this)">
                    <button class="action-btn btn-upload" onclick="document.getElementById('fileInput').click()">
                        <i class="fas fa-folder-open"></i> Pilih Galeri
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    let stream, interval;
    let useFront = false;
    const video = document.getElementById('video');
    const preview = document.getElementById('preview');
    const statusBox = document.getElementById('status-box');

    // --- SETUP MODE ---
    function setMode(type) {
        document.getElementById('mode-cam').className = type === 'cam' ? 'tab-btn active' : 'tab-btn';
        document.getElementById('mode-file').className = type === 'file' ? 'tab-btn active' : 'tab-btn';
        
        if (type === 'file') {
            stopCam();
            video.style.display = 'none';
            preview.style.display = 'block';
            document.getElementById('cam-ctrl').style.display = 'none';
            document.getElementById('file-ctrl').style.display = 'block';
            resetResult();
        } else {
            video.style.display = 'block';
            preview.style.display = 'none';
            document.getElementById('cam-ctrl').style.display = 'block';
            document.getElementById('file-ctrl').style.display = 'none';
            resetResult();
        }
    }

    function resetResult() {
        document.getElementById('label').innerText = "Siap Scan";
        document.getElementById('acc').innerText = "Akurasi AI: -";
        statusBox.className = "result-card"; 
    }

    // --- KAMERA ---
    async function startCam() {
        try {
            if(stream) stopCam();
            stream = await navigator.mediaDevices.getUserMedia({ 
                video: { facingMode: useFront ? 'user' : 'environment' } 
            });
            video.srcObject = stream;
            
            const btn = document.getElementById('btn-start');
            btn.innerHTML = '<i class="fas fa-stop"></i> Stop';
            btn.className = "action-btn btn-stop";
            btn.onclick = stopCam;

            interval = setInterval(() => sendToAI(), 2000);
        } catch(e) { 
            alert("Gagal akses kamera. Pastikan izin diberikan."); 
        }
    }

    function stopCam() {
        if(stream) stream.getTracks().forEach(t => t.stop());
        clearInterval(interval);
        video.srcObject = null;
        
        const btn = document.getElementById('btn-start');
        btn.innerHTML = '<i class="fas fa-play"></i> Mulai Kamera';
        btn.className = "action-btn btn-start";
        btn.onclick = startCam;
    }
    
    function toggleCam() { !stream ? startCam() : stopCam(); }
    function switchCam() { useFront = !useFront; if(stream) startCam(); }

    // --- KIRIM KE AI ---
    function sendToAI(file = null) {
        let formData = new FormData();
        formData.append('mode', 'klasifikasi'); // PENTING: Mode Klasifikasi

        if (file) {
            formData.append('gambar', file);
            document.getElementById('label').innerText = "Analisis...";
        } else {
            if (!stream) return;
            const cvs = document.getElementById('canvas');
            cvs.width = video.videoWidth; 
            cvs.height = video.videoHeight;
            cvs.getContext('2d').drawImage(video, 0, 0);
            formData.append('image_base64', cvs.toDataURL('image/jpeg', 0.6));
        }

        fetch('proses.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(d => {
                if(d.status === 'sukses') {
                    document.getElementById('label').innerText = d.label;
                    document.getElementById('acc').innerText = "Akurasi: " + d.akurasi + "%";
                    
                    // Logika Warna Status (Sesuai label AI Anda)
                    statusBox.className = "result-card"; 
                    let lbl = d.label.toLowerCase();
                    if(lbl.includes('sehat')) {
                        statusBox.classList.add('success');
                    } else if(lbl.includes('sakit') || lbl.includes('penyakit')) {
                        statusBox.classList.add('warning');
                    } else {
                        statusBox.classList.add('danger');
                    }
                }
            })
            .catch(err => console.error(err));
    }

    function handleFile(input) {
        if (input.files[0]) {
            let f = input.files[0];
            let r = new FileReader();
            r.onload = e => preview.src = e.target.result;
            r.readAsDataURL(f);
            sendToAI(f);
        }
    }
</script>

</body>
</html>