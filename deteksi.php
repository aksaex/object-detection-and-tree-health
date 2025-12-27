<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>🔍 Deteksi Pohon - TreeHealth AI</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* --- STYLE DASHBOARD (SAMA DENGAN INDEX) --- */
        :root {
            --primary: #2E8B57;
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
        
        /* SIDEBAR (Desktop Only) */
        .sidebar { 
            width: 280px;
            background: linear-gradient(180deg, var(--primary-dark) 0%, var(--primary) 100%); 
            color: white; padding: 30px 20px; 
            position: sticky; top: 0; height: 100vh; 
            display: flex; flex-direction: column;
            flex-shrink: 0;
        }
        
        /* MOBILE HEADER (Hanya Muncul di HP) */
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
            height: 100vh; /* Scroll di dalam area konten */
        }
        
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .page-title h1 { font-size: 2rem; font-weight: 700; color: var(--primary-dark); margin-bottom: 5px; }
        .page-title p { color: var(--gray); }

        /* WRAPPER ALAT SCAN */
        .scan-wrapper {
            display: grid;
            grid-template-columns: 2fr 1fr; /* Video Besar, Kontrol Kecil */
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
            /* Aspect Ratio Trick agar responsif */
            aspect-ratio: 4/3; 
            display: flex; justify-content: center; align-items: center;
            box-shadow: inset 0 0 20px rgba(0,0,0,0.5);
        }
        video { 
            width: 100%; height: 100%; 
            object-fit: cover; /* Cover agar full layar HP */
            position: absolute; top: 0; left: 0; 
        }
        
        #result-img {
            width: 100%; height: 100%; object-fit: contain;
            position: absolute; top: 0; left: 0; z-index: 10;
            display: none;
        }

        /* TOMBOL SWITCH KAMERA (Floating) */
        .switch-btn {
            position: absolute; top: 15px; right: 15px;
            width: 45px; height: 45px;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(5px);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 1.2rem; cursor: pointer;
            transition: 0.3s; z-index: 20;
            border: 1px solid rgba(255,255,255,0.3);
        }
        
        /* LOADER */
        .loader {
            position: absolute; top: 15px; left: 15px; z-index: 20;
            background: rgba(0,0,0,0.6); color: white;
            padding: 6px 12px; border-radius: 20px; font-size: 0.8rem;
            display: none; align-items: center; gap: 8px;
        }

        /* PANEL KONTROL */
        .control-panel { display: flex; flex-direction: column; gap: 20px; }

        .result-card {
            background: #eaf2f8; border: 2px solid #d6eaf8;
            border-radius: 16px; padding: 20px; text-align: center;
        }
        .result-card h2 { margin: 0; color: var(--primary-dark); font-size: 1.5rem; font-weight: 800; }
        
        .tab-group { display: flex; background: var(--gray-light); padding: 5px; border-radius: 12px; }
        .tab-btn {
            flex: 1; border: none; padding: 12px; border-radius: 8px;
            font-weight: 600; cursor: pointer; background: transparent; color: var(--gray);
        }
        .tab-btn.active { background: white; color: var(--primary); box-shadow: 0 2px 5px rgba(0,0,0,0.05); }

        .action-btn {
            width: 100%; padding: 16px; border: none; border-radius: 12px;
            font-size: 1rem; font-weight: 700; cursor: pointer; color: white;
            display: flex; align-items: center; justify-content: center; gap: 10px;
        }
        .btn-start { background: var(--primary); box-shadow: 0 4px 15px rgba(41, 128, 185, 0.3); }
        .btn-stop { background: var(--danger); }
        .btn-upload { background: var(--dark); }

        /* --- RESPONSIF KHUSUS ANDROID/HP (max-width 768px) --- */
        @media (max-width: 768px) {
            .sidebar { display: none; } /* Sembunyikan Sidebar Desktop */
            .mobile-header { display: flex; } /* Tampilkan Header Mobile */
            
            .dashboard-container { flex-direction: column; display: block; }
            .main-content { padding: 20px; height: auto; overflow: visible; }
            
            .page-header { 
                flex-direction: column; align-items: flex-start; gap: 10px; margin-bottom: 20px;
            }
            .page-title h1 { font-size: 1.5rem; }
            
            /* Tumpuk Video & Kontrol */
            .scan-wrapper { 
                grid-template-columns: 1fr; 
                gap: 20px; padding: 15px; 
            }
            
            /* Agar Video kotak di HP */
            .video-container { 
                aspect-ratio: 1 / 1; /* Kotak sempurna di HP */
                height: auto; 
            }
            
            .control-panel { gap: 15px; }
            .action-btn { padding: 14px; font-size: 0.9rem; }
        }
    </style>
</head>
<body>

