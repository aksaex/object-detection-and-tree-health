<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌿 TreeHealth AI - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
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
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--secondary);
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
        }
        
        /* Layout Container */
        .dashboard-container {
            display: grid;
            grid-template-columns: 280px 1fr;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            background: linear-gradient(180deg, var(--primary-dark) 0%, var(--primary) 100%);
            color: white;
            padding: 30px 20px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            height: 100vh;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 40px;
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        .logo-icon {
            font-size: 2rem;
        }
        
        .nav-title {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.7);
            margin: 25px 0 15px 0;
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 8px;
            color: white;
            text-decoration: none;
            margin-bottom: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .nav-item:hover, .nav-item.active {
            background-color: rgba(255, 255, 255, 0.15);
        }
        
        .nav-item i {
            width: 20px;
            text-align: center;
        }
        
        .team-section {
            margin-top: 40px;
            padding-top: 25px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .team-member {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
            font-size: 0.85rem;
        }
        
        .member-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        /* Main Content */
        .main-content {
            padding: 30px 40px;
            overflow-y: auto;
            max-height: 100vh;
        }
        
        /* Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }
        
        .page-title h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 8px;
        }
        
        .page-title p {
            color: var(--gray);
            font-size: 1rem;
        }
        
        .project-badge {
            background-color: var(--accent);
            color: var(--dark);
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .stat-card {
            background-color: var(--light);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-left: 4px solid var(--primary);
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            background-color: rgba(46, 139, 87, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            color: var(--primary);
            font-size: 1.5rem;
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: var(--gray);
            font-size: 0.95rem;
        }
        
        /* Feature Cards */
        .features-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 25px;
            color: var(--primary-dark);
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 50px;
        }
        
        .feature-card {
            background-color: var(--light);
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }
        
        .feature-card:hover {
            border-color: var(--primary);
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(46, 139, 87, 0.12);
        }
        
        .feature-icon {
            width: 70px;
            height: 70px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            color: white;
            font-size: 1.8rem;
        }
        
        .feature-card h3 {
            font-size: 1.3rem;
            margin-bottom: 12px;
            color: var(--primary-dark);
        }
        
        .feature-card p {
            color: var(--gray);
            font-size: 0.95rem;
            margin-bottom: 20px;
        }
        
        .feature-link {
            color: var(--primary);
            font-weight: 600;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        /* Tech Stack */
        .tech-stack {
            margin-top: 50px;
        }
        
        .tech-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--primary-dark);
        }
        
        .tech-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }
        
        .tech-tag {
            background-color: var(--gray-light);
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--dark);
        }
        
        .tech-tag.highlight {
            background-color: rgba(46, 139, 87, 0.15);
            color: var(--primary);
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }
            
            .sidebar {
                height: auto;
                position: relative;
                padding: 20px;
            }
            
            .main-content {
                padding: 25px;
            }
            
            .team-section {
                display: none;
            }
        }
        
        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <div class="logo-icon">🌿</div>
                <div>TreeHealth AI</div>
            </div>
            
            <div class="nav-title">Menu Utama</div>
            <a href="#" class="nav-item active">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="kesehatan.php" class="nav-item">
                <i class="fas fa-stethoscope"></i>
                <span>Cek Kesehatan Pohon</span>
            </a>
            <a href="deteksi.php" class="nav-item">
                <i class="fas fa-tree"></i>
                <span>Deteksi & Hitung Pohon</span>
            </a>
            
            <div class="team-section">
                <div class="nav-title">Tim Pengembang</div>
                <div class="team-member">
                    <div class="member-avatar">S</div>
                    <div>
                        <div>Safri Nur Saputra</div>
                        <div style="font-size:0.75rem; opacity:0.8">231011086</div>
                    </div>
                </div>
                <div class="team-member">
                    <div class="member-avatar">M</div>
                    <div>
                        <div>Muh. Aksa</div>
                        <div style="font-size:0.75rem; opacity:0.8">231011101</div>
                    </div>
                </div>
                <div class="team-member">
                    <div class="member-avatar">F</div>
                    <div>
                        <div>Sitti Fatima</div>
                        <div style="font-size:0.75rem; opacity:0.8">231011092</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="page-header">
                <div class="page-title">
                    <h1>Dashboard TreeHealth AI</h1>
                    <p>Sistem Monitoring Kesehatan Pohon Berbasis AI</p>
                </div>
                <div class="project-badge">
                    Proyek Akhir Visi Komputer
                </div>
            </div>
            
            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-brain"></i>
                    </div>
                    <div class="stat-value">MobileNetV2</div>
                    <div class="stat-label">Arsitektur Model</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-images"></i>
                    </div>
                    <div class="stat-value">3 Kelas</div>
                    <div class="stat-label">Klasifikasi Kesehatan</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <div class="stat-value">Roboflow</div>
                    <div class="stat-label">Sumber Dataset</div>
                </div>
            </div>
            
            <!-- Features -->
            <div class="features-title">Fitur Utama</div>
            <div class="features-grid">
                <a href="kesehatan.php" class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <h3>Cek Kesehatan Pohon</h3>
                    <p>Analisis kondisi kesehatan pohon secara instan dengan teknologi AI. Unggah gambar untuk mendapatkan diagnosis lengkap.</p>
                    <div class="feature-link">
                        <span>Mulai Analisis</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
                
                <a href="deteksi.php" class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3>Deteksi & Hitung Pohon</h3>
                    <p>Deteksi otomatis dan penghitungan pohon menggunakan model YOLO untuk inventarisasi lingkungan.</p>
                    <div class="feature-link">
                        <span>Mulai Deteksi</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Laporan & Analisis</h3>
                    <p>Hasil klasifikasi dan statistik kesehatan pohon dalam format yang mudah dipahami untuk pengambilan keputusan.</p>
                    <div class="feature-link">
                        <span>Lihat Contoh</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
            
            <!-- Tech Stack -->
            <div class="tech-stack">
                <div class="tech-title">Teknologi yang Digunakan</div>
                <div class="tech-tags">
                    <div class="tech-tag highlight">Convolutional Neural Network</div>
                    <div class="tech-tag highlight">MobileNetV2</div>
                    <div class="tech-tag">Transfer Learning</div>
                    <div class="tech-tag">Computer Vision</div>
                    <div class="tech-tag">Python</div>
                    <div class="tech-tag">YOLO</div>
                    <div class="tech-tag">Roboflow Dataset</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>