<div class="mobile-header">
    <div class="mobile-brand">
        <i class="fas fa-tree"></i> TreeHealth AI
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
        <a href="kesehatan.php" class="nav-item">
            <i class="fas fa-stethoscope"></i> <span>Cek Kesehatan Pohon</span>
        </a>
        <a href="#" class="nav-item active">
            <i class="fas fa-tree"></i> <span>Deteksi & Hitung Pohon</span>
        </a>

        <div style="margin-top: auto; padding-top: 50px; opacity: 0.6; font-size: 0.8rem;">
            &copy; kelompok hutan
        </div>
    </div>

    <div class="main-content">
        
        <div class="page-header">
            <div class="page-title">
                <h1>Deteksi & Hitung</h1>
                <p>Penghitungan otomatis dengan YOLOv8</p>
            </div>
            <div style="background: var(--accent); color: var(--dark); padding: 6px 12px; border-radius: 20px; font-weight: 600; font-size: 0.8rem;">
                Mode YOLO
            </div>
        </div>

        <div class="scan-wrapper">
            
            <div class="video-container">
                <video id="video" autoplay playsinline muted></video>
                <img id="result-img" alt="Hasil Deteksi">
                <canvas id="canvas" style="display: none;"></canvas>

                <div id="loader" class="loader">
                    <i class="fas fa-spinner fa-spin"></i> Proses...
                </div>

                <div class="switch-btn" onclick="switchCam()" title="Putar Kamera">
                    <i class="fas fa-sync-alt"></i>
                </div>
            </div>

            <div class="control-panel">
                
                <div class="result-card">
                    <h2 id="label">Siap</h2>
                    <small id="acc">Jumlah: -</small>
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
                        <i class="fas fa-play"></i> Mulai Deteksi
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
    let isProcessing = false;
    let useFront = false; // Default Kamera Belakang
    const video = document.getElementById('video');
    const resImg = document.getElementById('result-img');
    const loader = document.getElementById('loader');

    function setMode(type) {
        document.getElementById('mode-cam').className = type === 'cam' ? 'tab-btn active' : 'tab-btn';
        document.getElementById('mode-file').className = type === 'file' ? 'tab-btn active' : 'tab-btn';
        
        if (type === 'file') {
            stopCam();
            video.style.display = 'none';
            resImg.style.display = 'block';
            resImg.src = ""; 
            document.getElementById('cam-ctrl').style.display = 'none';
            document.getElementById('file-ctrl').style.display = 'block';
            resetLabel();
        } else {
            video.style.display = 'block';
            resImg.style.display = 'none';
            document.getElementById('cam-ctrl').style.display = 'block';
            document.getElementById('file-ctrl').style.display = 'none';
            resetLabel();
        }
    }

    function resetLabel() {
        document.getElementById('label').innerText = "Siap";
        document.getElementById('acc').innerText = "Jumlah: -";
    }

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

            interval = setInterval(sendFrameToAI, 2000); 
        } catch(e) { 
            alert("Gagal akses kamera. Pastikan pakai HTTPS atau Localhost."); 
        }
    }

    function stopCam() {
        if(stream) stream.getTracks().forEach(t => t.stop());
        clearInterval(interval);
        video.srcObject = null;
        
        const btn = document.getElementById('btn-start');
        btn.innerHTML = '<i class="fas fa-play"></i> Mulai Deteksi';
        btn.className = "action-btn btn-start";
        btn.onclick = startCam;
        
        if(document.getElementById('mode-cam').classList.contains('active')){
            resImg.style.display = 'none';
        }
        isProcessing = false;
    }
    
    function toggleCam() { !stream ? startCam() : stopCam(); }
    function switchCam() { useFront = !useFront; if(stream) startCam(); }

    function sendFrameToAI() {
        if (!stream || isProcessing) return;
        isProcessing = true;
        loader.style.display = 'flex'; 

        const cvs = document.getElementById('canvas');
        cvs.width = video.videoWidth; 
        cvs.height = video.videoHeight;
        cvs.getContext('2d').drawImage(video, 0, 0);
        let base64 = cvs.toDataURL('image/jpeg', 0.6);

        let formData = new FormData();
        formData.append('mode', 'deteksi');
        formData.append('image_base64', base64);

        kirimRequest(formData);
    }

    function handleFile(input) {
        if (input.files[0]) {
            let f = input.files[0];
            let r = new FileReader();
            r.onload = e => { 
                resImg.src = e.target.result; 
                resImg.style.display = 'block'; 
            }
            r.readAsDataURL(f);

            let formData = new FormData();
            formData.append('mode', 'deteksi');
            formData.append('gambar', f);
            
            document.getElementById('label').innerText = "Upload...";
            loader.style.display = 'flex';
            kirimRequest(formData);
        }
    }

    function kirimRequest(formData) {
        fetch('proses.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(d => {
                if(d.status === 'sukses') {
                    document.getElementById('label').innerText = d.label;
                    document.getElementById('acc').innerText = "Akurasi: " + d.akurasi + "%";
                    if (d.image_path) {
                        resImg.src = d.image_path; 
                        resImg.style.display = 'block'; 
                    }
                } else {
                    document.getElementById('label').innerText = "Gagal";
                }
            })
            .catch(e => { console.error(e); })
            .finally(() => {
                isProcessing = false;
                loader.style.display = 'none';
            });
    }
</script>

</body>
</html>